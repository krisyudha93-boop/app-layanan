<?php

namespace Database\Seeders;

use App\Enums\PublishStatus;
use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\PageVisit;
use App\Models\SearchLog;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;

class InformationPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@blitar.go.id')->first() ?? User::first();
        $dtsenType = ServiceType::where('code', 'DTSEN')->first();
        $pbiType = ServiceType::where('code', 'PBI')->first();
        $rehsosType = ServiceType::where('code', 'REHSOS')->first();

        $pages = [
            [
                'title' => 'Standar Pelayanan Surat Keterangan DTSEN',
                'slug' => 'surat-keterangan-dtsen',
                'category' => 'program',
                'service_type_id' => $dtsenType?->id,
                'description' => 'Layanan penerbitan Surat Keterangan Data Tunggal Sosial Ekonomi Nasional (DTSEN) bagi warga Kabupaten Blitar yang terdaftar dalam data desil untuk keperluan jalur afirmasi SPMB, beasiswa PIP, KIP Kuliah, dan bantuan lainnya.',
                'requirements' => "1. KTP Elektronik Pemohon (fotokopi/unggah berkas)\n2. Kartu Keluarga (KK) terbaru\n3. Surat Pengantar Desa/Kelurahan setempat\n4. Bukti Keterangan Lembaga Pendidikan bagi calon siswa/mahasiswa",
                'procedure' => "1. Pemohon mengisi formulir online di portal SAPA SOSIAL atau melalui operator Puskesos Desa.\n2. Mengunggah dokumen persyaratan.\n3. Petugas Dinsos memverifikasi data terhadap database SIKS-NG.\n4. Apabila desil memenuhi syarat, draf surat diajukan untuk paraf Kabid dan tanda tangan Kadis.\n5. Surat Keterangan ber-QR Code diterbitkan dan dapat diunduh pemohon.",
                'service_hours' => 'Senin - Kamis: 08.00 - 15.00 WIB, Jumat: 08.00 - 14.30 WIB',
                'location' => 'Kantor Dinas Sosial Kabupaten Blitar, Jl. Sudanco Supriyadi No. 17 Blitar',
                'contact' => 'WhatsApp Layanan: 0812-3456-7801 | Email: dinsos@blitarkab.go.id',
                'publish_status' => PublishStatus::PUBLISHED,
                'published_at' => now()->subMonths(2),
                'manager_id' => $admin->id,
                'forms' => [
                    [
                        'name' => 'Formulir Permohonan Surat Keterangan DTSEN (F-01/DTSEN)',
                        'file_path' => 'forms/formulir_permohonan_dtsen_v1.2.pdf',
                        'version' => '1.2',
                        'is_current' => true,
                    ],
                    [
                        'name' => 'Format Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)',
                        'file_path' => 'forms/sptjm_pemohon_v1.0.pdf',
                        'version' => '1.0',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Berapa batas desil untuk mendapatkan Surat Keterangan DTSEN jalur SPMB Afirmasi?',
                        'answer' => 'Sesuai ketentuan, batas desil maksimal untuk jalur afirmasi pendidikan adalah Desil 1 sampai dengan Desil 5.',
                        'sort_order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'question' => 'Berapa lama proses penerbitan Surat Keterangan DTSEN?',
                        'answer' => 'SLA penerbitan adalah maksimal 3 (tiga) hari kerja sejak dokumen persyaratan dinyatakan lengkap dan valid oleh petugas verifikator.',
                        'sort_order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'question' => 'Bagaimana jika nama saya tidak ditemukan dalam pengecekan SIKS-NG?',
                        'answer' => 'Jika pemohon belum terdata dalam SIKS-NG/DTSEN, permohonan akan ditolak dengan penjelasan, dan pemohon diarahkan untuk melakukan pengusulan data baru melalui Musyawarah Desa (Musdes) di kantor desa/kelurahan setempat.',
                        'sort_order' => 3,
                        'is_active' => true,
                    ],
                ],
            ],
            [
                'title' => 'Panduan Reaktivasi KIS / PBI-JK Kabupaten Blitar',
                'slug' => 'reaktivasi-kis-pbi-jk',
                'category' => 'program',
                'service_type_id' => $pbiType?->id,
                'description' => 'Fasilitasi rekomendasi pengaktifan kembali status kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan pemerintah pusat bagi warga yang membutuhkan penanganan medis segera.',
                'requirements' => "1. KTP dan Kartu Keluarga (KK)\n2. Kartu BPJS Kesehatan / KIS yang nonaktif\n3. Surat Keterangan Rawat Inap / Jadwal Kontrol Rutin / Resume Medis dari Rumah Sakit atau Puskesmas\n4. Surat Keterangan Tidak Mampu (SKTM) dari Desa/Kelurahan",
                'procedure' => "1. Pemohon mengajukan permohonan melalui SAPA SOSIAL.\n2. Verifikator Dinsos mengecek riwayat kepesertaan dan tanggal nonaktif.\n3. Dinsos menerbitkan surat rekomendasi reaktivasi bertanda tangan Kepala Dinas.\n4. Petugas menginput usulan reaktivasi ke aplikasi SIKS-NG Kemensos RI.\n5. Pemantauan berkala hingga status kepesertaan aktif kembali di sistem BPJS Kesehatan.",
                'service_hours' => 'Senin - Jumat: 08.00 - 15.30 WIB (Layanan Darurat Medis diprioritaskan)',
                'location' => 'Loket Pelayanan Terpadu Dinsos Kab. Blitar & Puskesos Kecamatan',
                'contact' => 'Hotline Reaktivasi PBI: 0812-3456-7802',
                'publish_status' => PublishStatus::PUBLISHED,
                'published_at' => now()->subMonths(2),
                'manager_id' => $admin->id,
                'forms' => [
                    [
                        'name' => 'Formulir Permohonan Reaktivasi KIS PBI (F-02/PBI)',
                        'file_path' => 'forms/formulir_reaktivasi_pbi_v2.0.pdf',
                        'version' => '2.0',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Mengapa kepesertaan BPJS KIS PBI bisa tiba-tiba dinonaktifkan?',
                        'answer' => 'Penonaktifan dilakukan berkala oleh Kementerian Sosial RI berdasarkan pemutakhiran data DTSEN terpadu, migrasi data kependudukan, atau kuota kepesertaan daerah.',
                        'sort_order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'question' => 'Berapa batas waktu penonaktifan yang masih dapat diusulkan reaktivasi?',
                        'answer' => 'Umumnya reaktivasi dapat diproses untuk kepesertaan yang dinonaktifkan maksimal 6 (enam) bulan terakhir, dengan prioritas bagi pasien penyakit kronis, katastropik, atau kondisi darurat medis.',
                        'sort_order' => 2,
                        'is_active' => true,
                    ],
                ],
            ],
            [
                'title' => 'Standar Pelayanan Rehabilitasi Sosial PPKS',
                'slug' => 'pelayanan-rehabilitasi-sosial',
                'category' => 'rehabilitation',
                'service_type_id' => $rehsosType?->id,
                'description' => 'Penanganan terpadu Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) meliputi penjangkauan, assessment, pemberian bantuan pemenuhan kebutuhan dasar, pendampingan, hingga rujukan ke balai/panti rehabilitasi sosial.',
                'requirements' => "1. Identitas PPKS (KTP/KK bila ada, atau data sementara penjangkauan)\n2. Laporan kronologis kejadian / temuan\n3. Surat Pengantar / Keterangan dari Pemerintah Desa / Kelurahan / Faskes\n4. Dokumentasi kondisi klien",
                'procedure' => "1. Laporan diterima petugas dari pengajuan masyarakat, pengaduan, atau penjangkauan tim reaksi cepat.\n2. Pekerja Sosial / Petugas melakukan assessment mendalam kondisi fisik, psikososial, dan lingkungan.\n3. Penyusunan Rencana Pelayanan (Intervensi Langsung atau Rujukan Balai).\n4. Pelaksanaan intervensi dan monitoring berkala hingga terminasi kasus.",
                'service_hours' => 'Pelayanan Kantor: Hari Kerja 08.00 - 15.00 WIB | Tim Reaksi Cepat / Darurat 24 Jam',
                'location' => 'Bidang Rehabilitasi Sosial, Kantor Dinas Sosial Kabupaten Blitar',
                'contact' => 'Emergency Call Center Rehsos Blitar: 0812-3456-7803',
                'publish_status' => PublishStatus::PUBLISHED,
                'published_at' => now()->subMonths(1),
                'manager_id' => $admin->id,
                'forms' => [
                    [
                        'name' => 'Format Berita Acara Penjangkauan dan Assessment PPKS',
                        'file_path' => 'forms/format_assessment_ppks_v1.0.pdf',
                        'version' => '1.0',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Apakah penanganan ODGJ atau lansia terlantar dikenakan biaya?',
                        'answer' => 'Tidak. Seluruh proses penanganan, evakuasi, assessment, dan rujukan PPKS terlantar oleh Dinas Sosial Kabupaten Blitar bebas biaya (gratis).',
                        'sort_order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'question' => 'Ke mana saja rujukan panti / balai rehabilitasi sosial dilakukan?',
                        'answer' => 'Dinsos bekerjasama dengan RSUD Ngudi Waluyo Wlingi, RSUD Srengat, RSJ Lawang, PSTW Blitar, Balai Disabilitas Malang, dan Sentra Terpadu Prof. Dr. Soeharso Surakarta.',
                        'sort_order' => 2,
                        'is_active' => true,
                    ],
                ],
            ],
            [
                'title' => 'Prosedur Penyampaian Pengaduan Sosial Masyarakat',
                'slug' => 'prosedur-pengaduan-sosial',
                'category' => 'complaint',
                'service_type_id' => null,
                'description' => 'Kanal pengaduan masyarakat atas berbagai permasalahan kesejahteraan sosial di wilayah Kabupaten Blitar, mulai dari ketidaktepatan bantuan sosial hingga laporan warga terlantar.',
                'requirements' => "1. Nama dan Nomor Kontak/WhatsApp pelapor yang aktif untuk konfirmasi\n2. Lokasi kejadian jelas (minimal desa/kelurahan dan kecamatan di Kab. Blitar)\n3. Uraian permasalahan secara obyektif\n4. Foto bukti pendukung (opsional namun disarankan)",
                'procedure' => "1. Pelapor mengisi menu Pengaduan Sosial di portal SAPA SOSIAL.\n2. Sistem menerbitkan Nomor Laporan (Nomor Tiket ADU).\n3. Verifikator memeriksa kejelasan laporan (dapat meminta klarifikasi bila diperlukan).\n4. Laporan didisposisikan ke Bidang teknis terkait.\n5. Petugas melakukan penanganan lapangan dan mencatat tindak lanjut.\n6. Pelapor dapat memantau status secara transparan melalui nomor tiket.",
                'service_hours' => 'Penerimaan Online 24 Jam | Penanganan Petugas: Hari Kerja',
                'location' => 'Portal SAPA SOSIAL & Ruang Pengaduan Dinsos Kab. Blitar',
                'contact' => 'Unit Pengaduan: 0812-3456-7804',
                'publish_status' => PublishStatus::PUBLISHED,
                'published_at' => now()->subMonths(1),
                'manager_id' => $admin->id,
                'forms' => [],
                'faqs' => [
                    [
                        'question' => 'Apakah identitas pelapor pengaduan sosial dirahasiakan?',
                        'answer' => 'Ya, identitas pelapor dilindungi kerahasiaannya oleh sistem dan hanya dapat diakses oleh petugas verifikator yang ditunjuk.',
                        'sort_order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'question' => 'Bagaimana cara mengetahui bahwa laporan pengaduan saya sudah ditindaklanjuti?',
                        'answer' => 'Gunakan fitur Cek Status Tiket pada portal dengan memasukkan nomor pengaduan (contoh: ADU-202609-00001). Seluruh riwayat catatan penanganan dapat dipantau.',
                        'sort_order' => 2,
                        'is_active' => true,
                    ],
                ],
            ],
        ];

        foreach ($pages as $p) {
            $forms = $p['forms'];
            $faqs = $p['faqs'];
            unset($p['forms'], $p['faqs']);

            $page = InformationPage::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );

            foreach ($forms as $form) {
                DownloadableForm::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'name' => $form['name'],
                    ],
                    $form
                );
            }

            foreach ($faqs as $faq) {
                Faq::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'question' => $faq['question'],
                    ],
                    $faq
                );
            }

            // Seed sample page visits for statistics
            for ($i = 0; $i < 7; $i++) {
                PageVisit::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'visit_date' => now()->subDays($i)->toDateString(),
                    ],
                    [
                        'visit_count' => rand(15, 85),
                    ]
                );
            }
        }

        // Seed search logs for dashboard analytics
        $popularKeywords = [
            ['keyword' => 'surat keterangan dtsen', 'result_count' => 8, 'searched_at' => now()->subHours(2)],
            ['keyword' => 'spmb afirmasi', 'result_count' => 6, 'searched_at' => now()->subHours(4)],
            ['keyword' => 'reaktivasi kis', 'result_count' => 5, 'searched_at' => now()->subHours(6)],
            ['keyword' => 'pbi nonaktif', 'result_count' => 4, 'searched_at' => now()->subHours(10)],
            ['keyword' => 'odgj terlantar', 'result_count' => 3, 'searched_at' => now()->subDay()],
            ['keyword' => 'bantuan sosial', 'result_count' => 12, 'searched_at' => now()->subDays(2)],
            ['keyword' => 'sktm beasiswa', 'result_count' => 7, 'searched_at' => now()->subDays(3)],
        ];

        foreach ($popularKeywords as $kw) {
            SearchLog::create($kw);
        }
    }
}
