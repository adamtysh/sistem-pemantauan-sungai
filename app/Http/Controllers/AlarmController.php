<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlarmLog;
use App\Models\AlarmSetting;
use App\Models\Location;
use App\Models\SensorSetting;

class AlarmController extends Controller
{

    // ▼▼▼ FUNGSI INI YANG DIPERBAIKI ▼▼▼
    public function index()
    {
        $data['page_title'] = 'Alarm Settings';
        // Menggunakan nested relationship untuk memuat lokasi melalui sensor
        $data['alarms'] = AlarmSetting::with('sensorSetting.location')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('alarms.index', $data);
    }
    // ▲▲▲ BATAS AKHIR PERBAIKAN ▲▲▲

    public function create()
    {
        $data['page_title'] = 'Create Alarm';
        $data['sensors'] = SensorSetting::with('location')->get();
        return view('alarms.create', $data);
    }

    public function store(Request $request)
    {
        AlarmSetting::create($request->all());
        return redirect()->route('alarm_settings.index')->with('success', 'Alarm created successfully');
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Alarm';
        $data['alarm'] = AlarmSetting::findOrFail($id);
        $data['sensors'] = SensorSetting::with('location')->get();
        return view('alarms.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $alarm = AlarmSetting::findOrFail($id);
        $alarm->update($request->all());
        return redirect()->route('alarm_settings.index')->with('success', 'Alarm updated successfully');
    }

    public function destroy($id)
    {
        $alarm = AlarmSetting::findOrFail($id);
        $alarm->delete();
        return redirect()->route('alarm_settings.index')->with('success', 'Alarm deleted successfully');
    }

    public function alarmHistory()
    {
        $data['page_title'] = 'Alarm History';
        $data['alarms'] = AlarmLog::orderBy('created_at', 'desc')->get();
        return view('alarms.alarm-log', $data);
    }

    // --- API METHODS ---
    public function getActiveAlarms()
    {
        $activeAlarms = AlarmSetting::where('status', 1)
            ->with('sensorSetting.location')
            ->get()
            ->map(function ($alarm) {
                if ($alarm->sensorSetting && $alarm->sensorSetting->location) {
                    return [
                        'id' => $alarm->id,
                        'location_name' => $alarm->sensorSetting->location->name,
                        'sensor_name' => $alarm->sensorSetting->display_name ?? $alarm->sensorSetting->sensor_name,
                        'operator' => $alarm->operator,
                        'threshold' => (float)$alarm->threshold,
                        'message' => $alarm->message,
                    ];
                }
                return null;
            })
            ->filter();

        return response()->json($activeAlarms->values());
    }

    public function logTriggeredAlarm(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string',
            'sensor_name' => 'required|string',
            'value' => 'required|string',
            'message' => 'required|string',
        ]);
        $log = AlarmLog::create($validated);
        return response()->json(['message' => 'Alarm successfully logged!','data' => $log], 201);
    }
}
