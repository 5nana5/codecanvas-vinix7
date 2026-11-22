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
            'duration_minutes' => 'required|integer|min:1|max:60',
            'description' => 'nullable|string',
        ]);

        $data['level'] = 'Pemula';
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        $quiz = Quiz::create($data);

        return redirect()->route('admin.quizzes.questions', $quiz)->with('success', 'Paket kuis berhasil dibuat.');
    }

    public function questions(Quiz $quiz)
    {
        $quiz->load(['category', 'questions']);
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'code_snippet' => 'nullable|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string',
        ]);

        $data['question_type'] = 'multiple_choice';
        $quiz->questions()->create($data);

        return back()->with('success', 'Soal pilihan ganda berhasil ditambahkan.');
    }

    public function downloadTemplate(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['PANDUAN PENGISIAN:', 'Wajib diisi teks pertanyaan', 'Opsional (potongan kode)', 'Wajib diisi Opsi A', 'Wajib diisi Opsi B', 'Wajib diisi Opsi C', 'Wajib diisi Opsi D', 'Wajib diisi huruf: a, b, c, atau d', 'Opsional (pembahasan)']);
            fputcsv($handle, ['question_text', 'code_snippet', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'explanation']);
            fputcsv($handle, ['Apa tag HTML untuk membuat tautan (link)?', '<a href="#">Klik</a>', '<div>', '<a>', '<link>', '<span>', 'b', 'Tag <a> digunakan untuk hyperlink.']);
            fputcsv($handle, ['Tag HTML semantik untuk menu navigasi utama adalah?', '<header>...</header>', '<section>', '<nav>', '<aside>', '<footer>', 'b', 'Tag <nav> menandakan blok navigasi utama.']);
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
        $imported = 0;
        $errorRows = [];
        $rowNumber = 0;

        while (($row = fgetcsv($file)) !== false) {
            $rowNumber++;
            $firstCol = trim($row ?? '');

            if ($firstCol === '' || str_starts_with($firstCol, 'sep=') || $firstCol === 'PANDUAN PENGISIAN:' || strtolower($firstCol) === 'question_text') {
                continue;
            }

            $qText = trim($row ?? '');
            $snippet = trim($row ?? '');
            $optA = trim($row ?? '');
            $optB = trim($row ?? '');
            $optC = trim($row ?? '');
            $optD = trim($row ?? '');
            $answer = strtolower(trim($row ?? ''));
            $explanation = trim($row ?? '');

            $rowErrors = [];

            if ($qText === '') {
                $rowErrors[] = "Teks pertanyaan tidak boleh kosong";
            }
            if ($optA === '' || $optB === '' || $optC === '' || $optD === '') {
                $rowErrors[] = "Opsi A, B, C, dan D wajib diisi lengkap";
            }
            if (!in_array($answer, ['a', 'b', 'c', 'd'])) {
                $rowErrors[] = "Kunci jawaban harus berupa huruf a, b, c, atau d";
            }

            if (count($rowErrors) > 0) {
                $errorRows[] = [
                    'baris' => $rowNumber,
                    'alasan_ditolak' => implode('; ', $rowErrors),
                    'question_text' => $qText,
                    'code_snippet' => $snippet,
                    'option_a' => $optA,
                    'option_b' => $optB,
                    'option_c' => $optC,
                    'option_d' => $optD,
                    'correct_answer' => $answer,
                    'explanation' => $explanation,
                ];
                continue;
            }

            $quiz->questions()->create([
                'question_type' => 'multiple_choice',
                'question_text' => $qText,
                'code_snippet' => $snippet !== '' ? $snippet : null,
                'option_a' => $optA,
                'option_b' => $optB,
                'option_c' => $optC,
                'option_d' => $optD,
                'correct_answer' => $answer,
                'explanation' => $explanation !== '' ? $explanation : null,
            ]);
            $imported++;
        }
        fclose($file);

        if (count($errorRows) > 0) {
            session(['import_errors_' . $quiz->id => $errorRows]);
            return back()->with('import_summary', [
                'imported' => $imported,
                'failed' => count($errorRows),
            ]);
        }

        session()->forget('import_errors_' . $quiz->id);
        return back()->with('success', "{$imported} soal berhasil diunggah.");
    }

    public function downloadImportErrors(Quiz $quiz): StreamedResponse
    {
        $errors = session('import_errors_' . $quiz->id, []);

        return response()->streamDownload(function () use ($errors) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['baris_ke', 'alasan_ditolak', 'question_text', 'code_snippet', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'explanation']);
            foreach ($errors as $err) {
                fputcsv($handle, array_values($err));
            }
            fclose($handle);
        }, 'laporan-error-import-soal.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
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
