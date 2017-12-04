<?php namespace App\Http\Controllers;
use App\Favorite;
use App\Library\Common;
use App\Review;
use App\PosAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sentry;
use View;
use Validator;
use Input;
use Request;
use Redirect;
use Lang;
use URL;
use File;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Share;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class frontProductsController extends FrontController
{

    public function index($url)
    {
        $prd = Product::whereStatus(1)->whereSefurl($url)->first();
        if($prd)
        {
            $reviews = $prd->reviews()->with('user')->approved()->notSpam()->orderBy('created_at','desc')->take(60)->paginate(15);
            $options = $prd->products_options()->where('stok','>',0)->get();
            $banks = PosAccount::whereStatus(1)->orderBy('mainpos','desc')->get();

            $socialLinks = Share::load(URL::full(), Common::getsiteConfigs()->meta_baslik.' / '.$prd->title_tr)->services('facebook', 'twitter', 'gplus');
            return View('urun', compact('prd','reviews','options','url','banks','socialLinks'));
        }

        return View('404');

    }

    public function postReview($pSefurl)
    {
        $input = array(
            'comment' => Input::get('comment'),
            'rating'  => Input::get('rating'),
            'user_id' => Input::get('uId')
        );
        $review = new Review;
        $validator = Validator::make( $input, $review->getCreateRules());
        if ($validator->passes()) {
            $review->storeReviewForProduct($pSefurl, $input['comment'], $input['rating'], $input['user_id']);
            return Redirect::to('urun/'.$pSefurl.'#DetailContent')->with('review_posted',true);
        }
        return Redirect::to('urun/'.$pSefurl.'#DetailContent')->withErrors($validator)->withInput();
    }

    public function ChangeReview($pSefurl)
    {
        if( Request::ajax())
        {
            $rId = Input::get('rId');
            $uId = Input::get('uId');
            $pId = Input::get('pId');
            $comment = Input::get('comment');

            $review = Review::whereId($rId)->where('pr_id',$pId)->where('user_id',$uId)->first();
            if($review)
            {
                $input = array(
                    'comment' => Input::get('comment'),
                    'rating'  => Input::get('rating'),
                    'user_id' => Input::get('uId')
                );
            }
        }

        $input = array(
            'comment' => Input::get('comment'),
            'rating'  => Input::get('rating'),
            'user_id' => Input::get('uId')
        );
        $review = new Review;
        $validator = Validator::make( $input, $review->getCreateRules());
        if ($validator->passes()) {
            $review->changeReviewForProduct($pSefurl, $input['comment'], $input['rating'], $input['user_id']);
            return Redirect::to('urun/'.$pSefurl.'#DetailContent')->with('review_posted',true);
        }
        return Redirect::to('urun/'.$pSefurl.'#DetailContent')->withErrors($validator)->withInput();
    }

    public function postCart()
    {
        $lang = Session::get('locale');

        if( Request::ajax()){
            $data = Input::all();

            $pId = $data['pId'];
            $prd = Product::whereStatus(1)->whereId($pId)->first();


            $result = array();
            if($prd)
            {
                //max stock
                if(Common::IsStockDinamic() === 1)
                    $maxStock = $prd->stock;
                else
                    $maxStock = 99;

                if($data['opt'])
                    $cart = Cart::search(array('id' => $prd->id, 'opt' =>$data['opt']));
                else
                    $cart = Cart::search(array('id' => $prd->id)); //options abandoned if cart exist.

                if($cart) //if product is already in cart
                {
                    $cart = Cart::get($cart[0]);
                    if($cart->qty >= $maxStock)
                    {
                        $qty = $maxStock;
                        $result['warning'] = Lang::get('frontend/general.productstocklimited', array('stokadet'=>$maxStock), $lang);
                        $result['nostock'] = Lang::get('frontend/general.notinstock',array(),$lang);
                    }
                    else
                    {
                        $qty = $cart->qty + $data['qty'];
                        if($qty > $maxStock)
                        {
                            $qty = $maxStock;
                            $result['warning'] = Lang::get('frontend/general.productstocklimited', array('stokadet'=>$maxStock), $lang);
                            $result['nostock'] = Lang::get('frontend/general.notinstock',array(),$lang);
                        }
                        $result['success'] = Lang::get('frontend/general.productaddedcart',array(),$lang);
                        Cart::update($cart->rowid, array('qty' => $qty));
                    }
                }
                else //if product is not exist in cart
                {
                    if($data['qty'] > $maxStock)
                    {
                        $data['qty'] = $maxStock;
                        $result['nostock'] = Lang::get('frontend/general.notinstock',array(),$lang);
                        $result['warning'] = Lang::get('frontend/general.stocklimited', array('stokadet'=>$maxStock), $lang);

                    }
                    if ($data['opt']) Cart::add($prd->id,$prd->title_tr, $data['qty'], $prd->real_price, array('opt' => $data['opt']) );
                    else Cart::add($prd->id,$prd->title_tr, $data['qty'], $prd->real_price);
                    $result['success'] = Lang::get('frontend/general.productaddedcart',array(),$lang);
                }
                $result['count'] = Cart::count();
                return $result;
            }
        }
    }

    public function delCart()
    {
        if( Request::ajax())
        {
            $rowId = Input::get('rowId');
            Cart::remove($rowId);
            if(Cart::total() == 0) Cart::destroy();
            return $rowId;
        }
    }

    public function showCart()
    {
        return View('sepet');
    }

    public function updateCart()
    {
        $cart = Cart::Content();
        foreach($cart as $row)
        {
            $cartQty = intval(Input::get('qty_'.$row->rowid));
            if($cartQty < 1)
                Cart::remove($row->rowid);
            else
            {
                if(Common::IsStockDinamic() === 1)
                    $maxStock = Common::getProductMaxQty($row->id);
                else
                    $maxStock = 99;
                if($cartQty > $maxStock)
                    $cartQty = $maxStock;
                Cart::update($row->rowid, array('qty' => $cartQty));
            }

        }
        if(Cart::total() == 0) Cart::destroy();
        return Redirect::to("/sepet")->with('success', Lang::get('frontend/general.cartupdated'));
    }


    public function postFavorite($pSefurl)
    {
        $input = array(
            'user_id' => Input::get('uId')
        );
        $favorite = new Favorite;
        $validator = Validator::make( $input, $favorite->getCreateRules());
        if ($validator->passes()) {
            $favorite->storeFavoriteForProduct($pSefurl, $input['comment'], $input['rating'], $input['user_id']);
            return Redirect::to('urun/'.$pSefurl.'#DetailContent')->with('review_posted',true);
        }
        return Redirect::to('urun/'.$pSefurl.'#DetailContent')->withErrors($validator)->withInput();
    }

}
