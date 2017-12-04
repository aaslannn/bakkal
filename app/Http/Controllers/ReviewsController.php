<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Review;

class ReviewsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('reviews'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {
        $reviews = Review::all();
        return View('admin/reviews/index', compact('reviews'));
    }

    public function getCreate()
    {
        return;
    }

    public function postCreate()
    {
        return;
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('reviews_edit'))
            return Redirect::to('/admin/reviews')->with('error', Lang::get('general.nopermission'));

        $review = Review::find($id);
        if($review == null) return Redirect::route('reviews')->with('error', Lang::get('reviews/message.review_not_found', compact('id')));
        return View('admin/reviews/edit', compact('review'));
    }

    public function postEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('reviews_edit'))
            return Redirect::to('/admin/reviews')->with('error', Lang::get('general.nopermission'));

        $review = Review::find($id);
        if($review == null) return Redirect::route('reviews')->with('error', Lang::get('reviews/message.review_not_found', compact('id')));

        $rules = array(
            'rating'     => 'required',
            'comment'     => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $review->rating = Input::get('rating');
        $review->comment = Input::get('comment');
        $review->approved = Input::get('approved');
        $review->spam = Input::get('spam');

        if ($review->save()) {
            return Redirect::route('reviews')->with('success', Lang::get('reviews/message.success.update'));
        } else {
            return Redirect::route('reviews', $id)->with('error', Lang::get('reviews/message.error.update'));
        }
    }

    public function getModalDelete($id = null)
    {
        $model = 'reviews';
        $confirm_route = $error = null;

        $review = Review::find($id);
        if($review == null)
        {
            $error = Lang::get('admin/reviews/message.review_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/review',['id'=>$review->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('reviews_edit'))
            return Redirect::to('/admin/reviews')->with('error', Lang::get('general.nopermission'));

        $review = Review::find($id);
        if($review == null) return Redirect::route('reviews')->with('error', Lang::get('reviews/message.review_not_found', compact('id')));

        $review->delete();
        return Redirect::route('reviews')->with('success', Lang::get('reviews/message.success.delete'));
    }

}
