@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('paymethods/title.management')
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
    <h1>@lang('paymethods/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Ödeme</li>
        <li class="active">@lang('paymethods/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Ödeme Yöntemleri
                    </h4>
                    <div class="pull-right">
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('posaccounts_add'))
                        <a href="{{ route('create/paymethod') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        @endif
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    @if ($paymethods->count() >= 1)

                        <table class="table table-bordered table-responsive" id="table1">
                            <thead>
                                <tr>
                                    <th>@lang('paymethods/table.id')</th>
                                    <th>@lang('paymethods/table.sequence')</th>
                                    <th>@lang('paymethods/table.title')</th>
                                    <th>@lang('paymethods/table.status')</th>
                                    <th>@lang('paymethods/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($paymethods as $pm)
                                    <tr>
                                        <td>{{{ $pm->id }}}</td>
                                        <td>{{{ $pm->sequence }}}</td>
                                        <td>{{{ $pm->title_en }}}</td>
                                        <td>{{{ \App\Sabit::itemStatus($pm->status) }}}</td>
                                        <td>
                                            <a href="{{ route('update/paymethod', $pm->id) }}">
                                                    <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                                </a>
                                            &nbsp;
                                                    <a href="{{ route('confirm-delete/paymethod', $pm->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                    <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
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
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
@stop
