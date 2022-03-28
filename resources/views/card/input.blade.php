<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.clients.clients')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required>
        @foreach($clients as $client)
            <option value="{{$client->id}}" {{$card && $card->client_id == $client->id ? 'selected' : '' }}>{{$client->username}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cards.card_holder_name')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="card_holder_name" value="@if ($card) {!! $card->card_holder_name !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cards.card_number')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="number" class="form-control" name="card_number" max="9999999999999999" value="@if ($card) {!! $card->card_number !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cards.expiry_date')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="expiry_date" value="@if ($card) {!! $card->expiry_date !!} @endif" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cards.cvv')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="number" class="form-control" name="cvv" min="000" max="999" value="@if ($card) {!! $card->cvv !!} @endif" />
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
