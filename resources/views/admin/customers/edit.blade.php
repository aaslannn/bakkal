@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Müşteri Düzenle
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link rel="stylesheet" href="{{ asset('assets/vendors/wizard/jquery-steps/css/wizard.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/wizard/jquery-steps/css/jquery.steps.css') }}">
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Müşteriyi Düzenle</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/customers') }}">@lang('customers/title.customers')</a></li>
        <li class="active">Müşteri Düzenle</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                        Müşteri : {{{ $customer->first_name}}} {{{ $customer->last_name}}}
                    </h3>
                    <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">

                    <!-- errors -->
                    <div class="has-error">
                        {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                    </div>

                    <!--main content-->
                    <div class="row">

                        <div class="col-md-12">

                            <!-- BEGIN FORM WIZARD WITH VALIDATION -->
                            <form class="form-wizard form-horizontal" action="" method="POST" id="wizard-validation" enctype="multipart/form-data">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <!-- first tab -->
                                <h1>Genel Bilgiler</h1>

                                <section>
                                
                                    <div class="form-group">
                                        <label for="first_name" class="col-sm-2 control-label">İsim *</label>
                                        <div class="col-sm-5">
                                            <input id="first_name" name="first_name" type="text" placeholder="" class="form-control required" value="{{{ Input::old('first_name', $customer->first_name) }}}" />
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="last_name" class="col-sm-2 control-label">Soyisim *</label>
                                        <div class="col-sm-5">
                                            <input id="last_name" name="last_name" type="text" placeholder="" class="form-control required" value="{{{ Input::old('last_name', $customer->last_name) }}}" />
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">E-Mail *</label>
                                        <div class="col-sm-5">
                                            <input id="email" name="email" placeholder="" type="text" class="form-control required email" value="{{{ Input::old('email', $customer->email) }}}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="activated" class="col-sm-2 control-label">Durum *</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" id="activated" name="activated">
                                                <option value="1" @if($customer->activated == 1) selected="selected" @endif>Onaylı</option>
                                                <option value="0" @if($customer->activated == 0) selected="selected" @endif>Onaysız</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <p class="text-warning">Şifreyi değiştirmek istemiyorsanız aşağıdaki alanları boş bırakınız :</p>
                                        <label for="password" class="col-sm-2 control-label">Yeni Şifre *</label>
                                        <div class="col-sm-5">
                                            <input id="password" name="password" type="password" placeholder="" class="form-control" value="{{{ Input::old('password') }}}" />
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="password_confirm" class="col-sm-2 control-label">Yeni Şifre (Tekrar) *</label>
                                        <div class="col-sm-5">
                                            <input id="password_confirm" name="password_confirm" type="password" placeholder="" class="form-control" value="{{{ Input::old('password_confirm') }}}" />
                                        </div>
                                    </div>
                                    
                                    <p>(*) Zorunlu</p>
                                
                                </section>

                                <!-- second tab -->
                                <h1>Müşteri Detayları</h1>

                                <section>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Cinsiyet</label>
                                        <div class="col-sm-5">

                                            <?php echo Form::select('gender', \App\Sabit::getGender(), $customer->gender, array('class' => 'form-control')); ?>

                                        </div>
                                    </div>

                                    

                                    <div class="form-group">
                                        <label for="dob" class="col-sm-2 control-label">Doğum Tarihi</label>
                                        <div class="col-sm-5">
                                            <input id="dob" name="dob" type="text" class="form-control" data-mask="99-99-9999" value="{{{ Input::old('dob', $customer->dob) }}}" placeholder="dd-mm-yyyy" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bio" class="col-sm-2 control-label">Notlar</label>
                                        <div class="col-sm-5">
                                            <textarea name="bio" id="bio" class="form-control" rows="4">{!! Input::old('bio', $customer->bio) !!}</textarea>
                                        </div>
                                    </div>
                                
                                </section>

                                <!-- third tab -->
                                <h1>Adres Bilgileri</h1>
                                <section>

                                    <div class="form-group">
                                        <label for="country" class="col-sm-2 control-label">Ülke</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" id="country" name="country">
                                            @foreach($countries as $ulke)
                                                <option value="{{ $ulke->id }}" @if($ulke->id == $customer->country) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="state" class="col-sm-2 control-label">Eyalet</label>
                                        <div class="col-sm-5">
                                            <input id="state" name="state" type="text" class="form-control" value="{{{ Input::old('state', $customer->state) }}}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="city" class="col-sm-2 control-label">Şehir</label>
                                        <div class="col-sm-5">
                                            <input id="city" name="city" type="text" class="form-control" value="{{{ Input::old('city', $customer->city) }}}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="town" class="col-sm-2 control-label">İlçe</label>
                                        <div class="col-sm-5">
                                            <input id="town" name="town" type="text" class="form-control" value="{{{ Input::old('town', $customer->town) }}}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Adres</label>
                                        <div class="col-sm-5">
                                            <input id="address" name="address" type="text" class="form-control" value="{{{ Input::old('address', $customer->address) }}}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel" class="col-sm-2 control-label">Telefon</label>
                                        <div class="col-sm-5">
                                            <input id="tel" name="tel" type="text" class="form-control" data-mask="(999) 999-99 99" value="{{{ Input::old('tel', $customer->tel) }}}" />
                                        </div>
                                    </div>
                                </section>

                            
                            </form>
                            <!-- END FORM WIZARD WITH VALIDATION --> 
                        </div>
                    </div>
                    <!--main content end--> 
                </div>
            </div>
        </div>
    </div>
    <!--row end-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/wizard/jquery-steps/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wizard/jquery-steps/js/jquery.steps.js') }}"></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_wizard.js') }}"></script>
@stop