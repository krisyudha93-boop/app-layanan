<?php

namespace App\Models;

use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RehabilitationCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_number',
        'client_id',
        'service_request_id',
        'complaint_id',
        'officer_id',
        'handling_type',
        'status',
        'handling_result',
        'received_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'handling_type' => HandlingType::class,
            'status' => RehabilitationCaseStatus::class,
            'received_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (RehabilitationCase $case) {
            if (empty($case->case_number)) {
                $case->case_number = NumberSequence::next('RHS');
            }
            if (empty($case->received_at)) {
                $case->received_at = now();
            }
            if (empty($case->status)) {
                $case->status = RehabilitationCaseStatus::RECEIVED;
            }
        });

        static::updated(function (RehabilitationCase $case) {
            if ($case->wasChanged('status')) {
                $from = $case->getOriginal('status');
                $fromVal = $from instanceof RehabilitationCaseStatus ? $from->value : $from;
                $toVal = $case->status instanceof RehabilitationCaseStatus ? $case->status->value : $case->status;

                $case->statusHistories()->create([
                    'from_status' => $fromVal,
                    'to_status' => $toVal,
                    'notes' => $case->status_notes ?? 'Pembaruan status kasus rehabilitasi',
                    'user_id' => auth()->id() ?? $case->officer_id,
                ]);
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class)->latest('assessment_date');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function monitoringRecords(): HasMany
    {
        return $this->hasMany(MonitoringRecord::class)->latest('monitoring_date');
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable')->latest();
    }

    public function dispositions(): MorphMany
    {
        return $this->morphMany(Disposition::class, 'dispositionable')->latest();
    }

    /**
     * Helper to log status history.
     */
    public function recordStatusChange(RehabilitationCaseStatus|string $toStatus, ?string $notes = null, ?int $userId = null): StatusHistory
    {
        $fromStatus = $this->status instanceof RehabilitationCaseStatus ? $this->status->value : $this->status;
        $targetStatus = $toStatus instanceof RehabilitationCaseStatus ? $toStatus->value : $toStatus;

        return $this->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => $targetStatus,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id(),
        ]);
    }
}
