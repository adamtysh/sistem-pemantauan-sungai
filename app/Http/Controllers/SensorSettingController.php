<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorSetting;
use App\Models\Location;

class SensorSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'Pengaturan Sensor';
        $data['sensor_settings'] = SensorSetting::get();
        return view('settings.sensors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Pengaturan Sensor';
        $data['locations'] = Location::get();
        return view('settings.sensors.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData =  $request->validate([
            'sensor_name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'location_id' => ['required', 'integer'],
            'unit' => ['nullable', 'string', 'max:50'],
        ]);

        try {
            $sensor = new SensorSetting();
            $sensor->sensor_name = $validateData['sensor_name'];
            $sensor->location_id = $validateData['location_id'];
            $sensor->unit = $validateData['unit'];
            $sensor->status = $validateData['status'];
            $sensor->save();

            return redirect()->route('sensor_settings.index')->with('success', 'Sensor created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('sensor_settings.index')->with('error', 'Error creating sensor.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title'] = 'Pengaturan Sensor';
        $data['sensor_setting'] = SensorSetting::findOrFail($id);
        $data['locations'] = Location::get();
        return view('settings.sensors.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData =  $request->validate([
            'sensor_name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'location_id' => ['required', 'integer'],
            'unit' => ['nullable', 'string', 'max:50'],
        ]);

        try {
            $sensor = SensorSetting::findOrFail($id);
            $sensor->sensor_name = $validateData['sensor_name'];
            $sensor->location_id = $validateData['location_id'];
            $sensor->unit = $validateData['unit'];
            $sensor->status = $validateData['status'];
            $sensor->save();

            return redirect()->route('sensor_settings.index')->with('success', 'Sensor updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('sensor_settings.index')->with('error', 'Error updating sensor.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sensor = SensorSetting::findOrFail($id);
            $sensor->delete();

            return redirect()->route('sensor_settings.index')->with('success', 'Sensor deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('sensor_settings.index')->with('error', 'Error deleting sensor.');
        }
    }
}
