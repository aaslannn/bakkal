<div class="AccountSettingsSidebar">
    <div class="DefaultBox">
        <div class="DefaultBoxHeading">{{Lang::get('frontend/general.profile-actions')}}</div>
        <div class="DefaultBoxBody">
            <?php $segment = \Illuminate\Support\Facades\Request::segment(2); ?>
            <ul>
                <li><a href="{{{ url('/uye/profil') }}}" {!! ($segment == 'profil' ? 'class="Selected"' : '') !!}><i class="fa fa-user"></i><span>{{Lang::get('frontend/general.member-info')}}</span></a></li>
                <li><a href="{{{ url('/uye/adresler') }}}" {!! ($segment == 'adresler' ? 'class="Selected"' : '') !!}><i class="fa fa-book"></i><span>{{Lang::get('frontend/general.address-book')}}</span></a></li>
                <li><a href="{{{ url('/uye/favoriler') }}}" {!! ($segment == 'favoriler' ? 'class="Selected"' : '') !!}><i class="fa fa-star"></i><span>{{Lang::get('frontend/general.favorite-products')}}</span><span class="BagdeWrapper"><span class="badge">{{ $uye->favorites->count() }}</span></span></a></li>
                <li><a href="{{{ url('/sepet') }}}"><i class="fa fa-shopping-cart"></i><span>{{Lang::get('frontend/general.my-cart')}}</span><span class="BagdeWrapper"><span class="badge Warning">{{ Cart::count() }}</span></span></a></li>
                <li><a href="{{{ url('/uye/siparisler') }}}" {!! ($segment == 'siparisler' ? 'class="Selected"' : '') !!}><i class="fa fa-calendar-o"></i><span>{{Lang::get('frontend/general.my-orders')}}</span><span class="BagdeWrapper"><span class="badge">{{ $uye->orders->count() }}</span></span></a></li>
                <li><a href="{{{ url('/cikis') }}}" class="ColorRed"><i class="fa fa-times-circle"></i><span>{{Lang::get('frontend/general.safelogout')}}</span></a></li>
            </ul>
        </div>
    </div>
</div>