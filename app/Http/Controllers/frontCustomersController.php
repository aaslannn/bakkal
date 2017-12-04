<?php namespace App\Http\Controllers;
use App\Content;
use App\Customer;
use App\Library\Common;
//use Sentry;
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
use Socialite;
use Illuminate\Auth\GenericUser;
use DateTime;
use Exception;


//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class frontCustomersController extends FrontController
{
    /*
    public function __construct(){
        $this->beforeFilter('exists',array('only' => array('show', 'edit', 'update', 'destroy')));
    }
    */

    public function show($id)
    {
        $customer = Customer::find($id);
        if($customer == null) return Redirect::to("/")->with('error', Lang::get('customers/message.customer_not_found', compact('id')));
        return View('customer.show', compact('customer'));
    }

    public function getSignin()
    {
        if(Auth::customer()->check())
            return redirect()->intended('/');

        Session::put('redirect', URL::previous());
        return View('giris');
    }

    public function postSignin()
    {
       $rules = array(
            'email'    => 'required|email',
            'password' => 'required|between:3,32',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('password'))->withErrors($validator);
        }

        $creds = array(
            'email' => Input::get('email'),
            'password' => Input::get('password'),
			'activated' => '1'
        );

        if(Auth::customer()->attempt($creds))
        {
            $cust = Auth::customer()->get();
            $customer = Customer::find($cust->id);

            $customer->recordLogin();



            if( Session::has('redirect')) {
                $url = Session::get('redirect');
                Session::forget('redirect');
                return Redirect::intended($url);
            }
            return Redirect::intended("/");
        }
		//Check password and activated user when credentials are not found.
		$customer = Customer::where('email', $creds['email'])
			->get(array('activated', 'password'))
			->first();
		$errorMessage = Lang::get('frontend/general.loginerrortrygain');
		if($customer && Hash::check($creds['password'], $customer->password) && 0 == $customer->activated) {
			$errorMessage = Lang::get('frontend/general.member-notactive');
		}
        return Redirect::back()->withInput(Input::except('password'))->with('error', $errorMessage);
    }

    public function getSignup()
    {
        if(Auth::customer()->check())
            return redirect()->intended('/');

        $sozlesme = Content::whereSefurl('uyelik-sozlesmesi')->first();
        if ($sozlesme) return View('kayit', compact('sozlesme'));
        return View('kayit');
    }

    public function postSignup()
    {
        $rules = array(
            'first_name'       => 'required|min:3',
            'last_name'        => 'required|min:3',
            'email'            => 'required|email|unique:customers',
            'password'         => 'required|between:3,32',
            'password_confirm' => 'required|same:password',
            'sozlesme'         => 'required|min:1'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
            //return json_encode($validator->messages());
        }

        //singup
        $inputs = Input::except('_token');
        $inputs['passnohash'] = Input::get('password');
        $inputs['activated'] = 1;
        $uye = Customer::create($inputs);

        if($uye)
        {
            $settings = Common::getsiteConfigs();
            $mailBody  = Lang::get('frontend/general.mail-registerwelcome', array('name'=>$uye->first_name, 'sitename'=>$settings->meta_baslik, 'email'=>$uye->email, 'password' =>$uye->passnohash ));

            $data = array(
                'taslak'   => $mailBody,
                'settings' => $settings
            );

            // Send the activation code through email
            Mail::send('emails.taslak', $data, function ($m) use ($uye) {
                $m->to($uye->email, $uye->first_name . ' ' . $uye->last_name);
                $m->subject('Welcome ' . $uye->first_name);
            });


             //login
            $creds = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if(Auth::customer()->attempt($creds))
            {
                if( Session::has('redirect')) {
                    $url = Session::get('redirect');
                    Session::forget('redirect');
                    return Redirect::intended($url);
                }
                return Redirect::intended("/");
            }
            return Redirect::to("/giris")->with('error', Lang::get('frontend/general.logintryagain'));
        }
        return Redirect::back()->withInput(Input::except('password'))->withErrors($validator);

    }
	/**
	 * Social login controller.
	 * @param string $provider
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLoginSocial($provider = NULL)
	{
		$common = new Common();
		$provider_check_field = $provider . '_login';
		if(!$provider || !in_array($provider, array('facebook', 'twitter')) || !$common->getsiteConfigs()->$provider_check_field)  {
			return Redirect::to('giris');
		}
		return Socialite::driver($provider)->redirect();
	}
	/**
	 * Social signup controller. If there's no type, redirect to signup page.
	 * @param string $provider Social login type. facebook|twitter.
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getHandleSocial($provider = NULL)
	{
		$user = $token = $tokenSecret = NULL;
		switch($provider)
		{
			case 'facebook':
			case 'twitter':
				try {
					$user = Socialite::driver($provider)->user();
				} catch(Exception $e) {
					return Redirect::to('giris');
				}
				$token = $user->token;
				if('twitter' == $provider) {
					$tokenSecret = $user->tokenSecret;
				}
				if(!$user->getId())
					return Redirect::to('giris');
				break;
			default:
				return Redirect::to('giris');
				break;
		}
		$data = array(
			'email'					=> $user->getEmail(),
			'first_name'			=> $user->getName(),
			'activated'				=> '1',
			'social_login'			=> '1',
			'social_provider'		=> $provider,
			'social_user_id'		=> $user->getId(),
			'social_token'			=> $token,
			'social_token_secret'	=> $tokenSecret
		);
		//login with social user id and provider name
		$customer = Customer::where('social_login', '1')
			->where('social_provider', $data['social_provider'])
			->where('social_user_id', $data['social_user_id'])
			->first();
		if($customer && 0 == $customer->activated) {
			return Redirect::to("/giris")->with('error', Lang::get('frontend/general.member-notactive'));
		}
		if(empty($customer)) {
			$customer = Customer::create($data);
		}
		Auth::customer()->login(new GenericUser($customer->getAttributes()));
		$customer->last_login = new DateTime();
		$customer->social_token = $token;
		if($tokenSecret) {
			$customer->social_token_secret = $tokenSecret;
		}
		$customer->save();
		if( Session::has('redirect')) {
			$url = Session::get('redirect');
			Session::forget('redirect');
			return Redirect::intended($url);
		}
		return Redirect::intended("/");
	}

    public function LogOut()
    {
        Auth::customer()->logout();
        return redirect(URL::previous());
        //return Redirect::to("/");
    }

    public function getForgotPassword()
    {
        return View('sifre-hatirlatma');
    }

    public function postForgotPassword()
    {
        $rules = array(
            'email' => 'required|email',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to(URL::previous())->withInput()->withErrors($validator);
            //return Redirect::to(URL::previous() . '#toforgot')->withInput()->withErrors($validator);
        }

        $user = Customer::whereEmail(Input::get('email'))->first();
        if($user == null) return Redirect::to(URL::previous())->with('error', Lang::get('frontend/general.pleaseenteremail'));

        $settings = Common::getsiteConfigs();
        $mailBody  = Lang::get('frontend/general.mail-rememberpass', array('name'=>$user->first_name.' '.$user->last_name, 'sitename'=>$settings->meta_baslik, 'email'=>$user->email, 'password' =>$user->passnohash ));
        $data = array(
            'taslak'   => $mailBody,
            'settings' => $settings
        );

        Mail::send('emails.taslak', $data, function ($m) use ($user) {
            $m->to($user->email, $user->first_name.' '.$user->last_name);
            $m->subject('Login Informations');
        });

        if(count(Mail::failures()) > 0)
            return Redirect::to(URL::previous())->with('error', Lang::get('frontend/general.mailerrortrylater'));

        return Redirect::to(URL::previous())->with('success', Lang::get('frontend/general.logininfosent'));
    }
}
