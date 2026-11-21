<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('quizzes')->get();
        $selectedCategory = $request->query('category');

        $quizzes = Quiz::with(['category', 'questions'])
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->whereHas('category', fn($q) => $q->where('slug', $selectedCategory));
            })
            ->latest()
            ->get();

        return view('welcome', compact('categories', 'quizzes', 'selectedCategory'));
    }

    public function show($slug)
    {
        $quiz = Quiz::with(['category', 'questions'])->where('slug', $slug)->firstOrFail();
        return view('quiz.play', compact('quiz'));
    }

    public function submit(Request $request, $slug)
    {
        $quiz = Quiz::with('questions')->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'participant_name' => 'required|string|max:100',
            'university' => 'nullable|string|max:100',
            'answers' => 'required|array',
        ]);

        $correctCount = 0;
        $totalQuestions = $quiz->questions->count();
        $review = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = trim((string) ($validated['answers'][$question->id] ?? ''));
            $correctAnswer = trim((string) $question->correct_answer);
            $isCorrect = false;

            if ($question->question_type === 'multiple_choice') {
                $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
            } elseif ($question->question_type === 'short_answer') {
                $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
            } elseif ($question->question_type === 'essay') {
                // Cocokkan berdasarkan kata kunci (dipisah koma di correct_answer) atau minimal 15 karakter jika tidak ada kata kunci spesifik
                $keywords = array_filter(array_map('trim', explode(',', strtolower($correctAnswer))));
                $lowerUser = strtolower($userAnswer);
                $matched = 0;
                foreach ($keywords as $kw) {
                    if (str_contains($lowerUser, $kw)) {
                        $matched++;
                    }
                }
                $isCorrect = count($keywords) > 0 ? ($matched >= 1) : (strlen($userAnswer) >= 15);
            }

            if ($isCorrect) {
                $correctCount++;
            }

            $review[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalQuestions > 0 ? (int) round(($correctCount / $totalQuestions) * 100) : 0;

        $verdict = match (true) {
            $score >= 81 => 'Sangat Siap',
            $score >= 61 => 'Siap Masuk Industri',
            $score >= 41 => 'Hampir Siap',
            default => 'Perlu Persiapan',
        };

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'participant_name' => $validated['participant_name'],
            'university' => $validated['university'] ?: 'Umum',
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'readiness_verdict' => $verdict,
        ]);

        return view('quiz.result', compact('quiz', 'attempt', 'review'));
    }
}
