<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AllVehicleInformationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $id = $user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
        
        $realtimeData = DB::table($tax_id.'_vehicle_realtime_information')->get();
        $workVehicleNumber = array();     
        $workVehicleDriverNumber = array();   
        $workVehicleData = array();
        for ($i=0; $i<sizeof($realtimeData); $i++){
            if ($realtimeData[$i]->vehicle_status == 1)
                array_push($workVehicleNumber, $realtimeData[$i]->vehicle_number);
                array_push($workVehicleDriverNumber, $realtimeData[$i]->driver_number);
                array_push($workVehicleData, $realtimeData[$i]);
        }
        for ($i=0; $i<sizeof($workVehicleNumber); $i++){
            $driverName = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $workVehicleDriverNumber[$i])->pluck('driver_name')[0];
            $licencePlate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('licence_plate')[0];
            $emissionStandards = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('emission_standards')[0];
            $odoMileage = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('odo_mileage')[0];
            $taskStartMileage = DB::table($tax_id . '_vehicle_attendance_record')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('task_start_mileage')[0];
            $milage = round($odoMileage - $taskStartMileage, 3);
            $realtimeTime = DB::table($tax_id . '_vehicle_realtime_information')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('date_time')[0];
            $taskStartTime = DB::table($tax_id . '_vehicle_attendance_record')->where('vehicle_number', '=', $workVehicleNumber[$i])->pluck('task_start_time')[0];
            $time = $realtimeTime - $taskStartTime;
            $taskOvertime = '';
            if (($time / 3600) < 8)
                $taskOvertime = '無超時駕駛';
            else {
                //$task_overtime = '超時駕駛'.date('Y-m-d H:i:s', ($time));
                $taskOvertime = $time - (3600*8);
                $day = floor($taskOvertime / (3600 * 24));
                $second = $taskOvertime % (3600 * 24);
                $hour = floor($second / 3600);
                $second = $second % 3600;
                $minute = floor($second / 60);
                $second = $second % 60;
                $taskOvertime = '已超時行駛' . $day . '天' . $hour . '小時' . $minute . '分鐘' . $second . '秒';
            }
            $day = floor($time / (3600 * 24));
            $second = $time % (3600 * 24);
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $time = $day . '天' . $hour . '小時' . $minute . '分鐘' . $second . '秒';

            $workVehicleData[$i]->lng = $workVehicleData[$i]->longitude;  
            $workVehicleData[$i]->lat = $workVehicleData[$i]->latitude;  
            $workVehicleData[$i]->date_time = date('Y-m-d H:i:s',  $workVehicleData[$i]->date_time);  
            $workVehicleData[$i]->driver_name = $driverName;
            $workVehicleData[$i]->licence_plate = $licencePlate;
            $workVehicleData[$i]->emission_standards = $emissionStandards;
            $workVehicleData[$i]->milage = $milage;
            $workVehicleData[$i]->time = $time;
            $workVehicleData[$i]->task_overtime = $taskOvertime;
            $workVehicleData[$i]->licence_plate = $licencePlate;
            $workVehicleData[$i]->licence_plate = $licencePlate;
        }

        return $workVehicleData;
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
