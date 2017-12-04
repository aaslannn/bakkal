<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Brand;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class BrandsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $brands = Brand::all();
        return View('admin/brands/index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands_add'))
            return Redirect::to('/admin/brands')->with('error', Lang::get('general.nopermission'));

        return View('admin/brands/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands_add'))
            return Redirect::to('/admin/brands')->with('error', Lang::get('general.nopermission'));

        $rules = array(
            'name'     => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $brand = Brand::create($inputs);
        if($brand) return Redirect::route('brands')->with('success', Lang::get('brands/message.success.create'));
        return Redirect::route('brands')->with('success', Lang::get('brands/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands_edit'))
            return Redirect::to('/admin/brands')->with('error', Lang::get('general.nopermission'));

        $brand = Brand::find($id);
        if($brand == null) return Redirect::route('brands')->with('error', Lang::get('brands/message.brand_not_found', compact('id')));
        return View('admin/brands/edit', compact('brand'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands_edit'))
            return Redirect::to('/admin/brands')->with('error', Lang::get('general.nopermission'));

        $brand = Brand::find($id);
        if($brand == null) return Redirect::route('brands')->with('error', Lang::get('brands/message.brand_not_found', compact('id')));

        $rules = array(
            'name'     => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $brand->name = Input::get('name');
        $brand->status = Input::get('status');
        if ($brand->save()) return Redirect::route('brands')->with('success', Lang::get('brands/message.success.update'));
        else return Redirect::route('brands', $id)->with('error', Lang::get('brands/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'brands';
        $confirm_route = $error = null;

        $brand = Brand::find($id);
        if($brand == null)
        {
            $error = Lang::get('admin/brands/message.brand_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/brand',['id'=>$brand->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('brands_add'))
            return Redirect::to('/admin/brands')->with('error', Lang::get('general.nopermission'));

        $brand = Brand::find($id);
        if($brand == null) return Redirect::route('brands')->with('error', Lang::get('brands/message.brand_not_found', compact('id')));

        $brand->delete();
        return Redirect::route('brands')->with('success', Lang::get('brands/message.success.delete'));
    }
}
