@extends('emails/layouts/default')

@section('content')
    <div style="border-bottom:1px solid #d6d6d6">
        <h3 style="font-size:24px;font-weight:normal">Siparişiniz alınmıştır.</h3>
        <p>Sayın <b>{{{ $order->alici_adi }}},</b>
        </p>
        <p>Sipariş detaylarınız aşağıdaki gibidir. Siparişinizle ilgili tüm sorularınızda sipariş numaranızı belirtmeyi unutmayınız.</p>
        <ul style="list-style-type:none">
            <li><b>Sipariş Numarası:</b> {{{ $order->id }}}</li>
            <li><b>Sipariş Tarihi :</b> {{{ $order->created_at }}}</li>
            <li><b>Sipariş Durumu :</b> {{{ $order->orderstatus->title_tr }}}</li>
            <li><b>Ödeme Şekli :</b> {{{ $order->paymethod->title_tr }}}</li>
            <li><b>Toplam Tutar :</b> {{ $settings->para_birim.$order->topTutar }}</li>
        </ul>
    </div>
    @if($order->odemeTuru == 2)
    <div style="border-bottom:1px solid #d6d6d6">
        <h3 style="font-size:24px;font-weight:normal">Banka Hesap Bilgileri</h3>
        <p>
            <ul style="list-style-type:none">
                <li><b>Banka Adı:</b> {{{ $order->orderbank->bankaAdi }}}</li>
                <li><b>Hesap Sahibi :</b> {{{ $order->orderbank->hesapAdi }}}</li>
                <li><b>Hesap Türü :</b> {{{ $order->orderbank->hesapTuru }}}</li>
                <li><b>IBAN :</b> {{{ $order->orderbank->iban }}}</li>
            </ul>
        </p>
    </div>
    @endif
    <div>
        <h3 style="font-size:24px;font-weight:normal">Sipariş Detayları</h3>
        <div style="box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.11);border:1px solid #d6d6d6;background:#eae9e7;font-size:13px;">
            <table style="width:100%;">
                <thead>
                <tr>
                    <th style="text-align:left;padding-left:5px;font-weight:normal;border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">Ürün Adı</th>
                    <th style="text-align:left;font-weight:normal;border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">Adet</th>
                    <th style="text-align:left;font-weight:normal;border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">Birim Fiyatı</th>
                    <th style="text-align:left;font-weight:normal;border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">Toplam Fiyat</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $araToplam = 0;
                    $kdvTutar = 0;
                    ?>
                    @foreach($order->orderdetails as $detail)
                        <tr>
                            <td style="padding-left:5px;border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">
                                {{ $detail->product->title_tr }} {!! ($detail->option_id > 0 ? '('.$detail->option->title_tr.')' : '') !!}
                            </td>
                            <td style="border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">{{ $detail->adet }}</td>
                            <td style="border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">{{ $settings->para_birim.number_format($detail->birimFiyat,2) }}</td>
                            <td style="border-bottom:1px solid #d6d6d6;padding-top:5px;padding-bottom:5px;">{{ $settings->para_birim.number_format($detail->toplamFiyat,2) }}</td>
                        </tr>
                        <?php
                        $araToplam += $detail->toplamFiyat;
                        $kdvTutar += $detail->kdvTutar;
                        ?>
                    @endforeach
                    <tr>
                        <td colspan="2"></td>
                        <td>Ara Toplam</td>
                        <td>{{ $settings->para_birim.number_format($araToplam,2) }}</td>
                    </tr>
                    @if($kdvTutar > 0)
                        <tr>
                            <td colspan="2"></td>
                            <td>KDV</td>
                            <td>{{ $settings->para_birim.number_format($kdvTutar,2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2"></td>
                        <td>Kargo Tutarı</td>
                        <td>{{ $settings->para_birim.number_format($order->kargoTutar,2) }}</td>
                    </tr>
                    @if($order->ind_oran > 0)
                        <tr>
                            <td colspan="2"></td>
                            <td>İndirim Oranı</td>
                            <td>% {{ $order->ind_oran }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2"></td>
                        <td>Toplam Tutar</td>
                        <td>{{ $settings->para_birim.number_format($order->topTutar,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
