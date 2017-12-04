@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.member-info')}}
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
                <li>{{Lang::get('frontend/general.myaccount')}}</li>
            </ol>
        </div>
        <div class="AccountSettings">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('uye.menu')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox AccountDetail">
                            <div class="DefaultBoxHeading Tabbed">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#generalsettings" data-toggle="tab">{{Lang::get('frontend/general.general-info')}}</a></li>
                                    <li><a id="ReadAddCommentTab" href="#changepassword" data-toggle="tab">{{Lang::get('frontend/general.change-pass')}}</a></li>
                                </ul>
                            </div>
                            <div class="DefaultBoxBody">
                                <div class="tab-content">
                                    <div id="generalsettings" class="tab-pane active">
                                        <div class="HelpBox mb-15">
                                            <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                                            <div class="HelpBoxContent"><b>{{Lang::get('frontend/general.aboutthispage')}}</b><span>{{Lang::get('frontend/general.profilehelptext')}}</span></div>
                                        </div>
                                        <div class="has-error">
                                            @include('notifications')
                                        </div>
                                        <form name="editProfile" method="post" action="">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="_islem" value="editProfile" />

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.first-name')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="text" name="first_name" class="form-control" value="{{{ Input::old('first_name', $uye->first_name) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('first_name', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.last-name')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="text" name="last_name" class="form-control" value="{{{ Input::old('last_name', $uye->last_name) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('last_name', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.emailaddress')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="text" class="form-control" name="email"  value="{{{ Input::old('email', $uye->email) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('email', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('dob', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.birthdate')}}</label>
                                                        <input name="dob" type="text" class="form-control Dob" value="{{{ Input::old('dob', $uye->dob) }}}" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('dob', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('gender', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.gender')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <?php echo Form::select('gender', \App\Sabit::getGender(null,LaravelLocalization::getCurrentLocale()), $uye->gender, array('class' => 'form-control')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('gender', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('tckimlik', 'has-error') }}">
                                                        <label>{{Lang::get('orders/title.tcidno')}}</label>
                                                        <input type="text" name="tckimlik" class="form-control KimlikNo" value="{{{ Input::old('tckimlik', $uye->tckimlik) }}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('tckimlik', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('tel', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.tel')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="text" name="tel" class="form-control TelefonNo" value="{{{ Input::old('tel', $uye->tel) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('tel', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('country', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.country')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <select class="form-control" name="country" id="country">
                                                                <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                                @foreach($countries as $ulke)
                                                                    <option value="{{ $ulke->id }}" {!! ($uye->country == $ulke->id ? 'selected="selected"' : '') !!}>{{ $ulke->ulke }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('country', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('state', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.state')}}</label>
                                                        <input type="text" name="state" class="form-control" value="{{{ Input::old('state', $uye->state) }}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('state', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('city', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.city')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="text" name="city" class="form-control" value="{{{ Input::old('city', $uye->city) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('city', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('town', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.town')}}</label>
                                                        <input type="text" name="town" class="form-control" value="{{{ Input::old('town', $uye->town) }}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('town', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('state', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.address')}}</label>
                                                        <div class="InputWrapper mt-10">
                                                            <textarea type="text" name="address" class="form-control">{{{ Input::old('address', $uye->address) }}}</textarea>
                                                            <div class="InputTools"><span class="Counter"><span>0 / </span><span>1000</span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">&nbsp;</div>
                                            </div>
                                            <button type="submit" class="BtnWarning inline-block mt-15"><i class="fa fa-floppy-o"></i><span>{{Lang::get('frontend/general.save')}}</span></button>
                                        </form>
                                    </div>
                                    <div id="changepassword" class="tab-pane">
                                        <div class="HelpBox mb-15">
                                            <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                                            <div class="HelpBoxContent"><b>{{Lang::get('frontend/general.aboutthispage')}}</b><span>{{Lang::get('frontend/general.passchangehelptext')}}</span></div>
                                        </div>
                                        <div class="has-error">
                                            @include('notifications')
                                        </div>
                                        <form name="changePass" method="post" action="">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="_islem" value="changePass" />

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('sifre', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.current-pass')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="password" name="sifre" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('sifre', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('yeni_sifre', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.new-pass')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="password" name="yeni_sifre" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('yeni_sifre', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->first('yeni_sifre_tekrar', 'has-error') }}">
                                                        <label>{{Lang::get('frontend/general.new-pass')}} ({{Lang::get('frontend/general.again')}})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                            <input type="password" name="yeni_sifre_tekrar" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <br>{!! $errors->first('yeni_sifre_tekrar', '<span class="help-block">:message</span> ') !!}
                                                </div>
                                            </div>
                                            <button type="submit" class="BtnWarning inline-block mt-10"><i class="fa fa-floppy-o"></i><span>{{Lang::get('frontend/general.update')}}</span></button>
                                        </form>
                                    </div>
                                </div>
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
        <script src="{{ asset('assets/js/frontend/events/accountevents.js') }}" type="text/javascript"></script>
        @if(Session::has('changepassword'))
            <script>triggerChangePassword();</script>
        @endif
        <script src="{{ asset('assets/js/frontend/events/textareaevents.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/input-mask/jquery.inputmask.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/input-mask/jquery.inputmask.date.extensions.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/input-mask/jquery.inputmask.extensions.js') }}"  type="text/javascript"></script>

    <!--page level js ends-->
@stop
