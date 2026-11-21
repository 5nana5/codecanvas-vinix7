<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuizManageController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('category')->withCount('questions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.quizzes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:150',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_minutes' => 'required|integer|min:1|max:60',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        $quiz = Quiz::create($data);

        return redirect()->route('admin.quizzes.questions', $quiz)->with('success', 'Paket kuis berhasil dibuat!');
    }

    public function questions(Quiz $quiz)
    {
        $quiz->load(['category', 'questions']);
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'question_type' => 'required|in:multiple_choice,short_answer,essay',
            'question_text' => 'required|string',
            'code_snippet' => 'nullable|string',
            'option_a' => 'nullable|string',
            'option_b' => 'nullable|string',
            'option_c' => 'nullable|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        $quiz->questions()->create($data);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function downloadTemplate(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['question_type', 'question_text', 'code_snippet', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'explanation']);
            fputcsv($handle, ['multiple_choice', 'Apa tag HTML untuk membuat tautan (link)?', '<a href="#">Klik</a>', '<div>', '<a>', '<link>', '<span>', 'b', 'Tag <a> digunakan untuk hyperlink.']);
            fputcsv($handle, ['short_answer', 'Tuliskan output console dari kode berikut:', 'console.log(2 + "2");', '', '', '', '', '22', 'Operator + menggabungkan angka dan string menjadi 22.']);
            fputcsv($handle, ['essay', 'Jelaskan secara singkat fungsi MVC pada framework Laravel!', '', '', '', '', '', 'model, view, controller', 'MVC memisahkan logika data (Model), tampilan (View), dan pengatur alur (Controller).']);
            fclose($handle);
        }, 'template-import-soal-codecanvas.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function importCsv(Request $request, Quiz $quiz)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        $header = fgetcsv($file); // Lewati baris header
        $imported = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 8 || empty(trim($row[1] ?? ''))) {
                continue;
            }

            $type = in_array(trim($row[0]), ['multiple_choice', 'short_answer', 'essay']) ? trim($row[0]) : 'multiple_choice';

            $quiz->questions()->create([
                'question_type' => $type,
                'question_text' => trim($row[1]),
                'code_snippet' => !empty(trim($row[2] ?? '')) ? $row[2] : null,
                'option_a' => $row[3] ?? null,
                'option_b' => $row[4] ?? null,
                'option_c' => $row[5] ?? null,
                'option_d' => $row[6] ?? null,
                'correct_answer' => trim($row[7]),
                'explanation' => $row[8] ?? null,
            ]);
            $imported++;
        }
        fclose($file);

        return back()->with('success', "Berhasil mengimpor {$imported} soal dari file CSV!");
    }

    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Paket kuis berhasil dihapus.');
    }
}
