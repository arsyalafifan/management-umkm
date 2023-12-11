<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">EDIT DATA</h5>
        <hr />
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

        <input type="hidden" name="sekolahid" value="{{ $sekolah->sekolahid }}" id="idsekolah">
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
                            <form method="POST" action="{{ route('sekolah.update', $sekolah->sekolahid )}}"
                                class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="namasekolah"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Nama Sekolah *') }}</label>

                                            <div class="col-md-12">
                                                <input id="namasekolah" type="text"
                                                    class="form-control @error('namasekolah') is-invalid @enderror"
                                                    name="namasekolah"
                                                    value="{{ old('namasekolah') ?? $sekolah->namasekolah }}"
                                                    autocomplete="namasekolah" autofocus>
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
                                            <label for="npsn"
                                                class="col-md-12 col-form-label text-md-left">{{ __('NPSN *') }}</label>

                                            <div class="col-md-12">
                                                <input id="npsn" type="text"
                                                    class="form-control @error('npsn') is-invalid @enderror" name="npsn"
                                                    value="{{ old('npsn')?? $sekolah->npsn }}" autocomplete="name">

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
                                            <label for="jenjang"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                                            <select id="jenjang" class="col-md-12 custom-select form-control"
                                                name='jenjang'>
                                                <option value="{{ old('jenjang') ?? $sekolah->jenjang }}">
                                                    {{ old('jenjang') ?? ($sekolah->jenjang == enum::JENJANG_SMA ? enum::JENJANG_DESC_SMA : ($sekolah->jenjang == enum::JENJANG_SMK ? enum::JENJANG_DESC_SMK : ($sekolah->jenjang == enum::JENJANG_SMK ? enum::JENJANG_DESC_SMK : "-- Pilih Jenjang --"))) }}
                                                </option>
                                                <option value="{{enum::JENJANG_SMA}}">{{  enum::JENJANG_DESC_SMA }}
                                                </option>
                                                <option value="{{enum::JENJANG_SMK}}">{{  enum::JENJANG_DESC_SMK }}
                                                </option>
                                                <option value="{{enum::JENJANG_SLB}}">{{  enum::JENJANG_DESC_SLB }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="jenis"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>
                                            <select id="jenis" class="col-md-12 custom-select form-control"
                                                name='jenis'>
                                                <option value="{{ old('jenis') ?? $sekolah->jenis }}">
                                                    {{ old('jenjang') ?? ($sekolah->jenis == enum::JENIS_NEGERI ? enum::JENIS_DESC_NEGERI : ($sekolah->jenjang == enum::JENIS_SWASTA ? enum::JENIS_DESC_SWASTA : "-- Pilih Jenjang --")) }}
                                                </option>
                                                <option value="{{enum::JENIS_NEGERI}}">{{  enum::JENIS_DESC_NEGERI }}
                                                </option>
                                                <option value="{{enum::JENIS_SWASTA}}">{{  enum::JENIS_DESC_SWASTA }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="alamat"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                                            <div class="col-md-12">
                                                <input id="alamat" type="text"
                                                    class="form-control @error('alamat') is-invalid @enderror"
                                                    name="alamat" value="{{ old('alamat') ?? $sekolah->alamat }}"
                                                    autocomplete="alamat">
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
                                            <label for="kota"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Kab / Kota') }}</label>
                                            <select id="kota" class="col-md-12 custom-select form-control" name='kota'>
                                                <option value="">-- Pilih kota / Kab --</option>
                                                @foreach ($kota as $item)
                                                <option value="{{$item->kotaid}}"
                                                    {{ $item->kotaid == $sekolah->kotaid ? 'selected' : '' }}>
                                                    {{  $item->kodekota . ' ' . $item->namakota }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="kecamatan"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                                            <select id="kecamatan" class="col-md-12 custom-select form-control"
                                                name='kecamatan'>
                                                <option value="">-- Pilih kota / Kab --</option>
                                                @foreach ($kecamatan as $item)
                                                <option value="{{$item->kecamatanid}}"
                                                    {{ $item->kecamatanid == $sekolah->kecamatanid ? 'selected' : '' }}>
                                                    {{  $item->kodekec . ' ' . $item->namakec }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="lintang" class="col-md-10 col-form-label text-md-left">Posisi
                                                geografis (Lintang)</label>
                                            <input class="form-control" type="number"
                                                data-bts-button-down-class="btn btn-default btn-outline"
                                                data-bts-button-up-class="btn btn-default btn-outline"
                                                value="{{ old('lintang') ?? $sekolah->lintang  }}" name="lintang">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="bujur" class="col-md-10 col-form-label text-md-left">Posisi
                                                geografis (Bujur)</label>
                                            <input class="form-control" type="number"
                                                data-bts-button-down-class="btn btn-default btn-outline"
                                                data-bts-button-up-class="btn btn-default btn-outline"
                                                value="{{ old('bujur') ?? $sekolah->bujur }}" name="bujur">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="kurikulum"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Kurikulum') }}</label>
                                            <select id="kurikulum" class="col-md-12 custom-select form-control"
                                                name='kurikulum'>
                                                <option value="">-- Pilih Kurikulum --</option>
                                                <option value="{{enum::KURIKULUM_13}}">{{  enum::KURIKULUM_DESC_13 }}
                                                </option>
                                                <option value="{{enum::KURIKULUM_MERDEKA}}">
                                                    {{  enum::KURIKULUM_DESC_MERDEKA }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="predikat"
                                                class="col-md-12 col-form-label text-md-left">{{ __('Predikat') }}</label>
                                            <select id="predikat" class="col-md-12 custom-select form-control"
                                                name='predikat'>
                                                <option value="">-- Pilih Predikat --</option>
                                                <option value="{{enum::SEKOLAH_PENGGERAK}}">
                                                    {{  enum::SEKOLAH_DESC_PENGGERAK }}</option>
                                                <option value="{{enum::SEKOLAH_ADIWIYATA}}">
                                                    {{  enum::SEKOLAH_DESC_ADIWIYATA }}</option>
                                                <option value="{{enum::SEKOLAH_RAMAH_ANAK}}">
                                                    {{  enum::SEKOLAH_DESC_RAMAH_ANAK }}</option>
                                                <option value="{{enum::SEKOLAH_SEHAT}}">{{  enum::SEKOLAH_DESC_SEHAT }}
                                                </option>
                                                <option value="{{enum::SEKOLAH_KEPENDUDUKAN}}">
                                                    {{  enum::SEKOLAH_DESC_KEPENDUDUKAN }}</option>
                                                <option value="{{enum::SEKOLAH_RAWAN_BENCANA}}">
                                                    {{  enum::SEKOLAH_DESC_RAWAN_BENCANA }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="wizard-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="white-box">
                                        <h3 class="box-title m-b-0">Akreditasi</h3>
                                        <p class="text-muted m-b-20">Klik Tambah Akreditasi untuk menambah data </p>
                                        {{-- <table id="demo-foo-addrow-akreditasi" class="table table-bordered table-hover toggle-circle" data-page-size="7">
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
                                                    @foreach($akreditasiBySekolahId as $key => $value)
                                                    <div class="modal fade" id="modal-akreditasi-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header d-flex">
                                                                    <h4 class="modal-title" id="exampleModalLabel">Upload Akreditasi</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="akreditasi" class="control-label">Akreditasi</label>
                                                                        <form method="POST" action="{{ route('sekolah.updateakreditasi', $value->akreditasiid )}}"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <select id="akreditasi" class="col-md-12 custom-select form-control"
                                            name="akreditasi">
                                            <option value="{{ $value->akreditasi }}">{{ $value->akreditasi }}</option>
                                            <option value="{{enum::AKREDITASI_A}}">{{  enum::AKREDITASI_DESC_A }}
                                            </option>
                                            <option value="{{enum::AKREDITASI_B}}">{{  enum::AKREDITASI_DESC_B }}
                                            </option>
                                            <option value="{{enum::AKREDITASI_C}}">{{  enum::AKREDITASI_DESC_C }}
                                            </option>
                                            <option value="{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}">
                                                {{  enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI }}</option>
                                        </select>
                                        </form>
                                    </div>
                                    <div class="form-group">
                                        <label for="file" class="control-label">File:</label>
                                        <input type="file" name="fileakreditasi" class="form-control"
                                            id="fileAkreditasi">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button value="SaveAkreditasi" type="sumbit" id="demo-btn-addrow"
                                        class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <tr>
                        <th>
                            {{ $value->akreditasi }}
                        </th>
                        <th>
                            {{ $value->fileakreditasi }}
                        </th>
                        <th>
                            <a class="btn btn-sm btn-success"
                                href="{{ route("sekolah.downloadakreditasifile", "1692607004_321.png") }}">Download</a>
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-akreditasi-edit">
                                Ubah
                            </a>
                        </th>
                    </tr>
                    @endforeach
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
                    </table> --}}
                    <div class="table-responsive">
                        {{-- <div class="text-right m-b-20">
                                                        <button type="button" id="demo-btn-addrow-akreditasi" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah Akreditasi
                                                        </button>
                                                    </div> --}}
                        <table class="table table-bordered yajra-datatable table-striped" id="akreditasi-table">
                            <thead>
                                <tr>
                                    <th>Akreditasi</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah akreditasi -->
                    <div class="modal fade" id="modal-akreditasi-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Akreditasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahAkreditasi" name="tambahAkreditasi"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="akreditasi" class="control-label">Akreditasi</label>
                                            <select id="akreditasi" class="col-md-12 form-control" name="akreditasi">
                                                <option value="" selected disabled>-- Pilih Akreditasi --</option>
                                                <option value="{{enum::AKREDITASI_A}}">{{  enum::AKREDITASI_DESC_A }}
                                                </option>
                                                <option value="{{enum::AKREDITASI_B}}">{{  enum::AKREDITASI_DESC_B }}
                                                </option>
                                                <option value="{{enum::AKREDITASI_C}}">{{  enum::AKREDITASI_DESC_C }}
                                                </option>
                                                <option value="{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}">
                                                    {{  enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fileakreditasi" class="control-label">File:</label>
                                            <input type="file" name="fileakreditasi" class="form-control"
                                                id="fileakreditasi">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storeAkreditasi" type="submit" id="storeAkreditasi"
                                                class="btn btn-primary storeAkreditasi"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit akreditasi -->
                    <div class="modal fade" id="modal-akreditasi-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Akreditasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editAkreditasi" name="editAkreditasi"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="akreditasi" class="control-label">Akreditasi</label>
                                            <select id="akreditasi" class="col-md-12 form-control" name="akreditasi">
                                                <option value="" selected disabled>-- Pilih Akreditasi --</option>
                                                <option value="{{enum::AKREDITASI_A}}">{{  enum::AKREDITASI_DESC_A }}
                                                </option>
                                                <option value="{{enum::AKREDITASI_B}}">{{  enum::AKREDITASI_DESC_B }}
                                                </option>
                                                <option value="{{enum::AKREDITASI_C}}">{{  enum::AKREDITASI_DESC_C }}
                                                </option>
                                                <option value="{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}">
                                                    {{  enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fileakreditasi" class="control-label">File:</label>
                                            <input type="file" name="fileakreditasi" class="form-control"
                                                id="fileakreditasi">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updateAkreditasi" type="submit" id="updateAkreditasi"
                                                class="btn btn-primary updateAkreditasi"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sertifikat Lahan</h3>
                    <p class="text-muted m-b-20">Klik Tambah Sertifikat Lahan untuk menambah data </p>
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">Sertifikat Lahan</h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="serfifikat-lahan" class="control-label">Upload Sertifikat
                                                Lahan</label>
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
                    {{-- <table id="demo-foo-addrow-sertifikat-lahan" class="table table-bordered table-hover toggle-circle" data-page-size="7">
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
                                                </table> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="sertifikat-lahan-table">
                            <thead>
                                <tr>
                                    <th>Sertifikat Lahan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah Sertifikat Lahan -->
                    <div class="modal fade" id="modal-sertifikat-lahan-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Sertifikat Lahan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahSertifikatLahan" name="tambahSertifikatLahan"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="sertifikatlahan" class="control-label">Sertifikat Lahan</label>
                                            <select id="sertifikatlahan" class="col-md-12 form-control"
                                                name="sertifikatlahan">
                                                <option value="">-- Pilih Sertifikat Lahan --</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_ADA }}</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="filesertifikatlahan" class="control-label">File:</label>
                                            <input type="file" name="filesertifikatlahan" class="form-control"
                                                id="filesertifikatlahan">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storeSertifikatLahan" type="submit" id="storeSertifikatLahan"
                                                class="btn btn-primary storeSertifikatLahan"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit sertifikat lahan -->
                    <div class="modal fade" id="modal-sertifikat-lahan-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Sertifikat Lahan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editSertifikatLahan" name="editSertifikatLahan"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="sertifikatlahan" class="control-label">Sertifikat Lahan</label>
                                            <select id="sertifikatlahan" class="col-md-12 form-control"
                                                name="sertifikatlahan">
                                                <option value="">-- Pilih Sertifikat Lahan --</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_ADA }}</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="filesertifikatlahan" class="control-label">File:</label>
                                            <input type="file" name="filesertifikatlahan" class="form-control"
                                                id="filesertifikatlahan">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updateSertifikatLahan" type="submit"
                                                id="updateSertifikatLahan"
                                                class="btn btn-primary updateSertifikatLahan"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Master Plan Sekolah</h3>
                    <p class="text-muted m-b-20">Klik Tambah Master Plan Sekolah untuk menambah data </p>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="master-plan-table">
                            <thead>
                                <tr>
                                    <th>Master Plan Sekolah</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah master plan sekolah -->
                    <div class="modal fade" id="modal-master-plan-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Master Plan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahMasterPlan" name="tambahMasterPlan"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="masterplan" class="control-label">Sertifikat Lahan</label>
                                            <select id="masterplan" class="col-md-12 form-control" name="masterplan">
                                                <option value="">-- Pilih Master Plan Sekolah --</option>
                                                <option value="{{enum::MASTER_PLAN_SEKOLAH_ADA }}">
                                                    {{  enum::MASTER_PLAN_SEKOLAH_DESC_ADA }}</option>
                                                <option value="{{enum::MASTER_PLAN_SEKOLAH_BELUM_ADA }}">
                                                    {{  enum::MASTER_PLAN_SEKOLAH_DESC_BELUM_ADA  }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="filemasterplan" class="control-label">File:</label>
                                            <input type="file" name="filemasterplan" class="form-control"
                                                id="filemasterplan">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storeMasterPlan" type="submit" id="storeMasterPlan"
                                                class="btn btn-primary storeMasterPlan"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit master plan -->
                    <div class="modal fade" id="modal-master-plan-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Master Plan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editMasterPlan" name="editMasterPlan"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="masterplan" class="control-label">Sertifikat Lahan</label>
                                            <select id="masterplan" class="col-md-12 form-control" name="masterplan">
                                                <option value="">-- Pilih Sertifikat Lahan --</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_ADA }}</option>
                                                <option value="{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}">
                                                    {{  enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="filemasterplan" class="control-label">File:</label>
                                            <input type="file" name="filemasterplan" class="form-control"
                                                id="filemasterplan">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updateMasterPlan" type="submit" id="updateMasterPlan"
                                                class="btn btn-primary updateMasterPlan"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="jumlah-guru-table">
                            <thead>
                                <tr>
                                    <th>Status Pegawai</th>
                                    <th>Jumlah Guru</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah jumlah guru -->
                    <div class="modal fade" id="modal-jumlah-guru-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Jumlah Guru</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahJumlahGuru" name="tambahJumlahGuru"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="statuspegawai" class="control-label">Status Pegawai</label>
                                            <select id="statuspegawai" class="col-md-12 form-control"
                                                name="statuspegawai">
                                                <option value="">-- Pilih Status Pegawai --</option>
                                                <option value="{{enum::STATUS_GURU_PNS }}">
                                                    {{  enum::STATUS_GURU_DESC_PNS }}</option>
                                                <option value="{{enum::STATUS_GURU_PTK }}">
                                                    {{ enum::STATUS_GURU_DESC_PTK  }}</option>
                                                <option value="{{enum::STATUS_GURU_THL }}">
                                                    {{ enum::STATUS_GURU_DESC_THL  }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahguru" class="control-label">Jumlah Guru</label>
                                            <input class="form-control" type="number" value="{{ old("jumlahguru") }}"
                                                id="jumlahguru" name="jumlahguru" placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="jeniskelamin" class="control-label">Jenis Kelamin</label>
                                            <select id="jeniskelaminguru" class="col-md-12 form-control"
                                                name="jeniskelamin">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">
                                                    {{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option>
                                                <option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">
                                                    {{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranid" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storeJumlahGuru" type="submit" id="storeJumlahGuru"
                                                class="btn btn-primary storeJumlahGuru"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit jumlah guru -->
                    <div class="modal fade" id="modal-jumlah-guru-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Master Plan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editJumlahGuru" name="editJumlahGuru"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="statuspegawai" class="control-label">Status Pegawai</label>
                                            <select id="statuspegawaiedit" class="col-md-12 form-control"
                                                name="statuspegawai">
                                                <option value="">-- Pilih Status Pegawai --</option>
                                                <option value="{{enum::STATUS_GURU_PNS }}">
                                                    {{  enum::STATUS_GURU_DESC_PNS }}</option>
                                                <option value="{{enum::STATUS_GURU_PTK }}">
                                                    {{ enum::STATUS_GURU_DESC_PTK  }}</option>
                                                <option value="{{enum::STATUS_GURU_THL }}">
                                                    {{ enum::STATUS_GURU_DESC_THL  }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahguru" class="control-label">Jumlah Guru</label>
                                            <input class="form-control" type="number" value="" name="jumlahguru"
                                                id="jumlahguruedit" placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="jeniskelamin" class="control-label">Jenis Kelamin</label>
                                            <select id="jeniskelaminguruedit" class="col-md-12 form-control"
                                                name="jeniskelamin">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">
                                                    {{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option>
                                                <option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">
                                                    {{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranguruedit" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updateJumlahGuru" type="submit" id="updateJumlahGuru"
                                                class="btn btn-primary updateJumlahGuru"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Jumlah Peserta Didik</h3>
                    <p class="text-muted m-b-20">Klik Tambah Jumlah Peserta Didik untuk menambah data </p>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped"
                            id="jumlah-peserta-didik-table">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Jumlah Peserta Didik</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah peserta didik -->
                    <div class="modal fade" id="modal-peserta-didik-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Peserta Didik</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahPesertaDidik" name="tambahPesertaDidik"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="kelaspesertadidik" class="control-label">Kelas</label>
                                            <select id="kelaspesertadidik" class="col-md-12 form-control" name="kelas">
                                                <option value="">-- Pilih Kelas --</option>
                                                <option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option>
                                                <option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option>
                                                <option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahpesertadidik" class="control-label">Jumlah Guru</label>
                                            <input class="form-control" id="jumlahpesertadidik" type="number"
                                                value="{{ old("jumlahpesertadidik") }}" name="jumlahpesertadidik"
                                                placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="jeniskelamin" class="control-label">Jenis Kelamin</label>
                                            <select id="jeniskelaminpesertadidik" class="col-md-12 form-control"
                                                name="jeniskelamin">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">
                                                    {{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option>
                                                <option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">
                                                    {{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranid" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storePesertaDidik" type="submit" id="storePesertaDidik"
                                                class="btn btn-primary storePesertaDidik"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit peserta didik -->
                    <div class="modal fade" id="modal-peserta-didik-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Peserta Didik</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editPesertaDidik" name="editPesertaDidik"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="kelaspesertadidik" class="control-label">Kelas</label>
                                            <select id="kelaspesertadidikedit" class="col-md-12 form-control"
                                                name="kelas">
                                                <option value="">-- Pilih Kelas --</option>
                                                <option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option>
                                                <option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option>
                                                <option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahpesertadidik" class="control-label">Jumlah Peserta
                                                Didik</label>
                                            <input class="form-control" id="jumlahpesertadidikedit" type="number"
                                                value="{{ old("jumlahpesertadidik") }}" name="jumlahpesertadidik"
                                                placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="jeniskelamin" class="control-label">Jenis Kelamin</label>
                                            <select id="jeniskelaminpesertadidikedit" class="col-md-12 form-control"
                                                name="jeniskelamin">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">
                                                    {{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option>
                                                <option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">
                                                    {{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranpesertadidikedit" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updatePesertaDidik" type="submit" id="updatePesertaDidik"
                                                class="btn btn-primary updatePesertaDidik"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Jumlah Rombel</h3>
                    <p class="text-muted m-b-20">Klik Tambah Jumlah Rombel untuk menambah data </p>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="jumlah-rombel-table">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Jumlah Rombel</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal tambah jumlah rombel -->
                    <div class="modal fade" id="modal-jumlah-rombel-tambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Tambah Jumlah Rombel</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="tambahJumlahRombel" name="tambahJumlahRombel"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sekolahid" value={{ $sekolah->sekolahid }}
                                            id="sekolahid" />
                                        <div class="form-group">
                                            <label for="kelasjumlahrombel" class="control-label">Kelas</label>
                                            <select id="kelasjumlahrombel" class="col-md-12 form-control" name="kelas">
                                                <option value="">-- Pilih Kelas --</option>
                                                <option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option>
                                                <option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option>
                                                <option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahrombel" class="control-label">Jumlah Rombel</label>
                                            <input class="form-control" id="jumlahrombel" type="number"
                                                value="{{ old("jumlahrombel") }}" name="jumlahrombel"
                                                placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranid" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="storeJumlahRombel" type="submit" id="storeJumlahRombel"
                                                class="btn btn-primary storeJumlahRombel"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal edit jumlah rombel -->
                    <div class="modal fade" id="modal-jumlah-rombel-edit" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" style="margin-top: 100px" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header d-flex">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Jumlah Rombel</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="editJumlahRombel" name="editJumlahRombel"
                                        class="form-horizontal form-material needs-validation"
                                        enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="form-group">
                                            <label for="kelasjumlahrombel" class="control-label">Kelas</label>
                                            <select id="kelasjumlahrombeledit" class="col-md-12 form-control"
                                                name="kelas">
                                                <option value="">-- Pilih Kelas --</option>
                                                <option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option>
                                                <option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option>
                                                <option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahrombel" class="control-label">Jumlah Rombel Didik</label>
                                            <input class="form-control" id="jumlahrombeledit" type="number"
                                                value="{{ old("jumlahrombel") }}" name="jumlahrombel"
                                                placeholder="Contoh: 20">
                                        </div>
                                        <div class="form-group">
                                            <label for="tahunajaranid" class="control-label">Tahun Ajaran</label>
                                            <select id="tahunajaranjumlahrombeledit" class="col-md-12 form-control"
                                                name="tahunajaranid">
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                @foreach ($tahunajaran as $item)
                                                <option value="{{$item->tahunajaranid}}">
                                                    {{  $item->daritahun . " - " . $item->sampaitahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button value="updateJumlahRombel" type="submit" id="updateJumlahRombel"
                                                class="btn btn-primary updatePesertaDidik"><i class="icon wb-plus"
                                                    aria-hidden="true"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button name="step[1]" value="SaveSekolah" type="submit" class="btn btn-info waves-effect waves-light m-r-10">
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
</div>
</div>
</div>


<!-- table akreditasi -->
<script>
    // tambah akreditasi
    $(document).on('submit', '#tambahAkreditasi', function (e) {
        e.preventDefault();

        let formData = new FormData($('#tambahAkreditasi')[0]);

        let url = "{{ route('sekolah.storeakreditasi') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (json) {
                var success = json.success;
                var message = json.message;
                var data = json.akreditasi;

                akreditasitable.draw();
                $('#fileakreditasi').val('');
                $('#akreditasi').val('');
                $('#editAkreditasi').trigger("reset");
                $('#modal-akreditasi-tambah').modal('hide');
                console.log(url);
                console.log(fileakreditasi);

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data akreditasi ditambah.", "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    // edit akreditasi
    $(document).on('submit', '#editAkreditasi', function (e) {
        e.preventDefault();
        var id = akreditasitable.rows({
            selected: true
        }).data()[0]['akreditasiid'];

        let formData = new FormData($('#editAkreditasi')[0]);

        var url = "{{ route('sekolah.updateakreditasi', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (json) {
                var success = json.success;
                var message = json.message;
                var data = json.akreditasi;

                akreditasitable.draw();
                $('#fileakreditasi').val('');
                $('#akreditasi').val('');
                $('#editAkreditasi').trigger("reset");
                $('#modal-akreditasi-edit').modal('hide');
                console.log(url);
                console.log(fileakreditasi);

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data akreditasi diubah.", "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
        }
    });

    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    let akreditasitable = $('#akreditasi-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: function (response) {
                response.recordsTotal = response.data.countAkreditasi;
                response.recordsFiltered = response.data.countAkreditasi;
                return response.data.akreditasi;
            },
            data: function (d) {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: [{
                text: 'Tambah',
                className: 'tambah btn btn-primary btn-sm btn-datatable mb-3',
                action: function () {
                    $('#modal-akreditasi-tambah').modal('show');
                }
            },
            {
                text: 'Ubah',
                className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                action: function () {
                    if (akreditasitable.rows({
                            selected: true
                        }).count() <= 0) {
                        swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                        "error");
                        return;
                    }
                    var akreditasi = akreditasitable.rows({
                        selected: true
                    }).data()[0]['akreditasi']

                    // $('#akreditasi').val(akreditasi).attr('selected','selected');
                    $('#modal-akreditasi-edit').modal('show');
                    $('#akreditasi option[value="' + akreditasi + '"]').prop('selected', true);
                    // $('#fileakreditasi').val(fileakreditasi);
                }
            },
            {
                text: 'Hapus',
                className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                action: function () {
                    if (akreditasitable.rows({
                            selected: true
                        }).count() <= 0) {
                        Swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                            "error");
                        return;
                    }
                    var id = akreditasitable.rows({
                        selected: true
                    }).data()[0]['akreditasiid'];
                    var url = "{{ route('sekolah.hapusakreditasi', ':id') }}"
                    url = url.replace(':id', id);
                    var nama = akreditasitable.rows({
                        selected: true
                    }).data()[0]['akreditasi'];
                    Swal.fire({
                        title: "Apakah anda yakin akan menghapus Akreditasi " + nama + "?",
                        text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, lanjutkan!",
                        closeOnConfirm: false
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                cache: false,
                                url: url,
                                dataType: 'JSON',
                                data: {
                                    "_token": $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function (json) {
                                    var success = json.success;
                                    var message = json.message;
                                    var data = json.data;
                                    console.log(data);

                                    if (success == 'true' || success == true) {
                                        swal.fire("Berhasil!",
                                            "Data anda telah dihapus.",
                                            "success");
                                        akreditasitable.draw();
                                    } else {
                                        swal.fire("Error!", data, "error");
                                    }
                                }
                            });
                        }
                    });
                }
            },
            {
                text: 'Download',
                className: 'edit btn btn-success btn-sm btn-datatable mb-3',
                action: function () {
                    if (akreditasitable.rows({
                            selected: true
                        }).count() <= 0) {
                        swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload",
                            "error");
                        return;
                    }
                    let id = akreditasitable.rows({
                        selected: true
                    }).data()[0]['akreditasiid'];
                    let url = "{{ route('sekolah.downloadakreditasifile', ':id') }}"
                    url = url.replace(':id', id);
                    console.log(url);
                    let today = new Date();
                    let dateTime = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today
                        .getDate() + "_" + today.getHours() + today.getMinutes() + today.getSeconds();
                    let namaFile = `AKREDITASI_${dateTime}.jpeg`
                    $.ajax({
                        type: "GET",
                        cache: false,
                        processData: false,
                        contentType: false,
                        // defining the response as a binary file
                        xhrFields: {
                            responseType: 'blob'
                        },
                        url: url,
                        success: function (data) {
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = namaFile;
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        }
                    });
                }
            },
        ],
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'akreditasi',
                render: function (data, type, row) {
                    if (row.akreditasi != null) {
                        if (row.akreditasi == "{{enum::AKREDITASI_A}}")
                            return '{{enum::AKREDITASI_DESC_A}}';
                        else if (row.akreditasi == "{{enum::AKREDITASI_B}}")
                            return '{{enum::AKREDITASI_DESC_B}}';
                        else if (row.akreditasi == "{{enum::AKREDITASI_C}}")
                            return '{{enum::AKREDITASI_DESC_C}}';
                        else if (row.akreditasi == "{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}")
                            return '{{enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'akreditasi'
            },
            {
                'orderData': 2,
                data: 'fileakreditasi',
                name: 'fileakreditasi'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

    ;

</script>

<!-- table sertifikat lahan -->
<script>
    // tambah sertifikat lahan
    $(document).on('submit', '#tambahSertifikatLahan', (e) => {
        e.preventDefault();

        let formData = new FormData($('#tambahSertifikatLahan')[0]);

        let url = "{{ route('sekolah.storesertifikatlahan') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.sertifikatlahan;

                sertifikatlahantable.draw();
                $('#filesertifikatlahan').val('');
                $('#sertifikatlahan').val('');
                $('#tambahSertifikatLahan').trigger("reset");
                $('#modal-sertifikat-lahan-tambah').modal('hide');
                console.log(url);
                console.log(filesertifikatlahan);

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data sertifikat lahan berhasil ditambah.", "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    // edit akreditasi
    $(document).on('submit', '#editSertifikatLahan', function (e) {
        e.preventDefault();
        let id = sertifikatlahantable.rows({
            selected: true
        }).data()[0]['sertifikatlahanid'];

        let formData = new FormData($('#editSertifikatLahan')[0]);

        let url = "{{ route('sekolah.updatesertifikatlahan', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.akreditasi;

                sertifikatlahantable.draw();
                $('#filesertifikatlahan').val('');
                $('#sertifikatlahan').val('');
                $('#editSertifikatLahan').trigger("reset");
                $('#modal-sertifikat-lahan-edit').modal('hide');
                console.log(url);
                console.log(fileakreditasi);

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data sertifikat lahan berhasil diubah.", "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    let sertifikatlahantable = $('#sertifikat-lahan-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: function (response) {
                response.recordsTotal = response.data.countSertifikatLahan;
                response.recordsFiltered = response.data.countSertifikatLahan;
                return response.data.sertifikatLahan;
            },
            data: function (d) {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: {
            buttons: [{
                    text: 'Tambah',
                    className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
                    action: () => {
                        $('#modal-sertifikat-lahan-tambah').modal('show');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (sertifikatlahantable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                                "error");
                            return;
                        }
                        let sertifikatlahan = sertifikatlahantable.rows({
                            selected: true
                        }).data()[0]['sertifikatlahan']
                        $('#modal-sertifikat-lahan-edit').modal('show');
                        $('#sertifikatlahan option[value="' + sertifikatlahan + '"]').prop('selected',
                            true);
                    }
                },
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: () => {
                        if (sertifikatlahantable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                                "error");
                            return;
                        }
                        let id = sertifikatlahantable.rows({
                            selected: true
                        }).data()[0]['sertifikatlahanid'];
                        let url = "{{ route('sekolah.hapussertifikatlahan', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({
                            title: "Apakah anda yakin akan menghapus sertifikat lahan ini?",
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya, lanjutkan!",
                            closeOnConfirm: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache: false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: (json) => {
                                        let success = json.success;
                                        let message = json.message;
                                        let data = json.data;
                                        console.log(data);

                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!",
                                                "Data anda telah dihapus.",
                                                "success");
                                            sertifikatlahantable.draw();
                                        } else {
                                            swal.fire("Error!", data, "error");
                                        }
                                    }
                                });
                            }
                        });
                    }
                },
                {
                    text: 'Download',
                    className: 'edit btn btn-success btn-sm btn-datatable mb-3',
                    action: () => {
                        if (sertifikatlahantable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload",
                                "error");
                            return;
                        }
                        let id = sertifikatlahantable.rows({
                            selected: true
                        }).data()[0]['sertifikatlahanid'];
                        let url = "{{ route('sekolah.downloadsertifikatlahanfile', ':id') }}"
                        url = url.replace(':id', id);
                        console.log(url);
                        let today = new Date();
                        let dateTime = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today
                            .getDate() + "_" + today.getHours() + today.getMinutes() + today
                            .getSeconds();
                        let namaFile = `SERTIFIKAT_LAHAN_${dateTime}.jpeg`
                        $.ajax({
                            type: "GET",
                            cache: false,
                            processData: false,
                            contentType: false,
                            // defining the response as a binary file
                            xhrFields: {
                                responseType: 'blob'
                            },
                            url: url,
                            success: (data) => {
                                let a = document.createElement('a');
                                let url = window.URL.createObjectURL(data);
                                a.href = url;
                                a.download = namaFile;
                                document.body.append(a);
                                a.click();
                                a.remove();
                                window.URL.revokeObjectURL(url);
                            }
                        });
                    }
                },
            ]
        },
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'sertifikatlahan',
                render: function (data, type, row) {
                    if (row.sertifikatlahan != null) {
                        if (row.sertifikatlahan == "{{enum::SERTIFIKAT_LAHAN_ADA}}")
                            return '{{enum::SERTIFIKAT_LAHAN_DESC_ADA}}';
                        else if (row.sertifikatlahan == "{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}")
                            return '{{enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'sertifikatLahan'
            },
            {
                'orderData': 2,
                data: 'filesertifikatlahan',
                name: 'filesertifikatlahan'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

</script>

<!-- table master plan sekolah -->
<script>
    // tambah sertifikat lahan
    $(document).on('submit', '#tambahMasterPlan', (e) => {
        e.preventDefault();

        let formData = new FormData($('#tambahMasterPlan')[0]);

        let url = "{{ route('sekolah.storemasterplan') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.masterplan;

                masterplansekolahtable.draw();
                $('#filemasterplan').val('');
                $('#masterplan').val('');
                $('#tambahMasterPlan').trigger("reset");
                $('#modal-master-plan-tambah').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data master plan sekolah berhasil ditambah.",
                    "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    // edit akreditasi
    $(document).on('submit', '#editMasterPlan', function (e) {
        e.preventDefault();
        let id = masterplansekolahtable.rows({
            selected: true
        }).data()[0]['masterplanid'];

        let formData = new FormData($('#editMasterPlan')[0]);

        let url = "{{ route('sekolah.updatemasterplan', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.akreditasi;

                masterplansekolahtable.draw();
                $('#filemasterplan').val('');
                $('#masterplan').val('');
                $('#editMasterPlan').trigger("reset");
                $('#modal-master-plan-edit').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data master plan berhasil diubah.", "success");
                } else {
                    swal.fire("Peringatan!", message, "info");
                }
            }
        })
    })

    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    var masterplansekolahtable = $('#master-plan-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: function (response) {
                response.recordsTotal = response.data.countMasterPlan;
                response.recordsFiltered = response.data.countMasterPlan;
                return response.data.masterplan;
            },
            data: function (d) {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: {
            buttons: [{
                    text: 'Tambah',
                    className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
                    action: () => {
                        $('#modal-master-plan-tambah').modal('show');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (masterplansekolahtable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                                "error");
                            return;
                        }
                        let masterplan = masterplansekolahtable.rows({
                            selected: true
                        }).data()[0]['masterplan'];
                        $('#modal-master-plan-edit').modal('show');
                        $('#masterplan option[value="' + masterplan + '"]').prop('selected', true);
                    }
                },
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: () => {
                        if (masterplansekolahtable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                                "error");
                            return;
                        }
                        let id = masterplansekolahtable.rows({
                            selected: true
                        }).data()[0]['masterplanid'];
                        let url = "{{ route('sekolah.hapusmasterplan', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({
                            title: "Apakah anda yakin akan menghapus data master plan ini?",
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya, lanjutkan!",
                            closeOnConfirm: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache: false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: (json) => {
                                        let success = json.success;
                                        let message = json.message;
                                        let data = json.data;
                                        console.log(data);

                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!",
                                                "Data anda telah dihapus.",
                                                "success");
                                            masterplansekolahtable.draw();
                                        } else {
                                            swal.fire("Error!", data, "error");
                                        }
                                    }
                                });
                            }
                        });
                    }
                },
                {
                    text: 'Download',
                    className: 'edit btn btn-success btn-sm btn-datatable mb-3',
                    action: () => {
                        if (masterplansekolahtable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload",
                                "error");
                            return;
                        }
                        let id = masterplansekolahtable.rows({
                            selected: true
                        }).data()[0]['masterplanid'];
                        let url = "{{ route('sekolah.downloadmasterplanfile', ':id') }}"
                        url = url.replace(':id', id);
                        console.log(url);
                        let today = new Date();
                        let dateTime = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today
                            .getDate() + "_" + today.getHours() + today.getMinutes() + today
                            .getSeconds();
                        let namaFile = `MASTER_PLAN_SEKOLAH_${dateTime}.jpeg`
                        $.ajax({
                            type: "GET",
                            cache: false,
                            processData: false,
                            contentType: false,
                            // defining the response as a binary file
                            xhrFields: {
                                responseType: 'blob'
                            },
                            url: url,
                            success: (data) => {
                                let a = document.createElement('a');
                                let url = window.URL.createObjectURL(data);
                                a.href = url;
                                a.download = namaFile;
                                document.body.append(a);
                                a.click();
                                a.remove();
                                window.URL.revokeObjectURL(url);
                            }
                        });
                    }
                },
            ]
        },
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'masterplan',
                render: function (data, type, row) {
                    if (row.masterplan != null) {
                        if (row.masterplan == "{{enum::MASTER_PLAN_SEKOLAH_ADA}}")
                            return '{{enum::MASTER_PLAN_SEKOLAH_DESC_ADA}}';
                        else if (row.masterplan == "{{enum::MASTER_PLAN_SEKOLAH_BELUM_ADA}}")
                            return '{{enum::MASTER_PLAN_SEKOLAH_DESC_BELUM_ADA}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'masterplan'
            },
            {
                'orderData': 2,
                data: 'filemasterplan',
                name: 'filemasterplan'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

</script>

<!-- table jumlah guru -->
<script>
    // tambah jumlah guru
    $(document).on('submit', '#tambahJumlahGuru', (e) => {
        e.preventDefault();

        let formData = new FormData($('#tambahJumlahGuru')[0]);

        let url = "{{ route('sekolah.storejumlahguru') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.masterplan;

                jumlahgurutable.draw();
                $('#statuspegawai').val('');
                $('#jumlahguru').val('');
                $('#jeniskelamin').val('');
                $('#tahunajaranid').val('');
                $('#tambahJumlahGuru').trigger("reset");
                $('#modal-jumlah-guru-tambah').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data jumlah guru berhasil ditambah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })

    // edit jumlah guru
    $(document).on('submit', '#editJumlahGuru', function (e) {
        e.preventDefault();
        let id = jumlahgurutable.rows({
            selected: true
        }).data()[0]['jumlahguruid'];

        let formData = new FormData($('#editJumlahGuru')[0]);

        let url = "{{ route('sekolah.updatejumlahguru', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.akreditasi;

                jumlahgurutable.draw();
                $('#statuspegawaiedit').val('');
                $('#jumlahguruedit').val('');
                $('#jeniskelaminguruedit').val('');
                $('#tahunajaranguruedit').val('');
                $('#editJumlahGuru').trigger("reset");
                $('#modal-jumlah-guru-edit').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data master plan berhasil diubah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })

    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    let jumlahgurutable = $('#jumlah-guru-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: (response) => {
                response.recordsTotal = response.data.countJumlahGuru;
                response.recordsFiltered = response.data.countJumlahGuru;
                return response.data.jumlahguru;
            },
            data: (d) => {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: {
            buttons: [{
                    text: 'Tambah',
                    className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
                    action: () => {
                        $('#modal-jumlah-guru-tambah').modal('show');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (jumlahgurutable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                                "error");
                            return;
                        }
                        let statuspegawai = jumlahgurutable.rows({
                            selected: true
                        }).data()[0]['statuspegawai'];
                        let jumlahguru = jumlahgurutable.rows({
                            selected: true
                        }).data()[0]['jumlahguru'];
                        let jeniskelamin = jumlahgurutable.rows({
                            selected: true
                        }).data()[0]['jeniskelamin'];
                        let tahunajaranid = jumlahgurutable.rows({
                            selected: true
                        }).data()[0]['tahunajaranid'];

                        $('#modal-jumlah-guru-edit').modal('show');

                        $('#statuspegawaiedit option[value="' + statuspegawai + '"]').prop('selected',
                            true);
                        $('#jumlahguruedit').val(jumlahguru);
                        $('#jeniskelaminguruedit option[value="' + jeniskelamin + '"]').prop('selected',
                            true);
                        $('#tahunajaranguruedit option[value="' + tahunajaranid + '"]').prop('selected',
                            true);

                    }
                },
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: () => {
                        if (jumlahgurutable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                                "error");
                            return;
                        }
                        let id = jumlahgurutable.rows({
                            selected: true
                        }).data()[0]['jumlahguruid'];
                        let url = "{{ route('sekolah.hapusjumlahguru', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({
                            title: "Apakah anda yakin akan menghapus jumlah guru ini?",
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya, lanjutkan!",
                            closeOnConfirm: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache: false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: (json) => {
                                        let success = json.success;
                                        let message = json.message;
                                        let data = json.data;
                                        console.log(data);

                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!",
                                                "Data anda telah dihapus.",
                                                "success");
                                            jumlahgurutable.draw();
                                        } else {
                                            swal.fire("Error!", data, "error");
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            ]
        },
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'statuspegawai',
                render: function (data, type, row) {
                    if (row.jumlahguru != null) {
                        if (row.statuspegawai == "{{enum::STATUS_GURU_PNS}}")
                            return '{{enum::STATUS_GURU_DESC_PNS}}';
                        else if (row.statuspegawai == "{{enum::STATUS_GURU_PTK}}")
                            return '{{enum::STATUS_GURU_DESC_PTK}}';
                        else if (row.statuspegawai == "{{enum::STATUS_GURU_THL}}")
                            return '{{enum::STATUS_GURU_DESC_THL}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'statuspegawai'
            },
            {
                'orderData': 2,
                data: 'jumlahguru',
                name: 'jumlahguru'
            },
            {
                'orderData': 3,
                data: 'jeniskelamin',
                render: function (data, type, row) {
                    if (row.jumlahguru != null) {
                        if (row.jeniskelamin == "{{enum::JENIS_KELAMIN_LAKI_LAKI}}")
                            return '{{enum::JENIS_KELAMIN_DESC_LAKI_LAKI}}';
                        else if (row.jeniskelamin == "{{enum::JENIS_KELAMIN_PEREMPUAN}}")
                            return '{{enum::JENIS_KELAMIN_DESC_PEREMPUAN}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'jeniskelamin'
            },
            {
                'orderData': 3,
                data: 'tahunajaranid',
                render: function (data, type, row) {
                    if (row.jumlahguru != null) {
                        return (row.daritahun + ' - ' + row.sampaitahun);
                    } else
                        return "-";
                },
                name: 'tahunajaranid'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

</script>

<!-- table jumlah peserta didik -->
<script>
    // tambah jumlah peserta didik
    $(document).on('submit', '#tambahPesertaDidik', (e) => {
        e.preventDefault();

        let formData = new FormData($('#tambahPesertaDidik')[0]);

        let url = "{{ route('sekolah.storepesertadidik') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.masterplan;

                jumlahpesertadidiktable.draw();
                $('#kelaspesertadidik').val('');
                $('#jeniskelamin').val('');
                $('#tahunajaranid').val('');
                $('#jumlahpesertadidik').val('');
                $('#tambahPesertaDidik').trigger("reset");
                $('#modal-peserta-didik-tambah').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data peserta didik berhasil ditambah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })

    // edit jumlah peserta didik
    $(document).on('submit', '#editPesertaDidik', function (e) {
        e.preventDefault();
        let id = jumlahpesertadidiktable.rows({
            selected: true
        }).data()[0]['pesertadidikid'];

        let formData = new FormData($('#editPesertaDidik')[0]);

        let url = "{{ route('sekolah.updatepesertadidik', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.akreditasi;

                jumlahpesertadidiktable.draw();
                $('#kelaspesertadidikedit').val('');
                $('#jeniskelaminedit').val('');
                $('#tahunajaranidedit').val('');
                $('#jumlahpesertadidikedit').val('');
                $('#editPesertaDidik').trigger("reset");
                $('#modal-peserta-didik-edit').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data peserta didik berhasil diubah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })

    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    var jumlahpesertadidiktable = $('#jumlah-peserta-didik-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: function (response) {
                response.recordsTotal = response.data.countPesertaDidik;
                response.recordsFiltered = response.data.countPesertaDidik;
                return response.data.jumlahpesertadidik;
            },
            data: function (d) {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: {
            buttons: [{
                    text: 'Tambah',
                    className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
                    action: () => {
                        $('#modal-peserta-didik-tambah').modal('show');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (jumlahpesertadidiktable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                                "error");
                            return;
                        }
                        let kelas = jumlahpesertadidiktable.rows({
                            selected: true
                        }).data()[0]['kelas'];
                        let jumlahpesertadidikdata = jumlahpesertadidiktable.rows({
                            selected: true
                        }).data()[0]['jumlahpesertadidik'];
                        let jeniskelamin = jumlahpesertadidiktable.rows({
                            selected: true
                        }).data()[0]['jeniskelamin'];
                        let tahunajaranid = jumlahpesertadidiktable.rows({
                            selected: true
                        }).data()[0]['tahunajaranid'];

                        $('#modal-peserta-didik-edit').modal('show');

                        $('#kelaspesertadidikedit option[value="' + kelas + '"]').prop('selected',
                        true);
                        $('#jumlahpesertadidikedit').val(jumlahpesertadidikdata);
                        $('#jeniskelaminpesertadidikedit option[value="' + jeniskelamin + '"]').prop(
                            'selected', true);
                        $('#tahunajaranpesertadidikedit option[value="' + tahunajaranid + '"]').prop(
                            'selected', true);

                    }
                },
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: function () {
                        if (jumlahpesertadidiktable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                                "error");
                            return;
                        }
                        var id = jumlahpesertadidiktable.rows({
                            selected: true
                        }).data()[0]['pesertadidikid'];
                        var url = "{{ route('sekolah.hapuspesertadidik', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({
                            title: "Apakah anda yakin akan menghapus data peserta didik ini?",
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya, lanjutkan!",
                            closeOnConfirm: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache: false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function (json) {
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        console.log(data);

                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!",
                                                "Data anda telah dihapus.",
                                                "success");
                                            jumlahpesertadidiktable.draw();
                                        } else {
                                            swal.fire("Error!", data, "error");
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            ]
        },
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'kelas',
                render: function (data, type, row) {
                    if (row.kelas != null) {
                        if (row.kelas == "{{enum::KELAS_X}}")
                            return '{{enum::KELAS_DESC_X}}';
                        else if (row.kelas == "{{enum::KELAS_XI}}")
                            return '{{enum::KELAS_DESC_XI}}';
                        else if (row.kelas == "{{enum::KELAS_XII}}")
                            return '{{enum::KELAS_DESC_XII}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'kelas'
            },
            {
                'orderData': 2,
                data: 'jumlahpesertadidik',
                name: 'jumlahpesertadidik'
            },
            {
                'orderData': 3,
                data: 'jeniskelamin',
                render: function (data, type, row) {
                    if (row.jeniskelamin != null) {
                        if (row.jeniskelamin == "{{enum::JENIS_KELAMIN_LAKI_LAKI}}")
                            return '{{enum::JENIS_KELAMIN_DESC_LAKI_LAKI}}';
                        else if (row.jeniskelamin == "{{enum::JENIS_KELAMIN_PEREMPUAN}}")
                            return '{{enum::JENIS_KELAMIN_DESC_PEREMPUAN}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'jeniskelamin'
            },
            {
                'orderData': 4,
                data: 'tahunajaranid',
                render: function (data, type, row) {
                    if (row.tahunajaranid != null) {
                        return (row.daritahun + ' - ' + row.sampaitahun);
                    } else
                        return "-";
                },
                name: 'tahunajaranid'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

</script>

<!-- table jumlah rombel -->
<script>
    // tambah jumlah rombel
    $(document).on('submit', '#tambahJumlahRombel', (e) => {
        e.preventDefault();

        let formData = new FormData($('#tambahJumlahRombel')[0]);

        let url = "{{ route('sekolah.storejumlahrombel') }}"

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.masterplan;

                jumlahrombeltable.draw();
                $('#kelasjumlahrombel').val('');
                $('#tahunajaranjumlahrombel').val('');
                $('#jumlahrombel').val('');
                $('#tambahJumlahRombel').trigger("reset");
                $('#modal-jumlah-rombel-tambah').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data jumlah rombel berhasil ditambah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })

    // edit jumlah peserta didik
    $(document).on('submit', '#editJumlahRombel', function (e) {
        e.preventDefault();
        let id = jumlahrombeltable.rows({
            selected: true
        }).data()[0]['rombelid'];

        let formData = new FormData($('#editJumlahRombel')[0]);

        let url = "{{ route('sekolah.updatejumlahrombel', ':id') }}"
        url = url.replace(':id', id);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (json) => {
                let success = json.success;
                let message = json.message;
                let data = json.akreditasi;

                jumlahrombeltable.draw();
                $('#jumlahrombeledit').val('');
                $('#tahunajaranjumlahrombeledit').val('');
                $('#jumlahpesertadidikedit').val('');
                $('#editJumlahRombel').trigger("reset");
                $('#modal-jumlah-rombel-edit').modal('hide');

                if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data peserta didik berhasil diubah.", "success");
                } else {
                    swal.fire("Error!", data, "error");
                }
            }
        })
    })


    var url = "{{ route('sekolah.edit', ':id') }}"
    url = url.replace(':id', $('#idsekolah').val());
    var jumlahrombeltable = $('#jumlah-rombel-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        ajax: {
            url: url,
            dataSrc: function (response) {
                response.recordsTotal = response.data.countJumlahRombel;
                response.recordsFiltered = response.data.countJumlahRombel;
                return response.data.jumlahrombel;
            },
            data: function (d) {
                return $.extend({}, d, {
                    "sekolahid": $("#idsekolah").val().toLowerCase(),
                });
            }
        },
        buttons: {
            buttons: [{
                    text: 'Tambah',
                    className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
                    action: () => {
                        $('#modal-jumlah-rombel-tambah').modal('show');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (jumlahrombeltable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah",
                                "error");
                            return;
                        }

                        let kelas = jumlahrombeltable.rows({
                            selected: true
                        }).data()[0]['kelas'];
                        let jumlahrombeldata = jumlahrombeltable.rows({
                            selected: true
                        }).data()[0]['jumlahrombel'];
                        let tahunajaranid = jumlahrombeltable.rows({
                            selected: true
                        }).data()[0]['tahunajaranid'];

                        $('#modal-jumlah-rombel-edit').modal('show');

                        $('#kelasjumlahrombeledit option[value="' + kelas + '"]').prop('selected',
                        true);
                        $('#jumlahrombeledit').val(jumlahrombeldata);
                        $('#tahunajaranjumlahrombeledit option[value="' + tahunajaranid + '"]').prop(
                            'selected', true);

                    }
                },
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: () => {
                        if (jumlahrombeltable.rows({
                                selected: true
                            }).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus",
                                "error");
                            return;
                        }
                        let id = jumlahrombeltable.rows({
                            selected: true
                        }).data()[0]['rombelid'];
                        let url = "{{ route('sekolah.hapusjumlahrombel', ':id') }}"
                        url = url.replace(':id', id);
                        let nama = jumlahrombeltable.rows({
                            selected: true
                        }).data()[0]['kelas'];
                        swal.fire({
                            title: "Apakah anda yakin akan menghapus data jumlah rombel ini?",
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya, lanjutkan!",
                            closeOnConfirm: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache: false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: (json) => {
                                        let success = json.success;
                                        let message = json.message;
                                        let data = json.data;
                                        console.log(data);

                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!",
                                                "Data anda telah dihapus.",
                                                "success");
                                            jumlahrombeltable.draw();
                                        } else {
                                            swal.fire("Error!", data, "error");
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            ]
        },
        columns: [
            // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
            {
                'orderData': 1,
                data: 'kelas',
                render: function (data, type, row) {
                    if (row.kelas != null) {
                        if (row.kelas == "{{enum::KELAS_X}}")
                            return '{{enum::KELAS_DESC_X}}';
                        else if (row.kelas == "{{enum::KELAS_XI}}")
                            return '{{enum::KELAS_DESC_XI}}';
                        else if (row.kelas == "{{enum::KELAS_XII}}")
                            return '{{enum::KELAS_DESC_XII}}';
                        else return "-";
                    } else
                        return "-";
                },
                name: 'kelas'
            },
            {
                'orderData': 2,
                data: 'jumlahrombel',
                name: 'jumlahrombel'
            },
            {
                'orderData': 3,
                data: 'tahunajaranid',
                render: function (data, type, row) {
                    if (row.tahunajaranid != null) {
                        return (row.daritahun + ' - ' + row.sampaitahun);
                    } else
                        return "-";
                },
                name: 'tahunajaranid'
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        //order: [[1, 'asc']]
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#search').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            sekolahtable.draw();
        }
    });

</script>

<script>
    $(document).ready(function () {
        $('.custom-select').select2();
    });

</script>

<!-- Form Wizard JavaScript -->
<script src="{{asset('/dist/plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js')}}"></script>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}"
    type="text/javascript"></script>

<script type="text/javascript">
    (function () {
        $('#exampleBasic').wizard({
            onFinish: function () {
                alert('finish');
            }
        });
        $('#exampleBasic2').wizard({
            onFinish: function () {
                $.ajax({
                    type: "CREATE",
                    cache: false,
                    url: "{{ route('tahunajaran.store') }}",
                    dataType: 'JSON',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (json) {
                        var success = json.success;
                        var message = json.message;
                        var data = json.data;
                        console.log(data);
                    }
                });
            }
        });
        $('#exampleValidator').wizard({
            onInit: function () {
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
            validator: function () {
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
            onFinish: function () {
                $('#validation').submit();
                alert('finish');
            }
        });

        $('#accordion').wizard({
            step: '[data-toggle="collapse"]',

            buttonsAppendTo: '.panel-collapse',

            templates: {
                buttons: function () {
                    var options = this.options;
                    return '<div class="panel-footer"><ul class="pager">' +
                        '<li class="previous">' +
                        '<a href="#' + this.id + '" data-wizard="back" role="button">' + options
                        .buttonLabels.back + '</a>' +
                        '</li>' +
                        '<li class="next">' +
                        '<a href="#' + this.id + '" data-wizard="next" role="button">' + options
                        .buttonLabels.next + '</a>' +
                        '<a href="#' + this.id + '" data-wizard="finish" role="button">' + options
                        .buttonLabels.finish + '</a>' +
                        '</li>' +
                        '<li>' +
                        '<button type"submit" class="btn btn-info waves-effect waves-light m-r-10"> Simpan </button>' +
                        '</li>' +
                        '</ul></div>';
                }
            },

            onBeforeShow: function (step) {
                step.$pane.collapse('show');
            },

            onBeforeHide: function (step) {
                step.$pane.collapse('hide');
            },

            onFinish: function () {
                alert('finish');
            }
        });
    })();

</script>

<!-- akreditasi -->
<script>
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search2').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-akreditasi');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-akreditasi').click(function () {

            //get the footable object
            var footable = addrow.data('footable');

            //build up the row we are wanting to add
            // var newRow = '<tr><td><select id="akreditasi" class="col-md-12 custom-select form-control" name="akreditasi[]"><option value="">-- Pilih Akreditasi --</option><option value="{{enum::AKREDITASI_A}}">{{  enum::AKREDITASI_DESC_A }}</option><option value="{{enum::AKREDITASI_B}}">{{  enum::AKREDITASI_DESC_B }}</option><option value="{{enum::AKREDITASI_C}}">{{  enum::AKREDITASI_DESC_C }}</option><option value="{{enum::AKREDTIASI_TIDAK_TERAKREDITASI}}">{{  enum::AKREDTIASI_DESC_TIDAK_TERAKREDITASI }}</option></select></td><td><input type="file" class="form-control" name="fileakreditasi[]" id="fileakreditasi"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search3').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-sertifikat-lahan');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-sertifikat-lahan').click(function () {

            //get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow =
                '<tr><td><select id="sertifikatlahan" class="col-md-12 custom-select form-control" name="sertifikatlahan[]"><option value="">-- Pilih Sertifikat Lahan --</option><option value="{{enum::SERTIFIKAT_LAHAN_ADA}}">{{  enum::SERTIFIKAT_LAHAN_DESC_ADA }}</option><option value="{{enum::SERTIFIKAT_LAHAN_BELUM_ADA}}">{{  enum::SERTIFIKAT_LAHAN_DESC_BELUM_ADA }}</option></select></td><td><input type="file" class="form-control" name="filesertifikatlahan[]" id="filesertifikatlahan"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search4').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-master-plan-sekolah');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-master-plan-sekolah').click(function () {

            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow =
                '<tr><td><select id="masterplansekolah" class="col-md-12 custom-select form-control" name="masterplan[]"><option value="">-- Pilih Master Plan Sekolah --</option><option value="{{enum::MASTER_PLAN_SEKOLAH_ADA }}">{{  enum::MASTER_PLAN_SEKOLAH_DESC_ADA }}</option><option value="{{enum::MASTER_PLAN_SEKOLAH_BELUM_ADA }}">{{  enum::MASTER_PLAN_SEKOLAH_DESC_BELUM_ADA  }}</option></select></td><td><input type="file" class="form-control" name="filemasterplan[]" id="filemasterplansekolah"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search5').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-guru');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-guru').click(function () {

            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow =
                '<tr><td><select id="statuspegawai" class="col-md-12 custom-select form-control" name="statuspegawai[]"><option value="">-- Pilih Status Pegawai --</option><option value="{{enum::STATUS_GURU_PNS }}">{{  enum::STATUS_GURU_DESC_PNS }}</option><option value="{{enum::STATUS_GURU_PTK }}">{{ enum::STATUS_GURU_DESC_PTK  }}</option><option value="{{enum::STATUS_GURU_THL }}">{{ enum::STATUS_GURU_DESC_THL  }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahguru") }}" name="jumlahguru[]" placeholder="Contoh: 20"></td><td><select id="jeniskelaminguru" class="col-md-12 custom-select form-control" name="jeniskelaminguru[]"><option value="">-- Pilih Jenis Kelamin --</option><option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">{{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option><option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">{{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option></select></td><td><select id="tahunajaranguru" class="col-md-12 custom-select form-control" name="tahunajaranguru[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


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
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search6').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-peserta-didik');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-peserta-didik').click(function () {

            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow =
                '<tr><td><select id="kelaspesertadidik" class="col-md-12 custom-select form-control" name="kelaspesertadidik[]"><option value="">-- Pilih Kelas --</option><option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option><option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option><option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahpesertadidik") }}" name="jumlahpesertadidik[]" placeholder="Contoh: 20"></td><td><select id="jeniskelaminpesertadidik" class="col-md-12 custom-select form-control" name="jeniskelaminpesertadidik[]"><option value="">-- Pilih Jenis Kelamin --</option><option value="{{enum::JENIS_KELAMIN_LAKI_LAKI }}">{{  enum::JENIS_KELAMIN_DESC_LAKI_LAKI }}</option><option value="{{enum::JENIS_KELAMIN_PEREMPUAN }}">{{ enum::JENIS_KELAMIN_DESC_PEREMPUAN }}</option></select></td><td><select id="tahunajaranpesertadidik" class="col-md-12 custom-select form-control" name="tahunajaranpesertadidik[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
    $(window).on('load', function () {

        // Search input
        $('#demo-input-search7').on('input', function (e) {
            e.preventDefault();
            addrow.trigger('footable_filter', {
                filter: $(this).val()
            });
        });

        // Add & Remove Row
        var addrow = $('#demo-foo-addrow-jumlah-rombel');
        addrow.footable().on('click', '.delete-row-btn', function () {

            //get the footable object
            var footable = addrow.data('footable');

            //get the row we are wanting to delete
            var row = $(this).parents('tr:first');

            //delete the row
            footable.removeRow(row);
        });
        // Add Row Button
        $('#demo-btn-addrow-jumlah-rombel').click(function () {

            // get the footable object
            var footable = addrow.data('footable');
            // //build up the row we are wanting to add
            var newRow =
                '<tr><td><select id="kelasrombel" class="col-md-12 custom-select form-control" name="kelasrombel[]"><option value="">-- Pilih Kelas --</option><option value="{{enum::KELAS_X }}">{{  enum::KELAS_DESC_X }}</option><option value="{{enum::KELAS_XI }}">{{ enum::KELAS_DESC_XI }}</option><option value="{{enum::KELAS_XII }}">{{ enum::KELAS_DESC_XII }}</option></select></td><td><input class="form-control" type="number" value="{{ old("jumlahrombel") }}" name="jumlahrombel[]" placeholder="Contoh: 20"></td><td><select id="tahunajaranrombel" class="col-md-12 custom-select form-control" name="tahunajaranrombel[]"><option value="">-- Pilih Tahun Ajaran --</option>@foreach ($tahunajaran as $item)<option value="{{$item->tahunajaranid}}">{{  $item->daritahun . " - " . $item->sampaitahun }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
