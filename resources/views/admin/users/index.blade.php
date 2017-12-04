@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Site Yöneticileri
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.colReorder.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.scroller.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.tableTools.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css">
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Yöneticiler</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li>Yöneticiler</li>
            <li class="active">Yönetici Listesi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Yönetici Listesi
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered table-responsive" id="table">
                        <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>İsim</th>
                            <th>Soyisim</th>
                            <th>E-Posta Adresi</th>
                            <th>Durum</th>
                            <th>Eklenme T.</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{{ $user->id }}}</td>
                                <td>{{{ $user->first_name }}}</td>
                                <td>{{{ $user->last_name }}}</td>
                                <td>{{{ $user->email }}}</td>
                                <td>
                                    @if($user->activated)
                                        Aktif
                                    @else
                                        Pasif
                                    @endif
                                </td>
                                <td>{{{ $user->created_at->format('Y-m-d H:i') }}}</td>
                                <td>
                                    <!--<a href="{{ route('users.show', $user->id) }}"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i></a>-->

                                    <a href="{{ route('users.update', $user->id) }}"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>

                                    @if (Sentry::getUser()->id != $user->id && $user->id != 1)
                                        <a href="{{ route('confirm-delete/user', $user->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>
                                    @endif

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
            <div class="modal-content"></div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
@stop