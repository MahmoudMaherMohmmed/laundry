@foreach($clothes_types as $clothes_type)
<option value="{{$clothes_type->id}}">{{$clothes_type->getTranslation('name', Session::get('applocale'))}}</option>
@endforeach