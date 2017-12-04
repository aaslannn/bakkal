@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $uye->first_name }}},</p>
<p>Welcome to Latiendaturca.com! Your account informations:</p>
<p>
    Mail Address : {{{ $uye->email }}} <br>
    Password : {{{ $uye->passnohash }}}
</p>
@stop
