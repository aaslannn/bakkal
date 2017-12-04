<?php namespace App\Http\Controllers;
use App\BankAccount;
use App\Cargo;
use App\City;
use App\Countrie;
use App\OrderStatu;
use App\Paymethod;
use App\PosAccount;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Order;

class OrdersController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('orders'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $orders = Order::orderBy('id','desc')->get();
        $statuses = OrderStatu::all();
        return View('admin/orders/index', compact('orders','statuses'));
    }

    public function getCreate()
    {
        return;
    }

    public function postCreate()
    {
        return;
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('orders_edit'))
            return Redirect::to('/admin/orders')->with('error', Lang::get('general.nopermission'));

        $order = Order::find($id);
        $countries = Countrie::whereTeslimat(1)->orderBy('varsayilan', 'desc')->get();
        //$cities = City::where('ulke_id',208)->orderBy('il', 'asc')->get(); //208:Türkiye
        $cargos = Cargo::whereStatus(1)->orderBy('name')->get();
        $payMethods = Paymethod::whereStatus(1)->orderBy('sequence','asc')->get();
        $bankAccounts = BankAccount::whereStatus(1)->orderBy('bankaAdi','asc')->get();
        $posAccounts = PosAccount::whereStatus(1)->select('id','bankname','cardname')->orderBy('mainpos','desc')->orderBy('bankname','asc')->get();
        $statuses = OrderStatu::all();

        if($order == null) return Redirect::route('orders')->with('error', Lang::get('orders/message.order_not_found', compact('id')));
        return View('admin/orders/edit', compact('order','countries','cargos','payMethods','bankAccounts','posAccounts','statuses'));
    }

    public function postEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('orders_edit'))
            return Redirect::to('/admin/orders')->with('error', Lang::get('general.nopermission'));

        $order = Order::find($id);
        if($order == null) return Redirect::route('orders')->with('error', Lang::get('orders/message.order_not_found', compact('id')));

        $rules = array(
            'alici_adi'     => 'required',
            'country_id'    => 'required|numeric|min:1',
            'city_id'     => 'required|min:2',
            'town'    => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $order->refNo = Input::get('refNo');
        $order->status = Input::get('status');
        $order->odemeTuru = Input::get('odemeTuru');
        $order->hesapId = Input::get('hesapId');
        $order->kargoId = Input::get('kargoId');
        $order->kargoTakip = Input::get('kargoTakip');
        $order->alici_adi = Input::get('alici_adi');
        $order->country_id = Input::get('country_id');
        $order->state = Input::get('state');
        $order->city_id = Input::get('city_id');
        $order->town = Input::get('town');
        $order->address = Input::get('address');
        $order->tel = Input::get('tel');
        $order->tckimlik = Input::get('tckimlik');
        $order->faturaAyni = Input::get('faturaAyni');
        $order->ftype = Input::get('ftype');
        $order->fisim = Input::get('fisim');
        $order->fcountry_id = Input::get('fcountry_id');
        $order->fstate = Input::get('fstate');
        $order->fcity_id = Input::get('fcity_id');
        $order->ftown = Input::get('ftown');
        $order->faddress = Input::get('faddress');
        $order->ftel = Input::get('ftel');
        $order->ftckimlik = Input::get('ftckimlik');
        $order->vergid = Input::get('vergid');
        $order->vergino = Input::get('vergino');

        if ($order->save()) {
            // Redirect to the setting page
            return Redirect::route('orders')->with('success', Lang::get('orders/message.success.update'));
        } else {
            // Redirect to the group page
            return Redirect::route('orders', $id)->with('error', Lang::get('orders/message.error.update'));
        }

    }

    public function getModalDelete($id = null)
    {
        $model = 'orders';
        $confirm_route = $error = null;

        $order = Order::find($id);
        if($order == null)
        {
            $error = Lang::get('admin/orders/message.order_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/order',['id'=>$order->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('orders_edit'))
            return Redirect::to('/admin/orders')->with('error', Lang::get('general.nopermission'));

        $order = Order::find($id);
        if($order == null) return Redirect::route('orders')->with('error', Lang::get('orders/message.order_not_found', compact('id')));
        $order->delete();
        return Redirect::route('orders')->with('success', Lang::get('orders/message.success.delete'));
    }

    public function show($id)
    {
        $order = Order::find($id);
        $statuses = OrderStatu::all();
        if($order == null) return Redirect::route('orders')->with('error', Lang::get('orders/message.order_not_found', compact('id')));
        return View('admin.orders.show', compact('order','statuses'));
    }

    public function getPrintView($id)
    {
        $order = Order::find($id);
        if($order == null) return Redirect::route('orders')->with('error', Lang::get('orders/message.order_not_found', compact('id')));
        return View('admin.orders.print', compact('order'));
    }

}
