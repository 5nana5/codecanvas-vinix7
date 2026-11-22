<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::updateOrCreate(
            ['slug' => 'finance'],
            ['name' => 'Finance', 'icon' => 'chart-bar', 'description' => 'Dasar analisis keuangan, unit economics startup, dan pengelolaan anggaran.']
        );

        $quiz = Quiz::updateOrCreate(
            ['slug' => 'startup-finance-basics'],
            [
                'category_id' => $cat->id,
                'title' => 'Startup Finance & Unit Economics',
                'level' => 'Pemula',
                'duration_minutes' => 5,
                'description' => 'Pahami kesehatan finansial produk digital dan analisis rasio dasar.',
            ]
        );

        $questions = [
            [
                'question_text' => 'Biaya iklan Rp2.000.000 mendatangkan 100 peserta baru. Berapa CAC per peserta?',
                'code_snippet' => "CAC = Total Biaya Akuisisi / Jumlah Pelanggan Baru",
                'option_a' => 'Rp2.000',
                'option_b' => 'Rp20.000',
                'option_c' => 'Rp200.000',
                'option_d' => 'Rp50.000',
                'correct_answer' => 'b',
                'explanation' => 'Rp2.000.000 / 100 = Rp20.000 per peserta.'
            ],
            [
                'question_text' => 'Unit economics bisnis dikatakan sehat secara jangka panjang apabila...',
                'code_snippet' => null,
                'option_a' => 'CAC lebih besar dari LTV',
                'option_b' => 'LTV (Lifetime Value) lebih besar dari CAC',
                'option_c' => 'Biaya selalu melebihi pendapatan',
                'option_d' => 'Tidak ada pencatatan arus kas',
                'correct_answer' => 'b',
                'explanation' => 'Pendapatan sepanjang masa dari pelanggan (LTV) harus melampaui biaya akuisisinya (CAC).'
            ],
            [
                'question_text' => 'Biaya langganan server bulanan yang nilainya tetap termasuk kategori...',
                'code_snippet' => null,
                'option_a' => 'Fixed Cost (Biaya Tetap)',
                'option_b' => 'Pendapatan Kotor',
                'option_c' => 'Piutang Usaha',
                'option_d' => 'Dividen',
                'correct_answer' => 'a',
                'explanation' => 'Fixed cost tidak berubah secara langsung mengikuti volume harian pengguna.'
            ],
            [
                'question_text' => 'Apa yang dimaksud dengan Break-Even Point (BEP)?',
                'code_snippet' => null,
                'option_a' => 'Titik impas di mana total pendapatan sama dengan total biaya',
                'option_b' => 'Kondisi perusahaan mengalami kerugian',
                'option_c' => 'Laba bersih setelah pajak',
                'option_d' => 'Modal awal investor',
                'correct_answer' => 'a',
                'explanation' => 'Pada titik BEP, perusahaan tidak untung dan tidak rugi.'
            ],
            [
                'question_text' => 'Laporan keuangan yang menampilkan aset, liabilitas, dan ekuitas pada tanggal tertentu adalah...',
                'code_snippet' => null,
                'option_a' => 'Laporan Laba Rugi',
                'option_b' => 'Neraca (Balance Sheet)',
                'option_c' => 'Laporan Arus Kas',
                'option_d' => 'Rekap Absensi',
                'correct_answer' => 'b',
                'explanation' => 'Neraca menyajikan posisi aset = liabilitas + ekuitas.'
            ],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(['quiz_id' => $quiz->id, 'question_text' => $q['question_text']], $q);
        }
    }
}
