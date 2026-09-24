<?php

namespace App\Enums;

enum ServiceRequestStatus: string
{
    case SUBMITTED = 'submitted';
    case DOCUMENT_CHECK = 'document_check';
    case REVISION_REQUESTED = 'revision_requested';
    case DATA_VERIFICATION = 'data_verification';
    case ELIGIBILITY_VERIFICATION = 'eligibility_verification';
    case VERIFICATION = 'verification';
    case ASSESSMENT = 'assessment';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case RECOMMENDATION_ISSUED = 'recommendation_issued';
    case PROPOSED_TO_MINISTRY = 'proposed_to_ministry';
    case MINISTRY_APPROVED = 'ministry_approved';
    case REACTIVATED = 'reactivated';
    case IN_PROCESS = 'in_process';
    case ISSUED = 'issued';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case MINISTRY_REJECTED = 'ministry_rejected';

    public function label(): string
    {
        return match ($this) {
            self::SUBMITTED => 'Diajukan',
            self::DOCUMENT_CHECK => 'Pemeriksaan Berkas',
            self::REVISION_REQUESTED => 'Permintaan Perbaikan',
            self::DATA_VERIFICATION => 'Verifikasi Data',
            self::ELIGIBILITY_VERIFICATION => 'Verifikasi Kelayakan',
            self::VERIFICATION => 'Verifikasi',
            self::ASSESSMENT => 'Assessment',
            self::AWAITING_APPROVAL => 'Menunggu Persetujuan',
            self::RECOMMENDATION_ISSUED => 'Rekomendasi Terbit',
            self::PROPOSED_TO_MINISTRY => 'Diusulkan ke Kemensos',
            self::MINISTRY_APPROVED => 'Disetujui Kemensos',
            self::REACTIVATED => 'Aktif Kembali',
            self::IN_PROCESS => 'Dalam Proses',
            self::ISSUED => 'Diterbitkan',
            self::COMPLETED => 'Selesai',
            self::REJECTED => 'Ditolak',
            self::MINISTRY_REJECTED => 'Ditolak Kemensos',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUBMITTED => 'gray',
            self::DOCUMENT_CHECK, self::DATA_VERIFICATION, self::ELIGIBILITY_VERIFICATION, self::VERIFICATION, self::ASSESSMENT => 'info',
            self::REVISION_REQUESTED => 'warning',
            self::AWAITING_APPROVAL => 'warning',
            self::RECOMMENDATION_ISSUED, self::PROPOSED_TO_MINISTRY => 'primary',
            self::MINISTRY_APPROVED, self::REACTIVATED, self::ISSUED, self::COMPLETED => 'success',
            self::IN_PROCESS => 'primary',
            self::REJECTED, self::MINISTRY_REJECTED => 'danger',
        };
    }
}
