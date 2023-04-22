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
        $taskData = DB::table($tax_id.'_vehicle_attendance_record')->where('task_status', '=', '1')->get();
        for ($i=0; $i<sizeof($taskData); $i++){        
            $driverNumber = $taskData[$i]->driver_number;
            $driverName = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $driverNumber)->pluck('driver_name')[0];
            $vehicleNumber = $taskData[$i]->vehicle_number;
            $licencePlate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('licence_plate')[0];
            $taskData[$i]->driver_name = $driverName;
            $taskData[$i]->licence_plate = $licencePlate;            
        }
        
        return response()->json($taskData);
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
