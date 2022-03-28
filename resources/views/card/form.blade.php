@extends('template')
@section('page_title')
@lang('messages.cards.create_card')
@stop
@section('content')
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
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cards.create_card') </h3>
                </div>
                <div class="box-content">
                    @if($card)
                    {!! Form::model($card,["url"=>"card/$card->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('card.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"card","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('card.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#card').addClass('active');
        $('#card_create').addClass('active');
    </script>
@stop
