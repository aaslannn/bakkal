@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('contents/title.management')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}">
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang('contents/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Sayfalar</li>
        <li class="active">@lang('contents/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="sitemap" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Sayfalar
                    </h4>
                    <div class="pull-right">
                    <a href="{{ route('create/content') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered table-responsive" id="table">
                            <thead>
                                <tr>
                                    <th>@lang('contents/table.sequence')</th>
                                    <th>@lang('contents/table.title')</th>
                                    <th>@lang('contents/table.status')</th>
                                    <th>Sırala</th>
                                    <th>@lang('contents/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($contents as $content)
                                    <tr>
                                        <td>{{{ $content->sequence }}}</td>
                                        <td>{{{ $content->title_en }}}</td>
                                        <td>{{{ \App\Sabit::itemStatus($content->status) }}}</td>
                                        <td>
                                            <a href="?up={{ $content->id }}">
                                                <i class="livicon" data-name="chevron-up" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Yukarı"></i>
                                            </a>
                                            <a href="?down={{ $content->id }}">
                                                <i class="livicon" data-name="chevron-down" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Aşağı"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('update/content', $content->id) }}">
                                                    <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                </a>
                                            &nbsp;
                                                    <a href="{{ route('confirm-delete/content', $content->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                    <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                                    </a>
                                        </td>
                                    </tr>
                                    @if($content->subcats->count() > 0)
                                        <?php $conSubs = \App\Content::where('parent_id',$content->id)->orderBy('sequence','asc')->get(); ?>
                                        @foreach ($conSubs as $content2)
                                            <tr>
                                                <td>{{{ $content->sequence.'.'.$content2->sequence }}}</td>
                                                <td>{{{ $content->title_en }}} &raquo; {{{ $content2->title_en }}}</td>
                                                <td>{{{ \App\Sabit::itemStatus($content->status) }}}</td>
                                                <td>
                                                    <a href="?up={{ $content2->id }}">
                                                        <i class="livicon" data-name="chevron-up" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Yukarı"></i>
                                                    </a>
                                                    <a href="?down={{ $content2->id }}">
                                                        <i class="livicon" data-name="chevron-down" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Aşağı"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('update/content', $content2->id) }}">
                                                        <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('confirm-delete/content', $content2->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                        <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/3/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/tables.js') }}" ></script>
@stop
