@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('paymethods/title.create')  @parent @stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            @lang('paymethods/title.create')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
                </a>
            </li>
            <li><a href="{{ URL::to('admin/paymethods') }}">@lang('paymethods/title.paymethods')</a></li>
            <li class="active">
                @lang('paymethods/title.create')
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('paymethods/title.create')
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group {{ $errors->first('sequence', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('paymethods/form.sequence')
                                </label>
                                <div class="col-sm-1">
                                    <input type="text" id="sequence" name="sequence" class="form-control" placeholder="" value="{{{ Input::old('sequence', $sequence) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('sequence', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <?php
                            $langs = \App\Language::whereDurum(1)->get();
                            ?>
                            @foreach($langs as $lang)
                                <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                    <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                        @lang('paymethods/form.title') [{{ strtoupper($lang->kisaltma) }}]
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma) }}}">
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group {{ $errors->first('uniqueName', 'has-error') }}">
                                <label for="uniqueName" class="col-sm-2 control-label">
                                    Benzersiz İsim*
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="uniqueName" name="uniqueName" class="form-control" placeholder="" value="{{{ Input::old('uniqueName') }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('uniqueName', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                <label for="status" class="col-sm-2 control-label">
                                    @lang('paymethods/form.status')
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
                                    <a class="btn btn-danger" href="{{ route('paymethods') }}">
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