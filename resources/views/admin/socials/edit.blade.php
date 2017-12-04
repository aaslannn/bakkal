@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('socials/title.edit')
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
            @lang('socials/title.edit')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li><a href="{{ URL::to('admin/socials') }}">@lang('socials/title.socials')</a></li>
            <li class="active">@lang('socials/title.edit')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="share" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('socials/title.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('socials/form.title')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="name" name="title" class="form-control" placeholder="" value="{{{ Input::old('title', $social->title) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('icon', 'has-error') }}">
                                <label for="icon" class="col-sm-2 control-label">
                                    @lang('socials/form.icon')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="icon" name="icon" class="form-control" placeholder="" value="{{{ Input::old('icon', $social->icon) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('icon', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('link', 'has-error') }}">
                                <label for="link" class="col-sm-2 control-label">
                                    @lang('socials/form.link')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="link" name="link" class="form-control" placeholder="" value="{{{ Input::old('link', $social->link) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('link', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('sequence', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('socials/form.sequence')
                                </label>
                                <div class="col-sm-1">
                                    <input type="text" id="sequence" name="sequence" class="form-control" placeholder="" value="{{{ Input::old('sequence', $social->sequence) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('sequence', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('socials/form.status')
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" @if($social->status === 1) selected="selected" @endif>Aktif</option>
                                        <option value="0" @if($social->status === 0) selected="selected" @endif>Pasif</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <a class="btn btn-danger" href="{{ route('socials') }}">
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