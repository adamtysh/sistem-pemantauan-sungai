<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlarmLog;
use App\Models\AlarmSetting;
use App\Models\Location;
use App\Models\SensorSetting;

class AlarmController extends Controller
{

    public function index()
    {
        $data['page_title'] = 'Alarm Settings';
        $data['alarms'] = AlarmSetting::with('location', 'sensorSetting')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('alarms.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Alarm';
        $data['locations'] = Location::all();
        $data['sensors'] = SensorSetting::all();
        return view('alarms.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Alarm';
        $data['alarm'] = AlarmSetting::findOrFail($id);
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
    public function store(Request $request)
    {
        $alarm = AlarmSetting::create($request->all());
        
        return redirect()->route('alarm_settings.index')->with('success', 'Alarm created successfully');
    }
    public function destroyAlarm($id)
    {
        $alarm = AlarmSetting::findOrFail($id);
        $alarm->delete();

        return response()->json([
            'message' => 'Alarm deleted successfully',
        ], 200);
    }

    public function alarmHistory()
    {
        $data['page_title'] = 'Alarm History';
        $data['alarms'] = AlarmLog::orderBy('created_at', 'desc')->get();
        return view('alarms.alarm-log', $data);
    }

    // ==========================================================
    // ▼▼▼ KODE BARU DIMULAI DARI SINI ▼▼▼
    // ==========================================================

    public function getActiveAlarms()
    {
        $activeAlarms = AlarmSetting::where('status', 1)
            ->with('sensorSetting.location')
            ->get()
            ->map(function ($alarm) {
                return [
                    'id' => $alarm->id,
                    'location_name' => $alarm->sensorSetting->location->name ?? 'N/A',
                    'sensor_name' => $alarm->sensorSetting->sensor_name ?? 'N/A',
                    'operator' => $alarm->operator,
                    'threshold' => (float)$alarm->threshold,
                    'message' => $alarm->message,
                ];
            });

        return response()->json($activeAlarms);
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

        return response()->json([
            'message' => 'Alarm successfully logged!',
            'data' => $log
        ], 201);
    }
    // ==========================================================
    // ▲▲▲ BATAS AKHIR KODE BARU ▲▲▲
    // ==========================================================
}