<?php

namespace Database\Seeders;

use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bantuan Sosial (Penyaluran Tidak Tepat Sasaran / Pungutan Liar)', 'is_active' => true],
            ['name' => 'Orang Dengan Gangguan Jiwa (ODGJ) Terlantar / Evakuasi Medis', 'is_active' => true],
            ['name' => 'Orang Terlantar / Gelandangan / Pengemis di Ruang Publik', 'is_active' => true],
            ['name' => 'Penelantaran Lanjut Usia dan Orang Renta', 'is_active' => true],
            ['name' => 'Kekerasan dan Penelantaran Anak', 'is_active' => true],
            ['name' => 'Layanan & Aksesibilitas Penyandang Disabilitas', 'is_active' => true],
            ['name' => 'Kualitas Pelayanan dan Etika Petugas Dinsos', 'is_active' => true],
            ['name' => 'Pengaduan Masalah Sosial Lainnya', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ComplaintCategory::updateOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }
    }
}
