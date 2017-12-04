@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Sipariş Detayları
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <?php $siteSetting = \App\Setting::find(1); ?>
<section class="content-header">
    <h1>View order</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/orders') }}">@lang('orders/title.orders')</a></li>
        <li class="active">Sipariş Detayı</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title"> <i class="livicon" data-name="shopping-cart-in" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('orders/title.details')
                        <div class="pull-right">
                            <a href="{{ route('print/order',$order->id) }}" target="_blank" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-print"></span> Yazdır</a>
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <form method="post" action="#">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <table class="table table-bordered table-striped" id="orders">

                                <tr>
                                    <td style="width: 20%;">Sipariş No</td>
                                    <td> {{ $order->id }} </td>
                                </tr>
                                <tr>
                                    <td>Referans No</td>
                                    <td> {{ $order->refNo }} </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%;">Müşteri</td>
                                    <td>  <a href="{{ route('customers.show', $order->customer->id) }}" target="_blank">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</a></td>
                                </tr>
                                <tr>
                                    <td>Ödeme Türü</td>
                                    <td> {{{ $order->paymethod->title_tr }}} </td>
                                </tr>
                                @if($order->odemeTuru == 2)
                                    <tr>
                                        <td>Banka Hesabı</td>
                                        <td><span>
                                            <b>Banka: </b><span>{{{ $order->orderbank->bankaAdi }}} </span>
                                            <b>Şube Kodu: </b><span>{{{ $order->orderbank->subeKodu }}} </span>
                                            <b>Şube Adı: </b><span>{{{ $order->orderbank->subeAdi }}} </span><br>
                                            <b>Hesap Adı: </b><span>{{{ $order->orderbank->hesapAdi }}} </span>
                                            <b>Hesap Türü </b><span>{{{ $order->orderbank->hesapTuru }}} </span>
                                            <b>Hesap No: </b><span>{{{ $order->orderbank->hesapNo }}} </span><br>
                                            <b>IBAN: </b><span>{{{ $order->orderbank->iban }}} </span>
                                        </span></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Sipariş Durumu</td>
                                    <td>
                                        <div class="col-sm-3">
                                            <select name="status" class="form-control orderStatus" data-id="{{ $order->id }}">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {!! ($status->id == $order->status ? ' selected="selected"' : '') !!}>{{ $status->title_tr }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Kargo Firması</td>
                                    <td> {{{ $order->cargo->name }}} </td>
                                </tr>
                                <tr>
                                    <td>Kargo Takip No</td>
                                    <td> {{ $order->kargoTakip }} </td>
                                </tr>
                                <tr>
                                    <td>Sipariş Tarihi</td>
                                    <td> {{ $order->created_at }} </td>
                                </tr>
                                <tr>
                                    <td>Üye IP Adresi</td>
                                    <td> {{ $order->uyeIp }} </td>
                                </tr>
                                <tr>
                                    <td>Hediye Paketi</td>
                                    <td> {{{ \App\Sabit::yesNo($order->hediye)  }}} </td>
                                </tr>
                                @if($order->ind_kod != '')
                                    <tr>
                                        <td>Promosyon Kodu</td>
                                        <td> {{ $order->ind_kod  }} / %{{ $order->ind_oran  }} İndirim </td>
                                    </tr>
                                    <li><span>{{Lang::get('orders/form.promotioncode')}}:</span><span>{{{ $order->ind_kod }}}</span></li>
                                @endif
                                <tr>
                                    <td>Teslimat Bilgileri</td>
                                    <td>
                                        <b>Adı Soyadı : </b><span>{{{ $order->alici_adi }}}</span><br>
                                        <b>Email : </b><span>{{{ $order->alici_email }}}</span><br>
                                        <b>Adres : </b><span>{{{ $order->address }}} {{{ $order->town }}}  {{{ $order->city_id }}} {{{ $order->state }}} / {{{ $order->country->ulke }}}</span><br>
                                        <b>Telefon : </b><span>{{{ $order->tel }}}</span><br>
                                        <b>TC Kimlik No : </b><span>{{{ $order->tckimlik }}}</span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fatura Bilgileri</td>
                                    <td>
                                        <b>Fatura Türü:</b><span>{{{ \App\Sabit::faturaType($order->ftype) }}}</span><br>
                                        @if($order->faturaAyni == 1)
                                            <b>Faturada Yazacak İsim:</b><span>{{{ $order->alici_adi }}}</span><br>
                                            <b>Adres:</b><span><span>{{{ $order->address }}} {{{ $order->town }}}  {{{ $order->city_id }}}  {{{ $order->state }}} / {{{ $order->country->ulke }}}</span></span><br>
                                            <b>Telefon:</b><span>{{{ $order->tel }}}</span><br>
                                            <b>TC Kimlik No:</b><span>{{{ $order->tckimlik }}}</span><br>
                                        @else
                                            <b>Faturada Yazacak İsim:</b><span>{{{ $order->fisim }}}</span><br>
                                            <b>Adres:</b><span><span>{{{ $order->faddress }}} {{{ $order->ftown }}}  {{{ $order->fcity_id }}}  {{{ $order->fstate }}} / {{{ $order->fcountry->ulke }}}</span></span><br>
                                            <b>Telefon:</b><span>{{{ $order->tel }}}</span><br>
                                            @if($order->ftype == 1)
                                                <b>TC Kimlik No:</b><span>{{{ $order->ftckimlik }}}</span><br>
                                            @else
                                                <b>Vergi Dairesi:</b><span>{{{ $order->vergid }}}</span><br>
                                                <b>Vergi No:</b><span>{{{ $order->vergino }}}</span><br>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                            </table>
                            <br>
                            <table class="table table-bordered table-striped" id="table1">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Görsel</th>
                                    <th class="text-center">Ürün Adı</th>
                                    <th class="text-center">Adet</th>
                                    <th class="text-center">Toplam Fiyat</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $araToplam = 0;
                                $kdvTutar = 0;
                                ?>
                                @foreach($order->orderdetails as $detail)
                                    @if($detail->product)
                                        <tr>
                                            <td class="text-center">{{ $detail->product_id  }}</td>
                                            <td class="text-center"><img src="{{ \App\Library\Common::getPrdImage($detail->product_id) }}" height="80"></td>
                                            <td class="text-center">
                                                <a href="{{ url('/urun/'.$detail->product->sefurl) }}" target="_blank">
                                                    {{ $detail->product->title_tr }} {!! ($detail->option_id ? ' ( <span style="color:#F00;">'.\App\Library\Common::getPropsAndOptions($detail->option_id).'</span> )' : '') !!}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $detail->adet }}</td>
                                            <td class="text-center">
                                                {{ $siteSetting->para_birim.$detail->toplamFiyat }}
                                                {!! ($detail->havale_ind_yuzde > 0 ? ' <br><i>(%'.$detail->havale_ind_yuzde .' Havale İndirimi)</i>' : '') !!}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="3">Silinmiş Ürün</td>
                                            <td class="text-center">{{ $detail->adet }}</td>
                                            <td class="text-center">
                                                {{ $siteSetting->para_birim.$detail->toplamFiyat }}
                                                {!! ($detail->havale_ind_yuzde > 0 ? ' <br><i>(%'.$detail->havale_ind_yuzde .' Havale İndirimi)</i>' : '') !!}
                                            </td>
                                        </tr>
                                    @endif
                                    <?php
                                    $araToplam += $detail->toplamFiyat;
                                    $kdvTutar += $detail->kdvTutar;
                                    ?>
                                @endforeach
                                <?php $kdvDahil = $araToplam + $kdvTutar; ?>
                                <tr class="TotalPrice">
                                    <td colspan="3"></td>
                                    <td class="text-right"> <b>Ara Toplam:</b></td>
                                    <td class="text-center">{{ $siteSetting->para_birim.number_format($araToplam,2) }}</td>
                                </tr>
                                <tr class="TotalPrice">
                                    <td colspan="3"></td>
                                    <td class="text-right"> <b>KDV:</b></td>
                                    <td class="text-center">{{ $siteSetting->para_birim.number_format($kdvTutar,2) }}</td>
                                </tr>
                                <tr class="TotalPrice">
                                    <td colspan="3"></td>
                                    <td class="text-right"> <b>KDV Dahil:</b></td>
                                    <td class="text-center">{{ $siteSetting->para_birim.number_format($kdvDahil,2) }}</td>
                                </tr>
                                <tr class="TotalPrice">
                                    <td colspan="3"></td>
                                    <td class="text-right"> <b>Kargo Ücreti:</b></td>
                                    <td class="text-center">{{ $siteSetting->para_birim.number_format($order->kargoTutar,2) }}</td>
                                </tr>
                                @if($order->ind_oran > 0)
                                    <tr class="TotalPrice">
                                        <td colspan="3"></td>
                                        <td class="text-right"> <b>{{Lang::get('orders/form.promodiscount')}}:</b></td>
                                        <td class="text-center">% {{ $order->ind_oran }}</td>
                                    </tr>
                                @endif
                                <tr class="TotalPrice">
                                    <td colspan="3"></td>
                                    <td class="text-right"> <b>Genel Toplam</b></td>
                                    <td class="text-center">{{ $siteSetting->para_birim.number_format($order->topTutar,2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('footer_scripts')
<script  src="{{ asset('assets/js/orderStatus.js') }}" type="text/javascript"></script>
@stop