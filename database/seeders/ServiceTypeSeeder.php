<?php

namespace Database\Seeders;

use App\Enums\ServiceHandler;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'code' => 'DTSEN',
                'name' => 'Surat Keterangan DTSEN',
                'category' => 'Perlindungan dan Jaminan Sosial',
                'description' => 'Penerbitan surat keterangan status terdaftar dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN) dan peringkat desil keluarga untuk keperluan afirmasi pendidikan, beasiswa, keringanan biaya kesehatan, dan bantuan sosial.',
                'handler' => ServiceHandler::DTSEN,
                'needs_assessment' => false,
                'sla_days' => 3,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Pengantar dari Desa / Kelurahan',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Bukti Pendaftaran / Keterangan Lembaga Terkait',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'code' => 'PBI',
                'name' => 'Reaktivasi KIS / PBI-JK',
                'category' => 'Jaminan Kesehatan',
                'description' => 'Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan bagi warga Kabupaten Blitar.',
                'handler' => ServiceHandler::PBI,
                'needs_assessment' => false,
                'sla_days' => 7,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) Peserta',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Kartu Indonesia Sehat (KIS) / BPJS Kesehatan Nonaktif',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Surat Keterangan Rawat / Resume Medis dari Faskes',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'code' => 'REHSOS',
                'name' => 'Pelayanan Rehabilitasi Sosial PPKS',
                'category' => 'Rehabilitasi Sosial',
                'description' => 'Pelayanan, penanganan, dan rujukan rehabilitasi bagi Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) seperti lansia terlantar, penyandang disabilitas, ODGJ terlantar, dan anak rentan.',
                'handler' => ServiceHandler::GENERIC,
                'needs_assessment' => true,
                'sla_days' => 14,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) / Identitas PPKS atau Pelapor',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Keterangan Tidak Mampu / Pengantar Desa',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Foto Dokumentasi Kondisi Fisik / Lingkungan PPKS',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'jpg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'code' => 'BANSOS',
                'name' => 'Rekomendasi Bantuan Sosial Khusus',
                'category' => 'Perlindungan dan Jaminan Sosial',
                'description' => 'Permohonan surat rekomendasi bantuan sosial terencana, tanggap darurat bencana sosial, atau asistensi modal usaha bagi keluarga miskin/rentan.',
                'handler' => ServiceHandler::GENERIC,
                'needs_assessment' => true,
                'sla_days' => 5,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'KTP Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Keterangan Tidak Mampu (SKTM) dari Desa/Kelurahan',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Foto Rumah / Tempat Tinggal Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'jpg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
        ];

        foreach ($types as $typeData) {
            $requirements = $typeData['requirements'];
            unset($typeData['requirements']);

            $serviceType = ServiceType::updateOrCreate(
                ['code' => $typeData['code']],
                $typeData
            );

            foreach ($requirements as $req) {
                ServiceRequirement::updateOrCreate(
                    [
                        'service_type_id' => $serviceType->id,
                        'name' => $req['name'],
                    ],
                    $req
                );
            }
        }
    }
}
