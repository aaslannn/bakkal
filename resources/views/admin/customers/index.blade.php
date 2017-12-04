@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Müşteri Yönetimi
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


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Müşteri Yönetimi</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Müşteri Yönetimi</li>
        <li class="active">Müşteriler</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Müşteriler
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered table-responsive" id="table">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                            <th>İsim</th>
                            <th>Soyisim</th>
                            <th>E-Mail</th>
                            <th>Durum</th>
                            <th>Adresler</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($customers as $customer)
                    	<tr>
                            <td>{{{ $customer->id }}}</td>
                    		<td>{{{ $customer->first_name }}}</td>
            				<td>{{{ $customer->last_name }}}</td>
            				<td>{{{ $customer->email }}}</td>
            				<td>
            					@if($customer->activated)
            						Onaylı
            					@else
            						Onay Bekleniyor
            					@endif
            				</td>
                            <td><a href="{{ route('adresses/customer', $customer->id) }}">Adresler ({{{ $customer->adresses->count() }}})</a> </td>
            				<td>{{{ $customer->created_at }}}</td>
            				<td>
                                <a href="{{ route('customers.show', $customer->id) }}"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Üye Detayı"></i></a>

                                <a href="{{ route('customers.update', $customer->id) }}"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i></a>

                                <a href="{{ route('confirm-delete/customer', $customer->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i></a>
                            </td>
            			</tr>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>    <!-- row-->
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
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
@stop