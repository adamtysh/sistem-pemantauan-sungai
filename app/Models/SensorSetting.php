<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- TAMBAHKAN BARIS INI ---
// Memberitahu file ini untuk menggunakan Model Location
use App\Models\Location;

class SensorSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Fungsi relasi ini sudah benar, tidak perlu diubah.
     * Cukup pastikan di tabel sensor_settings ada kolom 'location_id'
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}