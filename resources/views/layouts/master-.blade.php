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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
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
    <script src="{{ asset('/js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <!--[if lt IE 9]> -->
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="{{ apps::gettemplate($mode, 'main_theme') }} hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <div class="loader">
            <div class="animation__shake"></div>
            <p class="animation__shake">{{ config('app.name', '-') }}</p>
        </div>
    </div>
    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form> --}}
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    {{-- <div id="main-wrapper"> --}}
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark navbar-light" style="background-color: ">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                        </div>
                    </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                </ul>
            </nav>
            <!-- /.navbar -->
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
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
                        {{-- <h4 class="text-themecolor">{{ ucwords($page) }}</h4> --}}
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        {{-- <div class="d-flex justify-content-end align-items-center">
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
                        </div> --}}
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
                </div>
            </div>
            @else
            © 2022 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
            @endif --}}
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
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


    <!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
</body>

</html>
