@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.address-book')}}
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
                <li><a href="{{{ url('/uye/profil') }}}">{{Lang::get('frontend/general.myaccount')}}</a></li>
                <li>{{Lang::get('frontend/general.address-book')}}</li>
            </ol>
        </div>
        <div class="AddressBook">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('uye.menu')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox">
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.address-book')}}</div>
                            <div class="DefaultBoxBody">
                                <div class="HelpBox mb-15">
                                    <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                                    <div class="HelpBoxContent"><b>{{Lang::get('frontend/general.aboutthispage')}}</b><span>{{Lang::get('frontend/general.addresshelptext')}}</span></div>
                                </div>
                                <div class="has-error">
                                    @include('notifications')
                                </div>
                                <table class="table table-bordered table-striped AddressBookList">
                                    <thead>
                                    <tr>
                                        <th>{{Lang::get('frontend/general.addressname')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.addresstype')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.recipient')}}</th>
                                        <th class="text-center">{{Lang::get('orders/table.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($addresses as $adr)
                                        <tr>
                                            <td>{{ $adr->title }}</td>
                                            <td class="text-center">{{ \App\Sabit::addressType($adr->type,LaravelLocalization::getCurrentLocale()) }}</td>
                                            <td class="text-center">{{ $adr->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('update/adres', $adr->id) }}"><i class="fa fa-pencil-square"></i>{{Lang::get('frontend/general.edit-address')}}</a>
                                                <a href="{{ route('confirm-delete/adres', $adr->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-trash"></i>{{Lang::get('frontend/general.del-address')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <a data-toggle="modal" data-target="#AddressBookModal" class="BtnWarning inline-block"><i class="fa fa-plus"></i><span>{{Lang::get('frontend/general.addnewaddress')}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="customer_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <div id="AddressBookModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{Lang::get('frontend/general.addnewaddress')}}</h3>
                </div>
                <form name="addressForm" id="addressForm" method="post" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.addressname')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <input type="text" name="title" class="form-control" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.addressnamenotempty')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.recipient')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <input type="text" name="name" class="form-control" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.recipientnotempty')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.country')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <select class="form-control" name="country_id" id="country" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectcountry')}}">
                                            <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                            @foreach($countries as $ulke)
                                                <option value="{{ $ulke->id }}" @if($ulke->varsayilan == 1) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.state')}}</label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="{{Lang::get('frontend/general.onlyforcountries')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.city')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <input type="text" name="city_id" class="form-control" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseselectprovince')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.town')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <input type="text" class="form-control" name="town" id="town"  data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseentercounty')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label>{{Lang::get('frontend/general.address')}}</label>
                        <div class="InputWrapper">
                            <textarea type="text" name="adres" maxlength="300" class="form-control"></textarea>
                            <div class="InputTools"><span class="Counter"><span>0 / </span><span>1000</span></span></div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.tel')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                        <input type="text" class="form-control TelefonNo" name="tel" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterphone')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="block">{{Lang::get('frontend/general.addresstype')}}</label>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="type" value="1">{{Lang::get('frontend/general.deliveryaddress')}}
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="type" value="2">{{Lang::get('frontend/general.billingaddress')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="HelpBox mb-15">
                            <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                            <div class="HelpBoxContent"><span>{{Lang::get('frontend/general.notrequireddelinfo')}}</span></div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.tcidno')}}</label>
                                    <input type="text" class="form-control KimlikNo" name="tckimlik">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.taxno')}}</label>
                                    <input type="text" class="form-control" name="vergino">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('frontend/general.taxadministration')}}</label>
                                    <input type="text" class="form-control" name="vergid">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="BtnDanger inline-block mr-15"><i class="fa fa-close"></i><span>{{Lang::get('frontend/general.cancel')}}</span></a>
                    <button type="submit" class="BtnWarning inline-block" id="addAddress"><i class="fa fa-floppy-o"></i><span>{{Lang::get('frontend/general.save')}}</span></button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="AjaxLoader hide">
        <div class="LoaderBox">
            <div class="fa fa-spinner fa-spin"></div><span>Suspendisse ac imperdiet nunc.</span>
            <div class="LoaderFooter text-right"><a class="ColorRed">{{Lang::get('frontend/general.cancel')}}</a><a>{{Lang::get('frontend/general.ok')}}</a></div>
        </div>
    </div>

    <script src="{{ asset('assets/js/frontend/events/addressevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/textareaevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
