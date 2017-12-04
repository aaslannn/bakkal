@if ($errors->any())
<div class="alert alert-danger alert-dismissable margin5">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{Lang::get('frontend/general.error')}}:</strong> {{Lang::get('frontend/general.pleasecheckerror')}}
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable margin5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{Lang::get('frontend/general.success')}}:</strong> {{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable margin5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{Lang::get('frontend/general.error')}}:</strong> {{ $message }}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable margin5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{Lang::get('frontend/general.warning')}}:</strong> {{ $message }}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable margin5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{Lang::get('frontend/general.info')}}:</strong> {{ $message }}
</div>
@endif
