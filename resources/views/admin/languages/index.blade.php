@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('languages/title.management')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
        <!--page level css -->
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang('languages/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>@lang('languages/title.languages')</li>
        <li class="active">@lang('languages/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="bank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('languages/title.languages')
                    </h4>
                    <div class="pull-right">
                        @if (Sentry::getUser()->hasAccess('admin')  || Sentry::getUser()->hasAccess('languages_add'))
                            <a href="{{ route('create/language') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        @endif
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered table-responsive" id="table1">
                            <thead>
                                <tr>
                                    <th>@lang('languages/table.id')</th>
                                    <th>@lang('languages/table.dil')</th>
                                    <th>@lang('languages/table.kisaltma')</th>
                                    <th>Default</th>
                                    <th>@lang('languages/table.durum')</th>
                                    <th>@lang('languages/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($languages as $language)
                                    <tr>
                                        <td>{{{ $language->id }}}</td>
                                        <td>{{{ $language->dil }}}</td>
                                        <td>{{{ $language->kisaltma }}}</td>
                                        <td>
                                            {!! ($language->varsayilan == 1 ? '<i class="livicon" data-name="thumbs-up" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Varsayılan Dil"></i>' : '<a href="'.URL::to('admin/languages/?varsayilan='.$language->id).'">Default Yap</a>') !!}
                                        
                                        </td>
                                        <td>{{{ \App\Sabit::itemStatus($language->durum) }}}</td>
                                        <td>
                                            <a href="{{ route('update/language', $language->id) }}">
                                                    <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                </a>
                                            @if (Sentry::getUser()->hasAccess('admin')  || Sentry::getUser()->hasAccess('languages_add'))
                                            &nbsp;
                                                <a href="{{ route('confirm-delete/language', $language->id) }}" data-toggle="modal" data-target="#delete_confirm">
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
@stop
