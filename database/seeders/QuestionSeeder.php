<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $mcqQuestions = [
            [
                'question' => 'Apa ibukota Indonesia?',
                'options' => ['Jakarta', 'Surabaya', 'Bandung', 'Medan'],
                'correct_answer' => 'Jakarta'
            ],
            [
                'question' => 'Siapa presiden pertama Indonesia?',
                'options' => ['Soekarno', 'Soeharto', 'Habibie', 'Megawati'],
                'correct_answer' => 'Soekarno'
            ],
            [
                'question' => 'Berapa hasil dari 15 + 25?',
                'options' => ['35', '40', '45', '50'],
                'correct_answer' => '40'
            ],
            [
                'question' => 'Planet terdekat dengan matahari adalah?',
                'options' => ['Venus', 'Mars', 'Merkurius', 'Bumi'],
                'correct_answer' => 'Merkurius'
            ],
            [
                'question' => 'Bahasa pemrograman yang dikembangkan oleh Google adalah?',
                'options' => ['Python', 'Java', 'Go', 'C++'],
                'correct_answer' => 'Go'
            ]
        ];

        // Add more MCQ questions to reach 20
        for ($i = 1; $i <= 20; $i++) {
            $questionData = $mcqQuestions[($i - 1) % count($mcqQuestions)];
            
            Question::create([
                'stage' => 1,
                'question_number' => $i,
                'question' => "MCQ {$i}: " . $questionData['question'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
                'points' => 10
            ]);
        }

        // Stage 2: Fill in the blank questions (20 questions)
        $fillQuestions = [
            [
                'question' => 'Ibu kota Jawa Barat adalah ___',
                'correct_answer' => 'Bandung'
            ],
            [
                'question' => 'Hasil dari 12 x 8 adalah ___',
                'correct_answer' => '96'
            ],
            [
                'question' => 'Benua terbesar di dunia adalah ___',
                'correct_answer' => 'Asia'
            ],
            [
                'question' => 'Penemu bola lampu adalah ___',
                'correct_answer' => 'Thomas Edison'
            ],
            [
                'question' => 'Bahasa pemrograman untuk web development adalah ___',
                'correct_answer' => 'JavaScript'
            ]
        ];

        for ($i = 1; $i <= 20; $i++) {
            $questionData = $fillQuestions[($i - 1) % count($fillQuestions)];
            
            Question::create([
                'stage' => 2,
                'question_number' => $i,
                'question' => "Fill {$i}: " . $questionData['question'],
                'options' => null,
                'correct_answer' => $questionData['correct_answer'],
                'points' => 15
            ]);
        }

        // Stage 3: True/False questions (20 questions)
        $trueFalseQuestions = [
            [
                'question' => 'Indonesia merdeka pada tahun 1945',
                'correct_answer' => 'Benar'
            ],
            [
                'question' => 'Matahari mengelilingi bumi',
                'correct_answer' => 'Salah'
            ],
            [
                'question' => 'PHP adalah bahasa pemrograman',
                'correct_answer' => 'Benar'
            ],
            [
                'question' => 'Jakarta adalah ibu kota Malaysia',
                'correct_answer' => 'Salah'
            ],
            [
                'question' => 'Laravel adalah framework PHP',
                'correct_answer' => 'Benar'
            ]
        ];

        for ($i = 1; $i <= 20; $i++) {
            $questionData = $trueFalseQuestions[($i - 1) % count($trueFalseQuestions)];
            
            Question::create([
                'stage' => 3,
                'question_number' => $i,
                'question' => "T/F {$i}: " . $questionData['question'],
                'options' => ['Benar', 'Salah'],
                'correct_answer' => $questionData['correct_answer'],
                'points' => 5
            ]);
        }
    }
}
