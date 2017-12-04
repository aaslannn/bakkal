<?php namespace App\Http\Controllers;
use App\City;
use App\CustomerAddresse;
use Sentry;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Lang;
use URL;
use Mail;
use File;
use Illuminate\Support\Facades\Hash;
use App\Customer;
use App\Countrie;

class CustomersController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }


    protected $validationRules = array(
        'first_name'       => 'required|min:3',
        'last_name'        => 'required|min:3',
        'email'            => 'required|email|unique:customers',
        'password'         => 'required|between:3,32',
        'password_confirm' => 'required|same:password'
    );

    public function getIndex()
    {
        $customers = Customer::All();
        return View('admin.customers.index', compact('customers'));
    }

    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers_add'))
            return Redirect::to('/admin/customers')->with('error', Lang::get('general.nopermission'));

        $countries = Countrie::whereTeslimat(1)->orderBy('sira')->get();
        return View('admin/customers/create',compact('countries'));
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers_add'))
            return Redirect::to('/admin/customers')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'first_name'       => 'required|min:3',
            'last_name'        => 'required|min:3',
            'email'            => 'required|email|unique:customers',
            'password'         => 'required|between:3,32',
            'password_confirm' => 'required|same:password'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $inputs = Input::except('_token');
        //$inputs['password'] = Hash::make(Input::get('password'));
        $inputs['passnohash'] = Input::get('password');

        $uye = Customer::create($inputs);
        if($uye) return Redirect::route('customers')->with('success', Lang::get('customers/message.success.create'));
        return Redirect::route('create/customers')->with('error', Lang::get('customers/message.error.create'));

        // Redirect to the customer creation page
        //return Redirect::back()->withInput()->with('error', $error);
    }

    public function getEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers_edit'))
            return Redirect::to('/admin/customers')->with('error', Lang::get('general.nopermission'));

        $customer = Customer::find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));

        $countries = Countrie::whereTeslimat(1)->orderBy('sira')->get();
        //$cities = City::where('ulke_id',208)->orderBy('il', 'asc')->get(); //208:T�rkiye

        return View('admin/customers/edit', compact('customer', 'countries'));
    }


    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers_edit'))
            return Redirect::to('/admin/customers')->with('error', Lang::get('general.nopermission'));

        $customer = Customer::find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));

        $this->validationRules['email'] = "required|email|unique:customers,email,{$customer->email},email";

        // Do we want to update the customer password?
        if ( ! $password = Input::get('password')) {
            unset($this->validationRules['password']);
            unset($this->validationRules['password_confirm']);
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Update the customer
        $customer->first_name  = Input::get('first_name');
        $customer->last_name   = Input::get('last_name');
        $customer->email       = Input::get('email');
        $customer->dob   = Input::get('dob')?Input::get('dob'):null;
        $customer->bio   = Input::get('bio');
        $customer->gender   = Input::get('gender');
        $customer->country   = Input::get('country');
        $customer->state   = Input::get('state');
        $customer->city   = Input::get('city');
        $customer->town   = Input::get('town');
        $customer->address   = Input::get('address');
        $customer->tel   = Input::get('tel');
        $customer->activated   = Input::get('activated');

        // Do we want to update the customer password?
        if ($password) {
            //$customer->password = Hash::make($password);
            $customer->password = $password;
            $customer->passnohash = $password;
        }

        if ($customer->save()) {
            return Redirect::route('customers.update', $id)->with('success', Lang::get('customers/message.success.update'));
        }
        return Redirect::route('customers.update', $id)->withInput()->with('error', Lang::get('customers/message.error.update'));
    }

    /**
     * Show a list of all the deleted customers.
     *
     * @return View
     */
    public function getDeletedCustomers()
    {
        // Grab deleted customers
        $customers = Customer::onlyTrashed()->get();

        // Show the page
        return View('admin/deleted_customers', compact('customers'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'customers';
        $confirm_route = $error = null;

        $customer = Customer::find($id);
        if($customer == null)
        {
            $error = Lang::get('admin/customers/message.customer_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/customer',['id'=>$customer->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('customers_add'))
            return Redirect::to('/admin/customers')->with('error', Lang::get('general.nopermission'));

        $customer = Customer::find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));

        // Delete the customer
        //to allow soft deleted, we are performing query on customers model instead of sentry model
        $customer->delete();
        //Customer::destroy($id);

        return Redirect::route('customers')->with('success', Lang::get('customers/message.success.delete'));
    }

    public function getRestore($id = null)
    {
        $customer = Customer::withTrashed()->find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));

        $customer->restore();
        return Redirect::route('deleted_customers')->with('success', Lang::get('customers/message.success.restored'));
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));
        return View('admin.customers.show', compact('customer'));
    }

    public function getAdresses($id)
    {
        $customer = Customer::find($id);
        if($customer == null) return Redirect::route('customers')->with('error', Lang::get('customers/message.customer_not_found', compact('id')));

        $aId = Input::get('aId');
        $adres = CustomerAddresse::find($aId);

        if($aId && $adres)
        {
            if(Input::get('del'))
            {
                $adres->delete();
                return Redirect::route('adresses/customer', $id)->with('success', Lang::get('customers/message.success.optDelete'));
            }
        }

        $adresler = CustomerAddresse::where('customer_id', $id)->get();
        return View('admin/customers/addresses', compact('adresler'));

    }
}
