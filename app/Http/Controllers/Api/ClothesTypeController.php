<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothesType;
use App\Models\Service;
use Illuminate\Http\Request;
use Validator;

class ClothesTypeController extends Controller
{
    public function index($service_id)
    {   
        $clothes_types = [];
        $service = Service::where('id', $service_id)->first();

        if(isset($service) && $service!=null){
            $clothes_types = $this->formatClothesTypes($service->clothesTypes()->get(), app()->getLocale());
        }

        return response()->json(['clothes_types' => $clothes_types], 200);
    }

    private function formatClothesTypes($clothes_types, $lang){
        $clothes_types_array = [];

        foreach($clothes_types as $clothes_type){
            $clothes_type_array = [
                'id' => $clothes_type->id,
                'name' => $clothes_type->getTranslation('name', $lang),
                'description' => $clothes_type->getTranslation('description', $lang),
                'image' => url($clothes_type->image),
            ];

            array_push($clothes_types_array, $clothes_type_array);
        }

        return $clothes_types_array;
    }
}