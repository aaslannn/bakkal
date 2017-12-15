@extends('emails/layouts/default')

@section('content')
    <h3 style="font-size:24px;font-weight:normal">Yeni Sipariş.</h3>
    <p>Sayın <b>Yönetici,</b>
    </p>
    <p>Yeni bir sipariş alınmıştır. Sipariş detayları aşağıdaki gibidir.</p>
    <ul style="list-style-type:none">
        <li><b>Sipariş Numarası:</b> {{{ $order->id }}}</li>
        <li><b>Sipariş Tarihi :</b> {{{ $order->created_at }}}</li>
        <li><b>Sipariş Durumu :</b> {{{ $order->orderstatus->title_en }}}</li>
        <li><b>Ödeme Şekli :</b> {{{ $order->paymethod->title_en }}}</li>
        <li><b>Toplam Tutar :</b> {{ $settings->para_birim.$order->topTutar }}</li>
    </ul>
@stop
