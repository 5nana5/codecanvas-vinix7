<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::updateOrCreate(
            ['slug' => 'business'],
            ['name' => 'Business', 'icon' => '💼', 'description' => 'Studi kasus analisis proses bisnis, manajemen proyek, dan strategi operasional.']
        );

        $quiz = Quiz::updateOrCreate(
            ['slug' => 'business-analyst-sprint'],
            [
                'category_id' => $cat->id,
                'title' => 'Business Analyst & Agile Sprint',
                'level' => 'Beginner',
                'duration_minutes' => 5,
                'description' => 'Evaluasi pemahaman MVP, ruang lingkup proyek, dan pengambilan keputusan bisnis.',
            ]
        );

        $questions = [
            [
                'question_text' => 'Apa tujuan utama merilis MVP (Minimum Viable Product) pada proyek berdurasi singkat?',
                'code_snippet' => null,
                'option_a' => 'Menunggu semua fitur lengkap sebelum diuji',
                'option_b' => 'Merilis fitur inti tercepat untuk memvalidasi solusi ke pengguna',
                'option_c' => 'Menghapus kebutuhan database',
                'option_d' => 'Membuat desain tanpa fungsi backend',
                'correct_answer' => 'b',
                'explanation' => 'MVP fokus pada fitur inti agar cepat diuji dan mendapat umpan balik pengguna.'
            ],
            [
                'question_text' => 'Klien meminta tambahan fitur besar saat proyek sudah berjalan 85%. Tindakan paling tepat adalah...',
                'code_snippet' => null,
                'option_a' => 'Langsung mengerjakan tanpa mengubah jadwal',
                'option_b' => 'Mengevaluasi dampak jadwal dan memasukkannya ke fase berikutnya',
                'option_c' => 'Menghapus fitur utama yang sudah jadi',
                'option_d' => 'Menghentikan komunikasi dengan klien',
                'correct_answer' => 'b',
                'explanation' => 'Pengendalian scope mencegah proyek gagal rilis tepat waktu.'
            ],
            [
                'question_text' => 'KPI utama untuk mengukur keberhasilan alur pengerjaan micro-quiz adalah...',
                'code_snippet' => null,
                'option_a' => 'Jumlah baris kode di GitHub',
                'option_b' => 'Quiz Completion Rate (persentase peserta yang menyelesaikan kuis)',
                'option_c' => 'Ukuran file logo',
                'option_d' => 'Jumlah warna pada tema',
                'correct_answer' => 'b',
                'explanation' => 'Completion rate membuktikan alur pengguna mudah dipahami.'
            ],
            [
                'question_text' => 'Dalam analisis SWOT, perkembangan teknologi AI yang mempercepat penyusunan materi termasuk...',
                'code_snippet' => null,
                'option_a' => 'Strengths',
                'option_b' => 'Weaknesses',
                'option_c' => 'Opportunities',
                'option_d' => 'Threats',
                'correct_answer' => 'c',
                'explanation' => 'Faktor eksternal positif yang dapat dimanfaatkan organisasi adalah Opportunities.'
            ],
            [
                'question_text' => 'Apa fungsi utama pembuatan User Persona sebelum merancang aplikasi?',
                'code_snippet' => null,
                'option_a' => 'Menentukan spesifikasi server',
                'option_b' => 'Memahami kebutuhan dan kendala spesifik target pengguna',
                'option_c' => 'Menggantikan pengujian aplikasi',
                'option_d' => 'Menghitung pajak perusahaan',
                'correct_answer' => 'b',
                'explanation' => 'User Persona menjaga fitur tetap relevan dengan target pengguna.'
            ],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(['quiz_id' => $quiz->id, 'question_text' => $q['question_text']], $q);
        }
    }
}
