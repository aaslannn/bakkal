@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('categories/title.management')
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
    <h1>@lang('categories/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Kategoriler</li>
        <li class="active">@lang('categories/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="sitemap" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Kategoriler
                    </h4>
                    <div class="pull-right">
                        @if(@$parent && @$parent->id > 0)
                            <a href="{{ route('create/categorie').'?cat='.$parent->id }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        @else
                            <a href="{{ route('create/categorie') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        @endif
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered table-responsive" id="table">
                            <thead>
                                <tr>
                                    <th>@lang('categories/table.sequence')</th>
                                    <th>@lang('categories/table.title')</th>
                                    <th>@lang('categories/table.parentcat')</th>
                                    <th>@lang('categories/table.status')</th>
                                    <th>@lang('categories/table.altcat')</th>
                                    <th>@lang('categories/table.products')</th>
                                    <th>Sırala</th>
                                    <th>@lang('categories/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($categories as $categorie)
                                    <tr>
                                        <td>{{{ $categorie->sequence }}}</td>
                                        <td>
                                            <a href="{{ route('update/categorie', $categorie->id) }}">
                                            @if($categorie->image)
                                                <img src="{{{ url('/').'/uploads/categories/'.$categorie->image }}}" alt="{{{ $categorie->title_tr }}}" style="width:120px; max-height:50px;  margin-right: 3px;">
                                            @endif
                                            {{{ $categorie->title_tr }}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($categorie->parent_id > 0 && isset($parent))
                                                {{{ $parent->title_tr  }}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{{ \App\Sabit::itemStatus($categorie->status) }}}</td>
                                        <td>
                                           <a href="{{ URL::to('admin/categories') }}?id={{ $categorie->id }}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-folder-open"></span> @lang('categories/table.altcat')  ({{{ $categorie->subcats()->count() }}})</a>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('admin/products') }}?catId={{ $categorie->id }}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-tags"></span> @lang('categories/table.products') ({{{ $categorie->products()->count() }}})</a>
                                        </td>
                                        <td>
                                            <a href="?up={{ $categorie->id.(@$parent ? '&id='.$parent->id : '') }}">
                                                <i class="livicon" data-name="chevron-up" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Yukarı"></i>
                                            </a>
                                            <a href="?down={{ $categorie->id.(@$parent ? '&id='.$parent->id : '') }}">
                                                <i class="livicon" data-name="chevron-down" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Aşağı"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('update/categorie', $categorie->id) }}">
                                                    <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                </a>
                                            &nbsp;
                                            @if($categorie->products->count() > 0)
                                                <a onclick="alert('Bu kategoriye ait ürünler bulunmaktadır. Önce ürünleri silmeniz gerekmektedir.'); return false;">
                                                    <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('confirm-delete/categorie', $categorie->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                                </a>
                                            @endif
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
<script src="{{ asset('assets/js/pages/tables.js') }}"></script>
@stop
