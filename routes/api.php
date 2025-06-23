<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/alarms', [App\Http\Controllers\AlarmController::class, 'storeAlarm'])->name('api.alarms.index');
Route::get('/alarm-settings', [App\Http\Controllers\AlarmController::class, 'getAlarmSettings'])->name('api.alarms.get');
Route::post('/sensor-reading', [SensorReadingController::class, 'store']);
