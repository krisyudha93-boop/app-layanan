<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Master Organisasi & Wilayah
            WorkUnitSeeder::class,
            DistrictVillageSeeder::class,

            // 2. Akun Pengguna & Hak Akses
            UserSeeder::class,

            // 3. Master Layanan & Persyaratan
            ServiceTypeSeeder::class,
            DtsenPurposeSeeder::class,

            // 4. Master Penunjang Rehabilitasi & Pengaduan
            ClientCategorySeeder::class,
            ReferralInstitutionSeeder::class,
            ComplaintCategorySeeder::class,

            // 5. Portal Informasi & Form Unduhan (Layanan 6)
            InformationPageSeeder::class,

            // 6. Penomoran Dokumen & Tiket
            NumberSequenceSeeder::class,

            // 7. Data Sampel & Transaksional (Demo Layanan 1-5)
            SampleDataSeeder::class,
        ]);
    }
}
