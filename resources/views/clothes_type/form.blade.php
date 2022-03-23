@extends('template')
@section('page_title')
@lang('messages.clothes_types.create_clothes_type')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.clothes_types.create_clothes_type') </h3>
                </div>
                <div class="box-content">
                    @if($clothes_type)
                    {!! Form::model($clothes_type,["url"=>"clothes_type/$clothes_type->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('clothes_type.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"clothes_type","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('clothes_type.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $('#clothes_type').addClass('active');
        $('#clothes_type_create').addClass('active');
    </script>
@stop
