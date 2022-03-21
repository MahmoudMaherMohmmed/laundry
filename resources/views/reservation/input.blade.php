<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label"> @lang('messages.reservations.id')</label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control"  value="@if ($reservation) {!! $reservation->id !!} @endif" disabled />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.client_name') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required {{$reservation!=null ? 'disabled' : ''}}>
        @foreach($clients as $client)
        <option value="{{$client->id}}" {{$reservation && $reservation->client_id==$client->id ? 'selected' : '' }}>{{$client->first_name . ' ' . $client->first_name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.technician_name') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="technician_id" required>
        @foreach($technicians as $technician)
        <option value="{{$technician->id}}" {{$reservation && $reservation->technician_id==$technician->id ? 'selected' : '' }}>{{$technician->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label"> @lang('messages.reservations.date') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control js-datepicker" name="date" readonly="readonly" value="@if ($reservation) {!! $reservation->date !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label"> @lang('messages.reservations.time') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <select class="form-control chosen-rtl" name="from" required>
            @include('partial.hours_reservation')
        </select>
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.status.status')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="status" required>
        <option value="1" {{$reservation && $reservation->status==1 ? 'selected' : '' }}>قيد المراجعه</option>
        <option value="2" {{$reservation && $reservation->status==2 ? 'selected' : '' }}>مقبول</option>
        <option value="0" {{$reservation && $reservation->status==0 ? 'selected' : '' }}>مرفوض</option>
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
