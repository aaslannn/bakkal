<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Cargo;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class CargosController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $cargos = Cargo::all();
        return View('admin/cargos/index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos_add'))
            return Redirect::to('/admin/cargos')->with('error', Lang::get('general.nopermission'));

        return View('admin/cargos/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos_add'))
            return Redirect::to('/admin/cargos')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'name'     => 'required',
            'price'  => 'required|numeric',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $cargo = Cargo::create($inputs);
        if($cargo) return Redirect::route('cargos')->with('success', Lang::get('cargos/message.success.create'));
        return Redirect::route('cargos')->with('success', Lang::get('cargos/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos_edit'))
            return Redirect::to('/admin/cargos')->with('error', Lang::get('general.nopermission'));

        $cargo = Cargo::find($id);
        if($cargo == null) return Redirect::route('cargos')->with('error', Lang::get('cargos/message.cargo_not_found', compact('id')));
        return View('admin/cargos/edit', compact('cargo'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos_edit'))
            return Redirect::to('/admin/cargos')->with('error', Lang::get('general.nopermission'));

        $cargo = Cargo::find($id);
        if($cargo == null) return Redirect::route('cargos')->with('error', Lang::get('cargos/message.cargo_not_found', compact('id')));

        $rules = array(
            'name'     => 'required',
            'price'  => 'required|numeric',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $cargo->name = Input::get('name');
        $cargo->price = Input::get('price');
        $cargo->status = Input::get('status');
        if ($cargo->save()) return Redirect::route('cargos')->with('success', Lang::get('cargos/message.success.update'));
        else return Redirect::route('cargos', $id)->with('error', Lang::get('cargos/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'cargos';
        $confirm_route = $error = null;

        $cargo = Cargo::find($id);
        if($cargo == null)
        {
            $error = Lang::get('admin/cargos/message.cargo_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/cargo',['id'=>$cargo->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('cargos_add'))
            return Redirect::to('/admin/cargos')->with('error', Lang::get('general.nopermission'));

        $cargo = Cargo::find($id);
        if($cargo == null) return Redirect::route('cargos')->with('error', Lang::get('cargos/message.cargo_not_found', compact('id')));

        $cargo->delete();
        return Redirect::route('cargos')->with('success', Lang::get('cargos/message.success.delete'));
    }
}
