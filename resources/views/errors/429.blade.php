@extends('layouts.master-without-nav')

@section('title') 429 - Too Many Requests @endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div id="notfound">
        <div class="notfound-bg"></div>
            <div class="notfound">
                <div class="notfound-404">
                    <h1>429</h1>
                </div>
                <h2>{{ 'Too Many Requests' }}</h2>
                <a href="{{url('/')}}" class="home-btn">Go to Index</a>
            </div>
        </div>
    </div>
    @endsection