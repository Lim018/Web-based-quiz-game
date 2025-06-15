<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizGame;
use App\Models\Question;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    private function adminId()
    {
        return auth('admin')->id();
    }
    public function dashboard()
    {
        $adminId = $this->adminId();
        $totalQuizzes = Quiz::where('created_by', $adminId)->count();
        $activeGames = QuizGame::where('created_by', $adminId)->where('status', 'active')->count();
        $totalParticipants = Participant::whereHas('quizGame', function ($query) use ($adminId) {
            $query->where('created_by', $adminId);
        })->count();
        
        $recentGames = QuizGame::where('created_by', $adminId)
                              ->with(['quiz', 'participants'])
                              ->latest()
                              ->limit(5)
                              ->get();

        return view('admin.dashboard', compact('totalQuizzes', 'activeGames', 'totalParticipants', 'recentGames'));
    }

    /**
     * List all quizzes
     */
    public function listQuizzes()
    {
        $quizzes = Quiz::where('created_by', $this->adminId())
            ->withCount(['questions', 'games', 'games as active_games_count' => function($query) {
                $query->where('status', 'active');
            }])->latest()->get();

        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Show create quiz form
     */
    public function createQuizForm()
    {
        return view('admin.quizzes.create');
    }

    /**
     * Store new quiz
     */
    public function storeQuiz(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'time_per_question' => 30, // Default time, can be adjusted per question
            'created_by' => $this->adminId(), // Explicitly set admin ID
            'is_active' => true
        ]);

        return redirect()->route('admin.quiz.questions', $quiz->id)
                        ->with('success', 'Kuis berhasil dibuat! Sekarang tambahkan pertanyaan.');
    }

    private function authorizeAdminFor(Model $model)
    {
        $ownerId = null;
        if ($model instanceof Quiz) {
            $ownerId = $model->created_by;
        } elseif ($model instanceof QuizGame) {
            $ownerId = $model->created_by;
        } elseif ($model instanceof Question) {
            $ownerId = $model->quiz->created_by;
        }
        
        if ($ownerId !== $this->adminId()) {
            abort(403, 'AKSES DITOLAK');
        }
    }
    /**
     * Show edit quiz form
     */
    public function editQuiz(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update quiz
     */
    public function updateQuiz(Request $request, Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_per_question' => 'required|integer|min:10|max:300',
            'is_active' => 'boolean'
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'time_per_question' => $request->time_per_question,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.quizzes.index')
                        ->with('success', 'Kuis berhasil diperbarui!');
    }

    /**
     * Delete quiz
     */
    public function deleteQuiz(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        // Check if quiz has active games
        if ($quiz->games()->where('status', 'active')->exists()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus kuis yang sedang aktif dimainkan']);
        }

        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
                        ->with('success', 'Kuis berhasil dihapus!');
    }

    /**
     * Manage questions for a quiz
     */
    public function manageQuestions(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $questions = $quiz->questions()
                         ->orderBy('stage')
                         ->orderBy('question_number')
                         ->get()
                         ->groupBy('stage');

        $questionCounts = [
            1 => $quiz->questions()->where('stage', 1)->count(),
            2 => $quiz->questions()->where('stage', 2)->count(),
            3 => $quiz->questions()->where('stage', 3)->count()
        ];

        return view('admin.questions.manage', compact('quiz', 'questions', 'questionCounts'));
    }

    /**
     * Add new question
     */
    public function addQuestion(Request $request, Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $request->validate([
            'stage' => 'required|integer|min:1|max:3',
            'question' => 'required|string',
            'type' => 'required|in:mcq,short_answer,true_false',
            'correct_answer' => 'required|string',
            'options' => 'required_if:type,mcq|array|min:2',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1|max:100'
        ]);

        // Get next question number for this stage
        $questionNumber = $quiz->questions()
                             ->where('stage', $request->stage)
                             ->max('question_number') + 1;

        // Limit questions per stage to 20
        if ($questionNumber > 20) {
            return back()->withErrors(['error' => 'Maksimal 20 soal per tahap']);
        }

        Question::create([
            'quiz_id' => $quiz->id,
            'stage' => $request->stage,
            'question_number' => $questionNumber,
            'question' => $request->question,
            'type' => $request->type,
            'options' => $request->type === 'mcq' ? $request->options : null,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'points' => $request->points,
            'time_limit' => $quiz->time_per_question
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    /**
     * Update question
     */
    public function updateQuestion(Request $request, Question $question)
    {
        $this->authorizeAdminFor($question);
        $request->validate([
            'question' => 'required|string',
            'correct_answer' => 'required|string',
            'options' => 'required_if:type,mcq|array|min:2',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1|max:100'
        ]);

        $question->update([
            'question' => $request->question,
            'options' => $question->type === 'mcq' ? $request->options : null,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'points' => $request->points
        ]);

        return back()->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Delete question
     */
    public function deleteQuestion(Question $question)
    {
        $this->authorizeAdminFor($question);
        $quiz = $question->quiz;
        $stage = $question->stage;
        
        $question->delete();

        // Reorder question numbers
        $quiz->questions()
             ->where('stage', $stage)
             ->where('question_number', '>', $question->question_number)
             ->decrement('question_number');

        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    /**
     * Start realtime quiz session
     */
    public function startRealtimeSession(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        // Check if quiz has questions for all stages
        $stageCounts = $quiz->questions()->selectRaw('stage, count(*) as count')
                           ->groupBy('stage')
                           ->pluck('count', 'stage');

        if (!isset($stageCounts[1]) || !isset($stageCounts[2]) || !isset($stageCounts[3])) {
            return back()->withErrors(['error' => 'Kuis harus memiliki pertanyaan untuk semua tahap (1, 2, 3)']);
        }

        return view('admin.game.start', compact('quiz'));
    }

    /**
     * Create game session
     */
    public function createGameSession(Request $request, Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $request->validate([
            'session_title' => 'required|string|max:255'
        ]);

        $game = QuizGame::create([
            'quiz_id' => $quiz->id,
            'title' => $request->session_title,
            'room_code' => $this->generateRoomCode(),
            'mode' => 'realtime',
            'status' => 'waiting',
            'current_stage' => 1,
            'current_question' => 1,
            'created_by' => auth('admin')->id()
        ]);

        return redirect()->route('admin.game.show', $game->id);
    }

    /**
     * Show game session
     */
    public function showGameSession(QuizGame $game)
    {
        $this->authorizeAdminFor($game);
        $participants = $game->participants()
                           ->with(['answers' => function($query) {
                               $query->with('question');
                           }])
                           ->orderBy('total_score', 'desc')
                           ->get();

        return view('admin.game.show', compact('game', 'participants'));
    }

    /**
     * Start game
     */
    public function startGame(QuizGame $game): JsonResponse
    {
        $this->authorizeAdminFor($game);
        if ($game->status !== 'waiting') {
            return response()->json(['error' => 'Game sudah dimulai atau selesai'], 400);
        }

        $game->update([
            'status' => 'active',
            'started_at' => now()
        ]);

        return response()->json([
            'status' => 'started',
            'message' => 'Game berhasil dimulai!'
        ]);
    }

    /**
     * End game
     */
    public function endGame(QuizGame $game): JsonResponse
    {
        $this->authorizeAdminFor($game);
        if ($game->status !== 'active') {
            return response()->json(['error' => 'Game tidak sedang aktif'], 400);
        }

        $game->update([
            'status' => 'finished',
            'finished_at' => now()
        ]);

        // Mark all participants as finished
        $game->participants()->update(['is_finished' => true]);

        return response()->json([
            'status' => 'finished',
            'message' => 'Game berhasil diakhiri!'
        ]);
    }

    /**
     * View quiz results
     */
    public function viewResults(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $games = $quiz->games()
                     ->with(['participants' => function($query) {
                         $query->orderBy('total_score', 'desc');
                     }])
                     ->where('status', 'finished')
                     ->latest()
                     ->get();

        $totalPlayers = $quiz->games()
                           ->join('participants', 'quiz_games.id', '=', 'participants.quiz_game_id')
                           ->count();

        $averageScore = $quiz->games()
                           ->join('participants', 'quiz_games.id', '=', 'participants.quiz_game_id')
                           ->avg('participants.total_score');

        return view('admin.results.index', compact('quiz', 'games', 'totalPlayers', 'averageScore'));
    }

    /**
     * Game statistics
     */
    public function gameStatistics(QuizGame $game)
    {
        $this->authorizeAdminFor($game);
        $participants = $game->participants()
                           ->with(['answers.question'])
                           ->orderBy('total_score', 'desc')
                           ->get();

        $questionStats = $game->quiz->questions()
                              ->with(['participantAnswers' => function($query) use ($game) {
                                  $query->whereHas('participant', function($q) use ($game) {
                                      $q->where('quiz_game_id', $game->id);
                                  });
                              }])
                              ->get()
                              ->map(function($question) {
                                  $totalAnswers = $question->participantAnswers->count();
                                  $correctAnswers = $question->participantAnswers->where('is_correct', true)->count();
                                  
                                  return [
                                      'question' => $question->question,
                                      'stage' => $question->stage,
                                      'question_number' => $question->question_number,
                                      'total_answers' => $totalAnswers,
                                      'correct_answers' => $correctAnswers,
                                      'accuracy' => $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 2) : 0
                                  ];
                              });

        return view('admin.statistics.game', compact('game', 'participants', 'questionStats'));
    }

    /**
     * Share quiz (get shareable link)
     */
    public function shareQuiz(Quiz $quiz)
    {
        $this->authorizeAdminFor($quiz);
        $shareUrl = route('quiz.available') . '?quiz=' . $quiz->id;
        
        return view('admin.share.quiz', compact('quiz', 'shareUrl'));
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