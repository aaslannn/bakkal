@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('discodes/title.edit')
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
            @lang('discodes/title.edit')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li><a href="{{ URL::to('admin/discodes') }}">@lang('discodes/title.discodes')</a></li>
            <li class="active">@lang('discodes/title.edit')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('discodes/title.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group {{ $errors->first('code', 'has-error') }}">
                                <label for="code" class="col-sm-2 control-label">
                                    @lang('discodes/form.code')
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" id="code" name="code" class="form-control" placeholder="" value="{{{ Input::old('code', $discode->code) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('code', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('rate', 'has-error') }}">
                                <label for="rate" class="col-sm-2 control-label">
                                    @lang('discodes/form.rate')
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" id="rate" name="rate" class="form-control" placeholder="" value="{{{ Input::old('rate', $discode->rate) }}}">
                                </div>
                                <div class="col-sm-4"> <span class="help-block">% değeri giriniz.</span>
                                    {!! $errors->first('rate', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('start_date', 'has-error') }}">
                                <label for="start_date" class="col-sm-2 control-label">
                                    @lang('discodes/form.start_date')
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" id="start_date" name="start_date" class="form-control" data-mask="99.99.9999" value="{{{ Input::old('start_date', $discode->start_date) }}}" placeholder="dd.mm.yyyy">
                                </div>
                                <div class="col-sm-4"> {!! $errors->first('start_date', '<span class="help-block">:message</span> ') !!} </div>
                            </div>
                            <div class="form-group {{ $errors->first('end_date', 'has-error') }}">
                                <label for="end_date" class="col-sm-2 control-label">
                                    @lang('discodes/form.end_date')
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" id="end_date" name="end_date" class="form-control" data-mask="99.99.9999" value="{{{ Input::old('end_date', $discode->end_date) }}}" placeholder="dd.mm.yyyy">
                                </div>
                                <div class="col-sm-4"> {!! $errors->first('end_date', '<span class="help-block">:message</span> ') !!} </div>
                            </div>
                            <div class="form-group {{ $errors->first('used', 'has-error') }}">
                                <label for="used" class="col-sm-2 control-label">
                                    @lang('discodes/form.status')
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="used" name="used">
                                        <option value="0" @if($discode->used === 0) selected="selected" @endif>@lang('discodes/form.notused')</option>
                                        <option value="1" @if($discode->used === 1) selected="selected" @endif>@lang('discodes/form.used')</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    {!! $errors->first('used', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <a class="btn btn-danger" href="{{ route('discodes') }}">
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