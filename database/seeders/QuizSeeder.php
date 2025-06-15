<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create a Test User
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create a Realtime Quiz
        $realtimeQuiz = Quiz::create([
            'user_id' => $user->id,
            'title' => 'Kuis Sejarah Indonesia (Realtime)',
            'mode' => 'realtime',
            'room_code' => '123456', // Static room code for easy testing
            'is_active' => false,
        ]);

        // Questions for Realtime Quiz
        Question::create([
            'quiz_id' => $realtimeQuiz->id,
            'stage' => 1,
            'type' => 'multiple_choice',
            'question' => 'Siapakah presiden pertama Indonesia?',
            'options' => ['A' => 'Soekarno', 'B' => 'Soeharto', 'C' => 'B.J. Habibie', 'D' => 'Joko Widodo'],
            'correct_answer' => 'A',
            'points' => 10,
        ]);

        Question::create([
            'quiz_id' => $realtimeQuiz->id,
            'stage' => 2,
            'type' => 'short_answer',
            'question' => 'Ibu kota Indonesia adalah...',
            'correct_answer' => 'Jakarta',
            'points' => 10,
        ]);

        Question::create([
            'quiz_id' => $realtimeQuiz->id,
            'stage' => 3,
            'type' => 'true_false',
            'question' => 'Monas terletak di Surabaya.',
            'correct_answer' => 'false',
            'points' => 10,
        ]);


        // 3. Create a "Bebas" Mode Quiz
        $bebasQuiz = Quiz::create([
            'user_id' => $user->id,
            'title' => 'Kuis Pengetahuan Umum (Bebas)',
            'mode' => 'bebas',
            'room_code' => null,
            'is_active' => true, // Bebas mode is always active
        ]);

        // Questions for "Bebas" Quiz
        Question::create([
            'quiz_id' => $bebasQuiz->id,
            'stage' => 1,
            'type' => 'multiple_choice',
            'question' => 'Planet terdekat dari Matahari adalah?',
            'options' => ['A' => 'Venus', 'B' => 'Mars', 'C' => 'Merkurius', 'D' => 'Bumi'],
            'correct_answer' => 'C',
            'points' => 10,
        ]);
        
        Question::create([
            'quiz_id' => $bebasQuiz->id,
            'stage' => 1,
            'type' => 'multiple_choice',
            'question' => 'Formula kimia untuk air adalah?',
            'options' => ['A' => 'O2', 'B' => 'H2O', 'C' => 'CO2', 'D' => 'NaCl'],
            'correct_answer' => 'B',
            'points' => 10,
        ]);

        Question::create([
            'quiz_id' => $bebasQuiz->id,
            'stage' => 2,
            'type' => 'short_answer',
            'question' => 'Negara dengan menara Eiffel adalah...',
            'correct_answer' => 'Prancis',
            'points' => 10,
        ]);

        Question::create([
            'quiz_id' => $bebasQuiz->id,
            'stage' => 3,
            'type' => 'true_false',
            'question' => 'Matahari terbit dari barat.',
            'correct_answer' => 'false',
            'points' => 10,
        ]);
    }
}
