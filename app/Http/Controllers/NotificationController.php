<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Client;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->get_privilege();
    }

    public function index()
    {
        $notifications = Notification::latest()->get();
        
        return view('notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notification = null;
        $clients = Client::all();

        return view('notification.form', compact('notification', 'clients'));
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
            'client_id'  => 'required',
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($request->client_id != 0){
            Notification::create( $request->all() );
            $this->sendNotification($request);
        }else{
            $this->sendNotificationToAllClients($request);
        }

        \Session::flash('success', trans('messages.Added Successfully'));

        return redirect('/notification');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notification.index', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back();
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
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        $notification->delete();

        return redirect()->back();
    }

    private function sendNotification($request){
        $client = Client::where('id', $request->client_id)->first();
        
        if(isset($client) && $client!=null){
            sendNotification($client->device_token, array(
                "title" => $request->title, 
                "body" => $request->body
              ));
        }

        return true;
    }

    private function sendNotificationToAllClients($request){
        $clients = Client::all();
        
        foreach($clients as $client){
            if(isset($client->device_token) && $client->device_token!=null){
                $notification = new Notification();
                $notification->client_id = $client->id;
                $notification->title = $request->title;
                $notification->body = $request->body;
                $notification->save();

                sendNotification($client->device_token, array(
                    "title" => $request->title, 
                    "body" => $request->body
                  ));
            }
        }

        return true;
    }
}
