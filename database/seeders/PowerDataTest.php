<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PowerData;
use Carbon\Carbon;

class PowerDataTest extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [];

        $currentKwh = 15000.50;

        for ($i = 100; $i >= 0; $i--) {
            $time = $now->copy()->subMinutes($i * 5);

            $currentKwh += rand(50, 250) / 100;

            $data[] = [
                'power_meter_id' => 1,
                'voltage' => rand(2100, 2300) / 10,
                'current' => rand(100, 500) / 10,
                'power' => rand(200, 1100) / 100,
                'total_kwh' => $currentKwh,
                'recorded_at' => $time,
                'created_at' => $time,
                'updated_at' => $time,
            ];
        }

        PowerData::insert($data);
    }
}
