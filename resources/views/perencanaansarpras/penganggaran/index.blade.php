<?php
use App\enumVar as enum;
use App\Helpers\Get_field;
?>
@extends('layouts.master')

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }

    div.dt-buttons {
        float: right;
    }

    /* #detail-anggaran-table {
        display: none;
    } */
    .btn-view-pengajuan:hover{
        background-color: rgb(24, 106, 154);
    }
    .modal {
        overflow-y:auto;
    }
</style>
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">DAFTAR PENGANGGARAN</h5>
        <hr />
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

                @if (session()->has('success'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="card-title text-uppercase">KEBUTUHAN SARPRAS</h3>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="kebutuhan-sarpras-table">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Jenis Kebutuhan</th>
                                <th>No Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Sarpras</th>
                                <th>Jenis Sarpras</th>
                                <th>Jumlah</th>
                                <th width="2%">Status</th>
                                <th>pegawaiid</th>
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
<div class="card p-4 mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <h3 class="card-title text-uppercase">DETAIL PENGANGGARAN</h3>
                    <hr>
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-anggaran-table">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Sumber Dana</th>
                                {{-- <th>Keterangan</th> --}}
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
<!-- modal detail anggaran -->
<div class="modal" id="modal-detailanggaran" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1380px" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="detailAnggaran" name="detailAnggaran" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="sarpraskebutuhanid" name="sarpraskebutuhanid">
                <div class="modal-body">
                    <div class="row m-b-40">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
            
                                <div class="col-md-12">
                                    <select id="subkegid" class="custom-select-detail form-control @error('subkegid') is-invalid @enderror" name='subkegid' required>
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
                                    <select id="sumberdana" class="custom-select-detail form-control @error('sumberdana') is-invalid @enderror" name='sumberdana' required>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subdetailkeg" class="col-md-12 col-form-label text-md-left">{{ __('Sub Detail Kegiatan *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="subdetailkeg" required type="text" class="form-control @error('subdetailkeg') is-invalid @enderror" name="subdetailkeg" value="{{ (old('subdetailkeg')) }}" maxlength="255">
            
                                    @error('subdetailkeg')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
                
                                    <div class="col-md-12">
                                        <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="" maxlength="100" required autocomplete="jumlah" readonly>
                
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
                
                                    <div class="col-md-12">
                                        <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="" maxlength="100" required autocomplete="satuan" readonly>
                
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="overflow-y: auto; overflow-x:auto;">
                        {{-- <h4 class="card-title text-uppercase text-bold m-t-40">Upload Foto Kebutuhan Sarpras</h4><hr /> --}}
    
                        <table id="demo-foo-addrow-sarprastersedia" class="table table-responsive table-bordered table-hover toggle-circle" data-page-size="7">
                            <thead style="background-color: #d8d8d868;">
                                <tr>
                                    <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Jenis Pagu</th>
                                    <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Pagu</th>
                                    <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">No Kontrak</th>
                                    <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Kontrak</th>
                                    <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Perusahaan</th>
                                    <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                                    <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Upload File</th>
                                    <th class="text-center d-none" rowspan="2" data-sort-ignore="true" data-toggle="true">Preview</th>
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
                                <tr>
                                    <td class="border-0">
                                        <div class="form-group">
                                            <select id="jenispagu" class="form-control @error('jenispagu') is-invalid @enderror" name='jenispagu[]' required>
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
                                        <input id="nokontrak" disabled type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak[]" value="{{ (old('nokontrak')) }}" maxlength="100">
                                    </td>
                                    <td class="border-0">
                                        <input id="nilaikontrak" disabled type="number" class="form-control @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak[]" value="{{ (old('nilaikontrak')) }}" maxlength="100">
                                    </td>
                                    <td class="border-0">
                                        <select disabled id="perusahaanid" class="form-control perusahaanid @error('perusahaanid') is-invalid @enderror" name="perusahaanid[]" required>
                                            <option value="">-- Pilih Perusahaan --</option>
                                            @foreach ($perusahaan as $item)
                                            <option {{ old('perusahaanid') != '' || old('perusahaanid') != null ? 'selected' : '' }} value="{{ old('perusahaanid') ?? $item->perusahaanid }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border-0">
                                        <input disabled type="date" class="form-control @error('tgldari') is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old('tgldari') }}" required onchange="compareDates()">
                                    </td>
                                    <td class="border-0">
                                        <input disabled type="date" class="form-control @error('tglsampai') is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old('tglsampai') }}" required onchange="compareDates()">
                                    </td>
                                    <td class="border-0">
                                        <input disabled type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                                    </td>
                                    {{-- <td class="border-0">
                                        <div class="param_img_holder d-flex justify-content-center align-items-center d-none">
                                        </div>
                                    </td> --}}
                                    <td class="border-0">
                                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                    </td>
        
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #d8d8d868;">
                                    {{-- <td colspan="2">
                                        Total Nilai Pagu: <p class="total"></p>
                                        <input type="hidden" class="form-control total" value="" />
                                    </td> --}}
                                    <th class="" colspan="2">Total Nilai Pagu:</th>
                                    <td colspan="7">
                                        <input type="hidden" class="form-control total" value="" />
                                        <p class="total d-inline-block"></p>
                                        <span class="rupiahTerbilang font-italic"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
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
                <div class="modal-footer">
                    <button id="button-close-detailAnggaran" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button value="detailAnggaranSetuju" type="submit" id="detailAnggaranSetuju" class="btn btn-success detailAnggaranSetuju"><i class="fa fa-check" aria-hidden="true"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal-detail-pagu-penganggaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1380px;">
        <div class="modal-content">
          <form method="POST" id="updateDetailAnggaran" name="updateDetailAnggaran" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
            @csrf
        <div class="modal-header">
          <h3 class="modal-title" id="title-modal-detail-penganggaran"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row m-b-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
                            <div class="col-md-12">
                                {{-- <input id="subkegid-detail" class="form-control" name='subkegid' readonly/> --}}
                                <select id="subkegid-detail" class="custom-select-edit form-control @error('subkegid') is-invalid @enderror" name='subkegid' required>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                    @foreach ($subkegiatan as $item)
                                    <option value="{{$item->subkegid}}">{{ $item->progkode .  $item->kegkode .  $item->subkegkode . ' ' . $item->subkegnama}}</option>
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
                                <select id="sumberdana-detail" class="custom-select-edit form-control @error('sumberdana') is-invalid @enderror" name='sumberdana' required>
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
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subdetailkeg" class="col-md-12 col-form-label text-md-left">{{ __('Sub Detail Kegiatan *') }}</label>
                            <div class="col-md-12">
                                <input id="subdetailkeg-detail" class="form-control" name='subdetailkeg'/>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="jumlah-detail" type="number" class="form-control" name="jumlah" value="" maxlength="100" autocomplete="jumlah" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="satuan-detail" type="text" class="form-control" name="satuan" value="" maxlength="100" autocomplete="satuan" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="detail-pagu-penganggaran-table">
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
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="2">Total Nilai Pagu:</th>
                                    <td colspan="7">
                                        <input type="hidden" class="form-control totalpagu" value="" />
                                        <p class="totalpagu d-inline-block"></p>
                                        <span class="terbilangNilaiPagu font-italic"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="2">Total Nilai Kontrak:</th>
                                    <td colspan="7">
                                        <input type="hidden" class="form-control totalkontrak" value="" />
                                        <p class="totalkontrak d-inline-block"></p>
                                        <span class="terbilangNilaiKontrak font-italic"></span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button value="btnSubmitParent" type="submit" id="btnSubmitParent" class="btn btn-success btnSubmitParent"><i class="fa fa-check" aria-hidden="true"></i> Simpan
                </button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal" id="modal-edit-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="modal-title-edit-detail"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form method="POST" id="detailPagu-form" name="detailPagu-form" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                @csrf
                    {{-- <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/> --}}
                    <input type="hidden" id="detailpenganggaranid" name="detailpenganggaranid">
                    <input type="hidden" name="detail_mode" id="detail_mode"/>
                    <div class="form-group">
                        <label for="jenispagu" class="control-label">Jenis Pagu:</label>
                        <select id="detail_jenispagu" class="custom-select-edit-detail form-control" name='jenispagu'>
                            <option value="">-- Pilih Jenis Pagu --</option>
                            @foreach (enum::listJenisPagu() as $id)
                            <option value="{{ $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nilaipagu" class="control-label">Nilai Pagu:</label>
                        <div class="input-group">
                            <span class="p-2 mt-1">Rp </span>
                            <input id="detail_nilaipagu" type="text" class="form-control @error('nilaipagu') is-invalid @enderror" name="nilaipagu" value="{{ (old('nilaipagu')) }}" autocomplete="name">
                        </div>
                    </div>
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

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>

<!-- validasi jumlah yang disetujui -->
<script>

    $('table').on("focus", ".nilaipagu", function(){
        $( '.nilaipagu' ).mask('000,000,000,000,000', {reverse: true});
        // $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    })
    // $('table').on("blur", ".nilaipagu", function(){
    //     $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    // })

    // $('table').on('blur', 'nilaipagu', function() {
    //     const value = this.value.replace(/,/g, '');
    //     this.value = parseFloat(value).toLocaleString('en-US', {
    //         style: 'decimal',
    //         maximumFractionDigits: 2,
    //         minimumFractionDigits: 2
    //     });
    // });

    var detail_nilaipagu = document.getElementById('detail_nilaipagu');
    detail_nilaipagu.addEventListener('keyup', function(e)
    {
        detail_nilaipagu.value = formatRupiah(this.value);
    });

    function compareJumlah() {
        var jumlahSetuju = $('#jumlahsetuju').val();
        var jumlah = $('#jumlah').val();
        if (!isNaN(jumlahSetuju) && jumlahSetuju > jumlah) {
            // alert("The first date is after the second date!");
            swal.fire('Peringatan!', `Jumlah yang disetujui tidak boleh melebihi dari jumlah yang diajukan (${jumlah})`, 'warning');
            $('#jumlahsetuju').val('');
        }
    }

    $(document).on("change", ".count-pagu", function() {
        var sum = 0;
        $(".count-pagu").each(function(){
            sum += +Number($(this).val().replace(/[^0-9.-]+/g,""));
        });
        console.log(sum)
        $(".total").val(sum);
        $(".total").text(rupiah(sum));
        $(".rupiahTerbilang").text(`(${terbilang(sum)})`);
    });
    $(document).on("click", ".delete-row-btn", function() {
        var sum = 0;
        $(".count-pagu").each(function(){
            sum += +Number($(this).val().replace(/[^0-9.-]+/g,""));
        });
        $(".total").val(sum);
        $(".total").text(rupiah(sum));
        $(".rupiahTerbilang").text(`(${terbilang(sum)})`);
    });
</script>
<script>

    $(document).ready(function () {

        $('.custom-select-detail').select2({
            dropdownParent: $('#modal-detailanggaran')
        });

        $('.custom-select-edit').select2({
            dropdownParent: $('#modal-detail-pagu-penganggaran')
        });
        $('.custom-select-edit-detail').select2({
            dropdownParent: $('#modal-edit-detail .modal-content')
        });

        $('.custom-select').select2();

        const validExtensions = ['pdf', 'jpeg', 'jpg', 'png', 'gif', 'webp'];

$('table').on('change', '.file-input', function() {
  const $input = $(this);
  const imgPath = $input.val();
  const $imgPreview = $input.closest('tr').find('.param_img_holder');
  const extension = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

  if (typeof(FileReader) == 'undefined') {
    $imgPreview.html('This browser does not support FileReader');
    return;
  }

  if (validExtensions.includes(extension)) {
    $imgPreview.empty();
    var reader = new FileReader();
    reader.onload = function(e) {
      $('<iframe/>', {
        src: e.target.result,
        height: 300,
        width: 300,
      }).appendTo($imgPreview);
    }
    $imgPreview.show();
    reader.readAsDataURL($input[0].files[0]);
  } else {
    $imgPreview.empty();
    swal.fire('Peringatan!', 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: PDF, JPEG, JPG, PNG.', 'warning');

        // remove file ketika validasi ekstensi file gagal
        if(this.value){
            try{
                this.value = ''; //for IE11, latest Chrome/Firefox/Opera...
            }catch(err){ }
            if(this.value){ //for IE5 ~ IE10
                var form = document.createElement('form'),
                    parentNode = this.parentNode, ref = this.nextSibling;
                form.appendChild(this);
                form.reset();
                parentNode.insertBefore(this,ref);
            }
        }
  }
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
        });
        // FILTER SEKOLAH - END


        $('#kotaid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-anggaran-table').hide();
        });
        $('#kecamatanid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-anggaran-table').hide();
        });
        $('#jenjang').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-anggaran-table').hide();
        });
        $('#jenis').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-anggaran-table').hide();
        });
        $('#sekolahid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-anggaran-table').hide();
        });

        $('#search').keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                kebutuhansarprastable.draw();
                 $('#detail-anggaran-table').hide();
            }
        });
    });

    function setenabledtbutton(option) {
        detailPaguPenganggaranTable.buttons( '.view' ).disable();
        //detailPaguPenganggaranTable.buttons( '.print' ).disable();
        detailPaguPenganggaranTable.buttons( '.add' ).disable();
        detailPaguPenganggaranTable.buttons( '.edit' ).disable();
        detailPaguPenganggaranTable.buttons( '.delete' ).disable();

        if (option == "0") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
            detailPaguPenganggaranTable.buttons( '.add' ).enable();
            detailPaguPenganggaranTable.buttons( '.edit' ).enable();
            detailPaguPenganggaranTable.buttons( '.delete' ).enable();
        }
        else if (option == "1") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
            detailPaguPenganggaranTable.buttons( '.print' ).enable();
        }
        else if (option == "3" || option == "5" || option == "2" || option == "4" || option == "6") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
        }
    }

    function setenablepenganggaranbutton(status = '') {
        kebutuhansarprastable.buttons( '#btn-batalprosestender' ).enable();
        kebutuhansarprastable.buttons( '#btn-prosestender' ).enable();
        if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_PROSES_TENDER }}') {
            kebutuhansarprastable.buttons( '#btn-batalprosestender' ).enable();
            kebutuhansarprastable.buttons( '#btn-prosestender' ).disable();
        }
        else if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_DISETUJUI }}') {
            kebutuhansarprastable.buttons( '#btn-batalprosestender' ).disable();
            kebutuhansarprastable.buttons( '#btn-prosestender' ).enable();
        }
        else if(status != '{{ enum::STATUS_KEBUTUHAN_SARPRAS_PROSES_TENDER }}' || status != '{{ enum::STATUS_KEBUTUHAN_SARPRAS_DISETUJUI }}' ) {
            kebutuhansarprastable.buttons( '#btn-batalprosestender' ).disable();
            kebutuhansarprastable.buttons( '#btn-prosestender' ).disable();
        }
    }

        var detailanggarantable;
        var kebutuhansarprastable = $('#kebutuhan-sarpras-table').DataTable({
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
                url: "{{ route('penganggaran.index') }}",
                dataSrc: function (response) {
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function (d) {
                    return $.extend({}, d, {
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "sekolahid": $("#sekolahid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    });
                }
            },
            buttons: {
                buttons: [
                    {
                        attr: {id: 'btn-prosestender'},
                        text: '<i class="fa fa-check-square" aria-hidden="true"></i> Proses Tender',
                        className: 'edit btn btn-success btn-datatable mb-2',
                        action: function () {
                            if (kebutuhansarprastable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }

                            let status = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'];
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 5 ? 'Proses Tender' : '';

                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                            console.log(sarpraskebutuhanid)
                            let nopengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nopengajuan'];
                            let tglpengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['tglpengajuan'];

                            let url = "{{ route('penganggaran.prosestender', ':id') }}"
                            url = url.replace(':id', sarpraskebutuhanid);

                            if(status == 5){
                                swal.fire("Tidak dapat melakukan proses tender",
                                    `Data yang anda pilih sudah berstatus ${status == 5 ? statusDesc : ''}`, "error");
                                return;
                            }else {
                                swal.fire({   
                                title: "Konfirmasi",   
                                text: `Apakah anda yakin melakukan proses tender pengajuan kebutuhan sarpras dengan nomor pengajuan ${nopengajuan}?`,   
                                icon: "warning",   
                                showCancelButton: true,   
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
                                                swal.fire("Berhasil!", "Data anda telah diajukan.", "success"); 
                                                // detailanggarantable.draw();
                                                var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                                                var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                                                kebutuhansarprastable.draw();
                                            }
                                            else if (success == 'false' || success == false && data == 'failed') {
                                                swal.fire("Error!", message, "error"); 
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
                    },
                    {
                        attr: {id: 'btn-batalprosestender'},
                        text: '<i class="fa fa-ban" aria-hidden="true"></i> Batalkan',
                        className: 'edit btn btn-danger btn-datatable mb-2',
                        action: function () {
                            if (kebutuhansarprastable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }

                            let status = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'];
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 5 ? 'Proses Tender' : '';

                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                            console.log(sarpraskebutuhanid)
                            let nopengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nopengajuan'];
                            let tglpengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['tglpengajuan'];

                            let url = "{{ route('penganggaran.batalprosestender', ':id') }}"
                            url = url.replace(':id', sarpraskebutuhanid);

                            if(status == 3){
                                swal.fire("Tidak dapat melakukan proses tender",
                                    `Data yang anda pilih sudah berstatus ${status == 5 ? statusDesc : ''}`, "error");
                                return;
                            }else {
                                swal.fire({   
                                title: "Konfirmasi",   
                                text: `Apakah anda yakin membatalkan proses tender pengajuan kebutuhan sarpras dengan nomor pengajuan ${nopengajuan}?`,   
                                icon: "warning",   
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
                                                swal.fire("Berhasil!", "Data anda telah diajukan.", "success"); 
                                                // detailanggarantable.draw();
                                                var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                                                var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                                                kebutuhansarprastable.draw();
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
                    },
                ]
            },
            columns: [
                {
                    'orderData': 1,
                    data: 'sekolahid',
                    render: function (data, type, row) {
                        return (row.namasekolah);
                    },
                    name: 'namasekolah'
                },
                {
                    'orderData': 2,
                    data: 'jeniskebutuhan',
                    render: function(data, type, row){
                        if(row.jeniskebutuhan != null) {
                            var listJenisKebutuhan = @json(enum::listJenisKebutuhan($id = ''));
                            // let listJenisKebutuhan = JSON.parse('{!! json_encode(enum::listJenisKebutuhan()) !!}');
                            let Desc;
                            listJenisKebutuhan.forEach((value, index) => {
                                if(row.jeniskebutuhan == index + 1) {
                                    Desc = value;
                                }
                            });
                            return Desc;
                        }else {
                            return '---'
                        }
                    },
                    name: 'jeniskebutuhan'
                },
                {
                    'orderData': 3,
                    data: 'nopengajuan',
                    render: function(data, type, row){
                        return (row.nopengajuan);
                    },
                    name: 'nopengajuan'
                },
                {
                    'orderData': 4,
                    data: 'tglpengajuan',
                    render: function (data, type, row) {
                        return (DateFormat(row.tglpengajuan));
                    },
                    name: 'tglpengajuan'
                },
                {'orderData': 5, data: 'namasarprasid',
                    render: function ( data, type, row ) {
                        if(row.namasarprasid!=null){
                            return row.namasarpras;
                        }else
                            return "-";
                    }, 
                    name: 'namasarprasid'
                },
                {'orderData': 6, data: 'jenissarpras',
                    render: function ( data, type, row ) {
                        if(row.jenissarpras!=null){
                            if(row.jenissarpras=="{{enum::SARPRAS_UTAMA}}") 
                                return 'Sarpras Peralatan';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PERALATAN}}") 
                                return 'Sarpas Peralatan';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PENUNJANG}}") 
                                return 'Sarpras Penunjang';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'jenissarpras'
                },
                {
                    'orderData': 7,
                    data: 'jumlah',
                    render: function (data, type, row) {
                        return `${row.jumlah} ${row.satuan}`;
                    },
                    name: 'jumlah',
                },
                {'orderData': 8, data: 'status', 
                    render: function(data, type, row){
                        if(row.status != null){
                            if(row.status == 1){
                                return '<span class="badge badge-pill bg-draft">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT }}</span>';
                            }else if(row.status == 2){
                                return '<span class="badge badge-pill bg-info">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN }}</span>';
                            }else if (row.status == 3){
                                return '<span class="badge badge-pill bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI }}</span>';
                            }else if (row.status == 5){
                                return '<span class="badge badge-pill bg-primary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROSES_TENDER }}</span>';
                            }else if (row.status == 6){
                                return '<span class="badge badge-pill bg-secondary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_PEMBANGUNAN }}</span>';
                            }else{
                                return '<span class="badge badge-pill bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                            }
                        }else{
                            return '-'
                        }
                    },
                    name: 'status',
                },
                {
                    'orderData': 9,
                    data: 'pegawaiid',
                    render: function (data, type, row) {
                        if(row.pegawaiid != null) { 
                            return `${row.nip} ${row.nama}`;
                        }
                    },
                    name: 'pegawaiid',
                    visible: false
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

    function showDetailPaguPenganggaran(detailpenganggaranid) {
            // var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
            // var detailpenganggaranid = rowData.detailpenganggaranid;
            var url = "{{ route('penganggaran.showDetailPenganggaran', ':id') }}";
            url = url.replace(':id', detailpenganggaranid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailPaguPenganggaranTable.clear();

                    // let nilaiPagu = 0;
                    for (var i = 0; i < response.data.count; i++) {
                        detailPaguPenganggaranTable.row.add({
                            jenispagu: response.data.data[i].jenispagu,
                            nilaipagu: response.data.data[i].nilaipagu,
                            nokontrak: response.data.data[i].nokontrak,
                            nilaikontrak: response.data.data[i].nilaikontrak,
                            perusahaanid: response.data.data[i].perusahaanid,
                            nama: response.data.data[i].nama,
                            tgldari: response.data.data[i].tgldari,
                            tglsampai: response.data.data[i].tglsampai,
                            file: response.data.data[i].file,
                            detailpaguanggaranid: response.data.data[i].detailpaguanggaranid,
                        });
                        
                        let loop = response.data.data[i].nilaipagu;
                        
                        nilaiPagu =+ +loop;
                    }

                    let totalPagu = response.data.sumPagu[0].countpagu;
                    let totalKontrak = response.data.sumPagu[0].countkontrak;
                    let terbilangNilaiPagu = response.data.terbilangNilaiPagu;
                    let terbilangNilaiKontrak = response.data.terbilangNilaiKontrak;
                    console.log(terbilangNilaiKontrak);

                    $(".totalpagu").text(rupiah(totalPagu));
                    $(".totalpagu").val(totalPagu);
                    $(".terbilangNilaiPagu").text(`(${terbilangNilaiPagu})`);

                    $(".totalkontrak").text(rupiah(totalKontrak));
                    $(".totalkontrak").val(totalPagu);
                    $(".terbilangNilaiKontrak").text(terbilangNilaiKontrak == '' ? '(Nol Rupiah)' : `(${terbilangNilaiKontrak})`);
                    
                    detailPaguPenganggaranTable.draw();
                    $('#detail-pagu-penganggaran-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function loadDetailAnggaran(sarpraskebutuhanid) {
            var url = "{{ route('penganggaran.detailanggaran', ':id') }}";
            url = url.replace(':id', sarpraskebutuhanid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailanggarantable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        detailanggarantable.row.add({
                            detailpenganggaranid: response.data.data[i].detailpenganggaranid,
                            subkegid: response.data.data[i].subkegid,
                            subkegnama: response.data.data[i].subkegnama,
                            sumberdana: response.data.data[i].sumberdana,
                            subdetailkegiatan: response.data.data[i].subdetailkegiatan,
                            // keterangan: response.data.data[i].keterangan,
                            // sarpraskebutuhanid: response.data.data[i].sarpraskebutuhanid
                        });
                    }

                    detailanggarantable.draw();
                    $('#detail-anggaran-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on kebutuhan-sarpras-table
        kebutuhansarprastable.on('select', function (e, dt, type, indexes) {
            var rowData = kebutuhansarprastable.rows(indexes).data()[0]; // Get selected row data
            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
            var status = rowData.status;

            // Load history table with selected sarpraskebutuhanid
            setenablepenganggaranbutton(status);
            loadDetailAnggaran(sarpraskebutuhanid);
        });

        kebutuhansarprastable.on('deselect', function ( e, dt, type, indexes ) {
            setenablepenganggaranbutton();
            // hide history table
            $('#detail-anggaran-table').hide();
        });


        // hide histiry table
        $('#detail-anggaran-table').hide();

    // Initialize history table
    var detailanggarantable = $('#detail-anggaran-table').DataTable({
        "fnDrawCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        var total = api
            .data()
            .pluck(1)
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
        }, 0 );

        console.log(total)

        $(".totalpagu").val(total);
        $(".totalpagu").text(total);

        },
        responsive: true,
        processing: true,
        // serverSide: true,
        pageLength: 50,
        dom: 'Bfrtip',
        select: true,
        ordering: false,
        searching: false,
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
        // ... your detail-anggaran-table initialization options ...
        columns: [
            {
                data: 'subkegid',
                name: 'subkegid',
                render: function(data, type, row) {
                    if(row.subkegid != null) {
                        return row.subkegnama;
                    }
                }
            },
            {
                data: 'sumberdana',
                name: 'sumberdana'
            },
        ],
        buttons: {
            buttons: [
                {
                    text: '<i class="fa fa-plus-circle aria-hidden="true"></i> Tambah',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function () {
                        if (kebutuhansarprastable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Data permintaan sarpras belum dipilih", "Silakan pilih data permintaan sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;

                            let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                            let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];

                            console.log(jumlah);
                            $('#jumlah').val('');
                            $('#satuan').val('');
                            $('#subdetailkeg').val('');
                            $('#subkegid').val('');
                            $('#sumberdana').val('');
                            $('.jenispagu').val('');
                            $('.nilaipagu').val('');

                            $(".total").val('');
                            $(".total").text('');
                            $(".rupiahTerbilang").text('');

                            $('#sarpraskebutuhanid').val(sarpraskebutuhanid);
                            $('#jumlah').val(jumlah);
                            $('#satuan').val(satuan);

                            $('#modal-detailanggaran').modal('show');

                        }
                    }
                },
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                    className: 'edit btn btn-info mb-3 btn-datatable',
                    action: function() {

                        if (detailanggarantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpenganggaranid = rowData.detailpenganggaranid;
                            // var detailpagupenganggaranid = rowData.detailpagupenganggaranid;

                            let subkegid = detailanggarantable.rows({ selected: true }).data()[0]['subkegid']
                            let sumberdana = detailanggarantable.rows({ selected: true }).data()[0]['sumberdana']
                            let subdetailkeg = detailanggarantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                            let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                            let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];

                            $('#subkegid-detail').val(subkegid).trigger('change').attr('disabled', 'disabled');
                            $('#sumberdana-detail').val(sumberdana).trigger('change').attr('disabled', 'disabled');
                            $('#subdetailkeg-detail').val(subdetailkeg).attr('disabled', 'disabled');
                            $('#jumlah-detail').val(jumlah);
                            $('#satuan-detail').val(satuan);

                            $('#modal-detail-pagu-penganggaran').modal('show');
                            $('#btnSubmitParent').hide();
                            $('#title-modal-detail-penganggaran').text('LIHAT DETAIL PENGANGGARAN');

                            showDetailPaguPenganggaran(detailpenganggaranid);
                            setenabledtbutton("");
                        }
                    }
                },  
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (detailanggarantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        // var id = detailanggarantable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                        var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                        var detailpenganggaranid = rowData.detailpenganggaranid;

                        let subkegnama = detailanggarantable.rows({ selected: true }).data()[0]['subkegnama']
                        let subkegid = detailanggarantable.rows({ selected: true }).data()[0]['subkegid']
                        let sumberdana = detailanggarantable.rows({ selected: true }).data()[0]['sumberdana']
                        let subdetailkeg = detailanggarantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                        let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                        let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];
                        $('#modal-detail-pagu-penganggaran').modal('show');

                        $('#subkegid-detail').val(subkegid).trigger('change').removeAttr('disabled');
                        $('#sumberdana-detail').val(sumberdana).trigger('change').removeAttr('disabled');
                        $('#subdetailkeg-detail').val(subdetailkeg).removeAttr('disabled');
                        $('#jumlah-detail').val(jumlah);
                        $('#satuan-detail').val(satuan);
                        $('#detailpenganggaranid').val(detailpenganggaranid);

                        // $('#subkegid-edit option[value="'+subkegid+'"]').prop('selected', true);

                        $('#modal-edit-detail-penganggaran').modal('show');
                        $('#btnSubmitParent').show();
                        $('#title-modal-detail-penganggaran').text('EDIT DETAIL PENGANGGARAN');
                        showDetailPaguPenganggaran(detailpenganggaranid);
                        setenabledtbutton("0");
                        console.log(detailpenganggaranid);
                    }
                }, 
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (detailanggarantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = detailanggarantable.rows( { selected: true } ).data()[0]['detailpenganggaranid'];
                        var url = "{{ route('penganggaran.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        // var nama =  detailanggarantable.rows( { selected: true } ).data()[0]['namasekolah'];
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
                                            // detailanggarantable.draw();
                                            var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                                            loadDetailAnggaran(sarpraskebutuhanid);
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
    });

    // hide detail sarpras table table
    $('#detail-pagu-penganggaran-table').hide();
    var detailPaguPenganggaranTable = $('#detail-pagu-penganggaran-table').DataTable({
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
                        text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Tambah',
                        className: 'add btn btn-primary mb-3 btn-datatable',
                        action: function() {
                            $('#modal-edit-detail').modal('show');
                            showmodaldetail('add');
                        }
                    }, 
                    {
                        text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                        className: 'edit btn btn-warning mb-3 btn-datatable',
                        action: function () {
                            if (detailPaguPenganggaranTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                                return;
                            }
                            // var id = detailPaguPenganggaranTable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                            var rowData = detailPaguPenganggaranTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var id = rowData.sarpraskebutuhanid;

                            $('#modal-edit-detail').modal('show');
                            // setenabledtbutton("0");
                            showmodaldetail('edit');
                        }
                    }, 
                    {
                        text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                        className: 'delete btn btn-danger mb-3 btn-datatable',
                        action: function () {
                            if (detailPaguPenganggaranTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                                return;
                            }
                            var rowData = detailPaguPenganggaranTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpaguanggaranid = rowData.detailpaguanggaranid;
                            var url = "{{ route('penganggaran.deleteDetailPaguPenganggaran', ':id') }}"
                            url = url.replace(':id', detailpaguanggaranid);
                            // var nama =  detailPaguPenganggaranTable.rows( { selected: true } ).data()[0]['namasekolah'];

                            var rowDataAnggaran = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpenganggaranid = rowDataAnggaran.detailpenganggaranid;
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
                                                
                                                showDetailPaguPenganggaran(detailpenganggaranid);
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
                {'orderData': 1, data: 'jenispagu', name: 'jenispagu',
                    render: function(data, type, row) {
                        if(row.jenispagu != null){
                            // var listMinggu = @json(enum::listMinggu($id));
                            let listJenisPagu = JSON.parse('{!! json_encode(enum::listJenisPagu($id)) !!}');
                            let jenisPaguDesc;
                            listJenisPagu.forEach((value, index) => {
                                if(row.jenispagu == index + 1) {
                                    jenisPaguDesc = value;
                                }
                            });
                            return jenisPaguDesc;
                        }
                    }
                },
                {'orderData': 2, data: 'nilaipagu', name: 'nilaipagu',
                    render: (data, type, row) => {
                        if(row.nilaipagu != null) {
                            return rupiah(row.nilaipagu);
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
                            return rupiah(row.nilaikontrak);
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

    function resetformdetail() {
        $("#detailPagu-form")[0].reset();
        // const $input = $('#detail_file')
        // const $imgPreview = $input.closest('div').find('.param_img_holder');
        // $imgPreview.empty();
        // removeImageValue('detail_file');
        // var v_max = 1;
        // if (v_listDataDetail.length > 0) {
        //     var v_maxobj = v_listDataDetail.reduce((prev, current) => (prev && prev.nourut > current.nourut) ? prev : current);
        //     v_max = parseInt(v_maxobj.nourut)+1;
        // }
        // $("#detail_detail_nourut").val(v_max);
        //alert(v_listDataDetail.length);
        //alert(v_listDataDetail.length + '->' + JSON.stringify(max));

        $('span[id^="err_detail_"]', "#detailPagu-form").each(function(index, el){
            $('#'+el.id).html("");
        });

        $('select[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
        $('input[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("");
            }
        });
        $('textarea[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("");
            }
        });
    }

    function bindformdetail() {
        $('textarea[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                if(inputname == 'nilaipagu'){
                    $("#"+el.id).val(formatRupiah(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]));
                }else {
                    $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
                }
            }
        });
        
        $('select[id^="detail_"]', "#detailPagu-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
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
        
        $('textarea[id^=""]', "#detailPagu-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^=""]', "#detailPagu-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^=""]', "#detailPagu-form").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modedetail = "";
    function showmodaldetail(mode) {
        v_modedetail = mode;
        $("#detail_mode").val(mode);
        resetformdetail();
        if (mode == "add") {
            $("#modal-title-edit-detail").html('Tambah Data');
            setenableddetail(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-edit-detail").html('Ubah Data');
            bindformdetail();
            setenableddetail(true);
            // formatRupiah($('#detail_nilaipagu').val());
        }
        else {
            $("#modal-title-edit-detail").html('Lihat Data');
            bindformdetail();
            setenableddetail(false);
        }
        
        $("#m_formshowdetail").modal('show');
    }

    function hidemodaldetail() {
        $("#m_formshowdetail").modal('hide');
    }

    // store detail anggaran 
    $(document).on('submit', '#detailAnggaran', function(e){
            e.preventDefault();
            let id = kebutuhansarprastable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
            
            var formData = new FormData($('#detailAnggaran')[0]);

            var url = "{{ route('penganggaran.storeDetailPenganggaran', ':id') }}"
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
                    let errors = json.errors;

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Data detail anggaran berhasil ditambah.", "success");
                            // kebutuhansarprastable.draw();
                            // detailanggarantable.draw();
                            loadDetailAnggaran(id)
                            $('#jumlah').val('');
                            $('#satuan').val('');
                            $('#subdetailkeg').val('');
                            $('#subkegid').val('');
                            $('#sumberdana').val('');

                            $('#detailAnggaran').trigger("reset");
                            $('#modal-detailanggaran').modal('hide'); 
                            console.log( kebutuhansarprastable.rows( { selected: true } ));
                            kebutuhansarprastable.rows( { selected: true } ).data()[0];
                    }
                    else {
                            // var data = jqXHR.responseJSON;
                            console.log(errors);// this will be the error bag.
                            // printErrorMsg(errors);
                            // swal.fire("Error!", errors, "error"); 
                            swal.fire("Error!", errors.keterangan[0], "error"); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        // printErrorMsg(data.errors);
                    }
            })
        })

        // update detail anggaran 
        $(document).on('submit', '#updateDetailAnggaran', function(e){
            e.preventDefault();
            let id = kebutuhansarprastable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
            let detailpenganggaranid = detailanggarantable.rows( { selected: true } ).data()[0]['detailpenganggaranid'];
            
            var formData = new FormData($('#updateDetailAnggaran')[0]);

            var url = "{{ route('penganggaran.updateDetailPenganggaran', ':id') }}"
            url = url.replace(':id', detailpenganggaranid);

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
                    let errors = json.errors;

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Data detail anggaran berhasil diubah.", "success");
                            detailanggarantable.draw();
                            // updateDetailAnggarantable.draw();
                            loadDetailAnggaran(id)
                            $('#jumlah').val('');
                            $('#satuan').val('');
                            $('#subdetailkeg').val('');
                            $('#subkegid').val('');
                            $('#sumberdana').val('');
                            $('#updateDetailAnggaran').trigger("reset");
                            $('#modal-detail-pagu-penganggaran').modal('hide'); 
                            console.log( detailanggarantable.rows( { selected: true } ));
                            detailanggarantable.rows( { selected: true } ).data()[0];
                    }
                    else {
                            // var data = jqXHR.responseJSON;
                            console.log(errors);// this will be the error bag.
                            // printErrorMsg(errors);
                            // swal.fire("Error!", errors, "error"); 
                            swal.fire("Error!", errors.keterangan[0], "error"); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        printErrorMsg(data.errors);
                    }
            })
        })
    
        // edit detail
        $(document).on('submit', '#detailPagu-form', function(e){
            e.preventDefault();
            var url = "";
            
            var formData = new FormData($('#detailPagu-form')[0]);

            if($("#detail_mode").val() == "add") {
                var rowDataDetailAnggaran = detailanggarantable.rows( { selected: true } ).data()[0];
                var detailpenganggaranid = rowDataDetailAnggaran.detailpenganggaranid; 
                var url = "{{ route('penganggaran.storeDetailPaguPenganggaran', ':id') }}"
                url = url.replace(':id', detailpenganggaranid);
            }else if($("#detail_mode").val() == "edit") {
                var rowDataDetailPagu = detailPaguPenganggaranTable.rows( { selected: true } ).data()[0];
                var detailpaguanggaranid = rowDataDetailPagu.detailpaguanggaranid;
                var url = "{{ route('penganggaran.updateDetailPaguPenganggaran', ':id') }}"
                url = url.replace(':id', detailpaguanggaranid);
            }

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
                    let errors = json.errors;

                    if (success == 'true' || success == true) {
                        // kebutuhansarprastable.draw();
                        $('#jenispagu').val('');
                        $('#nilaipagu').val('');
                        $('#detailPagu-form').trigger("reset");
                        $('#modal-edit-detail').modal('hide'); 
                        detailanggarantable.draw();

                        var tableRow = detailanggarantable.rows({ selected: true }).data()[0]; 
                        // Get selected row data
                        var id = tableRow.detailpenganggaranid;
                        showDetailPaguPenganggaran(id);
                        swal.fire("Berhasil!", "Berhasil mengubah data.", "success");
                    }
                    else {
                            // var data = jqXHR.responseJSON;
                            console.log(errors);// this will be the error bag.
                            // printErrorMsg(errors);
                            // swal.fire("Error!", errors, "error"); 
                            swal.fire("Error!", errors.keterangan[0], "error"); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        printErrorMsg(data.errors);
                    }
            })
        })

</script>

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
        // var row = $(this).parents('tr:first');
        var row = $(this).parents('tr:first');

        //delete the row
        footable.removeRow(row);
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

            //get the footable object
            var footable = addrow.data('footable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td class="border-0"><select id="jenispagu" class="custom-select-detail form-control jenispagu @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}"></div></td><td class="border-0"><input id="nokontrak" disabled type="text" class="form-control @error("nokontrak") is-invalid @enderror" name="nokontrak[]" value="{{ (old("nokontrak")) }}" maxlength="100"></td><td class="border-0"><input id="nilaikontrak" disabled type="number" class="form-control @error("nilaikontrak") is-invalid @enderror" name="nilaikontrak[]" value="{{ (old("nilaikontrak")) }}" maxlength="100"></td><td class="border-0"><select id="perusahaanid" class="custom-select-detail form-control perusahaanid @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]" disabled><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></td><td class="border-0"><input disabled type="date" class="form-control @error("tgldari") is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old("tgldari") }}" required onchange="compareDates()"></td><td class="border-0"><input type="date" class="form-control @error("tglsampai") is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old("tglsampai") }}" disabled onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" disabled/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            // let imgParams = <td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center d-none"></div></td>
            
            // var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="filesarpraskebutuhan[]" id="filesarpraskebutuhan" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


            //add it
            footable.appendRow(newRow);
    });
});
</script>

@endsection
