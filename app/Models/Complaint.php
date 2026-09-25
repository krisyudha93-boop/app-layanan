<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'complaint_number',
        'complaint_category_id',
        'reporter_id',
        'reporter_name',
        'reporter_phone',
        'location_detail',
        'village_id',
        'description',
        'reported_at',
        'officer_id',
        'status',
        'verification_result',
        'action_taken',
        'duplicate_of_id',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ComplaintStatus::class,
            'reported_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = NumberSequence::next('ADU');
            }
            if (empty($complaint->reported_at)) {
                $complaint->reported_at = now();
            }
            if (empty($complaint->status)) {
                $complaint->status = ComplaintStatus::RECEIVED;
            }
        });

        static::updated(function (Complaint $complaint) {
            if ($complaint->wasChanged('status')) {
                $from = $complaint->getOriginal('status');
                $fromVal = $from instanceof ComplaintStatus ? $from->value : $from;
                $toVal = $complaint->status instanceof ComplaintStatus ? $complaint->status->value : $complaint->status;

                $complaint->statusHistories()->create([
                    'from_status' => $fromVal,
                    'to_status' => $toVal,
                    'notes' => $complaint->status_notes ?? 'Pembaruan status pengaduan',
                    'user_id' => auth()->id() ?? $complaint->officer_id,
                ]);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'complaint_category_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function duplicateOf(): BelongsTo
    {
        return $this->belongsTo(self::class, 'duplicate_of_id');
    }

    public function duplicates(): HasMany
    {
        return $this->hasMany(self::class, 'duplicate_of_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }

    public function rehabilitationCases(): HasMany
    {
        return $this->hasMany(RehabilitationCase::class);
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
    public function recordStatusChange(ComplaintStatus|string $toStatus, ?string $notes = null, ?int $userId = null): StatusHistory
    {
        $fromStatus = $this->status instanceof ComplaintStatus ? $this->status->value : $this->status;
        $targetStatus = $toStatus instanceof ComplaintStatus ? $toStatus->value : $toStatus;

        return $this->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => $targetStatus,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id(),
        ]);
    }
}
