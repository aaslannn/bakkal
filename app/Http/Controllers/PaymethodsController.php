<?php namespace App\Http\Controllers;
use App\Paymethod;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class PaymethodsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $paymethods = Paymethod::all();
        return View('admin/paymethods/index', compact('paymethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods_add'))
            return Redirect::to('/admin/paymethods')->with('error', Lang::get('general.nopermission'));

        $sequence = Paymethod::max('sequence') + 1;
        return View('admin/paymethods/create', compact('sequence'));
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods_add'))
            return Redirect::to('/admin/paymethods')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'title_en'     => 'required|unique:paymethods',
            'uniqueName' => 'required',
            'sequence'  => 'required|numeric',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $paymethod = Paymethod::create($inputs);
        if($paymethod) return Redirect::route('paymethods')->with('success', Lang::get('paymethods/message.success.create'));
        return Redirect::route('paymethods')->with('success', Lang::get('paymethods/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods_edit'))
            return Redirect::to('/admin/paymethods')->with('error', Lang::get('general.nopermission'));

        $paymethod = Paymethod::find($id);
        if($paymethod == null) return Redirect::route('paymethods')->with('error', Lang::get('paymethods/message.paymethod_not_found', compact('id')));
        return View('admin/paymethods/edit', compact('paymethod'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods_edit'))
            return Redirect::to('/admin/paymethods')->with('error', Lang::get('general.nopermission'));

        $paymethod = Paymethod::find($id);
        if($paymethod == null) return Redirect::route('paymethods')->with('error', Lang::get('paymethods/message.paymethod_not_found', compact('id')));

        $rules = array(
            'title_en'     => 'required',
            'sequence'  => 'required|numeric',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $paymethod->title_tr = Input::get('title_tr');
        $paymethod->title_en = Input::get('title_en');
        $paymethod->sequence = Input::get('sequence');
        $paymethod->status = Input::get('status');
        if ($paymethod->save()) return Redirect::route('paymethods')->with('success', Lang::get('paymethods/message.success.update'));
        else return Redirect::route('paymethods', $id)->with('error', Lang::get('paymethods/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'paymethods';
        $confirm_route = $error = null;

        $paymethod = Paymethod::find($id);
        if($paymethod == null)
        {
            $error = Lang::get('admin/paymethods/message.paymethod_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/paymethod',['id'=>$paymethod->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('paymethods_add'))
            return Redirect::to('/admin/paymethods')->with('error', Lang::get('general.nopermission'));

        $paymethod = Paymethod::find($id);
        if($paymethod == null) return Redirect::route('paymethods')->with('error', Lang::get('paymethods/message.paymethod_not_found', compact('id')));

        $paymethod->delete();
        return Redirect::route('paymethods')->with('success', Lang::get('paymethods/message.success.delete'));
    }
}
