@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('posaccounts/title.edit')
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
        @lang('posaccounts/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/posaccounts') }}">@lang('posaccounts/title.posaccounts')</a></li>
        <li class="active">@lang('posaccounts/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('posaccounts/title.edit')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <label for="isyerino" class="col-sm-2 control-label">
                                @lang('posaccounts/form.bankaAdi')
                            </label>
                            <div class="col-sm-10" style="padding-top: 6px;">
                                {{ $posaccount->bankname }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isyerino" class="col-sm-2 control-label">
                                @lang('posaccounts/form.uniqueName')
                            </label>
                            <div class="col-sm-10" style="padding-top: 6px;">
                                {{ $posaccount->bankhandle }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isyerino" class="col-sm-2 control-label">
                                @lang('posaccounts/form.kartAdi')
                            </label>
                            <div class="col-sm-10" style="padding-top: 6px;">
                                {{ $posaccount->cardname }}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('isyerino', 'has-error') }}">
                            <label for="isyerino" class="col-sm-2 control-label">
                                @lang('posaccounts/form.isyerino')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="isyerino" name="isyerino" class="form-control" placeholder="" value="{{{ Input::old('isyerino', $posaccount->isyerino) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('isyerino', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('kullanici', 'has-error') }}">
                            <label for="kullanici" class="col-sm-2 control-label">
                                @lang('posaccounts/form.kullanici')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="kullanici" name="kullanici" class="form-control" placeholder="" value="{{{ Input::old('kullanici', $posaccount->kullanici) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('kullanici', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('sifre', 'has-error') }}">
                            <label for="sifre" class="col-sm-2 control-label">
                                @lang('posaccounts/form.sifre')
                            </label>
                            <div class="col-sm-5">
                                <input type="password" id="pass" name="sifre" class="form-control" placeholder="" value="{{{ Input::old('sifre', $posaccount->sifre) }}}">
                            </div>
                            <div class="col-sm-5">
                                <a id="showPass" class="btn btn-info">Şifreyi göstermek için basılı tutunuz</a>
                                {!! $errors->first('sifre', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('terminalno', 'has-error') }}">
                            <label for="terminalno" class="col-sm-2 control-label">
                                @lang('posaccounts/form.terminalno')
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="terminalno" name="terminalno" class="form-control" placeholder="" value="{{{ Input::old('terminalno', $posaccount->terminalno) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('terminalno', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('taksit', 'has-error') }}">
                            <label for="taksit" class="col-sm-2 control-label">
                                @lang('posaccounts/form.taksitlendirme')
                            </label>
                            <div class="col-sm-5">
                                <?php echo Form::select('taksit', \App\Sabit::itemStatus(), Input::old('taksit', $posaccount->taksit), array('class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('taksit', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('mintaksit', 'has-error') }}">
                            <label for="mintaksit" class="col-sm-2 control-label">
                                @lang('posaccounts/form.mintaksit')
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="mintaksit" name="mintaksit" class="form-control" placeholder="" value="{{{ Input::old('mintaksit', $posaccount->mintaksit) }}}">
                            </div>
                            <div class="col-sm-4"> <span class="help-block">ör: 100.00</span>
                                {!! $errors->first('mintaksit', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('taksitler', 'has-error') }}">
                            <label for="taksit" class="col-sm-2 control-label">
                                @lang('posaccounts/form.taksitoran')
                            </label>
                            <div class="col-sm-5">
                                <?php
                                $taksitler = json_decode($posaccount->taksitler);
                                $taksit = array();
                                foreach($taksitler as $key => $val)
                                {
                                    $taksit[$key] = $val;
                                }
                                ?>
                                @for($i=2;$i<=12;$i++)
                                    <div class="col-sm-3">{{ $i }} Taksit (%): </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="taksit{{ $i }}" name="taksitler[{{ $i }}]" class="form-control" placeholder="" value="{{{ Input::old('taksitler['.$i.']', $taksit[$i]) }}}"> <span class="help-block"></span>
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                @endfor
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('taksitler', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                @lang('posaccounts/form.status')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if($posaccount->status === 1) selected="selected" @endif>Aktif</option>
                                    <option value="0" @if($posaccount->status === 0) selected="selected" @endif>Pasif</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('posaccounts') }}">
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
    <script>
        var timeoutId = 0,
            button = $('#showPass'),
            box = $('#pass');

        button.mousedown(function () {
            timeoutId = setTimeout(function () {
                showPass('text');
            }, 300);
        }).bind('mouseup', function () {
            clearTimeout(timeoutId);
            showPass('password');
        }).click(function () {
            return false;
        });

        function showPass(val) {
            box.prop('type',val);
        }
    </script>
@stop