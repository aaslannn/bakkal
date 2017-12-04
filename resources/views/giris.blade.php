@extends('layouts/defaultMember')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.sign-in')}}
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
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.sign-in')}}</div>
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
                        </div>
                        <div class="LoginInputs">
                            <input type="text" name="email" id="email" placeholder="{{Lang::get('frontend/general.emailaddress')}}" value="{{{ Input::old('email') }}}" class="form-control mb-5" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enteremailaddress')}}">
                            <input type="password" name="password" placeholder="{{Lang::get('frontend/general.password')}}" class="form-control" data-rule-required="true" data-msg-required="{{Lang::get('frontend/general.enterurpassword')}}">
                        </div>
                        <div class="LoginTools">
                            <div class="checkbox pull-left">
                                <label>
                                    <input type="checkbox" name="remember">{{Lang::get('frontend/general.rememberme')}}
                                </label>
                            </div><a href="{{{ url('/sifre-hatirlatma') }}}" class="pull-right mt-10">{{Lang::get('frontend/general.forgotpassword')}}</a>
                            <div class="clearfix"></div>
                        </div>
                        <button class="block text-center BtnWarning"><i class="fa fa-lock"></i>{{Lang::get('frontend/general.login')}}</button>
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
    <!--page level js ends-->
@stop
