@extends('template')
@section('page_title')
@lang('messages.services.create_service')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.services.create_service') </h3>
                </div>
                <div class="box-content">
                    @if($service)
                    {!! Form::model($service,["url"=>"service/$service->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('service.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"service","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('service.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#service').addClass('active');
        $('#main_service').addClass('active');
    </script>
@stop
