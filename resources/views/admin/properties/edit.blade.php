@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('products/table.properties')
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
            @lang('slides/title.edit')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li><a href="{{ URL::to('admin/slides') }}">@lang('slides/title.slides')</a></li>
            <li class="active">@lang('slides/title.edit')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="sitemap" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('slides/title.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{ route('update/prodprop', [$prop->pr_id,$prop->id]) }}">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <?php
                            $langs = \App\Language::whereDurum(1)->get();
                            ?>
                            @foreach($langs as $lang)
                                <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                    <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                        @lang('products/form.property') [{{ strtoupper($lang->kisaltma) }}]
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma, $prop->{'title_'.$lang->kisaltma}) }}}" required>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="options" class="col-sm-2 control-label">
                                    @lang('products/table.options') (Varolanlar)
                                </label>
                                <div class="col-sm-10">
                                    <?php $i = 0; ?>
                                    @if($prop->options->count() > 0)
                                        @foreach($prop->options as $option)
                                            <div class="form-group">
                                                <label for="options" class="col-sm-1 control-label">
                                                    {{ $i+1 }}.
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="oldoption_{{ $option->id }}" name="oldoptions[{{ $option->id }}]" class="form-control" placeholder="" value="{{ old('title_en', $option->title_tr) }}"><br>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="options" class="col-sm-2 control-label">
                                    @lang('products/table.options') (Yeni)
                                </label>
                                <div class="col-sm-10">
                                    @for($j=0;$j<6;$j++)
                                        <div class="form-group">
                                            <label for="options" class="col-sm-1 control-label">
                                                {{ $j+1 }}.
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" id="option_{{ $j }}" name="options[{{ $j }}]" class="form-control" placeholder=""><br>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <a class="btn btn-danger" href="{{ route('prodproperties', $prop->pr_id) }}">
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