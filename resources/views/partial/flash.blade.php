  <br><br>


  @if (Session::has('success'))
      <div class="alert alert-success {{ Session::has('important_msg') ? 'alert-important' : '' }}">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('success') }}
      </div>
  @elseif(Session::has('failed'))
      <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('failed') }}
      </div>
  @endif

  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
  @endif
