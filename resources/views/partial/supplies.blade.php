<div class="col-sm-5 col-lg-5 controls">
    <select class="form-control chosen-rtl" name="oil_id" required>
    @foreach($oils as $oil)
        <option value="{{$oil->id}}">{{$oil->getTranslation("name", Session::get("applocale""))}}</option>
    @endforeach
    </select>
</div>
<div class="col-sm-3 col-lg-3 controls">
    <input type="text" class="form-control" name="quantity" placeholder="Quantity"/>
</div>