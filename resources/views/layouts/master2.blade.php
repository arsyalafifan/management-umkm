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

    <title>{{ config('app.name', 'Laravel1') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/default/assets/images/favicon.png') }}">
    <link href="{{ asset('/js/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('/default/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/default/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('/datatables/datatables.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <link href="{{ asset('/js/toastr/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('/node_modules/timepicker/bootstrap-timepicker.min.js') }}"></script>

    <link href="{{ asset('/css/customs.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="skin-default fixed-layout">
    <div class="preloader1">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Laravel</p>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{-- route('dashboard') --}}">
                    </a>
                </div>

                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto">
                        <li class="d-none d-md-block d-lg-block">
                            <h3 class="text-white">Laravel</h3>
                        </li>
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('/1.jpg') }}" alt="user" class=""> <span class="hidden-md-down">
                                    {{-- session('login') --}}
                                    {{ Auth::user()->nama }}
                                     &nbsp;<i class="fa fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="{{ route('logoutakun') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="side-mini-panel">
            <ul class="mini-nav">
                <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>
                @foreach (App\Models\Mainmenu::where([['jenis', 1]])->orderBy('orderno', 'asc')->distinct()->get() as $parent)
                    <li id="{{$parent->menu}}" onclick="selectedMenu(`{{$parent->menu}}`)">
                        <a href="javascript:void(0)"><i class="{{ $parent->icon }}"></i></a>
                        <div class="sidebarmenu">
                            <!-- Left navbar-header -->
                            <h3 class="menu-title">{{$parent->menu}}</h3>
                            <ul class="sidebar-menu">
                                @foreach (App\Models\Mainmenu::where([['jenis', 2], ['parent', $parent->menu]])->orderBy('orderno', 'asc')->distinct()->get() as $item)
                                    @if ($item->url != 'javascript:void(0)')
                                        <li class="menu" onclick="selectedSub(`{{$item->menu}}`)">
                                            <a href="{{ route($item->url)}}">{{$item->menu}} </a>
                                        </li>
                                    @else
                                    <li class="menu" onclick="selectedSub(`{{$item->menu}}`)">
                                        <a href="javascript:void(0)">{{$item->menu}} <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul id="{{$item->menu}}" class="sub-menu">
                                            @foreach (App\Models\Mainmenu::where([['jenis', 3], ['parent', $item->menu]])->orderBy('orderno', 'asc')->distinct()->get() as $sub)
                                                <li><a href="{{ route($sub->url)}}">{{$sub->menu}} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                            <!-- Left navbar-header end -->
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-12">
                        <h4 class="text-white">{{-- ucfirst($page) --}}</h4>
                    </div>
                    {{-- <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div> --}}
                </div>

                <!-- CONTENT  -->
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer style="background-color: white" class="page-footer font-small blue">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3"><marquee behavior="scroll" direction="left">Anda login sebagai: <strong><b style=";color: #fb9678;">Admin</b></strong>, Tahun Login: <strong><b style=";color: #fb9678;">{{--session('tahun')--}}</b></strong> </marquee>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
    </div>
    <script>

    console.log("%c%cESIPUGA", "background:black ; color: white", "color: red; font-size:40px");

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
    </script>

    <script src="{{ asset('/js/customs.js') }}"></script>
    <script src="{{ asset('/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/waves.js') }}"></script>
    <script src="{{ asset('/default/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/default/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('/default/dist/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/js/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('/js/toast-master/js/jquery.toast.js') }}"></script>
</body>
</html>
