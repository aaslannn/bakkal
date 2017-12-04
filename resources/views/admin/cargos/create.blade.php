@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('cargos/title.create')  @parent @stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('cargos/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/cargos') }}">@lang('cargos/title.cargos')</a></li>
        <li class="active">
            @lang('cargos/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="truck" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('cargos/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('cargos/form.title')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="name" class="form-control" placeholder="" value="{{{ Input::old('name') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('price', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('cargos/form.price')
                            </label>
                            <div class="col-sm-2">
                                <div class="input-group">

                                    <input type="text" id="price" name="price" class="form-control" placeholder="" value="{{{ Input::old('price') }}}">
                                    <div class="input-group-addon">
                                        <i class="fa">TL</i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4"> <span class="help-block">ör: 6.5</span>
                                {!! $errors->first('price', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('cargos/form.status')
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
                                <a class="btn btn-danger" href="{{ route('cargos') }}">
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
@stop
