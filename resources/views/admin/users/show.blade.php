@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Yönetici Profili
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .error{color:#ef6f6c;}
    </style>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Yönetici Profili</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    {{ trans('panel.home') }}
                </a>
            </li>
            <li>
                <a href="#">Yöneticiler</a>
            </li>
            <li class="active">Yönetici Profili</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav  nav-tabs ">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab" id="tabtab1">
                            <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            Bilgiler</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab" id="tabtab2">
                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            Şifre Değiştir</a>
                    </li>

                </ul>
                <div  class="tab-content mar-top">
                    <div id="tab1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            Yönetici Profili
                                        </h3>

                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4">
                                            <div class="img-file">
                                                @if($user->pic)
                                                    <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="profile pic" class="img-max">
                                                @else
                                                    <img src="http://placehold.it/200x200" alt="profile pic">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('users/title.first_name')</td>
                                                            <td>
                                                                {{ $user->first_name }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.last_name')</td>
                                                            <td>
                                                                {{ $user->last_name }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.email')</td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @lang('users/title.gender')
                                                            </td>
                                                            <td>
                                                                {{ $user->gender }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.dob')</td>
                                                            <td>
                                                                {{ $user->dob }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.country')</td>
                                                            <td>
                                                                {{ $user->country }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.city')</td>
                                                            <td>
                                                                {{ $user->city }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.town')</td>
                                                            <td>
                                                                {{ $user->state }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.address')</td>
                                                            <td>
                                                                {{ $user->address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.status')</td>
                                                            <td>

                                                                @if($user->deleted_at)
                                                                    Silindi
                                                                @elseif($user->activated)
                                                                    Aktif
                                                                @else
                                                                    Beklemede
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('users/title.created_at')</td>
                                                            <td>
                                                                {!! $user->created_at->diffForHumans() !!}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form action="#" class="form-horizontal" method="post" name="usrPass" id="usrPass">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-body">

                                        <div class="form-group  {{ $errors->first('password', 'has-error') }}">
                                            <label for="password" class="col-sm-3 control-label">
                                                Şifre
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" name="password"  id="password" placeholder=""  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                            <label for="password_confirm" class="col-sm-3 control-label">
                                                Şifre (Onay)
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                                </span>
                                                    <input type="password" name="password_confirm"  id="password_confirm"  placeholder=""  class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                            &nbsp;
                                            <button type="button" class="btn btn-danger" onclick='$("#tabtab1").trigger("click");'>Vazgeç</button>
                                            &nbsp;
                                            <input type="reset" class="btn btn-default hidden-xs" value="Temizle"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @stop

    {{-- page level scripts --}}
    @section('footer_scripts')
            <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/wizard/jquery-steps/js/jquery.validate.min.js') }}"></script>
    <script>
        $('#usrPass').validate({
            rules: {
                password: {
                    required:true,
                    minlength:5,
                    maxlength:20

                },
                password_confirm: {
                    equalTo: "#password"
                }
            },
            messages: {
                password : {
                    required:'Şifre alanı gereklidir.',
                    minlength:'En az 5 karakter giriniz.',
                    maxlength:'En fazla 20 karakter girebilirsiniz'
                },
                password_confirm : {
                    equalTo:'Şifre Tekrarı Şifreye Eşit Olmalıdır.'
                }
            }
        });
    </script>
    @if(Session::has('errors'))
        <script>$("#tabtab2").trigger("click");</script>
    @endif
@stop