<?php namespace App\Http\Controllers;
use App\Categorie;
use App\City;
use App\Content;
use App\CustomerAddresse;
use App\DiscountCode;
use App\Favorite;
use App\Library\Common;
use App\PosAccount;
use App\Product;
use App\Setting;
use App\Slide;
use Gloudemans\Shoppingcart\Facades\Cart;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Hash;
//use Sentry;
use View;
use Auth;
use Input;
use App\Review;
use Lang;
use LaravelLocalization;


class FrontController extends Controller {

	protected $messageBag = null;
	protected $siteSettings;
	protected $translates;
    protected $locale = 'en';

	public function __construct() {
		$this->messageBag = new MessageBag;
		$this->beforeFilter('csrf',array('on'=> array('post')));

		$this->siteSettings = Setting::whereId(1)->first();
		View::share('siteSettings', $this->siteSettings);
		Theme::set($this->siteSettings->theme);

        $this->locale = LaravelLocalization::getCurrentLocale();
        view::share('defLocale',$this->locale);
	}

	public function getIndex()
	{
        $pass = Hash::make("12345678");
		$slides = Slide::whereStatus(1)->orderBy('sequence','asc')->take(5)->get();
		$chosens = Product::whereStatus(1)->whereChosen(1)->orderBy('sequence','asc')->take(5)->get();
		$dProducts = Product::whereStatus(1)->whereDiscount(1)->where('discount_price', '>', 0)->orderBy('sequence','asc')->take(16)->get();
		$vProducts = Product::whereStatus(1)->whereHome(1)->orderBy('sequence','asc')->take($this->siteSettings->featured_count)->get();

		return View('index', compact('slides','chosens','dProducts','vProducts'));
	}

	public function getContent($id)
	{
		$content = Content::whereStatus(1)->whereSefurl($id)->first();
		$contents = Content::whereStatus(1)->where('parent_id',0)->orderBy('sequence','asc')->get();

		if($content)
			return View('icerik', compact('content','contents'));
		return View('404');

	}

