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

    <title>{{ config('app.name', '-') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/'.apps::gettemplate($mode, 'favicon')) }}">
    <link href="{{ asset('/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/pages/dashboard1.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('/dist/css/style.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('/dist/css/style-.css') }}" rel="stylesheet"> --}}

    
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
    @yield('css')

    <link href="{{ asset('/js/toastr/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('/node_modules/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/globalFunction.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/css/customs.css') }}" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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

<body class="{{ apps::gettemplate($mode, 'main_theme') }}">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ config('app.name', '-') }}</p>
        </div>
    </div>
    <form id="logout-form" action="" method="POST" class="d-none">
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
                            <img src="" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <span class="hidden-xs" style="font-size: 12px;"><span class="font-bold">{{ apps::gettemplate($mode, 'app_alias2') }}</span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse" style="background-color:#20005E;">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        {{-- @if (session()->has('akses')) --}}
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="{{ __('Cari data, tekan Enter...') }}">
                            </form>
                        </li>
                        {{-- @endif --}}
                    </ul>
                    {{-- @if (!session()->has('akses')) --}}
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a href="" class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"><i class="ti-user"></i> Login</a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                    {{-- @else --}}
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="" alt="user" class=""> 
                                <span class="hidden-md-down">
                                {{-- session('login') --}}
                                {{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}
                                 &nbsp;<i class="fa fa-angle-down"></i></span> 
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="#" class="dropdown-item"><i class="ti-user"></i> Profil</a>
                                <a href="" class="dropdown-item"><i class="ti-key"></i> Ubah Password</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="" class="dropdown-item"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                    {{-- @endif --}}
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        {{-- @if (!session()->has('akses'))
                            <li> <a class="waves-effect waves-dark" href="{{ route('login') }}"><i class="ti-user"></i><span class="hide-menu">Login</span></a>
                            </li>
                        @else --}}
                            <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><!-- <img src="{{ asset('/1.jpg') }}" alt="user-img" class="img-circle"> --> <span class="hide-menu">{{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="#"><i class="ti-user"></i> Profil</a></li>
                                    <li><a href="#"><i class="ti-key"></i> Ubah Password</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href=""
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a></li>
                                </ul>
                            </li>
                            <li> 
                                <a class="has-arrow waves-effect waves-dark" href="" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Home</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li>
                                        <a class="waves-effect waves-dark" href="">Halaman Awal</a>
                                    </li>
                                    <li>
                                        <a class="waves-effect waves-dark" href="">Menu Utama</a>
                                    </li>
                                    <li>
                                        <a class="waves-effect waves-dark" href="">Dashboard</a>
                                    </li>
                                </ul>
                            </li>
                            {{-- @if (session()->has('akses'))
                                @php
                                $iconmenu = array (
                                        "Master" =>  "ti-list",
                                        "Sarpras" =>  "ti-layout-list-thumb",
                                        "Utilitas" =>  "ti-settings",
                                        "Verifikasi" =>  "ti-check-box",
                                        "Laporan" =>  "ti-stats-up",
                                    );
                                $akses = Session::get('akses');
                                @endphp
                                @for ($counter = 0; $counter < count($akses); $counter++)
                                    @if ($counter == 0 || ($counter > 0 && $akses[$counter]->ketjenis != $akses[$counter-1]->ketjenis))
                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{{ $iconmenu[$akses[$counter]->ketjenis] }}"></i><span class="hide-menu">{{ $akses[$counter]->ketjenis }}</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                    @endif
                                    @if ($counter == 0)
                                        @if ($counter+1 < count($akses) && $akses[$counter]->parent == $akses[$counter+1]->parent)
                                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">{{ $akses[$counter]->parent }}</a>
                                            <ul aria-expanded="false" class="collapse">
                                        @endif
                                    @elseif ($akses[$counter]->parent != $akses[$counter-1]->parent && ($counter+1 < count($akses) && $akses[$counter]->parent == $akses[$counter+1]->parent))
                                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">{{ $akses[$counter]->parent }}</a>
                                            <ul aria-expanded="false" class="collapse">
                                    @endif
                                    
                                    @if (Route::has($akses[$counter]->url))
                                    <li><a href="{{ route($akses[$counter]->url) }}">{{ $akses[$counter]->menu }}</a></li>
                                    @else
                                    <li><a href="javascript:void(0)">{{ $akses[$counter]->menu }}</a></li>
                                    @endif

                                    @if ($counter > 0 && $akses[$counter]->parent == $akses[$counter-1]->parent && ($counter+1 < count($akses) && $akses[$counter]->parent != $akses[$counter+1]->parent))
                                        </ul></li>
                                    @endif
                                    @if ($counter+1 == count($akses) || ($counter+1 < count($akses) && $akses[$counter]->ketjenis != $akses[$counter+1]->ketjenis))
                                        </ul></li>
                                    @endif
                                @endfor
                            @endif --}}
                        {{-- @endif --}}
                    </ul>
                </nav>
                <!--

                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Apps</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="app-calendar.html">Calendar</a></li>
                                    <li><a href="app-chat.html">Chat app</a></li>
                                    <li><a href="app-ticket.html">Support Ticket</a></li>
                                    <li><a href="app-contact.html">Contact / Employee</a></li>
                                    <li><a href="app-contact2.html">Contact Grid</a></li>
                                    <li><a href="app-contact-detail.html">Contact Detail</a></li>
                                </ul>
                            </li>
-->
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper background-mibedil">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"></h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><b>Home</b></a></li>
                                {{-- @if (isset($child))
                                    @if (isset($masterurl))
                                    <li class="breadcrumb-item active"><a href="{{ $masterurl }}">{{ ucwords($page) }}</a></li>
                                    @else
                                    <li class="breadcrumb-item">{{ ucwords($page) }}</li>
                                    @endif
                                <li class="breadcrumb-item active">{{ ucwords($child) }}</li>
                                @else
                                <li class="breadcrumb-item active">{{ ucwords($page) }}</li>
                                @endif --}}

                            </ol>
                            {{-- @if (isset($createbutton) && $createbutton && isset($createurl))
                            <a href="{{ $createurl }}" {{ isset($eventclik) && $eventclik!="" ? "onclick=$eventclik" : "" }} class="btn btn-info d-block d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                            @endif --}}
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
            {{-- @if (session()->has('thang'))
            <div class="d-flex">
                <div>
                @if (isset(Auth::user()->grup))
                    @if (Auth::user()->grup === Config::get('constants.grup.grup_superadmin'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_superadmin') }}</span>
                    @elseif (Auth::user()->grup === Config::get('constants.grup.grup_admin'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_admin') }}</span>
                    @elseif (Auth::user()->grup === Config::get('constants.grup.grup_user'))
                    <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_user') }}</span>
                    @endif
                @endif
                <span class="badge badge-pill badge-info text-white mr-auto text-lg-left">Tahun Anggaran : {{ Session::get('thang') }}</span>
                <span class="badge badge-pill badge-dark text-white mr-auto text-lg-left">Posisi RKA : {{ strtoupper(Session::get('posisirka')) }}</span>
                <span class="badge badge-pill badge-danger text-white mr-auto text-lg-left">Posisi Transaksi : {{ strtoupper(Session::get('posisi')) }}</span>
                </div>
                <div class="ml-auto">
                © 2022 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
                </div> --}}
            </div>
            {{-- @else --}}
            © 2022 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
            {{-- @endif --}}
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

    <!-- jQuery -->
    <script src="/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Counter js -->
    <script src="/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="/plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="/plugins/bower_components/morrisjs/morris.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/dashboard1.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    {{-- <script type="text/javascript">
    $(document).ready(function() {
        $.toast({
            heading: 'Welcome to Elite admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,

            stack: 6
        });
        $('.vcarousel').carousel({
            interval: 3000
        });
    });
    </script> --}}
    <!--Style Switcher -->
    <script src="/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="{{ asset('/js/customs.js') }}"></script>
    <script src="{{ asset('/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/dist/js/waves.js') }}"></script>
    <script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/dist/js/custom.min.js') }}"></script>
    <!-- <script src="{{ asset('/dist/js/sweetalert2.min.js') }}"></script> -->
    <script src="{{ asset('/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('/js/toast-master/js/jquery.toast.js') }}"></script>
    <!-- Chart JS -->
    <!-- <script src="dist/js/dashboard1.js"></script> -->


    <script src="{{ asset('/js/customs.js') }}"></script>
    <script src="{{ asset('/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/dist/js/waves.js') }}"></script>
    <script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/dist/js/custom.min.js') }}"></script>
    <!-- <script src="{{ asset('/dist/js/sweetalert2.min.js') }}"></script> -->
    <script src="{{ asset('/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('/js/toast-master/js/jquery.toast.js') }}"></script>
</body>

</html>
