<?php
$center = App\Models\Center::first();
$tStart = strtotime( substr($center->from, 0, strpos($center->from, " ")) );
$tEnd = strtotime( substr($center->to, 0, strpos($center->to, " ")) );
$tNow = $tStart;
?>

@while($tNow <= $tEnd)
  <option value="{{date('H:i A',$tNow)}}" {{$reservation && $reservation->from==date('H:i A',$tNow) ? 'selected' : '' }}>{{date('H:i A',$tNow)}}</option>
  @php $tNow = strtotime('+60 minutes',$tNow); @endphp
@endwhile