	public function islemler()
	{
		$lang = Session::get('locale');

		if( Request::ajax())
		{
			$islem = Input::get('islem');

			if($islem == 'getCity') //get cities by country
			{
				$country = Input::get('country');
				$cities = City::where('ulke_id',$country)->whereTeslimat(1)->orderBy('name')->lists('name','id');
				return $cities;
			}
			if($islem == 'getAdres' && Input::get('uid') > 0) //get address by id
			{
				$adrId = Input::get('adres');
				$uId = Input::get('uid');
				$adres = CustomerAddresse::whereId($adrId)->where('customer_id', $uId)->first();
				return $adres;
			}
			if($islem == 'addFavorite') //User can add product to favorites
			{
				if(Input::get('uId') > 0)
				{
					$uId = Input::get('uId');
					$prId = Input::get('id');

					$fav = Favorite::where('pr_id',$prId)->where('user_id',$uId)->first();
					if($fav == null)
					{
						$favorite = Favorite::create(array(
							'pr_id' => $prId,
							'user_id' => $uId
						));
						if ($favorite) return '<span class="ColorGreen">'.Lang::get('frontend/general.addedtofavoritelist',array(),$lang).'</span>';
						return Lang::get('frontend/general.errorandtry');
					}
					return '<span class="ColorGreen">'.Lang::get('frontend/general.productexists',array(),$lang).'</span>';
				}
				else return '<span class="ColorOrange">'.Lang::get('frontend/general.pleaselogin',array(),$lang).'</span>';

			}
			if($islem == 'delReview') //User can delete his/her own review
			{
				$return = array();
				if(!Auth::customer()->check())
					return array('succes'=>false, 'message'=>Lang::get('frontend/general.pleaselogin',array(),$lang));
				$cust = Auth::customer()->get();
				$uId = $cust->id;

				$prdId = Input::get('pId');
				$reviewId = Input::get('rId');
				$pSefurl = Input::get('pSefurl');
				$review = Review::whereId($reviewId)->where('pr_id',$prdId)->where('user_id',$uId)->first();
				if($review)
				{
					$review->delReviewForProduct($pSefurl,  $reviewId);
					return array('success'=>true, 'message'=>Lang::get('frontend/general.commentremoved',array(),$lang));
				}
				return array('success'=>false, 'message'=>Lang::get('frontend/general.anerroroccurred',array(),$lang));
			}
			if($islem == 'changeReview') //User can change his/her own review
			{
				$return = array();
				if(!Auth::customer()->check())
					return array('succes'=>false, 'message'=>Lang::get('frontend/general.pleaselogin',array(),$lang));
				$cust = Auth::customer()->get();
				$uId = $cust->id;

				$rId = Input::get('rId');
				$pId = Input::get('pId');
				$comment = Input::get('comment');
				$review = Review::whereId($rId)->where('pr_id',$pId)->where('user_id',$uId)->first();
				if($review)
				{
					$review->comment = $comment;
					if ($review->save()) {
						return array('success'=>true, 'message'=>Lang::get('frontend/general.commentchanged',array(),$lang));
					}
					return array('success'=>false, 'message'=>Lang::get('frontend/general.anerroroccurred',array(),$lang));
				}
				return array('success'=>false, 'message'=>Lang::get('frontend/general.anerroroccurred',array(),$lang));
			}
			if($islem == 'stockControl') //Get Max. Stock and Replace
			{
				$data = array();
				$qty = Input::get('qty');
				$pId = Input::get('pId');
				$max = Common::getProductMaxQty($pId);
				if($qty > $max)
				{
					$data['id'] = Input::get('id');
					$data['qty'] = $max;
					//$data['warning'] = 'Stoklarımızda bu üründen '.$max.' adet kalmıştır.';
				}
				return $data;

			}
			if($islem == 'addDisCode') //Add Discount Code
			{
				$data = array();
				$indKod = Input::get('indKod');

				if(Common::isDiscountCodeActive($indKod) > 0)
				{
					$codeId = Common::isDiscountCodeActive($indKod);
					$topTutar = Input::get('topTutar');
					$topHvlTutar = Input::get('topHvlTutar');

					$discode = DiscountCode::find($codeId);
					$data['code'] = $discode->code;
					$data['rate'] = $discode->rate;
					$data['total'] = number_format(Common::getYuzdeliFiyat($topTutar,$discode->rate),2,'.','');
					$data['hvltotal'] = number_format(Common::getYuzdeliFiyat($topHvlTutar,$discode->rate),2,'.','');
					$data['success'] = '<strong>'.Lang::get('frontend/general.congrats',array(),$lang).'!</strong> '.Lang::get('frontend/general.seccodeaddedtocart', array('coderate'=>$discode->rate), $lang);
				}
				else $data['error'] = '<strong>'.Lang::get('frontend/general.warning',array(),$lang).'!</strong> '.Lang::get('frontend/general.entervaliddescode',array(),$lang);
				return $data;
			}

			if($islem == 'getInstalments')
			{
				$posId = Input::get('posId');
				$topTutar = Input::get('topTutar');

				$pos = PosAccount::find($posId);
				if($pos)
				{
					if($pos->minTaksit <= $topTutar)
					{
						return $pos->taksitler;
					}
					else return '';
				}
			}
			if($islem == 'getCartCount')
			{
				return Cart::count();
			}
			if($islem == 'changeCatStyle')
			{
				$catStyle = Input::get('catStyle');
				Session::put('catStyle',$catStyle);
			}
			if($islem == 'addNewAddress') //Add New Address
			{
				if(!Auth::customer()->check())
					return array('error'=>Lang::get('frontend/general.pleaselogin',array(),$lang));

				if(Input::get('title') == '' || Input::get('name') == '' || Input::get('city_id') == '' || Input::get('state_id') == '' || Input::get('tel') == '')
					return array('error'=>Lang::get('frontend/general.fill-required-fields',array(),$lang));

				$cust = Auth::customer()->get();
				$data = array();
				$data['id'] = 0;
				$adres = CustomerAddresse::whereTitle(Input::get('title'))->where('customer_id',$cust->id)->first();

				if($adres == null)
				{
					$input = array();
					$input['title'] = Input::get('title');
					$input['name'] = Input::get('name');
					$input['country_id'] = Input::get('country_id');
					$input['state_id'] = Input::get('state_id');
					$input['city_id'] = Input::get('city_id');
					$input['town'] = Input::get('town');
					$input['adres'] = Input::get('adres');
					$input['tel'] = Input::get('tel');
					$input['tckimlik'] = Input::get('tckimlik');
					if(Input::get('type') == 2)
					{
						$input['vergid'] = Input::get('vergid');
						$input['vergino'] = Input::get('vergino');
					}
					$input['type'] = Input::get('type');
					$input['customer_id'] = $cust->id;
					$adres = CustomerAddresse::create($input);
					if($adres)
					{
						$data['success'] = Lang::get('frontend/general.addressadded',array(),$lang);
						$data['id'] = $adres->id;
					}
					else
						$data['error'] = Lang::get('frontend/general.errortrylater',array(),$lang);
				}
				else
				{
					$adres->title = Input::get('title');
					$adres->name = Input::get('name');
					$adres->country_id = Input::get('country_id');
					$adres->state_id = Input::get('state_id');
					$adres->city_id = Input::get('city_id');
					$adres->town = Input::get('town');
					$adres->adres = Input::get('adres');
					$adres->tel = Input::get('tel');
					$adres->tckimlik = Input::get('tckimlik');
					if(Input::get('type') == 2)
					{
						$adres->vergid = Input::get('vergid');
						$adres->vergino = Input::get('vergino');
					}
					if($adres->save())
					{
						$data['success'] = Lang::get('frontend/general.addresssavesuccess',array(),$lang);
						$data['id'] = $adres->id;
					}
					else
						$data['error'] = Lang::get('frontend/general.errortrylater',array(),$lang);
				}
				return $data;
			}

			if($islem == 'addressFill') //fill the address select
			{
				$data = array();
				if(Input::get('type') > 0)
				{
					if(Input::has('id'))
						$data['id'] = Input::get('id');

					if(!Auth::customer()->check())
						return array('error'=>Lang::get('frontend/general.pleaselogin',array(),$lang));
					$cust = Auth::customer()->get();

					$data['type'] = Input::get('type');
					$data['addresses'] = CustomerAddresse::whereType($data['type'])->where('customer_id',$cust->id)->orderBy('title')->lists('title','id');
				}
				return $data;
			}


		}
	}


