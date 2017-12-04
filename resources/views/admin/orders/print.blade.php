@extends('admin/layouts/cleanpage')

{{-- Page title --}}
@section('title')
Sipariş Detayları - {{ $order->id }}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" />
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <?php $siteSetting = \App\Setting::find(1); ?>
<section class="content" style="max-width: 8cm">
    <div class="row">
        <div class="col-lg-12" style="padding-left:0;">
                <table class="table table-bordered table-striped" id="orders">
                    <tr>
                        <td colspan="2">#{{ $order->id }} - {{ $order->created_at }} </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>{{{ $order->alici_adi }}}</b><br>
                            <b>Adres : </b><span>{{{ $order->address }}} {{{ $order->town }}}  {{{ $order->city_id }}} {{{ $order->state }}} / {{{ $order->country->ulke }}}</span><br>
                            <b>Telefon : </b><span>{{{ $order->tel }}}</span><br>
                            <b>Email : </b><span>{{{ $order->alici_email }}}</span><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Ödeme</td>
                        <td>
                            {{{ $order->paymethod->title_tr }}}
                            @if($order->odemeTuru == 2)
                                ( {{{ $order->orderbank->bankaAdi }}} - {{{ $order->orderbank->hesapAdi }}})
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Durum</td>
                        <td>{{ $order->orderstatus->title_tr }}</td>
                    </tr>
                    @if($order->ind_kod != '')
                        <tr>
                            <td>İndirim </td>
                            <td> {{ $order->ind_kod  }} / %{{ $order->ind_oran  }} İndirim </td>
                        </tr>
                        <li><span>{{Lang::get('orders/form.promotioncode')}}:</span><span>{{{ $order->ind_kod }}}</span></li>
                    @endif
                    @if($order->note != '')
                    <tr>
                        <td>Sipariş Notu</td>
                        <td> {{ $order->note }} </td>
                    </tr>
                    @endif
                </table>
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                    <tr>
                        <th class="text-center">Ürün Adı</th>
                        <th class="text-center">Adet</th>
                        <th class="text-center">Ücret</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $araToplam = 0;
                    $kdvTutar = 0;
                    ?>
                    @foreach($order->orderdetails as $detail)
                        <tr>
                            <td>
                                @if($detail->product)
                                    {{ $detail->product->title_tr }} {!! ($detail->option_id ? ' ( <span style="color:#F00;">'.\App\Library\Common::getPropsAndOptions($detail->option_id).'</span> )' : '') !!}
                                @else - @endif
                            </td>
                            <td class="text-center">{{ $detail->adet }}</td>
                            <td class="text-right">
                                {{ $siteSetting->para_birim.$detail->toplamFiyat }}
                                {!! ($detail->havale_ind_yuzde > 0 ? ' <br><i>(%'.$detail->havale_ind_yuzde .' Havale İndirimi)</i>' : '') !!}
                            </td>
                        </tr>
                        <?php
                        $araToplam += $detail->toplamFiyat;
                        $kdvTutar += $detail->kdvTutar;
                        ?>
                    @endforeach
                    <?php $kdvDahil = $araToplam + $kdvTutar; ?>
                    <tr class="TotalPrice">
                        <td colspan="2" class="text-right"> <b>Ara Toplam:</b></td>
                        <td class="text-right">{{ $siteSetting->para_birim.number_format($araToplam,2) }}</td>
                    </tr>
                    @if($kdvTutar > 0)
                    <tr class="TotalPrice">
                        <td colspan="2" class="text-right"> <b>KDV:</b></td>
                        <td class="text-right">{{ $siteSetting->para_birim.number_format($kdvTutar,2) }}</td>
                    </tr>
                    <tr class="TotalPrice">
                        <td colspan="2" class="text-right"> <b>KDV Dahil:</b></td>
                        <td class="text-right">{{ $siteSetting->para_birim.number_format($kdvDahil,2) }}</td>
                    </tr>
                    @endif
                    @if($order->kargoTutar > 0)
                    <tr class="TotalPrice">
                        <td colspan="2" class="text-right"> <b>Kargo Ücreti:</b></td>
                        <td class="text-right">{{ $siteSetting->para_birim.number_format($order->kargoTutar,2) }}</td>
                    </tr>
                    @endif
                    @if($order->ind_oran > 0)
                        <tr class="TotalPrice">
                            <td colspan="2" class="text-right"> <b>{{Lang::get('orders/form.promodiscount')}}:</b></td>
                            <td class="text-right">% {{ $order->ind_oran }}</td>
                        </tr>
                    @endif
                    <tr class="TotalPrice">
                        <td colspan="2" class="text-right"> <b>Genel Toplam</b></td>
                        <td class="text-right">{{ $siteSetting->para_birim.number_format($order->topTutar,2) }}</td>
                    </tr>
                    </tbody>
                </table>
        </div>
    </div>
</section>
@stop

@section('footer_scripts')
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
@stop