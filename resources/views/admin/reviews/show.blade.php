@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Sipariş Detayları
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/pages/order_profile.css') }}" rel="stylesheet" type="text/css"/>
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>View order</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Müşteriler</li>
        <li class="active">Müşteri Detayı</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('orders/title.user_profile')
                    </h3>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <form method="post" action="#">

                            <table class="table table-bordered table-striped" id="orders">

                                <tr>
                                    <td>@lang('orders/title.first_name')</td>
                                    <td>
                                        {{ $order->first_name }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>@lang('orders/title.last_name')</td>
                                    <td>
                                        {{ $order->last_name }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>@lang('orders/title.email')</td>
                                    <td>
                                        {{ $order->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @lang('orders/title.gender')
                                    </td>
                                    <td>
                                        {{ \App\Sabit::getGender($order->gender) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.dob')</td>
                                    <td>
                                        {{ $order->dob }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.country')</td>
                                    <td>
                                        {{ $order->countrie->ulke }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.city')</td>
                                    <td>
                                        {{ $order->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.town')</td>
                                    <td>
                                        {{ $order->state }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.address')</td>
                                    <td>
                                        {{ $order->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.tel')</td>
                                    <td>
                                        {{ $order->tel }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.status')</td>
                                    <td>

                                        @if($order->deleted_at)
                                            Silinmiş
                                        @elseif($order->activated == 1)
                                            Onaylı
                                        @else
                                            Onaysız
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('orders/title.created_at')</td>
                                    <td>
                                        {{{ $order->created_at }}}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<!-- Bootstrap WYSIHTML5 -->
<script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
@stop