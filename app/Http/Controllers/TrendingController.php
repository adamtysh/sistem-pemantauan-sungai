<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;
use App\Models\SensorSetting;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TrendingController extends Controller
{
    public function showSelection()
    {
        $data['page_title'] = 'Pilih Grafik Historis';
        $sensors = SensorSetting::with('location')->whereHas('location')->get();
        $data['locationsWithSensors'] = $sensors->groupBy('location.name');
        return view('trending.selection', $data);
    }

    public function index(Request $request, $sensorName)
    {
        $dbSensorName = $sensorName;
        if ($sensorName == 'Water Level') { $dbSensorName = 'Sensor_Water Level'; }
        elseif ($sensorName == 'Curah Hujan') { $dbSensorName = 'Sensor_Curah Hujan'; }
        elseif ($sensorName == 'Barometric Pressure') { $dbSensorName = 'Tekanan Udara'; }
        elseif ($sensorName == 'Humidity') { $dbSensorName = 'Kelembapan'; }
        
        $periode = $request->input('periode', 'harian');
        $tanggal_mulai = $request->input('tanggal_mulai', now()->toDateString());
        $tanggal_akhir = $request->input('tanggal_akhir', now()->toDateString());

        $query = SensorReading::where('sensor_name', $dbSensorName)->orderBy('reading_time', 'asc');

        if ($periode != 'all_time') {
            switch ($periode) {
                case 'harian':
                    $query->whereDate('reading_time', Carbon::parse($tanggal_mulai));
                    break;
                case 'mingguan':
                    $startOfWeek = Carbon::parse($tanggal_mulai)->startOfWeek();
                    $endOfWeek = Carbon::parse($tanggal_mulai)->endOfWeek();
                    $query->whereBetween('reading_time', [$startOfWeek, $endOfWeek]);
                    break;
                case 'bulanan':
                    $query->whereMonth('reading_time', Carbon::parse($tanggal_mulai)->month)
                          ->whereYear('reading_time', Carbon::parse($tanggal_mulai)->year);
                    break;
                case 'custom_range':
                    if ($tanggal_mulai && $tanggal_akhir) {
                        $query->whereBetween('reading_time', [Carbon::parse($tanggal_mulai)->startOfDay(), Carbon::parse($tanggal_akhir)->endOfDay()]);
                    }
                    break;
            }
        }
        $readings = $query->get();
            
        $chartData = $readings->map(function ($item) {
            preg_match('/^[\-]?([0-9\.]+)/', $item->data_value, $matches);
            $numericValue = isset($matches[1]) ? (float)$matches[1] : 0;
            return ['x' => Carbon::parse($item->reading_time)->toIso8601String(), 'y' => $numericValue];
        });

        $chartColor = '#6c757d';
        if (Str::contains(strtolower($sensorName), ['level', 'water'])) { $chartColor = '#0d6efd'; }
        elseif (Str::contains(strtolower($sensorName), 'suhu')) { $chartColor = '#fd7e14'; }
        elseif (Str::contains(strtolower($sensorName), 'humidity')) { $chartColor = '#0dcaf0'; }
        elseif (Str::contains(strtolower($sensorName), ['pressure', 'tekanan'])) { $chartColor = '#198754'; }
        
        // PERBAIKAN: Hanya mencari berdasarkan dbSensorName yang sudah dipetakan
        $setting = SensorSetting::where('sensor_name', $dbSensorName)->first();
        $unit = $setting ? $setting->unit : '';
        
        return view('trending.index', [
            'page_title' => 'Grafik Historis: ' . str_replace('_', ' ', $sensorName),
            'sensorName' => str_replace('_', ' ', $sensorName),
            'chartData' => $chartData,
            'chartColor' => $chartColor,
            'unit' => $unit,
            'currentPeriode' => $periode,
            'currentTanggalMulai' => $tanggal_mulai,
            'currentTanggalAkhir' => $tanggal_akhir,
        ]);
    }
}