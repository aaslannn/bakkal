@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.categories')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
    <!--Carousel Start -->
    <!-- //Carousel End -->
@stop

{{-- content --}}
@section('content')
    <section class="MainContent">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a></li>
                <li>{{Lang::get('frontend/general.categories')}}</li>
            </ol>
        </div>
        <div class="Categories">
        <div class="container">
          <div class="row">
                @foreach($categories as $cat)
                    <div class="col-md-6 Category">
                        <a href="/urunler/{{ $cat->sefurl }}">
                            <?php $count = App\Library\Common::getProductsCountbyCat($cat->id)  ?>
                            @if($cat->image != '')
                                <img src="{{ url('/').'/uploads/categories/'.$cat->image }}" class="img-responsive">
                            @else
                            <img src="{{ url('/').'/assets/images/nopiccat.jpg' }}" class="img-responsive">
                            @endif
                            <span>{{ $cat->{'title_'.$defLocale} }} ({{ $count }})</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
      </div>
    </section>
    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <!--page level js ends-->
@stop
