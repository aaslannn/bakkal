<?php namespace App\Http\Controllers;
use App\Customer;
use App\Library\Common;
use App\Licence;
use App\Order;
use App\Product;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Sentry;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use View;
use Request;
use Input;
use DB;

class MainController extends Controller {

	/**
     * Message bag.
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $messageBag = null;

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct()
    {
        // CSRF Protection
        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->messageBag = new MessageBag;
    }

    public function showHome()
    {
    	if(Sentry::check())
		{
			$today = date('Y-m-d');
			$thisMonth = date('Y-m-');

			$customers = Customer::count();
			$todayCustomers = Customer::where('created_at','like',$today.'%')->count();
			$monthCustomers = Customer::where('created_at','like',$thisMonth.'%')->count();

			$orders = Order::count();
			$todayOrders = Order::where('created_at','like',$today.'%')->count();
			$monthOrders = Order::where('created_at','like',$thisMonth.'%')->count();

			$products = Product::count();
			$todayProducts = Product::where('created_at','like',$today.'%')->count();
			$monthProducts = Product::where('created_at','like',$thisMonth.'%')->count();

			$money = 0;
			$todayMoney = 0;
			$monthMoney = 0;
			$allMoney = Order::whereStatus(5)->select(DB::raw('SUM(topTutar) as toplam'))->first();
			if($allMoney)
			{
				$money = $allMoney->toplam;
				$todaysMoney = Order::whereStatus(5)->where('created_at','like',$today.'%')->select(DB::raw('SUM(topTutar) as toplam'))->first();
				$todayMoney = $todaysMoney->toplam;
				$monthsMoney = Order::whereStatus(5)->where('created_at','like',$thisMonth.'%')->select(DB::raw('SUM(topTutar) as toplam'))->first();
				$monthMoney = $monthsMoney->toplam;
			}

			$licence = Licence::whereId(1)->first();

			return View('admin/index', compact('licence', 'customers','todayCustomers','monthCustomers','orders','todayOrders','monthOrders','products','todayProducts','monthProducts','money','todayMoney','monthMoney'));
		}
		else
			return Redirect::to('admin/signin');
    }

	public function changeStatus()
	{
		if( Request::ajax()) {
			if(Input::get('id') > 0 && Input::get('durum') > 0)
			{
				$id = Input::get('id');
				$order = Order::whereId($id)->first();
				if($order == null) return 'Sipariş ID Bulunamadı!';

				$order->status = Input::get('durum');
				if ($order->save()) return 'Sipariş Durumu Değiştirilmiştir.';
			}

		}
	}

    public function showView($name=null)
    {
    	if(View::exists('admin/'.$name))
		{
			if(Sentry::check())
				return View('admin/'.$name);
			else
				return Redirect::to('admin/signin')->with('error', 'Lütfen giriş yapınız!');
		}
		else
		    return View('admin/404');
    }
}