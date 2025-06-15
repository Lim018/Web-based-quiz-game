<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminRegisterController;

// Public Quiz Routes
Route::get('/', [QuizController::class, 'index'])->name('quiz.index');

// Participant Routes
Route::post('/join-realtime', [QuizController::class, 'joinRealtime'])->name('quiz.join-realtime');
Route::post('/join-free', [QuizController::class, 'joinFree'])->name('quiz.join-free');
Route::get('/game/{game}/participant/{participant}', [QuizController::class, 'play'])->name('quiz.play');
Route::get('/available-quizzes', [QuizController::class, 'availableQuizzes'])->name('quiz.available');

// API Routes for Quiz Gameplay
Route::prefix('api')->group(function () {
    Route::get('/game/{game}/status', [QuizController::class, 'getGameStatus'])->name('api.game.status');
    Route::post('/game/{game}/participant/{participant}/answer', [QuizController::class, 'submitAnswer'])->name('api.submit.answer');
    Route::post('/game/{game}/next-question', [QuizController::class, 'nextQuestion'])->name('api.next.question');
    Route::get('/game/{game}/leaderboard', [QuizController::class, 'getLeaderboard'])->name('api.leaderboard');
    Route::get('/game/{game}/current-question', [QuizController::class, 'getCurrentQuestion'])->name('api.current.question');
});

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Registration
Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.post');

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Quiz Management
    Route::get('/quizzes', [AdminController::class, 'listQuizzes'])->name('quizzes.index');
    Route::get('/quiz/create', [AdminController::class, 'createQuizForm'])->name('quiz.create');
    Route::post('/quiz/create', [AdminController::class, 'storeQuiz'])->name('quiz.store');
    Route::get('/quiz/{quiz}/edit', [AdminController::class, 'editQuiz'])->name('quiz.edit');
    Route::put('/quiz/{quiz}', [AdminController::class, 'updateQuiz'])->name('quiz.update');
    Route::delete('/quiz/{quiz}', [AdminController::class, 'deleteQuiz'])->name('quiz.delete');
    
    // Game Session Management
    Route::get('/quiz/{quiz}/play', [AdminController::class, 'startRealtimeSession'])->name('quiz.play');
    Route::post('/quiz/{quiz}/start-session', [AdminController::class, 'createGameSession'])->name('quiz.create-session');
    Route::get('/game/{game}', [AdminController::class, 'showGameSession'])->name('game.show');
    Route::post('/game/{game}/start', [AdminController::class, 'startGame'])->name('game.start');
    Route::post('/game/{game}/end', [AdminController::class, 'endGame'])->name('game.end');
    
    // Question Management
    Route::get('/quiz/{quiz}/questions', [AdminController::class, 'manageQuestions'])->name('quiz.questions');
    Route::post('/quiz/{quiz}/questions', [AdminController::class, 'addQuestion'])->name('quiz.questions.add');
    Route::put('/question/{question}', [AdminController::class, 'updateQuestion'])->name('question.update');
    Route::delete('/question/{question}', [AdminController::class, 'deleteQuestion'])->name('question.delete');
    
    // Results and Statistics
    Route::get('/quiz/{quiz}/results', [AdminController::class, 'viewResults'])->name('quiz.results');
    Route::get('/game/{game}/statistics', [AdminController::class, 'gameStatistics'])->name('game.statistics');
    
    // Share Quiz
    Route::get('/quiz/{quiz}/share', [AdminController::class, 'shareQuiz'])->name('quiz.share');
});