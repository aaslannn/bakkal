@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('reviews/title.edit')
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
    <h1>
        @lang('reviews/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/reviews') }}">Yorumlar</a></li>
        <li class="active">@lang('reviews/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="comment" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('reviews/title.edit')
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group {{ $errors->first('rating', 'has-error') }}">
                            <label for="rating" class="col-sm-2 control-label">
                                @lang('reviews/form.rating')
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="rating" name="rating" class="form-control" placeholder="" value="{{{ Input::old('rating', $review->rating) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('rating', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('comment', 'has-error') }}">
                            <label for="comment" class="col-sm-2 control-label">
                                @lang('reviews/form.comment')
                            </label>
                            <div class="col-sm-5">
                                <textarea class="form-control" name="comment">{{{ Input::old('comment', $review->comment) }}}</textarea>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('comment', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('approved', 'has-error') }}">
                            <label for="approved" class="col-sm-2 control-label">
                                @lang('reviews/form.approved')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="approved" name="approved">
                                    <option value="1" @if(Input::old('approved', $review->approved) == 1) selected="selected" @endif>Onaylı</option>
                                    <option value="0" @if(Input::old('approved', $review->approved) == 0) selected="selected" @endif>Onaysız</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('approved', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('spam', 'has-error') }}">
                            <label for="spam" class="col-sm-2 control-label">
                                @lang('reviews/form.spam')
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="spam" name="spam">
                                    <option value="1"  @if(Input::old('spam', $review->spam) == 1) selected="selected" @endif>Evet</option>
                                    <option value="0"  @if(Input::old('spam', $review->spam) == 0) selected="selected" @endif>Hayır</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('spam', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('reviews') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

@stop