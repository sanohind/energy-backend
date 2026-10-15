<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerData extends Model
{
    protected $fillable = [
        'power_meter_id',
        'voltage',
        'current',
        'power',
        'total_kwh',
        'recorded_at',
    ];

    protected $casts = [
        'voltage' => 'float',
        'current' => 'float',
        'power' => 'float',
        'recorded_at' => 'datetime',
    ];

    public function powerMeter()
    {
        return $this->belongsTo(PowerMeter::class);
    }
}
