@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Crop Image
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/imgcrop/css/jquery.Jcrop.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/cropcustom.css') }}" type="text/css" />
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
        <li><a href="{{ URL::to('admin/products') }}">@lang('products/title.products')</a></li>
        <li class="active">@lang('products/title.pictures')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Görsel Ayarları
                    </h4>
                </div>
                <div class="panel-body">
                        <div class="col-md-7">
                            <img src="{{{ url('/').'/uploads/products/'.$pic->pr_id.'/'.$pic->isim }}}" id="cropbox" style="max-height: 1000px;">
                        </div>
                        <div class="col-md-3">
                            <p>Soldaki resmi <strong>4:3</strong> oranında (En az <strong>651*488</strong> piksel olacak şekilde) boyutlandırınız.</p>
                            <form action="" method="post" onsubmit="return checkCoords();">
                                {!! csrf_field() !!}
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="we" name="w" />
                                <input type="hidden" id="he" name="h" />
                                <input type="submit" value="Resmi Boyutlandır" class="btn btn-large btn-primary" />
                                <p></p>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/imgcrop/jquery.Jcrop.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/imgcrop/jquery.color.js') }}" ></script>
    <script src="{{ asset('assets/vendors/imgcrop/cropcustom.js') }}" ></script>
@stop