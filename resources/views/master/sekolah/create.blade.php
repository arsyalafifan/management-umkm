<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5><hr />
            @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </p>
            @endforeach
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <form method="POST" action="{{ route('sekolah.store') }}" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-sm-12 p-4">
                        <div id="exampleBasic2" class="wizard">
                            <ul class="wizard-steps" role="tablist">
                                <li class="active" role="tab">
                                    <h4><span><i class="ti-user"></i></span>Identitas Sekolah</h4>
                                </li>
                                <li role="tab">
                                    <h4><span><i class="ti-credit-card"></i></span>Upload Data</h4>
                                </li>
                                <li role="tab">
                                    <h4><span><i class="ti-check"></i></span>Data Pelengkap</h4>
                                </li>
                            </ul>
                            <div class="wizard-content p-4">
                                <div class="wizard-pane active" role="tabpanel">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="namasekolah" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sekolah *') }}</label>
                
                                                <div class="col-md-12">
                                                    <input id="namasekolah" type="text" class="form-control @error('namasekolah') is-invalid @enderror" name="namasekolah" value="{{ old('namasekolah') }}" autocomplete="namasekolah" autofocus>
                                                    @if ($errors->has('namasekolah'))
                                                    @error('namasekolah')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    {{-- @else
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Nama Instansi harus diisi</strong>
                                                    </span> --}}
                                                    @endif
                                                </div>
                                            </div>
                
                                            <div class="col-md-6">
                                                <label for="npsn" class="col-md-12 col-form-label text-md-left">{{ __('NPSN *') }}</label>
                
                                                <div class="col-md-12">
                                                    <input id="npsn" type="text" class="form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn') }}" autocomplete="name">
                
                                                    @if ($errors->has('npsn'))
                                                    @error('npsn')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    {{-- @else
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Alamat harus diisi</strong>
                                                    </span> --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="jenjang" class="col-md-12 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                                                <select id="jenjang" class="col-md-12 custom-select form-control" name='jenjang'>
                                                    <option value="">-- Pilih Jenjang --</option>
                                                        <option value="{{enum::JENJANG_SMA}}">{{  enum::JENJANG_DESC_SMA }}</option>
                                                        <option value="{{enum::JENJANG_SMK}}">{{  enum::JENJANG_DESC_SMK }}</option>
                                                        <option value="{{enum::JENJANG_SLB}}">{{  enum::JENJANG_DESC_SLB }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>
                                                <select id="jenis" class="col-md-12 custom-select form-control" name='jenis'>
                                                    <option value="">-- Pilih Jenis --</option>
                                                        <option value="{{enum::JENIS_NEGERI}}">{{  enum::JENIS_DESC_NEGERI }}</option>
                                                        <option value="{{enum::JENIS_SWASTA}}">{{  enum::JENIS_DESC_SWASTA }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>
            
                                                <div class="col-md-12">
                                                    <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" autocomplete="alamat">
                                                    @if ($errors->has('alamat'))
                                                    @error('alamat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    {{-- @else
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Nama Instansi harus diisi</strong>
                                                    </span> --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="kota" class="col-md-12 col-form-label text-md-left">{{ __('Kab / Kota') }}</label>
                                                <select id="kota" class="col-md-12 custom-select form-control" name='kota'>
                                                    <option value="">-- Pilih kota / Kab --</option>
                                                    @foreach ($kota as $item)
                                                        <option value="{{$item->kotaid}}">{{  $item->kodekota . ' ' . $item->namakota }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="kecamatan" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                                                <select id="kecamatan" class="col-md-12 custom-select form-control" name='kecamatan'>
                                                    <option value="">-- Pilih kota / Kab --</option>
                                                    @foreach ($kecamatan as $item)
                                                        <option value="{{$item->kecamatanid}}">{{  $item->kodekec . ' ' . $item->namakec }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="lintang" class="col-md-10 col-form-label text-md-left">Posisi geografis (Lintang)</label>
                                                <input class="form-control" type="number" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline" value="{{ old('lintang') }}" name="lintang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="bujur" class="col-md-10 col-form-label text-md-left">Posisi geografis (Bujur)</label>
                                                <input class="form-control" type="number" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline" value="{{ old('bujur') }}" name="bujur">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="kurikulum" class="col-md-12 col-form-label text-md-left">{{ __('Kurikulum') }}</label>
                                                <select id="kurikulum" class="col-md-12 custom-select form-control" name='kurikulum'>
                                                    <option value="">-- Pilih Kurikulum --</option>
                                                        <option value="{{enum::KURIKULUM_13}}">{{  enum::KURIKULUM_DESC_13 }}</option>
                                                        <option value="{{enum::KURIKULUM_MERDEKA}}">{{  enum::KURIKULUM_DESC_MERDEKA }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="predikat" class="col-md-12 col-form-label text-md-left">{{ __('Predikat') }}</label>
                                                <select id="predikat" class="col-md-12 custom-select form-control" name='predikat'>
                                                    <option value="">-- Pilih Predikat --</option>
                                                        <option value="{{enum::SEKOLAH_PENGGERAK}}">{{  enum::SEKOLAH_DESC_PENGGERAK }}</option>
                                                        <option value="{{enum::SEKOLAH_ADIWIYATA}}">{{  enum::SEKOLAH_DESC_ADIWIYATA }}</option>
                                                        <option value="{{enum::SEKOLAH_RAMAH_ANAK}}">{{  enum::SEKOLAH_DESC_RAMAH_ANAK }}</option>
                                                        <option value="{{enum::SEKOLAH_SEHAT}}">{{  enum::SEKOLAH_DESC_SEHAT }}</option>
                                                        <option value="{{enum::SEKOLAH_KEPENDUDUKAN}}">{{  enum::SEKOLAH_DESC_KEPENDUDUKAN }}</option>
                                                        <option value="{{enum::SEKOLAH_RAWAN_BENCANA}}">{{  enum::SEKOLAH_DESC_RAWAN_BENCANA }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Akreditasi</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Akreditasi untuk menambah data </p>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="exampleModalLabel">Upload Akreditasi</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="akreditasi" class="control-label">Akreditasi</label>
                                                                    <input type="text" class="form-control" id="akreditasi">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="file" class="control-label">File:</label>
                                                                    <input type="file" class="form-control" id="fileAkreditasi">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            {{-- <button id="demo-btn-addrow" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <table id="demo-foo-addrow-akreditasi" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Akreditasi</th>
                                                            <th>File</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search2" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-akreditasi" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Akreditasi
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-akreditasi">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Sertifikat Lahan</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Sertifikat Lahan untuk menambah data </p>
                                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="exampleModalLabel">Sertifikat Lahan</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="serfifikat-lahan" class="control-label">Upload Sertifikat Lahan</label>
                                                                    <input type="text" class="form-control" id="sertifikatLahan">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="file" class="control-label">File:</label>
                                                                    <input type="file" class="form-control" id="fileSertifikatLahan">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            {{-- <button id="demo-btn-addrow-sertifikat-lahan" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <table id="demo-foo-addrow-sertifikat-lahan" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Sertifikat Lahan</th>
                                                            <th>File</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search3" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-sertifikat-lahan" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Sertifikat Lahan
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-sertifikat-lahan">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Master Plan Sekolah</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Master Plan Sekolah untuk menambah data </p>
                                            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="exampleModalLabel">Master Plan Sekolah</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="serfifikat-lahan" class="control-label">Upload Master Plan Sekolah</label>
                                                                    <input type="text" class="form-control" id="masterPlanSekolah">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="file" class="control-label">File:</label>
                                                                    <input type="file" class="form-control" id="fileMasterPlanSekolah">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            {{-- <button id="demo-btn-addrow-master-plan-sekolah" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <table id="demo-foo-addrow-master-plan-sekolah" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Master Plan Sekolah</th>
                                                            <th>File</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search4" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-master-plan-sekolah" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Master Plan Sekolah
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-master-plan-sekolah">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Jumlah Guru</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Jumlah Guru untuk menambah data </p>
                                                <table id="demo-foo-addrow-jumlah-guru" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Status Pegawai</th>
                                                            <th data-sort-initial="true" data-toggle="true">Jumlah Guru</th>
                                                            <th data-sort-initial="true" data-toggle="true">Jenis Kelamin</th>
                                                            <th data-sort-initial="true" data-toggle="true">Tahun Ajaran</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search5" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-jumlah-guru" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Jumlah Guru
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-jumlah-guru">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Jumlah Peserta Didik</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Jumlah Peserta Didik untuk menambah data </p>
                                                <table id="demo-foo-addrow-jumlah-peserta-didik" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Kelas</th>
                                                            <th data-sort-initial="true" data-toggle="true">Jumlah Peserta Didik</th>
                                                            <th data-sort-initial="true" data-toggle="true">Jenis Kelamin</th>
                                                            <th data-sort-initial="true" data-toggle="true">Tahun Ajaran</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search6" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-jumlah-peserta-didik" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Jumlah Peserta Didik
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-jumlah-peserta-didik">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="white-box">
                                                <h3 class="box-title m-b-0">Jumlah Rombel</h3>
                                                <p class="text-muted m-b-20">Klik Tambah Jumlah Rombel untuk menambah data </p>
                                                <table id="demo-foo-addrow-jumlah-rombel" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                                                    <thead>
                                                        <tr>
                                                            <th data-sort-initial="true" data-toggle="true">Kelas</th>
                                                            <th data-sort-initial="true" data-toggle="true">Jumlah Rombel</th>
                                                            <th data-sort-initial="true" data-toggle="true">Tahun Ajaran</th>
                                                            <th data-sort-ignore="true" class="min-width">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <div class="padding-bottom-15">
                                                        <div class="row">
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <div class="form-group">
                                                                    <input id="demo-input-search7" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 text-right m-b-20">
                                                                <button type="button" id="demo-btn-addrow-jumlah-rombel" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Jumlah Rombel
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <tbody id="tbody-jumlah-rombel">
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="text-right">
                                                                    <ul class="pagination">
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                        {{ __('Simpan') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sekolah.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sekolah') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        // $('#provid').select2().on('change', function() {
        //     if ($('#provid').val() == "") {
        //         $('#kodekota').val('');
        //     }
        //     else {
        //         var url = "{{ route('kota.nextno', ':parentid') }}"
        //         url = url.replace(':parentid', $('#provid').val());
        //         $.ajax({
        //             url:url,
        //             type:'GET',
        //             success:function(data) {
        //                 $('#kodekota').val(data);
        //             }
        //         });
        //     }
        // }).trigger('change');
    });
</script>

<!-- Form Wizard JavaScript -->
<script src="{{asset('/dist/plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js')}}"></script>

 <!-- foo table -->
 <script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
 <script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
 <script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>

 <script type="text/javascript">
     (function() {
         $('#exampleBasic').wizard({
             onFinish: function() {
                 alert('finish');
             }
         });
         $('#exampleBasic2').wizard({
             onFinish: function() {
                 $.ajax({
                         type: "CREATE",
                         cache:false,
                         url: "{{ route('tahunajaran.store') }}",
                         dataType: 'JSON',
                         data: {
                             "_token": $('meta[name="csrf-token"]').attr('content')
                         },
                         success: function(json){
                             var success = json.success;
                             var message = json.message;
                             var data = json.data;
                             console.log(data);
                         }
                     });     
             }
         });
         $('#exampleValidator').wizard({
             onInit: function() {
                 $('#validation').formValidation({
                     framework: 'bootstrap',
                     fields: {
                         username: {
                             validators: {
                                 notEmpty: {
                                     message: 'The username is required'
                                 },
                                 stringLength: {
                                     min: 6,
                                     max: 30,
                                     message: 'The username must be more than 6 and less than 30 characters long'
                                 },
                                 regexp: {
                                     regexp: /^[a-zA-Z0-9_\.]+$/,
                                     message: 'The username can only consist of alphabetical, number, dot and underscore'
                                 }
                             }
                         },
                         email: {
                             validators: {
                                 notEmpty: {
                                     message: 'The email address is required'
                                 },
                                 emailAddress: {
                                     message: 'The input is not a valid email address'
                                 }
                             }
                         },
                         password: {
                             validators: {
                                 notEmpty: {
                                     message: 'The password is required'
                                 },
                                 different: {
                                     field: 'username',
                                     message: 'The password cannot be the same as username'
                                 }
                             }
                         }
                     }
                 });
             },
             validator: function() {
                 var fv = $('#validation').data('formValidation');
 
                 var $this = $(this);
 
                 // Validate the container
                 fv.validateContainer($this);
 
                 var isValidStep = fv.isValidContainer($this);
                 if (isValidStep === false || isValidStep === null) {
                     return false;
                 }
 
                 return true;
             },
             onFinish: function() {
                 $('#validation').submit();
                 alert('finish');
             }
         });
 
         $('#accordion').wizard({
             step: '[data-toggle="collapse"]',
 
             buttonsAppendTo: '.panel-collapse',
 
             templates: {
                 buttons: function() {
                     var options = this.options;
                     return '<div class="panel-footer"><ul class="pager">' +
                         '<li class="previous">' +
                         '<a href="#' + this.id + '" data-wizard="back" role="button">' + options.buttonLabels.back + '</a>' +
                         '</li>' +
                         '<li class="next">' +
                         '<a href="#' + this.id + '" data-wizard="next" role="button">' + options.buttonLabels.next + '</a>' +
                         '<a href="#' + this.id + '" data-wizard="finish" role="button">' + options.buttonLabels.finish + '</a>' +
                         '</li>' +
                         '<li>' +
                         '<button type"submit" class="btn btn-info waves-effect waves-light m-r-10"> Simpan </button>' +
                         '</li>' +
                         '</ul></div>';
                 }
             },
 
             onBeforeShow: function(step) {
                 step.$pane.collapse('show');
             },
 
             onBeforeHide: function(step) {
                 step.$pane.collapse('hide');
             },
 
             onFinish: function() {
                 alert('finish');
             }
         });
     })();
 </script>

<!-- akreditasi -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search2').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-akreditasi');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-akreditasi').click(function() {

            //get the footable object
            var footable = addrow.data('footable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td><select id="akreditasi" class="col-md-12 custom-select form-control" name="akreditasi[]"><option value="">-- Pilih Akreditasi --</option><option value="{{enum::AKREDITASI_A}}">{{  enum::AKREDITASI_DESC_A }}</option><option value="{{enum::AKREDITASI_B}}">{{  enum::AKREDITASI_DESC_B }}</option><option value="{{enum::AKREDITASI_C}}">{{  enum::AKREDITASI_DESC_C }}</option><option value="{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}">{{  enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI }}</option></select></td><td><input type="file" class="form-control" name="fileakreditasi[]" id="fileakreditasi"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var akreditasi = document.getElementById("akreditasi").value;
            // var fileAkreditasi = document.getElementById("fileAkreditasi").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;
            // var table = document.getElementById("tbody");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = akreditasi;
            // row.insertCell(1).innerHTML = fileAkreditasi;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>

<!-- sertifikat lahan -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search3').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-sertifikat-lahan');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-sertifikat-lahan').click(function() {
            
            //get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow = '<tr><td><select id="sertifikatlahan" class="col-md-12 custom-select form-control" name="sertifikatlahan[]"><option value="">-- Pilih Sertifikat Lahan --</option><option value="{{enum::SERTIFIKAT_LAHAN_ADA}}">{{  enum::SERTIFIKAT_LAHAN_DESC_ADA }}</option><option value="{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}">{{  enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA }}</option></select></td><td><input type="file" class="form-control" name="filesertifikatlahan[]" id="filesertifikatlahan"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var sertifikatLahan = document.getElementById("sertifikatLahan").value;
            // var fileSertifikatLahan = document.getElementById("fileSertifikatLahan").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;

            // var table = document.getElementById("tbody-sertifikat-lahan");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = sertifikatLahan;
            // row.insertCell(1).innerHTML = fileSertifikatLahan;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>

<!-- master plan sekolah -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search4').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-master-plan-sekolah');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-master-plan-sekolah').click(function() {
            
            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow = '<tr><td><select id="masterplansekolah" class="col-md-12 custom-select form-control" name="masterplan[]"><option value="">-- Pilih Master Plan Sekolah --</option><option value="{{enum::MASTER_PLAN_SEKOLAH_ADA }}">{{  enum::MASTER_PLAN_SEKOLAH_DESC_ADA }}</option><option value="{{enum::MASTER_PLAN_SEKOLAH_BELUM_ADA }}">{{  enum::MASTER_PLAN_SEKOLAH_DESC_BELUM_ADA  }}</option></select></td><td><input type="file" class="form-control" name="filemasterplan[]" id="filemasterplansekolah"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var masterPlanSekolah = document.getElementById("masterPlanSekolah").value;
            // var fileMasterPlanSekolah = document.getElementById("fileMasterPlanSekolah").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;

            // var table = document.getElementById("tbody-master-plan-sekolah");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = masterPlanSekolah;
            // row.insertCell(1).innerHTML = fileMasterPlanSekolah;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>

<!-- jumlah guru -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search5').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-guru');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-guru').click(function() {
            
            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow = '<tr><td><select id="statuspegawai" class="col-md-12 custom-select form-control" name="statuspegawai[]"><option value="">-- Pilih Status Pegawai --</option><option value="{{enum::STATUS_GURU_PNS }}">{{  enum::STATUS_GURU_DESC_PNS }}</option><option value="{{enum::STATUS_GURU_PTK }}">{{ enum::STATUS_GURU_DESC_PTK  }}</option><option value="{{enum::STATUS_GURU_THL }}">{{ enum::STATUS_GURU_DESC_THL  }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahguru") }}" name="jumlahguru[]" placeholder="Contoh: 20"></td><td><select id="jeniskelaminguru" class="col-md-12 custom-select form-control" name="jeniskelaminguru[]"><option value="">-- Pilih Jenis Kelamin --</option><option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">{{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option><option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">{{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option></select></td><td><select id="tahunajaranguru" class="col-md-12 custom-select form-control" name="tahunajaranguru[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var masterPlanSekolah = document.getElementById("masterPlanSekolah").value;
            // var fileMasterPlanSekolah = document.getElementById("fileMasterPlanSekolah").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;

            // var table = document.getElementById("tbody-master-plan-sekolah");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = masterPlanSekolah;
            // row.insertCell(1).innerHTML = fileMasterPlanSekolah;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>

<!-- jumlah peserta didik -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search6').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-peserta-didik');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-peserta-didik').click(function() {
            
            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow = '<tr><td><select id="kelaspesertadidik" class="col-md-12 custom-select form-control" name="kelaspesertadidik[]"><option value="">-- Pilih Kelas --</option><option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option><option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option><option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahpesertadidik") }}" name="jumlahpesertadidik[]" placeholder="Contoh: 20"></td><td><select id="jeniskelaminpesertadidik" class="col-md-12 custom-select form-control" name="jeniskelaminpesertadidik[]"><option value="">-- Pilih Jenis Kelamin --</option><option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">{{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option><option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">{{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option></select></td><td><select id="tahunajaranpesertadidik" class="col-md-12 custom-select form-control" name="tahunajaranpesertadidik[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var masterPlanSekolah = document.getElementById("masterPlanSekolah").value;
            // var fileMasterPlanSekolah = document.getElementById("fileMasterPlanSekolah").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;

            // var table = document.getElementById("tbody-master-plan-sekolah");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = masterPlanSekolah;
            // row.insertCell(1).innerHTML = fileMasterPlanSekolah;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>

<!-- jumlah peserta didik -->
<script>
        $(window).on('load', function() {

        // Search input
        $('#demo-input-search7').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {filter: $(this).val()});
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-rombel');
        addrow.footable().on('click', '.delete-row-btn', function() {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-rombel').click(function() {
            
            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow = '<tr><td><select id="kelasrombel" class="col-md-12 custom-select form-control" name="kelasrombel[]"><option value="">-- Pilih Kelas --</option><option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option><option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option><option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahrombel") }}" name="jumlahrombel[]" placeholder="Contoh: 20"></td><td><select id="tahunajaranrombel" class="col-md-12 custom-select form-control" name="tahunajaranrombel[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            //add it
            footable.appendRow(newRow);

            // var masterPlanSekolah = document.getElementById("masterPlanSekolah").value;
            // var fileMasterPlanSekolah = document.getElementById("fileMasterPlanSekolah").value;
            // var deleteButton = '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>'
            // document.getElementById('akreditasiResult').innerHTML = akreditasi;

            // var table = document.getElementById("tbody-master-plan-sekolah");
            // var rowCount = table.rows.length;
            // var row = table.insertRow(rowCount);

            // row.insertCell(0).innerHTML = masterPlanSekolah;
            // row.insertCell(1).innerHTML = fileMasterPlanSekolah;
            // row.insertCell(2).innerHTML = deleteButton;


        });
    });
</script>
@endsection
