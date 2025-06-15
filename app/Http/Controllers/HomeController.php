<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function pilihQuiz()
    {
        $quizzes = Quiz::where('mode', 'bebas')
            ->with('user')
            ->withCount('questions')
            ->get();
        
        return view('pilih-quiz', compact('quizzes'));
    }
}