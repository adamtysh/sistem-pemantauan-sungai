<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'Titik Lokasi';
        $data['locations'] = Location::get();
        return view('settings.locations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Titik Lokasi';
        return view('settings.locations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData =  $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $location = new Location();
            $location->name = $validateData['name'];
            $location->save();

            return redirect()->route('locations.index')->with('success', 'Location created successfully.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('locations.index')->with('error', 'Error creating location.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $data['page_title'] = 'Titik Lokasi';
        $data['location'] = $location;
        return view('settings.locations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
       $validateData =  $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $location->name = $validateData['name'];
            $location->save();

            return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('locations.index')->with('error', 'Error updating location.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try {
            $location->delete();
            return redirect()->route('locations.index')
                             ->with('success', 'Location deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('locations.index')
                             ->with('error', 'Failed to delete location: ' . $e->getMessage());
        }
    }
}
