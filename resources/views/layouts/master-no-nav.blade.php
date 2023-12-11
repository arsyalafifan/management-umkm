<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '-') }} :: {{ config('app.desc', '') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'favicon')) }}">
    <link href="{{ asset('/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/default/dist/css/style-new.css') }}" rel="stylesheet">
    <link href="{{ asset('/default/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/datatables/datatables.js') }}"></script>-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.2.1/css/searchPanes.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/searchpanes/1.2.1/js/dataTables.searchPanes.min.js"></script>
    <link type="text/css" href="https://cdn.datatables.net/rowgroup/1.1.3/css/rowGroup.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/rowgroup/1.1.3/css/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Compiled and minified JavaScript -->
    <!-- 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script> 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.material.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.material.min.js"></script>
    -->

    <link href="{{ asset('/js/toastr/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('/node_modules/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/globalFunction.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/css/customs.css') }}" rel="stylesheet">
    
    <style>
    .page-wrapper, .footer {
        margin-left: 0px;
    }

    </style>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="{{ apps::gettemplate($mode, 'main_theme') }} fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ config('app.name', '-') }}</p>
        </div>
    </div>
    <form id="logout-form" action="{{ route('executive.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo-32')) }}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo-32')) }}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <span class="hidden-xs"><span class="font-bold">{{ apps::gettemplate($mode, 'app_alias1') }}-</span>{{ apps::gettemplate($mode, 'app_alias2') }}</span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav">
                        @if(Auth::guard('executive')->check())
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <h4 class="text-white m-l-10 font-weight-bold">SISTEM INFORMASI EKSEKUTIF</h4>
                        </li>
                        @endif
                    </ul>
                    @if(!Auth::guard('executive')->check())
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a href="{{ route('executive.login') }}" class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"><i class="ti-user"></i> Login</a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                    @else
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('/1.jpg') }}" alt="user" class=""> 
                                <span class="hidden-md-down">
                                {{-- session('login') --}}
                                {{ isset(Auth::guard('executive')->user()->nama) ? Auth::guard('executive')->user()->nama : '' }}
                                 &nbsp;<i class="fa fa-angle-down"></i></span> 
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="{{ route('user.profil') }}" class="dropdown-item"><i class="ti-user"></i> Profil</a>
                                <a href="{{ route('user.password') }}" class="dropdown-item"><i class="ti-key"></i> Ubah Password</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="{{ route('executive.logout') }}" class="dropdown-item"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                    @endif
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">{{ ucwords($page) }}</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><b>Home</b></a></li>
                                @if (isset($child))
                                    @if (isset($masterurl))
                                    <li class="breadcrumb-item active"><a href="{{ $masterurl }}">{{ ucwords($page) }}</a></li>
                                    @else
                                    <li class="breadcrumb-item">{{ ucwords($page) }}</li>
                                    @endif
                                <li class="breadcrumb-item active">{{ ucwords($child) }}</li>
                                @else
                                <li class="breadcrumb-item active">{{ ucwords($page) }}</li>
                                @endif

                            </ol>
                            @if (isset($createbutton) && $createbutton && isset($createurl))
                            <a href="{{ $createurl }}" {{ isset($eventclik) && $eventclik!="" ? "onclick=$eventclik" : "" }} class="btn btn-info d-block d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
        @if (session()->has('executive-thang'))
            <div class="d-flex">
                <div>
                @if (isset(Auth::guard('executive')->user()->grup))
                    @if (Auth::guard('executive')->user()->grup === Config::get('constants.grup.grup_superadmin'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_superadmin') }}</span>
                    @elseif (Auth::guard('executive')->user()->grup === Config::get('constants.grup.grup_admin'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_admin') }}</span>
                    @elseif (Auth::guard('executive')->user()->grup === Config::get('constants.grup.grup_user'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_user') }}</span>
                    @endif
                @endif
                <span class="badge badge-pill badge-info text-white mr-auto text-lg-left">Tahun Anggaran : {{ Session::get('executive-thang') }}</span>
                <span class="badge badge-pill badge-dark text-white mr-auto text-lg-left">Posisi RKA : {{ strtoupper(Session::get('executive-posisirka')) }}</span>
                <span class="badge badge-pill badge-danger text-white mr-auto text-lg-left">Posisi Transaksi : {{ strtoupper(Session::get('executive-posisi')) }}</span>
                </div>
                <div class="ml-auto">
                © 2021 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
                </div>
            </div>
            @else
            © 2021 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
            @endif
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script>

    console.log("%c%cSISTEM", "background:black ; color: white", "color: red; font-size:40px");

    function selectedSub(subMenu){
        localStorage.setItem('subMenu', subMenu)
    }

    function selectedMenu(menu){
        localStorage.setItem('menu', menu)
    }

    function onload(){
        var menu = localStorage.getItem('menu');
        var subMenu = localStorage.getItem('subMenu');

        var menuElement = document.getElementById(menu);
        var subMenuElement = document.getElementById(subMenu);


        if (subMenuElement) {
            menuElement.setAttribute("class", "selected");
            subMenuElement.style.display = 'block';
        }
    }
    onload()
    </script>

    <script>
        @if(Session::has('alert-success'))
            toastr.success("{{ Session::get('alert-success') }}")
        @endif
        @if(Session::has('alert-danger'))
            toastr.warning("{{ Session::get('alert-danger') }}")
        @endif

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(document).ready(function() {
            var elements = document.querySelectorAll('input,select,textarea');

            for (var i = elements.length; i--;) {
                elements[i].addEventListener('invalid', function () {
                    this.scrollIntoView(false);
                });
            }
            
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        //var label = e.target.parentNode.querySelector('label[for=' + e.target.id + ']');
                        e.target.setCustomValidity("Isi field ini terlebih dahulu");
                    }
                };
                elements[i].onchange = function(e) {
                    e.target.setCustomValidity("");
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
            elements = document.getElementsByTagName("SELECT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].onchange = function(e) {
                    e.target.setCustomValidity("");
                };
                elements[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.setCustomValidity("Pilih salah satu item pada list");
                    }
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
        });

        function checkRequiredEntries(form) {
            var requiredElements = form.querySelectorAll('[required]');
            var marker = 0;
            alert("Silahkan isi/pilih data "+requiredElements[0].name+" terlebih dahulu");
            requiredElements[0].focus();
            /*for (var i = 0; i < form.elements.length; i++) {
                if (form.elements[i].name.substring(0,3) == "req") {
                    if (form.elements[i].value == "") {
                        marker = 1;
                        alert("You have not filled out all the required fields");
                        form.elements[i].focus();
                        break;
                    } 
                }
            }

            if (!marker) {
                alert("The form would normally be submitted at this point.  All required fields have entries.");
            }*/
            return false;
        }
    </script>

    <script src="{{ asset('/js/customs.js') }}"></script>
    <script src="{{ asset('/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/waves.js') }}"></script>
    <script src="{{ asset('/default/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/default/dist/js/custom.min.js') }}"></script>
    <!-- <script src="{{ asset('/default/dist/js/sweetalert2.min.js') }}"></script> -->
    <script src="{{ asset('/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('/js/toast-master/js/jquery.toast.js') }}"></script>
    <!-- Chart JS -->
    <!-- <script src="dist/js/dashboard1.js"></script> -->
</body>

</html>
