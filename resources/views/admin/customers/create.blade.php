@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Müşteri Ekle
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Yeni Müşteri</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/customers') }}">@lang('customers/title.customers')</a></li>
        <li class="active">Müşteri Ekle</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                        Yeni Müşteri Ekle
                    </h3>
                    <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">

                    <!--main content-->
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('create/customer') }}" method="POST" enctype="multipart/form-data">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                    <label for="first_name" class="col-sm-2 control-label">İsim *</label>
                                    <div class="col-sm-5">
                                        <input id="first_name" name="first_name" type="text" placeholder="" class="form-control required" value="{{{ Input::old('first_name') }}}" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('first_name', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                    <label for="last_name" class="col-sm-2 control-label">Soyisim *</label>
                                    <div class="col-sm-5">
                                        <input id="last_name" name="last_name" type="text" placeholder="" class="form-control required" value="{{{ Input::old('last_name') }}}" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('last_name', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    <label for="email" class="col-sm-2 control-label">E-Mail *</label>
                                    <div class="col-sm-5">
                                        <input id="email" name="email" placeholder="" type="text" class="form-control required email" value="{{{ Input::old('email') }}}" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('email', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    <label for="password" class="col-sm-2 control-label">Şifre *</label>
                                    <div class="col-sm-5">
                                        <input id="password" name="password" type="password" placeholder="" class="form-control required" value="{{{ Input::old('password') }}}" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('password', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                    <label for="password_confirm" class="col-sm-2 control-label">Şifre (Tekrar) *</label>
                                    <div class="col-sm-5">
                                        <input id="password_confirm" name="password_confirm" type="password" placeholder="" class="form-control required" value="{{{ Input::old('password_confirm') }}}" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('password_confirm', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Cinsiyet</label>
                                    <div class="col-sm-5">
                                        <?php echo Form::select('gender', \App\Sabit::getGender(), null, array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dob" class="col-sm-2 control-label">Doğum Tarihi</label>
                                    <div class="col-sm-5">
                                        <input id="dob" name="dob" type="text" class="form-control" data-mask="99-99-9999" value="{{{ Input::old('dob') }}}" placeholder="dd-mm-yyyy" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bio" class="col-sm-2 control-label">Notlar</label>
                                    <div class="col-sm-5">
                                        <textarea name="bio" id="bio" class="form-control" rows="4">{{{ Input::old('bio') }}}</textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="country" class="col-sm-2 control-label">Ülke</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="country" name="country">
                                            @foreach($countries as $ulke)
                                                <option value="{{ $ulke->id }}" @if($ulke->varsayilan == 1) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">Eyalet</label>
                                    <div class="col-sm-5">
                                        <input id="state" name="state" type="text" class="form-control" value="{{{ Input::old('state') }}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="city" class="col-sm-2 control-label">Şehir</label>
                                    <div class="col-sm-5">
                                        <input id="city" name="city" type="text" class="form-control" value="{{{ Input::old('city') }}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="town" class="col-sm-2 control-label">İlçe</label>
                                    <div class="col-sm-5">
                                        <input id="town" name="town" type="text" class="form-control" value="{{{ Input::old('town') }}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Adres</label>
                                    <div class="col-sm-5">
                                        <input id="address" name="address" type="text" class="form-control" value="{{{ Input::old('address') }}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="activated" class="col-sm-2 control-label">
                                        Müşteri Durumu
                                    </label>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="activated" name="activated">
                                            <option value="1" selected="selected">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <a class="btn btn-danger" href="{{ route('customers') }}">
                                            @lang('button.cancel')
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            @lang('button.save')
                                        </button>
                                    </div>
                                </div>
                            
                            </form>
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
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
@stop