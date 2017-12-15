<?php namespace App\Http\Controllers;
use App\Brand;
use App\Setting;
use App\Product;
use App\Categorie;
use App\Picture;
use App\ProductOption;
use Illuminate\Support\Str;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use File;
use DB;
use Datatables;
use LaravelLocalization;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProductRequest;

class ProductsController extends MainController
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

    public function getIndex(\Illuminate\Http\Request $request)
    {
        if($request->has("catId") && $request->get("catId") > 0)
            $catId = (int)$request->get("catId");
        else
            $catId = 0;
        return View('admin/products/index', compact('catId'));

    }

    public function data(\Illuminate\Http\Request $request)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $q = Product::select([
            'products.id',
            'products.sequence',
            DB::raw('products.title_' . $locale . ' AS title'),
            DB::raw('categories.title_' . $locale . ' AS category'),
            'products.price',
            'products.stock',
            'products.discount',
            'products.discount_price',
            'products.currency'
        ])->leftJoin('categories', 'categories.id', '=', 'products.cat_id');

        return Datatables::of($q)
            ->filter(function($instance) use ($request){
                if($request->has("catId") && $request->get("catId") > 0)
                {
                    $catId = (int)$request->get("catId");
                    return $instance->where(function($q) use ($catId) {
                            $q->where('products.cat_id', $catId);
                    });
                }
            })
            ->edit_column('title','<a href="{{ route(\'update/product\', $id) }}"><img alt="{{{ $title }}}" src="{{ \App\Library\Common::getPrdImage($id) }}" style="width:60px; margin-right: 3px;">{{ $title }}</a>')
            ->edit_column('price','@if($discount === 1 && $discount_price > 0)<span style="text-decoration:line-through; color: #999;">{{{ $currency.number_format($price,2) }}}</span> {{{ $currency.number_format($discount_price,2) }}}
                                    @else
                                         {{{ $currency.number_format($price,2) }}}
                                    @endif')
            ->add_column('properties', '<a href="{{ route(\'prodproperties\', $id) }}">{{ trans(\'products/table.properties\') }} ({{ App\ProductProp::countPropbyPduductId($id) }})</a>')
            ->add_column('actions', '
                    <a href="{{ route(\'updatePictures/product\', $id) }}"><i class="livicon" data-name="camera" data-size="20" data-loop="true" data-c="#37bc9b" data-hc="#37bc9b" title="Ürün Görselleri"></i></a>&nbsp; 
                    <a href="{{ route(\'update/product\', $id) }}"><i class="livicon" data-name="edit" data-size="20" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Düzenle"></i></a>&nbsp; 
                    <a href="{{ route(\'confirm-delete/product\', $id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="remove-alt" data-size="20" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Sil"></i></a>&nbsp;            
                    <a href="{{ route(\'copy/product\', $id) }}" title="İçerik Kopyala"><i class="livicon" data-name="magic" data-size="20" data-loop="true" data-c="#FF9900" data-hc="#FF9900" title="İçerik Kopyala"></i></a>
                    ')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_add'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $sequence = Product::max('sequence') + 1;
        $categories = Categorie::whereStatus(1)->where('parent_id',0)->get();
        $brands = Brand::whereStatus(1)->orderBy('name')->get();

        $siteSetting = \App\Library\Common::getsiteConfigs();

        if($id > 0)
        {
            $copy = Product::find($id);
            if($copy)
                return View('admin/products/copy', compact('categories','brands','sequence','siteSetting','copy'));
            return View('admin/products/create', compact('categories','brands','sequence','siteSetting'));
        }
        return View('admin/products/create', compact('categories','brands','sequence','siteSetting'));
    }

    public function postCreate(ProductRequest $request, $id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_add'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $inputs = $request->except('_token','file','images');

        $url = Str::slug(Input::get('title_en'));
        $kayit = Product::whereSefurl($url)->count();
        $inputs['sefurl'] = ($kayit) ? $url .'-'. str_random(3) : $url;

        $inputs['sequence'] = Product::max('sequence') + 1;

        if(Input::get('discount') == 1 && Input::get('discount_price') > 0)
            $inputs['real_price'] = Input::get('discount_price');
        else
            $inputs['real_price'] = Input::get('price');

        $product = Product::create($inputs);
        if($product) 
        {
            $folderName  = '/uploads/products/'.$product->id.'/';
            $destinationPath = public_path() . $folderName;

            //upload catalog
            if ($file = Input::file('file'))
            {
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'pdf';
                $safeName        = str_random(10).'.'.$extension;
                $file->move($destinationPath, $safeName);
                
                $product->catalog = $safeName;
                $product->save();
            }

            //upload images
            if (Input::hasfile('images'))
            {
                $files = Input::file('images');
                $fileCount = count($files);
                if($fileCount > 5)
                    return redirect('admin/products/'.$product->id.'/pictures')->with('error', 'En fazla 5 Görsel Ekleyebilirsiniz!');

                $uploadCount = 0;
                $folderName      = '/uploads/products/'.$product->id.'/';
                $destinationPath = public_path() . $folderName;

                foreach($files as $file)
                {
                    $rules = array('file'=>'image|max:5000');
                    $validator = Validator::make(array('file'=>$file), $rules);

                    if ($validator->passes()) {
                        $fileName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension() ?: 'jpg';
                        $picture = str_random(10) . '.' . $extension;
                        $file->move($destinationPath, $picture);

                        //thumb1
                        $thumbImage = Image::make($destinationPath . $picture);
                        $thumbImage->resize(660, 495, function ($constraint) {
                            $constraint->aspectRatio();

                        });
                        $thumbImage->resizeCanvas(660, 495, 'center', false, 'FFFFFF');
                        $thumbImage->save($destinationPath . 'o-' . $picture);

                        //thumb2
                        $thumbImage = Image::make($destinationPath . $picture);
                        $thumbImage->resize(280, 210, function ($constraint) {
                            $constraint->aspectRatio();

                        });
                        $thumbImage->resizeCanvas(280, 210, 'center', false, 'FFFFFF');
                        $thumbImage->save($destinationPath . 'k-' . $picture);

                        $pic = Picture::create(array(
                            'pr_id' => $product->id,
                            'isim' => $picture
                        ));
                        if ($pic) {
                            $uploadCount++;
                            if ($product->image == '') {
                                $product->image = $picture;
                                $product->save();
                            }
                        }
                    }
                }

                if($uploadCount == $fileCount)
                    return Redirect::route('updatePictures/product', $product->id)->with('success', Lang::get('products/message.success.create'));
                else
                    return Redirect::route('updatePictures/product', $product->id)->withInput()->withErrors($validator);
            }
            return Redirect::route('updatePictures/product', $product->id)->with('success', Lang::get('products/message.success.create'));
        }
        return Redirect::route('create/product')->with('error', Lang::get('products/message.error.create'));
    }

    public function getEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $categories = Categorie::whereStatus(1)->where('parent_id',0)->get();
        $brands = Brand::whereStatus(1)->orderBy('name')->get();
        return View('admin/products/edit', compact('product', 'categories','brands'));
    }

    public function postEdit($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $rules = array(
            'title_en'     => 'required',
            'code'      => 'unique:products,code,'.$id.'',
            'cat_id'    => 'required|numeric|min:1',
            'price'     => 'required',
            'kdv'       => 'required|numeric|max:100',
            'file'      => 'mimes:pdf,doc,docx'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $product->cat_id = Input::get('cat_id');
        $product->title_tr = Input::get('title_tr');
        $product->title_en = Input::get('title_en');
        $product->code = Input::get('code');
        $product->brand_id = Input::get('brand_id');
        $product->content_tr = Input::get('content_tr');
        $product->content_en = Input::get('content_en');
        $product->price = Input::get('price');
        $product->discount_price = Input::get('discount_price');
        $product->discount = Input::get('discount');

        if(Input::get('discount') == 1 && Input::get('discount_price') > 0)
            $product->real_price = Input::get('discount_price');
        else
            $product->real_price = Input::get('price');

        $product->currency = Input::get('currency');
        $product->kdv = Input::get('kdv');
        $product->stock = Input::get('stock');
        $product->width = Input::get('width');
        $product->height = Input::get('height');
        $product->depth = Input::get('depth');
        $product->weight = Input::get('weight');
        $product->width_birim = Input::get('width_birim');
        $product->height_birim = Input::get('height_birim');
        $product->depth_birim = Input::get('depth_birim');
        $product->weight_birim = Input::get('weight_birim');
        $product->status = Input::get('status');
        $product->home = Input::get('home');
        $product->new = Input::get('new');
        $product->chosen = Input::get('chosen');
        $product->kargo_ucret = Input::get('kargo_ucret');
        $product->kargo_sure = Input::get('kargo_sure');
        $product->havale_ind_yuzde = Input::get('havale_ind_yuzde');
        $product->hizli_gonderi = Input::get('hizli_gonderi');
        $product->sinirli_stok = Input::get('sinirli_stok');
        $product->sequence = Input::get('sequence');
        
        if ($file = Input::file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'pdf';
            $folderName      = '/uploads/products/'.$id.'/';
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
            
            $product->catalog = $safeName;
        }

        if ($product->save()) {
            // Redirect to the setting page
            return Redirect::route('products')->with('success', Lang::get('products/message.success.update'));
        } else {
            // Redirect to the group page
            return Redirect::route('products', $id)->with('error', Lang::get('products/message.error.update'));
        }
    }

    public function getCopy($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $categories = Categorie::whereStatus(1)->where('parent_id',0)->get();
        $brands = Brand::whereStatus(1)->orderBy('name')->get();
        return View('admin/products/edit', compact('product', 'categories','brands'));
    }

    public function getModalDelete($id = null)
    {
        $model = 'products';
        $confirm_route = $error = null;

        $product = Product::find($id);
        if($product == null)
        {
            $error = Lang::get('admin/products/message.product_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route =  route('delete/product',['id'=>$product->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_add'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        \DB::table('products_options')->where('pr_id',$product->id)->delete(); //del options
        \DB::table('products_props')->where('pr_id',$product->id)->delete(); //del properties
        \DB::table('products_images')->where('pr_id',$product->id)->delete(); //del properties

        $sequence = $product->sequence;
        $product->delete();
        DB::table('products')->where('sequence','>',$sequence)->decrement('sequence'); //decrease others' sequences
        return Redirect::route('products')->with('success', Lang::get('products/message.success.delete'));
    }

    public function getPictures($id)
    {
        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $pId = Input::get('pId');
        $pic = Picture::find($pId);

        if($pId && $pic)
        {
            if(Input::get('del'))
            {
                $folderName = public_path().'/uploads/products/'.$id.'/';
                if(File::exists($folderName.$pic->isim)) File::delete($folderName.$pic->isim);
                if(File::exists($folderName.'o-'.$pic->isim)) File::delete($folderName.'o-'.$pic->isim);
                if(File::exists($folderName.'k-'.$pic->isim)) File::delete($folderName.'k-'.$pic->isim);

                if($product->image === $pic->isim)
                {
                    $newPic = Picture::where('pr_id',$pic->pr_id)->whereNotIn('id',[$pic->id])->first();
                    if($newPic)
                    {
                        $product->image = $newPic->isim;
                        $product->save();
                        //$pic->product->save(['image' => $newPic->isim]);
                    }
                }

                $pic->delete();
                return Redirect::route('updatePictures/product', $id)->with('success', Lang::get('products/message.success.picDelete'));
            }
            if(Input::get('def'))
            {
                $product->image = $pic->isim;
                $product->save();
                return Redirect::route('updatePictures/product', $id)->with('success', Lang::get('products/message.success.picDefault'));
            }

        }

        $pictures = Picture::where('pr_id', $id)->orderBy('varsayilan','desc')->get();
        return View('admin/products/pictures', compact('product','pictures'));

    }

    public function postPictures($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $count = Picture::where('pr_id',$id)->count();
        if ($count >= 5) return Redirect::route('updatePictures/product', $id)->with('error', Lang::get('products/message.error.maxPicture'));

        if (Input::hasfile('images'))
        {
            $files = Input::file('images');
            $fileCount = count($files);
            if($fileCount > 5)
                return Redirect::back()->with('error', 'En fazla 5 Görsel Ekleyebilirsiniz!');

            $totalCount = $count + $fileCount;
            if ($totalCount > 5) return Redirect::route('updatePictures/product', $id)->with('error', 'Bu ürün için maksimum görsel sayısı : 5');

            $uploadCount = 0;
            $folderName      = '/uploads/products/'.$product->id.'/';
            $destinationPath = public_path() . $folderName;

            //upload images
            foreach($files as $file)
            {
                $rules = array('file'=>'image|max:5000');
                $validator = Validator::make(array('file'=>$file), $rules);
                /*if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }*/

                if ($validator->passes()) {
                    $fileName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension() ?: 'jpg';
                    $picture = str_random(10) . '.' . $extension;
                    $file->move($destinationPath, $picture);

                    //thumb1
                    $thumbImage = Image::make($destinationPath . $picture);
                    $thumbImage->resize(660, 495, function ($constraint) {
                        $constraint->aspectRatio();

                    });
                    $thumbImage->resizeCanvas(660, 495, 'center', false, 'FFFFFF');
                    $thumbImage->save($destinationPath . 'o-' . $picture);

                    //thumb2
                    $thumbImage = Image::make($destinationPath . $picture);
                    $thumbImage->resize(280, 210, function ($constraint) {
                        $constraint->aspectRatio();

                    });
                    $thumbImage->resizeCanvas(280, 210, 'center', false, 'FFFFFF');
                    $thumbImage->save($destinationPath . 'k-' . $picture);

                    $pic = Picture::create(array(
                        'pr_id' => $product->id,
                        'isim' => $picture
                    ));
                    if ($pic) {
                        $uploadCount++;
                        if ($product->image == '') {
                            $product->image = $picture;
                            $product->save();
                        }
                    }
                }
            }
            if($uploadCount == $fileCount)
                return Redirect::route('updatePictures/product', $product->id)->with('success', Lang::get('products/message.success.picCreate'));
            else
                return Redirect::route('updatePictures/product', $product->id)->withErrors($validator);
            //return Redirect::route('updatePictures/product', $id)->with('error', Lang::get('products/message.delete.picCreate'));
        }
        return Redirect::route('updatePictures/product', $id)->with('error', 'Lütfen görsel seçiniz!');
    }

    public function getOptions($id)
    {
        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        $setStatus = Input::get('setStatus');
        if($setStatus && intval($setStatus) > 0)
        {
            $opt = ProductOption::whereId($setStatus)->where('pr_id',$id)->first();
            if ($opt)
            {
                $stok = $opt->stok;
                if($opt->stok == 0) $opt->stok = 1;
                else $opt->stok = 0;
                $opt->save();
            }
        }

        $oId = Input::get('oId');
        $opt = ProductOption::find($oId);

        if($oId && $opt)
        {
            if(Input::get('del'))
            {
                $opt->delete();
                return Redirect::route('updateOptions/product', $id)->with('success', Lang::get('products/message.success.optDelete'));
            }
        }
        $options = ProductOption::where('pr_id', $id)->get();
        return View('admin/products/options', compact('product','options'));
    }

    public function postOptions($id)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('products_edit'))
            return Redirect::to('/admin/products')->with('error', Lang::get('general.nopermission'));

        $product = Product::find($id);
        if($product == null) return Redirect::route('products')->with('error', Lang::get('products/message.product_not_found', compact('id')));

        // Declare the rules for the form validation
        $rules = array(
            'title_en'     => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $opt = ProductOption::create(array(
            'pr_id'     => $id,
            'title_tr' => Input::get('title_tr'),
            'title_en' => Input::get('title_en'),
            'stok' => Input::get('stok')
        ));

        if($opt) return Redirect::route('updateOptions/product', $id)->with('success', Lang::get('products/message.success.optCreate'));
        return Redirect::route('updateOptions/product', $id)->with('error', Lang::get('products/message.delete.optCreate'));

    }

}
