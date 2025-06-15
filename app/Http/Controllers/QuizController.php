<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function dashboard()
    {
        $quizzes = Auth::user()->quizzes()
            ->withCount('questions', 'participants')
            ->latest()
            ->get();
        
        return view('dashboard', compact('quizzes'));
    }

    public function selectMode()
    {
        return view('quiz.select-mode');
    }

    public function createQuiz(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:realtime,bebas',
            'title' => 'required|string|max:255',
        ]);

        $quiz = Quiz::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'mode' => $request->mode,
            'room_code' => $request->mode === 'realtime' ? $this->generateRoomCode() : null,
        ]);

        return redirect()->route('quiz.create-questions', $quiz);
    }

    public function createQuestions(Quiz $quiz)
    {
        return view('quiz.create-questions', compact('quiz'));
    }

    public function storeQuestions(Request $request, Quiz $quiz)
    {
        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.stage' => 'required|integer|min:1|max:3',
            'questions.*.type' => 'required|in:multiple_choice,short_answer,true_false',
            'questions.*.question' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.options' => 'nullable|array',
        ]);

        foreach ($request->questions as $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'stage' => $questionData['stage'],
                'type' => $questionData['type'],
                'question' => $questionData['question'],
                'options' => $questionData['options'] ?? null,
                'correct_answer' => $questionData['correct_answer'],
                'points' => 10,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Quiz berhasil dibuat!');
    }

    public function startRealtime(Quiz $quiz)
    {
        $quiz->update(['is_active' => true]);
        return redirect()->route('quiz.room-status', $quiz);
    }

    public function roomStatus(Quiz $quiz)
    {
        $participants = $quiz->participants()->latest()->get();
        return view('quiz.room-status', compact('quiz', 'participants'));
    }

    public function leaderboard(Quiz $quiz)
    {
        $leaderboard = $quiz->leaderboard()->get();
        return view('quiz.leaderboard', compact('quiz', 'leaderboard'));
    }

    private function generateRoomCode()
    {
        do {
            $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Quiz::where('room_code', $code)->exists());

        return $code;
    }
}