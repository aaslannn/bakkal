@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('products/title.options')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
        <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/only_dashboard.css') }}" />
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('products/title.options')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/products') }}">Ürünler</a></li>
        <li class="active">@lang('products/title.options')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ürün Bilgileri
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="img-file">
                            <img style="max-height: 200px;" class="img-max" alt="profile pic" src="{{ \App\Library\Common::getPrdImage($product->id) }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="users">
                                    <tr>
                                        <td style="width: 25%">Ürün Adı</td>
                                        <td>{{ $product->title_tr }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>{{ $product->categorie->title_tr }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ürüne Seçenek Ekle
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                        <?php
                        $langs = \App\Language::whereDurum(1)->get();
                        ?>
                        @foreach($langs as $lang)
                            <div class="form-group {{ $errors->first('title_'.$lang->kisaltma, 'has-error') }}">
                                <label for="title_{{ $lang->kisaltma }}" class="col-sm-2 control-label">
                                    @lang('products/form.option') [{{ strtoupper($lang->kisaltma) }}]
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group {{ $errors->first('stok', 'has-error') }}">
                            <label for="stok" class="col-sm-2 control-label">
                                @lang('products/form.stockstatus')
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" id="stok" name="stok">
                                    <option value="1" selected="selected">Mevcut</option>
                                    <option value="0" >Yok</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('stok', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('products') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.add')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="panel panel-primary todolist">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="medal" data-size="18" data-color="white" data-hc="white" data-l="true"></i>
                        @lang('products/title.options')
                    </h4>
                </div>
                <div class="panel-body">
                        @foreach($options as $opt)
                            <div class="todolist_list showactions">
                                <div class="col-md-8 col-sm-8 col-xs-8 nopadmar custom_textbox1">
                                    <div class="todotext todoitem">{{ $opt->title_tr }} </div>
                                    <div class="todotext todoitem">&nbsp;&nbsp; ( <a href="?setStatus={{ $opt->id }}" class="todoedit" title="Değiştir">
                                            {{ $opt->stok == 0 ? 'Yok' : 'Mevcut' }}
                                        </a> ) </div>
                                </div>
                                <div class="col-md-4  col-sm-4 col-xs-4  pull-right showbtns todoitembtns">
                                    <a href="{{ route('updateOptions/product', $opt->pr_id) }}?oId={{ $opt->id }}&del=1" class="tododelete redcolor">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
@stop