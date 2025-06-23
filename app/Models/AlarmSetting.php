<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlarmSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_setting_id',
        'operator',
        'threshold',
        'message',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function sensorSetting()
    {
        return $this->belongsTo(SensorSetting::class);
    }

    public function getLocationSensor($sensorSettingId)
    {
        $sensor = SensorSetting::find($sensorSettingId);
        if ($sensor) {
            return $sensor->location->name ?? null;
        }
    }
}