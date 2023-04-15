<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetVehicleRealInformationDetail extends Controller
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
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id');

        $driver_number = array_values($form);
        $driver_name = DB::table($tax_id[0] . '_driver_information')->where('driver_number', '=', $driver_number[0])->pluck('driver_name');
        $vehicle_number = DB::table($tax_id[0] . '_vehicle_realtime_information')->where('driver_number', '=', $driver_number[0])->pluck('vehicle_number');
        $licence_plate = DB::table($tax_id[0] . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicle_number[0])->pluck('licence_plate');
        $emission_standards = DB::table($tax_id[0] . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicle_number[0])->pluck('emission_standards');
        $mileage1 = DB::table($tax_id[0] . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number[0])->pluck('odo_mileage');
        $mileage2 = DB::table($tax_id[0] . '_vehicle_attendance_record')->where('vehicle_number', '=', $vehicle_number[0])->pluck('task_start_mileage');
        $realmileage = $mileage1[0] - $mileage2[0];
        $time1 = DB::table($tax_id[0] . '_vehicle_realtime_information')->where('vehicle_number', '=', $vehicle_number[0])->pluck('date_time');
        $time2 = DB::table($tax_id[0] . '_vehicle_attendance_record')->where('vehicle_number', '=', $vehicle_number[0])->pluck('task_start_time');
        $realtime = $time1[0]-$time2[0];
        // $datas = DB::table($tax_id[0].'_vehicle_realtime_information')->get();
        //return response()->json($datas);
        return $realtime;
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
