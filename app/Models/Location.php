<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * Mendefinisikan relasi bahwa satu Lokasi bisa memiliki banyak SensorSetting.
     */
    public function sensorSettings()
    {
        return $this->hasMany(SensorSetting::class);
    }
}