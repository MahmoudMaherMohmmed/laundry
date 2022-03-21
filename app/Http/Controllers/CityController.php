<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
    }

    public function index()
    {
        $cities = City::latest()->get();
        $languages = $this->languageRepository->all();
        return view('city.index', compact('cities', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = null;
        $countries = Country::all();
        $languages = $this->languageRepository->all();

        return view('city.form', compact('city', 'countries', 'languages'));
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
            'country_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $city = new City();
        $city->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $city->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $city->setTranslation('description', $key, $value) : null;
        }
        
        $city->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/city');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        return view('city.index', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        $countries = Country::all();
        $languages = $this->languageRepository->all();
        return view('city.form', compact('city', 'countries', 'languages'));
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
            'country_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $city = City::findOrFail($id);

        $city->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $city->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $city->setTranslation('description', $key, $value) : null;
        }
        
        $city->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();

        return redirect()->back();
    }
}
