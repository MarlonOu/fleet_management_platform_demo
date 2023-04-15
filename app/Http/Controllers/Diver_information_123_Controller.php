<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diver_information_123;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class Diver_information_123_Controller extends Controller
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
        return  Diver_information_123::all();
//        $user = auth()->user();
//        $id=$user['id'];
//        return $id;
//        $tax_id = DB::table('123_driver_information')->where('id', '=', $id)->pluck('tax_id');
//        $datas = DB::table($taxid.'_vehicle_realtime_information')->get();
//        var_dump($datas->employ_id);
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
        $user = auth()->user();
        $id=$user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id');

        DB::table($tax_id[0].'_driver_information')
            ->insert([
                'driver_name' => $form['driver_name'],
                'employ_id' => $form['employ_id'],
                'driver_number' => $form['driver_number'],
                'sex' => $form['sex'],
                'birthday' => $form['birthday'],
                'tel' => $form['tel'],
                'address' => $form['address'],
            ]);

        return response()->json($request);

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
//           //DB::table('123_driver_information')->insert(['employ_id' => $form['employ_id']]);
//           //DB::table('123_driver_information')->insert(['driver_name' => $form['driver_name']]);
//        return response ()->json($request);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Diver_information_123::all();
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
//        $diver_information_123 = new Diver_information_123;
//        $form =$request->all();
//        $diver_information_123 = Diver_information_123::find($id);
//        $diver_information_123->driver_name = $form['driver_name'];
//        $diver_information_123->save();
//        return response ()->json($request,$id);


        $form = $request->all();
        $user = auth()->user();
        $id=$user['id'];
        $tax_id = DB::table('users')->where('id', '=', $id)->pluck('tax_id');

        DB::table($tax_id[0].'_driver_information')
            ->where('id', $id)
            ->update([
                'driver_name' => $form['driver_name'],
                'employ_id' => $form['employ_id'],
                'driver_number' => $form['driver_number'],
                'sex' => $form['sex'],
                'birthday' => $form['birthday'],
                'tel' => $form['tel'],
                'address' => $form['address'],
            ]);

        return response()->json($request);



//        $diver_information_123  = Diver_information_123::find($id);
//        $diver_information_123->driver_name = $request->driver_name;
//        $diver_information_123->employ_id = $request->employ_id;
//        $diver_information_123->driver_number = $request->driver_number;
//        $diver_information_123->sex = $request->sex;
//        $diver_information_123->birthday = $request->birthday;
//        $diver_information_123->tel = $request->tel;
//        $diver_information_123->address = $request->address;
//        $diver_information_123->save();
//        return response($diver_information_123);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


