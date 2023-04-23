<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetAttendanceDetailController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $id = $user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
        $taskData = DB::table($tax_id.'_vehicle_attendance_record')->where('task_status', '=', '1')->get();
        $taskInformation = array();
        for ($i=0; $i<sizeof($taskData); $i++){          
            $driverNumber = $taskData[$i]->driver_number;
            $driverName = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $driverNumber)->pluck('driver_name')[0];
            $vehicleNumber = $taskData[$i]->vehicle_number;
            $licencePlate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('licence_plate')[0];
            $time = $taskData[$i]->task_end_time - $taskData[$i]->task_start_time;
            $day = floor($time / (3600 * 24));
            $second = $time % (3600 * 24);
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $time = $day . '天' . $hour . '小時' . $minute . '分鐘' . $second . '秒';

            array_push($taskInformation, array(
                'task_number'=> $taskData[$i]->task_number,
                'licence_plate'=> $licencePlate,
                'driver_name'=> $driverName,
                'task_start_time'=> date('Y-m-d H:i:s', $taskData[$i]->task_start_time),
                'task_end_time'=> date('Y-m-d H:i:s', $taskData[$i]->task_end_time),
                'time'=> $time,
            ));
        }
        
        return response()->json($taskInformation);
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
