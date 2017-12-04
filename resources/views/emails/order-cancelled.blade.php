@extends('emails/layouts/default')

@section('content')
    <h3 style="font-size:24px;font-weight:normal">Sipariş İptali</h3>
    <p>Sayın <b>Yönetici,</b></p>
    <p>>#{{$order->id}} no'lu sipariş iptal edilmiştir. Panelden kontrol edebilirsiniz.</p>
@stop
