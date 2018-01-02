<?php namespace App\Http\Controllers;

use App\BankAccount;
use App\Cargo;
use App\City;
use App\State;
use App\Countrie;
use App\CreditCard;
use App\CustomerAddresse;
use App\DiscountCode;
use App\Library\Common;
use App\Library\GarantiPay;
//use App\Library\PosPay;
use App\Order;
use App\OrderDetails;
use App\Paymethod;
use App\PosAccount;
use App\Product;
use App\Review;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Sentry;
use View;
use Validator;
use Input;
use Request;
use Redirect;
use Lang;
use URL;
use File;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Config;
use Mail;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class frontOrdersController extends FrontController
{

    public function index($url)
    {

        if (!Auth::customer()->check()) {
            Session::put('redirect', URL::full());
            return Redirect::to("/giris")->with('warning', Lang::get('frontend/general.logintoorder'));
        }
        $user = Auth::customer()->get();

        if ($url == 'teslimat') {
            if (Cart::total() == 0)
                return Redirect::to("/");

            // Check if topTutar is more than the minimum checkout amount
            if (Cart::total() < 300) {
                return Redirect::back()->withInput()->with('warning', 'Minimum checkout amount is 300 QAD!');
            }

            $countries = Countrie::whereTeslimat(1)->orderBy('varsayilan', 'desc')->orderBy('ulke', 'asc')->get();
            $states = State::whereTeslimat(1)->orderBy('name', 'asc')->get(); //208:Türkiye
            $cities = City::whereTeslimat(1)->orderBy('name', 'asc')->get(); //208:Türkiye
            $tadresler = CustomerAddresse::where('customer_id', $user->id)->whereType(1)->get();
            $fadresler = CustomerAddresse::where('customer_id', $user->id)->whereType(2)->get();
            return View('siparis.teslimat', compact('user', 'countries', 'states', 'cities', 'tadresler', 'fadresler'));
        }
        if ($url == 'odeme') {
            if (Cart::total() == 0)
                return Redirect::to("/");

            if (Session::has('order')) {
                $payMethods = Paymethod::whereStatus(1)->orderBy('sequence', 'asc')->get();
                $bankAccounts = BankAccount::whereStatus(1)->orderBy('bankaAdi', 'asc')->get();
                $posAccounts = PosAccount::whereStatus(1)->select('id', 'bankname', 'cardname')->orderBy('mainpos', 'desc')->orderBy('bankname', 'asc')->get();
                return View('siparis.odeme', compact('payMethods', 'bankAccounts', 'posAccounts'));
            }
            return Redirect::to("/siparis/teslimat")->with('warning', Lang::get('frontend/general.errorandtry'));
        }
        if ($url == 'onay') {
            if (Session::has('sId')) {
                $sId = intval(Session::get('sId'));
                $sip = Order::whereId($sId)->where('uyeId', $user->id)->first();
                if ($sip == null) return Redirect::to("/uye/siparisler")->with('warning', Lang::get('frontend/general.checkurorderdetail'));
                return View('siparis.onay', compact('sip'));
            }
            return Redirect::to("/")->with('error', Lang::get('frontend/general.errorenterorder'));
        }
        return View('404');
    }

    public function saveOrder($url)
    {
        if (!Auth::customer()->check())
            return Redirect::to("/giris")->with('warning', Lang::get('frontend/general.pleaselogin'));
        $uye = Auth::customer()->get();

        if ($url == 'teslimat') {
            $inputs = Input::except('_token');
            $inputs['faturaAyni'] = Input::has('faturaAyni') ? Input::get('faturaAyni') : 0;
            $inputs['hediye'] = Input::has('hediye') ? Input::get('hediye') : 0;

            if ($inputs['faturaAyni'] == 0) {
                $rules = array(
                    'alici_adi' => 'required|min:3',
                    'country_id' => 'required|numeric|min:1',
                    'state_id' => 'required|numeric|min:1',
                    'city_id' => 'required|numeric|min:1',
                    'address' => 'required',
                    'tel' => 'required',
                    'fisim' => 'required',
                    'fcountry_id' => 'required|numeric|min:1',
                    'fstate_id' => 'required|numeric|min:1',
                    'fcity_id' => 'required|numeric|min:1',
                    'faddress' => 'required',
                    'ftel' => 'required'
                );
            } else {
                $rules = array(
                    'alici_adi' => 'required|min:3',
                    'country_id' => 'required|numeric|min:1',
                    'state_id' => 'required|numeric|min:1',
                    'city_id' => 'required|min:2',
                    'address' => 'required',
                    'tel' => 'required'
                );
            }

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            Session::put('order', $inputs);
            return Redirect::to('siparis/odeme');

        }
        if ($url == 'odeme') {
            if (Input::get('odemeTuru') == 1) {
                $rules = array(
                    'odemeTuru' => 'required',
                    'topTutar' => 'required',
                    'odemeTuruOnay' => 'required'
                );

            } else if (Input::get('odemeTuru') == 2) {
                $rules = array(
                    'odemeTuru' => 'required',
                    'topTutar' => 'required',
                    'hesapId' => 'required'
                );
            } else if (Input::get('odemeTuru') == 3) {
                $rules = array(
                    'odemeTuru' => 'required',
                    'topTutar' => 'required',
                    'ccname' => 'required',
                    'ccno' => 'required|min:16|max:20',
                    'cctype' => 'required',
                    'ccmonth' => 'required',
                    'cvc2' => 'required|min:3|max:4'
                );
            }
            if (Input::get('odemeTuru') == 6) {
                $rules = array(
                    'odemeTuru' => 'required',
                    'topTutar' => 'required',
                    'odemeTuruOnay' => 'required'
                );
            } else {
                $rules = array(
                    'odemeTuru' => 'required',
                    'topTutar' => 'required'
                );
            }

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $inputs = Input::except('_token');
            $order = Session::get('order');

            $kdv = 0;
            $kargoTutar = 0;
            $topTutar = 0;
            $i = 0;
            $myCart = array();
            foreach (Cart::Content() as $row) {
                $prd = Product::whereStatus(1)->whereId($row->id)->first();

                if (Input::get('odemeTuru') == 2) $havale_ind = 1;
                else $havale_ind = 0;
                $uFiyat = Common::getTotalPrice($prd->id, $havale_ind);

                if ($prd->kdv > 0) {
                    $prdKdv = Common::getKDV($prd->real_price, $prd->kdv) * $row->qty;
                    $kdv += $prdKdv;
                } else $prdKdv = 0;

                $prdKargo = 0;
                // $prdKargo = $prd->kargo_ucret * $row->qty;
                // $kargoTutar += $prdKargo;

                $topTutar = $topTutar + ($uFiyat * $row->qty) + $prdKargo;

                $myCart[$i]['product_id'] = $prd->id;
                $myCart[$i]['adet'] = $row->qty;
                $myCart[$i]['birimFiyat'] = $row->price;
                $myCart[$i]['toplamFiyat'] = $row->price * $row->qty;
                $myCart[$i]['kargoTutar'] = $prdKargo;
                $myCart[$i]['kdvTutar'] = $prdKdv;
                if ($row->options->opt) $myCart[$i]['option_id'] = serialize($row->options->opt);

                $i++;
            }

            // Apply shipment
            if ($topTutar < 500) {
                $state = State::whereId($order['state_id'])->first();
                if (!$state) {
                    return Redirect::back()->withInput()->with('warning', 'Select a state please!');
                }
                $kargoTutar = $state->shipping_price;
                $topTutar += $kargoTutar;
            }

            $data = array();
            $data['uyeId'] = $uye->id;
            $data['refNo'] = str_random(8);
            $data['odemeTuru'] = $inputs['odemeTuru'];
            $data['kargoTutar'] = $kargoTutar;
            $data['kargoId'] = 1;
            $data['hediye'] = $order['hediye'];
            $data['uyeIp'] = Request::ip();
            $data['alici_adi'] = $order['alici_adi'];
            $data['alici_email'] = $order['alici_email'];
            $data['country_id'] = $order['country_id'];
            $data['state_id'] = $order['state_id'];
            $data['city_id'] = $order['city_id'];
            $data['town'] = $order['town'];
            $data['address'] = $order['address'];
            $data['tel'] = $order['tel'];
            $data['tckimlik'] = $order['tckimlik'];
            $data['faturaAyni'] = $order['faturaAyni'];
            $data['ftype'] = $order['ftype'];
            if ($data['faturaAyni'] == 1) {
                $data['fisim'] = $order['alici_adi'];
                $data['fcountry_id'] = $order['country_id'];
                $data['fstate'] = $order['state_id'];
                $data['fcity_id'] = $order['city_id'];
                $data['ftown'] = $order['town'];
                $data['faddress'] = $order['address'];
                $data['ftel'] = $order['tel'];
                $data['ftckimlik'] = $order['tckimlik'];
            } else {
                $data['ftype'] = $order['ftype'];
                $data['fisim'] = $order['fisim'];
                $data['fcountry_id'] = $order['fcountry_id'];
                $data['fstate'] = $order['fstate_id'];
                $data['fcity_id'] = $order['fcity_id'];
                $data['ftown'] = $order['ftown'];
                $data['faddress'] = $order['faddress'];
                $data['ftel'] = $order['ftel'];
                $data['ftckimlik'] = $order['ftckimlik'];
            }
            $data['vergid'] = $order['vergid'];
            $data['vergino'] = $order['vergino'];

            //if has a promotion code
            if (Input::get('indCode') != '') {
                $codeId = Common::isDiscountCodeActive(Input::get('indCode'));
                if ($codeId > 0) {
                    $discode = DiscountCode::find($codeId);
                    $data['ind_kod'] = $discode->code;
                    $data['ind_oran'] = $discode->rate;
                    $topTutar = Common::getYuzdeliFiyat($topTutar, $discode->rate);
                }
            }

            $topTutar = number_format($topTutar, 2, '.', '');
            $data['topTutar'] = $topTutar;

            if ($inputs['odemeTuru'] == 1) //CreditCard
            {
                $data['status'] = 7; //Ödeme Bekleniyor

                $posAccount = new \App\PosAccount();
                $account = $posAccount->where('mainpos', 1)->first();
                if ($account) {
                    $pospay = new GarantiPay($account->bankhandle, $account->getAttributes());
                }

                /*if(0 == $inputs['pos_id']) {
                        $account = $posAccount->where('mainpos', 1)->first();
                } else {
                        $accounts = $posAccount->all();
                        $mainPos = null;
                        foreach($accounts as $oneAccount) {
                                if($oneAccount['mainpos']) {
                                        $mainPos = $oneAccount;
                                }
                                if($oneAccount['id'] == $inputs['pos_id']) {
                                        $account = $oneAccount;
                                        break;
                                }
                        }
                        if(!$account) {
                                $account = ($mainPos?$mainPos:$oneAccount);
                        }
                }*/
                //$pospay = new PosPay($account->bankhandle, $account->getAttributes());
            } elseif ($inputs['odemeTuru'] == 4) //MailOrder
            {
                //TODO : this is passive now. Activate MailOrder from db.
                $data['status'] = 1; //Onay Bekliyor
            } elseif ($inputs['odemeTuru'] == 5) //Paypal
            {
                //TODO : this is passive now. Activate Paypal from db.
                $data['status'] = 7; //Ödeme Bekleniyor
            } elseif ($inputs['odemeTuru'] == 6) //Iyzico
            {
                $data['status'] = 7; //Ödeme Bekleniyor

                //TODO : Iyzico Sistemi düzeltilmelidir.
                return 'Iyzico ile ödeme sistemimiz düzenlenmektedir. Çok yakında hizmetinizde olacaktır.';
                die();
            }

            $order = Order::create($data);
            if ($order) {
                foreach ($myCart as $prd) {
                    $prd['order_id'] = $order->id;

                    if ($inputs['odemeTuru'] == 2) {
                        $hvlPrd = Product::whereId($prd['product_id'])->select('havale_ind_yuzde')->first();
                        if ($hvlPrd->havale_ind_yuzde > 0) {
                            $prd['havale_ind_yuzde'] = $hvlPrd->havale_ind_yuzde;
                            $fiyat = Common::getYuzdeliFiyat($prd['birimFiyat'], $hvlPrd->havale_ind_yuzde);
                            $prd['birimFiyat'] = $fiyat;
                            $prd['toplamFiyat'] = $fiyat * $prd['adet'];
                            $prd['kdvTutar'] = Common::getYuzdeliFiyat($prd['kdvTutar'], $hvlPrd->havale_ind_yuzde);
                        }
                    }

                    OrderDetails::create($prd);
                    if (Common::IsStockDinamic() === 1) {
                        $product = Product::whereId($prd['product_id'])->firstOrFail();
                        $product->stock -= $prd['adet'];
                        $product->save();
                    }
                }
                if ($order->ind_kod != '') {
                    $code = new DiscountCode;
                    $code->changeCodetoUsed($order->ind_kod);
                }
                Cart::destroy();
                Session::forget('order');

                if ($inputs['odemeTuru'] == 1)//Credit card. Pay after order is created.
                {
                    if ($account) {
                        $cardSuccess = true;
                        $return = $pospay->pay(array(
                            'card_no' => str_replace('-', '', $inputs['ccno']),
                            'card_date' => sprintf('%02d', $inputs['ccmonth']) . $inputs['ccyear'],
                            'card_cvc' => $inputs['cvc2'],
                            //'order_id' => sprintf('%010d', $order->id),
                            'order_id' => $order->id,
                            'amount' => $topTutar
                        ));

                        if (!$return) {
                            $cardSuccess = false;
                        }

                        if ($cardSuccess && isset($return['strReasonCodeValue']) && $return['strReasonCodeValue'] == '00') {
                            $order->status = 1;//Onay bekliyor
                            $order->save();
                        } else {
                            $errorMessage = '';
                            if (isset($return['strErrorMessage'])) {
                                $errorMessage = $return['strErrorMessage'] . '.';
                            }
                            if (Config::get('app.debug') && isset($return['strReasonCodeValue'])) {
                                $errorMessage .= '<br>' . $return['strReasonCodeValue'] . ' - ' . $return['strErrorMessageDetails'] . '!';
                            }
                            return Redirect::to('siparis/onay')->with('error', $errorMessage)->withInput()->with('sId', $order->id);
                        }

                        /*$cardSuccess = true;
                        try
                        {
                            $return = $pospay->pay(array(
                                    'card_no' => str_replace('-', '', $inputs['ccno']),
                                    'card_date' => sprintf('%02d', $inputs['ccmonth']) . $inputs['ccyear'],
                                    'card_cvc' => $inputs['cvc2'],
                                    'order_id' => sprintf('%010d', $order->id),
                                    'amount' => $data['topTutar'],
                                    'inst' => ($inputs['inst']<=1?0:$inputs['inst'])
                            ));
                        } catch(\Exception $ex) {
                            $cardSuccess = false;
                        }
                        if($cardSuccess && $return->basariliMi()) {
                            $order->status = 1;//Onay bekliyor
                            $order->save();
                        } else {
                            $errorMessage = '';
                            if(Config::get('app.debug')) {
                                if($ex instanceof \Exception) {
                                    $errorMessage .= $ex->getMessage();
                                    return 'errormessage : '. $errorMessage;
                                } else {
                                    $bankMessages = $return->hataMesajlari();
                                    $errorMessage .= $bankMessages[0]['mesaj'];

                                    return 'bankmessage : '. $bankMessages;
                                }
                            }
                            return Redirect::to('siparis/onay')->with('error', $errorMessage)->withInput()->with('sId',$order->id);
                        }*/
                    } else {
                        return Redirect::to('siparis/onay')->with('error', 'POS Ayarları ile ilgili bir sorundan dolayı işleminizi gerçekleştiremiyoruz. Site yönetimi ile irtibata geçiniz.')->withInput()->with('sId', $order->id);
                    }
                } else if ($inputs['odemeTuru'] == 6)//Iyzıco. Pay after order is created.
                {

                }

                $settings = Common::getsiteConfigs();
                $email = $settings->email;
                $data = array(
                    'order' => $order,
                    'settings' => $settings
                );

                $common = new Common();
                Mail::send('emails.order-new', $data, function ($m) use ($email) {
                    $m->to($email, 'Site Yoneticisi');
                    $m->subject('Yeni Siparis');
                });

                if ($order->alici_email != '') {
                    Mail::send('emails.order-details', $data, function ($m) use ($order) {
                        $m->to($order->alici_email, $order->alici_adi);
                        $m->subject('Order Details');
                    });
                }
                return Redirect::to('siparis/onay')->with('sId', $order->id);
            }
            return Redirect::to('siparis/odeme')->with('error', Lang::get('frontend/general.errorandtry'))->withInput()->with('sId', $order->id);
        }
    }

    public function getOdeme($id)
    {
        if (!Auth::customer()->check()) {
            Session::put('redirect', URL::full());
            return Redirect::to("/giris")->with('warning', Lang::get('frontend/general.logintopay'));
        }
        $user = Auth::customer()->get();

        $order = Order::whereId($id)->where('uyeId', $user->id)->whereStatus(7)->where('odemeTuru', 3)->first();
        if ($order) {
            $payMethods = Paymethod::whereStatus(1)->orderBy('sequence', 'asc')->get();
            $bankAccounts = BankAccount::whereStatus(1)->orderBy('bankaAdi', 'asc')->get();
            $posAccounts = PosAccount::whereStatus(1)->select('id', 'bankname', 'cardname')->orderBy('mainpos', 'desc')->orderBy('bankname', 'asc')->get();
            return View('siparis.odemeyap', compact('order', 'payMethods', 'bankAccounts', 'posAccounts'));
        }

        return View('404');
    }

    public function postOdeme($id)
    {
        if (!Auth::customer()->check()) {
            Session::put('redirect', URL::full());
            return Redirect::to("/giris")->with('warning', Lang::get('frontend/general.logintopay'));
        }
        $user = Auth::customer()->get();

        $rules = array(
            'ccname' => 'required',
            'ccno' => 'required|min:16|max:20',
            'cctype' => 'required',
            'ccmonth' => 'required',
            'cvc2' => 'required|min:3|max:4'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $order = Order::whereId($id)->where('uyeId', $user->id)->first();
        if ($order) {
            $inputs = Input::except('_token');
            $topTutar = $order->topTutar;

            //if has a new promotion code
            if (Input::get('indCode') != '' && $order->ind_kod == '') {
                $codeId = Common::isDiscountCodeActive(Input::get('indCode'));
                if ($codeId > 0 && $order->ind_kod == '') {
                    $discode = DiscountCode::find($codeId);
                    $order->ind_kod = $discode->code;
                    $order->ind_oran = $discode->rate;
                    $topTutar = Common::getYuzdeliFiyat($topTutar, $discode->rate);
                }
            }
            $order->topTutar = $topTutar;

            $account = null;
            $posAccount = new \App\PosAccount();
            $account = $posAccount->where('mainpos', 1)->first();

            /*$posAccount = new \App\PosAccount();
            if(0 == $inputs['pos_id']) {
                $account = $posAccount->where('mainpos', 1)->first();
            } else {
                $accounts = $posAccount->all();
                $mainPos = null;
                foreach($accounts as $oneAccount) {
                    if($oneAccount['mainpos']) {
                        $mainPos = $oneAccount;
                    }
                    if($oneAccount['id'] == $inputs['pos_id']) {
                        $account = $oneAccount;
                        break;
                    }
                }
                if(!$account) {
                    $account = ($mainPos?$mainPos:$oneAccount);
                }
            }*/

            $pospay = new GarantiPay($account->bankhandle, $account->getAttributes());
            $cardSuccess = true;
            try {
                $return = $pospay->pay(array(
                    'card_no' => str_replace('-', '', $inputs['ccno']),
                    'card_date' => sprintf('%02d', $inputs['ccmonth']) . $inputs['ccyear'],
                    'card_cvc' => $inputs['cvc2'],
                    //'order_id' => sprintf('%010d', $order->id),
                    'order_id' => $order->id,
                    'amount' => $topTutar
                ));
            } catch (\Exception $ex) {
                $cardSuccess = false;
            }

            if ($cardSuccess && isset($return['strReasonCodeValue']) && $return['strReasonCodeValue'] == '00') {
                $order->status = 1;//Onay bekliyor
                $order->save();
            } else {
                $errorMessage = '';
                if (isset($return['strErrorMessage'])) {
                    $errorMessage = $return['strErrorMessage'] . '.';
                }
                if (Config::get('app.debug')) {
                    $errorMessage .= '<br>' . $return['strReasonCodeValue'] . ' - ' . $return['strErrorMessageDetails'] . '!';
                }
                return Redirect::back()->with('error', $errorMessage)->withInput()->with('sId', $order->id);
                //return Redirect::to('siparis/onay')->with('error', $errorMessage)->withInput()->with('sId',$order->id);
            }

            /*if($cardSuccess && $return->basariliMi()) {
                $order->status = 1;//Onay bekliyor
                $order->save();
            } else {
                $errorMessage = '';
                if(Config::get('app.debug')) {
                    if($ex instanceof \Exception) {
                        $errorMessage .= $ex->getMessage();
                    } else {
                        $bankMessages = $return->hataMesajlari();
                        $errorMessage .= $bankMessages[0]['mesaj'];
                    }
                }
                return Redirect::to('siparis/onay')->with('error', $errorMessage)->withInput()->with('sId',$order->id);
            }*/

            if ($order->save()) {
                return Redirect::to('siparis/onay')->with('sId', $order->id);
            }
            return Redirect::back()->with('error', Lang::get('frontend/general.errorandtry'))->withInput()->with('sId', $order->id);

        }
    }

}
