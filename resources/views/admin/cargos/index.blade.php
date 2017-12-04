@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('cargos/title.management')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
        <!--page level css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.colReorder.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.scroller.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.tableTools.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
        <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css">
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang('cargos/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Kargolar</li>
        <li class="active">@lang('cargos/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="truck" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Kargolar
                    </h4>
                    <div class="pull-right">
                    <a href="{{ route('create/cargo') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body table-responsive">
                        <table class="table table-bordered table-responsive" id="table1">
                            <thead>
                                <tr>
                                    <th>@lang('cargos/table.id')</th>
                                    <th>@lang('cargos/table.title')</th>
                                    <th>@lang('cargos/table.price')</th>
                                    <th>@lang('cargos/table.status')</th>
                                    <th>@lang('cargos/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cargos as $cargo)
                                    <tr>
                                        <td>{{{ $cargo->id }}}</td>
                                        <td>{{{ $cargo->name }}}</td>
                                        <td>{{{ $cargo->price }}} TL</td>
                                        <td>{{{ \App\Sabit::itemStatus($cargo->status) }}}</td>
                                        <td>
                                            <a href="{{ route('update/cargo', $cargo->id) }}">
                                                    <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                </a>
                                            &nbsp;
                                                    <a href="{{ route('confirm-delete/cargo', $cargo->id) }}" data-toggle="modal" data-target="#delete_confirm">
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
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
@stop