    public function getIyzico()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-4kFdwIuOKVdohvcBMiPDmhLLUwWOtQJa");
        $options->setSecretKey("sandbox-nMir5VY6pS5qHQUhJA1ZFXGyKimfo9ZK");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");

        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice("1");
        $request->setPaidPrice("1.2");
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId("B67832");
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName("John Doe");
        $paymentCard->setCardNumber("5528790000000008");
        $paymentCard->setExpireMonth("12");
        $paymentCard->setExpireYear("2030");
        $paymentCard->setCvc("123");
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("0.3");
        $basketItems[0] = $firstBasketItem;

        $secondBasketItem = new \Iyzipay\Model\BasketItem();
        $secondBasketItem->setId("BI102");
        $secondBasketItem->setName("Game code");
        $secondBasketItem->setCategory1("Game");
        $secondBasketItem->setCategory2("Online Game Items");
        $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $secondBasketItem->setPrice("0.5");
        $basketItems[1] = $secondBasketItem;

        $thirdBasketItem = new \Iyzipay\Model\BasketItem();
        $thirdBasketItem->setId("BI103");
        $thirdBasketItem->setName("Usb");
        $thirdBasketItem->setCategory1("Electronics");
        $thirdBasketItem->setCategory2("Usb / Cable");
        $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $thirdBasketItem->setPrice("0.2");
        $basketItems[2] = $thirdBasketItem;
        $request->setBasketItems($basketItems);

        $payment = \Iyzipay\Model\Payment::create($request, $options);
    }
       
}