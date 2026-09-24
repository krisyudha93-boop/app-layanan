<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NumberSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'period',
        'last_number',
    ];

    protected function casts(): array
    {
        return [
            'last_number' => 'integer',
        ];
    }

    /**
     * Generate the next sequential number with row locking to prevent race conditions.
     * Format: {PREFIX}-{PERIOD}-{NNNNN} (e.g., DTSEN-202610-00001)
     */
    public static function next(string $prefix, ?string $period = null, int $digits = 5): string
    {
        $period = $period ?? now()->format('Ym');

        return DB::transaction(function () use ($prefix, $period, $digits) {
            $sequence = self::query()
                ->where('prefix', $prefix)
                ->where('period', $period)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = self::create([
                    'prefix' => $prefix,
                    'period' => $period,
                    'last_number' => 0,
                ]);
            }

            $sequence->increment('last_number');
            $paddedNumber = str_pad((string) $sequence->last_number, $digits, '0', STR_PAD_LEFT);

            return "{$prefix}-{$period}-{$paddedNumber}";
        });
    }
}
