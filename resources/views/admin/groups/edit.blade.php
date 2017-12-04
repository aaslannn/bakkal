@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('groups/title.edit')
    @parent
@stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            @lang('groups/title.edit')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Groups</li>
            <li class="active">@lang('groups/title.edit')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('groups/title.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('groups/form.name')
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Group Name" value="{{{ Input::old('name', $group->
                                name) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                <label for="description" class="col-sm-2 control-label">
                                    @lang('groups/form.description')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="description" name="description" class="form-control" placeholder="Açıklama" value="{{{ Input::old('description', $group->description) }}}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('description', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>

                            <?php $per = $group->permissions; ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tam Yetki : </label>
                                <div class="col-sm-2">
                                    {!! Form::select('permissions[admin]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[admin]', @$per['admin']),array('class' => 'form-control')) !!}
                                </div>
                                <div class="col-sm-4">
                                    <p class="alert alert-info">Tam yetki verirseniz aşağıdaki izinlerin önemi yoktur.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Genel Ayarlar : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[settings]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[settings]', @$per['settings']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[settings_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[settings_edit]', @$per['settings_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Dil Ayarları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[languages]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[languages]', @$per['languages']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[languages_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[languages_add]', @$per['languages_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[languages_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[languages_edit]', @$per['languages_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Dil Çevirileri : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[translations]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[translations]', @$per['translations']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[translations_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[translations_add]', @$per['translations_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[translations_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[translations_edit]', @$per['translations_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Yöneticiler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[users]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[users]', @$per['users']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[users_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[users_add]', @$per['users_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[users_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[users_edit]', @$per['users_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Yönetici Grupları: </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[groups]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[groups]', @$per['groups']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[groups_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[groups_add]', @$per['groups_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[groups_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[groups_edit]', @$per['groups_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kargo Firmaları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[cargos]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[cargos]', @$per['cargos']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[cargos_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[cargos_add]', @$per['cargos_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[cargos_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[cargos_edit]', @$per['cargos_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ödeme Yöntemleri : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[paymethods]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[paymethods]', @$per['paymethods']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[paymethods_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[paymethods_add]', @$per['paymethods_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[paymethods_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[paymethods_edit]', @$per['paymethods_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">POS Hesapları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[posaccounts]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[posaccounts]', @$per['posaccounts']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[posaccounts_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[posaccounts_add]', @$per['posaccounts_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[posaccounts_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[posaccounts_edit]', @$per['posaccounts_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Banka Hesapları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[bankaccounts]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[bankaccounts]', @$per['bankaccounts']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[bankaccounts_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[bankaccounts_add]', @$per['bankaccounts_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[bankaccounts_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[bankaccounts_edit]', @$per['bankaccounts_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kategoriler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[categories]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[categories]', @$per['categories']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[categories_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[categories_add]', @$per['categories_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[categories_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[categories_edit]', @$per['categories_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ürünler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[products]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[products]', @$per['products']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[products_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[products_add]', @$per['products_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[products_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[products_edit]', @$per['products_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Markalar : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[brands]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[brands]', @$per['brands']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[brands_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[brands_add]', @$per['brands_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[brands_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[brands_edit]', @$per['brands_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ürün Yorumları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[reviews]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[reviews]', @$per['reviews']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[reviews_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[reviews_edit]', @$per['reviews_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Siparişler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[orders]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[orders]', @$per['orders']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[orders_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[orders_edit]', @$per['orders_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">İndirim Kodları : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[discodes]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[discodes]', @$per['discodes']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[discodes_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[discodes_add]', @$per['discodes_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[discodes_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[discodes_edit]', @$per['discodes_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Müşteriler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[customers]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[customers]', @$per['customers']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[customers_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[customers_add]', @$per['customers_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[customers_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[customers_edit]', @$per['customers_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">İçerikler/Sayfalar : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[contents]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[contents]', @$per['contents']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[contents_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[contents_add]', @$per['contents_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[contents_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[contents_edit]', @$per['contents_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Slaytlar : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[slides]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[slides]', @$per['slides']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[slides_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[slides_add]', @$per['slides_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[slides_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[slides_edit]', @$per['slides_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sosyal Linkler : </label>
                                <div class="col-sm-8">
                                    <label class="col-sm-2 control-label">Görüntüleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[socials]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[socials]', @$per['socials']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Ekleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[socials_add]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[socials_add]', @$per['socials_add']),array('class' => 'form-control')) !!}
                                    </div>
                                    <label class="col-sm-2 control-label">Düzenleme : </label>
                                    <div class="col-sm-2">
                                        {!! Form::select('permissions[socials_edit]', [0 => 'Hayır', 1 => 'Evet'],Input::old('permissions[socials_edit]', @$per['socials_edit']),array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <a class="btn btn-danger" href="{{ route('groups') }}">
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