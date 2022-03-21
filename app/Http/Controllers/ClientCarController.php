<?php

namespace App\Http\Controllers;

use App\Models\ClientCar;
use App\Models\Client;
use App\Models\CarModel;
use App\Models\CarCylinder;
use Illuminate\Http\Request;
use Validator;

class ClientCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->get_privilege();
    }

    public function index()
    {
        $client_cars = ClientCar::latest()->get();
        return view('client_car.index', compact('client_cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client_car = null;
        $clients = Client::all();
        $models = CarModel::all();
        $cylinders = CarCylinder::all();

        return view('client_car.form', compact('client_car', 'clients', 'models', 'cylinders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'model_id' => 'required',
            'cylinder_id' => 'required',
            'manufacture_year' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ClientCar::create($request->all());

        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/client_car');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client_car = ClientCar::findOrFail($id);
        return view('client_car.show', compact('client_car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client_car = ClientCar::findOrFail($id);
        $clients = Client::all();
        $models = CarModel::all();
        $cylinders = CarCylinder::all();
        return view('client_car.form', compact('client_car', 'clients', 'models', 'cylinders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'model_id' => 'required',
            'cylinder_id' => 'required',
            'manufacture_year' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $client_car = new ClientCar();
        $client_car->fill($request);
        $client_car->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/client_car');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client_car = ClientCar::find($id);
        $client_car->delete();

        return redirect()->back();
    }
}
