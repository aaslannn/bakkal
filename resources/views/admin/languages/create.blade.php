@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('languages/title.create')  @parent @stop

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
        @lang('languages/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/languages') }}">@lang('languages/title.languages')</a></li>
        <li class="active">
            @lang('languages/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="bank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('languages/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group {{ $errors->first('dil', 'has-error') }}">
                            <label for="dil" class="col-sm-2 control-label">
                                @lang('languages/form.dil')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="dil" name="dil" class="form-control" placeholder="" value="{{{ Input::old('dil') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('dil', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('kisaltma', 'has-error') }}">
                            <label for="kisaltma" class="col-sm-2 control-label">
                                @lang('languages/form.kisaltma')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="kisaltma" name="kisaltma" class="form-control" placeholder="" value="{{{ Input::old('kisaltma') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('kisaltma', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('durum', 'has-error') }}">
                            <label for="durum" class="col-sm-2 control-label">
                                @lang('languages/form.durum')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="durum" name="durum">
                                    <option value="1" selected="selected">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('durum', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('varsayilan', 'has-error') }}">
                            <label for="varsayilan" class="col-sm-2 control-label">
                                @lang('languages/form.varsayilan')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="varsayilan" name="varsayilan">
                                    <option value="1" selected="selected">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('varsayilan', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>


                        <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('languages') }}">
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
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
@stop
