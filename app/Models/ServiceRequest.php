<?php

namespace App\Models;

use App\Enums\ServiceRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'request_number',
        'service_type_id',
        'submitter_id',
        'applicant_name',
        'applicant_nik',
        'family_card_number',
        'address',
        'village_id',
        'phone',
        'submitted_at',
        'officer_id',
        'work_unit_id',
        'status',
        'is_priority',
        'verification_result',
        'officer_notes',
        'assessment_notes',
        'service_result',
        'rejection_reason',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ServiceRequestStatus::class,
            'is_priority' => 'boolean',
            'submitted_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ServiceRequest $request) {
            if (empty($request->request_number)) {
                $prefix = 'REQ';
                if ($request->service_type_id) {
                    $prefix = ServiceType::find($request->service_type_id)?->code ?? 'REQ';
                }
                $request->request_number = NumberSequence::next($prefix);
            }
            if (empty($request->submitted_at)) {
                $request->submitted_at = now();
            }
            if (empty($request->status)) {
                $request->status = ServiceRequestStatus::SUBMITTED;
            }
        });

        static::updated(function (ServiceRequest $request) {
            if ($request->wasChanged('status')) {
                $from = $request->getOriginal('status');
                $fromVal = $from instanceof ServiceRequestStatus ? $from->value : $from;
                $toVal = $request->status instanceof ServiceRequestStatus ? $request->status->value : $request->status;

                $request->statusHistories()->create([
                    'from_status' => $fromVal,
                    'to_status' => $toVal,
                    'notes' => $request->status_notes ?? 'Pembaruan status pengajuan',
                    'user_id' => auth()->id() ?? $request->officer_id,
                ]);
            }
        });
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitter_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function workUnit(): BelongsTo
    {
        return $this->belongsTo(WorkUnit::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ServiceRequestDocument::class);
    }

    public function dtsenCertificate(): HasOne
    {
        return $this->hasOne(DtsenCertificate::class);
    }

    public function pbiReactivation(): HasOne
    {
        return $this->hasOne(PbiReactivation::class);
    }

    public function rehabilitationCase(): HasOne
    {
        return $this->hasOne(RehabilitationCase::class);
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
    public function recordStatusChange(ServiceRequestStatus|string $toStatus, ?string $notes = null, ?int $userId = null): StatusHistory
    {
        $fromStatus = $this->status instanceof ServiceRequestStatus ? $this->status->value : $this->status;
        $targetStatus = $toStatus instanceof ServiceRequestStatus ? $toStatus->value : $toStatus;

        return $this->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => $targetStatus,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id(),
        ]);
    }
}
