<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Content;

//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;

class ContentsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $parent_id = Input::has('id') ? Input::get('id') : 0;

        if(Input::has('up') && Input::get('up') > 0)
        {
            $id = Input::get('up');
            $con = Content::find($id);

            if($con->sequence > 1)
            {
                $conother = Content::where('parent_id',$con->parent_id)->whereSequence($con->sequence-1)->first();

                $con->sequence = $con->sequence - 1;
                $con->save();
                $conother->sequence = $conother->sequence + 1;
                $conother->save();

            }
        }
        elseif(Input::has('down') && Input::get('down') > 0)
        {
            $id = Input::get('down');
            $con = Content::find($id);

            $max = Content::where('parent_id',$con->parent_id)->max('sequence');

            if($con->sequence < $max)
            {
                $conother = Content::where('parent_id',$con->parent_id)->whereSequence($con->sequence+1)->first();

                $con->sequence = $con->sequence + 1;
                $con->save();
                $conother->sequence = $conother->sequence - 1;
                $conother->save();

            }
        }

        if($parent_id > 0)
        {
            $parent = Content::whereId($parent_id)->first();
            $contents = Content::where('parent_id', $parent_id)->orderBy('sequence','asc')->get();
            return View('admin/contents/index', compact('contents', 'parent'));
        }
        else {
            //$contents = Content::all();
            //$contents = Content::where('parent_id', 0)->autoFilter()->autoOrder('id', 'desc')->paginate(2);
            $contents = Content::where('parent_id', 0)->orderBy('sequence','asc')->get();
            return View('admin/contents/index', compact('contents'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents_add'))
            return Redirect::to('/admin/contents')->with('error', Lang::get('general.nopermission'));

        $contents = Content::whereStatus(1)->where('parent_id',0)->orderBy('sequence','asc')->get();
        return View('admin/contents/create', compact('contents'));
    }

    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents_add'))
            return Redirect::to('/admin/contents')->with('error', Lang::get('general.nopermission'));

        $rules = array(
            'title_en'     => 'required|unique:contents'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $input = Input::except('_token');
        $input['sefurl'] = Input::get('title_en');
        $input['sequence'] = Content::where('parent_id',Input::get('parent_id'))->max('sequence') + 1;

        $content = Content::create($input);

        if ($content) return Redirect::route('contents')->with('success', Lang::get('contents/message.success.create'));
        return Redirect::route('contents')->with('success', Lang::get('contents/message.delete.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents_edit'))
            return Redirect::to('/admin/contents')->with('error', Lang::get('general.nopermission'));

        $contents = Content::whereStatus(1)->where('parent_id',0)->where('id','!=',$id)->get();
        $content = Content::find($id);
        if($content == null) return Redirect::route('contents')->with('error', Lang::get('contents/message.content_not_found', compact('id')));
        return View('admin/contents/edit', compact('content','contents'));
    }

    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents_edit'))
            return Redirect::to('/admin/contents')->with('error', Lang::get('general.nopermission'));

        $content = Content::find($id);
        if($content == null) return Redirect::route('contents')->with('error', Lang::get('contents/message.content_not_found', compact('id')));

        $rules = array(
            'title_en'     => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $content->parent_id = Input::get('parent_id');
        $content->title_tr = Input::get('title_tr');
        $content->title_en = Input::get('title_en');
        $content->content_tr = Input::get('content_tr');
        $content->content_en = Input::get('content_en');
        $content->status = Input::get('status');
        $content->sefurl = Input::get('title_en');

        if ($content->save()) {
            // Redirect to the setting content
            return Redirect::route('contents')->with('success', Lang::get('contents/message.success.update'));
        } else {
            // Redirect to the group content
            return Redirect::route('contents', $id)->with('error', Lang::get('contents/message.error.update'));
        }

    }

    public function getModalDelete($id = null)
    {
        $model = 'contents';
        $confirm_route = $error = null;

        $content = Content::find($id);
        if($content == null)
        {
            $error = Lang::get('admin/contents/message.content_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/content',['id'=>$content->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('contents_add'))
            return Redirect::to('/admin/contents')->with('error', Lang::get('general.nopermission'));

        $content = Content::find($id);
        if($content == null) return Redirect::route('contents')->with('error', Lang::get('contents/message.content_not_found', compact('id')));

        $content->delete();
        return Redirect::route('contents')->with('success', Lang::get('contents/message.success.delete'));
    }
}
