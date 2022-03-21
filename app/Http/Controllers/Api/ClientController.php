<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ClientController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'clients';
    
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function login(Request $request)
    {
        $Validated = Validator::make($request->all(), [
            'phone'     => 'required',
            'password'  => 'required|min:6',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $client = Client::where('phone', $request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                $token = $client->createToken('API')->accessToken;

                $this->updateDeviceToken($client, $request->device_token);

                return response(['token' => $token], 200);
            } else {
                return response(["message" => trans('api.password')], 403);
            }
        } else {
            return response(["message" => trans('api.user_does_not_exist')], 403);
        }
    }

    private function updateDeviceToken($client, $device_token){
        $client->device_token = $device_token;
        $client->save();

        return true;
    }

    public function register(Request $request)
    {
        $Validated = Validator::make($request->all(), [
            'username'      => 'required|min:3',
            'email'     => 'required|email|unique:clients',
            'phone'     => 'required|unique:clients',
            'lat'       => 'required',
            'lng'       => 'required',
            'password'  => 'required|min:6',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $client = Client::create($request->only('username', 'email', 'phone', 'lat', 'lng', 'password', 'device_token'));

        $token = $client->createToken('API')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function profile(Request $request){
        $user = $this->formatUser($request->user());

        return response()->json(['user' => $user], 200);
    }

    public function updateProfile(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'username'      => 'required|min:3',
            'email'     => 'required|unique:clients,email,'.$client->id,
            'phone'     => 'required|unique:clients,phone,'.$client->id,
            'lat'       => 'required',
            'lng'       => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_client = Client::where('id', $client->id)->first();
        $updated_client->fill($request->only('username', 'email', 'phone', 'lat', 'lng'));
        $updated_client->update();
        
        return response()->json(['messaage' => trans('api.update_profile'), 'user' => $this->formatUser($updated_client)], 200);
    }

    public function updateProfileImage(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'image'      => 'required|mimes:jpeg,jpg,png',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_client = Client::where('id', $client->id)->first();
        if ($request->image) {
            $updated_client->image = $this->handleFile($request['image']);
        }
        $updated_client->update();

        return response()->json(['messaage' => trans('api.update_profile'), 'user' => $this->formatUser($updated_client)], 200);
    }

    private function formatUser($user){
        $user = [
            "id" => $user->id,
            "username" => $user->username,
            "phone" => $user->phone,
            "email" => $user->email,
            'lat' => $user->lat,
            'lng' => $user->lng,
            "image" => isset($user->image) && $user->image!=null ? url($user->image) : null,
            "activation_code" => $user->activation_code,
            "status" => $user->status,
        ];

        return $user;
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => trans('api.logout')], 200);
    }

       /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
