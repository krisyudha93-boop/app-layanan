<?php

namespace Database\Seeders;

use App\Models\ReferralInstitution;
use Illuminate\Database\Seeder;

class ReferralInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'RSUD Ngudi Waluyo Wlingi',
                'type' => 'RS',
                'address' => 'Jl. Dr. Soetomo No. 1, Beru, Kec. Wlingi, Kabupaten Blitar',
                'contact' => '(0342) 691006',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Srengat Kabupaten Blitar',
                'type' => 'RS',
                'address' => 'Jl. Raya Dandong No. 10, Kec. Srengat, Kabupaten Blitar',
                'contact' => '(0342) 561234',
                'is_active' => true,
            ],
            [
                'name' => 'RSJ Dr. Radjiman Wediodiningrat Lawang',
                'type' => 'RS',
                'address' => 'Jl. Ahmad Yani, Lawang, Kabupaten Malang',
                'contact' => '(0341) 426015',
                'is_active' => true,
            ],
            [
                'name' => 'Sentra Terpadu Prof. Dr. Soeharso Surakarta',
                'type' => 'balai',
                'address' => 'Jl. Tentara Pelajar, Jebres, Surakarta, Jawa Tengah',
                'contact' => '(0271) 637452',
                'is_active' => true,
            ],
            [
                'name' => 'Panti Sosial Tresna Werdha (PSTW) Blitar',
                'type' => 'panti',
                'address' => 'Jl. Teratai No. 12, Sukorejo, Blitar',
                'contact' => '(0342) 801234',
                'is_active' => true,
            ],
            [
                'name' => 'LKS Disabilitas Harapan Mulia Blitar',
                'type' => 'LKS',
                'address' => 'Jl. Merdeka No. 45, Garum, Kabupaten Blitar',
                'contact' => '081233445566',
                'is_active' => true,
            ],
            [
                'name' => 'BRSAMPK Antasena Magelang',
                'type' => 'balai',
                'address' => 'Jl. Magelang - Purworejo Km. 11, Magelang',
                'contact' => '(0293) 362145',
                'is_active' => true,
            ],
        ];

        foreach ($institutions as $inst) {
            ReferralInstitution::updateOrCreate(
                ['name' => $inst['name']],
                $inst
            );
        }
    }
}
