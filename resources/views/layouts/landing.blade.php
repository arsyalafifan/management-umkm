<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name', '-') }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'favicon')) }}">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400" rel="stylesheet" type="text/css">
        <!-- Core theme CSS (includes Bootstrap)-->
        {{-- <link href="css/styles.css" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="{{asset('dist/landing/css/styles.css')}}">
        <link href="{{ asset('/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
        <script src="{{ asset('/node_modules/sweetalert/sweetalert.min.js') }}"></script>
        <!-- select2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <style>
            * {
                padding:0;
                margin:0;
                -webkit-box-sizing:border-box;
                -moz-box-sizing:border-box;
                -box-sizing:border-box;
            }
            /* .mega-menu, .mega-menu >ul {
                position: relative;
                background-color: #333;
                height: 50px;
            } */
            .mega-menu >ul >li {
                display: inline-block;
                /* padding:15.5px 0; */
                overflow: hidden;
            }
            a{
                text-decoration: none;
            }
            .mega-menu >ul >li >a {
                /* padding:17px; */
                color:#eee;
                text-decoration: none !important;
            }
            /* .mega-menu >ul >li:hover {
                background-color: #10496f;
                -webkit-transition:ease 0.3s;
            } */
            .mega-menu .menu-detail {
                height: 0;
                visibility: hidden;
                opacity: 0;
                position: absolute;
            }
            .mega-menu >ul >li:hover >div.menu-detail {
                opacity: 1;
                height: 300px;
                width:100%;
                height: 100vh;
                visibility: visible;
                /* top:200px; */
                right:100;
                left: 0;
                z-index: 99;
                background-color: transparent;
                color:#fff;
                -webkit-transition:height 1s;
                -moz-transition:height 1s;
                transition:height 1s;
                /* border-top:3px solid #3399dd; */
                overflow: hidden;
            }

            .menu-detail .section {
                padding:20px;
            }

            .card-custom{
                background-color: #DDFDFC;
                color: #3500FF;
                height: 110px;
            }
        </style>
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-static" id="mainNav" style="{{ isset($p_nav_bg_color) ? 'background-color: '.$p_nav_bg_color.';' : ''}}">
            <div class="container">
                {{-- <a class="navbar-brand" href="#page-top"><img src="{{asset('/images/icon/landing/kepri.png')}}"  height="60" alt="..." style="top:0px; height:60px;" /></a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse flex-column mega-menu" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="{{route('index')}}">
                                <img width="60px" src="{{ asset('/images/icon/landing/beranda.png') }}" alt="">
                                Beranda
                            </a>
                        </li>
                        {{-- @if (isset($p_is_index) && $p_is_index) --}}
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="/">
                                <img width="60px" src="{{ asset('/images/icon/landing/beranda.png') }}" alt="">
                                Profile
                            </a>
                        </li>
                        {{-- @else --}}
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="/">
                                <img width="60px" src="{{ asset('/images/icon/landing/layanan_spakat.png') }}" alt="">
                                Layanan Spakat
                            </a>
                            <div class="menu-detail">
                                <div class="container-sm mt-5 text-center">
                                    <div class="row">
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Legalisir Pindah Rayon</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="{{ route('legalisir-dashboard') }}">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Legalisir Ijazah</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Legalisir Surat Keterangan Pengganti Ijazah</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Rekomendasi Perizinan Sekolah</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">PPDB</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Kenaikan JABFUNG Guru</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Kenaikan Gaji Berkala</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Penilaian Angka Kredit</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm m-2">
                                            <a href="">
                                                <div class="card p-3 card-custom">
                                                    <div class="card-body">
                                                      <h5 class="card-title">Pensium Guru</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {{-- @endif --}}
                        {{-- @if (!Auth::guest()) --}}
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="{{ route('sarpras-dashboard') }}">
                                <img width="60px" src="{{ asset('/images/icon/landing/sarpras.png') }}" alt="">
                                Sarpras
                            </a>
                        </li> 
                        {{-- @else --}}
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="">
                                <img width="60px" src="{{ asset('/images/icon/landing/layanan_ptk.png') }}" alt="">
                                PTK
                            </a>
                        </li> 
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="">
                                <img width="60px" src="{{ asset('/images/icon/landing/layanan_dokumen_kurikulum.png') }}" alt="">
                                Layanan Dokumen Kurikulum
                            </a>
                        </li> 
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="">
                                <img width="60px" src="{{ asset('/images/icon/landing/forum_interaksi.png') }}" alt="">
                                Peta Sebaran Sekolah
                            </a>
                        </li> 
                        <li class="nav-item nav-width">
                            <a class="nav-link" href="">
                                <img width="60px" src="{{ asset('/images/icon/landing/forum_interaksi.png') }}" alt="">
                                Forum Interaksi
                            </a>
                        </li> 
                        <li class="nav-item nav-width mr-2">
                            <a class="nav-link" href="">
                                <img width="60px" src="{{ asset('/images/icon/landing/bangunan.png') }}" alt="">
                                <p style="overflow: auto">
                                    Data pembangunan
                                </p>
                            </a>
                        </li> 
                        {{-- @endif --}}
                        
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; Riqcom Services 2023</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        {{-- <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a> --}}
                    </div>
                </div>
            </div>
        </footer>
        


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('dist/landing/js/scripts.js')}}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->

    </body>
</html>