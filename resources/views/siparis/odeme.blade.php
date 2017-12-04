@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.makeorder')}}
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
                <li><a href="{{{ url('/sepet') }}}">{{Lang::get('frontend/general.cart')}}</a></li>
                <li>{{Lang::get('frontend/general.order')}}</li>
            </ol>
        </div>
        <div class="CargoPackageDetail">
            <div class="Wizard">
                <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                <div class="Selected"><i class="fa fa-try"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                <div class="lastitem"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
            </div>
            <div class="container">
                <form name="odeme" method="post" action="" id="odemeForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="has-error">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissable margin5 mt-15">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>{{Lang::get('frontend/general.error')}}:</strong> {{Lang::get('frontend/general.pleasecheckerror')}}
                            </div>
                        @endif
                    </div>
                    <div class="DefaultBox mt-15">
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.my-cart')}}</div>
                    <div class="DefaultBoxBody MyCartSummary">
                        <table class="table table-bordered CartList">
                            <thead>
                            <tr>
                                <th>{{Lang::get('frontend/general.product')}}</th>
                                <th>{{Lang::get('frontend/general.count')}}</th>
                                <th>{{Lang::get('frontend/general.priceperitem')}}</th>
                                <th>{{Lang::get('frontend/general.kdv')}}</th>
                                <th>{{Lang::get('frontend/general.total')}}</th>
                                <th>{{Lang::get('frontend/general.witheft')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cart = Cart::Content();
                            $kdv = 0;
                            $cargo = 0;
                            $topHvlFiyat = 0;
                            foreach($cart as $row)
                            {
                                $prd = \App\Product::whereStatus(1)->whereId($row->id)->first();
                                if ($prd->kdv > 0)
                                {
                                    $prdKdv = \App\Library\Common::getKDV($prd->real_price,$prd->kdv) * $row->qty;
                                    $kdv += $prdKdv;
                                }
                                $cargo = $cargo + ($prd->kargo_ucret * $row->qty);

                                $uFiyat = \App\Library\Common::getTotalPrice($prd->id,0) * $row->qty;
                                $hvlFiyat = \App\Library\Common::getTotalPrice($prd->id,1) * $row->qty;
                                $topHvlFiyat += $hvlFiyat;
                                ?>
                                <tr>
                                    <td>
                                        <a href="{{ url('/urun/'.$prd->sefurl) }}">
                                            <img src="{{ \App\Library\Common::getPrdImage($prd->id) }}">
                                            <span>{{ $prd->{'title_'.$defLocale} }} {!! ($row->options->has('opt') ? ' <span class="prdOpt">('.\App\Library\Common::getPropsAndOptions($row->options->get('opt')).'</span>)' : '') !!}</span>
                                        </a>
                                    </td>
                                    <td><span>{{ $row->qty }}</span></td>
                                    <td><span>{{ $prd->currency.number_format($row->price,2) }}</span></td>
                                    <td><span>{!! ($prd->kdv > 0 ? '%'.$prd->kdv.' / '.$prd->currency.number_format($prdKdv,2) : '-') !!}</span></td>
                                    <td><span>{{ $prd->currency.number_format($uFiyat,2) }}</span></td>
                                    <td><span>{{ $prd->currency.number_format($hvlFiyat,2) }}</span></td>
                                    <td><a id="delCart" data-id="{{ $row->rowid }}" data-url="{{{ url('/delCart') }}}"><i class="fa fa-trash ml-30"></i></a></td>
                                </tr>
                                <?php
                            }
                            $topTutar = Cart::total()+$kdv;
                            ?>
                                <tr class="Summary">
                                    <td colspan="3" rowspan="5" class="noborder"></td>
                                    <td class="text-right"><b>{{Lang::get('frontend/general.kdvincluded')}}</b></td>
                                    <td>{{ $siteSettings->para_birim.number_format($topTutar,2) }}</td>
                                    <td>{{ $siteSettings->para_birim.number_format($topHvlFiyat,2) }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="Summary">
                                    <td class="text-right"><b>{{Lang::get('frontend/general.shipmentprice')}}</b></td>
                                    <td>{{ $siteSettings->para_birim.number_format($cargo,2) }}</td>
                                    <td>{{ $siteSettings->para_birim.number_format($cargo,2) }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php
                            $topTutar = $topTutar+$cargo;
                            $topHvlTutar = $topHvlFiyat + $cargo;
                            ?>
                                <tr class="Summary">
                                    <td class="text-right"><b>{{Lang::get('frontend/general.grandtotal')}}</b></td>
                                    <td>{{ $siteSettings->para_birim.number_format($topTutar,2) }}</td>
                                    <td>{{ $siteSettings->para_birim.number_format($topHvlTutar,2) }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="DiscountCode hide">
                                    <td class="text-right"><b>{{Lang::get('frontend/general.discount-price')}}</b></td>
                                    <td class="total"></td>
                                    <td class="hvltotal"></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="DefaultBoxBody text-center PromoCode" style="padding-top: 10px;">
                            <span class="inline-block mr-15 mt-5">{{Lang::get('frontend/general.promotioncode')}} :</span>
                            <div class="form-group inline-block mr-15">
                                <input type="text" name="code" id="code" placeholder="{{Lang::get('frontend/general.enterpromocode')}}" class="form-control">
                            </div><a class="BtnWarning inline-block" id="addProCode"><i class="fa fa-ticket"></i><span>{{Lang::get('frontend/general.usecode')}}</span></a>
                            <div class="has-error margin5 mr-10 ml-10 PromoCodeResult"></div>
                        </div>
                        <input type="hidden" name="lang" value="{{ Session::get('locale') }}">
                    </div>
                </div>

                    <div class="DefaultBox">
                        <div class="DefaultBoxHeading Tabbed">
                            <ul class="nav nav-tabs">
                                <?php $i=0; ?>
                                @foreach($payMethods as $pmt)
                                    <li {!! ($i == 0 ? ' class="active"' : '') !!}><a href="#{{ $pmt->uniqueName }}" data-toggle="tab" data-id="{{ $pmt->id }}" id="tab{{ $pmt->id }}">{{ $pmt->{'title_'.$defLocale} }}</a></li>
                                    <?php $i++ ?>
                                @endforeach
                            </ul>
                        </div>
                        <div class="DefaultBoxBody TabBody">
                            <div class="tab-content">
                                <?php $i=0; ?>
                                @foreach($payMethods as $pmt)
                                    <div id="{{ $pmt->uniqueName }}" class="tab-pane {!! ($i == 0 ? 'active' : '') !!}">
                                        @if($pmt->uniqueName == 'creditcard')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{--<div class="form-group {{ $errors->first('pos_id', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.selectcreditcard')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <select class="form-control" name="pos_id" id="posId">
                                                                    <option value="">{{Lang::get('frontend/general.select')}}</option>
                                                                    @foreach($posAccounts as $pos)
                                                                        <option value="{{ $pos->id }}">{{ $pos->bankname }} - {{ $pos->cardname }}</option>
                                                                    @endforeach
                                                                    <option value="0">{{Lang::get('frontend/general.othercard')}}</option>
                                                                </select>
                                                            </div>
                                                            {!! $errors->first('pos_id', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>--}}
                                                    <div class="form-group {{ $errors->first('ccname', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.nameoncard')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ccname" maxlength="40" autocomplete="off">
                                                            </div>
                                                            {!! $errors->first('ccname', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {{ $errors->first('ccno', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.cardno')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control KartNo" name="ccno" autocomplete="off" maxlength="20">
                                                            </div>
                                                            {!! $errors->first('ccno', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {{ $errors->first('cctype', 'has-error') }}">
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
                                                    <div class="form-group {{ $errors->first('cvc2', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.cardcvc')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control GuvenlikKodu" name="cvc2" autocomplete="off"  maxlength="4">
                                                            </div>
                                                            {!! $errors->first('cvc2', '<span class="help-block">:message</span> ') !!}
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
                                        @elseif($pmt->uniqueName == 'moneyorder')
                                            <div class="form-group {{ $errors->first('hesapId', 'has-error') }}">
                                            {!! $errors->first('hesapId', '<div><span class="help-block">:message</span></div>') !!}
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>{{Lang::get('frontend/general.bankname')}}</th>
                                                    <th>{{Lang::get('frontend/general.branch')}}</th>
                                                    <th>{{Lang::get('frontend/general.accounttype')}}</th>
                                                    <th>{{Lang::get('frontend/general.accountowner')}}</th>
                                                    <th>{{Lang::get('frontend/general.ibanno')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($bankAccounts as $bank)
                                                    <tr>
                                                        <td>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="hesapId" value="{{ $bank->id }}">{{ $bank->bankaAdi }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $bank->subeAdi }}</td>
                                                        <td>{{ $bank->hesapTuru }}</td>
                                                        <td>{{ $bank->hesapAdi }}</td>
                                                        <td>{{ $bank->iban }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        @elseif($pmt->uniqueName == 'cashpayment')
                                            <div class="form-group {{ $errors->first('odemeTuruOnay', 'has-error') }}">
                                                {!! $errors->first('odemeTuruOnay', '<div><span class="help-block">:message</span></div>') !!}
                                                <div class="InfoWrapper text-center"><img src="{{ asset('assets/images/ptt-logo.png') }}" class="mr-30">
                                                    <div class="checkbox inline-block">
                                                        <label>
                                                            <input type="checkbox" name="odemeTuruOnay" value="{{ $pmt->id }}">{{Lang::get('frontend/general.pttshipaccept')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($pmt->uniqueName == 'iyzico')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('pos_id', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.selectcreditcard')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <select class="form-control" name="pos_id" id="posId">
                                                                    <option value="">{{Lang::get('frontend/general.select')}}</option>
                                                                    @foreach($posAccounts as $pos)
                                                                        <option value="{{ $pos->id }}">{{ $pos->bankname }} - {{ $pos->cardname }}</option>
                                                                    @endforeach
                                                                    <option value="0">{{Lang::get('frontend/general.othercard')}}</option>
                                                                </select>
                                                            </div>
                                                            {!! $errors->first('pos_id', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {{ $errors->first('ccname', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.nameoncard')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ccname" maxlength="40" autocomplete="off">
                                                            </div>
                                                            {!! $errors->first('ccname', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {{ $errors->first('ccno', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.cardno')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control KartNo" name="ccno" autocomplete="off" maxlength="20">
                                                            </div>
                                                            {!! $errors->first('ccno', '<span class="help-block">:message</span> ') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {{ $errors->first('cctype', 'has-error') }}">
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
                                                    <div class="form-group {{ $errors->first('cvc2', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.cardcvc')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control GuvenlikKodu" name="cvc2" autocomplete="off"  maxlength="4">
                                                            </div>
                                                            {!! $errors->first('cvc2', '<span class="help-block">:message</span> ') !!}
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
                                        @endif
                                    </div>
                                    <?php $i++ ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="DefaultBoxFooter text-center">
                            <input type="checkbox" name="kabul" value="1" id="kabul1" checked="checked" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseacceptcontract')}}"> <label for="kabul1">{!!Lang::get('general.acceptcontract', array('url'=>url('/mesafeli-satis-sozlesmesi')))!!}</label> <br>
                            
                            <a class="BtnWarning inline-block mr-10" href="{{{ url('/siparis/teslimat') }}}"><i class="fa fa-arrow-left"></i><span>{{Lang::get('frontend/general.goback')}}</span></a>
                            <button type="submit" class="BtnSuccess inline-block"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.iaccept')}}</span></button>
                        </div>
                </div>
                    <input type="hidden" name="odemeTuru" value="{{ \App\Library\Common::getFirstPayMethod() }}" id=odemeTuru">
                    <input type="hidden" name="topTutar" value="{{ number_format($topTutar,2,'.','') }}">
                    <input type="hidden" name="topHvlTutar" value="{{ number_format($topHvlTutar,2,'.','') }}">
                    <input type="hidden" name="indCode" id="indCode" value="">
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
        @if($errors->has('hesapId'))
            <script> $("#tab2").trigger("click");</script>
        @endif
        @if($errors->has('odemeTuruOnay'))
            <script> $("#tab1").trigger("click");</script>
            @endif
    <!--page level js ends-->
@stop
