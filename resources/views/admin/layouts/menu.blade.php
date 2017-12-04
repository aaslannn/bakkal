<li {!! (Request::is('admin/books') || Request::is('admin/books/create') || Request::is('admin/books/*') ? 'class="active"' : '') !!}>
    <a href="#">
        <i class="livicon" data-name="list-ul" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
        <span class="title">Books</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="sub-menu">
        <li {!! (Request::is('admin/books') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/books') }}">
                <i class="fa fa-angle-double-right"></i>
                books
            </a>
        </li>
        <li {!! (Request::is('admin/books/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/books/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New Book
            </a>
        </li>
    </ul>
</li><li {!! (Request::is('admin/slides') || Request::is('admin/slides/create') || Request::is('admin/slides/*') ? 'class="active"' : '') !!}>
    <a href="#">
        <i class="livicon" data-name="list-ul" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
        <span class="title">Slides</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="sub-menu">
        <li {!! (Request::is('admin/slides') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/slides') }}">
                <i class="fa fa-angle-double-right"></i>
                slides
            </a>
        </li>
        <li {!! (Request::is('admin/slides/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/slides/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New Slide
            </a>
        </li>
    </ul>
</li>