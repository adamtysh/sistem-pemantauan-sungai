<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;
    protected $table = 'sensor_readings';
    protected $fillable = [
        'sensor_name',
        'data_value',
        'reading_time'
    ];
}