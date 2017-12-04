<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Social;
use Intervention\Image\Facades\Image;

class SocialsController extends MainController
{
	public function __construct()
	{
		$this->beforeFilter(function(){
			if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials'))
			{
				return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
			}
		});
	}

	public function getIndex()
	{
		$socials = Social::all();
		return View('admin/socials/index', compact('socials'));
	}

	public function getCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials_add'))
			return Redirect::to('/admin/socials')->with('error', Lang::get('general.nopermission'));

		$sequence = Social::max('sequence') + 1;
		return View('admin/socials/create', compact('sequence'));
	}

	public function postCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials_add'))
			return Redirect::to('/admin/socials')->with('error', Lang::get('general.nopermission'));

		// Declare the rules for the form validation
		$rules = array(
			'title'     => 'required',
			'sequence'  => 'required|numeric',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		if(Input::get('sequence') < 1) $sequence = Social::max('sequence') + 1;
		else $sequence = Input::get('sequence');

		$social = Social::create(array(
			'title'     => Input::get('title'),
			'link' => Input::get('link'),
			'icon'     => Input::get('icon'),
			'status'    => Input::get('status'),
			'sequence'  => $sequence
		));

		if ($social) return Redirect::route('socials')->with('success', Lang::get('socials/message.success.create'));
		return Redirect::route('socials')->with('success', Lang::get('socials/message.delete.create'));
	}

	public function getEdit($id)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials_edit'))
			return Redirect::to('/admin/socials')->with('error', Lang::get('general.nopermission'));

		$social = Social::find($id);
		if($social == null) return Redirect::route('socials')->with('error', Lang::get('socials/message.social_not_found', compact('id')));
		return View('admin/socials/edit', compact('social'));
	}

	public function postEdit($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials_edit'))
			return Redirect::to('/admin/socials')->with('error', Lang::get('general.nopermission'));

		$social = Social::find($id);
		if($social == null) return Redirect::route('socials')->with('error', Lang::get('socials/message.social_not_found', compact('id')));

		$rules = array(
			'title'     => 'required',
			'icon'     => 'required',
			'sequence'  => 'required|numeric',
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$social->title = Input::get('title');
		$social->icon = Input::get('icon');
		$social->link = Input::get('link');
		$social->status = Input::get('status');
		$social->sequence = Input::get('sequence');

		if ($social->save()) {
			// Redirect to the setting page
			return Redirect::route('socials')->with('success', Lang::get('socials/message.success.update'));
		} else {
			// Redirect to the group page
			return Redirect::route('socials', $id)->with('error', Lang::get('socials/message.error.update'));
		}

	}

	public function getModalDelete($id = null)
	{
		$model = 'socials';
		$confirm_route = $error = null;

		$social = Social::find($id);
		if($social == null)
		{
			$error = Lang::get('admin/socials/message.social_not_found', compact('id'));
			return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
		}

		$confirm_route =  route('delete/social',['id'=>$social->id]);
		return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('socials_add'))
			return Redirect::to('/admin/socials')->with('error', Lang::get('general.nopermission'));

		$social = Social::find($id);
		if($social == null) return Redirect::route('socials')->with('error', Lang::get('socials/message.social_not_found', compact('id')));

		$folderName  = '/uploads/socials/';
		if(File::exists(public_path() . $folderName.$social->image))
		{
			File::delete(public_path() . $folderName.$social->image);
		}

		$social->delete();
		return Redirect::route('socials')->with('success', Lang::get('socials/message.success.delete'));
	}
}
