<?php namespace App\Http\Controllers;

use App\City;
use App\Countrie;
use App\State;
use App\Customer;
use App\CustomerAddresse;
use App\Favorite;
use App\Library\Common;
//use Sentry;
use App\Order;
use Auth;
use Illuminate\Support\Facades\Session;
use View;
use Validator;
use Input;
use Request;
use Redirect;
use Lang;
use URL;
use File;
use Mail;
use Hash;


//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class frontAccountController extends FrontController
{
    protected $validationRules = array(
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email|unique:customers',
        'password' => 'required|between:3,32',
        'password_confirm' => 'required|same:password'
    );

    public function getProfile()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $countries = Countrie::whereTeslimat(1)->orderBy('varsayilan', 'desc')->get();
        $cities = City::whereTeslimat(1)->orderBy('name', 'asc')->get(); //208:Türkiye
        $states = State::whereTeslimat(1)->orderBy('name', 'asc')->get(); //208:Türkiye

        return View('uye.profil', compact('uye', 'countries', 'states', 'cities'));
    }

    public function postProfile()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        if (Input::get('_islem') == 'editProfile') {
            $rules = array(
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|unique:customers,email,' . $uye->email . ',email'
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            // Update the customer
            $uye->first_name = Input::get('first_name');
            $uye->last_name = Input::get('last_name');
            $uye->email = Input::get('email');
            $uye->dob = Input::get('dob') ? Input::get('dob') : null;
            $uye->gender = Input::get('gender');
            $uye->tckimlik = Input::get('tckimlik');
            $uye->country_id = Input::get('country_id');
            $uye->state_id = Input::get('state_id');
            $uye->city_id = Input::get('city_id');
            $uye->address = Input::get('address');
            $uye->tel = Input::get('tel');

            if ($uye->save()) {
                return Redirect::back()->with('success', Lang::get('frontend/general.infosavedsuccess'));
            }
            return Redirect::back()->withInput()->with('error', Lang::get('frontend/general.errorandtry'));
        }

        if (Input::get('_islem') == 'changePass') {
            $rules = array(
                'sifre' => 'required|between:3,32',
                'yeni_sifre' => 'required|between:3,32',
                'yeni_sifre_tekrar' => 'required|same:yeni_sifre'
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator)->with('changepassword', true);
            } elseif (Hash::check(Input::get('sifre'), $cust->password)) {
                $uye->password = Input::get('yeni_sifre');
                $uye->passnohash = Input::get('yeni_sifre');

                if ($uye->save()) {
                    return Redirect::to("/uye/profil")->with('success', Lang::get('frontend/general.passchangesuccess'))->with('changepassword', true);
                }
                return Redirect::to("/uye/profil")->with('error', Lang::get('frontend/general.errorandtry'))->with('changepassword', true);
            } else return Redirect::back()->with('error', Lang::get('frontend/general.passwrong'));
        }
    }

    public function getFavorites()
    {
        $orderBy = Input::has('orderBy') ? Input::get('orderBy') : null;

        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $favorites = $uye->favorites()->with('product')->orderBy('created_at', 'desc')->take(45)->paginate(15);

        return View('uye.favoriler', compact('uye', 'favorites'));
    }

    public function delFavorites()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $favs = Input::has('favs') ? Input::get('favs') : []; //blank array

        if (count($favs) > 0) {
            foreach ($favs as $fav) {
                $favorite = Favorite::whereId($fav)->where('user_id', $uye->id)->first();
                if ($favorite) {
                    $favorite->delete();
                    return Redirect::to("/uye/favoriler")->with('success', Lang::get('frontend/general.favoritedelsuccess'));
                }
                exit();
            }
        }
        return Redirect::to("/uye/favoriler");
    }

    public function getOrders()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $orders = $uye->orders()->with('orderdetails')->orderBy('created_at', 'desc')->take(45)->paginate(15);

        return View('uye.siparisler', compact('uye', 'orders'));
    }

    public function showOrder($id)
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $order = Order::whereId($id)->where('uyeId', $uye->id)->first();
        if ($order == null) return Redirect::to("/uye/siparisler")->with('error', Lang::get('frontend/general.orderdetailnotfound'));

        return View('uye.siparis', compact('uye', 'order'));
    }

    public function getModalCancelOrder($id = null)
    {
        $model = 'customers_orders';
        $confirm_route = $error = null;

        $order = Order::find($id);
        if ($order == null) {
            $error = Lang::get('frontend/general.errortrylater');
            return View('layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route = route('delete/siparis', ['id' => $order->id]);
        return View('layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getCancelOrder($id = null)
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.errortrylater'));

        $order = Order::whereId($id)->where('uyeId', $uye->id)->first();
        if ($order == null) return Redirect::to("/uye/siparisler")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $order->status = 4;
        if ($order->save()) {
            //mail to admin 
            $settings = Common::getsiteConfigs();
            $email = $settings->email;
            $data = array(
                'order' => $order,
                'settings' => $settings
            );

            $common = new Common();
            Mail::send('emails.order-cancelled', $data, function ($m) use ($email) {
                $m->to($email, 'Site Yoneticisi');
                $m->subject('Siparis Iptali');
            });
            if (count(Mail::failures()) > 0)
                return Redirect::to("/uye/siparisler")->with('warning', Lang::get('frontend/general.ordercancelled'));

            return Redirect::to("/uye/siparisler")->with('success', Lang::get('frontend/general.ordercancelled'));
        }
        return Redirect::to("/uye/siparisler")->with('error', Lang::get('frontend/general.anerroroccurred'));
    }

    public function getAddresses()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $addresses = $uye->adresses()->orderBy('title', 'asc')->take(20)->get();

        $countries = Countrie::whereTeslimat(1)->orderBy('varsayilan', 'desc')->get();
        //$cities = City::where('ulke_id',208)->orderBy('il', 'asc')->get(); //208:Türkiye

        return View('uye.adresler', compact('uye', 'addresses', 'countries'));
    }

    public function getModalAdrDelete($id = null)
    {
        $model = 'customers_address';
        $confirm_route = $error = null;

        $adres = CustomerAddresse::find($id);
        if ($adres == null) {
            $error = Lang::get('frontend/general.errortrylater');
            return View('layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route = route('delete/adres', ['id' => $adres->id]);
        return View('layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getAdrDelete($id = null)
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.errortrylater'));

        $adres = CustomerAddresse::whereId($id)->where('customer_id', $uye->id)->first();
        if ($adres == null) return Redirect::to("/uye/adresler")->with('error', Lang::get('frontend/general.anerroroccurred'));

        $adres->delete();
        return Redirect::to("/uye/adresler")->with('success', Lang::get('frontend/general.addressdelsuccess'));
    }

    public function postCreateAddress()
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.errortrylater'));

        $rules = array(
            'title' => 'required',
            'name' => 'required',
            'tel' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }


        $inputs = Input::except('_token');
        $inputs['customer_id'] = $uye->id;

        $adres = CustomerAddresse::create($inputs);
        if ($adres) return Redirect::to("/uye/adresler")->with('success', Lang::get('frontend/general.addressadded'));
        return Redirect::to("/uye/adresler")->with('error', Lang::get('frontend/general.errorandtry'));
    }

    public function getEditAddress($id)
    {
        if (!Auth::customer()->check())
            return redirect()->to('/');

        $cust = Auth::customer()->get();
        $uye = Customer::find($cust->id);
        if ($uye == null) return Redirect::to("/")->with('error', Lang::get('frontend/general.errortrylater'));

        $adres = CustomerAddresse::whereId($id)->where('customer_id', $uye->id)->first();
        if ($adres == null) return Redirect::to("/uye/adresler")->with('error', Lang::get('frontend/general.addressnotfound'));

        $countries = Countrie::whereTeslimat(1)->orderBy('varsayilan', 'desc')->get();
        $states = State::whereTeslimat(1)->orderBy('name', 'desc')->get();
        $cities = City::whereTeslimat(1)->orderBy('name', 'desc')->get();

        return View('uye/adres-duzenle', compact('adres', 'uye', 'countries', 'cities', 'states'));
    }

    public function postEditAddress($id = null)
    {
        $adres = CustomerAddresse::find($id);
        if ($adres == null) return Redirect::route('brands')->with('error', Lang::get('frontend/general.addressnotfound', compact('id')));

        $rules = array(
            'name' => 'required',
            'title' => 'required',
            'tel' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $adres->title = Input::get('title');
        $adres->name = Input::get('name');
        $adres->country_id = Input::get('country_id');
        $adres->state_id = Input::get('state_id');
        $adres->city_id = Input::get('city_id');
        $adres->adres = Input::get('adres');
        $adres->tel = Input::get('tel');
        $adres->tckimlik = Input::get('tckimlik');
        $adres->vergid = Input::get('vergid');
        $adres->vergino = Input::get('vergino');
        $adres->type = Input::get('type');

        if ($adres->save()) return Redirect::to("/uye/adresler")->with('success', Lang::get('frontend/general.addresssavesuccess'));
        return Redirect::to("/uye/adresler")->with('error', Lang::get('frontend/general.errortrylater'));
    }

}
