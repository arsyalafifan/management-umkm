@extends('layouts.master-without-nav')

@section('title') 403 - Unauthorized @endsection

@section('body')

<body>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    
        ga('create', 'UA-19175540-9', 'auto');
        ga('send', 'pageview');
        </script>
    @endsection

    @section('content')
    {{-- <div id="notfound">
        <div class="notfound-bg"></div>
            <div class="notfound">
                <div class="notfound-404">
                    <h1>403</h1>
                </div>
                <h2>{{ $exception->getMessage() }}</h2>
                <a href="{{url('/')}}" class="home-btn">Go to Index</a>
            </div>
        </div>
    </div> --}}

    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>403</h1>
                <h3 class="text-uppercase">UNAUTHORIZED</h3>
                <h2 class="text-muted m-t-30 m-b-30 text-uppercase">Akun anda tidak diizinkan untuk melakukan aksi ini.</h2>
                {{-- <a href="{{ route('sarpras-dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Kembali ke Dashboard</a> </div> --}}
                <a href="{{ url()->previous() }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Kembali</a> </div>
            <footer class="footer text-center">2023 © Riqcom Services.</footer>
        </div>
    </section>

    @endsection