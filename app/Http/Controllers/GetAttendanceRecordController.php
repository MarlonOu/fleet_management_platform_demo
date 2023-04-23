<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetAttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $user = auth()->user();
        $id = $user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
        $taskData = DB::table($tax_id.'_vehicle_attendance_record')->where('task_status', '=', '1')->pluck('vehicle_number');
        $taskData = array_unique(json_decode($taskData));
        $licencePlateList = array();
        for ($i=0; $i<sizeof($taskData); $i++){          
            $vehicleNumber = $taskData[$i];
            $licencePlate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('licence_plate')[0];
            array_push($licencePlateList, $licencePlate);
        }        
        return response()->json($licencePlateList);
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
    public function show(string $licencePlate)
    {
        $user = auth()->user();
        $id = $user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
        $vehicleNumber = DB::table($tax_id . '_commercial_vehicle_specification')->where('licence_plate', '=', $licencePlate)->pluck('vehicle_number')[0];
        $taskData = DB::table($tax_id.'_vehicle_attendance_record')->where('vehicle_number', '=', $vehicleNumber)->pluck('driver_number');
        $taskData = array_unique(json_decode($taskData));
        $driverNameList = array();
        for ($i=0; $i<sizeof($taskData); $i++){          
            $driverNumber = $taskData[$i];
            $driverName = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $driverNumber)->pluck('driver_name')[0];
            array_push($driverNameList, $driverName);
        }  
        
        return response()->json($driverNameList);
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
