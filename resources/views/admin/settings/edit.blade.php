@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('settings/title.edit')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('settings/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li class="active">@lang('settings/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('settings/title.edit')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="col-md-6">
                            <h4 style="color: #EF6F6C; font-weight: 600;">Site Bilgileri</h4>
                            <div class="form-group {{ $errors->
                            first('meta_baslik', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.meta_baslik')
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" id="meta_baslik" name="meta_baslik" class="form-control" placeholder="" value="{{{ Input::old('meta_baslik', $setting->
                                meta_baslik) }}}">
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('meta_baslik', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('meta_aciklama', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.meta_aciklama')
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" id="meta_aciklama" name="meta_aciklama" class="form-control" placeholder="" value="{{{ Input::old('meta_aciklama', $setting->
                                meta_aciklama) }}}">
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('meta_aciklama', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('meta_keywords', 'has-error') }}">
                                <label for="meta_keywords" class="col-sm-3 control-label">
                                    @lang('settings/form.meta_keywords')
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" placeholder="" value="{{{ Input::old('meta_keywords', $setting->
                                meta_keywords) }}}">
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('meta_keywords', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('logo_type', 'has-error') }}">
                                <label for="logo_type" class="col-sm-3 control-label">
                                    @lang('settings/form.logo_type')
                                </label>
                                <div class="col-sm-3">
                                    {!! Form::select('logo_type', \App\Sabit::logoType(),  $setting->logo_type, array('class' => 'form-control', 'id' => 'logoType')) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('logo_type', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="logotypeImage">
                                <div class="form-group {{ $errors->first('logo', 'has-error') }}">
                                    <label for="logo" class="col-sm-3 control-label">
                                        @lang('settings/form.logo') (230*70)
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 240px; height: 80px;">
                                                @if($setting->logo)
                                                    <img src="{{{ url('/').'/uploads/'.$setting->logo }}}" alt="logo">
                                                @else
                                                    <img src="{{ asset('assets/js/holder.js/100%x100%') }}" alt="logo">
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 240px; max-height: 80px;"></div>
                                            <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Logo Seçiniz</span>
                                                        <span class="fileinput-exists">Değiştir</span>
                                                        <input id="logo" name="logo" type="file" class="form-control" />
                                                    </span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('logo', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="logotypeText">
                                <div class="form-group {{ $errors->first('logo_text', 'has-error') }}">
                                    <label for="logo_text" class="col-sm-3 control-label">
                                        @lang('settings/form.logo_text')
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="logo_text" name="logo_text" class="form-control" placeholder="" value="{{{ Input::old('logo_text', $setting->
                                logo_text) }}}" maxlength="35">
                                    </div>
                                    <div class="col-sm-3">
                                        {!! $errors->first('logo_text', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->first('logo_color', 'has-error') }}">
                                    <label for="logo_color" class="col-sm-3 control-label">
                                        @lang('settings/form.logo_color')
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="logo_color" name="logo_color" class="form-control" placeholder="#f49525" value="{{{ Input::old('logo_color', $setting->logo_color) }}}" maxlength="35">
                                    </div>
                                    <div class="col-sm-3"> <span class="help-block">ör: #f49525</span>
                                        {!! $errors->first('logo_color', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->first('logo_fontsize', 'has-error') }}">
                                    <label for="logo_fontsize" class="col-sm-3 control-label">
                                        @lang('settings/form.logo_fontsize')
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" id="logo_fontsize" name="logo_fontsize" class="form-control" placeholder="" value="{{{ Input::old('logo_fontsize', $setting->
                                logo_fontsize) }}}" maxlength="2">
                                    </div>
                                    <div class="col-sm-6"> <span class="help-block">ör: 22</span>
                                        {!! $errors->first('logo_fontsize', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('favicon', 'has-error') }}">
                                <label for="favicon" class="col-sm-3 control-label">
                                    @lang('settings/form.favicon')
                                </label>
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 50px; height: 50px;">
                                            @if($setting->favicon)
                                                <img src="{{{ url('/').'/uploads/'.$setting->favicon }}}" alt="favicon">
                                            @else
                                                <img src="{{ asset('assets/js/holder.js/100%x100%') }}" alt="favicon">
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 50px; max-height: 50px;"></div>
                                        <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Favicon Seçiniz</span>
                                                        <span class="fileinput-exists">Değiştir</span>
                                                        <input id="favicon" name="favicon" type="file" class="form-control" />
                                                    </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('logo', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('catalog', 'has-error') }}">
                                <label for="catalog" class="col-sm-3 control-label">
                                    @lang('settings/form.catalog')
                                </label>
                                <div class="col-sm-6">
                                    @if($setting->catalog)
                                        <div style="margin-bottom: 8px;">
                                        Varolan Katalog : <a href="{{{ url('/').'/uploads/'.$setting->catalog }}}" target="_blank">{{ $setting->catalog }}</a>
                                        <a href="?delCat=1" style="color: #FF0000;">[Sil]</a>
                                        </div>
                                    @endif
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">PDF Seçiniz</span>
                                            <span class="fileinput-exists">Değiştir</span>
                                            <input type="file" name="catalog"></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('catalog', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('featured_count', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.featured_count')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="featured_count" name="featured_count" class="form-control" placeholder="" value="{{{ Input::old('featured_count', $setting->
                                featured_count) }}}" required>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('featured_count', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('para_birim', 'has-error') }}">
                                <label for="para_birim" class="col-sm-3 control-label">
                                    @lang('settings/form.para_birim')
                                </label>
                                <div class="col-sm-2">
                                    <?php echo Form::select('para_birim', \App\Sabit::paraBirimi(), $setting->para_birim, array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-7">
                                    <span class="help-block"><strong style="color: #FF0000;">Dikkat:</strong> Tüm ürünlerin para birimlerini etkiler!</span>
                                    {!! $errors->first('para_birim', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('dinamik_stok', 'has-error') }}">
                                <label for="dinamik_stok" class="col-sm-3 control-label">
                                    Dinamik Stoklama
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="dinamik_stok" name="dinamik_stok">
                                        <option value="1" @if($setting->dinamik_stok === 1) selected="selected" @endif>Evet</option>
                                        <option value="0" @if($setting->dinamik_stok === 0) selected="selected" @endif>Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-7"> <span class="help-block"><strong>Evet :</strong> Ürünler stok adedine göre sipariş edilir, stok düşer.<br><strong>Hayır :</strong> Ürünün stok adedi değişmez.</span>
                                    {!! $errors->first('dinamik_stok', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('def_uzunluk', 'has-error') }}">
                                <label for="def_uzunluk" class="col-sm-3 control-label">
                                    @lang('settings/form.def_uzunluk')
                                </label>
                                <div class="col-sm-2">
                                    <?php echo Form::select('def_uzunluk', \App\Sabit::dimensionLength(), $setting->def_uzunluk, array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-7">
                                    {!! $errors->first('def_uzunluk', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('def_agirlik', 'has-error') }}">
                                <label for="def_agirlik" class="col-sm-3 control-label">
                                    @lang('settings/form.def_agirlik')
                                </label>
                                <div class="col-sm-2">
                                    <?php echo Form::select('def_agirlik', \App\Sabit::weightLength(), $setting->def_agirlik, array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-7">
                                    {!! $errors->first('def_agirlik', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>


                            <div class="form-group {{ $errors->first('facebook_login', 'has-error') }}">
                                <label for="facebook_login" class="col-sm-3 control-label">
                                    Facebook ile Bağlan
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="facebook_login" name="facebook_login">
                                        <option value="1" @if($setting->facebook_login === 1) selected="selected" @endif>Evet</option>
                                        <option value="0" @if($setting->facebook_login === 0) selected="selected" @endif>Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    {!! $errors->first('facebook_login', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('twitter_login', 'has-error') }}">
                                <label for="twitter_login" class="col-sm-3 control-label">
                                    Twitter ile Bağlan
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="twitter_login" name="twitter_login">
                                        <option value="1" @if($setting->twitter_login === 1) selected="selected" @endif>Evet</option>
                                        <option value="0" @if($setting->twitter_login === 0) selected="selected" @endif>Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    {!! $errors->first('twitter_login', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('google_meta', 'has-error') }}">
                                <label for="google_meta" class="col-sm-3 control-label">
                                    @lang('settings/form.google_meta')
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" id="google_meta" name="google_meta" class="form-control" placeholder="" value="{{{ Input::old('google_meta', $setting->google_meta) }}}">
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('google_meta', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('google_analytics', 'has-error') }}">
                                <label for="google_analytics" class="col-sm-3 control-label">
                                    @lang('settings/form.google_analytics')
                                </label>
                                <div class="col-sm-6">
                                <textarea class="form-control" id="google_analytics" name="google_analytics" placeholder="" rows="4">{{{ Input::old('google_analytics', $setting->
                                google_analytics) }}}</textarea>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('google_analytics', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('site_durum', 'has-error') }}">
                                <label for="site_durum" class="col-sm-3 control-label">
                                    @lang('settings/form.site_durum')
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="site_durum" name="site_durum">
                                        <option value="1" @if($setting->site_durum === 1) selected="selected" @endif>Aktif</option>
                                        <option value="0" @if($setting->site_durum === 0) selected="selected" @endif>Pasif</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('site_durum', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('theme', 'has-error') }}">
                                <label for="theme" class="col-sm-3 control-label">
                                    @lang('settings/form.theme_id')
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="theme" name="theme">
                                        @if(count($themes) > 0)
                                            @foreach($themes as $theme)
                                                <option value="{{ $theme->baslik }}" @if($setting->theme === $theme->baslik) selected="selected" @endif >{{ $theme->baslik }}</option>
                                            @endforeach
                                        @else
                                            Default
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color: #EF6F6C; font-weight: 600;">Firma Bilgileri</h4>
                            <div class="form-group {{ $errors->
                            first('isim', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.isim')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="isim" name="isim" class="form-control" placeholder="" value="{{{ Input::old('isim', $setting->
                                isim) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('isim', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('web', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.web')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="web" name="web" class="form-control" placeholder="" value="{{{ Input::old('web', $setting->
                                web) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('web', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('tel', 'has-error') }}">
                                <label for="tel" class="col-sm-3 control-label">
                                    @lang('settings/form.tel')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="tel" name="tel" class="form-control" placeholder="" value="{{{ Input::old('tel', $setting->
                                tel) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('tel', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('tel2', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.tel2')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="tel2" name="tel2" class="form-control" placeholder="" value="{{{ Input::old('tel2', $setting->
                                tel2) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('tel2', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('faks', 'has-error') }}">
                                <label for="title" class="col-sm-3 control-label">
                                    @lang('settings/form.faks')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="faks" name="faks" class="form-control" placeholder="" value="{{{ Input::old('faks', $setting->
                                faks) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('faks', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                <label for="email" class="col-sm-3 control-label">
                                    @lang('settings/form.email')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="" value="{{{ Input::old('email', $setting->
                                email) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('sip_email', 'has-error') }}">
                                <label for="sip_email" class="col-sm-3 control-label">
                                    @lang('settings/form.sip_email')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="sip_email" name="sip_email" class="form-control" placeholder="" value="{{{ Input::old('sip_email', $setting->
                                sip_email) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('sip_email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('adres', 'has-error') }}">
                                <label for="adres" class="col-sm-3 control-label">
                                    @lang('settings/form.adres')
                                </label>
                                <div class="col-sm-5">
                                <textarea class="form-control" id="adres" name="adres" placeholder="" rows="4">{{{ Input::old('adres', $setting->
                                adres) }}}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('adres', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('sicil_no', 'has-error') }}">
                                <label for="sicil_no" class="col-sm-3 control-label">
                                    @lang('settings/form.sicil_no')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="sicil_no" name="sicil_no" class="form-control" placeholder="" value="{{{ Input::old('sicil_no', $setting->
                                sicil_no) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('sicil_no', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('vergi_no', 'has-error') }}">
                                <label for="vergi_no" class="col-sm-3 control-label">
                                    @lang('settings/form.vergi_no')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="vergi_no" name="vergi_no" class="form-control" placeholder="" value="{{{ Input::old('vergi_no', $setting->
                                vergi_no) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('vergi_no', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                            first('vergi_d', 'has-error') }}">
                                <label for="vergi_d" class="col-sm-3 control-label">
                                    @lang('settings/form.vergi_d')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="vergi_d" name="vergi_d" class="form-control" placeholder="" value="{{{ Input::old('vergi_d', $setting->vergi_d) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('vergi_no', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-4">
                                    <a class="btn btn-danger" href="{{ route('settings') }}">
                                        @lang('button.cancel')
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        @lang('button.save')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendors/colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script>
        $('#logo_color').colorpicker();

        $("#logoType").on("change", function(){
            $(".logotypeImage").toggle(($(this).val() == 0?true:false));
            $(".logotypeText").toggle(($(this).val() == 1?true:false));
        }).trigger("change");
    </script>
@stop