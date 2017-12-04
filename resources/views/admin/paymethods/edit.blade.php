@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('paymethods/title.edit')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('paymethods/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/paymethods') }}">@lang('paymethods/title.paymethods')</a></li>
        <li class="active">@lang('paymethods/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('paymethods/title.edit')
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
                                <input type="text" id="sequence" name="sequence" class="form-control" placeholder="" value="{{{ Input::old('sequence', $paymethod->sequence) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('sequence', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <?php
                        $langs = \App\Language::whereDurum(1)->get();
                        ?>
                        @foreach($langs as $lang)
                            <?php
                            $degisken = 'title_'.$lang->kisaltma;
                            ?>
                            <div class="form-group {{ $errors->first($degisken, 'has-error') }}">
                                <label for="{{ $degisken }}" class="col-sm-2 control-label">
                                    @lang('paymethods/form.title') [{{ strtoupper($lang->kisaltma) }}]
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="{{ $degisken }}" name="{{ $degisken }}" class="form-control" placeholder="" value="{{{ Input::old($degisken, $paymethod->$degisken)  }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first($degisken, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                @lang('paymethods/form.status')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if($paymethod->status === 1) selected="selected" @endif>Aktif</option>
                                    <option value="0" @if($paymethod->status === 0) selected="selected" @endif>Pasif</option>
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

{{-- page level scripts --}}
@section('footer_scripts')
@stop