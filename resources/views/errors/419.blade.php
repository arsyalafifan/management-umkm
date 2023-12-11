@extends('layouts.master-without-nav')

@section('title') 419 - Page Expired @endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div id="notfound">
        <div class="notfound-bg"></div>
            <div class="notfound">
                <div class="notfound-404">
                    <h1>419</h1>
                </div>
                <h2>{{ 'Page Expired' }}</h2>
                <a href="{{url('/')}}" class="home-btn">Go to Index</a>
            </div>
        </div>
    </div>
    @endsection