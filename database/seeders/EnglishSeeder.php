<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class EnglishSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::updateOrCreate(
            ['slug' => 'english'],
            ['name' => 'English', 'icon' => 'globe-alt', 'description' => 'Bahasa Inggris profesional untuk dokumentasi teknis, komunikasi tim, dan wawancara.']
        );

        $quiz = Quiz::updateOrCreate(
            ['slug' => 'english-for-tech-career'],
            [
                'category_id' => $cat->id,
                'title' => 'English for Tech & Career Readiness',
                'level' => 'Pemula',
                'duration_minutes' => 5,
                'description' => 'Asah pemahaman dokumentasi teknis berbahasa Inggris dan komunikasi profesional.',
            ]
        );

        $questions = [
            [
                'question_text' => 'Apa arti kalimat dokumentasi berikut: "This feature is deprecated and will be removed in the next release."?',
                'code_snippet' => null,
                'option_a' => 'Fitur ini baru saja dirilis',
                'option_b' => 'Fitur ini sudah usang/tidak disarankan dan akan dihapus pada rilis berikutnya',
                'option_c' => 'Fitur ini sedang diperbaiki keamanannya',
                'option_d' => 'Fitur ini khusus untuk admin',
                'correct_answer' => 'b',
                'explanation' => 'Deprecated berarti fitur lama yang tidak lagi direkomendasikan dan akan segera dihapus.'
            ],
            [
                'question_text' => 'Pilih kalimat paling tepat untuk melaporkan progres kerja kepada mentor:',
                'code_snippet' => null,
                'option_a' => 'I finish the database yesterday and now I am build the UI.',
                'option_b' => 'I finished the database schema yesterday, and today I am building the UI.',
                'option_c' => 'Yesterday I am finish database, today build UI.',
                'option_d' => 'The database done, UI later.',
                'correct_answer' => 'b',
                'explanation' => 'Gunakan Past Tense ("finished") untuk kemarin dan Present Continuous ("am building") untuk hari ini.'
            ],
            [
                'question_text' => 'Apa makna istilah "Scalability" dalam rekayasa perangkat lunak?',
                'code_snippet' => null,
                'option_a' => 'Kemampuan sistem menangani peningkatan beban pengguna/data dengan stabil',
                'option_b' => 'Fitur pengubah tema gelap dan terang',
                'option_c' => 'Penghapusan data lama otomatis',
                'option_d' => 'Ukuran resolusi layar monitor',
                'correct_answer' => 'a',
                'explanation' => 'Scalability adalah kemampuan sistem bertumbuh tanpa penurunan performa.'
            ],
            [
                'question_text' => 'Jawaban terbaik saat ditanya "How do you handle tight deadlines?" dalam wawancara kerja adalah...',
                'code_snippet' => null,
                'option_a' => 'I usually panic and skip testing.',
                'option_b' => 'I prioritize core features, break tasks into milestones, and communicate clearly.',
                'option_c' => 'I ask someone else to do my job.',
                'option_d' => 'I ignore the deadline.',
                'correct_answer' => 'b',
                'explanation' => 'Menunjukkan manajemen prioritas dan komunikasi profesional.'
            ],
            [
                'question_text' => 'Lengkapilah kalimat berikut: "The web application ________ deployed before Demo Day begins."',
                'code_snippet' => null,
                'option_a' => 'will be',
                'option_b' => 'were',
                'option_c' => 'have',
                'option_d' => 'being',
                'correct_answer' => 'a',
                'explanation' => 'Future Passive membutuhkan pola "will be + Verb 3".'
            ],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(['quiz_id' => $quiz->id, 'question_text' => $q['question_text']], $q);
        }
    }
}
