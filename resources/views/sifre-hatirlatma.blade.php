@extends('layouts/defaultMember')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.remindpass')}}
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
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.remindpass')}}</div>
                    <div class="DefaultBoxBody">
                        <div class="HelpBox mb-15">
                            <div class="HelpBoxIcon"><i class="fa fa-exclamation-circle"></i></div>
                            <div class="HelpBoxContent"><span>{{Lang::get('frontend/general.renewpassinfo')}}</span></div>
                        </div>
                        @include('notifications')
                        <div class="has-error">
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                        <form method="POST" action="#">
                            {{ csrf_field() }}
                            <div class="LoginInputs mb-15">
                                <input type="text" name="email" id="email" placeholder="{{Lang::get('frontend/general.emailaddress')}}" value="{{{ Input::old('email') }}}" class="form-control">
                            </div>
                            <button type="submit" class="block text-center BtnWarning"><i class="fa fa-chevron-right"></i><span>{{Lang::get('frontend/general.submit')}}</span></button>
                        </form>
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
    <!--page level js ends-->
@stop
