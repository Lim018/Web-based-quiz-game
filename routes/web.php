<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;

// Public Quiz Routes
Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/join-room', [QuizController::class, 'joinRoom'])->name('quiz.join-room');
Route::post('/create-free-game', [QuizController::class, 'createFreeGame'])->name('quiz.create-free-game');
Route::get('/game/{game}/participant/{participant}', [QuizController::class, 'play'])->name('quiz.play');

// API Routes for Quiz
Route::prefix('api')->group(function () {
    Route::get('/game/{game}/status', [QuizController::class, 'getGameStatus'])->name('api.game.status');
    Route::post('/game/{game}/participant/{participant}/answer', [QuizController::class, 'submitAnswer'])->name('api.submit.answer');
    Route::post('/game/{game}/next-question', [QuizController::class, 'nextQuestion'])->name('api.next.question');
    Route::get('/game/{game}/leaderboard', [QuizController::class, 'getLeaderboard'])->name('api.leaderboard');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/create-game', [AdminController::class, 'createGame'])->name('create.game');
    Route::get('/game/{game}', [AdminController::class, 'showGame'])->name('game.show');
    Route::post('/game/{game}/start', [AdminController::class, 'startGame'])->name('game.start');
    Route::get('/questions', [AdminController::class, 'manageQuestions'])->name('questions');
});