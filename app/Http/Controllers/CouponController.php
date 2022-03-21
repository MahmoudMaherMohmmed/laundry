<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Oil;
use Illuminate\Http\Request;
use Validator;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupon = null;
        $oils = Oil::all();

        return view('coupon.form', compact('coupon', 'oils'));
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
            'oil_ids' => 'required|array',
            'coupon' => 'required',
            'discount' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($request->oil_ids as $oil_id){
            $coupon = new Coupon();
            $coupon->fill(array_merge($request->all(), ['oil_id' => $oil_id]));
            $coupon->save();
        }

        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/coupon');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('coupon.index', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $oils = Oil::all();
        return view('coupon.form', compact('coupon', 'oils'));
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
            'oil_ids' => 'required|array',
            'coupon' => 'required',
            'discount' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($request->oil_ids as $oil_id){
            $coupon = Coupon::findOrFail($id);
            $coupon->fill(array_merge($request->all(), ['oil_id' => $oil_id]));
            $coupon->save();
        }

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();

        return redirect()->back();
    }
}
