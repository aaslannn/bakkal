@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Müşteri Detayları
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>View Customer</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>Müşteriler</li>
        <li class="active">Müşteri Detayı</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('customers/title.user_profile')
                    </h3>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="customers">

                            <tr>
                                <td>@lang('customers/title.first_name')</td>
                                <td>
                                    {{ $customer->first_name }}
                                </td>

                            </tr>
                            <tr>
                                <td>@lang('customers/title.last_name')</td>
                                <td>
                                    {{ $customer->last_name }}
                                </td>

                            </tr>
                            <tr>
                                <td>@lang('customers/title.email')</td>
                                <td>
                                    {{ $customer->email }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @lang('customers/title.gender')
                                </td>
                                <td>
                                    <?php $gender = \App\Sabit::getGender($customer->gender); ?>
                                    {{ ($gender == 'Seçiniz') ? '-' : $gender }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.dob')</td>
                                <td>
                                    {{ $customer->dob }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.country')</td>
                                <td>
                                    {{ \App\Library\Common::getCountry($customer->country) }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.city')</td>
                                <td>
                                    {{ $customer->city }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.town')</td>
                                <td>
                                    {{ $customer->state }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.address')</td>
                                <td>
                                    {{ $customer->address }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.tel')</td>
                                <td>
                                    {{ $customer->tel }}
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.status')</td>
                                <td>

                                    @if($customer->deleted_at)
                                        Silinmiş
                                    @elseif($customer->activated == 1)
                                        Onaylı
                                    @else
                                        Onaysız
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('customers/title.created_at')</td>
                                <td>
                                    {{{ $customer->created_at }}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop