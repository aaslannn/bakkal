<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use App\Sitetheme;

class SitethemesController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('settings'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function getIndex()
    {

    }

    public function postIndex()
    {

    }
}
