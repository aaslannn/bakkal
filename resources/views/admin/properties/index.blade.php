@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('products/table.properties')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('products/table.properties')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/products') }}">Ürünler</a></li>
        <li class="active">@lang('products/table.properties')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
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
                                        <td>{{ $product->title_en }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>{{ $product->categorie->title_en }}</td>
                                    </tr>
                                    <tr>
                                        <td>İşlemler</td>
                                        <td><a href="{{ route('update/product', $product->id) }}">Ürün Düzenle</a> /  <a href="{{ route('updatePictures/product', $product->id) }}">Ürün Görselleri</a> </td>
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
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="medal" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ürüne Özellik Ekle
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ route('create/prodprop',$product->id) }}">
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
                                    <input type="text" id="title_{{ $lang->kisaltma }}" name="title_{{ $lang->kisaltma }}" class="form-control" placeholder="" value="{{{ Input::old('title_'.$lang->kisaltma) }}}" required>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('title_'.$lang->kisaltma, '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="options" class="col-sm-2 control-label">
                                @lang('products/table.options')
                            </label>
                            <div class="col-sm-10">
                                @for($i=0;$i<6;$i++)
                                    <div class="form-group">
                                        <label for="options" class="col-sm-1 control-label">
                                            {{ $i+1 }}.
                                        </label>
                                        <div class="col-sm-10">
                                                <input type="text" id="option_{{ $i }}" name="options[{{ $i }}]" class="form-control" placeholder=""><br>
                                        </div>
                                    </div>
                                @endfor
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
        <div class="col-sm-7">
            <div class="panel panel-primary">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="medal" data-size="18" data-color="white" data-hc="white" data-l="true"></i>
                        @lang('products/table.properties')
                    </h4>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive" id="table1">
                        <thead>
                        <tr>
                            <th>@lang('products/form.property')</th>
                            <th>@lang('products/table.options')</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($properties as $prop)
                            <tr>
                                <td>{{ $prop->title_en }}</td>
                                <td>
                                    @if($prop->options)
                                        @foreach($prop->options as $opt)
                                            - {{ $opt->title_en }}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('update/prodprop', [$prop->pr_id,$prop->id]) }}"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="@lang('button.edit')"></i> @lang('button.edit')</a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('confirm-delete/prodprop', [$prop->pr_id,$prop->id]) }}" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="@lang('button.delete')"></i> @lang('button.delete')</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
@stop