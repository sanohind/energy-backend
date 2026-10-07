<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerMeter extends Model
{
    protected $fillable = [
        'slave_id',
        'name',
        'is_active',
    ];

    public function powerData()
    {
        return $this->hasMany(PowerData::class);
    }
}
