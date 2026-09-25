<?php

namespace App\Models;

use App\Enums\ReferralStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'referral_number',
        'rehabilitation_case_id',
        'assessment_id',
        'referral_institution_id',
        'officer_id',
        'referral_date',
        'status',
        'service_result',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'referral_date' => 'date',
            'status' => ReferralStatus::class,
            'completed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Referral $referral) {
            if (empty($referral->referral_number)) {
                $referral->referral_number = NumberSequence::next('RJK');
            }
            if (empty($referral->referral_date)) {
                $referral->referral_date = now();
            }
            if (empty($referral->status)) {
                $referral->status = ReferralStatus::DRAFT;
            }
        });

        static::updated(function (Referral $referral) {
            if ($referral->wasChanged('status')) {
                $from = $referral->getOriginal('status');
                $fromVal = $from instanceof ReferralStatus ? $from->value : $from;
                $toVal = $referral->status instanceof ReferralStatus ? $referral->status->value : $referral->status;

                $referral->statusHistories()->create([
                    'from_status' => $fromVal,
                    'to_status' => $toVal,
                    'notes' => $referral->status_notes ?? 'Pembaruan status rujukan',
                    'user_id' => auth()->id() ?? $referral->officer_id,
                ]);
            }
        });
    }

    public function rehabilitationCase(): BelongsTo
    {
        return $this->belongsTo(RehabilitationCase::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function referralInstitution(): BelongsTo
    {
        return $this->belongsTo(ReferralInstitution::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function monitoringRecords(): HasMany
    {
        return $this->hasMany(MonitoringRecord::class);
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable')->latest();
    }

    /**
     * Helper to log status history.
     */
    public function recordStatusChange(ReferralStatus|string $toStatus, ?string $notes = null, ?int $userId = null): StatusHistory
    {
        $fromStatus = $this->status instanceof ReferralStatus ? $this->status->value : $this->status;
        $targetStatus = $toStatus instanceof ReferralStatus ? $toStatus->value : $toStatus;

        return $this->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => $targetStatus,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id(),
        ]);
    }
}
