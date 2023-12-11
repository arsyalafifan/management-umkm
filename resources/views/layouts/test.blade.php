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

    <title>{{ config('app.name', 'Sisfokap') }} :: {{ config('app.desc', 'Sisfokap') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/default/assets/images/favicon.png') }}">
    <link href="{{ asset('/default/dist/css/style-new.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
</head>

<body class="skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sisfokap</p>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
                    <a class="navbar-brand" href="{{-- route('dashboard') --}}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('/default/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('/default/assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <span class="hidden-xs"><span class="font-bold">Sisfo</span>kap</span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        @if (session()->has('akses'))
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="{{ __('Cari data, tekan Enter...') }}">
                            </form>
                        </li>
                        @endif
                    </ul>
                    @if (!session()->has('akses'))
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a href="{{ route('login') }}" class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"><i class="ti-user"></i> Login</a>
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
                                {{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}
                                 &nbsp;<i class="fa fa-angle-down"></i></span> 
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="{{ route('user.profil') }}" class="dropdown-item"><i class="ti-user"></i> Profil</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="{{ route('logout') }}" class="dropdown-item"
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
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        @if (!session()->has('akses'))
                            <li> <a class="waves-effect waves-dark" href="{{ route('login') }}"><i class="ti-user"></i><span class="hide-menu">Login</span></a>
                            </li>
                        @else
                            <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><img src="{{ asset('/1.jpg') }}" alt="user-img" class="img-circle"><span class="hide-menu">{{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{ route('user.profil') }}"><i class="ti-user"></i> Profil</a></li>
                                    <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a></li>
                                </ul>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="{{ route('home') }}"><i class="ti-home"></i><span class="hide-menu">Home</span></a>
                            </li>
                            @if (session()->has('akses'))
                                @php
                                $iconmenu = array (
                                        "Master" =>  "ti-list",
                                        "Perencanaan" =>  "ti-layout-list-thumb",
                                        "Penatausahaan" =>  "ti-loop",
                                        "Pertanggungjawaban" =>  "ti-pencil-alt",
                                        "Pelaporan" =>  "ti-stats-up",
                                        "Utilitas" =>  "ti-settings",
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
                            @endif
                        @endif
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
                            <a href="{{ $createurl }}" class="btn btn-info d-block d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data</a>
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
            @if (session()->has('thang'))
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
                </div>
                <div class="ml-auto">
                © 2021 {{ config('app.name', 'Sisfokap') }} by Riqcom Services
                </div>
            </div>
            @else
            © 2021 {{ config('app.name', 'Sisfokap') }} by Riqcom Services
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

    <script src="{{ asset('/js/customs.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/custom.min.js') }}"></script>
</body>

</html>