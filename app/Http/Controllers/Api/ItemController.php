<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Validator;

class ItemController extends Controller
{
    public function index($service_id, $clothes_type_id)
    {   
        $items = $this->formatItems(Item::where(['service_id' => $service_id, 'clothes_type_id' => $clothes_type_id])->get(), app()->getLocale());

        return response()->json(['items' => $items], 200);
    }

    private function formatItems($items, $lang){
        $items_array = [];

        foreach($items as $item){
            $item_array = [
                'id' => $item->id,
                'name' => $item->getTranslation('name', $lang),
                'description' => $item->getTranslation('description', $lang),
                'price' => $item->price,
                'image' => url($item->image),
            ];

            array_push($items_array, $item_array);
        }

        return $items_array;
    }
}