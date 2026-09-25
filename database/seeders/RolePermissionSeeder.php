<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define standard roles
        $roles = [
            'administrator' => 'Administrator Sistem Dinas Sosial',
            'petugas_dinsos' => 'Petugas Pelayanan / Rehabilitasi Sosial',
            'pejabat_penandatangan' => 'Pejabat Penandatangan (Kabid / Kadis)',
            'pimpinan' => 'Pimpinan & Pengawas Daerah (Read Only)',
            'operator_kecamatan_desa' => 'Operator Kecamatan / Desa / Puskesos',
            'masyarakat' => 'Masyarakat Pemohon / Pelapor',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Define permissions
        $permissions = [
            // Service Requests
            'view_service_requests',
            'create_service_requests',
            'update_service_requests',
            'delete_service_requests',
            'verify_service_requests',
            'approve_service_requests',

            // DTSEN Certificates
            'view_dtsen_certificates',
            'check_siks_ng',
            'sign_dtsen_certificates',

            // PBI Reactivations
            'view_pbi_reactivations',
            'verify_pbi_reactivations',
            'sign_pbi_recommendations',
            'propose_to_ministry',

            // Rehabilitation Cases
            'view_rehabilitation_cases',
            'manage_rehabilitation_cases',
            'manage_assessments',
            'manage_referrals',
            'manage_monitoring',

            // Complaints
            'view_complaints',
            'create_complaints',
            'verify_complaints',
            'handle_complaints',
            'resolve_complaints',

            // Master data & settings
            'manage_master_data',
            'manage_users',
            'view_reports',
            'export_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('administrator');
        $adminRole->syncPermissions(Permission::all());

        $petugasRole = Role::findByName('petugas_dinsos');
        $petugasRole->syncPermissions([
            'view_service_requests', 'create_service_requests', 'update_service_requests', 'verify_service_requests',
            'view_dtsen_certificates', 'check_siks_ng',
            'view_pbi_reactivations', 'verify_pbi_reactivations', 'propose_to_ministry',
            'view_rehabilitation_cases', 'manage_rehabilitation_cases', 'manage_assessments', 'manage_referrals', 'manage_monitoring',
            'view_complaints', 'verify_complaints', 'handle_complaints', 'resolve_complaints',
            'view_reports', 'export_reports',
        ]);

        $pejabatRole = Role::findByName('pejabat_penandatangan');
        $pejabatRole->syncPermissions([
            'view_service_requests', 'approve_service_requests',
            'view_dtsen_certificates', 'sign_dtsen_certificates',
            'view_pbi_reactivations', 'sign_pbi_recommendations',
            'view_rehabilitation_cases',
            'view_complaints',
            'view_reports', 'export_reports',
        ]);

        $pimpinanRole = Role::findByName('pimpinan');
        $pimpinanRole->syncPermissions([
            'view_service_requests',
            'view_dtsen_certificates',
            'view_pbi_reactivations',
            'view_rehabilitation_cases',
            'view_complaints',
            'view_reports', 'export_reports',
        ]);

        $operatorRole = Role::findByName('operator_kecamatan_desa');
        $operatorRole->syncPermissions([
            'view_service_requests', 'create_service_requests',
            'view_complaints', 'create_complaints',
        ]);

        $masyarakatRole = Role::findByName('masyarakat');
        $masyarakatRole->syncPermissions([
            'create_service_requests',
            'create_complaints',
        ]);
    }
}
