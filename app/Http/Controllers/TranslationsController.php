<?php namespace App\Http\Controllers;
use App\Language;
use App\Translation;
use Illuminate\Support\Facades\Request;
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

class TranslationsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $translations = Translation::all();
        return View('admin/translations/index', compact('translations'));
    }

    public function data()
    {
        $langs = Language::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations_add'))
            return Redirect::to('/admin/translations')->with('error', Lang::get('general.nopermission'));

        return View('admin/translations/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations_add'))
            return Redirect::to('/admin/translations')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'slug'     => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $trans = Translation::create($inputs);
        if($trans) return Redirect::route('translations')->with('success', Lang::get('translations/message.success.create'));
        return Redirect::route('translations')->with('success', Lang::get('translations/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations_edit'))
            return Redirect::to('/admin/translations')->with('error', Lang::get('general.nopermission'));

        $trans = Translation::find($id);
        if($trans == null) return Redirect::route('translations')->with('error', Lang::get('translations/message.translation_not_found', compact('id')));
        return View('admin/translations/edit', compact('trans'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations_edit'))
            return Redirect::to('/admin/translations')->with('error', Lang::get('general.nopermission'));

        $trans = Translation::find($id);
        if ($trans == null) return Redirect::route('translations')->with('error', Lang::get('translations/message.translation_not_found', compact('id')));


        // Declare the rules for the form validation
        $rules = array(
            'slug'     => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }


        $langs = Language::whereDurum(1)->get();
        foreach ($langs as $lang)
        {
            $trans->{'lang_'.$lang->kisaltma} = Input::get('lang_'.$lang->kisaltma);
        }
        $trans->slug = Input::get('slug');

        if ($trans->save()) return Redirect::route('translations')->with('success', Lang::get('translations/message.success.update'));
        else return Redirect::route('translations', $id)->with('error', Lang::get('translations/message.error.update'));
    }

    public function ajaxUpdate()
    {
        if( Request::ajax())
        {
            $id = Request::input('id');

            $trans = Translation::find($id);
            if ($trans == null) return 'Çeviri bulunamadı, daha sonra tekrar deneyiniz.';

            $datas = Request::except('_token','id');
            foreach ($datas as $key => $val) {
                $trans->{$key} = $val;
            }
            if ($trans->save()) return Lang::get('translations/message.success.update');
            else return Lang::get('translations/message.error.update');
        }
    }

    public function getModalDelete($id = null)
    {
        $model = 'translations';
        $confirm_route = $error = null;

        $trans = Translation::find($id);
        if($trans == null)
        {
            $error = Lang::get('admin/translations/message.translation_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/translation',['id'=>$trans->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('translations_add'))
            return Redirect::to('/admin/translations')->with('error', Lang::get('general.nopermission'));

        $trans = Translation::find($id);
        if($trans == null) return Redirect::route('translations')->with('error', Lang::get('translations/message.translation_not_found', compact('id')));

        $trans->delete();
        return Redirect::route('translations')->with('success', Lang::get('translations/message.success.delete'));
    }
}
