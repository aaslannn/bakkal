<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use DB;
use App\Setting;
use App\Sitetheme;
use App\Http\Requests\SettingRequest;
use Intervention\Image\Facades\Image;


class SettingsController extends MainController
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
        $setting = Setting::find(1);
        if($setting == null) return Redirect::to('/admin/');

        if(Input::has('delCat'))
        {
            $delCat = Input::get('delCat');
            if($delCat == 1)
            {
                if(File::exists(public_path().'/uploads/'.$setting->catalog))
                    File::delete(public_path().'/uploads/'.$setting->catalog);

                $setting->catalog = '';
                $setting->save();
            }
        }

        $themes = Sitetheme::whereDurum(1)->get();

        return View('admin/settings/edit', compact('setting', 'themes'));
    }

    public function postIndex(SettingRequest $request)
    {

        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('settings_edit'))
            return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));

        $id = 1;
        $setting = Setting::find($id);
        if($setting == null) return Redirect::to('/admin/');

        /****if currency changed, update products currency***/
        $oldCurrency = $setting->para_birim;
        $newCurrency = $request->get('para_birim');
        if($oldCurrency !== $newCurrency)
        {
            \DB::table('products')->where('currency',$oldCurrency)->update(['currency' => $newCurrency]);
        }
        /****if currency changed, update products currency***/

        $setting->update($request->except('logo','favicon', 'catalog'));

        if ($request->hasFile('logo'))
        {
            $file            = $request->file('logo');
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/';
            $destinationPath = public_path() . $folderName;
            //$safeName        = str_random(10).'.'.$extension;
            $safeName        = 'logo.'.$extension;

            //delete old pic if exists
            if(File::exists(public_path() . $folderName.$setting->logo))
            {
                File::delete(public_path() . $folderName.$setting->logo);
            }
            $file->move($destinationPath, $safeName);

            $finalImage = Image::make($destinationPath.$safeName);
            $finalImage->resize(230, 70, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $finalImage->save($destinationPath.$safeName);

            //save new file path into db
            $setting->logo  = $safeName;
        }

        if ($request->hasFile('favicon'))
        {
            $file = $request->file('favicon');
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/';
            $destinationPath = public_path() . $folderName;
            $safeName        = 'favicon.'.$extension;

            //delete old pic if exists
            if(File::exists(public_path() . $folderName.$setting->favicon))
                File::delete(public_path() . $folderName.$setting->favicon);

            $file->move($destinationPath, $safeName);

            //resize
            $finalImage = Image::make($destinationPath.$safeName);
            $finalImage->resize(50, 50, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $finalImage->save($destinationPath.$safeName);

            //save new file path into db
            $setting->favicon  = $safeName;
        }

        if ($request->hasFile('catalog'))
        {
            $file = $request->file('catalog');
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'pdf';
            $folderName      = '/uploads/';
            $destinationPath = public_path() . $folderName;
            $safeName        = 'catalog.'.$extension;

            if(File::exists(public_path() . $folderName.$setting->catalog))
                File::delete(public_path() . $folderName.$setting->catalog);

            $file->move($destinationPath, $safeName);
            $setting->catalog  = $safeName;
        }

        if ($setting->save()) {
            // Redirect to the setting page
            return Redirect::route('settings')->with('success', Lang::get('settings/message.success.update'));
        } else {
            // Redirect to the group page
            return Redirect::route('settings', $id)->with('error', Lang::get('settings/message.error.update'));
        }

    }

}
