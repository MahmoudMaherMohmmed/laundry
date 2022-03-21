@extends('template')
@section('page_title')
@lang('messages.coupons.create_coupon')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.coupons.create_coupon') </h3>
                </div>
                <div class="box-content">
                    @if($coupon)
                    {!! Form::model($coupon,["url"=>"coupon/$coupon->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('coupon.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"coupon","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('coupon.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $('#coupon').addClass('active');
        $('#coupon_create').addClass('active');
    </script>
@stop
