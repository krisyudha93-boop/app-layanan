<?php

namespace Database\Seeders;

use App\Models\NumberSequence;
use Illuminate\Database\Seeder;

class NumberSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $period = now()->format('Ym');

        $sequences = [
            ['prefix' => 'DTSEN', 'period' => $period, 'last_number' => 0],
            ['prefix' => 'PBI', 'period' => $period, 'last_number' => 0],
            ['prefix' => 'ADU', 'period' => $period, 'last_number' => 0],
            ['prefix' => 'RHS', 'period' => $period, 'last_number' => 0],
            ['prefix' => 'RJK', 'period' => $period, 'last_number' => 0],
            ['prefix' => 'BNS', 'period' => $period, 'last_number' => 0],
        ];

        foreach ($sequences as $seq) {
            NumberSequence::updateOrCreate(
                [
                    'prefix' => $seq['prefix'],
                    'period' => $seq['period'],
                ],
                $seq
            );
        }
    }
}
