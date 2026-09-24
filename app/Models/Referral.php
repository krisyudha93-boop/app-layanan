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
