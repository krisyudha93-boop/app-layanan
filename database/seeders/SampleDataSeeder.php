<?php

namespace Database\Seeders;

use App\Enums\ApprovalDecision;
use App\Enums\ComplaintAttachmentType;
use App\Enums\ComplaintStatus;
use App\Enums\DocumentVerificationStatus;
use App\Enums\HandlingType;
use App\Enums\MinistryDecision;
use App\Enums\PbiReason;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\Approval;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\Disposition;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\MonitoringRecord;
use App\Models\NumberSequence;
use App\Models\PbiReactivation;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch Users
        $admin = User::where('email', 'admin@blitar.go.id')->first();
        $linjamsosOfficer = User::where('email', 'petugas.linjamsos@blitar.go.id')->first();
        $rehsosOfficer = User::where('email', 'petugas.rehsos@blitar.go.id')->first();
        $kabidLinjamsos = User::where('email', 'kabid.linjamsos@blitar.go.id')->first();
        $kadis = User::where('email', 'kadis@blitar.go.id')->first();
        $budiUser = User::where('email', 'budi.santoso@gmail.com')->first();
        $sitiUser = User::where('email', 'siti.rohmah@gmail.com')->first();
        $agusUser = User::where('email', 'agus.priyanto@gmail.com')->first();

        // 2. Fetch Master Data
        $linjamsosUnit = WorkUnit::where('name', 'ilike', '%Linjamsos%')->first() ?? WorkUnit::first();
        $rehsosUnit = WorkUnit::where('name', 'ilike', '%Rehabilitasi Sosial%')->first() ?? WorkUnit::first();

        $dtsenType = ServiceType::where('code', 'DTSEN')->first();
        $pbiType = ServiceType::where('code', 'PBI')->first();
        $rehsosType = ServiceType::where('code', 'REHSOS')->first();
        $bansosType = ServiceType::where('code', 'BANSOS')->first();

        $spmbPurpose = DtsenPurpose::where('code', 'spmb')->first() ?? DtsenPurpose::first();
        $pipPurpose = DtsenPurpose::where('code', 'pip')->first() ?? DtsenPurpose::first();
        $bansosPurpose = DtsenPurpose::where('code', 'bansos')->first() ?? DtsenPurpose::first();

        $satreyanVillage = Village::where('code', '35.05.08.1002')->first() ?? Village::first();
        $kanigoroVillage = Village::where('code', '35.05.08.1001')->first() ?? Village::first();
        $garumVillage = Village::where('code', '35.05.15.1001')->first() ?? Village::first();
        $srengatVillage = Village::where('code', '35.05.19.1001')->first() ?? Village::first();
        $wlingiVillage = Village::where('code', '35.05.12.1001')->first() ?? Village::first();

        $catLansia = ClientCategory::where('name', 'ilike', '%Lanjut Usia%')->first() ?? ClientCategory::first();
        $catOdgj = ClientCategory::where('name', 'ilike', '%ODGJ%')->first() ?? ClientCategory::first();
        $catDisabilitas = ClientCategory::where('name', 'ilike', '%Disabilitas%')->first() ?? ClientCategory::first();
        $catAnak = ClientCategory::where('name', 'ilike', '%Anak%')->first() ?? ClientCategory::first();

        $complaintCatOdgj = ComplaintCategory::where('name', 'ilike', '%ODGJ%')->first() ?? ComplaintCategory::first();
        $complaintCatBansos = ComplaintCategory::where('name', 'ilike', '%Bantuan Sosial%')->first() ?? ComplaintCategory::first();
        $complaintCatLayanan = ComplaintCategory::where('name', 'ilike', '%Pelayanan%')->first() ?? ComplaintCategory::first();

        $instRsj = ReferralInstitution::where('name', 'ilike', '%Radjiman%')->first() ?? ReferralInstitution::first();
        $instPstw = ReferralInstitution::where('name', 'ilike', '%Tresna Werdha%')->first() ?? ReferralInstitution::first();

        // ==========================================
        // 3. SAMPLE CLIENTS (PPKS)
        // ==========================================
        $client1 = Client::updateOrCreate(
            ['nik' => '3505066503480001'],
            [
                'name' => 'Karsinem (Mbah Karsinem)',
                'client_category_id' => $catLansia->id,
                'birth_date' => '1948-03-25',
                'gender' => 'P',
                'address' => 'RT 03 RW 02 Dusun Pandanarum',
                'village_id' => $satreyanVillage->id,
                'phone' => null,
            ]
        );

        $client2 = Client::updateOrCreate(
            ['nik' => '3505081504900005'],
            [
                'name' => 'Slamet Wahyudi',
                'client_category_id' => $catOdgj->id,
                'birth_date' => '1990-04-15',
                'gender' => 'L',
                'address' => 'Jl. Merdeka No. 14, Kanigoro',
                'village_id' => $kanigoroVillage->id,
                'phone' => '085712349901',
            ]
        );

        $client3 = Client::updateOrCreate(
            ['nik' => '3505151208020002'],
            [
                'name' => 'Rian Pratama',
                'client_category_id' => $catDisabilitas->id,
                'birth_date' => '2002-08-12',
                'gender' => 'L',
                'address' => 'Dusun Tawangsari RT 01 RW 04',
                'village_id' => $garumVillage->id,
                'phone' => '085733441122',
            ]
        );

        // ==========================================
        // 4. SERVICE REQUEST 1: DTSEN (COMPLETED)
        // ==========================================
        $reqNum1 = NumberSequence::next('DTSEN');
        $req1 = ServiceRequest::create([
            'request_number' => $reqNum1,
            'service_type_id' => $dtsenType->id,
            'submitter_id' => $budiUser->id,
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3505081205800001',
            'family_card_number' => '3505081205800001',
            'address' => 'RT 02 RW 01 Dusun Krajan, Desa Satreyan',
            'village_id' => $satreyanVillage->id,
            'phone' => '081234567890',
            'submitted_at' => now()->subDays(4),
            'officer_id' => $linjamsosOfficer->id,
            'work_unit_id' => $linjamsosUnit->id,
            'status' => ServiceRequestStatus::COMPLETED,
            'is_priority' => false,
            'verification_result' => 'Data NIK 3505081205800001 terdaftar pada database DTSEN/SIKS-NG di Desil 2.',
            'officer_notes' => 'Pemeriksaan berkas dan NIK sesuai kartu keluarga. Memenuhi syarat SPMB Afirmasi.',
            'service_result' => 'Surat Keterangan DTSEN Nomor 400.9/015/409.105/2026 telah terbit dan disetujui Kepala Dinas.',
            'completed_at' => now()->subDays(1),
        ]);

        $req1->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Pengajuan permohonan dibuat oleh pemohon', $budiUser->id);
        $req1->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas KTP dan KK diverifikasi', $linjamsosOfficer->id);
        $req1->recordStatusChange(ServiceRequestStatus::DATA_VERIFICATION, 'Pengecekan data SIKS-NG: Desil 2', $linjamsosOfficer->id);
        $req1->recordStatusChange(ServiceRequestStatus::AWAITING_APPROVAL, 'Draf diajukan untuk paraf Kabid dan tanda tangan Kadis', $linjamsosOfficer->id);
        $req1->recordStatusChange(ServiceRequestStatus::ISSUED, 'Surat Keterangan DTSEN diterbitkan', $kadis->id);
        $req1->recordStatusChange(ServiceRequestStatus::COMPLETED, 'Tiket layanan diselesaikan dan dapat diunduh', $linjamsosOfficer->id);

        // Certificate for Request 1
        $cert1 = DtsenCertificate::create([
            'service_request_id' => $req1->id,
            'dtsen_purpose_id' => $spmbPurpose->id,
            'purpose_description' => 'Persyaratan Pendaftaran SPMB Jalur Afirmasi SMAN 1 Blitar',
            'subject_name' => 'Dimas Anggara Santoso',
            'subject_nik' => '3505081503080001',
            'relationship_to_applicant' => 'Anak Kandung',
            'is_registered' => true,
            'decile' => 2,
            'checked_at' => now()->subDays(3),
            'checker_id' => $linjamsosOfficer->id,
            'certificate_number' => '400.9/015/409.105/2026',
            'issued_at' => now()->subDays(1),
            'valid_until' => now()->addDays(90)->toDateString(),
            'signer_id' => $kadis->id,
            'file_path' => 'certificates/dtsen_400.9_015_409.105_2026.pdf',
            'verification_code' => 'DTSEN-202609-VK001',
        ]);

        // Approvals for Cert 1
        Approval::create([
            'approvable_type' => DtsenCertificate::class,
            'approvable_id' => $cert1->id,
            'step' => 1,
            'approver_id' => $kabidLinjamsos->id,
            'decision' => ApprovalDecision::APPROVED,
            'notes' => 'Memenuhi kriteria desil 2 (maksimal 5). Berkas lengkap, paraf disetujui.',
            'decided_at' => now()->subDays(2),
        ]);

        Approval::create([
            'approvable_type' => DtsenCertificate::class,
            'approvable_id' => $cert1->id,
            'step' => 2,
            'approver_id' => $kadis->id,
            'decision' => ApprovalDecision::APPROVED,
            'notes' => 'Disetujui untuk ditandatangani dan diterbitkan secara digital.',
            'decided_at' => now()->subDays(1),
        ]);

        // Attach sample documents for Req 1
        foreach ($dtsenType->requirements as $reqIndex => $reqItem) {
            ServiceRequestDocument::create([
                'service_request_id' => $req1->id,
                'service_requirement_id' => $reqItem->id,
                'file_path' => 'documents/dtsen/' . $req1->request_number . '_doc_' . ($reqIndex + 1) . '.pdf',
                'original_name' => $reqItem->name . '.pdf',
                'verification_status' => DocumentVerificationStatus::VALID,
                'notes' => 'Berkas jelas dan valid.',
            ]);
        }

        // ==========================================
        // 5. SERVICE REQUEST 2: DTSEN (AWAITING APPROVAL)
        // ==========================================
        $reqNum2 = NumberSequence::next('DTSEN');
        $req2 = ServiceRequest::create([
            'request_number' => $reqNum2,
            'service_type_id' => $dtsenType->id,
            'submitter_id' => $sitiUser->id,
            'applicant_name' => 'Siti Rohmah',
            'applicant_nik' => '3505084508850002',
            'family_card_number' => '3505084508850002',
            'address' => 'Jl. Supriyadi No. 44, Desa Kanigoro',
            'village_id' => $kanigoroVillage->id,
            'phone' => '081234567891',
            'submitted_at' => now()->subDays(2),
            'officer_id' => $linjamsosOfficer->id,
            'work_unit_id' => $linjamsosUnit->id,
            'status' => ServiceRequestStatus::AWAITING_APPROVAL,
            'is_priority' => false,
            'verification_result' => 'Hasil cek SIKS-NG: Terdaftar di Desil 3.',
            'officer_notes' => 'Permohonan untuk beasiswa PIP anak SD. Draf diajukan untuk paraf Kepala Bidang.',
            'service_result' => null,
            'completed_at' => null,
        ]);

        $req2->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Permohonan diajukan secara online', $sitiUser->id);
        $req2->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas KTP dan KK lengkap', $linjamsosOfficer->id);
        $req2->recordStatusChange(ServiceRequestStatus::DATA_VERIFICATION, 'Pengecekan SIKS-NG: Desil 3', $linjamsosOfficer->id);
        $req2->recordStatusChange(ServiceRequestStatus::AWAITING_APPROVAL, 'Draf surat menunggu persetujuan Kabid', $linjamsosOfficer->id);

        $cert2 = DtsenCertificate::create([
            'service_request_id' => $req2->id,
            'dtsen_purpose_id' => $pipPurpose->id,
            'purpose_description' => 'Persyaratan Pengusulan PIP Siswa SDN Kanigoro 01',
            'subject_name' => 'Aulia Zahra',
            'subject_nik' => '3505085209140001',
            'relationship_to_applicant' => 'Anak Kandung',
            'is_registered' => true,
            'decile' => 3,
            'checked_at' => now()->subDay(),
            'checker_id' => $linjamsosOfficer->id,
            'certificate_number' => null,
            'issued_at' => null,
            'valid_until' => null,
            'signer_id' => null,
            'file_path' => null,
            'verification_code' => 'DTSEN-202609-VK002',
        ]);

        Approval::create([
            'approvable_type' => DtsenCertificate::class,
            'approvable_id' => $cert2->id,
            'step' => 1,
            'approver_id' => $kabidLinjamsos->id,
            'decision' => ApprovalDecision::PENDING,
            'notes' => null,
            'decided_at' => null,
        ]);

        // ==========================================
        // 6. SERVICE REQUEST 3: DTSEN (REJECTED - EXCEEDS DECILE)
        // ==========================================
        $reqNum3 = NumberSequence::next('DTSEN');
        $req3 = ServiceRequest::create([
            'request_number' => $reqNum3,
            'service_type_id' => $dtsenType->id,
            'submitter_id' => null,
            'applicant_name' => 'Hendra Kurniawan',
            'applicant_nik' => '3505191206840003',
            'family_card_number' => '3505191206840003',
            'address' => 'Dusun Dandong RT 03 RW 02',
            'village_id' => $srengatVillage->id,
            'phone' => '082199887766',
            'submitted_at' => now()->subDays(3),
            'officer_id' => $linjamsosOfficer->id,
            'work_unit_id' => $linjamsosUnit->id,
            'status' => ServiceRequestStatus::REJECTED,
            'is_priority' => false,
            'verification_result' => 'Hasil pengecekan SIKS-NG per 22 September 2026: Terdaftar pada Desil 7.',
            'officer_notes' => 'Tujuan permohonan adalah Bantuan Sosial dengan ambang maksimal Desil 3.',
            'rejection_reason' => 'Peringkat desil keluarga adalah Desil 7, melebihi ambang batas maksimal Desil 3 untuk tujuan Bantuan Sosial.',
            'completed_at' => now()->subDays(2),
        ]);

        $req3->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Permohonan diajukan', null);
        $req3->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas lengkap', $linjamsosOfficer->id);
        $req3->recordStatusChange(ServiceRequestStatus::DATA_VERIFICATION, 'Pengecekan SIKS-NG: Desil 7', $linjamsosOfficer->id);
        $req3->recordStatusChange(ServiceRequestStatus::REJECTED, 'Ditolak karena melebihi batas desil', $linjamsosOfficer->id);

        DtsenCertificate::create([
            'service_request_id' => $req3->id,
            'dtsen_purpose_id' => $bansosPurpose->id,
            'purpose_description' => 'Permohonan Bantuan PKH',
            'subject_name' => 'Hendra Kurniawan',
            'subject_nik' => '3505191206840003',
            'relationship_to_applicant' => 'Diri Sendiri',
            'is_registered' => true,
            'decile' => 7,
            'checked_at' => now()->subDays(2),
            'checker_id' => $linjamsosOfficer->id,
            'certificate_number' => null,
            'verification_code' => 'DTSEN-202609-VK003',
        ]);

        // ==========================================
        // 7. SERVICE REQUEST 4: PBI-JK (COMPLETED / REACTIVATED)
        // ==========================================
        $reqNumPbi1 = NumberSequence::next('PBI');
        $reqPbi1 = ServiceRequest::create([
            'request_number' => $reqNumPbi1,
            'service_type_id' => $pbiType->id,
            'submitter_id' => $sitiUser->id,
            'applicant_name' => 'Siti Rohmah',
            'applicant_nik' => '3505084508850002',
            'family_card_number' => '3505084508850002',
            'address' => 'Jl. Supriyadi No. 44, Desa Kanigoro',
            'village_id' => $kanigoroVillage->id,
            'phone' => '081234567891',
            'submitted_at' => now()->subDays(12),
            'officer_id' => $linjamsosOfficer->id,
            'work_unit_id' => $linjamsosUnit->id,
            'status' => ServiceRequestStatus::COMPLETED,
            'is_priority' => true, // Darurat Medis
            'verification_result' => 'Peserta terdata nonaktif per 1 Agustus 2026. Desil 2, indikasi medis cuci darah (hemodialisa) rutin di RSUD Wlingi.',
            'officer_notes' => 'Rekomendasi Kadis diterbitkan, telah diusulkan di SIKS-NG Kemensos dan disetujui.',
            'service_result' => 'Kepesertaan PBI-JK telah aktif kembali di sistem BPJS Kesehatan per tanggal 23 September 2026.',
            'completed_at' => now()->subDay(),
        ]);

        $reqPbi1->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Pengajuan reaktivasi PBI darurat medis', $sitiUser->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas KIS, KTP, dan surat faskes lengkap', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::ELIGIBILITY_VERIFICATION, 'Verifikasi kelayakan: Desil 2, nonaktif < 6 bulan', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::AWAITING_APPROVAL, 'Draf rekomendasi diajukan ke Kepala Dinas', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::RECOMMENDATION_ISSUED, 'Surat Rekomendasi No. 440/042/409.105/2026 diterbitkan', $kadis->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::PROPOSED_TO_MINISTRY, 'Data diinput ke SIKS-NG Kemensos RI', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::MINISTRY_APPROVED, 'Disetujui Kementerian Sosial RI', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::REACTIVATED, 'Konfirmasi aktif kembali dari BPJS Kesehatan', $linjamsosOfficer->id);
        $reqPbi1->recordStatusChange(ServiceRequestStatus::COMPLETED, 'Proses reaktivasi selesai', $linjamsosOfficer->id);

        PbiReactivation::create([
            'service_request_id' => $reqPbi1->id,
            'participant_name' => 'Siti Rohmah',
            'participant_nik' => '3505084508850002',
            'bpjs_card_number' => '0001892837482',
            'deactivated_date' => now()->subMonths(2)->toDateString(),
            'reason' => PbiReason::EMERGENCY,
            'health_facility_name' => 'RSUD Ngudi Waluyo Wlingi',
            'health_letter_number' => '445/112/RSUD/2026',
            'decile' => 2,
            'eligibility_notes' => 'Pasien membutuhkan hemodialisa rutin 2x seminggu. Memenuhi syarat reaktivasi darurat medis.',
            'recommendation_number' => '440/042/409.105/2026',
            'recommendation_issued_at' => now()->subDays(10),
            'signer_id' => $kadis->id,
            'proposed_to_ministry_at' => now()->subDays(9),
            'ministry_decision' => MinistryDecision::APPROVED,
            'ministry_decided_at' => now()->subDays(2),
            'reactivated_date' => now()->subDay()->toDateString(),
        ]);

        // ==========================================
        // 8. SERVICE REQUEST 5: PBI-JK (PROPOSED TO MINISTRY)
        // ==========================================
        $reqNumPbi2 = NumberSequence::next('PBI');
        $reqPbi2 = ServiceRequest::create([
            'request_number' => $reqNumPbi2,
            'service_type_id' => $pbiType->id,
            'submitter_id' => $budiUser->id,
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3505081205800001',
            'family_card_number' => '3505081205800001',
            'address' => 'RT 02 RW 01 Dusun Krajan, Desa Satreyan',
            'village_id' => $satreyanVillage->id,
            'phone' => '081234567890',
            'submitted_at' => now()->subDays(5),
            'officer_id' => $linjamsosOfficer->id,
            'work_unit_id' => $linjamsosUnit->id,
            'status' => ServiceRequestStatus::PROPOSED_TO_MINISTRY,
            'is_priority' => false,
            'verification_result' => 'Desil 3, peserta sakit diabetes kronis menahun dengan rujukan faskes.',
            'officer_notes' => 'Rekomendasi Kadis telah terbit, telah diinput ke SIKS-NG tanggal 21 September 2026.',
            'service_result' => null,
            'completed_at' => null,
        ]);

        $reqPbi2->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Pengajuan reaktivasi dibuat', $budiUser->id);
        $reqPbi2->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas lengkap', $linjamsosOfficer->id);
        $reqPbi2->recordStatusChange(ServiceRequestStatus::ELIGIBILITY_VERIFICATION, 'Verifikasi kelayakan selesai', $linjamsosOfficer->id);
        $reqPbi2->recordStatusChange(ServiceRequestStatus::RECOMMENDATION_ISSUED, 'Rekomendasi terbit', $kadis->id);
        $reqPbi2->recordStatusChange(ServiceRequestStatus::PROPOSED_TO_MINISTRY, 'Telah diusulkan ke Kemensos RI', $linjamsosOfficer->id);

        PbiReactivation::create([
            'service_request_id' => $reqPbi2->id,
            'participant_name' => 'Suparman (Ayah Pemohon)',
            'participant_nik' => '3505081002550001',
            'bpjs_card_number' => '0001345678912',
            'deactivated_date' => now()->subMonths(3)->toDateString(),
            'reason' => PbiReason::CHRONIC,
            'health_facility_name' => 'Puskesmas Kanigoro',
            'health_letter_number' => '440/56/PKM-KNG/2026',
            'decile' => 3,
            'eligibility_notes' => 'Pengobatan rawat jalan penyakit kronis diabetes melitus.',
            'recommendation_number' => '440/048/409.105/2026',
            'recommendation_issued_at' => now()->subDays(4),
            'signer_id' => $kadis->id,
            'proposed_to_ministry_at' => now()->subDays(3),
            'ministry_decision' => MinistryDecision::PENDING,
            'ministry_decided_at' => null,
            'reactivated_date' => null,
        ]);

        // ==========================================
        // 9. SERVICE REQUEST 6: REHSOS (IN PROCESS)
        // ==========================================
        $reqNumReh = NumberSequence::next('RHS');
        $reqReh = ServiceRequest::create([
            'request_number' => $reqNumReh,
            'service_type_id' => $rehsosType->id,
            'submitter_id' => null,
            'applicant_name' => 'Wahyudi (Perangkat Desa Satreyan)',
            'applicant_nik' => '3505081105820005',
            'family_card_number' => '3505081105820005',
            'address' => 'Kantor Desa Satreyan, Kec. Kanigoro',
            'village_id' => $satreyanVillage->id,
            'phone' => '081333445566',
            'submitted_at' => now()->subDays(6),
            'officer_id' => $rehsosOfficer->id,
            'work_unit_id' => $rehsosUnit->id,
            'status' => ServiceRequestStatus::IN_PROCESS,
            'is_priority' => true,
            'verification_result' => 'Laporan temuan lansia terlantar sebatang kara dan sakit-sakitan tanpa keluarga pendamping.',
            'officer_notes' => 'Assessment telah dilakukan oleh pekerja sosial Dinsos.',
            'assessment_notes' => 'Klien Mbah Karsinem butuh perawatan jangka panjang di panti jompo (PSTW).',
            'service_result' => null,
            'completed_at' => null,
        ]);

        $reqReh->recordStatusChange(ServiceRequestStatus::SUBMITTED, 'Permohonan bantuan rehabilitasi diterima', null);
        $reqReh->recordStatusChange(ServiceRequestStatus::DOCUMENT_CHECK, 'Berkas pengantar desa terverifikasi', $rehsosOfficer->id);
        $reqReh->recordStatusChange(ServiceRequestStatus::VERIFICATION, 'Verifikasi lapangan bersama TKSK', $rehsosOfficer->id);
        $reqReh->recordStatusChange(ServiceRequestStatus::ASSESSMENT, 'Assessment kondisi sosial lansia selesai', $rehsosOfficer->id);
        $reqReh->recordStatusChange(ServiceRequestStatus::IN_PROCESS, 'Kasus dialihkan ke modul penanganan rehabilitasi sosial', $rehsosOfficer->id);

        // ==========================================
        // 10. REHABILITATION CASES, ASSESSMENTS, REFERRALS
        // ==========================================

        // Case 1: ODGJ Terlantar (In Service / Referred to RSJ)
        $caseNum1 = NumberSequence::next('RHS');
        $case1 = RehabilitationCase::create([
            'case_number' => $caseNum1,
            'client_id' => $client2->id,
            'service_request_id' => null,
            'complaint_id' => null,
            'officer_id' => $rehsosOfficer->id,
            'handling_type' => HandlingType::BOTH,
            'status' => RehabilitationCaseStatus::IN_SERVICE,
            'handling_result' => null,
            'received_at' => now()->subDays(6),
            'closed_at' => null,
        ]);

        $case1->recordStatusChange(RehabilitationCaseStatus::RECEIVED, 'Kasus ODGJ diterima dari penjangkauan lapangan', $rehsosOfficer->id);
        $case1->recordStatusChange(RehabilitationCaseStatus::ASSESSMENT, 'Assessment kejiwaan awal di RSUD Wlingi', $rehsosOfficer->id);
        $case1->recordStatusChange(RehabilitationCaseStatus::SERVICE_PLANNING, 'Rencana rujukan stabilisasi ke RSJ Lawang', $rehsosOfficer->id);
        $case1->recordStatusChange(RehabilitationCaseStatus::IN_SERVICE, 'Klien dirujuk dan sedang dalam perawatan medis kejiwaan', $rehsosOfficer->id);

        $assessment1 = Assessment::create([
            'rehabilitation_case_id' => $case1->id,
            'officer_id' => $rehsosOfficer->id,
            'assessment_date' => now()->subDays(5)->toDateString(),
            'result' => 'Klien mengalami disorientasi ruang dan waktu, halusinasi auditorik, riwayat putus minum obat selama 8 bulan.',
            'service_needs' => 'Stabilisasi medis kejiwaan rawat inap, terapi antipsikotik, dan rehabilitasi sosial medik.',
            'recommendation' => 'Rujukan darurat ke RSJ Dr. Radjiman Wediodiningrat Lawang.',
            'needs_referral' => true,
        ]);

        $referralNum1 = NumberSequence::next('RJK');
        $referral1 = Referral::create([
            'referral_number' => $referralNum1,
            'rehabilitation_case_id' => $case1->id,
            'assessment_id' => $assessment1->id,
            'referral_institution_id' => $instRsj->id,
            'officer_id' => $rehsosOfficer->id,
            'referral_date' => now()->subDays(4)->toDateString(),
            'status' => ReferralStatus::IN_SERVICE,
            'service_result' => 'Klien dalam masa observasi dan perawatan intensif di Bangsal Kenanga RSJ Lawang.',
            'completed_at' => null,
        ]);

        $referral1->recordStatusChange(ReferralStatus::DRAFT, 'Draf surat rujukan dibuat', $rehsosOfficer->id);
        $referral1->recordStatusChange(ReferralStatus::SENT, 'Surat rujukan dan evakuasi dikirim ke RSJ', $rehsosOfficer->id);
        $referral1->recordStatusChange(ReferralStatus::ACCEPTED, 'Klien diterima oleh pihak RSJ Lawang', $rehsosOfficer->id);
        $referral1->recordStatusChange(ReferralStatus::IN_SERVICE, 'Perawatan medis sedang berlangsung', $rehsosOfficer->id);

        MonitoringRecord::create([
            'rehabilitation_case_id' => $case1->id,
            'referral_id' => $referral1->id,
            'officer_id' => $rehsosOfficer->id,
            'monitoring_date' => now()->subDays(2)->toDateString(),
            'progress' => 'Kondisi klien mulai kooperatif, sudah tidak gaduh gelisah, nafsu makan baik.',
            'result_notes' => 'Diperkirakan membutuhkan perawatan lanjutan sekitar 14-21 hari ke depan.',
        ]);

        // Case 2: Lansia Terlantar (Closed / Finished at PSTW)
        $caseNum2 = NumberSequence::next('RHS');
        $case2 = RehabilitationCase::create([
            'case_number' => $caseNum2,
            'client_id' => $client1->id,
            'service_request_id' => $reqReh->id,
            'complaint_id' => null,
            'officer_id' => $rehsosOfficer->id,
            'handling_type' => HandlingType::REFERRAL,
            'status' => RehabilitationCaseStatus::CLOSED,
            'handling_result' => 'Klien telah resmi diterima dan tinggal di Panti Sosial Tresna Werdha (PSTW) Blitar dengan jaminan kebutuhan dasar seumur hidup.',
            'received_at' => now()->subDays(20),
            'closed_at' => now()->subDays(2),
        ]);

        $case2->recordStatusChange(RehabilitationCaseStatus::RECEIVED, 'Laporan diterima dari pengajuan desa', $rehsosOfficer->id);
        $case2->recordStatusChange(RehabilitationCaseStatus::ASSESSMENT, 'Assessment komprehensif selesai', $rehsosOfficer->id);
        $case2->recordStatusChange(RehabilitationCaseStatus::SERVICE_PLANNING, 'Rencana pemindahan ke PSTW Blitar', $rehsosOfficer->id);
        $case2->recordStatusChange(RehabilitationCaseStatus::IN_SERVICE, 'Klien dipindahkan ke PSTW Blitar', $rehsosOfficer->id);
        $case2->recordStatusChange(RehabilitationCaseStatus::MONITORING, 'Monitoring adaptasi lingkungan panti', $rehsosOfficer->id);
        $case2->recordStatusChange(RehabilitationCaseStatus::CLOSED, 'Kasus terminasi selesai', $rehsosOfficer->id);

        $assessment2 = Assessment::create([
            'rehabilitation_case_id' => $case2->id,
            'officer_id' => $rehsosOfficer->id,
            'assessment_date' => now()->subDays(18)->toDateString(),
            'result' => 'Lansia berusia 78 tahun, tinggal seorang diri di gubug tidak layak huni, tidak memiliki keluarga yang mengasuh.',
            'service_needs' => 'Pemenuhan kebutuhan permukiman layak, makanan bergizi, dan pemeriksaan kesehatan berkala.',
            'recommendation' => 'Rujukan ke PSTW Blitar.',
            'needs_referral' => true,
        ]);

        $referralNum2 = NumberSequence::next('RJK');
        $referral2 = Referral::create([
            'referral_number' => $referralNum2,
            'rehabilitation_case_id' => $case2->id,
            'assessment_id' => $assessment2->id,
            'referral_institution_id' => $instPstw->id,
            'officer_id' => $rehsosOfficer->id,
            'referral_date' => now()->subDays(16)->toDateString(),
            'status' => ReferralStatus::COMPLETED,
            'service_result' => 'Lansia terdaftar sebagai warga binaan sosial tetap PSTW Blitar.',
            'completed_at' => now()->subDays(2),
        ]);

        MonitoringRecord::create([
            'rehabilitation_case_id' => $case2->id,
            'referral_id' => $referral2->id,
            'officer_id' => $rehsosOfficer->id,
            'monitoring_date' => now()->subDays(5)->toDateString(),
            'progress' => 'Mbah Karsinem sangat senang tinggal di wisma panti, berinteraksi baik dengan rekan sesama lansia, dan rutin senam pagi.',
            'result_notes' => 'Kasus dapat ditutup karena tujuan pelayanan telah tercapai optimal.',
        ]);

        // ==========================================
        // 11. COMPLAINTS & DISPOSITIONS
        // ==========================================

        // Complaint 1: ODGJ Terlantar (RESOLVED)
        $compNum1 = NumberSequence::next('ADU');
        $comp1 = Complaint::create([
            'complaint_number' => $compNum1,
            'complaint_category_id' => $complaintCatOdgj->id,
            'reporter_id' => $agusUser->id,
            'reporter_name' => 'Agus Priyanto',
            'reporter_phone' => '081234567892',
            'location_detail' => 'Kompleks Pasar Garum, dekat pos kamling barat rel kereta',
            'village_id' => $garumVillage->id,
            'description' => 'Ada seseorang dengan gangguan jiwa tanpa pakaian yang mondar-mandir membawa kayu dan membuat takut pedagang pasar subuh.',
            'reported_at' => now()->subDays(3),
            'officer_id' => $rehsosOfficer->id,
            'status' => ComplaintStatus::RESOLVED,
            'verification_result' => 'Laporan dicek kebenarannya bersama perangkat Kelurahan Garum dan Babinsa.',
            'action_taken' => 'Tim Reaksi Cepat Dinsos berkoordinasi dengan Satpol PP telah mengevakuasi yang bersangkutan ke RSUD untuk pemeriksaan dan penanganan.',
            'duplicate_of_id' => null,
            'resolved_at' => now()->subDay(),
        ]);

        $comp1->recordStatusChange(ComplaintStatus::RECEIVED, 'Laporan pengaduan diterima sistem', $agusUser->id);
        $comp1->recordStatusChange(ComplaintStatus::VERIFICATION, 'Verifikasi lapangan oleh petugas', $rehsosOfficer->id);
        $comp1->recordStatusChange(ComplaintStatus::DISPATCHED, 'Didisposisikan ke Tim Evakuasi Rehsos', $rehsosOfficer->id);
        $comp1->recordStatusChange(ComplaintStatus::IN_HANDLING, 'Evakuasi dan penanganan medis berlangsung', $rehsosOfficer->id);
        $comp1->recordStatusChange(ComplaintStatus::RESOLVED, 'Evakuasi berhasil, klien tertangani', $rehsosOfficer->id);

        ComplaintAttachment::create([
            'complaint_id' => $comp1->id,
            'file_path' => 'complaints/attachments/adu_odgj_garum_foto1.jpg',
            'type' => ComplaintAttachmentType::PHOTO,
        ]);

        // Complaint 2: Bansos (IN_HANDLING with DISPOSITION)
        $compNum2 = NumberSequence::next('ADU');
        $comp2 = Complaint::create([
            'complaint_number' => $compNum2,
            'complaint_category_id' => $complaintCatBansos->id,
            'reporter_id' => $budiUser->id,
            'reporter_name' => 'Budi Santoso',
            'reporter_phone' => '081234567890',
            'location_detail' => 'Dusun Krajan RT 02 RW 01, Desa Satreyan',
            'village_id' => $satreyanVillage->id,
            'description' => 'Ada warga lansia miskin ekstrem di lingkungan kami yang hidup sebatang kara dan belum pernah tercatat dalam penerima bansos PKH atau sembako.',
            'reported_at' => now()->subDays(2),
            'officer_id' => $linjamsosOfficer->id,
            'status' => ComplaintStatus::IN_HANDLING,
            'verification_result' => 'Data dicek di DTKS desa, nama belum terdaftar. Perlu asesmen lapangan oleh pendamping PKH.',
            'action_taken' => 'Petugas Dinsos berkoordinasi dengan Puskesos Desa Satreyan untuk memasukkan usulan pada Musdes mendatang.',
            'duplicate_of_id' => null,
            'resolved_at' => null,
        ]);

        $comp2->recordStatusChange(ComplaintStatus::RECEIVED, 'Laporan diterima', $budiUser->id);
        $comp2->recordStatusChange(ComplaintStatus::VERIFICATION, 'Pengecekan data kepesertaan bansos', $linjamsosOfficer->id);
        $comp2->recordStatusChange(ComplaintStatus::DISPATCHED, 'Didisposisikan ke Bidang Perlindungan Jaminan Sosial', $linjamsosOfficer->id);
        $comp2->recordStatusChange(ComplaintStatus::IN_HANDLING, 'Koordinasi dengan TKSK Kecamatan Kanigoro', $linjamsosOfficer->id);

        Disposition::create([
            'dispositionable_type' => Complaint::class,
            'dispositionable_id' => $comp2->id,
            'from_user_id' => $admin->id,
            'to_work_unit_id' => $linjamsosUnit->id,
            'to_user_id' => $linjamsosOfficer->id,
            'instructions' => 'Mohon tindak lanjuti verifikasi data bansos dan koordinasikan dengan Puskesos Desa Satreyan.',
            'disposed_at' => now()->subDays(2),
        ]);

        // Complaint 3: Bansos (DUPLICATE of Complaint 2)
        $compNum3 = NumberSequence::next('ADU');
        $comp3 = Complaint::create([
            'complaint_number' => $compNum3,
            'complaint_category_id' => $complaintCatBansos->id,
            'reporter_id' => $sitiUser->id,
            'reporter_name' => 'Siti Rohmah',
            'reporter_phone' => '081234567891',
            'location_detail' => 'Dusun Krajan RT 02 RW 01 Desa Satreyan',
            'village_id' => $satreyanVillage->id,
            'description' => 'Laporan tambahan warga miskin di Krajan Satreyan yang belum dapat bantuan.',
            'reported_at' => now()->subDay(),
            'officer_id' => $linjamsosOfficer->id,
            'status' => ComplaintStatus::DUPLICATE,
            'verification_result' => 'Subjek laporan sama dengan tiket pengaduan ' . $compNum2 . '.',
            'action_taken' => null,
            'duplicate_of_id' => $comp2->id,
            'resolved_at' => now()->subDay(),
        ]);

        $comp3->recordStatusChange(ComplaintStatus::RECEIVED, 'Laporan diterima', $sitiUser->id);
        $comp3->recordStatusChange(ComplaintStatus::DUPLICATE, 'Ditandai sebagai duplikat dari ' . $compNum2, $linjamsosOfficer->id);

        // Complaint 4: Pelayanan (RECEIVED / NEW)
        $compNum4 = NumberSequence::next('ADU');
        $comp4 = Complaint::create([
            'complaint_number' => $compNum4,
            'complaint_category_id' => $complaintCatLayanan->id,
            'reporter_id' => null,
            'reporter_name' => 'Warga Masyarakat',
            'reporter_phone' => '087812345678',
            'location_detail' => 'Loket Pelayanan Terpadu Dinsos Kab. Blitar',
            'village_id' => $kanigoroVillage->id,
            'description' => 'Antrean loket pada jam istirahat diharapkan tetap ada petugas pengganti (piket) agar pemohon dari pelosok desa tidak menunggu lama.',
            'reported_at' => now()->subHours(5),
            'officer_id' => null,
            'status' => ComplaintStatus::RECEIVED,
            'verification_result' => null,
            'action_taken' => null,
            'duplicate_of_id' => null,
            'resolved_at' => null,
        ]);

        $comp4->recordStatusChange(ComplaintStatus::RECEIVED, 'Pengaduan baru diterima dan menunggu verifikasi', null);
    }
}
