<?php

namespace Database\Seeders;

use App\Models\ClientCategory;
use Illuminate\Database\Seeder;

class ClientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lanjut Usia Terlantar / Rawan Terlantar', 'is_active' => true],
            ['name' => 'Penyandang Disabilitas (Fisik, Sensorik, Intelektual, Mental)', 'is_active' => true],
            ['name' => 'Orang Dengan Gangguan Jiwa (ODGJ) Terlantar', 'is_active' => true],
            ['name' => 'Anak Terlantar / Anak Berhadapan dengan Hukum (ABH)', 'is_active' => true],
            ['name' => 'Korban Tindak Kekerasan dan Penelantaran', 'is_active' => true],
            ['name' => 'Gelandangan, Pengemis, dan Tuna Sosial', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ClientCategory::updateOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }
    }
}
