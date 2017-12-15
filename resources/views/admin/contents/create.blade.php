@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('contents/title.create') @parent @stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
    <!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('contents/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/contents') }}">@lang('contents/title.pages')</a></li>
        <li class="active">
            @lang('contents/title.create')
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
                        @lang('contents/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                        <div class="form-group {{ $errors->first('parent_id', 'has-error') }}">
                            <label for="parent_id" class="col-sm-2 control-label">
                                @lang('contents/form.parentcat')
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" id="parent_id" name="parent_id">
                                        <option value=""  selected="selected">Yok</option>
                                        @if(count($contents) > 0)
                                            @foreach($contents as $pg)
                                                <option value="{{ $pg->id }}" @if($pg->id == Input::old('parent_id')) selected="selected" @endif>{{ $pg->title_en }}</option>
                                            @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('parent_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <?php
                        $langs = \App\Language::whereDurum(1)->get();
                        ?>
                        @foreach($langs as $lang)
                            <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                    @lang('contents/form.title') [{{ strtoupper($lang->kisaltma) }}]
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('content_'.$lang->kisaltma, 'has-error') }}">
                                <label for="content_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                    @lang('contents/form.content') [{{ strtoupper($lang->kisaltma) }}]
                                </label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" id="ckeditor_standard" name="content_{{ $lang->kisaltma }}">{{{ Input::old('content_'.$lang->kisaltma) }}}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('content_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('contents/form.status')
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
                                <a class="btn btn-danger" href="{{ route('contents') }}">
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
        <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
        <script  src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"  type="text/javascript"></script>
        <script  src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}"  type="text/javascript" ></script>
        <script  src="{{ asset('assets/js/pages/editor.js') }}"  type="text/javascript"></script>
@stop
