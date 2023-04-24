<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Post extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "zxc";
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
        $form = $request->all();
        DB::table('posts')->insert(['integer' => $form['integer']]);
        return response ()->json($form);
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
    public function update(Request $request, string $vehicle_number)
    {
        $terminalData = $request->all();
        $terminalDataList = explode(";", $terminalData['data']);
        $taxid = $terminalDataList[0];
        $carRealtimeData = str_replace('\'', '"', $terminalDataList[3]);
        $carRealtimeData = json_decode($carRealtimeData, true);


        DB::table($taxid.'_vehicle_realtime_information')
        ->where('vehicle_number', $vehicle_number)
        ->update([
            'altitude' => $carRealtimeData['altitude'],
            'latitude' => $carRealtimeData['latitude'],
            'longitude' => $carRealtimeData['longitude'],
            'date_time' => $carRealtimeData['date_time'],
            'speed' => $carRealtimeData['speed'],
            'engine_speed' => $carRealtimeData['engine_speed'],
            'app1' => $carRealtimeData['app1'],
            'bpp' => $carRealtimeData['bpp'],
            'torque' => $carRealtimeData['torque'],
            'instant_fuel' => $carRealtimeData['instant_fuel'],
            'average_fuel' => $carRealtimeData['average_fuel'],
            'odo_mileage' => $carRealtimeData['odo_mileage'],
            'idle_hours' => $carRealtimeData['idle_hours'],
            'idle_fuel' => $carRealtimeData['idle_fuel'],
            'brake_state' => $carRealtimeData['brake_state'],
            'ap1_lis' => $carRealtimeData['ap1_lis']
            ]);

        return response()->json($carRealtimeData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
