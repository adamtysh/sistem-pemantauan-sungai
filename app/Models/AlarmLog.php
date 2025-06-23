<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlarmLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'sensor_name',
        'value',
        'message',
    ];
    
}
