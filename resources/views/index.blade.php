<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
<!DOCTYPE html>
<html class="wide wow-animation desktop landscape rd-navbar-static-linked" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{ config('app.name', '-') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'favicon')) }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="index/scripts/css.css">
    <link rel="stylesheet" href="index/scripts/bootstrap.css">
    <link rel="stylesheet" href="index/scripts/fonts.css">
    <link rel="stylesheet" href="index/scripts/style.css">
    <style>
      .rd-navbar-aside.rd-navbar-static .rd-navbar-nav {
        background-color: {{ apps::gettemplate($mode, 'index_nav_bgcolor') }};
      }
    </style>
  </head>
  <body class="">
    <div class="preloader loaded">
      <div class="preloader-body">
        <div class="cssload-container">
          <div class="cssload-speeding-wheel"></div>
        </div>
        <p>{{ config('app.name', '-') }}</p>
      </div>
    </div>
    <div class="page animated" style="animation-duration: 500ms;">
      <section class="section section-relative section-header bg-image" id="home" style="background: url({{ asset('/default/assets/images/'.apps::gettemplate($mode, 'index_bg')) }}); background-size: cover ">
        <!-- Page Header-->
        <header class="section page-header header-absolute">
          <!-- RD Navbar-->
          <div class="rd-navbar-wrap" style="height: 75px;">
            <nav class="rd-navbar rd-navbar-aside rd-navbar-original rd-navbar-static" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
              <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1 toggle-original" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
              <div class="rd-navbar-collapse toggle-original-elements">
                <ul class="list rd-navbar-list">
                  <li><a class="icon icon-sm icon-bordered link-default fa fa-question-circle" href="javascript:;" title="FAQ"></a></li>
                  <li><a class="icon icon-sm icon-bordered link-default fa fa-download" href="javascript:;" title="Download"></a></li>
                  <li><a class="icon icon-sm icon-bordered link-default fa fa-play-circle" href="javascript:;" title="Video"></a></li>
                </ul>
              </div>
              <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                  <!-- RD Navbar Panel-->
                  <div class="rd-navbar-panel">
                    <!-- RD Navbar Toggle-->
                    <button class="rd-navbar-toggle toggle-original" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                    <!-- RD Navbar Brand-->
                    <div class="rd-navbar-brand"><a class="brand" href="#"><img class="brand-logo-dark" src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index')) }}" alt="" srcset="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index')) }} 2x" width="153" height="36"><img class="brand-logo-light" src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index_inverse')) }}" alt="" srcset="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index_inverse')) }} 2x" width="306" height="72"></a>
                    </div>
                  </div>
                  <div class="rd-navbar-nav-wrap toggle-original-elements">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="#home"></a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#about">Info</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#news">Dasar Hukum</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#products">Jenis</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#gallery">Galeri</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#contacts">Hubungi Kami</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </header>
        <!-- Preview section-->
        <section class="section context-dark section-jumbotron">
          <div class="panel-left"><a class="brand" href="#"><img class="brand-logo-dark" src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index2')) }}" alt="" srcset="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index')) }} 2x" width="153" height="36"><img class="brand-logo-light" src="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index_inverse')) }}" alt="" srcset="{{ asset('/default/assets/images/'.apps::gettemplate($mode, 'logo_index_inverse')) }} 2x" width="306" height="72"></a>
            <ul class="list custom-list wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
              <li><a class="icon icon-sm icon-gray-filled icon-circle fa fa-question-circle" href="javascript:;" title="FAQ"></a></li>
              <li><a class="icon icon-sm icon-gray-filled icon-circle fa fa-download"  href="javascript:;" title="Download"></a></li>
              <li><a class="icon icon-sm icon-gray-filled icon-circle fa fa-play-circle"  href="javascript:;" title="Video"></a></li>
            </ul>
          </div>
          <div class="section-fullheight">
            <div class="section-fullheight-inner section-sm text-center text-lg-left">
              <div class="container">
                <div class="row justify-content-center justify-content-lg-start">
                  <div class="col-md-10 offset-lg-1 col-lg-8 offset-xl-1 col-xl-8 offset-xxl-2 col-xxl-7 offset-top-0-xxl-225">
                    <div class="jumbotron-custom-1">
                      <div class="text-1 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">{{ config('app.name', '-') }}</div>
                      <div class="offset-top-40 wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;">
                        <h2 class="font-weight-lighter">Sistem</h2>
                        <h3 class="font-weight-bold font-italic">Pengelolaan</h3>
                        <h2 class="font-weight-bold">Dana Kapitasi</h2>
                      </div>
                      <p class="title-text wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">Dana kapitasi adalah besaran pembayaran per bulan yang dibayar kepada FKTP berdasarkan jumlah peserta yang terdaftar tanpa memperhitungkan jenis dan jumlah pelayanan kesehatan yang diberikan.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ul class="project-list">
            <li class="bg-image" style="background-image: url(index/images/mis.jpg)"><a href="{{ route('home') }}">Sistem Informasi Pengelolaan</a></li>
            <li class="bg-image" style="background-image: url(index/images/eis.jpg)"><a href="{{ route('executive') }}">Sistem Informasi Eksekutif</a></li>
            <li class="bg-image" style="background-image: url(index/images/reg.jpg)"><a href="{{ env('REGISTRASI_URL') }}">Registrasi Aplikasi</a></li>
          </ul>
        </section>
      </section>
      <section class="section section-lg bg-default text-center text-sm-left section-lined" id="about">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <div class="container">
          <div class="row row-40">
            <div class="col-lg-9">
              <div class="row row-30 row-xxl-85">
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Master Data</h5>
                  <ul class="list-xs list-modern">
                    <li>Wilayah</li>
                    <li>FKTP</li>
                    <li>dst</li>
                  </ul>
                </div>
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Perencanaan</h5>
                  <ul class="list-xs list-modern">
                    <li>Rencana Pengelolaan Dana</li>
                    <li>RKAS</li>
                    <li>dst</li>
                  </ul>
                </div>
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Penatausahaan</h5>
                  <ul class="list-xs list-modern">
                    <li>Notifikasi Transfer</li>
                    <li>SP2DK</li>
                    <li>dst</li>
                  </ul>
                </div>
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Pertanggungjawaban</h5>
                  <ul class="list-xs list-modern">
                    <li>SPTJM</li>
                    <li>KPJ</li>
                    <li>dst</li>
                  </ul>
                </div>
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Pelaporan</h5>
                  <ul class="list-xs list-modern">
                    <li>Laporan Kapitasi</li>
                    <li>Laporan Akuntansi</li>
                    <li>dst</li>
                  </ul>
                </div>
                <div class="col-sm-6 col-md-4 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                  <h5>Pengaturan</h5>
                  <ul class="list-xs list-modern">
                    <li>Akses</li>
                    <li>Pengguna</li>
                    <li>dst</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-3 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
              <div class="heading-4 font-weight-bold text-lg-right">Apa itu {{ config('app.name', '-') }}?</div>
              <p class="text-lg-right paragraph-custom-2">Sistem Informasi Dana Kapitasi atau disebut dengan {{ config('app.name', '-') }} merupakan sebuah Sistem Aplikasi yang digunakan untuk mencatat transaksi keuangan atas dana kapitasi di lingkungan FKTP Puskesmas. Aplikasi {{ config('app.name', '-') }} dirancang secara sistematis guna memenuhi kebutuhan pelaporan Dana Kapitasi di tingkat FKTP Puskesmas.</p>
            </div>
          </div>
        </div>
      </section>
      <!-- News-->
      <section class="section section-lg bg-gray-100 section-lined" id="news">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <div class="container">
          <h4 class="text-center font-weight-bold offset-bottom-xl-10">Dasar Hukum</h4>
          <div class="row row-40">
            <div class="col-lg-12">
              <div class="row">
                  <h5>Paraturan Menteri Kesehatan Republik Indonesia Nomor 21 Tahun 2016</h5>
                  <ul class="list-xs list-modern">
                    <li>Tentang Penggunaan Dana Kapitasi Jaminan Kesehatan Nasional Untuk Jasa Pelayanan Kesehatan Dan Dukungan Biaya Operasional pada Fasilitas Kesehatan Tingkat Pertama Milik Pemerintah Daerah</li>
                  </ul>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">
                  <h5>Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 28 Tahun 2021</h5>
                  <ul class="list-xs list-modern">
                    <li>Tentang Pencatatan Pengesahan Dana Kapitasi Jaminan Kesehatan Nasional pada Fasilitas Kesehatan Tingkat Pertama Milik Pemerintah Daerah</li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- New products-->
      <section class="section section-lg bg-gray-200 section-lined" id="products">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <div class="container">
          <h4 class="text-center font-weight-bold offset-bottom-xl-10">Jenis</h4>
          <div class="row row-40">
            <div class="col-lg-12">
              <div class="row">
                  <h5>Coming Soon</h5>
                  <ul class="list-xs list-modern">
                    <li>wait for us...</li>
                  </ul>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">
                  <h5>Coming Soon</h5>
                  <ul class="list-xs list-modern">
                    <li>wait for us...</li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- GMP-->
      <section class="section section-lg bg-default section-lined" id="gallery">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <div class="container">
          <h4 class="text-center font-weight-bold offset-bottom-xl-10">Galeri</h4>
          <div class="row row-40">
            <div class="col-lg-12">
              <div class="row text-center">
                  <h5>Coming Soon</h5>
                  <ul class="list-xs list-modern">
                    <li>wait for us...</li>
                  </ul>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row text-center">
                  <h5>Coming Soon</h5>
                  <ul class="list-xs list-modern">
                    <li>wait for us...</li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Get in touch-->
      <section class="section section-md wow fadeIn section-lined bg-gray-100" id="contacts" data-wow-delay="0.2s" style="visibility: hidden; animation-delay: 0.2s; animation-name: none;">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <div class="container">
          <h4 class="font-weight-bold">Hubungi Kami</h4>
          <p class="big">Silakan hubungi kami untuk mengetahui lebih jauh tentang {{ config('app.name', '-') }}. <br class="d-none d-lg-inline">Kami akan terbuka dalam menjawab pertanyaan Anda.</p>
          <!-- RD Mailform-->
          <form class="rd-form rd-mailform bg-gray-100" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php" novalidate="novalidate">
            <div class="row row-50">
              <div class="col-lg-4">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-account-outline"></div>
                  <input class="form-input form-control-has-validation" id="contact-name" type="text" name="name" data-constraints="@Required"><span class="form-validation"></span>
                  <label class="form-label rd-input-label" for="contact-name">Nama</label>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-email-outline"></div>
                  <input class="form-input form-control-has-validation" id="contact-email" type="email" name="email" data-constraints="@Email @Required"><span class="form-validation"></span>
                  <label class="form-label rd-input-label" for="contact-email">E-mail</label>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-phone"></div>
                  <input class="form-input form-control-has-validation" id="contact-phone" type="text" name="phone" data-constraints="@Numeric"><span class="form-validation"></span>
                  <label class="form-label rd-input-label" for="contact-phone">No. HP</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-message-outline"></div>
                  <label class="form-label rd-input-label" for="contact-message">Pesan</label>
                  <textarea class="form-input form-control-has-validation form-control-last-child" id="contact-message" name="message" data-constraints="@Required"></textarea><span class="form-validation"></span>
                </div>
              </div>
              <div class="col-md-12">
                <button class="button button-default" type="submit">Kirim</button>
              </div>
            </div>
          </form>
        </div>
      </section>
      <!-- Page Footer-->
      <div class="pre-footer-classic bg-gray-700 context-dark">
        <div class="container">
          <div class="row row-30 justify-content-lg-between">
            <div class="col-sm-6 col-lg-3 col-xl-3">
              <h5 class="font-weight-bold text-uppercase">Alamat</h5>
              <ul class="list list-sm">
                <li>
                  <p>{{ apps::gettemplate($mode, 'comp_address') }}</p>
                </li>
                <li>
                  <p>{{ apps::gettemplate($mode, 'comp_city') }} {{ apps::gettemplate($mode, 'comp_postal_code') }}</p>
                </li>
                <li>
                  <p>{{ apps::gettemplate($mode, 'comp_country') }}</p>
                </li>
              </ul>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3">
              <h5 class="font-weight-bold text-uppercase">Kontak</h5>
              <dl class="list-terms-custom">
                <dt>Telp</dt>
                <dd><a class="link-default" href="tel:{{ apps::gettemplate($mode, 'comp_telp') }}">{{ apps::gettemplate($mode, 'comp_telp_all') }}</a></dd>
              </dl>
              <dl class="list-terms-custom">
                <dt>Fax</dt>
                <dd><a class="link-default" href="fax:{{ apps::gettemplate($mode, 'comp_fax') }}">{{ apps::gettemplate($mode, 'comp_fax_all') }}</a></dd>
              </dl>
              <dl class="list-terms-custom">
                <dt>E-mail</dt>
                <dd><a class="link-default" href="mailto:{{ apps::gettemplate($mode, 'comp_email') }}">{{ apps::gettemplate($mode, 'comp_email') }}</a></dd>
              </dl>
              <dl class="list-terms-custom">
                <dt>E-mail Pengaduan</dt>
                <dd><a class="link-default" href="mailto:{{ apps::gettemplate($mode, 'comp_email_helpdesk') }}">{{ apps::gettemplate($mode, 'comp_email_helpdesk') }}</a></dd>
              </dl>
              <ul class="list-inline list-inline-sm">
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-facebook" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-instagram" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-behance" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-twitter" href="#"></a></li>
              </ul>
            </div>
            <div class="col-lg-4">
              <h5 class="font-weight-bold text-uppercase">Newsletter</h5>
              <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php" novalidate="novalidate">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-email-outline"></div>
                  <input class="form-input form-control-has-validation" id="footer-email" type="email" name="email" data-constraints="@Email @Required"><span class="form-validation"></span>
                  <label class="form-label rd-input-label" for="footer-email">E-mail</label>
                </div>
                <div class="button-wrap">
                  <button class="button button-default button-invariable" type="submit">Kirim</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <footer class="section footer-classic context-dark text-center">
        <div class="container">
          <div class="row row-15 justify-content-lg-between">
            <div class="col-lg-4 col-xl-3 text-lg-left">
              <p class="rights"><span>©&nbsp;</span><span class="copyright-year">2021</span><span>&nbsp;</span><span>{{ config('app.name', '-') }}</span></p>
            </div>
            <div class="col-lg-5 col-xl-6">
              <ul class="list-inline list-inline-lg text-uppercase">
                <li><a class="small-2 font-weight-regular" href="#about">Info</a></li>
                <li><a class="small-2 font-weight-regular" href="#gallery">Galeri</a></li>
                <li><a class="small-2 font-weight-regular" href="#contacts">Hubungi Kami</a></li>
              </ul>
            </div>
            <div class="col-lg-3 text-lg-right"></div>
          </div>
        </div>
      </footer>
    </div>
    <div class="snackbars" id="form-output-global"></div>
    <script src="index/scripts/core.js"></script>
    <script src="index/scripts/script.js"></script>
<a href="#home" id="ui-to-top-" class="ui-to-top fa fa-angle-up"></a>
</body></html>