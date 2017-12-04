<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Request;
use Redirect;
use Lang;
use URL;
use File;
use Intervention\Image\Facades\Image;
use App\Product;
use App\Picture;

class PicturesController extends Controller
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    public function index()
    {
        $pId = Input::get('pId');
        $pic = Picture::find($pId);

        if($pId && $pic)
        {
            if(Input::get('del') === 1)
            {
                $folderName = public_path().'/uploads/products/'.$id.'/';
                if(File::exists($folderName.$pic->isim)) File::delete($folderName.$pic->isim);
                if(File::exists($folderName.'t_'.$pic->isim)) File::delete($folderName.'t_'.$pic->isim);

                if($pic->varsayilan === 1)
                {
                    $newPic = Picture::where('pr_id',$pic->pr_id)->whereNotIn('isim',[$pic->isim])->first();
                    if($newPic)
                    {
                        $pic->product->update(['image' => $newPic->isim]);
                    }
                }

                $pic->delete();
                return Redirect::route('pictures')->with('success', Lang::get('products/message.success.picDelete', compact('pId')));
            }
            if(Input::get('def') === 1)
            {
                $pic->update(['varsayilan' => 1]);
                return Redirect::route('pictures',$pId)->with('success', Lang::get('products/message.success.picDefault'));
            }

        }
    }

    public function getCropPic($id)
    {
        $pic = Picture::find($id);
        return View('admin/products/picturecrop', compact('pic'));
    }

    public function postCropPic($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $pic = Picture::find($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $targ_w = 651;
            $targ_h = 488;
            $jpeg_quality = 99;

            $destinationPath = public_path().'/uploads/products/'.$pic->pr_id.'/';

            $src = $destinationPath.$pic->isim;
            $newsrc = $destinationPath.'o-'.$pic->isim;

            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            $resim = imagecopyresampled($dst_r,$img_r,0,0,intval($_POST['x']),intval($_POST['y']), $targ_w,$targ_h, intval($_POST['w']),intval($_POST['h']));

            //header('Content-type: image/jpeg');
            //$resim = imagejpeg($dst_r,null,$jpeg_quality);

            $resim = imagejpeg($dst_r,$newsrc,$jpeg_quality);
            imagedestroy($dst_r);

            //thumb2
            $thumbImage = Image::make($newsrc);
            $thumbImage->resize(280, null, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $thumbImage->save($destinationPath.'k-'.$pic->isim);

            //exit;
            return Redirect::route('updatePictures/product', $pic->pr_id)->with('success', Lang::get('message.pictureadded'));


        }
    }

}
