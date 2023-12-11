<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<style>
    div.dataTables_filter input{
        /* display: none; */
    }

    /* div.dt-buttons {
        float: right;
    } */

    .modal-body{
        max-height: 80vh;
        overflow-y: auto !important;
    }
    .modal-open .modal {
        /* overflow-x: hidden; */
        /* overflow-y: hidden !important; */
    }
</style>
<div class="card">
    <div class="card-body p-4">
        <h2 class="card-title text-uppercase">JENIS SARPRAS TERSEDIA</h2><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kotaid" class="col-md-12 custom-select form-control" name='kotaid' autofocus>
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                                @foreach ($kota as $item)
                                    <option value="{{$item->kotaid}}">{{  $item->kodekota . ' ' . $item->namakota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                                {{-- @foreach ($kecamatan as $item)
                                    <option value="{{$item->kecamatanid}}">{{  $item->kodekec . ' ' . $item->namakec }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="form-group row">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jenjang" class="col-md-12 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="jenjang" class="col-md-12 custom-select form-control" name='jenjang' autofocus>
                                <option value="">-- Pilih Jenjang --</option>
                                    <option value="{{enum::JENJANG_SMA}}">{{  enum::JENJANG_DESC_SMA }}</option>
                                    <option value="{{enum::JENJANG_SMK}}">{{  enum::JENJANG_DESC_SMK }}</option>
                                    <option value="{{enum::JENJANG_SLB}}">{{  enum::JENJANG_DESC_SLB }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="jenis" class="col-md-12 custom-select form-control" name='jenis' autofocus>
                                <option value="">-- Pilih Jenis --</option>
                                    <option value="{{enum::JENIS_NEGERI}}">{{  enum::JENIS_DESC_NEGERI }}</option>
                                    <option value="{{enum::JENIS_SWASTA}}">{{  enum::JENIS_DESC_SWASTA }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sekolahid" class="col-md-12 col-form-label text-md-left">{{ __('Sekolah') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="sekolahid" class="col-md-12 custom-select form-control" name='sekolahid' autofocus {{ $isSekolah ? 'disabled' : '' }}>
                                <option value="{{ $isSekolah ? $userSekolah->sekolahid : ''}}">{{ $isSekolah ? $userSekolah->namasekolah : '-- Pilih Sekolah --' }}</option>
                                @foreach ($sekolah as $item)
                                    <option value="{{$item->sekolahid}}">{{  $item->namasekolah }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="search" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                        </div>
                        <div class="col-md-9">
                            <input id="search" type="text" class="col-md-12 form-control" name="search" value="{{ old('search') }}" maxlength="100" autocomplete="search" placeholder="-- Filter --">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-group row">
            <div class="col-md-12">
                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
                @endif

                {{-- @if (session()->has('success1'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success1') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif --}}
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="jenis-sarpras-tersedia-table">
                        <thead>
                            <tr>
                                <th>Nama Sekolah</th>
                                <th>Nama Sarpras</th>
                                <th>Jenis Sarpras</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-body p-4">
        <h2 class="card-title text-uppercase">DETAIL SARPRAS</h2><hr />
        <div class="form-group row">
            <div class="col-md-12">
                {{-- @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
                @endif

                @if (session()->has('success'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif --}}
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-sarpras-table">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Sumber Dana</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-detail-pagu-sarpras" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px;">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">DETAIL PAGU SARPRAS</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-bordered yajra-datatable table-striped" id="detail-pagu-sarpras-table">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">Jenis Pagu</th>
                            <th class="text-center" rowspan="2">Nilai Pagu</th>
                            <th class="text-center" rowspan="2">No Kontrak</th>
                            <th class="text-center" rowspan="2">Nilai Kontrak</th>
                            <th class="text-center" rowspan="2">Perusahaan</th>
                            <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                            <th class="text-center" rowspan="2">Upload File</th>
                            <th class="text-center" rowspan="2">Preview</th>
                        </tr>
                        <tr>
                            <th class="text-center">Dari</th>
                            <th class="text-center">Sampai</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body p-4">
        <h2 class="card-title text-uppercase">DETAIL JUMLAH SARPRAS</h2><hr />
        <div class="form-group row">
            <div class="col-md-12">
                {{-- @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
                @endif

                @if (session()->has('success'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif --}}
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-jumlah-sarpras-table">
                        <thead>
                            <tr>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                                {{-- <th>File Foto</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-foto-detail-jumlah-sarpras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="exampleModalLabel">Foto Detail Jumlah Sarpras</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="foto-detail-jumlah-sarpras-table">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal jenis sarpras -->
<div class="modal" id="modal-jenis-sarpras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-jenis-sarpras" id="modal-title-jenis-sarpras"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="jenissarprasForm" name="jenissarprasForm" method="POST" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- {{ method_field('PUT') }} --}}
                    <input type="hidden" name="jenissarpras" id="jenissarpras_mode">
                    <input type="hidden" name="sekolahid" id="jenissarpras_sekolahid">
                    <div class="form-group row">
                        <label for="jenissarpras" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Sarpras Tersedia *') }}</label>
    
                        <div class="col-md-12">
                            <select id="jenissarpras_jenissarpras" class="custom-select1 form-control @error('jenissarpras') is-invalid @enderror" name='jenissarpras' required>
                                <option value="">-- Pilih Jenis Sarpras Tersedia --</option>
                                <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_UTAMA ? 'selected' : '' }} value="{{ enum::SARPRAS_UTAMA }}">{{ __('Sarpras Utama') }}</option>
                                <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PENUNJANG ? 'selected' : '' }} value="{{ enum::SARPRAS_PENUNJANG }}">{{ __('Sarpras Penunjang') }}</option>
                                <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PERALATAN ? 'selected' : '' }} value="{{ enum::SARPRAS_PERALATAN }}">{{ __('Sarpras Peralatan') }}</option>
                            </select>
    
                            @error('jenissarpras')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="namasarprasid" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpras *') }}</label>
    
                        <div class="col-md-12">
                            <select id="jenissarpras_namasarprasid" class="custom-select1 form-control @error('namasarpras') is-invalid @enderror" name='namasarprasid' required>
                                <option value="">-- Pilih Nama Sarpras --</option>
                                {{-- @foreach ($namasarpras as $item)
                                <option value="{{$item->namasarprasid}}">{{ $item->namasarpras }}</option>
                                @endforeach --}}
                            </select>
    
                            @error('namasarpras')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah Unit *') }}</label>
                                <div class="col-md-12">
                                    <input id="jenissarpras_jumlahunit" type="number" class="form-control @error('jumlahunit') is-invalid @enderror" name="jumlahunit" value="{{ (old('jumlahunit')) }}" maxlength="100" required autocomplete="jumlahunit">
            
                                    @error('jumlahunit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="col-md-3"> --}}
                                <div class="form-group">
                                    <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
                
                                    <div class="col-md-12">
                                        <input id="jenissarpras_satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ (old('satuan')) }}" maxlength="100" required autocomplete="satuan">
                
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            {{-- </div> --}}
                        </div>
                    </div>
    
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="thang" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Anggaran *') }}</label>
    
                                <div class="col-md-12">
                                    <select id="jenissarpras_thang" class="custom-select1 form-control @error('thang') is-invalid @enderror" name='thang' required>
                                        <option value="">-- Tahun Anggaran --</option>
                                        @foreach (enum::listTahun() as $id)
                                            <option value="{{ $id }}"> {{ enum::listTahun('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button value="btnSubmit" type="submit" id="btnSubmit" class="btn btn-primary btnSubmit"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah detail sarpras -->
<div class="modal" id="modal-detail-sarpras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1300px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-detail-sarpras" id="modal-title-detail-sarpras"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sarprastersediaid" id="sarprastersediaid">
                <div class="row m-b-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
                            <div class="col-md-12">
                                <select id="subkegid" class="custom-select form-control @error('subkegid') is-invalid @enderror" name='subkegid' required>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                    @foreach ($subkegiatan as $item)
                                    <option {{ old('subkegid') != '' && old('subkegid') == $item->subkegid ? 'selected' : '' }} value="{{$item->subkegid}}">{{ $item->progkode .  $item->kegkode .  $item->subkegkode . ' ' . $item->subkegnama}}</option>
                                    @endforeach
                                </select>
        
                                @error('subkegid')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumberdana" class="col-md-12 col-form-label text-md-left">{{ __('Sumber Dana *') }}</label>
        
                            <div class="col-md-12">
                                <select id="sumberdana" class="custom-select form-control @error('sumberdana') is-invalid @enderror" name='sumberdana' required>
                                    <option value="">-- Pilih Sumber Dana --</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'DAK' ? 'selected' : '' }} value="DAK">{{ __('DAK') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'BOS' ? 'selected' : '' }} value="BOS">{{ __('BOS') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'SPP' ? 'selected' : '' }} value="SPP">{{ __('SPP') }}</option>
                                </select>
        
                                @error('sumberdana')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <h4 class="card-title text-uppercase text-bold m-t-40">Upload Foto Kebutuhan Sarpras</h4><hr /> --}}

                <div class="table-responsive">
                    <table style="min-width: 1500px" id="demo-foo-addrow-sarprastersedia" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                        <thead style="background-color: #d8d8d868;">
                            <tr>
                                <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Jenis Pagu</th>
                                <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Pagu</th>
                                <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">No Kontrak</th>
                                <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Kontrak</th>
                                <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Perusahaan</th>
                                <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                                <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Upload File</th>
                                <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Preview</th>
                                <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Hapus</th>
                            </tr>
                            <tr>
                                <th class="text-center" data-sort-initial="true" data-toggle="true">Dari</th>
                                <th class="text-center" data-sort-initial="true" data-toggle="true">Sampai</th>
                            </tr>
                        </thead>
                        <div class="padding-bottom-15">
                            <div class="row">
                                <div class="col-sm-12 text-right m-b-5">
                                    <button type="button" id="demo-btn-addrow-sarprastersedia" class="btn btn-primary"><i class="fldemo glyphicon glyphicon-plus"></i> Tambah
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                        <tbody id="tbody-sarprastersedia" style="font-weight: 300;">
                            <tr class="tr-length">
                                <td class="border-0">
                                    <div class="form-group">
                                        <select id="jenispagu" class="form-control select-custom @error('jenispagu') is-invalid @enderror" name='jenispagu[]' required>
                                            <option value="">-- Pilih Jenis Pagu --</option>
                                            @foreach (enum::listJenisPagu() as $id)
                                            <option {{ old('jenispagu') != '' || old('jenispagu') != null ? 'selected' : '' }} value="{{ old('jenispagu') ?? $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="border-0" style="width: 200px">
                                    <div class="input-group">
                                        <span class="p-2">Rp </span>
                                        <input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}">
                                    </div>
                                </td>
                                <td class="border-0">
                                        <input id="nokontrak" type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak[]" value="{{ (old('nokontrak')) }}" maxlength="100">
                                </td>
                                <td class="border-0" style="width: 200px">
                                    <div class="input-group">
                                        <span class="p-2">Rp </span>
                                        <input id="nilaikontrak" type="number" class="form-control @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak[]" value="{{ (old('nilaikontrak')) }}" maxlength="100">
                                    </div>
                                </td>
                                <td class="border-0">
                                    <div class="perusahaanid-container">
                                        <select id="perusahaanid" class="form-control select-custom @error('perusahaanid') is-invalid @enderror" name="perusahaanid[0]" required>
                                            <option value="">-- Pilih Perusahaan --</option>
                                            @foreach ($perusahaan as $item)
                                            <option {{ old('perusahaanid') != '' || old('perusahaanid') != null ? 'selected' : '' }} value="{{ old('perusahaanid') ?? $item->perusahaanid }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="border-0">
                                    <input type="date" class="form-control @error('tgldari') is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old('tgldari') }}" required onchange="compareDates()">
                                </td>
                                <td class="border-0">
                                    <input type="date" class="form-control @error('tglsampai') is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old('tglsampai') }}" required onchange="compareDates()">
                                </td>
                                <td class="border-0">
                                    <input type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                                </td>
                                <td class="border-0">
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </td>
                                <td class="border-0">
                                    <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                </td>
    
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <div class="text-right">
                                        <ul class="pagination">
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sarprastersedia.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Tersedia') }}
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
    // $('div.dataTables_filter').addClass('form-material');
    $(document).ready(function () {

        // verifikasi kebutuhan sarpras 
        $(document).on('submit', '#jenissarprasForm', function(e){
            e.preventDefault();
            var url = '';
            var type = '';
            var id = '';

            // var data = {};
            
            // $('input[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            //     var inputname = el.id.substring(13, el.id.length);
            //     if (inputname != "mode") {
            //         data[inputname] = $("#"+el.id).val();
            //     }
            // });
            // $('select[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            //     var inputname = el.id.substring(13, el.id.length);
            //     if (inputname != "mode") {
            //         data[inputname] = $("#"+el.id).val();
            //     }
            // });

            // console.log(data);

            
            if($("#jenissarpras_mode").val() == 'add') {
                url = "{{ route('sarprastersedia.storejenissarpras') }}";
                type = 'POST'
                // url = url.replace(':id', id);   
            }else if($("#jenissarpras_mode").val() == "edit") {
                url = "{{ route('sarprastersedia.updatejenissarpras', ':id') }}";
                id = jenisSarprasTersediaTable.rows( { selected: true } ).data()[0]['sarprastersediaid'];
                url = url.replace(':id', id); 
                type = 'POST'
            }
            var formData = new FormData($('#jenissarprasForm')[0]);
            
            $.ajax({
                type: type,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                // data: data,
                contentType: false,
                processData: false,
                success: (json) => {
                    let success = json.success;
                    let message = json.message;
                    let data = json.data;
                    // let errors = json.errors;

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Data jenis sarpras berhasil ditambah.", "success");
                            // kebutuhansarprastable.draw();
                            // jenissarprasFormtable.draw();
                            // var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                            // var detailpenganggaranid = rowData.detailpenganggaranid;
                            // showDetailPaguPenganggaran(detailpenganggaranid);
                            jenisSarprasTersediaTable.draw();

                            $('#jenissarprasForm').trigger("reset");
                            $('#modal-jenis-sarpras').modal('hide'); 
                    }
                },
                // error: function(jqXHR, textStatus, errorThrown) {
                //         var data = jqXHR.responseJSON;
                //         console.log(data.errors);// this will be the error bag.
                //         // printErrorMsg(data.errors);
                //     }
            })
        })



        $('.custom-select').select2();

        $('.custom-select1').select2({
            dropdownParent: $('#modal-jenis-sarpras .modal-content')
        });

        // Get namasarpras when jenis sarpras selected
        $('#jenissarpras_jenissarpras').select2().on('change', function() {
            var url = "{{ route('sarprastersedia.getNamaSarpras', ':parentid') }}";
            url = url.replace(':parentid', ($('#jenissarpras_jenissarpras').val() == "" || $('#jenissarpras_jenissarpras').val() == null ? "-1" : $('#jenissarpras_jenissarpras').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#jenissarpras_namasarprasid').empty();
                    $('#jenissarpras_namasarprasid').append($("<option></option>").attr("value", "").text("-- Pilih Nama Sarpras --"));
                    $.each(data.data, function(key, value) {
                        $('#jenissarpras_namasarprasid').append($("<option></option>").attr("value", value.namasarprasid).text(value.namasarpras));
                    });
                    $('#jenissarpras_namasarprasid').select2();
                    // $('#sekolahid').val(sekolahid);
                    var namasarprasid = jenisSarprasTersediaTable.rows( { selected: true } ).data()[0]['namasarprasid'];
                    if ($('#jenissarpras_mode').val() == 'edit') {
                        $('#jenissarpras_namasarprasid').val(namasarprasid);
                    }
                    $('#jenissarpras_namasarprasid').trigger('change');
                }
            })
        })

        // START HANDLE MODAL JENIS SARPRAS FORM

    function resetformdetail() {
        $("#jenissarprasForm")[0].reset();
        // var v_max = 1;
        // if (v_listDataDetail.length > 0) {
        //     var v_maxobj = v_listDataDetail.reduce((prev, current) => (prev && prev.nourut > current.nourut) ? prev : current);
        //     v_max = parseInt(v_maxobj.nourut)+1;
        // }
        // $("#detail_detail_nourut").val(v_max);
        //alert(v_listDataDetail.length);
        //alert(v_listDataDetail.length + '->' + JSON.stringify(max));

        // $('span[id^="err_detail_detail_"]', "#jenissarprasForm").each(function(index, el){
        //     $('#'+el.id).html("");
        // });

        $('select[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            var inputname = el.id.substring(13, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindformdetail() {
        $('textarea[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            var inputname = el.id.substring(13, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            // if(el.type != 'file') {
            //     var inputname = el.id.substring(13, el.id.length);
            //     //alert(inputname);
            //     if (inputname != "mode") {
            //         if((inputname == 'nilaikontrak' && jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname] != null) || (inputname == 'nilaipagu' && jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname] != null)){
            //             $("#"+el.id).val(formatRupiah(jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname]));
            //         }else {
            //             $("#"+el.id).val(jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname]);
            //         }
            //     }
            // }

            var inputname = el.id.substring(13, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname]);
                console.log(inputname);
            }
        });
        
        $('select[id^="jenissarpras_"]', "#jenissarprasForm").each(function(index, el){
            var inputname = el.id.substring(13, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(jenisSarprasTersediaTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
            }
        });
    }

    function setenableddetail(value) {
        if (value) {
            $("#btnSubmit").show();
        }
        else {
            $("#btnSubmit").hide();
        }
        
        $('textarea[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modejenissarpras = "";
    function showmodaljenissarpras(mode) {
        v_modejenissarpras = mode;
        $("#jenissarpras_mode").val(mode);
        resetformdetail();
        if (mode == "add") {
            $("#modal-title-jenis-sarpras").html('Tambah Data');
            setenableddetail(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-jenis-sarpras").html('Ubah Data');
            bindformdetail();
            setenableddetail(true);
        }
        else {
            $("#modal-title-jenis-sarpras").html('Lihat Data');
            bindformdetail();
            setenableddetail(false);
        }
        
        $("#m_formshowdetail").modal('show');
    }

    function hidemodaldetail() {
        $("#m_formshowdetail").modal('hide');
    }

    // END HANDLE MODAL JENIS SARPRAS FORM

        var detailSarprasTable;
        var detailJumlahSarprasTable;
    
        var jenisSarprasTersediaTable = $('#jenis-sarpras-tersedia-table').DataTable({
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
                url: "{{ route('sarprastersedia.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "sekolahid": $("#sekolahid").val().toLowerCase(),
                        "jenjang": $("#jenjang").val().toLowerCase(),
                        "jenis": $("#jenis").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-plus-circle aria-hidden="true"></i> Tambah',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function () {
                        var id = $("#sekolahid").val();
                        if (id === '') {
                            swal.fire("Sekolah belum dipilih", "Silakan pilih sekolah terlebih dahulu", "error");
                            return;
                        }
                        else{
                            // var url = "{{  route('sarprastersedia.createBySekolahId', ['sekolahid' => ':id']) }}";
                            // url = url.replace(':id', id);
                            // window.location.href = url;

                            $('#modal-jenis-sarpras').modal('show');
                            showmodaljenissarpras('add');
                            $('#jenissarpras_sekolahid').val($('#sekolahid').val());

                        }
                    }
                },
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (jenisSarprasTersediaTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = jenisSarprasTersediaTable.rows( { selected: true } ).data()[0]['sarprastersediaid'];
                        var url = "{{ route('sarprastersedia.edit', ':id') }}"
                        // url = url.replace(':id', id);
                        // window.location = url;

                        $('#modal-jenis-sarpras').modal('show');
                        showmodaljenissarpras('edit');
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (jenisSarprasTersediaTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = jenisSarprasTersediaTable.rows( { selected: true } ).data()[0]['sarprastersediaid'];
                        var url = "{{ route('sarprastersedia.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus data ini?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "DELETE",
                                    cache:false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(json){
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        console.log(data);
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            jenisSarprasTersediaTable.draw();
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });   
                            }          
                        });
                    }
                }]
            },
            columns: [
                {'orderData': 1, data: 'namasekolah', name: 'namasekolah'},
                {'orderData': 2, data: 'namasarprasid',
                render: function ( data, type, row ) {
                        if(row.namasarprasid!=null){
                            return row.namasarpras;
                        }else
                        return "-";
                    }, 
                    name: 'namasarprasid'},
                    {'orderData': 3, data: 'jenissarpras',
                    render: function ( data, type, row ) {
                        if(row.jenissarpras!=null){
                            if(row.jenissarpras=="{{enum::SARPRAS_UTAMA}}") 
                            return 'Sarpras Utama';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PERALATAN}}") 
                            return 'Sarpas Peralatan';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PENUNJANG}}") 
                            return 'Sarpras Penunjang';
                            else return "-";
                        }else
                        return "-";
                    }, 
                    name: 'jenissarpras'},
                    {'orderData': 4, data: 'jumlahunit', name: 'jumlahunit',
                    render: function(data, type, row) {
                        if(row.jumlahunit != null) {
                            return `${row.jumlahunit} ${row.satuan != null ? row.satuan : ''}`
                        }
                    }
                },
                {'orderData': 5, data: 'sarprastersediaid', name: 'sarprastersediaid', visible: false},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        // FILTER SEKOLAH - START
        $('#kotaid').select2().on('select2:select', function() {

            var urlSekolahKota = "{{ route('helper.getsekolahkota', ':id') }}";
            urlSekolahKota = urlSekolahKota.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: urlSekolahKota,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                }
            })

            var url = "{{ route('helper.getkecamatan', ':id') }}";
            url = url.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#kecamatanid').empty();
                    $('#kecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
                    $.each(data.data, function(key, value) {
                        $('#kecamatanid').append($("<option></option>").attr("value", value.kecamatanid).text(value.kodekec + ' - ' + value.namakec));
                    });
                    $('#kecamatanid').select2();
                    // $('#kecamatanid').val(kecamatanid);
                    $('#kecamatanid').trigger('change');
                }
            })

            if($('#kecamatanid').val() == '' && $('#jenjang').val() != '' && $('#jenis').val() != '') {
                var urlSekolahKotaJenjangJenis = "{{ route('helper.getSekolahKotaJenjangJenis', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang', 'jenis' => ':jenis']) }}";
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':kotaid', $('#kotaid').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenjang', $('#jenjang').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenis', $('#jenis').val() == "" );

                $.ajax({
                    url: urlSekolahKotaJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                    }
                })
            }
        });
        
        $('#kecamatanid').select2().on('select2:select', function() {
            var jenis = $('#jenis').val();
            var jenjang = $('#jenjang').val();
            url = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
            url = url.replace(':jenis', ($('#jenis').val() == "" || $('#jenis').val() == null ? "-1" : $('#jenis').val()));
            url = url.replace(':jenjang', ($('#jenjang').val() == "" || $('#jenjang').val() == null ? "-1" : $('#jenjang').val()));
            url = url.replace(':kecamatanid', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()))
            // var url = "{{ route('helper.getkecamatan', ':id') }}";
            // url = url.replace(':id', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()));

            var urlSekolah = "{{ route('helper.getsekolah', ':id') }}";
            urlSekolah = urlSekolah.replace(':id', $('#kecamatanid').val())

            $.ajax({
                url: urlSekolah,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                    $('#detail-sarpras-table').hide();
                    $('#detail-jumlah-sarpras-table').hide();

                }
            })

            if($('#kecamatanid').val() != '' && $('#jenjang').val() != '' && $('#jenis').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenjang').select2().on('select2:select', function() {
            jenisSarprasTersediaTable.draw();
            // hide detail sarpras table table
            $('#detail-sarpras-table').hide();
            $('#detail-jumlah-sarpras-table').hide();
            if($('#kecamatanid').val() != '' && $('#kotaid').val() != '') {
                var urlSekolah = "{{ route('helper.getsekolahjenjang', ['kecamatanid' => ':kecamatanid', 'jenjang' => ':jenjang']) }}";
                urlSekolah = urlSekolah.replace(':kecamatanid', $('#kecamatanid').val());
                urlSekolah = urlSekolah.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolah,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() != '' && $('#kecamatanid').val() == '') {
                var urlSekolahKotaJenjang = "{{ route('helper.getSekolahKotaJenjang1', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang']) }}";
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':kotaid', $('#kotaid').val());
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahKotaJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() == '' && $('#kecamatanid').val() == '') {
                var urlSekolahJenjang = "{{ route('helper.getsekolahjenjang2', ['jenjang' => ':jenjang']) }}";
                urlSekolahJenjang = urlSekolahJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenis').select2().on('select2:select', function(){
            jenisSarprasTersediaTable.draw();
            // hide detail sarpras table table
            $('#detail-sarpras-table').hide();
            $('#detail-jumlah-sarpras-table').hide();
            if($('#kecamatanid').val() != '' && $('#jenjang').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() != '' && $('#jenjang').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjeniskecamatan', ['jenis' => ':jenis', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjenisjenjang', ['jenis' => ':jenis', 'jenjang' => ':jenjang']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '' && $('#jenjang').val() == ''){
                var urlSekolahJenis = "{{ route('helper.getsekolahjenis2', ':jenis') }}";
                urlSekolahJenis = urlSekolahJenis.replace(':jenis', $('#jenis').val());

                $.ajax({
                    url: urlSekolahJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        })
        // FILTER SEKOLAH - END


        // $('#kotaid').change( function() { 
        //     jenisSarprasTersediaTable.draw();
        //     // hide detail sarpras table table
        //     $('#detail-sarpras-table').hide();
        //     $('#detail-jumlah-sarpras-table').hide();
        //     // sekolahtable.draw();
        //     if (this.value) {
        //         $.ajax({
        //             url: "{{ route('helper.getkecamatan', ':id') }}".replace(':id', this.value),
        //         }).done(function (result) {
        //             let dataWr = result.data;
                    
        //             $("#kecamatanid").html("");
        //             var d = new Option("-- Semua Kecamatan --", "");
        //             $("#kecamatanid").append(d);
            
        //             if (dataWr) {
        //                 dataWr.forEach((element) => {
        //                     var text = element.kodekec + ' - ' + element.namakec; 
        //                     var o = new Option(text, element.kecamatanid);
        //                     $("#kecamatanid").append(o);
        //                 });
        //             }
        //         });
        //     }else{

        //         $("#kecamatanid").html("");
                
        //         var dd = new Option("-- Pilih Kecamatan --", "");
        //         $("#kecamatanid").append(dd);
        //     }
        // });
        // $('#kecamatanid').change( function() { 
        //     jenisSarprasTersediaTable.draw();
        //     // hide detail sarpras table table
        //     $('#detail-sarpras-table').hide();
        //     $('#detail-jumlah-sarpras-table').hide();
        //     // sekolahtable.draw();
        //     var jenis = $('#jenis').val();
        //     var jenjang = $('#jenjang').val();
        //     url = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
        //     url = url.replace(':jenis', jenis);
        //     url = url.replace(':jenjang', jenjang);
        //     url = url.replace(':kecamatanid', this.value)

        //     console.log(url);
        //     if (this.value) {
        //         $.ajax({
        //             url: url
        //         }).done(function (result) {
        //             let dataWr = result.data;
                    
        //             $("#sekolahid").html("");
        //             var d = new Option("-- Semua Kecamatan --", "");
        //             $("#sekolahid").append(d);
            
        //             if (dataWr) {
        //                 dataWr.forEach((element) => {
        //                     var text = element.namasekolah; 
        //                     var o = new Option(text, element.sekolahid);
        //                     $("#sekolahid").append(o);
        //                 });
        //             }
        //         });
        //     }else{

        //         $("#sekolahid").html("");
                
        //         var dd = new Option("-- Pilih Kecamatan --", "");
        //         $("#sekolahid").append(dd);
        //     }
        // });
        $('#sekolahid').change( function() { 
            jenisSarprasTersediaTable.draw();
            // hide detail sarpras table table
            $('#detail-sarpras-table').hide();
            $('#detail-jumlah-sarpras-table').hide();
        });

        // $('#jenis').select2().on('change', function() {

        //     jenisSarprasTersediaTable.draw();

        // });

        // $('#jenis').change( function() { 
        //     jenisSarprasTersediaTable.draw();
        //     // hide detail sarpras table table
        //     $('#detail-sarpras-table').hide();
        //     $('#detail-jumlah-sarpras-table').hide();
        // });

        // $('#jenjang').change( function() { 
        //     jenisSarprasTersediaTable.draw();
        //     // hide detail sarpras table table
        //     $('#detail-sarpras-table').hide();
        //     $('#detail-jumlah-sarpras-table').hide();
        // });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                jenisSarprasTersediaTable.draw();
                $('#detail-sarpras-table').hide();
                $('#detail-jumlah-sarpras-table').hide();
            }
        });

        function loadDetailSarpras(sarprastersediaid) {
            var url = "{{ route('sarprastersedia.loadDetailSarpras', ':id') }}";
            url = url.replace(':id', sarprastersediaid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailSarprasTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        detailSarprasTable.row.add({
                            subkegid: response.data.data[i].subkegid,
                            subkegnama: response.data.data[i].subkegnama,
                            sumberdana: response.data.data[i].sumberdana,
                            jenispagu: response.data.data[i].jenispagu,
                            nilaipagu: response.data.data[i].nilaipagu,
                            tglpelaksanaan: response.data.data[i].tglpelaksanaan,
                            file: response.data.data[i].file,
                            detailsarprasid: response.data.data[i].detailsarprasid,
                            detailpagusarprasid: response.data.data[i].detailpagusarprasid,
                        });
                    }

                    detailSarprasTable.draw();
                    $('#detail-sarpras-table').show();
                    $('#detail-jumlah-sarpras-table').hide();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on legalisir-table
        jenisSarprasTersediaTable.on('select', function (e, dt, type, indexes) {
            var rowData = jenisSarprasTersediaTable.rows(indexes).data()[0]; // Get selected row data
            var sarprastersediaid = rowData.sarprastersediaid;

            // Load history table with selected sarprastersediaid
            loadDetailSarpras(sarprastersediaid);
        });

        jenisSarprasTersediaTable.on('deselect', function ( e, dt, type, indexes ) {
            // hide histiry table
            $('#detail-sarpras-table').hide();
            $('#detail-jumlah-sarpras-table').hide();
        });

        var detailSarprasTable = $('#detail-sarpras-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: false,
            language: {
                // lengthMenu: "Menampilkan _MENU_ data per halaman",
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

            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-plus-circle aria-hidden="true"></i> Tambah',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function () {
                        if (jenisSarprasTersediaTable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Jenis Sarpras belum dipilih", "Silakan pilih jenis sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = jenisSarprasTersediaTable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var sarprastersediaid = rowData.sarprastersediaid;
                            var url = "{{  route('sarprastersedia.createDetailSarpras', ['sarprastersediaid' => ':id']) }}";
                            url = url.replace(':id', sarprastersediaid);
                            window.location.href = url;

                            // $('#modal-detail-sarpras').modal('show');
                        }
                    }
                },
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                    className: 'edit btn btn-info mb-3 btn-datatable',
                    action: function() {

                        if (detailSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var rowData = detailSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailsarprasid = rowData.detailsarprasid;
                            // var detailpagusarprasid = rowData.detailpagusarprasid;
                            console.log(detailsarprasid);
                            $('#modal-detail-pagu-sarpras').modal('show');
                            showDetailPaguSarpras(detailsarprasid)
                        }
                    }
                },  
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (detailSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        // var id = detailSarprasTable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                        var rowData = detailSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                        var id = rowData.detailsarprasid;
                        var url = "{{ route('sarprastersedia.editDetailSarpras', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (detailSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = detailSarprasTable.rows( { selected: true } ).data()[0]['detailsarprasid'];
                        var url = "{{ route('sarprastersedia.destroyDetailSarpras', ':id') }}"
                        url = url.replace(':id', id);
                        // var nama =  detailSarprasTable.rows( { selected: true } ).data()[0]['namasekolah'];
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus data ini?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache:false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(json){
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        console.log(data);
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            // detailSarprasTable.draw();
                                            var rowData = jenisSarprasTersediaTable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var sarprastersediaid = rowData.sarprastersediaid;
                                            loadDetailSarpras(sarprastersediaid);
                                        }
                                        else {
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
                {'orderData': 1, data: 'subkegid', name: 'subkegid', 
                    render: function(data, type, row){
                        return row.subkegnama;
                    }
                },
                {'orderData': 2, data: 'sumberdana', name: 'sumberdana'},
                // {'orderData': 3, data: 'jenispagu', name: 'jenispagu'},
                // {'orderData': 4, data: 'nilaipagu', name: 'nilaipagu'},
                // {'orderData': 5, data: 'tglpelaksanaan', name: 'tglpelaksanaan'},
                // {'orderData': 6, data: 'file', name: 'file'},
                //     {'orderData': 3, data: 'jenissarpras',
                //     render: function ( data, type, row ) {
                //         if(row.jenissarpras!=null){
                //             if(row.jenissarpras=="{{enum::SARPRAS_UTAMA}}") 
                //                 return 'Sarpras Peralatan';
                //             else if(row.jenissarpras=="{{enum::SARPRAS_PERALATAN}}") 
                //                 return 'Sarpas Peralatan';
                //             else if(row.jenissarpras=="{{enum::SARPRAS_PENUNJANG}}") 
                //                 return 'Sarpras Penunjang';
                //             else return "-";
                //         }else
                //             return "-";
                //     }, 
                //     name: 'jenissarpras'},
                // {'orderData': 4, data: 'jumlahunit', name: 'jumlahunit'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        // hide detail jumlah sarpras table table
        $('#detail-sarpras-table').hide();
        function loadDetailJumlahSarpras(detailsarprasid) {
            var url = "{{ route('sarprastersedia.loadDetailJumlahSarpras', ':id') }}";
            url = url.replace(':id', detailsarprasid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailJumlahSarprasTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        detailJumlahSarprasTable.row.add({
                            kondisi: response.data.data[i].kondisi,
                            jumlah: response.data.data[i].jumlah,
                            file: response.data.data[i].file,
                            detailjumlahsarprasid: response.data.data[i].detailjumlahsarprasid
                        });
                    }

                    detailJumlahSarprasTable.draw();
                    $('#detail-jumlah-sarpras-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on legalisir-table
        detailSarprasTable.on('select', function (e, dt, type, indexes) {
            var rowData = detailSarprasTable.rows(indexes).data()[0]; // Get selected row data
            var detailsarprasid = rowData.detailsarprasid;
            var detailpagusarprasid = rowData.detailpagusarprasid;
            console.log(detailsarprasid);
            // console.log(detailpagusarprasid);

            // Load history table with selected detailjumlahpagusarprasid
            loadDetailJumlahSarpras(detailsarprasid);
        });

        detailSarprasTable.on('deselect', function ( e, dt, type, indexes ) {
            // hide histiry table
            $('#detail-jumlah-sarpras-table').hide();
        });

        var detailJumlahSarprasTable = $('#detail-jumlah-sarpras-table').DataTable({
            responsive: true,
            processing: true,
            // serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: false,
            searching: true,
            language: {
                // lengthMenu: "Menampilkan _MENU_ data per halaman",
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

            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-plus-circle aria-hidden="true"></i> Tambah',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function () {
                        if (detailSarprasTable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Detail sarpras belum dipilih", "Silakan pilih detail sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = detailSarprasTable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var detailsarprasid = rowData.detailsarprasid;
                            var url = "{{ route('sarprastersedia.createDetailJumlahSarpras', ['detailsarprasid' => ':id']) }}";
                            url = url.replace(':id', detailsarprasid);
                            window.location.href = url;
                        }
                    }
                },
                {
                    text: '<i class="fa fa-picture-o" aria-hidden="true"></i> Lihat Foto',
                    className: 'edit btn btn-info mb-3 btn-datatable',
                    action: function() {

                        if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var rowData = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailjumlahsarprasid = rowData.detailjumlahsarprasid;
                            // var detailpagusarprasid = rowData.detailpagusarprasid;
                            console.log(detailjumlahsarprasid);
                            $('#modal-foto-detail-jumlah-sarpras').modal('show');
                            showFotoDetailJumlahSarpras(detailjumlahsarprasid)
                        }
                    }
                },
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-datatable mb-3',
                    action: () => {
                        if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        let id = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['detailjumlahsarprasid'];
                        let url = "{{ route('sarprastersedia.destroyDetailJumlahSarpras', ':id') }}"
                        url = url.replace(':id', id);
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus data ini?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    cache:false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: (json) => {
                                        let success = json.success;
                                        let message = json.message;
                                        let data = json.data;
                                        console.log(data);
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            var rowData = detailSarprasTable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var detailsarprasid = rowData.detailsarprasid;
                                            // detailJumlahSarprasTable.draw();
                                            loadDetailJumlahSarpras(detailsarprasid);
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });  
                            }           
                        });
                    }
                },
                // {
                //     text: 'Hapus',
                //     className: 'edit btn btn-danger mb-3 btn-datatable',
                //     action: function () {
                //         if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                //             swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                //             return;
                //         }
                //         var id = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['detailjumlahsarprasid'];
                //         var url = "{{ route('sarprastersedia.destroyDetailJumlahSarpras', ':id') }}"
                //         url = url.replace(':id', id);
                //         // var nama =  detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['namasekolah'];
                //         swal.fire({   
                //             title: "Apakah anda yakin akan menghapus data ini?",   
                //             text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                //             type: "warning",   
                //             showCancelButton: true,   
                //             confirmButtonColor: "#DD6B55",   
                //             confirmButtonText: "Ya, lanjutkan!",   
                //             closeOnConfirm: false 
                //         }).then(function(){
                //             $.ajaxSetup({
                //                 headers: {
                //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //                 }
                //             });
                //             $.ajax({
                //                 type: "POST",
                //                 cache:false,
                //                 url: url,
                //                 dataType: 'JSON',
                //                 data: {
                //                     "_token": $('meta[name="csrf-token"]').attr('content')
                //                 },
                //                 success: function(json){
                //                     var success = json.success;
                //                     var message = json.message;
                //                     var data = json.data;
                //                     console.log(data);
                                    
                //                     if (success == 'true' || success == true) {
                //                         swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                //                         // detailJumlahSarprasTable.draw();
                //                         var rowData = detailSarprasTable.rows( {selected: true} ).data()[0]; // Get selected row data
                //                         var detailsarprasid = rowData.detailsarprasid;
                //                         loadDetailJumlahSarpras(detailsarprasid);
                //                     }
                //                     else {
                //                         swal.fire("Error!", data, "error"); 
                //                     }
                //                 }
                //             });             
                //         });
                //     }
                // }
            ]
            },

            columns: [
                {'orderData': 1, data: 'kondisi', name: 'kondisi', 
                    render: function(data, type, row){
                        if (row.kondisi != null || row.kondisi != '') {
                            if (row.kondisi == "{{ enum::KONDISI_SARPRAS_BAIK }}") {
                                return 'Baik'
                            } else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_BERAT }}"){
                                return 'Rusak Berat'
                            }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_SEDANG }}"){
                                return 'Rusak Sedang'
                            }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_RINGAN }}"){
                                return 'Rusak Ringan'
                            }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_BELUM_SELESAI }}"){
                                return 'Belum Selesai'
                            }
                        }
                    }
                },
                {'orderData': 2, data: 'jumlah',
                    name: 'jumlah'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
    });
    // hide detail sarpras table table
    $('#detail-jumlah-sarpras-table').hide();

    function showDetailPaguSarpras(detailsarprasid) {
            var url = "{{ route('sarprastersedia.showDetailPaguSarpras', ':id') }}";
            url = url.replace(':id', detailsarprasid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailPaguSarprasTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        detailPaguSarprasTable.row.add({
                            jenispagu: response.data.data[i].jenispagu,
                            nilaipagu: response.data.data[i].nilaipagu,
                            nokontrak: response.data.data[i].nokontrak,
                            nilaikontrak: response.data.data[i].nilaikontrak,
                            perusahaanid: response.data.data[i].perusahaanid,
                            tgldari: response.data.data[i].tgldari,
                            tglsampai: response.data.data[i].tglsampai,
                            nama: response.data.data[i].nama,
                            tglpelaksanaan: response.data.data[i].tglpelaksanaan,
                            file: response.data.data[i].file,
                            detailpagusarprasid: response.data.data[i].detailpagusarprasid,
                        });
                    }

                    detailPaguSarprasTable.draw();
                    $('#detail-pagu-sarpras-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
    }
    // hide detail sarpras table table
    $('#detail-pagu-sarpras-table').hide();
    var detailPaguSarprasTable = $('#detail-pagu-sarpras-table').DataTable({
            responsive: true,
            processing: true,
            // serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: true,
            // searching: true,
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
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-download" aria-hidden="true"></i> Download File',
                    className: 'edit btn btn-success mb-3 btn-datatable',
                    action: () => {
                   if (detailPaguSarprasTable.rows( { selected: true } ).count() <= 0) {
                       swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                       return;
                   }
                   let id = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['detailpagusarprasid'];
                   let namaFile = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['file'];
                   let url = "{{ route('sarprastersedia.downloadFileDetailPagu', ':id') }}"
                   url = url.replace(':id', id);
                   console.log(url);
                   $.ajax({
                           type: "GET",
                           cache:false,
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
                }]
            },
            columns: [
                {'orderData': 1, data: 'jenispagu', name: 'jenispagu',
                    render: function(data, type, row) {
                        if(row.jenispagu != null){
                            if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PERENCANAAN }}") {
                                return 'Konsultan Perencanaan'
                            } else if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PENGAWAS }}") {
                                return 'Konsultan Pengawasan'
                            }
                            else if (row.jenispagu == "{{ enum::JENIS_PAGU_BANGUNAN }}") {
                                return 'Bangunan'
                            }
                            else {
                                return 'Pengadaan'
                            }
                        }
                    }
                },
                {'orderData': 2, data: 'nilaipagu', name: 'nilaipagu',
                    render: (data, type, row) => {
                        if(row.nilaipagu != null) {
                            return row.nilaipagu;
                        }else{
                            return '---';
                        }
                    }
                },
                {'orderData': 3, data: 'nokontrak', name: 'nokontrak',
                    render: function(data, type, row) {
                        if(row.nokontrak != null) {
                            return row.nokontrak
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 4, data: 'nilaikontrak', name: 'nilaikontrak',
                    render: function(data, type, row) {
                        if(row.nilaikontrak != null) {
                            return row.nilaikontrak
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 5, data: 'perusahaanid', name: 'nama',
                    render: function(data, type, row) {
                        if(row.perusahaanid != null) {
                            return row.nama
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 6, data: 'tgldari', name: 'tgldari', 
                    render: function(data, type, row) {
                        if(row.tgldari != null) {
                            return DateFormat(row.tgldari);
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 7, data: 'tglsampai', name: 'tglsampai',
                    render: function(data, type, row) {
                        if(row.tglsampai != null) {
                            return DateFormat(row.tglsampai);
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 8, data: 'file', name: 'file', 
                    render: function(data, type, row) {
                        if(row.file != null) {
                            return row.file;
                        }else{
                            return '---';
                        }
                    }
                },
                {'orderData': 9, data: 'file', name: 'preview', 
                    render: function (data, type, row){
                        if(row.file != null){
                            return "<div class=\"d-flex justify-content-center align-items-center\"><iframe src=\"/storage/uploaded/sarprastersedia/detailsarpras/"+row.file+"\" height=\"300\" /></div>";
                        }else{
                            return '---'
                        }
                    }
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
    });

    function showFotoDetailJumlahSarpras(detailjumlahsarprasid) {
        var url = "{{ route('sarprastersedia.showFotoDetailJumlahSarpras', ':id') }}";
        url = url.replace(':id', detailjumlahsarprasid);

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {

                fotoDetailJumlahSarprasTable.clear();

                for (var i = 0; i < response.data.count; i++) {
                    fotoDetailJumlahSarprasTable.row.add({
                        filedetailjumlahsarprasid: response.data.data[i].filedetailjumlahsarprasid,
                        file: response.data.data[i].file,
                    });
                }

                fotoDetailJumlahSarprasTable.draw();
                $('#foto-detail-jumlah-sarpras-table').show();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    var fotoDetailJumlahSarprasTable = $('#foto-detail-jumlah-sarpras-table').DataTable({
        responsive: true,
        processing: true,
        // serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: true,
        searching: true,
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
        buttons: {
            buttons: [
            {
                text: '<i class="fa fa-download" aria-hidden="true"></i> Download File',
                className: 'edit btn btn-success mb-3 btn-datatable',
                action: () => {
                if (fotoDetailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                    return;
                }
                let id = fotoDetailJumlahSarprasTable.rows( { selected: true } ).data()[0]['filedetailjumlahsarprasid'];
                let namaFile = fotoDetailJumlahSarprasTable.rows( { selected: true } ).data()[0]['file'];
                let url = "{{ route('sarprastersedia.downloadFileDetailJumlahSarpras', ':id') }}"
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                        type: "GET",
                        cache:false,
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
            }]
        },
        columns: [
            {'orderData': 1, data: 'file', name: 'file'},
            {'orderData': 2, data: 'file', name: 'preview', 
                render: function (data, type, row){
                    if(row.file != null){
                        return "<div class=\"d-flex justify-content-center align-items-center\"><img src=\"/storage/uploaded/sarprastersedia/detailjumlahsarpras/"+row.file+"\" height=\"300\" /></div>";
                    }
                }
            },
        ],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
    });
</script>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script>
<!-- Sarpras Tersedia -->
<script>
    $(window).on('load', function() {

    // Search input
    $('#demo-input-search2').on('input', function (e) {
        e.preventDefault();
        addrow.trigger('footable_filter', {filter: $(this).val()});
    });

    // Add & Remove Row
    var addrow = $('#demo-foo-addrow-sarprastersedia');
    addrow.footable().on('click', '.delete-row-btn', function() {

        //get the footable object
        var footable = addrow.data('footable');

        //get the row we are wanting to delete
        var row = $(this).parents('tr:first');

        //delete the row
        footable.removeRow(row);
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

            // var index = $('.tr-length').length;
            // $('.tr-length:first').find("select").select2("destroy");
            // var $select2 = $('.tr-length:first').clone();
            // $service.find('select[name*=service]')
            // .val('')
            // .attr('name', 'items[' + index + '][service]')
            // .attr('id', 'service-' + index);



            //get the footable object
            var footable = addrow.data('footable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td class="border-0"><select id="jenispagu" class="custom-select-detail form-control jenispagu @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}"></div></td><td class="border-0"><input id="nokontrak" type="text" class="form-control @error("nokontrak") is-invalid @enderror" name="nokontrak[]" value="{{ (old("nokontrak")) }}" maxlength="100"></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaikontrak" type="number" class="form-control @error("nilaikontrak") is-invalid @enderror" name="nilaikontrak[]" value="{{ (old("nilaikontrak")) }}" maxlength="100"></div></td><td class="border-0"><div class="more-perusahaanid-container"><select id="perusahaanid" class="custom-select-detail form-control perusahaanid @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]"><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></div></td><td class="border-0"><input type="date" class="form-control @error("tgldari") is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old("tgldari") }}" required onchange="compareDates()"></td><td class="border-0"><input type="date" class="form-control @error("tglsampai") is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old("tglsampai") }}" onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]"/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            var index = $('.perusahaanid-container').length;
            $('.perusahaanid-container:first').find("select").select2("destroy")
            var $perusahaanid = $('.perusahaanid-container:first').clone();

            $perusahaanid.find('select[name*=perusahaanid]')
            .val('')
            .attr('name', 'items[' + index + '][perusahaanid]')
            .attr('id', 'perusahaanid-' + index);
            // var newRow = '<tr><td class="border-0"><select id="jenispagu" class="form-control @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0"><input id="nilaipagu" type="number" class="form-control @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}" maxlength="100" required></td><td class="border-0"><select id="perusahaanid" class="form-control @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]" required><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></td><td class="border-0"><input type="date" class="form-control @error("tglpelaksanaan") is-invalid @enderror" id="tglpelaksanaan" name="tglpelaksanaan[]" value="{{ old("tglpelaksanaan") }}" required onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            // var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="filesarpraskebutuhan[]" id="filesarpraskebutuhan" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


            //add it
            footable.appendRow(newRow);
    });
});
</script>

<script>

    const sekolahid = document.getElementById("sekolahid");
	
    window.onload = function() {
        localStorage.setItem("sekolahid", $('#sekolahid').val());
        // localStorage.setItem("email", $('#inputEmail').val());   
    }
    
    var test = localStorage.getItem('sekolahid');
    $('#sekolahid').val(test);

  
    var href = window.location.href;
    
    if(href.match('sarprastersedia')[0] == 'sarprastersedia') {
        $('#sekolahid').on('change', function(e) {
        localStorage.setItem("sekolahid", $('#sekolahid').val());
        console.log(href.match('sarprastersedia')[0]);
        console.log(window.location.href);
        })
    }else {
        localStorage.setItem("sekolahid", '')
    }


</script>

@endsection