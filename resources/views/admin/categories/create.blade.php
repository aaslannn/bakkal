@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('categories/title.create')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('categories/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/categories') }}">@lang('categories/title.categories')</a></li>
        <li class="active">
            @lang('categories/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="sitemap" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('categories/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                        <div class="form-group {{ $errors->first('parent_id', 'has-error') }}">
                            <label for="parent_id" class="col-sm-2 control-label">
                                @lang('categories/form.parentcat')
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">Yok</option>
                                        @if(count($categories) > 0)
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" @if($cat->id == Input::old('parent_id', $catId)) selected="selected" @endif>{{ $cat->title_tr }}</option>
                                                @if($cat->subcats()->count() > 0)
                                                    <?php $subcats = $cat->subcats()->get(); ?>
                                                    @foreach($subcats as $subcat)
                                                            <option value="{{ $subcat->id }}" @if($subcat->id == Input::old('parent_id', $catId)) selected="selected" @endif> &nbsp; &raquo; {{ $subcat->title_tr }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('cat_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <?php
                        $langs = \App\Language::whereDurum(1)->get();
                        ?>
                        @foreach($langs as $lang)
                            <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                    @lang('categories/form.title') [{{ strtoupper($lang->kisaltma) }}]
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group {{ $errors->
                            first('image', 'has-error') }}">
                                <label for="image" class="col-sm-2 control-label">
                                    @lang('categories/form.image')
                                </label>
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 878px; height: 304px;">
                                            <img src="{{ asset('assets/js/holder.js/100%x100%') }}" alt="image">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 878px; max-height: 304px;"></div>
                                        <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Görsel Seçiniz</span>
                                                        <span class="fileinput-exists">Değiştir</span>
                                                        <input id="image" name="image" type="file" class="form-control" />
                                                    </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <!--
                            <div class="form-group {{ $errors->first('content', 'has-error') }}">
                                <label for="content" class="col-sm-2 control-label">
                                    @lang('categories/form.content')
                                </label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" id="ckeditor_standard" name="content">{{{ Input::old('content') }}}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('content', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            -->
                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('categories/form.status')
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

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('categories') }}">
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
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
@stop
