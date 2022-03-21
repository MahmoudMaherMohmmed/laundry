<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.coupons.oil')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="oil_ids[]" required multiple>
        @foreach($oils as $oil)
            <option value="{{$oil->id}}" {{$coupon && $coupon->oil_id==$oil->id ? 'selected' : '' }}>{{$oil->getTranslation('name', Session::get('applocale'))}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.coupons.coupon')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="coupon" value="@if ($coupon) {!! $coupon->coupon !!} @endif" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.coupons.discount')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="discount" value="@if ($coupon) {!! $coupon->discount !!} @endif" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.coupons.date') <span class="text-danger">*</span></label>
    <div class="col-sm-4 col-lg-5 controls">
        {!! Form::text('from',null,['placeholder'=>'From','class'=>'form-control js-datepicker' ,'value' => 'date("Y-m-d")' , 'autocomplete' => 'off' ]) !!}
    </div>
    <div class="col-sm-4 col-lg-5 controls">
        {!! Form::text('to',null,['placeholder'=>'To','class'=>'form-control js-datepicker' ,'value' => 'date("Y-m-d")' , 'autocomplete' => 'off' ]) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.status.status')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="status" required>
        <option value="1" {{$coupon && $coupon->status==1 ? 'selected' : '' }}>@lang('messages.status.available')</option>
        <option value="0" {{$coupon && $coupon->status==0 ? 'selected' : '' }}>@lang('messages.status.not_available')</option>
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
