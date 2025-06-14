<?php

namespace App\Http\Controllers;

use App\Models\QuizGame;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $games = QuizGame::with('participants')->latest()->get();
        return view('admin.index', compact('games'));
    }

    public function createGame(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $game = QuizGame::create([
            'title' => $request->title,
            'description' => $request->description,
            'room_code' => (new QuizGame())->generateRoomCode(),
            'mode' => 'realtime'
        ]);

        return redirect()->route('admin.game.show', $game->id);
    }

    public function showGame(QuizGame $game)
    {
        $participants = $game->participants()->with('answers')->get();
        return view('admin.game', compact('game', 'participants'));
    }

    public function startGame(QuizGame $game)
    {
        $game->update([
            'status' => 'active',
            'started_at' => now()
        ]);

        return response()->json(['status' => 'started']);
    }

    public function manageQuestions()
    {
        $questions = Question::orderBy('stage')->orderBy('question_number')->get();
        return view('admin.questions', compact('questions'));
    }
}