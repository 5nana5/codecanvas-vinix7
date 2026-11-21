<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class TechSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::updateOrCreate(
            ['slug' => 'tech'],
            ['name' => 'Tech', 'icon' => '💻', 'description' => 'Eksplorasi pemahaman potongan kode (HTML, CSS, JS, SQL) & rekayasa web.']
        );

        $quiz = Quiz::updateOrCreate(
            ['slug' => 'web-dev-code-snippet'],
            [
                'category_id' => $cat->id,
                'title' => 'Web Dev & Code-Snippet Readiness',
                'level' => 'Beginner',
                'duration_minutes' => 5,
                'description' => 'Uji ketelitian membaca logika potongan kode web dasar.',
            ]
        );

        $questions = [
            [
                'question_text' => 'Apa output di console dari potongan kode JavaScript berikut?',
                'code_snippet' => "const scores = [70, 85, 90, 60];\nconst passed = scores.filter(s => s >= 80);\nconsole.log(passed.length);",
                'option_a' => '1',
                'option_b' => '2',
                'option_c' => '3',
                'option_d' => '4',
                'correct_answer' => 'b',
                'explanation' => 'Filter menyaring nilai >= 80 yaitu 85 dan 90, sehingga jumlahnya 2.'
            ],
            [
                'question_text' => 'Mengapa atribut aria-label pada potongan HTML berikut penting untuk standar aksesibilitas (WCAG)?',
                'code_snippet' => "<button type=\"button\" aria-label=\"Ubah ke Mode Terang\">\n  <svg aria-hidden=\"true\">...</svg>\n</button>",
                'option_a' => 'Mengubah warna tombol otomatis',
                'option_b' => 'Memberi keterangan teks bagi screen reader dan agentic browsing',
                'option_c' => 'Mempercepat koneksi database',
                'option_d' => 'Menghapus elemen SVG',
                'correct_answer' => 'b',
                'explanation' => 'Tombol ikon membutuhkan aria-label agar terbaca jelas oleh pembaca layar.'
            ],
            [
                'question_text' => 'Pada CSS Flexbox berikut, ke arah mana elemen anak akan disusun?',
                'code_snippet' => ".box {\n  display: flex;\n  flex-direction: column;\n  gap: 12px;\n}",
                'option_a' => 'Menyamping dari kiri ke kanan',
                'option_b' => 'Menumpuk vertikal dari atas ke bawah',
                'option_c' => 'Menyamping dari kanan ke kiri',
                'option_d' => 'Bertumpuk di tengah',
                'correct_answer' => 'b',
                'explanation' => 'flex-direction: column menyusun elemen secara vertikal.'
            ],
            [
                'question_text' => 'Apa fungsi query SQL berikut pada tabel hasil kuis?',
                'code_snippet' => "SELECT university, COUNT(*) as total\nFROM quiz_attempts\nGROUP BY university\nORDER BY total DESC;",
                'option_a' => 'Menghapus data kampus duplikat',
                'option_b' => 'Menghitung jumlah peserta per kampus dari terbanyak',
                'option_c' => 'Mengurutkan kampus sesuai abjad A-Z',
                'option_d' => 'Menghitung rata-rata nilai',
                'correct_answer' => 'b',
                'explanation' => 'GROUP BY mengelompokkan per kampus dan ORDER BY DESC mengurutkan dari tertinggi.'
            ],
            [
                'question_text' => 'Pada arsitektur MVC Laravel, di manakah logika pemrosesan jawaban kuis diletakkan?',
                'code_snippet' => "Route::post('/quiz/{slug}', [QuizController::class, 'submit']);",
                'option_a' => 'File Blade (.blade.php)',
                'option_b' => 'Controller (QuizController)',
                'option_c' => 'File konfigurasi (.env)',
                'option_d' => 'Folder public/css',
                'correct_answer' => 'b',
                'explanation' => 'Controller menangani validasi request dan logika bisnis dalam pola MVC.'
            ],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(['quiz_id' => $quiz->id, 'question_text' => $q['question_text']], $q);
        }
    }
}
