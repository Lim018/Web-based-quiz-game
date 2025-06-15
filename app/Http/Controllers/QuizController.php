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

        // Create free play game session
        $game = QuizGame::create([
            'quiz_id' => $quiz->id,
            'title' => $quiz->title . ' - Free Play',
            'room_code' => $this->generateRoomCode(),
            'mode' => 'free',
            'status' => 'active',
            'current_stage' => 1,
            'current_question' => 1,
            'started_at' => now()
        ]);

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
     * Play quiz game
     */
    public function play(QuizGame $game, Participant $participant)
    {
        // Verify participant belongs to this game and session
        if ($participant->quiz_game_id !== $game->id || $participant->session_id !== session()->getId()) {
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
     * Get current question details
     */
    public function getCurrentQuestion(QuizGame $game): JsonResponse
    {
        $question = $game->getCurrentQuestion();
        
        if (!$question) {
            return response()->json(['error' => 'Tidak ada pertanyaan saat ini'], 404);
        }

        return response()->json([
            'id' => $question->id,
            'question' => $question->question,
            'type' => $question->type,
            'options' => $question->type === 'mcq' ? $question->options : null,
            'stage' => $question->stage,
            'question_number' => $question->question_number,
            'time_limit' => $question->time_limit ?? 30,
            'points' => $question->points
        ]);
    }

    /**
     * Submit answer for current question
     */
    public function submitAnswer(Request $request, QuizGame $game, Participant $participant): JsonResponse
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        if ($game->status !== 'active') {
            return response()->json(['error' => 'Game tidak aktif'], 400);
        }

        $question = $game->getCurrentQuestion();
        
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
        $participant->updateScore($game->current_stage, $pointsEarned);

        return response()->json([
            'correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'total_score' => $participant->fresh()->total_score,
            'correct_answer' => $question->correct_answer,
            'explanation' => $question->explanation
        ]);
    }

    /**
     * Move to next question (Admin only for realtime, auto for free play)
     */
    public function nextQuestion(QuizGame $game): JsonResponse
    {
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
    }

    /**
     * Get leaderboard for current game
     */
    public function getLeaderboard(QuizGame $game): JsonResponse
    {
        $leaderboard = $game->getLeaderboard()->map(function ($participant, $index) {
            return [
                'rank' => $index + 1,
                'name' => $participant->name,
                'total_score' => $participant->total_score,
                'stage_1_score' => $participant->stage_1_score,
                'stage_2_score' => $participant->stage_2_score,
                'stage_3_score' => $participant->stage_3_score,
                'is_finished' => $participant->is_finished
            ];
        });

        return response()->json([
            'leaderboard' => $leaderboard,
            'game_status' => $game->status,
            'total_participants' => $game->participants()->count()
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