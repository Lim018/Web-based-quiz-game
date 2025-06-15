<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Participant;
use App\Models\Answer;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function joinRealtime(Request $request)
    {
        $request->validate([
            'room_code' => 'required|string|size:6',
            'nickname' => 'required|string|max:255',
        ]);

        $quiz = Quiz::where('room_code', $request->room_code)
            ->where('mode', 'realtime')
            ->first();

        if (!$quiz) {
            return back()->withErrors(['room_code' => 'Kode room tidak ditemukan']);
        }

        $participant = Participant::create([
            'quiz_id' => $quiz->id,
            'nickname' => $request->nickname,
        ]);

        session(['participant_id' => $participant->id]);

        return redirect()->route('game.waiting-room', $quiz);
    }

    public function joinBebas(Request $request, Quiz $quiz)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
        ]);

        $participant = Participant::create([
            'quiz_id' => $quiz->id,
            'nickname' => $request->nickname,
        ]);

        session(['participant_id' => $participant->id]);

        return redirect()->route('game.play', $quiz);
    }

    public function waitingRoom(Quiz $quiz)
    {
        if (!$quiz->is_active) {
            return view('game.waiting-room', compact('quiz'));
        }

        return redirect()->route('game.play', $quiz);
    }

    public function play(Quiz $quiz)
    {
        $participantId = session('participant_id');
        if (!$participantId) {
            return redirect()->route('home');
        }

        $participant = Participant::find($participantId);
        $answeredQuestionIds = $participant->answers()->pluck('question_id')->toArray();
        
        $question = $quiz->questions()
            ->whereNotIn('id', $answeredQuestionIds)
            ->orderBy('stage')
            ->orderBy('id')
            ->first();

        if (!$question) {
            return redirect()->route('game.finish', $quiz);
        }

        return view('game.play', compact('quiz', 'question', 'participant'));
    }

    public function submitAnswer(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);

        $participantId = session('participant_id');
        $participant = Participant::find($participantId);
        $question = $quiz->questions()->find($request->question_id);

        $isCorrect = $this->checkAnswer($question, $request->answer);
        $pointsEarned = $isCorrect ? $question->points : 0;

        Answer::create([
            'participant_id' => $participant->id,
            'question_id' => $question->id,
            'answer' => $request->answer,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
        ]);

        $participant->increment('total_score', $pointsEarned);

        if ($quiz->mode === 'realtime') {
            return response()->json([
                'correct' => $isCorrect,
                'correct_answer' => $question->correct_answer,
                'points_earned' => $pointsEarned,
            ]);
        }

        return redirect()->route('game.play', $quiz);
    }

    public function finish(Quiz $quiz)
    {
        $participantId = session('participant_id');
        $participant = Participant::find($participantId);
        
        if ($participant && !$participant->finished_at) {
            $participant->update(['finished_at' => now()]);
        }

        $leaderboard = $quiz->leaderboard()->get();

        return view('game.finish', compact('quiz', 'participant', 'leaderboard'));
    }

    private function checkAnswer($question, $answer)
    {
        if ($question->type === 'true_false') {
            return strtolower($answer) === strtolower($question->correct_answer);
        }

        if ($question->type === 'short_answer') {
            return strtolower(trim($answer)) === strtolower(trim($question->correct_answer));
        }

        return $answer === $question->correct_answer;
    }
}