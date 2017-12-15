@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('orders/title.edit')
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
        @lang('orders/title.edit')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li><a href="{{ URL::to('admin/orders') }}">@lang('orders/title.orders')</a></li>
        <li class="active">@lang('orders/title.edit')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('orders/title.edit') - {{ $order->id }} ({{ $order->customer->first_name }} {{ $order->customer->last_name }})
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group {{ $errors->first('refNo', 'has-error') }}">
                            <label for="refNo" class="col-sm-2 control-label">
                                Referans No
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="refNo" name="refNo" class="form-control" placeholder="" value="{{{ Input::old('refNo', $order->refNo) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('refNo', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label">
                                Sipariş Durumu
                            </label>
                            <div class="col-sm-2">
                                <select name="status" class="form-control">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {!! ($status->id == $order->status ? ' selected="selected"' : '') !!}>{{ $status->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('status', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('odemeTuru', 'has-error') }}">
                            <label for="odemeTuru" class="col-sm-2 control-label">
                                Ödeme Türü
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="odemeTuru">
                                    @foreach($payMethods as $pmt)
                                        <option value="{{ $pmt->id }}" @if($order->odemeTuru == $pmt->id) selected="selected" @endif>{{ $pmt->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4"> {!! $errors->first('odemeTuru', '<span class="help-block">:message</span> ') !!} </div>
                        </div>
                        <div class="form-group {{ $errors->first('hesapId', 'has-error') }}">
                            <label for="hesapId" class="col-sm-2 control-label">
                                Banka Hesabı
                            </label>
                            <div class="col-sm-4">
                                <select class="form-control" id="hesapId" name="hesapId">
                                    <option value="">Seçiniz..</option>
                                    @foreach($bankAccounts as $bank)
                                        <option value="{{ $bank->id }}" @if($order->hesapId == $bank->id) selected="selected" @endif>{{ $bank->bankaAdi }} , {{ $bank->hesapAdi }} , {{ $bank->iban }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4"> <span class="help-block">Havale ise seçiniz.</span>

                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('brand', 'has-error') }}">
                            <label for="brand" class="col-sm-2 control-label">
                                Kargo Firması
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="kargoId" id="kargoId">
                                    @foreach($cargos as $cargo)
                                        <option value="{{ $cargo->id }}" @if($order->kargoId == $cargo->id) selected="selected" @endif>{{ $cargo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('brand', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kargoTakip" class="col-sm-2 control-label">
                                Kargo Takip No
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="kargoTakip" name="kargoTakip" class="form-control" placeholder="" value="{{{ Input::old('kargoTakip', $order->kargoTakip) }}}">
                            </div>
                            <div class="col-sm-4"> </div>
                        </div>
                        <div class="form-group">
                            <label for="hediye" class="col-sm-2 control-label">
                                Hediye Paketi
                            </label>
                            <div class="col-sm-2">
                                <?php echo Form::select('hediye', \App\Sabit::yesNo(), $order->hediye, array('class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-4"> </div>
                        </div>
                        <div class="form-group" style="border-top:1px #ccc solid;">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-4">&nbsp;</div>
                        </div>
                        <div class="form-group {{ $errors->first('alici_adi', 'has-error') }}">
                            <label for="alici_adi" class="col-sm-2 control-label">
                                Alıcı Adı
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="alici_adi" name="alici_adi" class="form-control" placeholder="" value="{{{ Input::old('alici_adi', $order->alici_adi) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('alici_adi', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('country_id', 'has-error') }}">
                            <label for="country_id" class="col-sm-2 control-label">
                                Ülke
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="country_id" id="country_id">
                                    <option value="">Seçiniz..</option>
                                    @foreach($countries as $ulke)
                                        <option value="{{ $ulke->id }}" @if($order->country_id == $ulke->id) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('country_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                         <div class="form-group {{ $errors->first('state', 'has-error') }}">
                            <label for="state" class="col-sm-2 control-label">
                                Eyalet
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="state" name="state" class="form-control" placeholder="" value="{{{ Input::old('state', $order->state) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('state', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('city_id', 'has-error') }}">
                            <label for="city_id" class="col-sm-2 control-label">
                                İl
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="city_id" name="city_id" class="form-control" placeholder="" value="{{{ Input::old('city_id', $order->city_id) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('city_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('town', 'has-error') }}">
                            <label for="town" class="col-sm-2 control-label">
                                İlçe
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="town" name="town" class="form-control" placeholder="" value="{{{ Input::old('town', $order->town) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('town', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('address', 'has-error') }}">
                            <label for="address" class="col-sm-2 control-label">
                               Adres
                            </label>
                            <div class="col-sm-4">
                                <textarea class="form-control" name="address">{{{ Input::old('address', $order->address) }}}</textarea>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('address', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('tel', 'has-error') }}">
                            <label for="tel" class="col-sm-2 control-label">
                                Telefon
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="tel" name="tel" class="form-control" placeholder="" value="{{{ Input::old('tel', $order->tel) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('tel', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('tckimlik', 'has-error') }}">
                            <label for="tckimlik" class="col-sm-2 control-label">
                                TC Kimlik No
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="tckimlik" name="tckimlik" class="form-control" placeholder="" value="{{{ Input::old('tckimlik', $order->tckimlik) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('tckimlik', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('faturaAyni', 'has-error') }}">
                            <label for="faturaAyni" class="col-sm-2 control-label">
                                Fatura Bilgileri
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" id="faturaAyni" name="faturaAyni">
                                    <option value="1" @if(Input::old('faturaAyni', $order->faturaAyni) == 1) selected="selected" @endif>Teslimat Bilgileriyle Aynı</option>
                                    <option value="0" @if(Input::old('faturaAyni', $order->faturaAyni) == 0) selected="selected" @endif>Teslimat Bilgilerinden Farklı</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                {!! $errors->first('faturaAyni', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group" style="border-top:1px #ccc solid;">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-4">&nbsp;</div>
                        </div>
                        <div class="form-group">
                            <label for="ftype" class="col-sm-2 control-label">
                                Fatura Türü
                            </label>
                            <div class="col-sm-2">
                                <?php echo Form::select('ftype', \App\Sabit::faturaType(), $order->ftype, array('class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-4"> </div>
                        </div>

                        <div class="form-group {{ $errors->first('fisim', 'has-error') }}">
                            <label for="fisim" class="col-sm-2 control-label">
                                Faturada Yazacak İsim
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="fisim" name="fisim" class="form-control" placeholder="" value="{{{ Input::old('fisim', $order->fisim) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('fisim', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('fcountry_id', 'has-error') }}">
                            <label for="fcountry_id" class="col-sm-2 control-label">
                                Ülke
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="fcountry_id" id="fcountry_id">
                                    <option value="">Seçiniz..</option>
                                    @foreach($countries as $ulke)
                                        <option value="{{ $ulke->id }}" @if($order->fcountry_id == $ulke->id) selected="selected" @endif>{{ $ulke->ulke }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('fcountry_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('fcity_id', 'has-error') }}">
                            <label for="fcity_id" class="col-sm-2 control-label">
                                İl
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="fcity_id" name="fcity_id" class="form-control" placeholder="" value="{{{ Input::old('fcity_id', $order->fcity_id) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('fcity_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('fstate', 'has-error') }}">
                            <label for="fstate" class="col-sm-2 control-label">
                                İlçe
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="fstate" name="fstate" class="form-control" placeholder="" value="{{{ Input::old('fstate', $order->fstate) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('fstate', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('faddress', 'has-error') }}">
                            <label for="faddress" class="col-sm-2 control-label">
                                Adres
                            </label>
                            <div class="col-sm-4">
                                <textarea class="form-control" name="faddress">{{{ Input::old('faddress', $order->faddress) }}}</textarea>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('faddress', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('ftel', 'has-error') }}">
                            <label for="ftel" class="col-sm-2 control-label">
                                Telefon
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="ftel" name="ftel" class="form-control" placeholder="" value="{{{ Input::old('ftel', $order->ftel) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('ftel', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('ftckimlik', 'has-error') }}">
                            <label for="ftckimlik" class="col-sm-2 control-label">
                                TC Kimlik No
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="ftckimlik" name="ftckimlik" class="form-control" placeholder="" value="{{{ Input::old('ftckimlik', $order->ftckimlik) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('ftckimlik', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('vergid', 'has-error') }}">
                            <label for="vergid" class="col-sm-2 control-label">
                                Vergi Dairesi
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="vergid" name="vergid" class="form-control" placeholder="" value="{{{ Input::old('vergid', $order->vergid) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('vergid', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('vergino', 'has-error') }}">
                            <label for="vergino" class="col-sm-2 control-label">
                                Vergi No
                            </label>
                            <div class="col-sm-2">
                                <input type="text" id="vergino" name="vergino" class="form-control" placeholder="" value="{{{ Input::old('vergino', $order->vergino) }}}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('vergino', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('orders') }}">
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