@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.edit-address')}}
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
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.edit-address')}}</div>
                            <div class="DefaultBoxBody">
                                <div class="has-error">
                                    @include('notifications')
                                </div>
                                <form name="addressForm" id="addressForm" method="post" action="">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.addressname')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <input type="text" name="title" class="form-control" value="{{{ Input::old('title', $adres->title) }}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.recipient')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <input type="text" name="name" class="form-control" value="{{{ Input::old('name', $adres->name) }}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('country_id', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.country')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <select class="form-control" name="country_id" id="country">
                                                        <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                        @foreach($countries as $ulke)
                                                            <option value="{{ $ulke->id }}" {!! ($adres->country_id == $ulke->id ? 'selected="selected"' : '') !!}>{{ $ulke->ulke }}</option>
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
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <select class="form-control" name="state_id" id="state">
                                                        <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" {!! ($adres->state_id == $state->id ? 'selected="selected"' : '') !!}>{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('state', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('city_id', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.city')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <select class="form-control" name="city_id" id="city">
                                                        <option value="">{{Lang::get('frontend/general.select')}}..</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ $city->id }}" {!! ($adres->city_id == $city->id ? 'selected="selected"' : '') !!}>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('city', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('adres', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.address')}}</label>
                                                <div class="InputWrapper mt-10">
                                                    <textarea type="text" name="adres" class="form-control">{{{ Input::old('adres', $adres->adres) }}}</textarea>
                                                    <div class="InputTools"><span class="Counter"><span>0 / </span><span>1000</span></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">&nbsp;</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('tel', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.tel')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-star"></i></div>
                                                    <input type="text" class="form-control TelefonNo" name="tel" data-rule-required="true" data-msg-required="Telefon Numarası Giriniz" value="{{{ Input::old('tel', $adres->tel) }}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('tel', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('tel', 'has-error') }}">
                                                <label>{{Lang::get('frontend/general.addresstype')}}</label>
                                                <?php echo Form::select('type', \App\Sabit::addressType(null,LaravelLocalization::getCurrentLocale()), $adres->type, array('class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('tel', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('tckimlik', 'has-error') }}">
                                                <label>{{Lang::get('orders/title.tcidno')}}</label>
                                                <input type="text" name="tckimlik" id="tckimlik" class="form-control KimlikNo" value="{{{ Input::old('tckimlik', $adres->tckimlik) }}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('tckimlik', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('vergino', 'has-error') }}">
                                                <label>{{Lang::get('orders/title.taxno')}}</label>
                                                <input type="text" name="vergino" class="form-control" value="{{{ Input::old('vergino', $adres->vergino) }}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('vergino', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->first('vergid', 'has-error') }}">
                                                <label>{{Lang::get('orders/title.taxadministration')}}</label>
                                                <input type="text" name="vergid" class="form-control" value="{{{ Input::old('vergid', $adres->vergid) }}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>{!! $errors->first('vergid', '<span class="help-block">:message</span> ') !!}
                                        </div>
                                    </div>
                                    <button type="submit" class="BtnWarning inline-block mt-15"><i class="fa fa-floppy-o"></i><span>{{Lang::get('frontend/general.save')}}</span></button>
                                </form>
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
    <script src="{{ asset('assets/js/frontend/events/addressevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/textareaevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
