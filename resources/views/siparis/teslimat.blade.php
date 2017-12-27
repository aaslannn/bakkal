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
                <div class="Selected"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                <div><i class="fa fa-try"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                <div class="lastitem"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
            </div>
            <div class="container">
                <div class="has-error">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissable margin5 mt-15">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{Lang::get('frontend/general.error')}}:</strong> {{Lang::get('frontend/general.pleasecheckerror')}}
                        </div>
                    @endif
                </div>
                <form name="teslimat" method="post" action="" id="teslimatForm">
                    <meta name="csrf_token" content="{{ csrf_token() }}">
                    {{ csrf_field() }}
                    <div class="DefaultBox mt-15">
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.deliveryinfo')}}</div>
                    <div class="DefaultBoxBody AddressDetail">
                        <div class="AddressDetailHeading">
                            <div class="row">
                                <div class="col-md-6"><b class="block mt-40">{{Lang::get('frontend/general.deliveryaddress')}}</b></div>
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label class="BillinAddressInput">
                                            <input type="checkbox" name="faturaAyni" id="faturaAyni" value="1">{{Lang::get('frontend/general.samebillingaddress')}}
                                        </label>
                                    </div><b>{{Lang::get('frontend/general.billingaddress')}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="AddressDetailBody">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="addressResult"></div>
                                    <div class="form-group">
                                        <label>{{Lang::get('frontend/general.myaddresslist')}}</label>
                                            <select class="form-control" name="adres" id="adres">
                                                <option value="0">{{Lang::get('frontend/general.select')}}</option>
                                                <option value="-1">{{Lang::get('frontend/general.addnew')}}</option>
                                                @foreach($tadresler as $adr)
                                                    <option value="{{ $adr->id }}">{{ $adr->title }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group hide" id="addressContainer">
                                        <div>
                                            <button type="button" name="newAddress" id="addNewAddress" class="BtnWarning"><i class="fa fa-save"></i><span>Save Address</span></button>
                                        </div>
                                        <label>{{Lang::get('customers/title.addressname')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input class="form-control" name="adres_adi" id="adres_adi">
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->first('alici_adi', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.namesurname')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input type="text" class="form-control required" name="alici_adi" id="alici_adi" value="{{{ Input::old('alici_adi', $user->first_name.' '.$user->last_name) }}}" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterrecipientname')}}">
                                        </div>
                                        {!! $errors->first('alici_adi', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('country', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.country')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control required" name="country_id" id="country_id" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectcountry')}}">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($countries as $ulke)
                                                    <option value="{{ $ulke->id }}" @if($ulke->varsayilan == 1) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('country_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('state', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.state')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control required" name="state_id" id="state_id" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectcountry')}}">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" @if($state->varsayilan == 1) selected="selected" @endif>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('state_d', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('city', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.city')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control required" name="city_id" id="city_id" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectcountry')}}">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if($city->varsayilan == 1) selected="selected" @endif>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('city_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('town', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.town')}}</label>
                                        <input class="form-control required" value="{{{ Input::old('town') }}}" type="text" name="town" id="town">
                                        {!! $errors->first('town', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="from-group {{ $errors->first('address', 'has-error') }}">
                                        <label>{{Lang::get('customers/title.address')}}</label>
                                        <div class="InputWrapper">
                                            <textarea type="text" class="form-control" name="address" id="address" maxlength="300">{{{ Input::old('address') }}}</textarea>
                                            <div class="InputTools"><span class="Counter"><span>0 / </span><span>300</span></span></div>
                                        </div>
                                        {!! $errors->first('address', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('tel', 'has-error') }}">
                                        <label>{{Lang::get('customers/title.tel')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input class="form-control TelefonNo"  value="{{{ Input::old('tel') }}}"  type="text" name="tel" id="tel"  data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterphone')}}">
                                        </div>
                                        {!! $errors->first('tel', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get('frontend/general.tcidno')}}</label>
                                        <input class="form-control KimlikNo" name="tckimlik" id="tckimlik" value="{{{ Input::old('tckimlik') }}}" >
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get('frontend/general.emailfornotification')}}</label>
                                        <input class="form-control" name="alici_email" id="alici_email"  value="{{{ Input::old('alici_email', $user->email) }}}">
                                    </div>
                                </div>
                                <div class="col-md-6 BillingAddress">
                                    <div class="faddressResult"></div>
                                    <div class="form-group">
                                        <label>{{Lang::get('frontend/general.myaddresslist')}}</label>
                                            <select class="form-control" name="fadres" id="fadres">
                                                <option value="0">{{Lang::get('frontend/general.select')}}</option>
                                                <option value="-1">{{Lang::get('frontend/general.addnew')}}</option>
                                                @foreach($fadresler as $adr)
                                                    <option value="{{ $adr->id }}">{{ $adr->title }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group hide" id="faddressContainer">
                                        <div>
                                            <button type="button" name="newAddressf" id="addNewAddressf" class="BtnWarning"><i class="fa fa-save"></i><span>Save Address</span></button>                                                 </div>

                                        <label>{{Lang::get('customers/title.addressname')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input class="form-control" name="fadres_adi" id="fadres_adi">
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->first('fisim', 'has-error') }}"">
                                        <label>{{Lang::get('frontend/general.nameonbill')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input class="form-control" name="fisim" id="fisim" value="{{{ Input::old('fisim') }}}">
                                        </div>
                                        {!! $errors->first('fisim', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('fcountry_id', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.country')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control" name="fcountry_id" id="fcountry_id">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($countries as $ulke)
                                                    <option value="{{ $ulke->id }}" @if($ulke->varsayilan == 1) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('fcountry_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('fstate_id', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.state')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control required" name="fstate_id" id="fstate_id" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectstate')}}">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $city->id }}" @if($city->varsayilan == 1) selected="selected" @endif>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('fstate_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('fcity_id', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.city')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <select class="form-control required" name="fcity_id" id="fcity_id" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectcity')}}">
                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if($city->varsayilan == 1) selected="selected" @endif>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! $errors->first('fcity_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('ftown', 'has-error') }}">
                                        <label>{{Lang::get('frontend/general.town')}}</label>
                                        <input class="form-control" type="text" name="ftown" id="ftown" value="{{{ Input::old('ftown') }}}">
                                        {!! $errors->first('ftown', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="from-group {{ $errors->first('faddress', 'has-error') }}">
                                        <label>{{Lang::get('customers/title.address')}}</label>
                                        <div class="InputWrapper">
                                            <textarea type="text" class="form-control" name="faddress" id="faddress" maxlength="300">{{{ Input::old('faddress') }}}</textarea>
                                            <div class="InputTools"><span class="Counter"><span>0 / </span><span>300</span></span></div>
                                        </div>
                                        {!! $errors->first('faddress', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group {{ $errors->first('ftel', 'has-error') }}">
                                        <label>{{Lang::get('customers/title.tel')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                            <input class="form-control TelefonNo" name="ftel" id="ftel" value="{{{ Input::old('ftel') }}}">
                                        </div>
                                        {!! $errors->first('ftel', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get('frontend/general.billtype')}}</label>
                                            <select class="form-control SelectBillinType" name="ftype" id="ftype">
                                                <option value="1">{{Lang::get('frontend/general.individual')}}</option>
                                                <option value="2">{{Lang::get('frontend/general.institutional')}}</option>
                                            </select>
                                    </div>
                                    <div class="form-group fbireysel">
                                        <label>{{Lang::get('frontend/general.tcidno')}}</label>
                                        <input class="form-control KimlikNo" name="ftckimlik" id="ftckimlik" value="{{{ Input::old('ftckimlik') }}}">
                                    </div>
                                    <div class="form-group fkurumsal hide">
                                        <label>{{Lang::get('frontend/general.taxadministration')}}</label>
                                        <input class="form-control" name="vergid" id="vergid" value="{{{ Input::old('vergid') }}}">
                                    </div>
                                    <div class="form-group fkurumsal hide">
                                        <label>{{Lang::get('frontend/general.taxno')}}</label>
                                        <input class="form-control" name="vergino" id="vergino" value="{{{ Input::old('vergino') }}}">
                                    </div>
                                    <div class="Cover"><span>

                        {!!Lang::get('frontend/general.samebillingaddressbr')!!}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="DefaultBoxBody AddressDetailTools">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-3">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.shippingfirm')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <select class="form-control" name="kargoId" id="kargoId" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.selectcargo')}}">
                                            <option value="">{{Lang::get('frontend/general.select')}}</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{ $cargo->id }}" {!! Input::old('kargoId') == $cargo->id ? ' selected="selected"' : ''  !!}}>{{ $cargo->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.giftwrap')}}</label>
                                    <select class="form-control" name="hediye" id="hediye">
                                        <option value="0" {!! Input::old('hediye') == 0 ? ' selected="selected"' : ''  !!}}>{{Lang::get('frontend/general.no')}}</option>
                                        <option value="1" {!! Input::old('hediye') == 1 ? ' selected="selected"' : ''  !!}}>{{Lang::get('frontend/general.yes')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="DefaultBoxFooter text-center">
                        <a class="BtnWarning inline-block mr-15" href="{{{ url('/sepet') }}}"><i class="fa fa-arrow-left"></i><span>{{Lang::get('frontend/general.goback')}}</span></a>
                        <button type="submit" class="BtnSuccess inline-block"><i class="fa fa-arrow-right"></i><span>{{Lang::get('frontend/general.nextstep')}}</span></button>
                    </div>
                </div>
                    <input type="hidden" name="uId" id="uId" value="{{{ $user->id }}}">
                </form>
            </div>
        </div>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
        <script src="{{ asset('assets/js/frontend/events/textareaevents.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/frontend/events/cargopackageevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
