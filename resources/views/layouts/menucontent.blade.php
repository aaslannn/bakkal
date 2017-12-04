<div class="AccountSettingsSidebar mt-10">
    <div class="DefaultBox">
        <div class="DefaultBoxBody">
            <ul>
                <?php $segment = \Illuminate\Support\Facades\Request::segment(1); ?>
                @foreach($contents as $content)
                    <li>
                        <a href="{{{ url('/'.$content->sefurl) }}}" {!! ($segment == $content->sefurl ? 'class="Selected"' : '') !!}><i class="fa fa-chevron-right"></i><span>{{ $content->{'title_'.$defLocale} }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>