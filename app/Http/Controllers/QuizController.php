<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizGame;
use App\Models\Participant;
use App\Models\Question;
use App\Models\ParticipantAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    /**
     * Show main quiz page with mode selection
     */
    public function index()
    {
        return view('quiz.index');
    }

    /**
     * Show available quizzes for free play mode
     */
    public function availableQuizzes()
    {
        $quizzes = Quiz::where('is_active', true)
                      ->with(['questions' => function($query) {
                          $query->selectRaw('quiz_id, stage, count(*) as question_count')
                                ->groupBy('quiz_id', 'stage');
                      }])
                      ->get();
        
        return view('quiz.available', compact('quizzes'));
    }

    /**
     * Join real-time game with room code
     */
    public function joinRealtime(Request $request)
    {
        $request->validate([
            'room_code' => 'required|string|size:6',
            'name' => 'required|string|max:255'
        ]);

        $game = QuizGame::where('room_code', strtoupper($request->room_code))
                       ->where('status', 'waiting')
                       ->first();

        if (!$game) {
            return back()->withErrors(['room_code' => 'Kode room tidak valid atau game sudah dimulai']);
        }

        // Check if participant already joined
        $existingParticipant = $game->participants()
                                  ->where('session_id', session()->getId())
                                  ->first();

        if ($existingParticipant) {
            return redirect()->route('quiz.play', [
                'game' => $game->id, 
                'participant' => $existingParticipant->id
            ]);
        }

        $participant = Participant::create([
            'quiz_game_id' => $game->id,
            'name' => $request->name,
            'session_id' => session()->getId()
        ]);

        return redirect()->route('quiz.play', [
            'game' => $game->id, 
            'participant' => $participant->id
        ]);
    }

    /**
     * Join free play mode - select from available quizzes
     */
    public function joinFree(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'name' => 'required|string|max:255'
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);

        // Cari atau buat satu sesi game "Free Play" yang persisten untuk kuis ini.
        $game = QuizGame::firstOrCreate(
            [
                'quiz_id' => $quiz->id,
                'mode' => 'free',
            ],
            [
                'title' => $quiz->title . ' - Free Play (Leaderboard)',
                'room_code' => $this->generateRoomCode(),
                'status' => 'active',
                'current_stage' => 1,
                'current_question' => 1,
                'started_at' => now(),
            ]
        );

        // Setiap kali bermain, catat sebagai partisipan baru untuk melacak setiap upaya.
        // Leaderboard nanti yang akan menyaring untuk skor tertinggi.
        $participant = Participant::create([
            'quiz_game_id' => $game->id,
            'name' => $request->name,
            'session_id' => session()->getId() . '_' . time() // Tambahkan timestamp untuk unique session per attempt
        ]);

        return redirect()->route('quiz.play', [
            'game' => $game->id, 
            'participant' => $participant->id
        ]);
    }

    /**
     * Play quiz game
     */
    public function play(QuizGame $game, Participant $participant)
    {
        // Verify participant belongs to this game
        if ($participant->quiz_game_id !== $game->id) {
            abort(403, 'Akses tidak diizinkan');
        }

        // For free mode, allow any participant to play
        // For realtime mode, check session
        if ($game->mode === 'realtime' && !str_starts_with($participant->session_id, session()->getId())) {
            abort(403, 'Akses tidak diizinkan');
        }

        return view('quiz.play', compact('game', 'participant'));
    }

    /**
     * Get current game status
     */
    public function getGameStatus(QuizGame $game): JsonResponse
    {
        $currentQuestion = $game->getCurrentQuestion();
        
        return response()->json([
            'status' => $game->status,
            'mode' => $game->mode,
            'current_stage' => $game->current_stage,
            'current_question' => $game->current_question,
            'participants_count' => $game->participants()->count(),
            'stage_info' => $this->getStageInfo($game->current_stage),
            'question' => $currentQuestion ? [
                'id' => $currentQuestion->id,
                'question' => $currentQuestion->question,
                'type' => $currentQuestion->type,
                'options' => $currentQuestion->options,
                'time_limit' => $currentQuestion->time_limit ?? 30,
                'points' => $currentQuestion->points
            ] : null
        ]);
    }

    /**
     * Get current question details for specific participant
     */
    public function getCurrentQuestion(QuizGame $game, Participant $participant): JsonResponse
    {
        // For free mode, get question based on participant's progress
        if ($game->mode === 'free') {
            $question = $this->getNextQuestionForParticipant($participant);
        } else {
            $question = $game->getCurrentQuestion();
        }
        
        if (!$question) {
            return response()->json(['error' => 'Tidak ada pertanyaan lagi', 'finished' => true], 404);
        }

        return response()->json([
            'status' => 'active', // Tambahkan status
            'stage_info' => $this->getStageInfo($question->stage), // Tambahkan info tahap
            'question' => $question // Masukkan pertanyaan ke dalam key 'question'
        ]);
        // return response()->json([
        //     'id' => $question->id,
        //     'question' => $question->question,
        //     'type' => $question->type,
        //     'options' => $question->type === 'mcq' ? $question->options : null,
        //     'stage' => $question->stage,
        //     'question_number' => $question->question_number,
        //     'time_limit' => $question->time_limit ?? 30,
        //     'points' => $question->points
        // ]);
    }

    /**
     * Get next unanswered question for participant in free mode
     */
    private function getNextQuestionForParticipant(Participant $participant)
    {
        $answeredQuestionIds = ParticipantAnswer::where('participant_id', $participant->id)
                                              ->pluck('question_id')
                                              ->toArray();

        return Question::where('quiz_id', $participant->quizGame->quiz_id)
                      ->whereNotIn('id', $answeredQuestionIds)
                      ->orderBy('stage')
                      ->orderBy('question_number')
                      ->first();
    }

    /**
     * Submit answer for current question
     */
    public function submitAnswer(Request $request, QuizGame $game, Participant $participant): JsonResponse
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        if ($game->mode === 'realtime' && $game->status !== 'active') {
            return response()->json(['error' => 'Game tidak aktif'], 400);
        }

        if ($game->mode === 'free') {
            $question = $this->getNextQuestionForParticipant($participant);
        } else {
            $question = $game->getCurrentQuestion();
        }
        
        if (!$question) {
            return response()->json(['error' => 'Tidak ada pertanyaan saat ini'], 404);
        }

        // Check if already answered
        $existingAnswer = ParticipantAnswer::where('participant_id', $participant->id)
                                         ->where('question_id', $question->id)
                                         ->first();

        if ($existingAnswer) {
            return response()->json(['error' => 'Sudah menjawab pertanyaan ini'], 400);
        }

        $isCorrect = $question->checkAnswer($request->answer);
        $pointsEarned = $isCorrect ? $question->points : 0;

        // Save answer
        ParticipantAnswer::create([
            'participant_id' => $participant->id,
            'question_id' => $question->id,
            'answer' => $request->answer,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'answered_at' => now()
        ]);

        // Update participant score
        $participant->updateScore($question->stage, $pointsEarned);

        // Check if this is the last question for free mode
        $nextQuestion = $this->getNextQuestionForParticipant($participant);
        $isLastQuestion = !$nextQuestion;

        return response()->json([
            'correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'total_score' => $participant->fresh()->total_score,
            'is_last_question' => $isLastQuestion,
            // Remove correct_answer and explanation to prevent cheating
        ]);
    }

    /**
     * Move to next question (Admin only for realtime, auto for free play)
     */
    public function nextQuestion(QuizGame $game, Participant $participant = null): JsonResponse
    {
        if ($game->mode === 'realtime') {
            if ($game->status !== 'active') {
                return response()->json(['error' => 'Game tidak aktif'], 400);
            }

            // Check if current stage has more questions
            $questionsInStage = $game->quiz->questions()
                                     ->where('stage', $game->current_stage)
                                     ->count();

            if ($game->current_question < $questionsInStage) {
                // Move to next question in current stage
                $game->current_question++;
            } else {
                // Move to next stage or finish game
                if ($game->current_stage < 3) {
                    $game->current_stage++;
                    $game->current_question = 1;
                } else {
                    // Finish game
                    $game->status = 'finished';
                    $game->finished_at = now();
                    
                    // Mark all participants as finished
                    $game->participants()->update(['is_finished' => true]);
                }
            }

            $game->save();

            return response()->json([
                'status' => $game->status,
                'current_stage' => $game->current_stage,
                'current_question' => $game->current_question,
                'stage_info' => $this->getStageInfo($game->current_stage),
                'question' => $game->status === 'active' ? $game->getCurrentQuestion() : null
            ]);
        } else {
            // Free mode - just return next question for participant
            $nextQuestion = $this->getNextQuestionForParticipant($participant);
            
            if (!$nextQuestion) {
                // Mark participant as finished
                $participant->update(['is_finished' => true]);
                
                return response()->json([
                    'finished' => true,
                    'status' => 'finished'
                ]);
            }

            return response()->json([
                'status' => 'active',
                'question' => [
                    'id' => $nextQuestion->id,
                    'question' => $nextQuestion->question,
                    'type' => $nextQuestion->type,
                    'options' => $nextQuestion->type === 'mcq' ? $nextQuestion->options : null,
                    'stage' => $nextQuestion->stage,
                    'question_number' => $nextQuestion->question_number,
                    'time_limit' => $nextQuestion->time_limit ?? 30,
                    'points' => $nextQuestion->points
                ],
                'stage_info' => $this->getStageInfo($nextQuestion->stage)
            ]);
        }
    }

    /**
     * Get leaderboard for current game
     */
    public function getLeaderboard(QuizGame $game)
    {
        if ($game->mode === 'free') {
            // For free play mode, group participants by name and take the highest score
            $leaderboard = $game->participants
                ->groupBy('name')
                ->map(function ($group) {
                    // Return the participant with the highest score for each name
                    return $group->sortByDesc('total_score')->first();
                })
                ->sortByDesc('total_score')
                ->values() // Reset keys for clean array indexing
                ->map(function ($participant, $index) {
                    return [
                        'rank' => $index + 1,
                        'name' => $participant->name,
                        'total_score' => $participant->total_score
                    ];
                });
        } else {
            // For real-time mode, show all participants as usual
            $participants = $game->participants()
                ->orderBy('total_score', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
                
            $leaderboard = $participants->map(function ($participant, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $participant->name,
                    'total_score' => $participant->total_score
                ];
            });
        }

        return response()->json([
            'leaderboard' => $leaderboard
        ]);
    }

    /**
     * Restart quiz for free mode
     */
    public function restartFreeMode(Request $request, QuizGame $game)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        if ($game->mode !== 'free') {
            return response()->json(['error' => 'Hanya bisa restart di mode bebas'], 400);
        }

        // Create new participant for new attempt
        $participant = Participant::create([
            'quiz_game_id' => $game->id,
            'name' => $request->name,
            'session_id' => session()->getId() . '_' . time()
        ]);

        return response()->json([
            'participant_id' => $participant->id,
            'redirect_url' => route('quiz.play', ['game' => $game->id, 'participant' => $participant->id])
        ]);
    }

    /**
     * Get stage information
     */
    private function getStageInfo($stage): array
    {
        $stageInfo = [
            1 => ['name' => 'Pilihan Ganda', 'type' => 'mcq', 'description' => 'Soal pilihan ganda'],
            2 => ['name' => 'Isian Singkat', 'type' => 'short_answer', 'description' => 'Soal isian singkat'],
            3 => ['name' => 'Benar/Salah', 'type' => 'true_false', 'description' => 'Soal benar atau salah']
        ];

        return $stageInfo[$stage] ?? ['name' => 'Unknown', 'type' => 'unknown'];
    }

    /**
     * Generate unique room code
     */
    private function generateRoomCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (QuizGame::where('room_code', $code)->exists());

        return $code;
    }
}