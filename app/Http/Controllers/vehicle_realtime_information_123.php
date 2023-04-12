<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vehicle_realtime_information_123 extends Controller
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
        $form = $request->all();
        $terminalDataList = explode(",", $form);
        $taxid = $terminalDataList[0];
        DB::table($taxid.'_vehicle_realtime_information')->insert(['altitude' => $form['altitude'],
            'latitude' => $form['latitude'],
            'longitude' => $form['longitude'],
            'can_date_time' => $form['can_date_time'],
            'speed' => $form['speed'],
            'engine_speed' => $form['engine_speed'],
            'app1' => $form['app1'],
            'bpp' => $form['bpp'],
            'torque' => $form['torque'],
            'instant_fuel' => $form['instant_fuel'],
            'average_fuel' => $form['average_fuel'],
            'odo_mileage' => $form['odo_mileage'],
            'idle_hours' => $form['idle_hours'],
            'idle_fuel' => $form['idle_fuel'],
            'brake_state' => $form['brake_state'],
            'ap1_lis' => $form['ap1_lis'],
            ]);
        return response()->json($form);
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
