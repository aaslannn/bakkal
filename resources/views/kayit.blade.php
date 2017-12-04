@extends('layouts/defaultMember')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.beamember')}}
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
            <div class="LoginContainer">
                <div class="DefaultBox">
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.beamember')}}</div>
					@if(($siteSettings->facebook_login || $siteSettings->twitter_login))
					<div class="DefaultBoxBody">
						<div class="SocialSignIn">
					@endif
							@if($siteSettings->facebook_login)
							<a class="FacebookSignIn" href="{{{ url('/giris/facebook') }}}"><i class="fa fa-facebook mr-5"></i>{{Lang::get('frontend/general.loginfb')}}</a>
							@endif
							@if($siteSettings->twitter_login)
							<a class="TwitterSignIn" href="{{{ url('/giris/twitter') }}}"><i class="fa fa-twitter mr-5"></i>{{Lang::get('frontend/general.logintwitter')}}</a>
							@endif
					@if(($siteSettings->facebook_login || $siteSettings->twitter_login))
						</div>
					</div>
					@endif
                    <form method="POST" action="#" id="loginform">
                        {{ csrf_field() }}
                        <div class="DefaultBoxBody">
                            <div class="has-error">
                                @include('notifications')
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="LoginInputs">
                                <input type="text" name="email" id="email" placeholder="{{Lang::get('frontend/general.emailaddress')}}" value="{{{ Input::old('email') }}}" class="form-control mb-5" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enteremailaddress')}}">
                                <input type="password" name="password" placeholder="{{Lang::get('frontend/general.password')}}" class="form-control mb-5" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterurpassword')}}">
                                <input type="password" name="password_confirm" placeholder="{{Lang::get('frontend/general.repassword')}}" class="form-control mb-5" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.confirmurpass')}}">
                                <input type="text" name="first_name" id="first_name" placeholder="{{Lang::get('frontend/general.first-name')}}" value="{{{ Input::old('first_name') }}}" class="form-control mb-5" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterurfirstname')}}">
                                <input type="text" name="last_name" id="last_name" placeholder="{{Lang::get('frontend/general.last-name')}}" value="{{{ Input::old('last_name') }}}" class="form-control" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterurlastname')}}">
                            </div>
                            <div class="LoginTools">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="sozlesme" value="1" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.pleaseconfirmcontract')}}">
                                        <a data-toggle="modal" data-target="#UyelikSozlesme">{{Lang::get('frontend/general.iacceptcontract')}}</a>
                                    </label>
                                </div>
                            </div>
                            <button class="block text-center BtnWarning"><i class="fa fa-lock"></i>{{Lang::get('frontend/general.sign-up')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <div id="UyelikSozlesme" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><a data-dismiss="modal" class="close"><i class="fa fa-times"></i></a>
                    <h3 class="modal-title">{!! $sozlesme->{'title_'.$defLocale} !!}</h3>
                </div>
                <div class="modal-body" style="font-size: smaller;">
                    {!! $sozlesme->{'content_'.$defLocale} !!}
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="BtnWarning inline-block mr-15"><i class="fa fa-chevron-right"></i><span>{{Lang::get('frontend/general.close')}}</span></a>
                </div>
            </div>
        </div>
    </div>
    <!--page level js ends-->
@stop
