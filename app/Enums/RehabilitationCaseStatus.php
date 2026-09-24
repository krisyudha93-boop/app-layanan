<?php

namespace App\Enums;

enum RehabilitationCaseStatus: string
{
    case RECEIVED = 'received';
    case ASSESSMENT = 'assessment';
    case SERVICE_PLANNING = 'service_planning';
    case IN_SERVICE = 'in_service';
    case MONITORING = 'monitoring';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::RECEIVED => 'Diterima',
            self::ASSESSMENT => 'Assessment',
            self::SERVICE_PLANNING => 'Rencana Pelayanan',
            self::IN_SERVICE => 'Dalam Pelayanan',
            self::MONITORING => 'Monitoring',
            self::CLOSED => 'Selesai / Ditutup',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::RECEIVED => 'gray',
            self::ASSESSMENT, self::SERVICE_PLANNING => 'info',
            self::IN_SERVICE, self::MONITORING => 'warning',
            self::CLOSED => 'success',
        };
    }
}
