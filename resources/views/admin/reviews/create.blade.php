@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('products/title.create')  @parent @stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/vendors/summernote/dist/summernote-bs3.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
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
        <li>@lang('products/title.products')</li>
        <li class="active">
            @lang('products/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="tag" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('products/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        @if(count($categories) > 0)
                        <div class="form-group {{ $errors->first('cat_id', 'has-error') }}">
                            <label for="cat_id" class="col-sm-2 control-label">
                                @lang('products/form.category')
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" id="cat_id" name="cat_id">
                                        <option value="0"  selected="selected">Kategori Seçiniz</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" @if($cat->id == Input::old('cat_id')) selected="selected" @endif>{{ $cat->title }}</option>
                                            @if($cat->subcats()->count() > 0)
                                                <?php $subcats = $cat->subcats()->get(); ?>
                                                @foreach($subcats as $subcat)
                                                    <option value="{{ $subcat->id }}" @if($subcat->id == Input::old('cat_id')) selected="selected" @endif> &nbsp;&nbsp;&nbsp; &raquo; {{ $subcat->title }}</option>
                                                    <?php $subcats2 = $subcat->subcats()->get(); ?>
                                                    @foreach($subcats2 as $subcat2)
                                                        <option value="{{ $subcat2->id }}" @if($subcat2->id == Input::old('cat_id')) selected="selected" @endif> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &raquo; {{ $subcat2->title }}</option>
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
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('products/form.name')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="title" name="title" class="form-control" placeholder="" value="{{{ Input::old('title') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('code', 'has-error') }}">
                            <label for="code" class="col-sm-2 control-label">
                                @lang('products/form.code')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="code" name="code" class="form-control" placeholder="" value="{{{ Input::old('code') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('code', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('brand', 'has-error') }}">
                            <label for="brand" class="col-sm-2 control-label">
                                @lang('products/form.brand')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="brand" name="brand" class="form-control" placeholder="" value="{{{ Input::old('brand') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('brand', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('content', 'has-error') }}">
                            <label for="content" class="col-sm-2 control-label">
                                @lang('products/form.content')
                            </label>
                            <div class="col-sm-5">
                                <textarea class="form-control" id="ckeditor_full" name="content">{{{ Input::old('content') }}}</textarea>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('content', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('price', 'has-error') }}">
                            <label for="price" class="col-sm-2 control-label">
                                @lang('products/form.price')
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="price" name="price" class="form-control" placeholder="" value="{{{ Input::old('price') }}}">
                            </div>
                            <div class="col-sm-2">  <span class="help-block">ör: 2550.50</span>
                                {!! $errors->first('price', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('discount_price', 'has-error') }}">
                            <label for="price" class="col-sm-2 control-label">
                                @lang('products/form.discount_price')
                            </label>
                            <div class="col-sm-2">
                                <label for="discount"><input type="checkbox" name="discount" id="discount" value="1"> @lang('products/form.discount_yes')</label>
                                <input type="text" id="discount_price" name="discount_price" class="form-control" placeholder="" value="{{{ Input::old('discount_price') }}}">
                            </div>
                            <div class="col-sm-2">  <span class="help-block">ör: 2550.50</span>
                                {!! $errors->first('discount_price', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('currency', 'has-error') }}">
                            <label for="cat_id" class="col-sm-2 control-label">
                                @lang('products/form.currency')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="currency" name="currency">
                                    <option value="QAR" @if(Input::old('currency') == "QAR") selected="selected" @endif>QAR</option>
                                    <option value="TL" @if(Input::old('currency') == "TL") selected="selected" @endif>TL</option>
                                    <option value="USD" @if(Input::old('currency') == "USD") selected="selected" @endif>USD</option>
                                    <option value="EUR" @if(Input::old('currency') == "EUR") selected="selected" @endif>EUR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('currency', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('kdv', 'has-error') }}">
                            <label for="cat_id" class="col-sm-2 control-label">
                                @lang('products/form.kdv')
                            </label>
                            <div class="col-sm-2">

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa">%</i>
                                    </div>
                                    <input type="text" id="kdv" name="kdv" class="form-control" placeholder="" value="{{{ Input::old('kdv', '18') }}}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('kdv', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('stock', 'has-error') }}">
                            <label for="price" class="col-sm-2 control-label">
                                @lang('products/form.stockstatus')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="stock" name="stock">
                                    <option value="1" selected="selected">Mevcut</option>
                                    <option value="0" >Yok</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('stock', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                @lang('products/form.status')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" selected="selected">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('home', 'has-error') }}">
                            <label for="home" class="col-sm-2 control-label">
                                @lang('products/form.home')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="home" name="home">
                                    <option value="1" selected="selected">Evet</option>
                                    <option value="0">Hayır</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('new', 'has-error') }}">
                            <label for="new" class="col-sm-2 control-label">
                                @lang('products/form.new')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="new" name="new">
                                    <option value="1" selected="selected">Evet</option>
                                    <option value="0">Hayır</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('new', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('chosen', 'has-error') }}">
                            <label for="chosen" class="col-sm-2 control-label">
                                @lang('products/form.chosen')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="chosen" name="chosen">
                                    <option value="1">Evet</option>
                                    <option value="0" selected="selected">Hayır</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('chosen', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
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
        <!-- begining of page level js -->
<!-- Bootstrap WYSIHTML5 -->
<script  src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}"  type="text/javascript" ></script>
<script  src="{{ asset('assets/vendors/tinymce/js/tinymce/tinymce.min.js') }}"  type="text/javascript" ></script>
<script  src="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/vendors/summernote/dist/summernote.min.js') }}"  type="text/javascript"></script>
<script  src="{{ asset('assets/js/pages/editor.js') }}"  type="text/javascript"></script>
@stop
