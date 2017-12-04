@extends('emails/layouts/default')

@section('content')
<p>Sayın {{{ $user->first_name }}} {{{ $user->last_name }}},</p>
<p>Giriş bilgileriniz aşağıda yer almaktadır;</p>
<p>Mail Adresiniz : {{{ $user->email }}} <br>Şifre : {{{ $user->passnohash }}}</p>
@stop
