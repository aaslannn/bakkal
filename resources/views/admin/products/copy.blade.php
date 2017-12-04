@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('products/title.create')  @parent @stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/vendors/summernote/dist/summernote-bs3.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<style>
    #DiscountedPrice{display: none;}
</style>
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('products/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/products') }}">@lang('products/title.products')</a></li>
        <li class="active">
            @lang('products/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="tag" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('products/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-7">
                                <a class="btn btn-danger" href="{{ route('products') }}">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-success">@lang('button.save')</button>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('cat_id', 'has-error') }}">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="alert alert-info margin5">
                                    <strong>{{Lang::get('frontend/general.info')}}:</strong> "{{ $copy->title_tr }}" adlı ürünün Kategori, Marka, İsim, İçerik ve Ana Fiyat bilgileri kopyalanmıştır.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            @if(count($categories) > 0)
                                <div class="form-group {{ $errors->first('cat_id', 'has-error') }}">
                                    <label for="cat_id" class="col-sm-2 control-label">
                                        @lang('products/form.category')
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control required" required id="cat_id" name="cat_id">
                                            <option value=""  selected="selected">Kategori Seçiniz</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" @if($cat->id == Input::old('cat_id', $copy->cat_id)) selected="selected" @endif><strong>{{ $cat->title_tr }}</strong></option>
                                                @if($cat->subcats()->count() > 0)
                                                    <?php $subcats = $cat->subcats()->get(); ?>
                                                    @foreach($subcats as $subcat)
                                                        <option value="{{ $subcat->id }}" @if($subcat->id == Input::old('cat_id', $copy->cat_id)) selected="selected" @endif> &nbsp;&nbsp;&nbsp; &raquo; {{ $subcat->title_tr }}</option>
                                                        <?php $subcats2 = $subcat->subcats()->get(); ?>
                                                        @foreach($subcats2 as $subcat2)
                                                            <option value="{{ $subcat2->id }}" @if($subcat2->id == Input::old('cat_id', $copy->cat_id)) selected="selected" @endif> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &raquo; {{ $subcat2->title_tr }}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('cat_id', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                            @endif

                            <?php
                            $langs = \App\Language::whereDurum(1)->get();
                            ?>
                            @foreach($langs as $lang)
                                <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                    <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                        @lang('products/form.name') [{{ strtoupper($lang->kisaltma) }}]
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma , $copy->{'title_'.$lang->kisaltma}) }}}">
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group {{ $errors->first('brand_id', 'has-error') }}">
                                <label for="brand_id" class="col-sm-2 control-label">
                                    @lang('products/form.brand')
                                </label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="brand_id" name="brand_id">
                                        <option value="0">Seçiniz</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $brand->id == Input::old('brand_id', $copy->brand_id) ? 'selected="selected"' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('brand_id', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            @foreach($langs as $lang)
                                <div class="form-group {{ $errors->first('content_'.$lang->kisaltma, 'has-error') }}">
                                    <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                        @lang('products/form.content') [{{ strtoupper($lang->kisaltma) }}]
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="ckeditor_full" name="content_{{ $lang->kisaltma }}">{{{ Input::old('content_'.$lang->kisaltma , $copy->{'content_'.$lang->kisaltma}) }}}</textarea>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group {{ $errors->first('catalog', 'has-error') }}">
                                <label for="catalog" class="col-sm-2 control-label">
                                    @lang('products/form.catalog')
                                </label>
                                <div class="col-sm-6">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">PDF Seçiniz</span>
                                            <span class="fileinput-exists">Değiştir</span>
                                            <input type="file" name="file"></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                    </div>
                                </div>
                                <div class="col-sm-2"> {!! $errors->first('catalog', '<span class="help-block">:message</span> ') !!}</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group {{ $errors->first('price', 'has-error') }}">
                                <label for="price" class="col-sm-2 control-label">
                                    @lang('products/form.price')
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa">{{ $siteSetting->para_birim }}</i>
                                        </div>
                                        <input type="text" id="price" name="price" class="form-control required PriceFormat" required placeholder="" value="{{{ Input::old('price', $copy->price) }}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">  <span class="help-block">ör: 1530,00</span>
                                    {!! $errors->first('price', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount" class="col-sm-2 control-label">
                                    @lang('products/form.discount_status')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="discount" name="discount">
                                        <option value="1">Evet</option>
                                        <option value="0" selected="selected">Hayır</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('discount_price', 'has-error') }}" id="DiscountedPrice">
                                <label for="discount_price" class="col-sm-2 control-label">
                                    @lang('products/form.discount_price')
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa">{{ $siteSetting->para_birim }}</i>
                                        </div>
                                        <input type="text" id="discount_price" name="discount_price" class="form-control PriceFormat" placeholder="" value="{{{ Input::old('discount_price') }}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">  <span class="help-block">ör: 1230,50</span>
                                    {!! $errors->first('discount_price', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <!--
                        <div class="form-group {{ $errors->first('currency', 'has-error') }}">
                            <label for="cat_id" class="col-sm-2 control-label">
                                @lang('products/form.currency')
                                    </label>
                                    <div class="col-sm-4">
                                        <?php echo Form::select('currency', \App\Sabit::paraBirimi(), Input::old('currency', $siteSetting->para_birim), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        {!! $errors->first('currency', '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                                -->
                            <input type="hidden" name="currency" value="{{{ $siteSetting->para_birim }}}">
                            <div class="form-group {{ $errors->first('kdv', 'has-error') }}">
                                <label for="cat_id" class="col-sm-2 control-label">
                                    +@lang('products/form.kdv')
                                </label>
                                <div class="col-sm-4">

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa">%</i>
                                        </div>
                                        <input type="text" id="kdv" name="kdv" class="form-control" placeholder="" value="{{{ Input::old('kdv', '18') }}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('kdv', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('kargo_ucret', 'has-error') }}">
                                <label for="kargo_ucret" class="col-sm-2 control-label">
                                    @lang('products/form.kargo_ucret')
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa">{{ $siteSetting->para_birim }}</i>
                                        </div>
                                        <input type="text" id="kargo_ucret" name="kargo_ucret" class="form-control PriceFormat" placeholder="" value="{{{ Input::old('kargo_ucret') }}}">
                                    </div>
                                </div>
                                <div class="col-sm-3"> <span class="help-block">ör: 6,50</span>
                                    {!! $errors->first('kargo_ucret', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('kargo_sure', 'has-error') }}">
                                <label for="kargo_sure" class="col-sm-2 control-label">
                                    @lang('products/form.kargo_sure')
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="kargo_sure" name="kargo_sure" class="form-control StockFormat" maxlength="3"  placeholder="" value="{{{ Input::old('kargo_sure') }}}">
                                </div>
                                <div class="col-sm-2">
                                    <span class="help-block">Gün</span>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('kargo_sure', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('havale_ind_yuzde', 'has-error') }}">
                                <label for="havale_ind_yuzde" class="col-sm-2 control-label">
                                    @lang('products/form.havale_ind_yuzde')
                                </label>
                                <div class="col-sm-4">

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa">%</i>
                                        </div>
                                        <input type="text" id="havale_ind_yuzde" name="havale_ind_yuzde" class="form-control" placeholder="" value="{{{ Input::old('havale_ind_yuzde', 0) }}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('havale_ind_yuzde', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('stock', 'has-error') }}">
                                <label for="stock" class="col-sm-2 control-label">
                                    @lang('products/form.stock')
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="stock" name="stock" class="form-control required StockFormat" required  placeholder="" value="{{{ Input::old('stock', 1) }}}" maxlength="6">
                                </div>
                                <div class="col-sm-2">
                                    {!! $errors->first('stock', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('width', 'has-error') }}">
                                <label for="width" class="col-sm-2 control-label">
                                    @lang('products/form.width')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="width" name="width" class="form-control"  placeholder="" value="{{{ Input::old('width') }}}">
                                </div>
                                <div class="col-sm-2">
                                    <?php echo Form::select('width_birim', \App\Sabit::dimensionLength(), Input::old('width_birim', $siteSetting->def_uzunluk), array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('width', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('height', 'has-error') }}">
                                <label for="width" class="col-sm-2 control-label">
                                    @lang('products/form.height')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="height" name="height" class="form-control"  placeholder="" value="{{{ Input::old('height') }}}">
                                </div>
                                <div class="col-sm-2">
                                    <?php echo Form::select('height_birim', \App\Sabit::dimensionLength(), Input::old('height_birim', $siteSetting->def_uzunluk), array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('height', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('depth', 'has-error') }}">
                                <label for="width" class="col-sm-2 control-label">
                                    @lang('products/form.depth')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="depth" name="depth" class="form-control"  placeholder="" value="{{{ Input::old('depth') }}}">
                                </div>
                                <div class="col-sm-2">
                                    <?php echo Form::select('depth_birim', \App\Sabit::dimensionLength(), Input::old('depth_birim', $siteSetting->def_uzunluk), array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('depth', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('weight', 'has-error') }}">
                                <label for="weight" class="col-sm-2 control-label">
                                    @lang('products/form.weight')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="weight" name="weight" class="form-control"  placeholder="" value="{{{ Input::old('weight') }}}">
                                </div>
                                <div class="col-sm-2">
                                    <?php echo Form::select('weight_birim', \App\Sabit::weightLength(), Input::old('weight_birim', $siteSetting->def_agirlik), array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('weight', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('products/form.status')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Pasif</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('home', 'has-error') }}">
                                <label for="home" class="col-sm-2 control-label">
                                    @lang('products/form.home')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="home" name="home">
                                        <option value="1" selected="selected">Evet</option>
                                        <option value="0">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('new', 'has-error') }}">
                                <label for="new" class="col-sm-2 control-label">
                                    @lang('products/form.new')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="new" name="new">
                                        <option value="1" selected="selected">Evet</option>
                                        <option value="0">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('new', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('chosen', 'has-error') }}">
                                <label for="chosen" class="col-sm-2 control-label">
                                    @lang('products/form.chosen')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="chosen" name="chosen">
                                        <option value="1">Evet</option>
                                        <option value="0" selected="selected">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('chosen', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('hizli_gonderi', 'has-error') }}">
                                <label for="hizli_gonderi" class="col-sm-2 control-label">
                                    @lang('products/form.hizli_gonderi')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="hizli_gonderi" name="hizli_gonderi">
                                        <option value="1">Evet</option>
                                        <option value="0">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('hizli_gonderi', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('sinirli_stok', 'has-error') }}">
                                <label for="sinirli_stok" class="col-sm-2 control-label">
                                    @lang('products/form.sinirli_stok')
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="sinirli_stok" name="sinirli_stok">
                                        <option value="1">Evet</option>
                                        <option value="0">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    {!! $errors->first('sinirli_stok', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('sequence', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('products/form.sequence')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="sequence" name="sequence" class="form-control" placeholder="" value="{{{ Input::old('sequence', $sequence) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('sequence', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('images', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('products/title.pictures')
                                </label>
                                <div class="col-sm-5">
                                    {!! Form::file('images[]',array('multiple' => 'true')) !!}
                                </div>
                                <div class="col-sm-5"> <span class="help-block"><strong>CTRL</strong> ile maksimum 5 görsel ekleyebilirsiniz.</span>
                                    {!! $errors->first('images', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <p class="text-danger"><strong>Ürün Fotoğrafı Yüklerken Dikkat Etmeniz Gerekenler:</strong>
                            </p><ul>
                                <li>Görsel Boyutları <strong>4:3</strong> oranında olmalıdır.</li>
                                <li>Görsel Boyutları en az <strong>651*488</strong> piksel olmalıdır.</li>
                                <li>Kabul Edilen Dosya Biçimi : <strong>JPG</strong></li>
                                <li>Maksimum Ekleme Sayısı : <strong>5</strong></li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-7">
                                <a class="btn btn-danger" href="{{ route('products') }}">
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
        </div>
    </div>
    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
<!-- Bootstrap WYSIHTML5 -->
<script  src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}"  type="text/javascript" ></script>
<script  src="{{ asset('assets/vendors/tinymce/js/tinymce/tinymce.min.js') }}"  type="text/javascript" ></script>
<script  src="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/summernote/dist/summernote.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/js/pages/editor.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/js/jquery.price_format.2.0.min.js') }}"  type="text/javascript"></script>
<script>
    (function () {
        "use strict"
        /*
        $(".PriceFormat").priceFormat({
            prefix:"",
            //centsSeparator:",",
            centsLimit: 0,
            thousandsSeparator:"."
        });
        */
        $(".StockFormat").priceFormat({
            prefix:"",
            //centsSeparator:",",
            centsLimit: 0,
            thousandsSeparator:""
        });


        $(document).on("change", "#discount", function () {
            var disc = $('#discount').val();
            if(disc == 1)
            {
                $("#DiscountedPrice").show();
            }
            else
            {
                $("#discount_price").val('');
                $("#DiscountedPrice").hide();

            }

        });

    }());
</script>
@stop
