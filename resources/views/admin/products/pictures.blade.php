@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('products/title.pictures')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
        <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/gallery/fancy_box/jquery.fancybox.css') }}" media="screen" />
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('products/title.pictures')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/products') }}">Ürünler</a></li>
        <li class="active">@lang('products/title.pictures')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ürün Bilgileri
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="img-file">
                            <img class="img-max" alt="profile pic" src="{{ \App\Library\Common::getPrdImage($product->id) }}" style="max-width:350px;">
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
                                        <td>Varsayılan Görsel</td>
                                        <td>Sol taraftaki görsel varsayılan görseldir. Aşağıda yer alan "Ürün Görselleri" bölümünden değiştirebilirsiniz.</td>
                                    </tr>
                                    <tr>
                                        <td>İşlemler</td>
                                        <td><a href="{{ route('update/product', $product->id) }}">Ürün Düzenle</a> /  <a href="{{ route('prodproperties', $product->id) }}">Ürün Özellikleri</a> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="image" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('products/title.pictures')
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="tab-pane gallery-padding">
                        <div class="gallery">
                            @foreach($pictures as $pic)
                                <div class="col-lg-3 col-md-4 col-xs-6 col-sm-3 gallery-border">
                                    <a class="fancybox" href="{{{ url('/').'/uploads/products/'.$pic->pr_id.'/o-'.$pic->isim }}}" data-fancybox-group="gallery" title="{{{ $pic->baslik }}}">
                                        <img src="{{{ url('/').'/uploads/products/'.$pic->pr_id.'/k-'.$pic->isim }}}" class="img-responsive gallery-style" alt="{{{ $pic->baslik }}}"></a>
                                    <div style="margin-top: 3px;">
                                        @if($pic->product->image != $pic->isim)
                                            <a href="{{ route('updatePictures/product', $pic->pr_id) }}?pId={{ $pic->id }}&def=1" class="btn btn-xs btn-primary" title="İlk Görsel"><span class="glyphicon glyphicon-star"></span> Varsayılan Yap</a>
                                        @else
                                            <span class="label label-sm label-success">Varsayılan</span>
                                        @endif
                                        <a href="{{ route('updatePictures/product', $pic->pr_id) }}?pId={{ $pic->id }}&del=1" class="btn btn-xs btn-danger " title="Sil"><span class="glyphicon glyphicon-trash"></span> Sil</a>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Görsel Yükleme
                </h4>
            </div>
            <div class="panel-body">
                <p class="text-danger"><strong>Ürün Fotoğrafı Yüklerken Dikkat Etmeniz Gerekenler:</strong>
                    <ul>
                        <li>Ekleyebileceğiniz Görsel Sayısı : <strong>{{ 5 - $pictures->count() }}</strong></li>
                        <li>Kabul Edilen Dosya Biçimleri : <strong>JPG, PNG</strong></li>
                        <li>Görsel Boyutları <strong>4:3</strong> oranında, en az <strong>651*488 px</strong> ve en fazla <strong>5 MB</strong> olmalıdır.</li>
                    </ul>
                </p>
                <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <div class="form-group {{ $errors->first('file', 'has-error') }}">
                        <label for="title" class="col-sm-2 control-label">
                            @lang('products/form.image')
                        </label>
                        <div class="col-sm-9">
                            {!! Form::file('images[]',array('multiple' => 'true')) !!}
                            {{--<div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Görsel Seçiniz</span>
                                            <span class="fileinput-exists">Değiştir</span>
                                            <input type="file" name="file" required>
                                        </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                            </div>--}}
                        </div>
                        <div class="col-sm-5">
                            {!! $errors->first('file', '<span class="help-block">:message</span> ') !!}
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
    </div>
    <!-- row-->
</section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="{{ asset('assets/vendors/gallery/fancy_box/jquery.mousewheel.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/gallery/fancy_box/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
        });
    </script>
@stop