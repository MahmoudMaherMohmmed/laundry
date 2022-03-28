<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Validator;

class CardController extends Controller
{
    public function index(Request $request)
    {   
        $client = $request->user();
        $cards = $this->formatCards(Card::where(['client_id' => $client->id])->get(), app()->getLocale());

        return response()->json(['cards' => $cards], 200);
    }

    private function formatCards($cards, $lang){
        $cards_array = [];

        foreach($cards as $card){
            array_push($cards_array, [
                'id' => $card->id,
                'card_holder_name' => $card->card_holder_name,
                'card_number' => $card->card_number,
                'expiry_date' => $card->expiry_date,
                'cvv' => $card->cvv,
            ]);
        }

        return $cards_array;
    }

    public function store(Request $request){
        $client = $request->user();
        $Validated = Validator::make($request->all(), [
            'card_holder_name' => 'required',
            'card_number' => 'required|numeric',
            'expiry_date' => 'required',
            'cvv' => 'required|numeric',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $card = Card::create( array_merge($request->all(), ['client_id' => $client->id]) );
        
        return response()->json(['message' => trans('api.card_added_successfully')], 200);
    }

    public function edit($id, Request $request){
        $Validated = Validator::make($request->all(), [
            'card_holder_name' => 'required',
            'card_number' => 'required|numeric',
            'expiry_date' => 'required',
            'cvv' => 'required|numeric',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_card = Card::where('id', $id)->first();
        $updated_card->card_holder_name = $request->card_holder_name;
        $updated_card->card_number = $request->card_number;
        $updated_card->expiry_date = $request->expiry_date;
        $updated_card->cvv = $request->cvv;
        $updated_card->save();
        
        return response()->json(['messaage' => trans('api.card_updated_successfully')], 200);
    }

    public function delete($id, Request $request){
        $card = Card::where('id', $id)->first();
        if(isset($card) && $card!=null){
            $card->delete();
            return response()->json(['message' => trans('api.card_deleted_successfully')], 200);
        }

        return response()->json(['message' => trans('api.card_is_not_found')], 403); 
    }
}