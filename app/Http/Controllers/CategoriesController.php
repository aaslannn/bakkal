<?php namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Categorie;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class CategoriesController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories'))
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
        $parent_id = Input::has('id') ? Input::get('id') : 0;

        if(Input::has('up') && Input::get('up') > 0)
        {
            $id = Input::get('up');
            $cat = Categorie::find($id);

            if($cat->sequence > 1)
            {
                $catother = Categorie::where('parent_id',$cat->parent_id)->whereSequence($cat->sequence-1)->first();

                $cat->sequence = $cat->sequence - 1;
                $cat->save();
                $catother->sequence = $catother->sequence + 1;
                $catother->save();

            }
        }
        elseif(Input::has('down') && Input::get('down') > 0)
        {
            $id = Input::get('down');
            $cat = Categorie::find($id);

            $max = Categorie::where('parent_id',$cat->parent_id)->max('sequence');

            if($cat->sequence < $max)
            {
                $catother = Categorie::where('parent_id',$cat->parent_id)->whereSequence($cat->sequence+1)->first();

                $cat->sequence = $cat->sequence + 1;
                $cat->save();
                $catother->sequence = $catother->sequence - 1;
                $catother->save();

            }
        }

        if($parent_id > 0)
        {
            $parent = Categorie::whereId($parent_id)->first();
            $categories = Categorie::where('parent_id', $parent_id)->orderBy('sequence','asc')->get();
            return View('admin/categories/index', compact('categories', 'parent'));
        }
        else {
            $categories = Categorie::where('parent_id', 0)->orderBy('sequence','asc')->get();
            return View('admin/categories/index', compact('categories','parent'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories_add'))
            return Redirect::to('/admin/categories')->with('error', Lang::get('general.nopermission'));

        $catId = Input::has('cat') ? Input::get('cat') : null;
        $categories = Categorie::whereStatus(1)->where('parent_id',0)->orderBy('sequence','asc')->get();
        return View('admin/categories/create', compact('categories','catId'));
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories_add'))
            return Redirect::to('/admin/categories')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'title_tr'     => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $safeName = '';
        if ($file = Input::file('image'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/categories/';
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);

            //save new file path into db
            //$setting->logo  = $safeName;
        }

        $sequence = Categorie::where('parent_id',Input::get('parent_id'))->max('sequence') + 1;

        $url = Str::slug(Input::get('title_tr'));
        $kayit = Categorie::whereSefurl($url)->count();
        $sefurl = ($kayit) ? $url .'-'. str_random(3) : $url;

        $cat = Categorie::create(array(
            'title_tr'     => Input::get('title_tr'),
            'title_en'     => Input::get('title_en'),
            'title_es'     => Input::get('title_es'),
            'parent_id' => Input::get('parent_id'),
            'content'   => Input::get('content'),
            'sefurl'    => $sefurl,
            'status'    => Input::get('status'),
            'sequence'  => $sequence,
            'image'     => $safeName
        ));

        if ($cat) return Redirect::route('categories')->with('success', Lang::get('categories/message.success.create'));
        return Redirect::route('categories')->with('success', Lang::get('categories/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories_edit'))
            return Redirect::to('/admin/categories')->with('error', Lang::get('general.nopermission'));

        $categories = Categorie::whereStatus(1)->where('parent_id',0)->where('id','!=',$id)->get();
        $categorie = Categorie::find($id);
        if($categorie == null) return Redirect::route('categories')->with('error', Lang::get('categories/message.categorie_not_found', compact('id')));
        return View('admin/categories/edit', compact('categorie','categories'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories_edit'))
            return Redirect::to('/admin/categories')->with('error', Lang::get('general.nopermission'));

        $categorie = Categorie::find($id);
        if($categorie == null) return Redirect::route('categories')->with('error', Lang::get('categories/message.categorie_not_found', compact('id')));

        $rules = array(
            'title_tr'     => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        /*
        $input = Input::all();
        $input['sefurl'] = Input::get('title');
        */

        $categorie->parent_id = Input::get('parent_id');
        $categorie->title_tr = Input::get('title_tr');
        $categorie->title_en = Input::get('title_en');
        $categorie->title_es = Input::get('title_es');
        $categorie->status = Input::get('status');
        //$categorie->sefurl = Input::get('title');

        if ($file = Input::file('image'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/categories/';
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);

            //delete old pic if exists
            if(File::exists(public_path() . $folderName.$categorie->image))
            {
                File::delete(public_path() . $folderName.$categorie->image);
            }
            //save new file path into db
            $categorie->image  = $safeName;
        }

        if ($categorie->save()) {
            // Redirect to the setting page
            return Redirect::route('categories')->with('success', Lang::get('categories/message.success.update'));
        } else {
            // Redirect to the group page
            return Redirect::route('categories', $id)->with('error', Lang::get('categories/message.error.update'));
        }

    }

    public function getModalDelete($id = null)
    {
        $model = 'categories';
        $confirm_route = $error = null;

        $categorie = Categorie::find($id);
        if($categorie == null)
        {
            $error = Lang::get('admin/categories/message.categorie_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/categorie',['id'=>$categorie->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('categories_add'))
            return Redirect::to('/admin/categories')->with('error', Lang::get('general.nopermission'));

        $categorie = Categorie::find($id);
        if($categorie == null) return Redirect::route('categories')->with('error', Lang::get('categories/message.categorie_not_found', compact('id')));

        $categorie->delete();
        return Redirect::route('categories')->with('success', Lang::get('categories/message.success.delete'));
    }
}
