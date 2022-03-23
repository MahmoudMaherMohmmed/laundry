@extends('template')
@section('page_title')
@lang('messages.items.create_item')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.items.create_item') </h3>
                </div>
                <div class="box-content">
                    @if($item)
                    {!! Form::model($item,["url"=>"item/$item->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('item.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"item","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('item.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#item').addClass('active');
        $('#item_create').addClass('active');
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#service_id").change(function(){
                $.ajax({
                    type: "GET",
                    url: "{{url('services/clothes_types')}}",
                    data: {
                        service_id: $(this).val(),
                    },
                    success: function(response){
                        $("#clothes_types").html(response); 
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@stop
