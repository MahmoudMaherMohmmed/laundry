@extends('template')
@section('page_title')
@lang('messages.centers.create_center')
@stop
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.centers.create_center') </h3>
                </div>
                <div class="box-content">
                    @if($center)
                    {!! Form::model($center,["url"=>"center/$center->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('center.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"center","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('center.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#center').addClass('active');
        $('#center_create').addClass('active');
    </script>
@stop
