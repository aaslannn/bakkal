@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('products/title.management')
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
    <h1>@lang('products/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>
            <a href="{{ URL::to('admin/categories') }}">Kategoriler</a>
        </li>
        <li class="active">Ürünler</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="tag" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ürünler
                    </h4>
                    <div class="pull-right">
                    <a href="{{ route('create/product') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>@lang('products/table.sequence')</th>
                                <th>@lang('products/table.title')</th>
                                <th>@lang('products/table.categorie')</th>
                                <th>@lang('products/table.price')</th>
                                <th class="text-center">@lang('products/table.stock')</th>
                                <th class="text-center">@lang('products/table.properties')</th>
                                <th class="text-center">@lang('products/table.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.min.js') }}" ></script>
    <script>
        $(function() {
            var conf = {
                pageLength : 25,
                responsive : true,
                processing: true,
                serverSide: true,
                order   : [[0, "asc"]],
                ajax    : '{!! route('products.data') !!}?catId={{$catId}}',
                "sDom"  : "<'row'<'col-sm-6'l><'col-sm-6'p>><'row'<'col-sm-12'rt>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                columns : [
                    { data: 'sequence', name: 'sequence' },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    { data: 'price', name: 'price' },
                    { data: 'stock', name: 'stock', sClass:'text-center' },
                    { data: 'properties', name: 'properties', orderable: false, searchable: false, sClass:'text-center'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, sClass:'text-center' }
                ]
            };
            conf.language = {
                url: PUBLIC_REL + "/assets/vendors/datatables/i18n/" + LOCALE + ".json"
            };
            var table = $('#table').DataTable(conf);
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            });
        });
    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
@stop
