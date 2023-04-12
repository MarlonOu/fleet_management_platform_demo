<?php

namespace App\Http\Controllers;

use App\Models\Diver_information_123;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "hello";
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
        $aa = '123';
        DB::table($aa . '_driver_information')->insert(['employ_id' => $form['employ_id'],
            'driver_name' => $form['driver_name'],
            'driver_number' => $form['driver_number'],
            'sex' => $form['sex'],
            'birthday' => $form['birthday'],
            'tel' => $form['tel'],
            'address' => $form['address']]);
        return response()->json($form);


//
//        $form = $request->all();
//        $diver_information_123 = new Diver_information_123;
//        $diver_information_123->driver_name = $request->driver_name;
//        $diver_information_123->employ_id = $request->employ_id;
//        $diver_information_123->driver_number = $request->driver_number;
//        $diver_information_123->sex = $request->sex;
//        $diver_information_123->birthday = $request->birthday;
//        $diver_information_123->tel = $request->tel;
//        $diver_information_123->address = $request->address;
//        $diver_information_123->save();
//        //DB::table('123_driver_information')->insert(['employ_id' => $form['employ_id']]);
//        //DB::table('123_driver_information')->insert(['driver_name' => $form['driver_name']]);
//        return response ()->json($request);
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
        $form = $request->all();


        $aa = '123';
        DB::table($aa . '_driver_information')->where('id', $id)->update(['employ_id' => $form['employ_id'],
            'driver_name' => $form['driver_name'],
            'driver_number' => $form['driver_number'],
            'sex' => $form['sex'],
            'birthday' => $form['birthday'],
            'tel' => $form['tel'],
            'address' => $form['address']]);
        return response()->json($form);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
