<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Slide;
use Intervention\Image\Facades\Image;

class SlidesController extends MainController
{
	public function __construct()
	{
		$this->beforeFilter(function(){
			if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides'))
			{
				return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
			}
		});
	}

	public function getIndex()
	{
		$slides = Slide::all();
		return View('admin/slides/index', compact('slides'));
	}

	public function getCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides_add'))
			return Redirect::to('/admin/slides')->with('error', Lang::get('general.nopermission'));

		$sequence = Slide::max('sequence') + 1;
		return View('admin/slides/create', compact('sequence'));
	}

	public function postCreate()
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides_add'))
			return Redirect::to('/admin/slides')->with('error', Lang::get('general.nopermission'));

		// Declare the rules for the form validation
		$rules = array(
			'sequence'  => 'required|numeric',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$safeName = '';
		if ($file = Input::file('image'))
		{
			$fileName        = $file->getClientOriginalName();
			$extension       = $file->getClientOriginalExtension() ?: 'png';
			$folderName      = '/uploads/slides/';
			$destinationPath = public_path() . $folderName;
			$safeName        = str_random(10).'.'.$extension;
			$file->move($destinationPath, $safeName);

			//resize
			$finalImage = Image::make($destinationPath.$safeName);
			$finalImage->resize(868, 383, function($constraint)
			{
				$constraint->aspectRatio();
			});
			$finalImage->save($destinationPath.$safeName);
		}

		if(Input::get('sequence') < 1) $sequence = Slide::max('sequence') + 1;
		else $sequence = Input::get('sequence');

		$slide = Slide::create(array(
			'title'     => Input::get('title'),
			'title_tr'     => Input::get('title_tr'),
			'title_en'     => Input::get('title_en'),
			'title_es'     => Input::get('title_es'),
			'link' => Input::get('link'),
			'status'    => Input::get('status'),
			'sequence'  => $sequence,
			'image'     => $safeName
		));

		if ($slide) return Redirect::route('slides')->with('success', Lang::get('slides/message.success.create'));
		return Redirect::route('slides')->with('success', Lang::get('slides/message.delete.create'));
	}

	public function getEdit($id)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides_edit'))
			return Redirect::to('/admin/slides')->with('error', Lang::get('general.nopermission'));

		$slide = Slide::find($id);
		if($slide == null) return Redirect::route('slides')->with('error', Lang::get('slides/message.slide_not_found', compact('id')));
		return View('admin/slides/edit', compact('slide'));
	}

	public function postEdit($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides_edit'))
			return Redirect::to('/admin/slides')->with('error', Lang::get('general.nopermission'));

		$slide = Slide::find($id);
		if($slide == null) return Redirect::route('slides')->with('error', Lang::get('slides/message.slide_not_found', compact('id')));

		$rules = array(
			'sequence'  => 'required|numeric',
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$slide->title_tr = Input::get('title_tr');
		$slide->title_en = Input::get('title_en');
		$slide->title_es = Input::get('title_es');
		$slide->link = Input::get('link');
		$slide->status = Input::get('status');
		$slide->sequence = Input::get('sequence');

		if ($file = Input::file('image'))
		{
			$fileName        = $file->getClientOriginalName();
			$extension       = $file->getClientOriginalExtension() ?: 'png';
			$folderName      = '/uploads/slides/';
			$destinationPath = public_path() . $folderName;
			$safeName        = str_random(10).'.'.$extension;
			$file->move($destinationPath, $safeName);

			//delete old pic if exists
			if(File::exists(public_path() . $folderName.$slide->image))
			{
				File::delete(public_path() . $folderName.$slide->image);
			}
			//save new file path into db
			$slide->image  = $safeName;

			//resize
			$finalImage = Image::make($destinationPath.$safeName);
			$finalImage->resize(868, 383, function($constraint)
			{
				$constraint->aspectRatio();
			});
			$finalImage->save($destinationPath.$safeName);
		}

		if ($slide->save()) {
			// Redirect to the setting page
			return Redirect::route('slides')->with('success', Lang::get('slides/message.success.update'));
		} else {
			// Redirect to the group page
			return Redirect::route('slides', $id)->with('error', Lang::get('slides/message.error.update'));
		}

	}

	public function getModalDelete($id = null)
	{
		$model = 'slides';
		$confirm_route = $error = null;

		$slide = Slide::find($id);
		if($slide == null)
		{
			$error = Lang::get('admin/slides/message.slide_not_found', compact('id'));
			return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
		}

		$confirm_route =  route('delete/slide',['id'=>$slide->id]);
		return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('slides_add'))
			return Redirect::to('/admin/slides')->with('error', Lang::get('general.nopermission'));

		$slide = Slide::find($id);
		if($slide == null) return Redirect::route('slides')->with('error', Lang::get('slides/message.slide_not_found', compact('id')));

		$folderName  = '/uploads/slides/';
		if(File::exists(public_path() . $folderName.$slide->image))
		{
			File::delete(public_path() . $folderName.$slide->image);
		}

		$slide->delete();
		return Redirect::route('slides')->with('success', Lang::get('slides/message.success.delete'));
	}
}
