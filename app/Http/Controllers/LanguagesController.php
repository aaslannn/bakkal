<?php namespace App\Http\Controllers;
use App\Language;
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

class LanguagesController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        if(Input::has('varsayilan'))
        {
            $mainId = Input::get('varsayilan');
            $exMain = Language::whereVarsayilan(1)->where('id','!=',$mainId)->first();
            if($exMain)
            {
                $exMain->varsayilan = 0;
                $exMain->save();
            }

            $newMain = Language::find($mainId);
            if($exMain)
            {
                $newMain->varsayilan = 1;
                $newMain->save();
            }
        }

        $languages = Language::all();
        return View('admin/languages/index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages_add'))
            return Redirect::to('/admin/languages')->with('error', Lang::get('general.nopermission'));

        return View('admin/languages/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages_add'))
            return Redirect::to('/admin/languages')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'dil'     => 'required|unique:languages',
            'kisaltma'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $language = Language::create($inputs);
        if($language) return Redirect::route('languages')->with('success', Lang::get('languages/message.success.create'));
        return Redirect::route('languages')->with('success', Lang::get('languages/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages_edit'))
            return Redirect::to('/admin/languages')->with('error', Lang::get('general.nopermission'));

        $language = Language::find($id);
        if($language == null) return Redirect::route('languages')->with('error', Lang::get('languages/message.language_not_found', compact('id')));
        return View('admin/languages/edit', compact('language'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages_edit'))
            return Redirect::to('/admin/languages')->with('error', Lang::get('general.nopermission'));

        $language = Language::find($id);
        if($language == null) return Redirect::route('languages')->with('error', Lang::get('languages/message.language_not_found', compact('id')));

        /*
        $rules = array(
            'dil'     => 'required',
            'kisaltma'  => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        */


        //$language->dil = Input::get('dil');
        //$language->kisaltma = Input::get('kisaltma');
        $language->durum = Input::get('durum');
        //$language->varsayilan = Input::get('varsayilan');

        if ($language->save()) return Redirect::route('languages')->with('success', Lang::get('languages/message.success.update'));
        else return Redirect::route('languages', $id)->with('error', Lang::get('languages/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'languages';
        $confirm_route = $error = null;

        $language = Language::find($id);
        if($language == null)
        {
            $error = Lang::get('admin/languages/message.language_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/language',['id'=>$language->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('languages_add'))
            return Redirect::to('/admin/languages')->with('error', Lang::get('general.nopermission'));

        $language = Language::find($id);
        if($language == null) return Redirect::route('languages')->with('error', Lang::get('languages/message.language_not_found', compact('id')));

        $language->delete();
        return Redirect::route('languages')->with('success', Lang::get('languages/message.success.delete'));
    }
}
