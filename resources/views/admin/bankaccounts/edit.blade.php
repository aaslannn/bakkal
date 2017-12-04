@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('bankaccounts/title.edit')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
<style>
    .IBAN{text-transform: uppercase;}
</style>
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('bankaccounts/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/bankaccounts') }}">@lang('bankaccounts/title.bankaccounts')</a></li>
        <li class="active">@lang('bankaccounts/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="bank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('bankaccounts/title.edit')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group {{ $errors->first('bankaAdi', 'has-error') }}">
                            <label for="bankaAdi" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.bankaAdi')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="bankaAdi" name="bankaAdi" class="form-control" placeholder="" value="{{{ Input::old('bankaAdi', $bankaccount->bankaAdi) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('bankaAdi', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('hesapTuru', 'has-error') }}">
                            <label for="hesapTuru" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.hesapTuru')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="hesapTuru" name="hesapTuru" class="form-control" placeholder="" value="{{{ Input::old('hesapTuru', $bankaccount->hesapTuru) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('hesapTuru', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('hesapAdi', 'has-error') }}">
                            <label for="hesapAdi" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.hesapAdi')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="hesapAdi" name="hesapAdi" class="form-control" placeholder="" value="{{{ Input::old('hesapAdi', $bankaccount->hesapAdi) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('hesapAdi', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('iban', 'has-error') }}">
                            <label for="iban" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.iban')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="iban" name="iban" class="form-control IBAN" placeholder="____ ____ ____ ____ ____ ____ __" value="{{{ Input::old('iban', $bankaccount->iban) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('iban', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('subeAdi', 'has-error') }}">
                            <label for="subeAdi" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.subeAdi')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="subeAdi" name="subeAdi" class="form-control" placeholder="" value="{{{ Input::old('subeAdi', $bankaccount->subeAdi) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('subeAdi', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('subeKodu', 'has-error') }}">
                            <label for="subeKodu" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.subeKodu')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="subeKodu" name="subeKodu" class="form-control" placeholder="" value="{{{ Input::old('subeKodu', $bankaccount->subeKodu) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('subeKodu', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('hesapNo', 'has-error') }}">
                            <label for="hesapNo" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.hesapNo')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="hesapNo" name="hesapNo" class="form-control" placeholder="" value="{{{ Input::old('hesapNo', $bankaccount->hesapNo) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('hesapNo', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                @lang('bankaccounts/form.status')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if($bankaccount->status === 1) selected="selected" @endif>Aktif</option>
                                    <option value="0" @if($bankaccount->status === 0) selected="selected" @endif>Pasif</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('bankaccounts') }}">
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
    <script type="text/javascript" src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script>
        var maskedInputOptions = {
                autoclear: false
            };
        $(".IBAN").mask("aa99 9999 9999 9999 9999 9999 99", maskedInputOptions);
    </script>
@stop