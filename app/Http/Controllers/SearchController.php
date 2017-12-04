<?php namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

use App\Categorie;
use App\Library\Common;
use App\Product;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends FrontController
{
    /*
    public function appendValue($data, $type, $element)
    {
        // operate on the item passed by reference, adding the element and type
        foreach ($data as $key => & $item) {
            $item[$element] = $type;
        }
        return $data;
    }
    */

    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on sefurl
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix.'/'.$item['sefurl']);
        }
        return $data;
    }

    public function index()
    {
        $q = Input::get('q');
        //$catId = Input::has('catId') ? Input::get('catId') : 0;
        $catId = 0;
        $catId = Input::get('catId');
        $query = e(Input::get('q',''));

        if(!$query && $query == '') return Redirect::to('/');
        if (strlen($query) < 2) return Redirect::to("/");

        $products = Product::where(function($wq) use ($query) {
            $wq->where('title_tr','like','%'.$query.'%')
                ->orWhere('title_en','like','%'.$query.'%')
                ->orWhere('title_es','like','%'.$query.'%');
        });

        if($catId > 0)
        {
            $cat = Categorie::find($catId);
            if($cat)
            {
                $idList = Common::getCatList($cat->id);
                $products->whereIn('cat_id',$idList);
            }
        }

        $orderBy = Input::has('orderBy') ? Input::get('orderBy') : null;
        if($orderBy == 'chosen') $products->orderBy('chosen','desc');
        elseif($orderBy == 'new') $products->orderBy('new','desc')->orderBy('created_at','desc');
        elseif($orderBy == 'minPrice') $products->orderBy('real_price','asc');
        elseif($orderBy == 'maxPrice') $products->orderBy('real_price','desc');
        else $products->orderBy('sequence','asc');

        $products = $products->paginate(30);

        //$products = $this->appendURL($products, 'products');
        return View('results', compact('q','products','cat','orderBy'));
    }
}