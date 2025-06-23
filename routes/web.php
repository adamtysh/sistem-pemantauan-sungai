<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Exports\DataSensorExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk halaman utama dan proses login/register.
// Auth::routes() sudah mencakup semua rute untuk login, register, dan reset password.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Auth::routes();


// --- SEMUA RUTE YANG MEMBUTUHKAN LOGIN DIMASUKKAN KE DALAM GRUP INI ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::prefix('settings')->group(function () {
        Route::get('/menu', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.menu');
    });

    Route::get('/alarm-history', [App\Http\Controllers\AlarmController::class, 'alarmHistory'])->name('alarm.history');

    // Rute untuk trending
    Route::get('/trending', [App\Http\Controllers\TrendingController::class, 'showSelection'])->name('trending.selection');
    Route::get('/trending/{sensorName}', [App\Http\Controllers\TrendingController::class, 'index'])->name('trending.index');

    // Resource Controllers
    Route::resource('locations', App\Http\Controllers\LocationController::class);
    Route::resource('sensor_settings', App\Http\Controllers\SensorSettingController::class);
    Route::resource('alarm_settings', App\Http\Controllers\AlarmController::class);
    Route::resource('users', UserController::class);

    // Rute untuk Unduh Laporan Excel
    Route::get('/laporan/download-sensor', function () {
        return Excel::download(new DataSensorExport, 'laporan-historis-sensor.xlsx');
    })->name('sensor.export');

});


// =========================================================================
// RUTE API UNTUK DIAKSES OLEH SKRIP NODE.JS (DI LUAR GRUP AUTH)
// =========================================================================
Route::get('/api/active-alarms', [App\Http\Controllers\AlarmController::class, 'getActiveAlarms'])->name('api.alarms.active');
Route::post('/api/log-alarm', [App\Http\Controllers\AlarmController::class, 'logTriggeredAlarm'])->name('api.alarms.log');

Route::get('/cctv-monitoring', function () {
    return view('cctv.index', ['page_title' => 'CCTV Monitoring']);
})->name('cctv.index')->middleware('auth');