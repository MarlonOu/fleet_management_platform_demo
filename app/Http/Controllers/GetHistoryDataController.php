<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class GetHistoryDataController extends Controller
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
    public function show(string $taskNumber)
    {
        $user = auth()->user();
        $vehicle_type = $user['vehicle_type'];
        
        function truck($taskNumber){
            $user = auth()->user();
            $id = $user['id'];
            $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
            $taskData = DB::table($tax_id.'_vehicle_attendance_record')->where('task_number', '=', $taskNumber)->get()[0];
            $vehicleNumber = $taskData->vehicle_number;
            $historyData = DB::table($tax_id.'_vehicle_history_'.$vehicleNumber)->get();
            $co2Emission = $taskData->co2_emission;
            $mileage = round($taskData->task_end_mileage - $taskData->task_start_mileage, 2);
            if ($co2Emission == null){
                $instantFuelSum = 0;
                for ($i=0; $i<sizeof($historyData); $i++)
                    $instantFuelSum += $historyData[$i]->instant_fuel;
                //平均油耗 instantFuelAverage km/L
                $instantFuelAverage = $instantFuelSum / sizeof($historyData);
                //Mileage during driving (最後一筆ODO - 第一筆ODO)   mileage km
                $mileage = $historyData[sizeof($historyData)-1]->odo_mileage - $historyData[0]->odo_mileage;
                //耗油量 mileage-instantFuelAverage = FuelConsumption L
                $fuelConsumption = $mileage / $instantFuelAverage;
                //消耗柴油重量 FuelConsumption * 柴油密度0.85 =  dieselWeight kg
                $dieselWeight = $fuelConsumption * 0.85;
                //CO2 dieselWeight * 3.16 kg/kg fuel = co2 kg
                $co2Emission = round(($dieselWeight * 3.16), 2);
                DB::table($tax_id.'_vehicle_attendance_record')
                    ->where('vehicle_number', $vehicleNumber)
                    ->update([
                        'co2_emission' => $co2Emission
                        ]);
            }
            $driverNumber = $taskData->driver_number;
            $driverName = DB::table($tax_id . '_driver_information')->where('driver_number', '=', $driverNumber)->pluck('driver_name')[0];
            $licencePlate = DB::table($tax_id . '_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('licence_plate')[0];
            $taskStartTime = $taskData->task_start_time;
            $taskEndTime = $taskData->task_end_time;
            $time = $taskEndTime - $taskStartTime;
            $day = floor($time / (3600 * 24));
            $second = $time % (3600 * 24);
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $time = $day . '天' . $hour . '小時' . $minute . '分鐘' . $second . '秒';
            $taskStartTime = date('Y-m-d H:i:s',  $taskStartTime);
            $taskEndTime = date('Y-m-d H:i:s',  $taskEndTime);
    
            $dateTimeList = array();
            $speedList = array();
            $engineSpeedList = array();
            $instantFuelList = array();
            $averageFuelList = array();
            $odoMileageList = array();
            $idleHoursList = array();
            $idleFuelList = array();
            for ($i=0; $i<sizeof($historyData); $i++){
                array_push($dateTimeList, date('Y-m-d H:i:s',  $historyData[$i]->date_time+(3600*8)));
                array_push($speedList, (float)$historyData[$i]->speed);
                array_push($engineSpeedList, (float)$historyData[$i]->engine_speed);
                array_push($instantFuelList, (float)$historyData[$i]->instant_fuel);
                array_push($averageFuelList, (float)$historyData[$i]->average_fuel);
                array_push($odoMileageList, (float)$historyData[$i]->odo_mileage);
                array_push($idleHoursList, (float)$historyData[$i]->idle_hours);
                array_push($idleFuelList, (float)$historyData[$i]->idle_fuel);
            }
    
            $esgData = array(
                'tax_id'=> $tax_id,
                'licence_plate'=> $licencePlate,
                'driver_name'=> $driverName,
                'task_start_sime'=> $taskStartTime,
                'task_end_time'=> $taskEndTime,
                'time'=> $time,
                'mileage'=> $mileage . ' km',
                'co2_emission'=> $co2Emission . ' kg',
                'speedThreshold'=> 115,
                'engineThreshold'=> 2500,
                'date_time'=> $dateTimeList,
                'speed'=> $speedList,
                'engine_speed'=> $engineSpeedList,
                'instant_fuel'=> $instantFuelList,
                'average_fuel'=> $averageFuelList,
                'odo_mileage'=> $odoMileageList,
                'idle_hours'=> $idleHoursList,
                'idle_fuel'=> $idleFuelList,
            );
            return response()->json($esgData);
        }

        function vehicle($taskNumber){
            $user = auth()->user();
            $id = $user['id'];
            $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id')[0];
            $taskData = DB::table($tax_id.'_obdii_vehicle_attendance_record')->where('task_number', '=', $taskNumber)->get()[0];
            $vehicleNumber = $taskData->vehicle_number;
            $historyData = DB::table($tax_id.'_obdii_vehicle_history_'.$vehicleNumber)->where('task_number', '=', $taskNumber)->get();
            $co2Emission = $taskData->co2_emission;
            // if ($co2Emission == null){
            //     $instantFuelSum = 0;
            //     for ($i=0; $i<sizeof($historyData); $i++)
            //         $instantFuelSum += $historyData[$i]->instant_fuel;
            //     //平均油耗 instantFuelAverage km/L
            //     $instantFuelAverage = $instantFuelSum / sizeof($historyData);
            //     //Mileage during driving (最後一筆ODO - 第一筆ODO)   mileage km
            //     $mileage = $historyData[sizeof($historyData)-1]->odo_mileage - $historyData[0]->odo_mileage;
            //     //耗油量 mileage-instantFuelAverage = FuelConsumption L
            //     $fuelConsumption = $mileage / $instantFuelAverage;
            //     //消耗柴油重量 FuelConsumption * 柴油密度0.85 =  dieselWeight kg
            //     $dieselWeight = $fuelConsumption * 0.85;
            //     //CO2 dieselWeight * 3.16 kg/kg fuel = co2 kg
            //     $co2Emission = round(($dieselWeight * 3.16), 2);
            //     DB::table($tax_id.'_vehicle_attendance_record')
            //         ->where('vehicle_number', $vehicleNumber)
            //         ->update([
            //             'co2_emission' => $co2Emission
            //             ]);
            // }
            $driverNumber = $taskData->driver_number;
            $driverName = DB::table($tax_id . '_obdii_driver_information')->where('driver_number', '=', $driverNumber)->pluck('driver_name')[0];
            $licencePlate = DB::table($tax_id . '_obdii_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('licence_plate')[0];
            $vehicleBrand = DB::table($tax_id . '_obdii_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('vehicle_brand')[0];
            $vehicleModel = DB::table($tax_id . '_obdii_commercial_vehicle_specification')->where('vehicle_number', '=', $vehicleNumber)->pluck('vehicle_model')[0];
            $taskStartTime = $taskData->task_start_time;
            $taskEndTime = $taskData->task_end_time;
            $time = $taskEndTime - $taskStartTime;
            $day = floor($time / (3600 * 24));
            $second = $time % (3600 * 24);
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $time = $day . '天' . $hour . '小時' . $minute . '分鐘' . $second . '秒';
            $taskStartTime = date('Y-m-d H:i:s',  $taskStartTime);
            $taskEndTime = date('Y-m-d H:i:s',  $taskEndTime);
    
            $dateTimeList = array();
            $speedList = array();
            $engineSpeedList = array();
            $oxygenSensorList = array();
            $shortFuelList = array();
            $fuelRateList = array();
            $massAirFlowList = array();
            $airFuelRatioList = array();
            for ($i=0; $i<sizeof($historyData); $i++){
                array_push($dateTimeList, date('Y-m-d H:i:s',  $historyData[$i]->date_time+(3600*8)));
                array_push($speedList, (float)$historyData[$i]->speed);
                array_push($engineSpeedList, (float)$historyData[$i]->engine_speed);
                array_push($oxygenSensorList, (float)$historyData[$i]->oxygen_sensor);
                array_push($shortFuelList, (float)$historyData[$i]->short_fuel);
                array_push($fuelRateList, (float)$historyData[$i]->fuel_rate);
                array_push($massAirFlowList, (float)$historyData[$i]->mass_air_flow);
                array_push($airFuelRatioList, (float)(explode(":", $historyData[$i]->air_fuel_ratio)[0]));
            }
    
            $esgData = array(
                'tax_id'=> $tax_id,
                'licence_plate'=> $licencePlate,
                'vehicle_brand'=> $vehicleBrand,
                'vehicle_model'=> $vehicleModel,
                'driver_name'=> $driverName,
                'task_start_sime'=> $taskStartTime,
                'task_end_time'=> $taskEndTime,
                'time'=> $time,
                'co2_emission'=> $co2Emission . ' kg',
                'speedThreshold'=> 115,
                'engineThreshold'=> 7000,
                'date_time'=> $dateTimeList,
                'speed'=> $speedList,
                'engine_speed'=> $engineSpeedList,
                'oxygen_sensor'=> $oxygenSensorList,
                'short_fuel'=> $shortFuelList,
                'fuel_rate'=> $fuelRateList,
                'mass_air_flow'=> $massAirFlowList,
                'air_fuel_ratio'=> $airFuelRatioList,
            );
            return response()->json($esgData);
        }

        if ($vehicle_type == '1') 
            return vehicle($taskNumber);
        else 
            return truck($taskNumber);
        
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
