@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ $prd->title_en }}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
@stop

{{-- slider --}}
@section('top')
    <!--Carousel Start -->
    <!-- //Carousel End -->
@stop

{{-- content --}}
@section('content')
    <?php
    if(Auth::customer()->check())
    {
        $cust = Auth::customer()->get();
        $uId = $cust->id;
    }
    else
        $uId = 0;
    ?>
    <section class="MainContent">
        <div class="container positionrelative">
            <ol class="breadcrumb">
                <li><a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a></li>
                <?php echo \App\Library\Common::getCatBreadcrumb($prd->cat_id,1,LaravelLocalization::getCurrentLocale()); ?>
                <li>{{ $prd->{'title_'.$defLocale} }}</li>
            </ol>
            <div class="PrevNextProduct">
                <?php
                $previousPrd = \App\Library\Common::getPreviousPrdLink($prd->id);
                $nextPrd = \App\Library\Common::getNextPrdLink($prd->id);
                ?>
                @if($previousPrd != '')
                    <a class="Prev" href="{{ url('/').$previousPrd }}" data-toggle="tooltip" data-container="body" data-placement="bottom" title="{{ Lang::get('frontend/general.previous-product') }}"><i class="fa fa-chevron-left"></i></a>
                @else
                    <a class="Prev disabled" data-toggle="tooltip" data-container="body" data-placement="bottom" title="{{ Lang::get('frontend/general.previous-product') }}" disabled><i class="fa fa-chevron-left"></i></a>
                @endif
                @if($nextPrd != '')
                    <a class="Next" href="{{ url('/').$nextPrd }}" data-toggle="tooltip"  data-container="body" data-placement="bottom" title="{{ Lang::get('frontend/general.next-product') }}"><i class="fa fa-chevron-right"></i></a>
                @else
                    <a class="Next disabled" data-toggle="tooltip"  data-container="body" data-placement="bottom" title="{{ Lang::get('frontend/general.next-product') }}" disabled><i class="fa fa-chevron-right"></i></a>
                @endif
            </div>
        </div>
        <div class="ProductDetail">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="ProductImageGallery">
                            <div class="ImageWrapper">
                                @if($prd->image != '')
                                    <img src="{{ url('/').'/uploads/products/'.$prd->id.'/o-'.$prd->image }}">
                                @else
                                    <img src="{{ Theme::url('images/nopic.jpg') }}">
                                @endif
                                {!! ($prd->new == 1 ? '<span class="New">' . Lang::get('frontend/general.new') . '</span>' : '') !!}
                                {!! ($prd->stock == 0 ? '<span class="OutOfStock">' . Lang::get('frontend/general.notinstock') . '</span>' : '') !!}
                                <div class="Loader"><i class="fa fa-spinner fa-spin"></i></div>
                            </div>
                            @if($prd->products_images->count() > 1)
                            <div class="ImageThumbails">
                                @foreach($prd->products_images as $img)
                                    <a data-image-url="{{ url('/').'/uploads/products/'.$prd->id.'/o-'.$img->isim }}"><img src="{{ url('/').'/uploads/products/'.$prd->id.'/k-'.$img->isim }}"></a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="ProductFeatures">
                            <div class="DefaultBox">
                                <div class="DefaultBoxHeading">{{ $prd->{'title_'.$defLocale} }}</div>
                                <div class="DefaultBoxBody">
                                    <div class="Price">
                                        <div class="DiscountWrapper">
                                            @if($prd->discount != '' && $prd->discount_price > 0)
                                                <span class="DiscountRate">{{Lang::get('frontend/general.discountpercent', array('percent'=>\App\Library\Common::getYuzde($prd->price,$prd->discount_price)))}}</span>
                                                <span class="DiscountPrice">
                                                    <span class="line-through">{{ $prd->currency.number_format($prd->price,2) }}</span>
                                                    <span>{{ $prd->currency.number_format($prd->discount_price,2) }} {!! ($prd->kdv > 0 ? '<i>+' . Lang::get('frontend/general.kdv') . '</i>' : '<i>' . Lang::get('frontend/general.kdvincluded') . '</i>') !!}
                                                        {!! ($prd->havale_ind_yuzde > 0 ? ' <i>(' . Lang::get('frontend/general.transferdiscountpercent', array('percent'=>$prd->havale_ind_yuzde)) . ')</i>' : '') !!}
                                                    </span>
                                                </span>
                                            @else
                                                <span class="DiscountPrice">
                                                    <span>
                                                        {{ $prd->currency.$prd->real_price }} {!! ($prd->kdv > 0 ? '<i>+' . Lang::get('frontend/general.kdv') . '</i>' : '') !!}
                                                        {!! ($prd->havale_ind_yuzde > 0 ? ' <i>'.$prd->currency.''.\App\Library\Common::getYuzdeliFiyat($prd->real_price,$prd->havale_ind_yuzde).' (' . Lang::get('frontend/general.transferdiscountpercent', array('percent'=>$prd->havale_ind_yuzde)) . ')</i>' : '') !!}
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="Comments text-center">
                                        <div class="Raiting">
                                            @for ($i=1; $i <= 5 ; $i++)
                                                <span><i class="fa fa-star{{ ($i <= $prd->rating_cache) ? '' : '-o'}}"></i></span>
                                            @endfor
                                        </div>
                                        <a id="ReadAddComment" href="#DetailContent">{{Lang::get('frontend/general.readcomment')}} ({{$prd->rating_count}})</a>
                                        <a id="ReadAddComment" href="#DetailContent">{{Lang::get('frontend/general.commenton')}}</a>
                                    </div>
                                    <div class="Cargo">
                                        <ul class="TableList">
                                            {{--<li><span>{{ Lang::get('frontend/general.stockcode') }}</span><span>{{ $prd->id }}</span></li>--}}                                            
                                            <li><span>{{ Lang::get('frontend/general.category') }}</span><span class="ColorOrange">{{ $prd->categorie->{'title_'.$defLocale} }}</span></li>
                                            {!! ($prd->brand_id > 0 ? ' <li><span>' . Lang::get('frontend/general.brand') . '</span><span>'. \App\Library\Common::getBrandName($prd->brand_id).'</span></li>' : '') !!}
                                            @if($prd->width != '' && $prd->height != '')
                                                <li>
                                                    <span>{{ Lang::get('frontend/general.dimensions') }}</span>
                                                    <span>{{ $prd->width.' '.$prd->width_birim.' x '.$prd->height.' '.$prd->height_birim }} {{  $prd->depth != '' ? ' x '.$prd->depth.' '.$prd->depth_birim : '' }}</span></li>
                                            @else
                                                {!! ($prd->width != '' ? ' <li><span>' . Lang::get('frontend/general.width') . '</span><span>'.$prd->width.' '.$prd->width_birim.'</span></li>' : '') !!}
                                                {!! ($prd->height != '' ? ' <li><span>' . Lang::get('frontend/general.height') . '</span><span>'.$prd->height.' '.$prd->height_birim.'</span></li>' : '') !!}
                                                {!! ($prd->depth != '' ? ' <li><span>' . Lang::get('frontend/general.depth') . '</span><span>'.$prd->depth.' '.$prd->depth_birim.'</span></li>' : '') !!}
                                            @endif
                                            {!! ($prd->weight != '' ? ' <li><span>' . Lang::get('frontend/general.weight') . '</span><span>'.$prd->weight.' '.$prd->weight_birim.'</span></li>' : '') !!}
                                            @if($prd->kdv > 0)
                                                <li><span>{{Lang::get('frontend/general.kdv')}}</span><span>%{{ $prd->kdv }}</span></li>
                                                <li><span>{{Lang::get('frontend/general.kdvincludedprice')}}</span><span>{{ $prd->currency.''.number_format(\App\Library\Common::addTaxToPrice($prd->real_price,$prd->kdv),2) }}</span></li>
                                            @endif                                         

                                            {!! ($prd->kargo_ucret == 0 ? '<li><span>' . Lang::get('frontend/general.shippinginfosingular') . '</span><span>' . Lang::get('frontend/general.freeshipping') . '</span></li>' : '<li><span>' . Lang::get('frontend/general.shipmentprice') . '</span><span>'.$prd->currency.$prd->kargo_ucret.'</span></li>') !!}
                                            {!! ((int)$prd->kargo_sure > 0 ? ' <li><span>' . Lang::get('frontend/general.kargo-sure') . '</span><span>'.$prd->kargo_sure.' '.Lang::get('frontend/general.days').'</span></li>' : '') !!}                                           
                                        </ul>
                                        <div>
                                            @if($prd->stock == 0)
                                            <div class="NoStock">
                                                <div><i class="fa fa-ban"></i><span>{{Lang::get('frontend/general.notinstock')}}</span></div>
                                            </div>
                                            @else
                                                @if($prd->hizli_gonderi == 1)
                                                    <div class="FastCargo mr-5">
                                                        <div><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.hizli-gonderi')}}</span></div>
                                                    </div>
                                                @endif
                                                @if($prd->sinirli_stok == 1)
                                                    <div class="LimitedStock">
                                                        <div><i class="fa fa-gift"></i><span>{{Lang::get('frontend/general.sinirli-stok')}}</span></div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @if($prd->stock > 0)
                                        <form name="addCart" class="addCart" id="addCart" action="{{{ url('/addCart') }}}" method="post">
                                            <meta name="csrf_token" content="{{ csrf_token() }}">
                                            {{ csrf_field() }}
                                            <div class="Features">
                                                <div class="row">
                                                    @if($prd->properties && $prd->properties->count() > 0)
                                                        @foreach($prd->properties as $prop)
                                                            @if($prop->options->count() > 0)
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{$prop->{'title_'.$defLocale} }}</label>
                                                                        <select class="form-control" name="opt[{{ $prop->id }}]" id="opt_{{ $prop->id }}">
                                                                            <option value="">@lang('frontend/general.select')</option>
                                                                            @foreach($prop->options as $opt)
                                                                                <option value="{{ $opt->id }}">{{ $opt->title_en }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @elseif($options->count() > 0)
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>{{Lang::get('frontend/general.option')}}</label>
                                                                <select class="form-control" name="opt" id="opt">
                                                                    @foreach($options as $opt)
                                                                        <option value="{{ $opt->id }}">{{ $opt->{'title_'.$defLocale} }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="opt" id="opt" value="0">
                                                    @endif
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                {{Lang::get('frontend/general.count')}} @if(\App\Library\Common::IsStockDinamic() == 1 && $prd->stock < 10) <span class="ColorRed" style="font-size: 11px;">{{ Lang::get('frontend/general.stockalert',['number' => $prd->stock]) }}</span>@endif
                                                            </label>
                                                            <select class="form-control" name="qty" id="qty">
                                                                @for ($i=1; $i <= \App\Library\Common::getProductMaxQty($prd->id,10) ; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="BuyingTools text-center">
                                                <a id="CartButton" class="BtnSuccess inline-block mr-10"><i class="fa fa-shopping-cart"></i><span class="cartBtnText">{{Lang::get('frontend/general.addtocart')}}</span></a>
                                                <a class="BtnWarning inline-block" id="OrderNow"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.buynow')}}</span></a>                                            </div>
                                            <input type="hidden" name="pId" value="{{ $prd->id }}">
                                            <input type="hidden" name="uId" id="uId" value="{{ $uId }}">
                                        </form>
                                        <div class="result" style="padding: 0 10px;"></div>
                                    @endif
                                    <div class="FeaturesFooter">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($uId == 0)
                                                <a href="{{{ url('/giris') }}}"><i class="fa fa-star mr-5"></i>{{Lang::get('frontend/general.addtofavourites')}}</a></div>
                                                @else
                                                <a class="AddFavorite" data-id="{{ $prd->id }}"><i class="fa fa-star mr-5"></i><span class="AddFavoriteText">{{Lang::get('frontend/general.addtofavourites')}}</span></a></div>
                                                @endif
                                            <div class="col-md-6 text-right">
                                                <div class="ShareSocial">
                                                    @foreach($socialLinks as $key => $val )
                                                        <a class="{{ $key }}" href="{{ $val }}" title="Paylaş : {{ $key }}" rel="external"><i class="fa fa-{{ ($key == 'gplus' ? 'google-plus' : $key) }}"></i></a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissable margin5">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="ProductDetailContent">
                    <div class="DefaultBox">
                        <div id="DetailContent" class="DefaultBoxHeading Tabbed">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#detail" data-toggle="tab">{{Lang::get('frontend/general.productdescription')}}</a></li>
                                <li><a id="ReadAddCommentTab" href="#comment" data-toggle="tab">{{Lang::get('frontend/general.comments')}}</a></li>
                                <?php
                                $payCreditCard = \App\Paymethod::where('uniqueName','creditcard')->whereStatus(1)->first();
                                if ($payCreditCard) {
                                ?>
                                <li><a href="#payment" data-toggle="tab">{{Lang::get('frontend/general.instoptions')}}</a></li>
                                <?php } ?>
                            </ul>
                            @if($prd->catalog != '')                            
                            <a href="{{{ url('/').'/uploads/products/'.$prd->id.'/'.$prd->catalog }}}" target="_blank"><i class="fa fa-file-text-o mr-5"></i><span>{{Lang::get('frontend/general.downloadcatalog')}}</span></a>
                            @endif
                        </div>
                        <div class="DefaultBoxBody">
                            <div class="tab-content">
                                <div id="detail" class="tab-pane active">
                                    <div>{!! $prd->{'content_'.$defLocale} !!}</div>
                                </div>
                                <div id="comment" class="tab-pane">
                                    <div class="AddComment">
                                        <div class="AddCommentHeading">
                                            @if($uId == 0)
                                            <p>
                                                {!!Lang::get('frontend/general.commentsigninup', array('signuptag'=>'<a class="ColorOrange" href="' . url('/kayit') . '">', 'signintag'=>'<a class="ColorOrange" href="' . url('/giris') . '">'))!!}
                                            </p>
                                            @else
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <a class="BtnWarning inline-block BtnAddComment"><i class="fa fa-comment"></i><span>{{Lang::get('frontend/general.commenton')}}</span></a>
                                                </div>
                                                <div class="col-md-7">&nbsp;</div>
                                                <div class="col-md-2">
                                                    <div class="Raiting text-center"><b>{{Lang::get('frontend/general.averagepoint')}}</b>
                                                        @for ($i=1; $i <= 5 ; $i++)
                                                            <span><i class="fa fa-star{{ ($i <= $prd->rating_cache) ? '' : '-o'}}"></i></span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group" id="AddCommentContainer">
                                            <form method="POST" name="AddComment" action="#" class="AddCommentContainer">
                                                {{ csrf_field() }}
                                                <div class="CommentTools" id="reviews-anchor">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>{{Lang::get('frontend/general.writecomment')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-md-12"> <span class="inlineblock">{{Lang::get('frontend/general.rate')}}</span>
                                                                    <div class="RateProduct inline-block"  data-rating="{{Input::old('rating',0)}}">
                                                                        <a><i class="fa fa-star-o"></i></a>
                                                                        <a><i class="fa fa-star-o"></i></a>
                                                                        <a><i class="fa fa-star-o"></i></a>
                                                                        <a><i class="fa fa-star-o"></i></a>
                                                                        <a><i class="fa fa-star-o"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="CommentTable">
                                                    <div>
                                                        <div class="InputWrapper">
                                                            <textarea type="text" name="comment" id="new-review" class="form-control required" maxlength="300" data-rule-required="true" data-msg-required="{{ Lang::get('frontend/general.entercomment') }}">{{{ Input::old('comment') }}}</textarea>
                                                            <div class="InputTools"><span class="Counter"><span>0 / </span><span>300</span></span></div>
                                                        </div>
                                                    </div>
                                                    <button class="BtnWarning" type="submit">{{Lang::get('frontend/button.submit')}}</button>
                                                </div>
                                                <input type="hidden" name="rating" id="ratings-hidden" value="0">
                                                <input type="hidden" name="uId" value="{!! $uId !!}">
                                            </form>
                                        </div>
                                        <div class="has-error ml-15 mr-15">
                                            @if(Session::has('review_posted'))
                                                <div class="alert alert-success alert-dismissable mt-10 mb-5">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    {{Lang::get('frontend/general.commentadded')}}.
                                                </div>
                                            @endif
                                            @if(Session::has('review_removed'))
                                                <div class="alert alert-success alert-dismissable margin5">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    {{Lang::get('frontend/general.commentremoved')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="CommentList">
                                        @foreach($reviews as $review)
                                            <div class="CommentItem">
                                                <div class="CommentHeading">
                                                    <div class="UserInfo inline-block"><a>{{ $review->user ? $review->user->first_name.' '.$review->user->last_name : Lang::get('frontend/general.guest')}}</a><span> - {{$review->created_at}}</span></div>
                                                    <div class="Raiting inline-block ml-30">
                                                        @for ($i=1; $i <= 5 ; $i++)
                                                            <span><i class="fa fa-star{{ ($i <= $review->rating) ? '' : '-o'}}"></i></span>
                                                        @endfor
                                                    </div>
                                                    @if($review->user->id === $uId)
                                                        <div class="CommentEditTools pull-right">
                                                            <a type="submit" class="close DelReview" data-id="{{ $review->id }}" data-prd-id="{{ $prd->id }}" title="{{Lang::get('frontend/general.removecomment')}}"  data-psefurl="{{ $url }}"><i class="fa fa-trash-o"></i></a>
                                                            <a class="close EditReview" data-id="{{ $review->id }}" title="{{Lang::get('frontend/general.editcomment')}}"><i class="fa fa-pencil-square-o"></i></a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    @endif
                                                </div>
                                                <div class="CommentBody">
                                                    <p>{{{ $review->comment }}}</p>

                                                    @if($review->user->id === $uId)
                                                        <div class="form-group">
                                                            <div class="CommentTable hide" id="Comment{{ $review->id }}">
                                                                <div>
                                                                    <div class="InputWrapper">
                                                                        <textarea type="text" name="comment" id="comment{{ $review->id }}" class="form-control" maxlength="300">{{{$review->comment}}}</textarea>
                                                                        <div class="InputTools"><span class="Counter"><span>0 / </span><span>300</span></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right mt-5">
                                                                    <button class="BtnWarning ChangeReview"  type="button" name="ChangeReview" data-id="{{ $review->id }}" data-prd-id="{{ $prd->id }}">
                                                                        <i class="fa fa-comment"></i> <span>{{Lang::get('frontend/button.update')}}</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                            <div class="CategoryListPagination text-center">{!! $reviews->render() !!}</div>
                                    </div>
                                </div>
                                <div id="payment" class="tab-pane">
                                    <?php $i = 0; ?>
                                    @foreach ($banks as $bank)
                                        @if($bank->taksit == 1)
                                            @if($i % 4 == 0)
                                                <div class="clearfix" style="clear:both;"></div>
                                                <div class="Partials">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        @for($j=2;$j<=12;$j++)
                                                            <tr>
                                                                <td>{{ $j }}</td>
                                                            </tr>
                                                        @endfor
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                            <div class="{{ $bank->bankhandle }}">
                                                <table class="table table-bordered">
                                                    <caption class="{{ $bank->bankhandle }}"><img src="{{ url('/').'/uploads/banks/'.$bank->icon }}"></caption>
                                                    <thead>
                                                    <tr>
                                                        <th>{{Lang::get('frontend/general.instamount')}}</th>
                                                        <th>{{Lang::get('frontend/general.totalamount')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $taksitler = json_decode($bank->taksitler); ?>
                                                        @foreach($taksitler as $key => $val)
                                                            @if($val == '-')
                                                                <tr>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                            @else
                                                                <?php
                                                                $taksitliFiyat = \App\Library\Common::getYuzdeArtiFiyat($prd->real_price,$val);
                                                                $taksits = $taksitliFiyat / $key;
                                                                ?>
                                                                <tr>
                                                                    <td>{{ $siteSettings->para_birim.number_format($taksits,2) }}</td>
                                                                    <td>{{ $siteSettings->para_birim.number_format($taksitliFiyat,2) }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="2">{{Lang::get('frontend/general.minInstalment')}}  : <b>{{ $siteSettings->para_birim.$bank->mintaksit }}</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php $i++; ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </section>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="{{ asset('assets/js/frontend/events/textareaevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/cartevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/favoriteevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/productgallery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/commentevents.js') }}" type="text/javascript"></script>
    @if(Session::has('review_posted') OR $errors->any())
    <script>
        $("#ReadAddCommentTab").trigger("click");
    </script>
    @endif
    <script>
        $(function() {
            $("[data-toggle='tooltip']").tooltip();
        });
    </script>

    <!--page level js ends-->
@stop
