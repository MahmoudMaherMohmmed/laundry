@extends('template')
@section('page_title')
@lang('messages.cities.create_city')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cities.create_city') </h3>
                </div>
                <div class="box-content">
                    @if($city)
                    {!! Form::model($city,["url"=>"city/$city->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('city.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"city","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('city.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#country').addClass('active');
        $('#cities').addClass('active');
    </script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4lIndWVJTXYLEgRwBQ4g3BXmAEHQup44&callback=initMap&v=weekly&channel=2"
      async></script>

    <script>
        function initMap() {
            const myLatlng = { lat: 25.60417611097951, lng: 43.86444002590798 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: myLatlng,
            });
           
            map.addListener("click", (mapsMouseEvent) => {
                var latLng = mapsMouseEvent.latLng.toJSON();
                $('input[name="lat"]').val( JSON.parse( latLng.lat ) );
                $('input[name="lng"]').val( JSON.parse( latLng.lng ) );
            });
        }
    </script>
@stop
