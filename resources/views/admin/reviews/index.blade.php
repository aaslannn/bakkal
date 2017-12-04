@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('reviews/title.management')
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
    <h1>@lang('reviews/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>
            Ürün Yorumları
        </li>
        <li class="active">@lang('reviews/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="comments" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('reviews/title.reviews')
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered table-responsive" id="table">
                            <thead>
                                <tr>
                                    <th>@lang('reviews/table.id')</th>
                                    <th>@lang('reviews/table.member')</th>
                                    <th>@lang('reviews/table.product')</th>
                                    <th>@lang('reviews/table.comment')</th>
                                    <th>@lang('reviews/table.rating')</th>
                                    <th>@lang('reviews/table.created_at')</th>
                                    <th>@lang('reviews/table.status')</th>
                                    <th>@lang('reviews/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{{ $review->id }}}</td>
                                        <td>{{ $review->user ? $review->user->first_name.' '.$review->user->last_name : 'Misafir'}}</td>
                                        <td>{{ $review->product ? $review->product->title_tr : 'Silinmiş Ürün' }}</td>
                                        <td>{{{ $review->comment }}}</td>
                                        <td>{{{ $review->rating }}}</td>
                                        <td>{{{ $review->timeago }}}</td>
                                        <td>{{{ \App\Sabit::itemStatus($review->approved) }}}</td>
                                        <td>
                                            <a href="{{ route('update/review', $review->id) }}">
                                                <i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i>
                                            </a>
                                            <!--
                                            &nbsp;
                                            <a href="{{ route('confirm-delete/review', $review->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                <i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i>
                                            </a>
                                            -->
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
