<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\City;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = $this->formatServices(Service::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['services' => $services], 200);
    }

    private function formatServices($services, $lang){
        $services_array = [];

        foreach($services as $service){
            $service_array = [
                'id' => $service->id,
                'name' => $service->getTranslation('name', $lang),
                'description' => $service->getTranslation('description', $lang),
                'image' => url($service->image),
            ];

            array_push($services_array, $service_array);
        }

        return $services_array;
    }

    public function applyCoupon(Request $request){
        $Validated = Validator::make($request->all(), [
            'coupon'      => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $coupon_details = [];
        $coupon = Coupon::where('coupon', $request->coupon)->first();
        if(isset($coupon) && $coupon!=null){
            $coupon_details = [
                'id' => $coupon->id,
                'coupon' => $coupon->coupon,
                'discount' => $coupon->discount,
                'oil' => $this->getCouponOil($request->coupon, app()->getLocale()),
            ];
        }else{
            return response()->json(['messaage' => trans('api.coupon_not_found')], 403);
        }

        return response()->json(['coupon' => $coupon_details], 403);
    }

    private function getCouponOil($coupon, $lang){
        $oil = [];

        $coupons = Coupon::where('coupon', $coupon)->get();
        foreach($coupons as $coupon){
            array_push($oil, [
                'id' => $coupon->oil->id,
                'name' => $coupon->oil->getTranslation('name', $lang),
            ]);
        }

        return $oil;
    }
}