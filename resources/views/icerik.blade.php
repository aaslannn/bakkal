@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ $content->title_en }}
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
                <li><a>{{ $content->{'title_'.$defLocale} }}</a></li>
            </ol>
        </div>
        <div class="Help">
            <div class="container">
                @if($content->image != '')
                    <div class="HelpImage"><img src="{{ url('/').'/uploads/contents/'.$content->image }}"></div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        @include('layouts.menucontent')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox mt-10">
                            <div class="DefaultBoxHeading">{{ $content->{'title_'.$defLocale} }}</div>
                            <div class="DefaultBoxBody">
                                <div>{!! $content->{'content_'.$defLocale} !!}</div>
                                @if($content->sefurl == 'iletisim')
                                    <div class="mt-15">
                                        <ul class="TableList">
                                            <li><span>{{Lang::get('frontend/general.company-name')}}:</span><span>{{ $siteSettings->isim }}</span></li>
                                            <li><span>{{Lang::get('frontend/general.tel')}}:</span><span>{{ $siteSettings->tel }}</span></li>
                                            @if($siteSettings->tel2 != '')                                            
                                                <li><span>{{Lang::get('frontend/general.tel')}}2:</span><span>{{ $siteSettings->tel2 }}</span></li>
                                            @endif
                                            @if($siteSettings->faks != '')  
                                                <li><span>{{Lang::get('frontend/general.faks')}}:</span><span>{{ $siteSettings->faks }}</span></li>
                                            @endif
                                            <li><span>{{Lang::get('frontend/general.email')}}:</span><span>{{ $siteSettings->email }}</span></li>
                                            <li><span>{{Lang::get('frontend/general.address')}}:</span><span>{{ $siteSettings->adres }}</span></li>
                                            @if($siteSettings->sicil_no != '')  
                                                <li><span>{{Lang::get('frontend/general.regist-no')}}:</span><span>{{ $siteSettings->sicil_no }}</span></li>
                                            @endif
                                            @if($siteSettings->vergi_no != '') 
                                                <li><span>{{Lang::get('frontend/general.taxno')}}:</span><span>{{ $siteSettings->vergi_no }}</span></li>
                                            @endif
                                            @if($siteSettings->vergi_d != '') 
                                                <li><span>{{Lang::get('frontend/general.taxadministration')}}:</span><span>{{ $siteSettings->vergi_d }}</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <?php $bankAccounts = \App\BankAccount::whereStatus(1)->orderBy('bankaAdi','asc')->get(); ?>
                                    @if($bankAccounts->count() > 0)
                                    <div class="mt-15">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th colspan="5">{{Lang::get('frontend/general.bankaccountinfo')}}</th>
                                            </tr>
                                            <tr>
                                                <th>{{Lang::get('frontend/general.bankname')}}</th>
                                                <th>{{Lang::get('frontend/general.accounttype')}}</th>
                                                <th>{{Lang::get('frontend/general.accountowner')}}</th>
                                                <th>{{Lang::get('frontend/general.ibanno')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>                                            
                                            @foreach($bankAccounts as $bank)
                                                <tr>
                                                    <td>{{ $bank->bankaAdi }}</td>
                                                    <td>{{ $bank->hesapTuru }}</td>
                                                    <td>{{ $bank->hesapAdi }}</td>
                                                    <td>{{ $bank->iban }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif

                                @endif
                                @if($content->subcats->count() > 0)
                                    <div id="SSSAccordionPanel" class="panel-group">
                                        <?php $conSubs = \App\Content::where('parent_id',$content->id)->orderBy('sequence','asc')->get(); ?>
                                        @foreach($conSubs as $subcon)
                                        <div class="panel panel-default">
                                            <div id="heading1" class="panel-heading">
                                                <div class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#SSSAccordionPanel" href="#content{{ $subcon->id }}">{{ $subcon->{'title_'.$defLocale} }}</a><i class="fa fa-chevron-down"></i></div>
                                            </div>
                                            <div id="content{{ $subcon->id }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>{!! $subcon->{'content_'.$defLocale} !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
        <script src="{{ asset('assets/js/frontend/events/helpevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
