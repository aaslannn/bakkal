@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('translations/title.edit')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('translations/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/translations') }}">@lang('translations/title.translations')</a></li>
        <li class="active">@lang('translations/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="bank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('translations/title.edit')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="slug" class="col-sm-2 control-label">
                                &nbsp;
                            </label>
                            <div class="col-sm-8">
                                <p class="text-danger">
                                    <i>Değişken isimlerinin başına <strong>(:)</strong> işareti koyunuz.<br>
                                    Çevirileri eklerken siteyi etkilemeyecek kodlar (tag) kullanabilirsiniz ( br,strong gibi..)<br></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('slug', 'has-error') }}">
                            <label for="slug" class="col-sm-2 control-label">
                                @lang('translations/form.slug')
                            </label>
                            <div class="col-sm-3">
                                <input type="text" id="slug" name="slug" required="required" class="form-control" placeholder="" value="{{{ Input::old('slug', $trans->slug) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('slug', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <?php
                        $langs = \App\Language::whereDurum(1)->get();
                        ?>
                        @foreach($langs as $lang)
                            <div class="form-group {{ $errors->first('lang_'.$lang->kisaltma, 'has-error') }}">
                                <label for="lang_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                    {{ $lang->dil }}
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="lang_{{ $lang->kisaltma }}" name="lang_{{ $lang->kisaltma }}" class="form-control" placeholder=""
                                           value="{{{ Input::old('lang_'.$lang->kisaltma , $trans->{'lang_'.$lang->kisaltma}) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('lang_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('translations') }}">
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