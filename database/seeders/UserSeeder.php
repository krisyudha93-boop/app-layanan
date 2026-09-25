<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $secUnit = WorkUnit::where('name', 'like', '%Sekretariat%')->first();
        $linjamsosUnit = WorkUnit::where('name', 'like', '%Perlindungan dan Jaminan Sosial%')->first();
        $rehsosUnit = WorkUnit::where('name', 'like', '%Rehabilitasi Sosial%')->first();
        $puskesosUnit = WorkUnit::where('name', 'like', '%Pusat Kesejahteraan Sosial%')->first();

        $kanigoroDistrict = District::where('code', '35.05.08')->first();
        $satreyanVillage = Village::where('code', '35.05.08.1002')->first();
        $kanigoroVillage = Village::where('code', '35.05.08.1001')->first();
        $garumDistrict = District::where('code', '35.05.15')->first();
        $garumVillage = Village::where('code', '35.05.15.1001')->first();

        $users = [
            // 1. Administrator
            [
                'name' => 'Administrator Sistem Dinsos',
                'email' => 'admin@blitar.go.id',
                'phone' => '081234567001',
                'nik' => '3505081001850001',
                'work_unit_id' => $secUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['administrator'],
            ],
            // 2. Petugas Pelayanan / SIKS-NG (Linjamsos)
            [
                'name' => 'Ahmad Mu\'amar Muzakki',
                'email' => 'petugas.linjamsos@blitar.go.id',
                'phone' => '081234567002',
                'nik' => '3505081503900002',
                'work_unit_id' => $linjamsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['petugas_dinsos'],
            ],
            // 3. Petugas Rehabilitasi Sosial
            [
                'name' => 'Dewi Sartika, S.Tr.Sos',
                'email' => 'petugas.rehsos@blitar.go.id',
                'phone' => '081234567003',
                'nik' => '3505085507920003',
                'work_unit_id' => $rehsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['petugas_dinsos'],
            ],
            // 4. Pejabat Penandatangan / Kabid Linjamsos (Paraf)
            [
                'name' => 'Drs. Hendro Wibowo, M.Si',
                'email' => 'kabid.linjamsos@blitar.go.id',
                'phone' => '081234567004',
                'nik' => '3505082006700004',
                'work_unit_id' => $linjamsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['pejabat_penandatangan'],
            ],
            // 5. Pejabat Penandatangan / Kabid Rehsos
            [
                'name' => 'Hj. Siti Aminah, S.Sos, M.AP',
                'email' => 'kabid.rehsos@blitar.go.id',
                'phone' => '081234567005',
                'nik' => '3505086510750005',
                'work_unit_id' => $rehsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['pejabat_penandatangan'],
            ],
            // 6. Pejabat Penandatangan / Kepala Dinas Sosial (Tanda Tangan Final)
            [
                'name' => 'Dr. Bambang Setiawan, M.M.',
                'email' => 'kadis@blitar.go.id',
                'phone' => '081234567006',
                'nik' => '3505081102680006',
                'work_unit_id' => $secUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['pejabat_penandatangan', 'pimpinan'],
            ],
            // 7. Pimpinan / Bupati / Pengawas (Read Only Dashboard)
            [
                'name' => 'Pimpinan & Pengawas Daerah',
                'email' => 'pimpinan@blitar.go.id',
                'phone' => '081234567007',
                'nik' => '3505080505720007',
                'work_unit_id' => null,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['pimpinan'],
            ],
            // 8. Operator Kecamatan Kanigoro
            [
                'name' => 'Rudy Hartono (Operator Kec. Kanigoro)',
                'email' => 'operator.kanigoro@blitar.go.id',
                'phone' => '081234567008',
                'nik' => '3505081408880008',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => null,
                'is_active' => true,
                'roles' => ['operator_kecamatan_desa'],
            ],
            // 9. Operator Desa Satreyan (Puskesos)
            [
                'name' => 'Nur Cahyo (Operator Puskesos Satreyan)',
                'email' => 'operator.satreyan@blitar.go.id',
                'phone' => '081234567009',
                'nik' => '3505082211910009',
                'work_unit_id' => $puskesosUnit?->id,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $satreyanVillage?->id,
                'is_active' => true,
                'roles' => ['operator_kecamatan_desa'],
            ],
            // 10. Masyarakat / Pemohon 1
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567890',
                'nik' => '3505081205800001',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $satreyanVillage?->id,
                'is_active' => true,
                'roles' => ['masyarakat'],
            ],
            // 11. Masyarakat / Pemohon 2
            [
                'name' => 'Siti Rohmah',
                'email' => 'siti.rohmah@gmail.com',
                'phone' => '081234567891',
                'nik' => '3505084508850002',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $kanigoroVillage?->id,
                'is_active' => true,
                'roles' => ['masyarakat'],
            ],
            // 12. Masyarakat / Pelapor 3
            [
                'name' => 'Agus Priyanto',
                'email' => 'agus.priyanto@gmail.com',
                'phone' => '081234567892',
                'nik' => '3505151001920003',
                'work_unit_id' => null,
                'district_id' => $garumDistrict?->id,
                'village_id' => $garumVillage?->id,
                'is_active' => true,
                'roles' => ['masyarakat'],
            ],
        ];

        foreach ($users as $userData) {
            $roles = $userData['roles'] ?? [];
            unset($userData['roles']);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );

            if (!empty($roles)) {
                $user->syncRoles($roles);
            }
        }
    }
}
