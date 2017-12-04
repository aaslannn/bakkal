@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('rate')
@lang('discodes/title.management')
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
        <h1>@lang('discodes/title.management')</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li>İndirim Kodları</li>
            <li class="active">@lang('discodes/title.management')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-rate pull-left"> <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            İndirim Kodları
                        </h4>
                        <div class="pull-right">
                            <a href="{{ route('create/discode') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        </div>
                    </div>
                    <br />
                    <div class="panel-body">
                        @if ($discodes->count() >= 1)

                            <table class="table table-bordered table-responsive" id="table">
                                <thead>
                                <tr>
                                    <th>@lang('discodes/table.id')</th>
                                    <th>@lang('discodes/table.code')</th>
                                    <th class="text-center">@lang('discodes/table.rate')</th>
                                    <th class="text-center">@lang('discodes/table.dates')</th>
                                    <th class="text-center">@lang('discodes/table.status')</th>
                                    <th class="text-center">@lang('discodes/table.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($discodes as $discode)
                                    <tr>
                                        <td>{{{ $discode->id }}}</td>
                                        <td>{{{ $discode->code }}}</td>
                                        <td class="text-center">%{{{ $discode->rate }}}</td>
                                        <td class="text-center">{{{ $discode->start_date }}} - {{{ $discode->end_date }}}</td>
                                        <td class="text-center">{!! ($discode->used == 1 ? '<span style="color:#FF0000;">Kullanıldı</span>' : '<span style="color:#00CC66;">Kullanılmadı</span>') !!}</td>
                                        <td class="text-center">
                                            <a href="{{ route('update/discode', $discode->id) }}">
                                                <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" rate="Düzenle"></i>
                                            </a>
                                            &nbsp;
                                            <a href="{{ route('confirm-delete/discode', $discode->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" rate="Sil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        @else
                            @lang('general.noresults')
                        @endif
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>




@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_rate" aria-hidden="true">
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
