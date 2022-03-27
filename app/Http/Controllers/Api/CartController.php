<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {   
        $client = $request->user();
        $cart_items = $this->formatItems(Cart::where(['client_id' => $client->id])->get(), app()->getLocale());

        return response()->json(['cart' => $cart_items], 200);
    }

    private function formatItems($cart, $lang){
        $service_array = [];

        foreach($cart as $cart_item){
            $item = Item::where('id', $cart_item->item_id)->first();
            $service = $item->service()->first();

            if( !in_array($service->getTranslation('name', $lang), $service_array) ){
                array_push($service_array, $service->getTranslation('name', $lang));
            }

            $item_array = [
                'id' => $item->id,
                'name' => $item->getTranslation('name', $lang),
                'description' => $item->getTranslation('description', $lang),
                'price' => $item->price,
                'image' => url($item->image),
            ];
            dd($service_array[$service->getTranslation('name', $lang)]);

            array_push($service_array[$service->getTranslation('name', $lang)], $item_array);
        }

        return $service_array;
    }

    public function store(Request $request){
        $client = $request->user();
        $Validated = Validator::make($request->all(), [
            'item_id' => 'required',
            'units_number' => 'required|numeric',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $cart = Cart::create( array_merge($request->all(), ['client_id' => $client->id]) );
        
        return response()->json(['message' => trans('api.cart_item_added_successfully')], 200);
    }

    public function edit(Request $request, $cart_item_id){
        $Validated = Validator::make($request->all(), [
            'units_number' => 'required|numeric',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_cart = Cart::where('id', $cart_item_id)->first();
        $updated_cart->units_number = $request->units_number;
        $updated_cart->save();
        
        return response()->json(['messaage' => trans('api.cart_item_updated_successfully')], 200);
    }

    public function delete(Request $request){
        $Validated = Validator::make($request->all(), [
            'cart_item_id' => 'required'
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $cart = Cart::where('id', $request->cart_item_id)->first();
        if(isset($cart) && $cart!=null){
            $cart->delete();
            return response()->json(['message' => trans('api.cart_item_deleted_successfully')], 200);
        }

        return response()->json(['message' => trans('api.cart_item_is_not_found')], 403); 
    }
}