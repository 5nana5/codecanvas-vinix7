<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vinix7.id'],
            [
                'name' => 'Mentor VINIX7',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            TechSeeder::class,
            BusinessSeeder::class,
            MarketingSeeder::class,
            FinanceSeeder::class,
            EnglishSeeder::class,
        ]);

        $techQuiz = Quiz::where('slug', 'web-dev-code-snippet')->first();
        if ($techQuiz && QuizAttempt::count() === 0) {
            QuizAttempt::insert([
                ['quiz_id' => $techQuiz->id, 'participant_name' => 'Iman', 'university' => 'UGM', 'score' => 100, 'correct_count' => 5, 'total_questions' => 5, 'readiness_verdict' => 'Sangat Siap', 'created_at' => now(), 'updated_at' => now()],
                ['quiz_id' => $techQuiz->id, 'participant_name' => 'Farid', 'university' => 'ITTS', 'score' => 80, 'correct_count' => 4, 'total_questions' => 5, 'readiness_verdict' => 'Siap Masuk Industri', 'created_at' => now(), 'updated_at' => now()],
                ['quiz_id' => $techQuiz->id, 'participant_name' => 'Najla', 'university' => 'Universitas Kalbis', 'score' => 60, 'correct_count' => 3, 'total_questions' => 5, 'readiness_verdict' => 'Hampir Siap', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
