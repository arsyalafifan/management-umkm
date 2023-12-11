@extends('layouts.master-without-nav')

@section('title') 404 @endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div id="notfound">
        <div class="notfound-bg"></div>
            <div class="notfound">
                <div class="notfound-404">
                    <h1>404</h1>
                </div>
                <h2>we are sorry, but the page you requested was not found</h2>
                <a href="{{url('/')}}" class="home-btn">Go to Index</a>
            </div>
        </div>
    </div>
    @endsection