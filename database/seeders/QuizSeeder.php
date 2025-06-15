<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat satu Admin contoh jika belum ada
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@contoh.com'],
            [
                'name' => 'Admin Contoh',
                'password' => Hash::make('password'), // password default: password
            ]
        );

        // 2. Membuat satu Kuis contoh
        $quiz = Quiz::create([
            'title' => 'Kuis Pengetahuan Umum',
            'description' => 'Uji wawasanmu dengan berbagai pertanyaan menarik dari seluruh dunia.',
            'created_by' => $admin->id,
            'is_active' => true,
        ]);

        // 3. Menambahkan Pertanyaan untuk setiap tahap

        // ==================================================================
        // TAHAP 1: Pilihan Ganda (Multiple Choice Questions)
        // ==================================================================
        $mcq_questions = [
            [
                'question' => 'Apa ibu kota dari negara Australia?',
                'options' => json_encode(['Sydney', 'Melbourne', 'Canberra', 'Perth']),
                'correct_answer' => 'Canberra',
            ],
            [
                'question' => 'Siapakah penemu bola lampu?',
                'options' => json_encode(['Albert Einstein', 'Thomas Edison', 'Isaac Newton', 'Nikola Tesla']),
                'correct_answer' => 'Thomas Edison',
            ],
            [
                'question' => 'Planet mana yang dikenal sebagai "Planet Merah"?',
                'options' => json_encode(['Venus', 'Mars', 'Jupiter', 'Saturnus']),
                'correct_answer' => 'Mars',
            ],
        ];

        foreach ($mcq_questions as $index => $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'stage' => 1,
                'question_number' => $index + 1,
                'question' => $q['question'],
                'type' => 'mcq',
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'points' => 10,
            ]);
        }

        // ==================================================================
        // TAHAP 2: Isian Singkat (Short Answer)
        // ==================================================================
        $short_answer_questions = [
            [
                'question' => 'Bahan utama dalam pembuatan cokelat adalah biji dari pohon...',
                'correct_answer' => 'Kakao',
            ],
            [
                'question' => 'Samudra terbesar di dunia adalah samudra...',
                'correct_answer' => 'Pasifik',
            ],
            [
                'question' => 'Negara dengan julukan "Negeri Matahari Terbit" adalah...',
                'correct_answer' => 'Jepang',
            ],
        ];

        foreach ($short_answer_questions as $index => $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'stage' => 2,
                'question_number' => $index + 1,
                'question' => $q['question'],
                'type' => 'short_answer',
                'correct_answer' => $q['correct_answer'],
                'points' => 15,
            ]);
        }

        // ==================================================================
        // TAHAP 3: Benar atau Salah (True/False)
        // ==================================================================
        $true_false_questions = [
            [
                'question' => 'Benar atau Salah: Manusia memiliki 5 indra.',
                'correct_answer' => 'True',
            ],
            [
                'question' => 'Benar atau Salah: Air mendidih pada suhu 90 derajat Celsius di tekanan atmosfer standar.',
                'correct_answer' => 'False',
            ],
            [
                'question' => 'Benar atau Salah: Bunglon mengubah warna kulitnya untuk bersembunyi dari predator.',
                'correct_answer' => 'True',
            ],
        ];
        
        foreach ($true_false_questions as $index => $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'stage' => 3,
                'question_number' => $index + 1,
                'question' => $q['question'],
                'type' => 'true_false',
                'correct_answer' => $q['correct_answer'],
                'points' => 5,
            ]);
        }
    }
}