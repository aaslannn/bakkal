@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title') @lang('posaccounts/title.create')  @parent @stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('posaccounts/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/posaccounts') }}">@lang('posaccounts/title.posaccounts')</a></li>
        <li class="active">
            @lang('posaccounts/title.create')
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
                        @lang('posaccounts/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group {{ $errors->first('bankname', 'has-error') }}">
                            <label for="bankname" class="col-sm-2 control-label">
                                @lang('posaccounts/form.bankaAdi')*
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="bankname" name="bankname" class="form-control" placeholder="" value="{{{ Input::old('bankname') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('bankname', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('bankhandle', 'has-error') }}">
                            <label for="bankhandle" class="col-sm-2 control-label">
                                @lang('posaccounts/form.uniqueName')*
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="bankhandle" name="bankhandle" class="form-control" placeholder="" value="{{{ Input::old('bankhandle') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('bankhandle', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>   
                        <div class="form-group {{ $errors->first('cardname', 'has-error') }}">
                            <label for="cardname" class="col-sm-2 control-label">
                                @lang('posaccounts/form.kartAdi')*
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="cardname" name="cardname" class="form-control" placeholder="" value="{{{ Input::old('cardname') }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('cardname', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>                       
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                @lang('posaccounts/form.status')
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
                        <div class="form-group {{ $errors->first('icon', 'has-error') }}">
                            <label for="icon" class="col-sm-2 control-label">
                                @lang('posaccounts/form.icon')
                            </label>
                            <div class="col-sm-5">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 190px; height: 40px;">
                                        <img src="{{ asset('assets/js/holder.js/100%x100%') }}" alt="icon">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:190px; max-height:40px;"></div>
                                    <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">İkon Seçiniz</span>
                                                        <span class="fileinput-exists">Değiştir</span>
                                                        <input id="icon" name="icon" type="file" class="form-control" />
                                                    </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('icon', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('taksit', 'has-error') }}">
                            <label for="taksit" class="col-sm-2 control-label">
                                @lang('posaccounts/form.taksitlendirme')
                            </label>
                            <div class="col-sm-5">
                                <?php echo Form::select('taksit', \App\Sabit::itemStatus(), Input::old('taksit'), array('class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('taksit', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('taksitler', 'has-error') }}">
                            <label for="taksit" class="col-sm-2 control-label">
                                @lang('posaccounts/form.taksitoran')
                            </label>
                            <div class="col-sm-5">
                                @for($i=2;$i<=12;$i++)
                                    <div class="col-sm-3">{{ $i }} Taksit (%): </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="taksit{{ $i }}" name="taksitler[{{ $i }}]" class="form-control" placeholder="" value="-"> <span class="help-block"></span>
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                @endfor
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('taksitler', '<span class="help-block">:message</span> ') !!}
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
        <!-- begining of page level js -->
@stop
