<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SensorSettingController;
use App\Http\Controllers\AlarmController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrendingController;
use Illuminate\Support\Facades\Auth;
use App\Exports\DataSensorExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Auth::routes();

// --- SEMUA RUTE YANG MEMBUTUHKAN LOGIN DIMASUKKAN KE DALAM GRUP INI ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('settings')->group(function () {
        Route::get('/menu', [SettingController::class, 'index'])->name('settings.menu');
    });
    Route::get('/alarm-history', [AlarmController::class, 'alarmHistory'])->name('alarm.history');
    Route::get('/trending', [TrendingController::class, 'showSelection'])->name('trending.selection');
    Route::get('/trending/{sensorName}', [TrendingController::class, 'index'])->name('trending.index');
    Route::get('/cctv-monitoring', function () { return view('cctv.index', ['page_title' => 'CCTV Monitoring']); })->name('cctv.index');
    Route::resource('locations', LocationController::class);
    Route::resource('sensor_settings', SensorSettingController::class);
    Route::resource('alarm_settings', AlarmController::class);
    Route::resource('users', UserController::class);
    Route::get('/laporan/download-sensor', function () {
        return Excel::download(new DataSensorExport, 'laporan-historis-sensor.xlsx');
    })->name('sensor.export');
});

// ▼▼▼ RUTE API DIPINDAHKAN KE LUAR GRUP AUTH ▼▼▼
Route::get('/api/active-alarms', [AlarmController::class, 'getActiveAlarms'])->name('api.alarms.active');
Route::post('/api/log-alarm', [AlarmController::class, 'logTriggeredAlarm'])->name('api.alarms.log');



// RUTE UNTUK TES DIAGNOSTIK
Route::get('/tes-koneksi', function () {
    return response()->json(['status' => 'OK', 'pesan' => 'Laravel merespons dengan sukses!']);
});
