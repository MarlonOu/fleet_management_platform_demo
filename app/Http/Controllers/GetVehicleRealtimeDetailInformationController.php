<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetVehicleRealtimeDetailInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index(Request $request)
    {

        $form = $request->all();
        $user = auth()->user();
        $id = $user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];

        $driver_number = array_values($form)[0];
        $driver_name = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $driver_number)->pluck('driver_name')[0];
        $vehicle_number = DB::table($tax_id . '_vehicle_realtime_information')->where('driver_number', '=', $driver_number)->pluck('vehicle_number')[0];
        $licence_plate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicle_number)->pluck('licence_plate')[0];
        $emission_standards = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicle_number)->pluck('emission_standards')[0];
        $speed = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number)->pluck('speed')[0];
        $engine_speed = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number)->pluck('engine_speed')[0];
        $instant_fuel = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number)->pluck('instant_fuel')[0];
        $odo_mileage = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number)->pluck('odo_mileage')[0];
        $task_start_mileage = DB::table($tax_id . '_vehicle_attendance_record')->where('vehicle_number', '=', $vehicle_number)->pluck('task_start_mileage')[0];
        $milage = $odo_mileage - $task_start_mileage;
        $realtime_time = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number)->pluck('date_time')[0];
        $task_start_time = DB::table($tax_id . '_vehicle_attendance_record')->where('vehicle_number', '=', $vehicle_number)->pluck('task_start_time')[0];
        $time = $realtime_time - $task_start_time;
        $task_overtime = '';
        if (($time/3600) < 8) 
            $task_overtime = '無超時駕駛';
        else{
            //$task_overtime = '超時駕駛'.date('Y-m-d H:i:s', ($time));
            $day = floor($time / (3600*24));
            $second = $time % (3600*24);
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $task_overtime = '已超時駕駛'.$day.'天'.$hour.'小時'.$minute.'分鐘'.$second.'秒';
        }
        
        // $datas = DB::table($tax_id[0].'_vehicle_realtime_information')->get();
        //return response()->json($datas);
        $vehicalRealtimeDetailInformation = array(
            'driver_name' => $driver_name,  
            'licence_plate' => $licence_plate,
            'speed' => $speed, 
            'milage' => $milage,
            'time' => $time,
            'task_overtime' => $task_overtime,
            'engine_speed' => $engine_speed,
            'odo_mileage' => $odo_mileage,
            'instant_fuel' => $instant_fuel
          ); 
        return response()->json($vehicalRealtimeDetailInformation);
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
        //
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
