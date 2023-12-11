<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '-') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/'.apps::gettemplate($mode, 'favicon')) }}">
    {{-- <link href="{{ asset('/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/js/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/plugins/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    {{-- <link href="{{ asset('/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet"> --}}
    <!-- morris CSS -->
    {{-- <link href="{{ asset('/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet"> --}}
    <!-- animation CSS -->
    <link href="{{ asset('/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/custom.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('/css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- touchspin CSS -->
    <link href="{{asset('/dist/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
    <!-- wizard -->
    <link href="{{asset('/dist/plugins/bower_components/jquery-wizard-master/css/wizard.css')}}" rel="stylesheet">
    <!-- dropify -->
    <link rel="stylesheet" href="{{asset('/dist/plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
    <!-- toastr --> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet" />

    <!-- modify selected row datatable color -->
    <style>
        @media (min-width: 1549px){
            #page-wrapper {
                margin-right: 0;
            }
        }
        @media (max-width: 540px){
            #page-wrapper {
                margin-left: 40px;
            }
        }
        table.dataTable tbody>tr.selected,table.dataTable tbody>tr>.selected {
            background-color: #9dabc7 !important;
            color: white;
            /* background-color: #b0bed9 !important; */
        }
        table.dataTable tbody>tr:hover,table.dataTable tbody>tr>:hover {
            /* background-color: #9dabc7 !important; */
            /* color: white; */
            box-shadow: inset 0 0 0 9999px #e9edf3 !important;
            /* background-color: #b0bed9 !important; */
        }
        .swal2-container {
            /* zoom: 1.3; */
            transform: scale(1.3);
        }

        label{
            font-weight: 600;
        }

        .progress {
            background-color: rgb(18 21 23 / 13%);
        }

    </style>

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

    @yield('css')

    {{-- <link href="{{ asset('/js/toastr/toastr.min.css') }}" rel="stylesheet"> --}}
    {{-- <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script> --}}
    <!-- Date range Plugin JavaScript -->
    {{-- <script src="{{ asset('/node_modules/timepicker/bootstrap-timepicker.min.js') }}"></script> --}}
    <script src="{{ asset('/assets/js/globalFunction.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/css/customs.css') }}" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    {{-- toastr --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
     alpha/css/bootstrap.css" rel="stylesheet">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

    <!-- toastr lates --> 
	{{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
</head>
<body class = "fix-header ">
    

     <!-- Preloader -->
     <div class="preloader">
        <div class="cssload-speeding-wheel">
        </div>
        {{-- <div class = "d-flex flex-column justify-content-center align-items-center">
            {{ config('app.name', '') }} 
        </div> --}}
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <!-- .Logo -->
                <div class="top-left-part">
                    <a class="logo" href="index.html">
                        <!--This is logo icon--><img src="../plugins/images/eliteadmin-small-logo.png" alt="" class="light-logo" /></a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="logotext">
                            <!--This is logo text-->APLIKASI MIBEDIL</a>
                    </li>
                </ul>
                <!-- /.Logo -->
                <!-- top right panel -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- .dropdown -->
                    <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i>
          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
          </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5>
                                            <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <!-- .dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect profile-pic" data-toggle="dropdown" href="#"> 
                            {{-- <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"> --}}
                            <span class="">
                                {{-- session('login') --}}
                                {{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}
                                 &nbsp;<i class="fa fa-angle-down"></i></span> 
                            {{-- <b class="hidden-xs">
                                {{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}
                                 &nbsp;<i class="fa fa-angle-down"></i></span> 
                            </b>  --}}
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('user.password') }}"><i class="ti-settings"></i> Ubah Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> 
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- top right panel -->
            </div>
        </nav>
        <!-- End Top Navigation -->
        <!-- .Side panel -->
        <div class="side-mini-panel">
            <ul class="mini-nav">
                <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class=" ti-menu"></i></a></div>
                <!-- .Dashboard -->
                {{-- <li class="">
                    <a href="javascript:void(0)"><i class="linea-icon linea-basic" data-icon="v"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Master</h3>
                        <ul class="sidebar-menu">
                            <li><a href="{{ route('instansi.index') }}">Instansi</a></li>
                            <li><a href="{{ route('kota.index') }}">Kota</a></li>
                            <li><a href="{{ route('kecamatan.index') }}">Kecamatan</a></li>
                            <li><a href="{{ route('tahunajaran.index') }}">Tahun Ajaran</a></li>
                            <li><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
                            <li><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                            <li><a href="{{ route('ijazah.index') }}">Ijazah</a></li>
                            <li><a href="{{ route('namasarpras.index') }}">Nama Sarpras</a></li>
                            <li><a href="{{ route('perusahaan.index') }}">Perusahaan</a></li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Kegiatan</span></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a class="waves-effect waves-dark" href="{{ route('program.index') }}">Program</a>
                                    </li>
                                    <li>
                                        <a class="waves-effect waves-dark" href="{{ route('kegiatan.index') }}">Kegiatan</a>
                                    </li>
                                    <li>
                                        <a class="waves-effect waves-dark" href="{{ route('subkegiatan.index') }}">Sub Kegiatan</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <li class=""><a href="javascript:void(0)"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Sarpras</h3>
                        <ul class="sidebar-menu">
                            <li><a href="{{ route('sarprastersedia.index') }}">Sarpras Tersedia</a></li>
                            <li><a href="{{ route('sarpraskebutuhan.index') }}">Kebutuhan Sarpras</a></li>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <li class=""><a href="javascript:void(0)"><i class="ti-layout-media-right-alt "></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Verifikasi</h3>
                        <ul class="sidebar-menu">
                            <li><a href="{{ route('legalisir.index') }}">Verifikasi Legalisir Ijazah</a></li>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <li class=""><a href="javascript:void(0)"><i class="ti-settings "></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Utilitas</h3>
                        <ul class="sidebar-menu">
                            <li><a href="{{ route('akses.index') }}">Hak Akses</a></li>
                            <li><a href="{{ route('user.index') }}">Pengguna</a></li>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li> --}}

                @if (!session()->has('akses'))
                    <li>
                        <a class="waves-effect waves-dark" href="{{ route('login') }}">
                        <i class="ti-user"></i>
                        <span class="hide-menu">Login</span></a>
                    </li>
                @else
                    {{-- <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">{{ isset(Auth::user()->nama) ? Auth::user()->nama : '' }}</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#"><i class="ti-user"></i> Profil</a></li>
                            <li><a href="#"><i class="ti-key"></i> Ubah Password</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a></li>
                        </ul>
                    </li> --}}
                    <li> 
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-home"></i>
                            <span style="font-size: 12px;" class="hide-menu">Home</span>
                        </a>
                        {{-- <ul aria-expanded="false" class="collapse"> --}}
                            {{-- <li>
                                <a class="waves-effect waves-dark" href="{{ route('index') }}">Halaman Awal</a>
                            </li> --}}
                            <div class="sidebarmenu">
                                <h3 class="menu-title">Home</h3>
                                <ul class="sidebar-menu">
                                    <li>
                                        <a class="waves-effect waves-dark" href="{{ route('index') }}">Halaman Awal</a>
                                    </li>
                                </ul>
                            </div>
                            {{-- <li>
                                <a class="waves-effect waves-dark" href="{{ route('dashboard') }}">Dashboard</a>
                            </li> --}}
                        {{-- </ul> --}}
                    </li>
                    @if (session()->has('akses'))
                        @php
                        $iconmenu = array (
                                "Master" =>  "ti-list",
                                "Sarpras" =>  "ti-layout-list-thumb",
                                "Utilitas" =>  "ti-settings",
                                "Verifikasi" =>  "ti-check-box",
                                "Transaksi" =>  "ti-money",
                                "Laporan & Rekap" =>  "ti-stats-up",
                                "Perencanaan Sarpras" =>  "ti-agenda",
                            );
                        $akses = Session::get('akses');
                        // echo $akses;
                        @endphp
                        @for ($counter = 0; $counter < count($akses); $counter++)
                            @if ($counter == 0 || ($counter > 0 && $akses[$counter]->ketjenis != $akses[$counter-1]->ketjenis))
                                <li> 
                                    <a class="has-arrow waves-effect" href="javascript:void(0)" aria-expanded="false">
                                        <i class="{{ $iconmenu[$akses[$counter]->ketjenis] }}"></i>
                                        <span style="font-size: 12px;" class="hide-menu">{{ $akses[$counter]->ketjenis }}</span>
                                    </a>
                                    <div class="sidebarmenu">
                                        <h3 class="menu-title">{{ $akses[$counter]->ketjenis }}</h3>
                                        <ul aria-expanded="false" class="sidebar-menu">

                                {{-- <li class="">
                                    <a href="javascript:void(0)" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                                        <i class="{{ $iconmenu[$akses[$counter]->ketjenis] }}"></i>
                                    </a>
                                    <div class="sidebarmenu">
                                        <!-- Left navbar-header -->
                                        <h3 class="menu-title">Utilitas</h3>
                                        <ul class="sidebar-menu">
                                            <li><a href="{{ route('akses.index') }}">Hak Akses</a></li>
                                            <li><a href="{{ route('user.index') }}">Pengguna</a></li>
                                        </ul>
                                        <!-- Left navbar-header end -->
                                    </div>
                                </li> --}}
                            @endif
                            @if ($counter == 0)
                                @if ($counter+1 < count($akses) && $akses[$counter]->parent == $akses[$counter+1]->parent)
                                <li> 
                                    {{-- <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">{{ $akses[$counter]->parent }}</a> --}}
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">{{ $akses[$counter]->parent }}</a>
                                    <ul aria-expanded="false" class="collapse sub-menu sidebar-menu">
                                @endif
                            @elseif ($akses[$counter]->parent != $akses[$counter-1]->parent && ($counter+1 < count($akses) && $akses[$counter]->parent == $akses[$counter+1]->parent))
                                <li> 
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">{{ $akses[$counter]->parent }} <i class="fa fa-angle-left pull-right"></i> </a>
                                    <ul aria-expanded="false" class="collapse sidebar-menu sub-menu ">
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
                                </ul></div></li>
                            @endif
                        @endfor
                    @endif
                @endif


                <!-- /.Dashboard -->
            </ul>
        </div>
        <!-- /.Side panel -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- .row -->
                <div class="row bg-title" style="background:url(../../assets/img/BACKGROUND_APLIKASI_foto_gub.jpg) no-repeat center center /cover; box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.2);">
                    <div class="col-md-5 align-self-center">
                        <h4 class="page-title">{{ ucwords($page ?? '') ?? '' }}</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        {{-- <ol class="breadcrumb pull-right">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Minimal Dashboard</li>
                        </ol>
                        @if (isset($createbutton) && $createbutton && isset($createurl))
                            <a href="{{ $createurl }}" {{ isset($eventclik) && $eventclik!="" ? "onclick=$eventclik" : "" }} class="btn btn-info d-block d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                            @endif --}}

                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href=""><b>Dashboard</b></a></li>
                                    @if (isset($child))
                                        @if (isset($masterurl))
                                        <li class="breadcrumb-item active"><a href="{{ $masterurl }}">{{ ucwords($page ?? '') }}</a></li>
                                        @else
                                        <li class="breadcrumb-item">{{ ucwords($page ?? '') }}</li>
                                        @endif
                                    <li class="breadcrumb-item active">{{ ucwords($child) }}</li>
                                    @else
                                    <li class="breadcrumb-item active">{{ ucwords($page ?? '') }}</li>
                                    @endif
    
                                </ol>
                                @if (isset($createbutton) && $createbutton && isset($createurl))
                                <a id="btnTambah" href="{{ $createurl }}" {{ isset($eventclik) && $eventclik!="" ? "onclick=$eventclik" : "" }} class="btn btn-info d-block d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                                @endif
                            </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center">
                 @if (session()->has('thang'))
                <div class="d-flex">
                    <div>
                    @if (isset(Auth::user()->grup))
                        @if (Auth::user()->grup === Config::get('constants.grup.grup_superadmin'))
                        <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_superadmin') }}</span>
                        @elseif (Auth::user()->grup === Config::get('constants.grup.grup_dinas'))
                        <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_dinas') }}</span>
                        @elseif (Auth::user()->grup === Config::get('constants.grup.grup_sekolah'))
                        <span class="badge badge-pill badge-primary text-white mr-auto font-weight-bold">Level : {{ Config::get('constants.grupnama.grupnama_sekolah') }}</span>
                        @endif
                    @endif
                    <span class="badge badge-pill badge-info text-white mr-auto text-lg-left">Tahun : {{ Session::get('thang') }}</span>
                    </div>
                    <div class="ml-auto">
                    © 2023 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
                    </div>
                </div>
                @else
                © 2023 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
                @endif
            </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>

    <script>
        $(document).ready(function() {
            $(".alert").hide();
            // $("#myWish").click(function showAlert() {
            //     $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            //         $("#success-alert").slideUp(500);
            //     });
            // });
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>


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
    
        {{-- <!-- jQuery -->
        <script src="{{ asset('/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('/bootstrap/dist/js/tether.min.js') }}"></script>
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
        <!--slimscroll JavaScript -->
        <script src="{{ asset('/js/jquery.slimscroll.js') }}"></script>
        <!--Wave Effects -->
        <script src="{{ asset('/js/waves.js') }}"></script>
        <!--Counter js -->
        <script src="{{asset('/plugins/bower_components/waypoints/lib/jquery.waypoints.js')}}"></script>
        <script src="{{asset('/plugins/bower_components/counterup/jquery.counterup.min.js')}}"></script>
        <!--Morris JavaScript -->
        <script src="{{ asset('/plugins/bower_components/raphael/raphael-min.js') }}"></script>
        <script src="{{ asset('/plugins/bower_components/morrisjs/morris.js') }}"></script>
        <!-- Custom Theme JavaScript -->
        <script src="{{ asset('/js/custom.min.js') }}"></script>
        <script src="{{ asset('/js/dashboard1.js') }}"></script>
        <!-- Sparkline chart JavaScript -->
        <script src="{{asset('/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js')}}"></script>
        <script src="{{asset('/plugins/bower_components/toast-master/js/jquery.toast.js')}}"></script> --}}
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
        // </script> --}}

        <!-- jquery -->
        {{-- <script src="{{asset('/dist/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script> --}}
        <!-- tether -->
        <script src="{{asset('/bootstrap/dist/js/tether.min.js')}}"></script>
        <!-- boostrap js --> 
        <script src="{{asset('/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- bootstrap exstension -->
        <script src="{{asset('/dist/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js')}}"></script>


        <!--Style Switcher -->
        <script src="{{asset('/dist/plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>

        <script src="{{ asset('/js/customs.js') }}"></script>
        <script src="{{ asset('/js/popper/popper.min.js') }}"></script>
        {{-- <script src="{{ asset('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
        <script src="{{ asset('/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('/dist/js/waves.js') }}"></script>
        <script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('/dist/js/custom.min.js') }}"></script>
        <!-- <script src="{{ asset('/dist/js/sweetalert2.min.js') }}"></script> -->
        {{-- <script src="{{ asset('/node_modules/sweetalert/sweetalert.min.js') }}"></script> --}}
        <script src="{{ asset('/js/raphael/raphael-min.js') }}"></script>
        <script src="{{ asset('/js/morrisjs/morris.min.js') }}"></script>
        <script src="{{ asset('/js/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('/js/toast-master/js/jquery.toast.js') }}"></script>

        {{-- toastr js --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <!-- touchspin -->
        <script src="{{asset('/dist/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>

        <!-- switcher -->
        <script src="{{asset('/dist/plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>

        <script>
            $(document).ready(function() {
                // toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif
            });
    
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 700,
                "timeOut": 3000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "show",
                "hideMethod": "hide"
            }
        </script>

</body>
</html>