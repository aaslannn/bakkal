@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('orders/title.management')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/TableTools/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}" />
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang('orders/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>
            Siparişler
        </li>
        <li class="active">@lang('orders/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="shopping-cart-in" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('orders/title.orders')
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered table-responsive" id="table">
                            <thead>
                                <tr>
                                    <th>@lang('orders/table.id')</th>
                                    <th>@lang('orders/table.member')</th>
                                    <th>@lang('orders/table.paymethod')</th>
                                    <th>@lang('orders/table.gift')</th>
                                    <th>@lang('orders/table.price')</th>
                                    <th>@lang('orders/table.orderdate')</th>
                                    <th>@lang('orders/table.status')</th>
                                    <th>@lang('orders/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $siteSetting = \App\Setting::find(1); ?>
                                @foreach ($orders as $order)
                                    <tr  {!! $order->status == 1 ? 'class="warning"' : '' !!}>
                                        <td>{{{ $order->id }}}</td>
                                        <td>{{{ $order->customer ? $order->customer->first_name.' '.$order->customer->last_name : 'Silinmiş Üye' }}}</td>
                                        <td>{{{ $order->paymethod->title_en }}}</td>
                                        <td>{{{ \App\Sabit::yesNo($order->hediye) }}}</td>
                                        <td>{{{ $siteSetting->para_birim.number_format($order->topTutar,2) }}}</td>
                                        <td>{{{ $order->created_at }}}</td>
                                        <td>{{{ $order->orderstatus->title_en }}}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}">
                                                <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Detaylar"></i>
                                            </a> &nbsp;
                                            <a href="{{ route('update/order', $order->id) }}">
                                                <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                            </a> &nbsp;
                                            <a href="{{ route('confirm-delete/order', $order->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>
@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
    <script  src="{{ asset('assets/js/orderStatus.js') }}" type="text/javascript"></script>
@stop
