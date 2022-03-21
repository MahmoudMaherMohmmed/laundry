<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Massara;
use App\Models\Term;
use App\Models\Center;
use App\Models\Country;
use App\Models\Slider;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Validator;
use Mail;
use App;

class AppController extends Controller
{
    public function laundry(Request $request){
        $center = Center::first();
        $center_info = [];

        if(isset($center) && $center!=null){
            $center_info = [
                'description' => $center->getTranslation('description', app()->getLocale()),
                'email' => $center->email,
                'contact_email' => $center->contact_email,
                "phone_1" => $center->phone_1,
                "phone_2" => $center->phone_2,
                "facebook_link" => $center->facebook_link,
                "whatsapp_link" => $center->whatsapp_link,
                "instagram_link" => $center->instagram_link,
                "lat" => $center->lat,
                "lng" => $center->lng,
                "logo" => url($center->logo),
            ];
        }

        return response()->json(['center' => $center_info], 200);
    }

    public function TermsAndConditions(Request $request){
        $term = Term::first();
        $terms_and_conditions = [];

        if(isset($term) && $term!=null){
            $terms_and_conditions = [
                'description' => $term->getTranslation('description', app()->getLocale()),
            ];
        }

        return response()->json(['terms_and_conditions' => $terms_and_conditions], 200);
    }

    public function contactMail(Request $request){
        $Validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $center = Center::first();
        if(isset($center) && $center!=null){
            $data = ['name'=>$request->name, 'subject'=>$request->subject, 'message_body'=>$request->message];
            $message = $request->message;
            Mail::send('mail', $data, function($message) use ($center, $request) {
                $message->to($center->contact_email, 'Safer')
                ->subject($request->subject)
                ->from('info@safer.com','Safer Contact Us');
             });
    
             return response()->json(['message' => trans('api.send_successfully')], 200);
        }else{
            return response()->json(['message' => trans('api.miss_configration')], 403);
        }
        
    }

    public function countries(Request $request)
    {
        $countries = Country::all();

        return response()->json(['countries' => $this->formatCountries($countries, $request->lang)], 200);
    }

    private function formatCountries($countries, $lang)
    {
        $countries_array = [];

        foreach($countries as $country){
            array_push($countries_array,[
                'id' => $country->id,
                'title' => isset($lang) && $lang!=null ? $country->getTranslation('title', $lang) : $country->title,
            ]);
        }

        return $countries_array;
    }

    public function sliders(Request $request)
    {
        $sliders = $this->formateSliders(Slider::get(), $request->lang);

        return response()->json(['sliders' => $sliders]);
    }

    private function formateSliders($sliders, $lang){
        $sliders_array = [];

        foreach($sliders as $slider){
            array_push($sliders_array, [
                'id' => $slider->id,
                'title' => isset($lang) && $lang!=null ? $slider->getTranslation('title', $lang) : $slider->title,
                'image' => url($slider->image)
            ]);
        }

        return $sliders_array;
    }
    
}
