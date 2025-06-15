<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\GameController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pilih-quiz', [HomeController::class, 'pilihQuiz'])->name('pilih-quiz');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Game routes (public)
Route::post('/join-realtime', [GameController::class, 'joinRealtime'])->name('game.join-realtime');
Route::post('/join-bebas/{quiz}', [GameController::class, 'joinBebas'])->name('game.join-bebas');
Route::get('/waiting-room/{quiz}', [GameController::class, 'waitingRoom'])->name('game.waiting-room');
Route::get('/play/{quiz}', [GameController::class, 'play'])->name('game.play');
Route::post('/submit-answer/{quiz}', [GameController::class, 'submitAnswer'])->name('game.submit-answer');
Route::get('/finish/{quiz}', [GameController::class, 'finish'])->name('game.finish');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [QuizController::class, 'dashboard'])->name('dashboard');
    Route::get('/select-mode', [QuizController::class, 'selectMode'])->name('quiz.select-mode');
    Route::post('/create-quiz', [QuizController::class, 'createQuiz'])->name('quiz.create');
    Route::get('/create-questions/{quiz}', [QuizController::class, 'createQuestions'])->name('quiz.create-questions');
    Route::post('/store-questions/{quiz}', [QuizController::class, 'storeQuestions'])->name('quiz.store-questions');
    Route::post('/start-realtime/{quiz}', [QuizController::class, 'startRealtime'])->name('quiz.start-realtime');
    Route::get('/room-status/{quiz}', [QuizController::class, 'roomStatus'])->name('quiz.room-status');
    Route::get('/leaderboard/{quiz}', [QuizController::class, 'leaderboard'])->name('quiz.leaderboard');
});