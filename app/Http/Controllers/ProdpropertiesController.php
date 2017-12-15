<?php namespace App\Http\Controllers;
use App\Brand;
use App\Http\Requests\ProdPropRequest;
use App\ProductProp;
use App\Setting;
use Illuminate\Support\Str;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use DB;
use App\Product;
use App\Categorie;
use App\ProductOption;



class ProdpropertiesController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function index($id)
    {
        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $properties = ProductProp::where('pr_id', $id)->orderBy('id','ASC')->get();
        return View('admin/properties/index', compact('product','properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ProdPropRequest $request,$id)
    {
        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $inputs = array();
        $inputs['pr_id'] = $id;
        if($request->has('title_tr')) $inputs['title_tr'] = $request->get('title_tr');
        if($request->has('title_en')) $inputs['title_en'] = $request->get('title_en');

        $prop = new ProductProp($inputs);
        $prop->save();

        if ($prop->id)
        {
            $options = $request->get('options');
            foreach ($options as $option)
            {
                if(trim($option) != '')
                {
                    $opt = ProductOption::create(array(
                        'pr_id'     => $id,
                        'prop_id'   => $prop->id,
                        'title_en'  => trim($option),
                        'stok'      => 1
                    ));
                }
            }
            return Redirect::route('prodproperties', $id)->with('success', Lang::get('products/message.success.propCreate'));
        }
        return Redirect::route('prodproperties', $id)->with('error', Lang::get('products/message.delete.propCreate'));
    }

    public function edit($prId, $id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($prId);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('prId')));

        $prop =  ProductProp::find($id);
        if($prop == null) return redirect()->route('prodproperties',['id' =>$prId])->with('error', Lang::get('properties/message.prop_not_found', compact('id')));

        return View('admin/properties/edit', compact('prop'));
    }

    public function update(ProdPropRequest $request,$prId, $id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $prop =  ProductProp::find($id);
        if($prop == null) return redirect()->route('prodproperties',['id' =>$prId])->with('error', Lang::get('products/message.product_not_found', compact('id')));

        if($request->has('title_tr')) $prop->title_tr = $request->get('title_tr');
        if($request->has('title_en')) $prop->title_en = $request->get('title_en');

        if ($prop->save())
        {
            //options update
            $options = $request->get('oldoptions');
            foreach ($options as $key => $val)
            {
                $opt = ProductOption::find($key);

                if(trim($val) != '')
                {
                    $opt->title_en = trim($val);
                    $opt->save();
                }
                else
                    $opt->delete();
            }

            //new options save
            if($request->has('options'))
            {
                $options = $request->get('options');
                foreach ($options as $option)
                {
                    if(trim($option) != '')
                    {
                        $opt = ProductOption::create(array(
                            'pr_id'     => $id,
                            'prop_id'   => $prop->id,
                            'title_en'  => trim($option),
                            'stok'      => 1
                        ));
                    }
                }
            }
            return Redirect::route('prodproperties', $prId)->with('success', Lang::get('products/message.success.propCreate'));
        }
        return Redirect::route('prodproperties', $prId)->with('error', Lang::get('products/message.delete.propCreate'));
    }

    public function getModalDelete($prId = null, $id = null)
    {
        $model = 'properties';
        $confirm_route = $error = null;

        $prop =  ProductProp::find($id);
        if($prop == null)
        {
            $error = Lang::get('admin/properties/message.prop_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/prodprop',['prId'=>$prId, 'id'=>$prop->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function destroy($prId = null, $id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_add'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $prop =  ProductProp::find($id);
        if($prop == null) return redirect()->route('prodproperties',['id' =>$prId])->with('error', Lang::get('properties/message.prop_not_found', compact('id')));

        \DB::table('products_options')->where('prop_id',$prop->id)->delete();
        $prop->delete();
        return redirect()->route('prodproperties',['id' =>$prId])->with('success', Lang::get('properties/message.success.delete'));
    }
}
