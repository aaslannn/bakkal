<?php
namespace App\Library;

use App\Brand;
use App\Categorie;
use App\City;
use App\Countrie;
use App\Customer;
use App\DiscountCode;
use App\Language;
use App\Order;
use App\Paymethod;
use App\Product;
use App\ProductOption;
use App\ProductProp;
use App\Setting;
use App\Town;
use App\Translation;
use Faker\Provider\cs_CZ\DateTime;
use igaster\laravelTheme\Theme;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Common extends Model
{
    public static function getCategoriesbyParent($pId = 0, $limit = 0)
    {
        if($limit > 0) $cats = Categorie::whereStatus(1)->where('parent_id',$pId)->orderBy('sequence','asc')->take($limit)->get();
        else $cats = Categorie::whereStatus(1)->where('parent_id',$pId)->orderBy('sequence','asc')->get();
        return $cats;
    }

    public static function getAllCats($pId = 0, $limit = 0, $lang = 'tr')
    {
        $myTitle = 'title_'.$lang;
        if($limit > 0) $cats = Categorie::whereStatus(1)->where('parent_id',$pId)->orderBy('sequence','asc')->get();
        foreach($cats as $cat)
        {
            echo $cat->$myTitle.'<br>';
            Common::getCats($cat->id);
        }
    }

    public static function getLocaleLangName($lang)
    {
        $lang = Language::whereKisaltma($lang)->first();
        return $lang->dil;
    }

    public static function getAltCatCount($pId = 0) //get Categories Children Count
    {
        return Categorie::whereStatus(1)->where('parent_id',$pId)->count();
    }

    public static function getsiteConfigs() //general Configs
    {
        $siteConfig = Setting::whereId(1)->first();
        return $siteConfig;
    }

    public static function getLogo() //get logo text or image
    {
        $siteConfig = self::getsiteConfigs();
        if($siteConfig->logo_type == 1)
        {
            return '<span style="color:'.$siteConfig->logo_color.'; font-size:'.$siteConfig->logo_fontsize.'px; font-weight:600; vertical-align:center;" class="logoText">'.$siteConfig->logo_text.'</span>';
        }
        return '<img src="'.asset('/uploads/'.$siteConfig->logo).'">';
    }

    public static function getCountry($id) //get Counntry Name
    {
        $country = Countrie::whereId($id)->first();
        if ($country) return $country->ulke;
        return '-';
    }
    public static function getCity($id) // get City Name
    {
        $city = City::whereId($id)->first();
        if ($city) return $city->il;
        return '-';
    }
    public static function getBrandName($id) // get Brand Name
    {
        $brand = Brand::whereId($id)->first();
        if ($brand) return $brand->name;
        return '-';
    }

    public static function getPrdImage($id,$size = 'k') //get Product Image with URL and size
    {
        $prd = Product::whereId($id)->select('id','image')->first();
        if ($prd->image != '')
            $img = url('/').'/uploads/products/'.$prd->id.'/'.$size.'-'.$prd->image;
        else
            $img = url('/').'/assets/images/nopic.jpg';
        return $img;
    }

    public static function getPrdPrice($id) //get Product Price
    {
        $prd = Product::whereId($id)->select('price','discount','discount_price')->first();

        if($prd->discount == 1 && $prd->discount_price > 0)
            return $prd->discount_price;
        return $prd->price;

    }

    public static function getYuzde($price,$newprice) //get Percentage of prices
    {
        $c = $price / 100;
        $yuzde = 100 - floor($newprice / $c);
        return '%'.$yuzde;
    }

    public static function getYuzdeliFiyat($price,$yuzde) //yüzde indirimli fiyat
    {
        $ind = $price * ($yuzde/100);
        $new = $price - $ind;
        return $new;
    }

    public static function getYuzdeArtiFiyat($price,$yuzde) //yüzde eklenen fiyat
    {
        $ind = $price * ($yuzde/100);
        $new = $price + $ind;
        return $new;
    }

    public static function getKDV($price,$rate)
    {
        if($rate > 0)
        {
            $kdv = $price * ($rate/100);
            return number_format($kdv,2);
        }
        return $price;
    }

    public static function addTaxToPrice($price,$rate)
    {
        if($rate > 0)
        {
            $kdv = $price * ($rate/100);
            $toplam = $price + $kdv;
            return $toplam;
        }
        return $price;
    }

    //get total price with discount,tax,banktransfer
    public static function getTotalPrice($pId, $havaleIndirim = 0)
    {
        $prd = Product::whereStatus(1)->select('id','real_price','havale_ind_yuzde','kdv')->whereId($pId)->first();

        if($havaleIndirim == 1 && $prd->havale_ind_yuzde > 0)
        {
            $price = Common::getYuzdeliFiyat($prd->real_price ,$prd->havale_ind_yuzde);
        }
        else
            $price = $prd->real_price;

        if($prd->kdv > 0)
            $price = Common::addTaxToPrice($price,$prd->kdv);

        return $price;
    }

    public static function getProductsbyCat($cId) //Get Products in Cat and Subcats
    {
        $idList = Common::getCatList($cId);
        $products = Product::whereStatus(1)->whereIn('cat_id',$idList)->paginate(15);
        return $products;
    }
    
    public static function getProductsCountbyCat($cId) //Get Products Count in Cat and Subcats
    {
        $idList = Common::getCatList($cId);
        $count = Product::whereStatus(1)->whereIn('cat_id',$idList)->count();
        return $count;
    }

    public static function getCatList($cId) //Get Cat and Subcats id array
    {
        $idList = array();
        $idList[] = $cId;
        $subs = Categorie::whereStatus(1)->where('parent_id',$cId)->get();
        foreach($subs as $sub)
        {
            $idList[] = $sub->id;
            if($sub->subcats->count() > 0)
            {
                foreach($sub->subcats as $sub2)
                {
                    $idList[] = $sub2->id;
                }
            }
        }
        return $idList;
    }

    public static function getCatListUp($cId) //Get Cat and ParnetCats id array (3 kat)
    {
        $idList = array();
        $idList[] = $cId;

        $cat = Categorie::whereId($cId)->first();

        if($cat->parentCat)
        {
            $idList[] = $cat->parentCat->id;
            if($cat->parentCat->parentCat)
                $idList[] = $cat->parentCat->parentCat->id;

        }
        $idList = array_reverse($idList); //breadcrumb gösterimi icin ters cevir
        return $idList;
    }

    public static function getCatBreadcrumb($cId, $withUrl = 0, $lang = 'tr')
    {
        $idList = Common::getCatListUp($cId);
        $degisken = '';
        foreach($idList as $catId)
        {
            $cat = Categorie::find($catId);
            $ctitle = 'title_'.$lang;
            if ($withUrl == 0) $degisken .= $cat->$ctitle.' / ';
            else $degisken .= '<li><a href="'.url('/urunler/'.$cat->sefurl).'">'.$cat->$ctitle.'</a></li>';
        }
        return $degisken;
    }

    public  static function getFirstPayMethod() //for default pay method.
    {
        $method = Paymethod::whereStatus(1)->orderBy('sequence','asc')->first();
        return $method->id;
    }

    public static function isDiscountCodeActive($disCode) //if active return id
    {
        $today = date("Y-m-d");
        $discode = DiscountCode::whereCode($disCode)->whereUsed(0)->where('rate','>',0)->where('start_date','<=',$today)->where('end_date','>=',$today)->first();
        if($discode) return $discode->id;
        return 0;
    }

    public static function getPercentOfOrders()
    {
        $orders = Order::all()->count();
        if($orders > 0)
        {
            $okOrders = Order::whereStatus(5)->count();

            $c = $orders / 100;
            $yuzde = floor($okOrders / $c);
            return $yuzde;
        }
        return 0;

    }

    public static function getPercentOfCusOrders()
    {
        $customers = Customer::all()->count();
        $orders = Order::where('status','!=',7)->select('uyeId')->groupBy('uyeId')->get()->count();

        $c = $customers / 100;
        $yuzde = floor($orders / $c);
        return $yuzde;
    }

    public static function getPriceFormatToDb($price) //get Percentage of prices
    {
        $price = str_replace(",00","",$price);
        $price = str_replace(".","",$price);
        $price = str_replace(",",".",$price);
        return $price;
    }

    public static function setPriceFormatToDb($price) //get Percentage of prices
    {
        $price = str_replace(",","",$price);
        return $price;
    }

    public static function IsStockDinamic() // Is Stock Dinamic?? 1/0
    {
        $siteConfig = Setting::whereId(1)->select('dinamik_stok')->firstOrFail();
        return $siteConfig->dinamik_stok;
    }

    public static function getProductMaxQty($pId, $max = 0) //Get Product's Maximum Quantity
    {
        $prd = Product::whereId($pId)->select('stock')->firstOrFail();
        if($max == 0)
        {
            if(Common::IsStockDinamic() == 1)
                $max = $prd->stock;
            else
                $max = 99;
        }
        if($max < $prd->stock) return $max;
        else return $prd->stock;
    }

    public static function getPreviousPrdLink($pId) //Get Previous Product Link
    {
        $prd = Product::whereId($pId)->select('sequence','cat_id')->firstOrFail();

        $previousPrd = Product::where('cat_id',$prd->cat_id)->where('sequence','<',$prd->sequence)->orderBy('sequence','desc')->first();
        if($previousPrd)
            return '/urun/'.$previousPrd->sefurl;
        return '';

        /*
        $lastPrd = Product::where('cat_id',$prd->cat_id)->where('sequence','>',$prd->sequence)->orderBy('sequence','desc')->first();
        if($lastPrd)
        {
            return '/urun/'.$lastPrd->sefurl;
        }
        return '#';
        */
    }

    public static function getNextPrdLink($pId) //Get Previous Product Link
    {
        $prd = Product::whereId($pId)->select('sequence','cat_id')->firstOrFail();

        $nextPrd = Product::where('cat_id',$prd->cat_id)->where('sequence','>',$prd->sequence)->orderBy('sequence','asc')->first();
        if($nextPrd)
            return '/urun/'.$nextPrd->sefurl;
        return '';

        /*
        $firstPrd = Product::where('cat_id',$prd->cat_id)->where('sequence','<',$prd->sequence)->orderBy('sequence','asc')->first();
        if($firstPrd)
        {
            return '/urun/'.$firstPrd->sefurl;
        }
        return '#';
        */
    }

    public static function strtoupper_tr($string)
    {
        $little = array('ç','ğ','i','ı','ö','ş','ü');
        $big = array('Ç','Ğ','İ','I','Ö','S','Ü');
        return strtoupper(str_replace($little,$big,$string));

    }

    //Seperate opt column and write property & option
    public static function getPropsAndOptions($opt, $lang = 'tr')
    {
        if(self::isSerialized($opt)) $opt = unserialize($opt);

        $properties = '';
        if(is_array($opt))
        {
            foreach($opt as $key => $val)
            {
                if((int)$key != 0 && (int)$val != 0)
                {
                    $pName = ProductProp::find($key)->{'title_'.$lang};
                    $oName = ProductOption::find($val)->title_tr;
                    $properties .= $pName.' : '.$oName.', ';
                }
            }
            $properties = substr($properties,0,-2);
        }
        elseif((int)$opt > 0)
            $properties = ProductOption::whereId($opt)->first()->title_tr;

        return $properties;
    }

    public static function isSerialized($str) //return bool
    {
        return ($str == serialize(false) || @unserialize($str) !== false);
    }

}