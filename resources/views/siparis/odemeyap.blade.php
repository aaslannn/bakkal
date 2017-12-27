@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.pay')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
    <!--Carousel Start -->
    <!-- //Carousel End -->
@stop

{{-- content --}}
@section('content')
    <section class="MainContent">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a></li>
                <li><a href="{{{ url('uye/siparisler/'.$order->id) }}}">{{Lang::get('frontend/general.order')}}</a></li>
                <li>{{Lang::get('frontend/general.pay')}}</li>
            </ol>
        </div>
        <div class="CargoPackageDetail">
            <div class="Wizard">
                <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                <div class="Selected"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                <div class="lastitem"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
            </div>
            <div class="container">
                <form name="odeme" method="post" action="" id="odemeForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="DefaultBox mt-15">
                        <div class="DefaultBoxHeading">{{Lang::get('frontend/general.products')}}</div>
                        <div class="DefaultBoxBody MyCartSummary">
                            <table class="table table-bordered CartList">
                                <thead>
                                <tr>
                                    <th>{{Lang::get('frontend/general.product')}}</th>
                                    <th>{{Lang::get('frontend/general.count')}}</th>
                                    <th>{{Lang::get('frontend/general.stockcode')}}</th>
                                    <th>{{Lang::get('frontend/general.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $topTutar = 0;
                                $cargo = 0;
                                ?>
                                @foreach($order->orderdetails as $detail)
                                    <?php
                                    $cargo += $detail->product->kargo_ucret * $detail->adet;
                                    $araFiyat = \App\Library\Common::getTotalPrice($detail->product->id,0) * $detail->adet;
                                    $topTutar += $araFiyat;
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ url('/urun/'.$detail->product->sefurl) }}">
                                                <img src="{{ \App\Library\Common::getPrdImage($detail->product_id) }}">
                                                <span>
                                                    {{ $detail->product->{'title_'.$defLocale} }}
                                                    {!! ($detail->options && $detail->options->has('opt') ? ' <span class="prdOpt">('.\App\Library\Common::getPropsAndOptions($detail->options->get('opt')).'</span>)' : '') !!}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="text-center"><span>x{{ $detail->adet }}</span></td>
                                        <td class="text-center"><span>{{ $detail->product->id }}</span></td>
                                        <td class="text-center"><span>{{ $siteSettings->para_birim.number_format($araFiyat,2) }}</span></td>
                                    </tr>
                                @endforeach
                                <?php
                                //$topTutar = number_format($topTutar,2);
                                ?>
                                <tr class="Summary">
                                    <td colspan="2" class="noborder"></td>
                                    <td class="text-right"> <b>{{Lang::get('frontend/general.kdvincluded')}}:</b></td>
                                    <td class="text-center">{{ $siteSettings->para_birim.number_format($topTutar,2) }}</td>
                                </tr>
                                <tr class="Summary">
                                    <td colspan="2" class="noborder"></td>
                                    <td class="text-right"> <b>{{Lang::get('frontend/general.shipmentprice')}}:</b></td>
                                    <td class="text-center">{{ $siteSettings->para_birim.number_format($cargo,2) }}</td>
                                </tr>
                                <?php
                                $topTutar += $cargo;
                                ?>
                                <tr class="Summary">
                                    <td colspan="2" class="noborder"></td>
                                    <td class="text-right"> <b>{{Lang::get('frontend/general.grandtotal')}}</b></td>
                                    <td class="text-center">{{ $siteSettings->para_birim.number_format($topTutar,2)}}</td>
                                </tr>
                                @if($order->ind_oran > 0)
                                    <?php
                                    $topTutar = \App\Library\Common::getYuzdeliFiyat($topTutar,$order->ind_oran);
                                    ?>
                                <tr class="Summary">
                                    <td colspan="2" class="noborder"></td>
                                    <td class="text-right"><b>{{Lang::get('frontend/general.discount-price')}}</b></td>
                                    <td class="text-center">{{ $siteSettings->para_birimi.$topTutar}}</td>
                                </tr>
                                @endif
                                <tr class="DiscountCode hide">
                                    <td colspan="2" class="noborder"></td>
                                    <td class="text-right"><b>{{Lang::get('frontend/general.discount-price')}}</b></td>
                                    <td class="total"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if(!$order->ind_oran)
                        <div>
                            <div class="DefaultBoxBody text-center PromoCode" style="padding-top: 10px;">
                                <span class="inline-block mr-15 mt-5">{{Lang::get('frontend/general.promotioncode')}} :</span>
                                <div class="form-group inline-block mr-15">
                                    <input type="text" name="code" id="code" placeholder="Kodu Giriniz" class="form-control">
                                </div><a class="BtnWarning inline-block" id="addProCode"><i class="fa fa-ticket"></i><span>{{Lang::get('frontend/general.usecode')}}</span></a>

                                <div class="has-error margin5 mr-10 ml-10 PromoCodeResult"></div>
                            </div>
                        </div>
                        <input type="hidden" name="indCode" id="indCode" value="">
                        @endif
                    </div>
                    <div class="DefaultBox">
                            <div class="DefaultBoxBody TabBody">
                                @include('notifications')
                                <div class="has-error">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissable margin5">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>{{Lang::get('frontend/general.error')}}:</strong> {{Lang::get('frontend/general.pleasecheckerror')}}<br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-content">
                                        <div id="creditcard" class="tab-pane active">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{--<div class="form-group">
                                                            <label>{{Lang::get('frontend/general.selectcreditcard')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <select class="form-control required"  data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.selectcreditcard')}}"  name="pos_id" id="posId">
                                                                        <option value="">{{Lang::get('frontend/general.select')}}</option>
                                                                        @foreach($posAccounts as $pos)
                                                                            <option value="{{ $pos->id }}">{{ $pos->bankname }} - {{ $pos->cardname }}</option>
                                                                        @endforeach
                                                                        <option value="0">{{Lang::get('frontend/general.othercard')}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>--}}
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.nameoncard')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control required" required name="ccname" maxlength="40" autocomplete="off" data-rule-requiired="true" data-msg-required="{{ Lang::get('frontend/general.writenameoncard') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.cardno')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control KartNo required" required  name="ccno" autocomplete="off" maxlength="20" data-rule-requiired="true" data-msg-required="{{ Lang::get('frontend/general.entercardnumber') }}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.cardtype')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <?php echo Form::select('cctype', \App\Sabit::creditCardType(), null, array('class' => 'form-control')); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.cardenddate')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <?php echo Form::select('ccmonth', \App\Sabit::getMonthsNumber(), null, array('class' => 'form-control')); ?>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control" name="ccyear">
                                                                                @for($i=date("Y");$i<=(date("Y")+40);$i++)
                                                                                    <option value="{{ $i-2000 }}">{{ $i }}</option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.cardcvc')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control GuvenlikKodu required" required  name="cvc2" autocomplete="off"  maxlength="4"  data-rule-required="true" data-msg-required="{{ Lang::get('frontend/general.enterseccode') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{Lang::get('frontend/general.selectinst')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <select class="form-control" name="inst" id="Instalments">
                                                                        <option value="1">{{Lang::get('frontend/general.noinst')}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="InfoWrapper">
                                                            <div class="HelpBox mb-15">
                                                                <div class="HelpBoxIcon"><i class="fa fa-exclamation-circle"></i></div>
                                                                <div class="HelpBoxContent"><span>{{Lang::get('frontend/general.cardcvchow')}}</span></div>
                                                            </div>
                                                            <div class="text-center mt-30"><img src="{{ asset('assets/images/payment-image.png') }}" class="mt-30"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
                            <div class="DefaultBoxFooter text-center">
                                <button type="submit" class="BtnSuccess inline-block"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.iaccept')}}</span></button>
                            </div>
                    </div>
                    <input type="hidden" name="topTutar" value="{{ number_format($topTutar,2,'.','') }}">
                    <input type="hidden" name="topHvlTutar" value="">
                </form>
            </div>
        </div>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
        <script src="{{ asset('assets/js/frontend/events/cargopackageevents.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/frontend/events/cartevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
