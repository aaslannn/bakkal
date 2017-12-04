<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\DiscountCode;

class DiscountCodesController extends MainController
{
	public function __construct()
	{
		$this->beforeFilter(function(){
			if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes'))
			{
				return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
			}
		});
	}

	public function getIndex()
	{
		$discodes = DiscountCode::orderBy('used','asc')->orderBy('start_date','asc')->get();
		return View('admin/discodes/index', compact('discodes'));
	}

	public function getCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes_add'))
			return Redirect::to('/admin/discodes')->with('error', Lang::get('general.nopermission'));

		return View('admin/discodes/create');
	}

	public function postCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes_add'))
			return Redirect::to('/admin/discodes')->with('error', Lang::get('general.nopermission'));

		// Declare the rules for the form validation
		$rules = array(
			'code'     => 'required',
			'rate'  => 'required|numeric|max:100|min:1',
			'start_date'  => 'required|date',
			'end_date'  => 'required|date'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$inputs = Input::except('_token');
		$discode = DiscountCode::create($inputs);

		if ($discode) return Redirect::route('discodes')->with('success', Lang::get('discodes/message.success.create'));
		return Redirect::route('discodes')->with('success', Lang::get('discodes/message.delete.create'));
	}

	public function getEdit($id)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes_edit'))
			return Redirect::to('/admin/discodes')->with('error', Lang::get('general.nopermission'));

		$discode = DiscountCode::find($id);
		if($discode == null) return Redirect::route('discodes')->with('error', Lang::get('discodes/message.discode_not_found', compact('id')));
		return View('admin/discodes/edit', compact('discode'));
	}

	public function postEdit($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes_edit'))
			return Redirect::to('/admin/discodes')->with('error', Lang::get('general.nopermission'));

		$discode = DiscountCode::find($id);
		if($discode == null) return Redirect::route('discodes')->with('error', Lang::get('discodes/message.discode_not_found', compact('id')));

		$rules = array(
			'code'     => 'required',
			'rate'  => 'required|numeric|max:100|min:1',
			'start_date'  => 'required|date',
			'end_date'  => 'required|date'
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$discode->code = Input::get('code');
		$discode->rate = Input::get('rate');
		$discode->start_date = Input::get('start_date');
		$discode->end_date = Input::get('end_date');
		$discode->used = Input::get('used');

		if ($discode->save()) {
			// Redirect to the setting page
			return Redirect::route('discodes')->with('success', Lang::get('discodes/message.success.update'));
		} else {
			// Redirect to the group page
			return Redirect::route('discodes', $id)->with('error', Lang::get('discodes/message.error.update'));
		}

	}

	public function getModalDelete($id = null)
	{
		$model = 'discodes';
		$confirm_route = $error = null;

		$discode = DiscountCode::find($id);
		if($discode == null)
		{
			$error = Lang::get('admin/discodes/message.discode_not_found', compact('id'));
			return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
		}

		$confirm_route =  route('delete/discode',['id'=>$discode->id]);
		return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('discodes_add'))
			return Redirect::to('/admin/discodes')->with('error', Lang::get('general.nopermission'));

		$discode = DiscountCode::find($id);
		if($discode == null) return Redirect::route('discodes')->with('error', Lang::get('discodes/message.discode_not_found', compact('id')));

		$folderName  = '/uploads/discodes/';
		if(File::exists(public_path() . $folderName.$discode->image))
		{
			File::delete(public_path() . $folderName.$discode->image);
		}

		$discode->delete();
		return Redirect::route('discodes')->with('success', Lang::get('discodes/message.success.delete'));
	}
}
