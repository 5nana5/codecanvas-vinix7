<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class MarketingSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::updateOrCreate(
            ['slug' => 'marketing'],
            ['name' => 'Marketing', 'icon' => '📣', 'description' => 'Strategi digital marketing, metrik kampanye, dan optimasi konversi.']
        );

        $quiz = Quiz::updateOrCreate(
            ['slug' => 'digital-marketing-funnel'],
            [
                'category_id' => $cat->id,
                'title' => 'Digital Marketing & Growth Funnel',
                'level' => 'Beginner',
                'duration_minutes' => 5,
                'description' => 'Uji kemampuan menghitung metrik iklan digital dan strategi akuisisi peserta.',
            ]
        );

        $questions = [
            [
                'question_text' => 'Sebuah kampanye memperoleh 10.000 tayangan dan 500 klik. Berapa CTR-nya?',
                'code_snippet' => "CTR = (Total Klik / Total Tayangan) x 100%",
                'option_a' => '0,5%',
                'option_b' => '5%',
                'option_c' => '20%',
                'option_d' => '50%',
                'correct_answer' => 'b',
                'explanation' => '(500 / 10.000) x 100% = 5%.'
            ],
            [
                'question_text' => 'Pengunjung masuk ke landing page lalu langsung keluar tanpa mengklik apa pun. Metrik apa yang tinggi?',
                'code_snippet' => null,
                'option_a' => 'Conversion Rate',
                'option_b' => 'Bounce Rate',
                'option_c' => 'Retention Rate',
                'option_d' => 'Lifetime Value',
                'correct_answer' => 'b',
                'explanation' => 'Bounce rate mengukur persentase pengunjung yang langsung meninggalkan halaman tanpa interaksi.'
            ],
            [
                'question_text' => 'Strategi lead magnet paling efektif menarik mahasiswa mencoba platform edukasi adalah...',
                'code_snippet' => null,
                'option_a' => 'Meminta pembayaran di halaman pertama',
                'option_b' => 'Menyediakan micro-quiz gratis 3 menit dengan hasil skor instan',
                'option_c' => 'Menampilkan dokumen kontrak panjang',
                'option_d' => 'Mewajibkan verifikasi KTP sebelum melihat halaman',
                'correct_answer' => 'b',
                'explanation' => 'Kuis interaktif gratis memberi nilai langsung dan menurunkan hambatan pengguna baru.'
            ],
            [
                'question_text' => 'Tujuan utama melakukan A/B Testing pada tombol Call-To-Action (CTA) adalah...',
                'code_snippet' => null,
                'option_a' => 'Memperlambat loading web',
                'option_b' => 'Membandingkan dua variasi tombol untuk melihat klik tertinggi',
                'option_c' => 'Menghapus data pengguna lama',
                'option_d' => 'Mengubah struktur server',
                'correct_answer' => 'b',
                'explanation' => 'A/B Testing memvalidasi desain mana yang paling efektif berdasarkan data.'
            ],
            [
                'question_text' => 'Mengapa struktur heading HTML (H1, H2) dan kecepatan LCP berpengaruh pada SEO?',
                'code_snippet' => null,
                'option_a' => 'Membantu mesin pencari memahami topik dan memberi peringkat lebih baik',
                'option_b' => 'Membuat huruf otomatis berwarna merah',
                'option_c' => 'Menonaktifkan fitur dark mode',
                'option_d' => 'Menggantikan fungsi domain',
                'correct_answer' => 'a',
                'explanation' => 'Struktur semantik dan performa Core Web Vitals yang baik meningkatkan skor SEO.'
            ],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(['quiz_id' => $quiz->id, 'question_text' => $q['question_text']], $q);
        }
    }
}
