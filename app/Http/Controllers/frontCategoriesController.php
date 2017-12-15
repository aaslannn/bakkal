<?php namespace App\Http\Controllers;
use App\Brand;
use App\Library\Common;
use App\Product;
use App\Categorie;
use Sentry;
use Session;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use DB;



//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class frontCategoriesController extends FrontController
{

    public function index($url = null)
    {
        if($url === null)
        {
            $categories = Categorie::whereStatus(1)->where('parent_id', 0)->orderBy('sequence','asc')->get();
            return View('kategoriler', compact('categories'));
        }

        $cat = Categorie::whereStatus(1)->whereSefurl($url)->first();
        if($cat)
        {
            $idList = Common::getCatList($cat->id);

            $products = Product::whereStatus(1)
                                    ->whereIn('cat_id',$idList);

            $page = Input::has('page') ? Input::get('page') : 1;
            $myUrl = '/urunler/'.$cat->sefurl.'/?page='.$page;

            $brands = Input::has('brands') ? Input::get('brands') : []; //blank array
            $discount = Input::has('discount') ? Input::get('discount') : null;
            $new = Input::has('new') ? Input::get('new') : null;
            $stock = Input::has('stock') ? Input::get('stock') : null;
            $min_price = Input::has('min_price') ? Input::get('min_price') : null;
            $max_price = Input::has('max_price') ? Input::get('max_price') : null;
            $orderBy = Input::has('orderBy') ? Input::get('orderBy') : null;

            if($discount == 1)
            {
                $products->whereDiscount(1);
                $myUrl .= '&discount=1';
            }
            if($new == 1)
            {
                $products->whereNew(1);
                $myUrl .= '&new=1';
            }
            if($stock == 1)
            {
                $products->where('stock','>',0);
                $myUrl .= '&stock=1';
            }
            if(isset($min_price))
            {
                $min_price = Common::getPriceFormatToDb($min_price);
                $products->where('real_price', '>=', $min_price);
                $myUrl .= '&min_price='.$min_price;
            }
            if(isset($max_price) && $max_price > 0)
            {
                $max_price = Common::getPriceFormatToDb($max_price);
                $products->where('real_price', '<=', $max_price);
                $myUrl .= '&max_price='.$max_price;
            }
            if(count($brands) > 0)
            {
                $products->whereIn('brand_id',$brands);
                foreach ($brands as $brand) {
                    $myUrl .= '&brands[]='.$brand;
                }
            }

            /*
            if(isset($orderBy))
                $myUrl .= '&orderBy='.$orderBy;
            */

            if($orderBy == 'chosen') $products->orderBy('chosen','desc');
            elseif($orderBy == 'new') $products->orderBy('new','desc')->orderBy('created_at','desc');
            elseif($orderBy == 'minPrice') $products->orderBy('real_price','asc');
            elseif($orderBy == 'maxPrice') $products->orderBy('real_price','desc');
            else $products->orderBy('sequence','asc');

            $products = $products->paginate(18);

            $markalar = Product::whereStatus(1)
                                ->whereIn('cat_id',$idList)
                                ->where('brand_id','>', 0)
                                ->select('brand_id', DB::raw('count(*) as total'))
                                ->groupBy('brand_id')
                                ->get();

            if( Session::has('catStyle')) {
                $catStyle = Session::get('catStyle');
            }
            else $catStyle = 'Thumbnail';

            return View('urunler', compact('cat','products','markalar','orderBy','myUrl','catStyle'));
        }

        return View('404');

    }
    
    /*
    public function getProductList()  //get products by JSON
    {        
        $products = Product::whereStatus(1)->get();
        $limit = 6;
        
        $productlist = array();
        
        foreach ($products as $prd){
            $productlist[] = array(                
                'image'     => "images/sample-products/001.jpg",
                'title'     => $prd->title_en,
                'url'       => "#".$prd->id,
                'discount'  => true,
                'discountPrice' => "299 TL",
                'damping'   => "%15 indirim",
                'price'     => "249 TL",
                'newStatus' => true
            );            
        }         
        $productlist['pagecount'] = ceil($products->count() / $limit);
        
        return "productlist:". json_encode($productlist, JSON_PRETTY_PRINT);
    }
     */
}
