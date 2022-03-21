@extends('template')
@section('page_title')
    @lang('messages.bank_transfers.bank_transfer_details')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.bank_transfers.bank_transfer_details')</h3>
                            <a class="btn btn-sm btn-success show-tooltip" style="float: left" href='{{ url("reservation/$reservation->id/edit") }}' title="Update">@lang('messages.reservations.update_reservation')</a>
                        </div>
                        <div class="box-content">
                            <div class="table-responsive">
                                <table class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td> @lang('messages.reservations.client_name') </td>
                                            <td> {{ $reservation->client->first_name .' '. $reservation->client->last_name}} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.reservations.technician_name') </td>
                                            <td> {{ $reservation->technician->name }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.reservations.date') </td>
                                            <td> {{ $reservation->date }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.reservations.time') </td>
                                            <td> {{ $reservation->from }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.reservations.total_price') </td>
                                            <td> {{ $reservation->total_price }} </td>
                                        </tr>
                                        <tr>
                                            <th> @lang('messages.reservations.transaction_id') </th>
                                            <td> {{ $reservation->transaction_id!=null ? $reservation->transaction_id : '---' }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('script')
    <script>
        $('#reservation').addClass('active');
        $('#reservation_create').addClass('active');
    </script>
@stop
