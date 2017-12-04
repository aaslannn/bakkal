<?php namespace App\Http\Controllers;
use App\PosAccount;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use Intervention\Image\Facades\Image;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class PosAccountsController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        if(Input::has('mainpos'))
        {
            $mainId = Input::get('mainpos');
            $exMain = PosAccount::whereMainpos(1)->where('id','!=',$mainId)->first();
            if($exMain)
            {
                $exMain->mainpos = 0;
                $exMain->save();
            } 
            
            $newMain = PosAccount::find($mainId);
            if($exMain)
            {
                $newMain->mainpos = 1;
                $newMain->save();
            }          
                       
        }
        $posaccounts = PosAccount::all();
        return View('admin/posaccounts/index', compact('posaccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts_add'))
            return Redirect::to('/admin/posaccounts')->with('error', Lang::get('general.nopermission'));

        return View('admin/posaccounts/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts_add'))
            return Redirect::to('/admin/posaccounts')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'bankname'     => 'required',
            'bankhandle'   => 'required',
            'cardname'     => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $taksitler = json_encode(Input::get('taksitler'));


        $posaccount = PosAccount::create(array(
            'bankname'     => Input::get('bankname'),
            'bankhandle' => Input::get('bankhandle'),
            'cardname' => Input::get('cardname'),
            'status'    => Input::get('status'),
            'taksit'    => Input::get('taksit'),
            'taksitler'    => $taksitler
        ));

        if($posaccount)
        {
            if ($file = Input::file('icon'))
            {
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $folderName      = '/uploads/banks/';
                $destinationPath = public_path() . $folderName;
                $safeName        = $posaccount->bankhandle.'.'.$extension;
                $file->move($destinationPath, $safeName);

                //resize
                $finalImage = Image::make($destinationPath.$safeName);
                $finalImage->resize(200, 40, function($constraint)
                {
                    $constraint->aspectRatio();
                });
                $finalImage->save($destinationPath.$safeName);

                $posaccount->icon  = $safeName;
                $posaccount->save();
            }

            return Redirect::route('posaccounts')->with('success', Lang::get('posaccounts/message.success.create'));
        }
        return Redirect::route('posaccounts')->with('success', Lang::get('posaccounts/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts_edit'))
            return Redirect::to('/admin/posaccounts')->with('error', Lang::get('general.nopermission'));

        $posaccount = PosAccount::find($id);
        if($posaccount == null) return Redirect::route('posaccounts')->with('error', Lang::get('posaccounts/message.posaccount_not_found', compact('id')));
        
        return View('admin/posaccounts/edit', compact('posaccount'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts_edit'))
            return Redirect::to('/admin/posaccounts')->with('error', Lang::get('general.nopermission'));

        $posaccount = PosAccount::find($id);
        if($posaccount == null) return Redirect::route('posaccounts')->with('error', Lang::get('posaccounts/message.posaccount_not_found', compact('id')));

        $rules = array(
            'status'     => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $posaccount->isyerino = Input::get('isyerino');
        $posaccount->kullanici = Input::get('kullanici');
        $posaccount->sifre = Input::get('sifre');
        $posaccount->terminalno = Input::get('terminalno');
        $posaccount->taksit = Input::get('taksit');
        $posaccount->mintaksit = Input::get('mintaksit');        
        $posaccount->status = Input::get('status');
        $posaccount->taksitler = json_encode(Input::get('taksitler'));

        if ($posaccount->save()) return Redirect::route('posaccounts')->with('success', Lang::get('posaccounts/message.success.update'));
        else return Redirect::route('posaccounts', $id)->with('error', Lang::get('posaccounts/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'posaccounts';
        $confirm_route = $error = null;

        $posaccount = PosAccount::find($id);
        if($posaccount == null)
        {
            $error = Lang::get('admin/posaccounts/message.posaccount_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/posaccount',['id'=>$posaccount->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('posaccounts_add'))
            return Redirect::to('/admin/posaccounts')->with('error', Lang::get('general.nopermission'));

        $posaccount = PosAccount::find($id);
        if($posaccount == null) return Redirect::route('posaccounts')->with('error', Lang::get('posaccounts/message.posaccount_not_found', compact('id')));

        $posaccount->delete();
        return Redirect::route('posaccounts')->with('success', Lang::get('posaccounts/message.success.delete'));
    }
}
