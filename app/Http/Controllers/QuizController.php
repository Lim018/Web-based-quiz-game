<?php

namespace App\Http\Controllers;

use App\Models\QuizGame;
use App\Models\Participant;
use App\Models\Question;
use App\Models\ParticipantAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function index()
    {
        return view('quiz.index');
    }

    public function joinRoom(Request $request)
    {
        $request->validate([
            'room_code' => 'required|string|size:6',
            'name' => 'required|string|max:255'
        ]);

        $game = QuizGame::where('room_code', strtoupper($request->room_code))
                       ->where('status', 'waiting')
                       ->first();

        if (!$game) {
            return back()->withErrors(['room_code' => 'Room code tidak valid atau game sudah dimulai']);
        }

        // Check if participant already joined
        $existingParticipant = $game->participants()
                                  ->where('session_id', session()->getId())
                                  ->first();

        if ($existingParticipant) {
            return redirect()->route('quiz.play', ['game' => $game->id, 'participant' => $existingParticipant->id]);
        }

        $participant = Participant::create([
            'quiz_game_id' => $game->id,
            'name' => $request->name,
            'session_id' => session()->getId()
        ]);

        return redirect()->route('quiz.play', ['game' => $game->id, 'participant' => $participant->id]);
    }

    public function createFreeGame(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $game = QuizGame::create([
            'title' => 'Free Play Game',
            'room_code' => (new QuizGame())->generateRoomCode(),
            'mode' => 'free',
            'status' => 'active',
            'started_at' => now()
        ]);

        $participant = Participant::create([
            'quiz_game_id' => $game->id,
            'name' => $request->name,
            'session_id' => session()->getId()
        ]);

        return redirect()->route('quiz.play', ['game' => $game->id, 'participant' => $participant->id]);
    }

    public function play(QuizGame $game, Participant $participant)
    {
        // Verify participant belongs to this game and session
        if ($participant->quiz_game_id !== $game->id || $participant->session_id !== session()->getId()) {
            abort(403);
        }

        return view('quiz.play', compact('game', 'participant'));
    }

    public function getGameStatus(QuizGame $game): JsonResponse
    {
        return response()->json([
            'status' => $game->status,
            'current_stage' => $game->current_stage,
            'current_question' => $game->current_question,
            'participants_count' => $game->participants()->count(),
            'question' => $game->getCurrentQuestion()
        ]);
    }

    public function submitAnswer(Request $request, QuizGame $game, Participant $participant): JsonResponse
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $question = $game->getCurrentQuestion();
        
        if (!$question) {
            return response()->json(['error' => 'No current question'], 404);
        }

        // Check if already answered
        $existingAnswer = ParticipantAnswer::where('participant_id', $participant->id)
                                         ->where('question_id', $question->id)
                                         ->first();

        if ($existingAnswer) {
            return response()->json(['error' => 'Already answered'], 400);
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
            'total_score' => $participant->total_score,
            'correct_answer' => $question->correct_answer
        ]);
    }

    public function nextQuestion(QuizGame $game): JsonResponse
    {
        if ($game->current_question < 20) {
            $game->current_question++;
        } else if ($game->current_stage < 3) {
            $game->current_stage++;
            $game->current_question = 1;
        } else {
            $game->status = 'finished';
            $game->finished_at = now();
            
            // Mark all participants as finished
            $game->participants()->update(['is_finished' => true]);
        }

        $game->save();

        return response()->json([
            'status' => $game->status,
            'current_stage' => $game->current_stage,
            'current_question' => $game->current_question,
            'question' => $game->getCurrentQuestion()
        ]);
    }

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
            ];
        });

        return response()->json($leaderboard);
    }
}