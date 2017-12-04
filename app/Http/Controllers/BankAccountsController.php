<?php namespace App\Http\Controllers;
use App\BankAccount;
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

class BankAccountsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $bankaccounts = BankAccount::all();
        return View('admin/bankaccounts/index', compact('bankaccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts_add'))
            return Redirect::to('/admin/bankaccounts')->with('error', Lang::get('general.nopermission'));

        return View('admin/bankaccounts/create');
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts_add'))
            return Redirect::to('/admin/bankaccounts')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'bankaAdi'     => 'required',
            'hesapAdi'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        $bankaccount = BankAccount::create($inputs);
        if($bankaccount) return Redirect::route('bankaccounts')->with('success', Lang::get('bankaccounts/message.success.create'));
        return Redirect::route('bankaccounts')->with('success', Lang::get('bankaccounts/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts_edit'))
            return Redirect::to('/admin/bankaccounts')->with('error', Lang::get('general.nopermission'));

        $bankaccount = BankAccount::find($id);
        if($bankaccount == null) return Redirect::route('bankaccounts')->with('error', Lang::get('bankaccounts/message.bankaccount_not_found', compact('id')));
        return View('admin/bankaccounts/edit', compact('bankaccount'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts_edit'))
            return Redirect::to('/admin/bankaccounts')->with('error', Lang::get('general.nopermission'));

        $bankaccount = BankAccount::find($id);
        if($bankaccount == null) return Redirect::route('bankaccounts')->with('error', Lang::get('bankaccounts/message.bankaccount_not_found', compact('id')));

        $rules = array(
            'bankaAdi'     => 'required',
            'hesapAdi'  => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $bankaccount->bankaAdi = Input::get('bankaAdi');
        $bankaccount->subeAdi = Input::get('subeAdi');
        $bankaccount->subeKodu = Input::get('subeKodu');
        $bankaccount->hesapAdi = Input::get('hesapAdi');
        $bankaccount->hesapNo = Input::get('hesapNo');
        $bankaccount->hesapTuru = Input::get('hesapTuru');
        $bankaccount->iban = Input::get('iban');
        $bankaccount->status = Input::get('status');
        if ($bankaccount->save()) return Redirect::route('bankaccounts')->with('success', Lang::get('bankaccounts/message.success.update'));
        else return Redirect::route('bankaccounts', $id)->with('error', Lang::get('bankaccounts/message.error.update'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'bankaccounts';
        $confirm_route = $error = null;

        $bankaccount = BankAccount::find($id);
        if($bankaccount == null)
        {
            $error = Lang::get('admin/bankaccounts/message.bankaccount_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/bankaccount',['id'=>$bankaccount->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('bankaccounts_add'))
            return Redirect::to('/admin/bankaccounts')->with('error', Lang::get('general.nopermission'));

        $bankaccount = BankAccount::find($id);
        if($bankaccount == null) return Redirect::route('bankaccounts')->with('error', Lang::get('bankaccounts/message.bankaccount_not_found', compact('id')));

        $bankaccount->delete();
        return Redirect::route('bankaccounts')->with('success', Lang::get('bankaccounts/message.success.delete'));
    }
}
