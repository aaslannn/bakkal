@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('customers/title.addresses')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/TableTools/css/dataTables.tableTools.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}" />
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('customers/title.addresses')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/customers') }}">Müşteriler</a></li>
        <li class="active">@lang('customers/title.addresses')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Müşteri Adresleri
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered table-responsive" id="table">
                    <thead>
                    <tr class="filters">
                        <th>#</th>
                        <th>Müşteri</th>
                        <th>Başlık</th>
                        <th>Ülke / İl / İlçe</th>
                        <th>Adres</th>
                        <th>Telefon</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($adresler as $adres)
                        <tr>
                            <td>{{{ $adres->id }}}</td>
                            <td>{{{ $adres->user->first_name }}} {{{ $adres->user->last_name }}}</td>
                            <td>{{{ $adres->title }}}</td>
                            <td>{{{ \App\Library\Common::getCountry($adres->country_id) }}} / {{{ $adres->city_id }}} / {{{ $adres->town }}}</td>
                            <td>{{{ $adres->adres }}}</td>
                            <td>{{{ $adres->tel }}}</td>
                            <td>
                                <a href="{{ route('adresses/customer', $adres->customer_id) }}?oId={{ $adres->id }}&del=1" class="tododelete redcolor">
                                    <i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
@stop