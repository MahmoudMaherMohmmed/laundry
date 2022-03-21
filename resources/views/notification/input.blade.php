<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.notifications.client_name')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required {{$notification!=null ? 'disabled' : ''}}>
        <option value="0">@lang('messages.notifications.all')</option>
        @foreach($clients as $client)
            <option value="{{$client->id}}" {{$notification && $notification->client_id==$client->id ? 'selected' : '' }}>{{$client->username}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.notifications.title') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::text('title', null, ['placeholder'=>'Notification Title', 'class'=>'form-control', 'value' => '$notification->title', 'autocomplete' => 'off' ]) !!}
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.description') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <textarea class="form-control" name="body" rows=6>{{$notification ? $notification->body : ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
