<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/default/assets/images/favicon.png') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>SIPD-KAPITASI :: {{ config('app.desc', 'SIPD-KAPITASI') }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/landing-page.css" rel="stylesheet"/>

        <!--     Fonts and icons     -->
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300' rel='stylesheet' type='text/css'>
        <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    </head>
    <body class="landing-page landing-page1">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <nav class="navbar navbar-transparent navbar-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                    </button>
                    <!--<a href="http://www.creative-tim.com">
                        <div class="logo-container">
                            <div class="logo">
                            <img src="{{ asset('/default/assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                            </div>
                            <div class="brand">
                            <span class="font-bold">SIPD-KAPITASI
                            </div>
                        </div>
                    </a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="example" >
                    <ul class="nav navbar-nav navbar-right">
                    @if (Route::has('login'))
                        @auth
                        <li>
                            <a href="{{ url('/home') }}">
                            <i class="fa fa-home"></i>
                            Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="{{ route('login') }}">
                            <i class="fa fa-user"></i>
                            Login
                            </a>
                        </li>
                        @endauth
                    @endif
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
        <div class="wrapper">
            <div class="parallax filter-gradient1 red" data-color="red">
                <div class="parallax-background">
                    <img class="parallax-background-image" src="images/news/sipd-kapitasi.jpg">
                </div>
                <div class= "container">
                    <div class="row">
                        <div class="col-md-6 hidden-xs">
                            <div class="parallax-image">
                                <img class="phone" src="assets/img/template/untitled-1.png" style="margin-top: 105px"/>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <div class="description">
                                <h2>&nbsp;</h2>
                                <p><b>Sistem Informasi Dana Kapitasi atau disebut dengan SIPD-KAPITASI merupakan sebuah Sistem Aplikasi yang digunakan untuk mencatat transaksi keuangan atas dana kapitasi di lingkungan FKTP Puskesmas</b></p>
                                <p><b>Aplikasi SIPD-KAPITASI dirancang secara sistematis guna memenuhi kebutuhan pelaporan Dana Kapitasi di tingkat FKTP Puskesmas.</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section1 section-no-padding">
                <div class="parallax filter-gradient red" data-color="red">
                    <div class="parallax-background">
                    <img class="parallax-background-image" src="images/news/image4.jpg">
                    </div>
                    <div class="info" style="top:50px;">
                        <h1>COMING SOON</h1>
                        <p>Stay tuned, we'll come to you soon.</p><br /><br />
                        <p style="padding:0px;margin:0px;font-size:5px">S I S F O K A P</p>
                        <p style="padding:0px;margin:0px;font-size:10px">S I S F O K A P</p>
                        <h5 style="padding:0px;margin:0px;">S I S F O K A P</h5>
                        <h4 style="padding:0px;margin:0px;">S I S F O K A P</h4>
                        <h3 style="padding:0px;margin:0px;" class="hidden-xs">S I S F O K A P</h3>
                        <h2 style="padding:0px;margin:0px;" class="hidden-xs">S I S F O K A P</h2>
                        <h1 style="padding:0px;margin:0px;" class="hidden-xs">S I S F O K A P</h1>
                        <h2 style="padding:0px;margin:0px;" class="hidden-xs">S I S F O K A P</h2>
                        <h3 style="padding:0px;margin:0px;">S I S F O K A P</h3>
                        <h4 style="padding:0px;margin:0px;">S I S F O K A P</h4>
                        <h5 style="padding:0px;margin:0px;">S I S F O K A P</h5>
                        <p style="padding:0px;margin:0px;font-size:10px">S I S F O K A P</p>
                        <p style="padding:0px;margin:0px;font-size:5px">S I S F O K A P</p>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <nav class="pull-left">
                        <ul>
                        @if (Route::has('login'))
                            @auth
                            <li>
                                <a href="{{ url('/home') }}">
                                <i class="fa fa-home"></i>
                                Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('login') }}">
                                <i class="fa fa-user"></i>
                                Login
                                </a>
                            </li>
                            @endauth
                        @endif
                        </ul>
                    </nav>
                    <div class="social-area pull-right">
                        <a class="btn btn-social btn-facebook btn-simple">
                        <i class="fa fa-facebook-square"></i>
                        </a>
                        <a class="btn btn-social btn-twitter btn-simple">
                        <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                    <div class="copyright">
                        &copy; 2021 <a href="www.riqcom.co.id">Riqcom Services</a>
                    </div>
                </div>
            </footer>
        </div>
    
        

    </body>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.js" type="text/javascript"></script>
    <script src="assets/js/awesome-landing-page.js" type="text/javascript"></script>
</html>
