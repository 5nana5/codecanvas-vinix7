<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'quizzes' => Quiz::count(),
            'questions' => Question::count(),
            'attempts' => QuizAttempt::count(),
            'avg_score' => round(QuizAttempt::avg('score') ?? 0, 1),
        ];

        $recentAttempts = QuizAttempt::with('quiz.category')
            ->latest()
            ->take(20)
            ->get();

        return view('dashboard', compact('stats', 'recentAttempts'));
    }

    public function bulkDestroyAttempts(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Pilih setidaknya satu peserta terlebih dahulu.');
        }

        $deleted = QuizAttempt::whereIn('id', $ids)->delete();

        return back()->with('success', "Data hasil {$deleted} peserta berhasil dihapus.");
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'rekap-hasil-codecanvas-' . date('Y-m-d') . '.csv';
        $attempts = QuizAttempt::with('quiz.category')->latest()->get();

        return response()->streamDownload(function () use ($attempts) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['No', 'Nama Peserta', 'Asal Kampus / Instansi', 'Kategori', 'Topik Kuis', 'Benar', 'Total Soal', 'Skor', 'Status Kesiapan', 'Waktu Selesai']);

            foreach ($attempts as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row->participant_name,
                    $row->university,
                    $row->quiz->category->name ?? '-',
                    $row->quiz->title ?? '-',
                    $row->correct_count,
                    $row->total_questions,
                    $row->score,
                    $row->readiness_verdict,
                    $row->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
