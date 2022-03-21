@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <a class="tile tile-light-blue" data-stop="500" href="{{url('users')}}">
                <div class="img img-center">
                    <i class="fa fa-users"></i>
                    <p class="title text-center">{{$users}}</p>
                    <p class="title text-center">@lang('messages.users.users')</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a class="tile tile-light-blue" data-stop="500" href="{{url('country')}}">
                <div class="img img-center">
                    <i class="glyphicon glyphicon-globe" style="font-size: 47px;"></i>
                    <p class="title text-center">{{$countries}}</p>
                    <p class="title text-center">@lang('messages.country.country')</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a class="tile tile-light-blue" data-stop="500" href="{{url('client')}}">
                <div class="img img-center">
                    <i class="fa fa-users"></i>
                    <p class="title text-center">{{$clients}}</p>
                    <p class="title text-center">@lang('messages.clients.clients')</p>
                </div>
            </a>
        </div>
    </div>
@stop
