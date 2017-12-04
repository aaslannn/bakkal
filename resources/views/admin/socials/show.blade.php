@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
slide
@parent
@stop

@section('content')
<section class="content-header">
    <h1>Slides</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>slides</li>
        <li class="active">slides</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    slide {{ $slide->id }}'s details
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <table class="table">
                    <tr><td>id</td><td>{{ $slide->id }}</td></tr>
                     <tr><td>title</td><td>{{ $slide['title'] }}</td></tr>
					<tr><td>image</td><td>{{ $slide['image'] }}</td></tr>
					<tr><td>link</td><td>{{ $slide['link'] }}</td></tr>
					
                </table>
            </div>
        </div>
    </div>
</div>
@stop