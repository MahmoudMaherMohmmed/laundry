@extends('template')
@section('page_title')
@lang('messages.notifications.create_notification')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.notifications.create_notification') </h3>
                </div>
                <div class="box-content">
                    @if($notification)
                    {!! Form::model($notification,["url"=>"notification/$notification->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('notification.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"notification","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('notification.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#notification').addClass('active');
        $('#notification_create').addClass('active');
    </script>
@stop
