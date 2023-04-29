<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadObdiiVehicleDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $terminalData = $request->all();
        $terminalDataList = explode(";", $terminalData['data']);
        $taxid = $terminalDataList[0];
        $vehicleNumber = $terminalDataList[1];
        $carRealtimeData = str_replace('\'', '"', $terminalDataList[4]);
        $carRealtimeData = json_decode($carRealtimeData, true);

        DB::table($taxid.'_obdii_vehicle_realtime_information')
        ->where('vehicle_number', $vehicleNumber)
        ->update([
            'altitude' => $carRealtimeData['altitude'],
            'latitude' => $carRealtimeData['latitude'],
            'longitude' => $carRealtimeData['longitude'],
            'date_time' => $carRealtimeData['date_time'],
            'speed' => $carRealtimeData['speed'],
            'engine_speed' => $carRealtimeData['engine_speed'],
            'oxygen_sensor' => $carRealtimeData['oxygen_sensor'],
            'short_fuel' => $carRealtimeData['short_fuel'],
            'fuel_rate' => $carRealtimeData['fuel_rate'],
            'mass_air_flow' => $carRealtimeData['mass_air_flow'],
            'air_fuel_ratio' => $carRealtimeData['air_fuel_ratio'],
            ]);

        return response()->json($carRealtimeData);
        // return 200;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
