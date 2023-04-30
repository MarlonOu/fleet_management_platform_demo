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
        $carRealtimeData = str_replace('\'', '"', $terminalDataList[sizeof($terminalDataList)-2]);
        $carRealtimeData = json_decode($carRealtimeData, true);

        DB::table($taxid.'_obdii_vehicle_realtime_information')
            ->where('vehicle_number', $vehicleNumber)
            ->update([
                'altitude' => $carRealtimeData['altitude'],
                'latitude' => $carRealtimeData['latitude'],
                'longitude' => $carRealtimeData['longitude'],
                'date_time' => $carRealtimeData['date_time'],
                'can_date_time' => $carRealtimeData['can_date_time'],
                'speed' => $carRealtimeData['speed'],
                'engine_speed' => $carRealtimeData['engine_speed'],
                'oxygen_sensor' => $carRealtimeData['oxygen_sensor'],
                'short_fuel' => $carRealtimeData['short_fuel'],
                'fuel_rate' => $carRealtimeData['fuel_rate'],
                'mass_air_flow' => $carRealtimeData['mass_air_flow'],
                'air_fuel_ratio' => $carRealtimeData['air_fuel_ratio'],
            ]);
        $query = [['vehicle_number', $vehicleNumber], ['task_status', 0]];
        $workingTaskNumber = DB::table($taxid . '_obdii_vehicle_attendance_record')->where($query)->pluck('task_number');

        if (sizeof($workingTaskNumber) != 0){
            for ($i=2; $i<sizeof($terminalDataList)-1; $i++){
                $carData = str_replace('\'', '"', $terminalDataList[$i]);
                $carData = json_decode($carData, true);                
                $vehicleStatus = '4';//offline
                if ($carData['engine_speed'] != '0')
                    $vehicleStatus = '1';//driving
                else if ($carData['engine_speed'] == '0')
                    $vehicleStatus = '0';//flameout
                DB::table($taxid.'_obdii_vehicle_history_'.$vehicleNumber)
                    ->insert([
                        'task_number' => $workingTaskNumber[0],
                        'altitude' => $carData['altitude'],
                        'latitude' => $carData['latitude'],
                        'longitude' => $carData['longitude'],
                        'date_time' => $carData['date_time'],
                        'can_date_time' => $carData['can_date_time'],
                        'speed' => $carData['speed'],
                        'engine_speed' => $carData['engine_speed'],
                        'oxygen_sensor' => $carData['oxygen_sensor'],
                        'short_fuel' => $carData['short_fuel'],
                        'fuel_rate' => $carData['fuel_rate'],
                        'mass_air_flow' => $carData['mass_air_flow'],
                        'air_fuel_ratio' => $carData['air_fuel_ratio'],
                        'vehicle_status' => $vehicleStatus,
                    ]);
            }
            
        }
        

        // return response()->json($carRealtimeData);
        return 200;
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
