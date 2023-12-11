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
        <h5 class="card-title text-uppercase">DAFTAR TENDER</h5>
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
                                <th>Jenis Pengajuan</th>
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
                                    <input id="subdetailkeg" required type="text" class="form-control @error('subdetailkeg') is-invalid @enderror" name="subdetailkeg" value="{{ (old('subdetailkeg')) }}" maxlength="100">
            
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
                                        <select disabled id="perusahaanid" class="custom-select form-control perusahaanid @error('perusahaanid') is-invalid @enderror" name="perusahaanid[]" required>
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px;">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">DETAIL PENGANGGARAN</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="updateDetailAnggaran" name="updateDetailAnggaran" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                <div class="row m-b-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
                            <div class="col-md-12">
                                <input id="subkegid-detail" class="form-control" name='subkegid' readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumberdana" class="col-md-12 col-form-label text-md-left">{{ __('Sumber Dana *') }}</label>
                            <div class="col-md-12">
                                <input id="sumberdana-detail" class="form-control" name='sumberdana' readonly/>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subdetailkeg" class="col-md-12 col-form-label text-md-left">{{ __('Sub Detail Kegiatan *') }}</label>
                            <div class="col-md-12">
                                <input id="subdetailkeg-detail" class="form-control" name='subdetailkeg' readonly/>
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
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal" id="modal-edit-detail-penganggaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px;">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">EDIT DETAIL PENGANGGARAN</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" class="form-material">
                <div class="row m-b-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
                            <div class="col-md-12">
                                <select id="subkegid" class="custom-select-edit-detail form-control @error('subkegid') is-invalid @enderror" name='subkegid' required>
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
                                <select id="sumberdana" class="custom-select-edit-detail form-control @error('sumberdana') is-invalid @enderror" name='sumberdana' required>
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
                                <input id="subdetailkeg" required type="text" class="form-control @error('subdetailkeg') is-invalid @enderror" name="subdetailkeg" value="{{ (old('subdetailkeg')) }}" maxlength="100">
            
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
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal" id="modal-lengkapi-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="modal-title-lengkapi-data"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form method="POST" id="tambahDetailPaguSarpras" name="tambahDetailPaguSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/> --}}
                    <input type="hidden" name="detail_mode" id="detail_mode"/>
                    <fieldset disabled>
                        <div class="form-group">
                            <label for="jenispagu" class="control-label">Jenis Pagu:</label>
                            <select id="detail_jenispagu" class="form-control" name='jenispagu'>
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
                                <input id="detail_nilaipagu" type="text" class="form-control @error('nilaipagu') is-invalid @enderror" name="nilaipagu" value="{{ (old('nilaipagu')) }}" maxlength="100" disabled autocomplete="name">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label for="nokontrak" class="control-label">Nomor Kontrak:</label>
                        <input id="detail_nokontrak" type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak" value="{{ (old('nokontrak')) }}" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="nilaikontrak" class="control-label">Nilai Kontrak:</label>
                        <div class="input-group">
                            <span class="p-2 mt-1">Rp </span>
                            <input id="detail_nilaikontrak" type="text" class="form-control @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak" value="{{ (old('nilaikontrak')) }}" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="perusahaanid" class="control-label">Perusahaan:</label>
                        <select id="detail_perusahaanid" class="custom-select-detail form-control @error('perusahaanid') is-invalid @enderror" name="perusahaanid" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($perusahaan as $item)
                            <option value="{{ $item->perusahaanid }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgldari" class="control-label">Dari Tanggal:</label>
                        <input type="date" class="form-control @error('tgldari') is-invalid @enderror" id="detail_tgldari" name="tgldari" value="{{ old('tgldari') }}" required onchange="compareDates()">
                        @error('tgldari')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tglsampai" class="control-label">Sampai Tanggal:</label>
                        <input type="date" class="form-control @error('tglsampai') is-invalid @enderror" id="detail_tglsampai" name="tglsampai" value="{{ old('tglsampai') }}" required onchange="compareDates()">
                        @error('tglsampai')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file" class="control-label">File:</label>
                        <input id="detail_file" type="file" class="file-input fileinput fileinput-new input-group" data-provides="fileinput" name="file"/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                        <div class="param_img_holder d-flex justify-content-center align-items-center">
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

    // $('table').on("focus", ".nilaipagu", function(){
    //     $( '.nilaipagu' ).mask('000,000,000,000,000', {reverse: true});
    //     // $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    // })
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

    var detail_nilaikontrak = document.getElementById('detail_nilaikontrak');
    detail_nilaikontrak.addEventListener('keyup', function(e)
    {
        detail_nilaikontrak.value = formatRupiah(this.value);
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
            dropdownParent: $('#modal-lengkapi-data .modal-content')
        });

        $('.custom-select').select2();

        // verifikasi kebutuhan sarpras 
        $(document).on('submit', '#tambahDetailPaguSarpras', function(e){
            var url = '';
            let id = detailPaguPenganggaranTable.rows( { selected: true } ).data()[0]['detailpaguanggaranid'];
            
            e.preventDefault();
            
            let formData = new FormData($('#tambahDetailPaguSarpras')[0]);

            if($("#detail_mode").val() == "add") {
                var url = "{{ route('tender.storeDetailPenganggaran', ':id') }}"
                url = url.replace(':id', id);   
            }else if($("#detail_mode").val() == "edit") {
                var url = "{{ route('tender.storeDetailPenganggaran', ':id') }}"
                url = url.replace(':id', id); 
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
                    let data = json.data;
                    let errors = json.errors;

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Data detail anggaran berhasil ditambah.", "success");
                            // kebutuhansarprastable.draw();
                            // tambahDetailPaguSarprastable.draw();
                            var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpenganggaranid = rowData.detailpenganggaranid;
                            showDetailPaguPenganggaran(detailpenganggaranid);

                            $('#tambahDetailPaguSarpras').trigger("reset");
                            $('#modal-lengkapi-data').modal('hide'); 
                            console.log( kebutuhansarprastable.rows( { selected: true } ));
                            kebutuhansarprastable.rows( { selected: true } ).data()[0];
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        // printErrorMsg(data.errors);
                    }
            })
        })

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
                url: "{{ route('tender.index') }}",
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
                        attr: {id: 'btn-progrespembangunan'},
                        text: '<i class="fa fa-check-square" aria-hidden="true"></i> Progres Pembangunan',
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
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 6 ? 'progres pembangunan' : '';

                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                            console.log(sarpraskebutuhanid)
                            let nopengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nopengajuan'];
                            let tglpengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['tglpengajuan'];

                            let url = "{{ route('tender.progrespembangunan', ':id') }}"
                            url = url.replace(':id', sarpraskebutuhanid);

                            if(status == 6){
                                swal.fire("Tidak dapat melakukan progres pembangunan",
                                    `Data yang anda pilih sudah berstatus ${status == 6 ? statusDesc : ''}`, "error");
                                return;
                            }else {
                                swal.fire({   
                                title: "Konfirmasi",   
                                text: `Apakah anda yakin melakukan progres pembangunan pengajuan kebutuhan sarpras dengan nomor pengajuan ${nopengajuan}?`,   
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
                                                swal.fire("Berhasil!", "Data berhasil diubah.", "success"); 
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
                    {
                        attr: {id: 'btn-batalprogrespembangunan'},
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

                            let url = "{{ route('tender.batalprogrespembangunan', ':id') }}"
                            url = url.replace(':id', sarpraskebutuhanid);

                            if(status == 3){
                                swal.fire("Tidak dapat melakukan progres pembangunan",
                                    `Data yang anda pilih sudah berstatus ${status == 5 ? statusDesc : ''}`, "error");
                                return;
                            }else {
                                swal.fire({   
                                title: "Konfirmasi",   
                                text: `Apakah anda yakin membatalkan progres pembangunan pengajuan kebutuhan sarpras dengan nomor pengajuan ${nopengajuan}?`,   
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
                                                swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
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
                        if(row.jenissarpras != null){
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
                        return (row.jumlah);
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

        function setenabletenderbutton(status = '') {
            kebutuhansarprastable.buttons( '#btn-batalprogrespembangunan' ).disable();
            kebutuhansarprastable.buttons( '#btn-progrespembangunan' ).disable();
            if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_PROGRES_PEMBANGUNAN }}') {
                kebutuhansarprastable.buttons( '#btn-batalprogrespembangunan' ).enable();
                kebutuhansarprastable.buttons( '#btn-progrespembangunan' ).disable();
            }
            else if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_PROSES_TENDER }}') {
                kebutuhansarprastable.buttons( '#btn-batalprogrespembangunan' ).disable();
                kebutuhansarprastable.buttons( '#btn-progrespembangunan' ).enable();
            }
        }

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
            setenabletenderbutton(status)
            loadDetailAnggaran(sarpraskebutuhanid);
        });

        kebutuhansarprastable.on('deselect', function ( e, dt, type, indexes ) {
            setenabletenderbutton();
            // hide history table
            $('#detail-anggaran-table').hide();
        });

        function showDetailPaguPenganggaran(detailpenganggaranid) {
            var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
            var detailpenganggaranid = rowData.detailpenganggaranid;
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
                // {'orderData': 2, data: 'status', 
                //     render: function(data, type, row){
                //         if(row.status != null){
                //             if(row.status == 1){
                //                 return '<span class="badge bg-secondary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT }}</span>';
                //             }else if(row.status == 2){
                //                 return '<span class="badge bg-info">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN }}</span>';
                //             }else if (row.status == 3){
                //                 return '<span class="badge bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI }}</span>';
                //             }else{
                //                 return '<span class="badge bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                //             }
                //         }else{
                //             return '-'
                //         }
                //     },
                //     name: 'status',
                // },
                // {
                //     data: 'keterangan',
                //     name: 'keterangan'
                // }
            ],
            buttons: {
                buttons: [
                    {
                        text: '<i class="fa fa-pencil" aria-hidden="true"></i> Lengkapi Data',
                        className: 'edit btn btn-primary mb-3 btn-datatable',
                        action: function() {

                            if (detailanggarantable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                                return;
                            }
                            else{
                                var rowData = detailanggarantable.rows({ selected: true }).data()[0]; // Get selected row data
                                var detailpenganggaranid = rowData.detailpenganggaranid;
                                // var detailpagupenganggaranid = rowData.detailpagupenganggaranid;

                                let subkegnama = detailanggarantable.rows({ selected: true }).data()[0]['subkegnama']
                                let sumberdana = detailanggarantable.rows({ selected: true }).data()[0]['sumberdana']
                                let subdetailkeg = detailanggarantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                                let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                                let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];
                                $('#modal-detail-pagu-penganggaran').modal('show');

                                $('#subkegid-detail').val(subkegnama);
                                $('#sumberdana-detail').val(sumberdana);
                                $('#subdetailkeg-detail').val(subdetailkeg);
                                $('#jumlah-detail').val(jumlah);
                                $('#satuan-detail').val(satuan);

                                console.log(subdetailkeg)

                                showDetailPaguPenganggaran(detailpenganggaranid);
                                setenabledtbutton('0');
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

                                let subkegnama = detailanggarantable.rows({ selected: true }).data()[0]['subkegnama']
                                let sumberdana = detailanggarantable.rows({ selected: true }).data()[0]['sumberdana']
                                let subdetailkeg = detailanggarantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                                let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                                let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];
                                $('#modal-detail-pagu-penganggaran').modal('show');

                                $('#subkegid-detail').val(subkegnama);
                                $('#sumberdana-detail').val(sumberdana);
                                $('#subdetailkeg-detail').val(subdetailkeg);
                                $('#jumlah-detail').val(jumlah);
                                $('#satuan-detail').val(satuan);

                                console.log(subdetailkeg);

                                showDetailPaguPenganggaran(detailpenganggaranid);
                                setenabledtbutton('');
                            }
                        }
                    }
                ]
            },
        });

        // hide histiry table
        $('#detail-anggaran-table').hide();
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
                        text: '<i class="fa fa-pencil" aria-hidden="true"></i> Lengkapi Data',
                        className: 'add btn btn-primary mb-3 btn-datatable',
                        action: function() {

                            if (detailPaguPenganggaranTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                                return;
                            }
                            else{
                                var rowData = detailPaguPenganggaranTable.rows({ selected: true }).data()[0]; // Get selected row data
                                var detailpenganggaranid = rowData.detailpenganggaranid;
                                var file = rowData.file;
                                console.log(file);
                                // var detailpagupenganggaranid = rowData.detailpagupenganggaranid;
                                $('#modal-lengkapi-data').modal('show');
                                if(file != null) {
                                    $('#detail_file').prop('required',false)
                                }else{
                                    $('#detail_file').prop('required', true)
                                }
                                showmodaldetail('add');
                            }
                        }
                    },
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
                            return DateFormat(row.tgldari)
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
        $("#tambhaDetailPaguSarpras")[0].reset();
        var v_max = 1;
        if (v_listDataDetail.length > 0) {
            var v_maxobj = v_listDataDetail.reduce((prev, current) => (prev && prev.nourut > current.nourut) ? prev : current);
            v_max = parseInt(v_maxobj.nourut)+1;
        }
        $("#detail_detail_nourut").val(v_max);
        //alert(v_listDataDetail.length);
        //alert(v_listDataDetail.length + '->' + JSON.stringify(max));

        $('span[id^="err_detail_detail_"]', "#tambhaDetailPaguSarpras").each(function(index, el){
            $('#'+el.id).html("");
        });

        $('select[id^="detail_detail_"]', "#tambhaDetailPaguSarpras").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindformdetail() {
        $('textarea[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            if(el.type != 'file') {
                var inputname = el.id.substring(7, el.id.length);
                //alert(inputname);
                if (inputname != "mode") {
                    if((inputname == 'nilaikontrak' && detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname] != null) || (inputname == 'nilaipagu' && detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname] != null)){
                        $("#"+el.id).val(formatRupiah(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]));
                    }else {
                        $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
                    }
                }
            }
        });
        
        $('select[id^="detail_"]', "#tambahDetailPaguSarpras").each(function(index, el){
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

    var v_modedetail = "";
    function showmodaldetail(mode) {
        v_modedetail = mode;
        $("#detail_mode").val(mode);
        // resetformdetail();
        if (mode == "add") {
            $("#modal-title-lengkapi-data").html('Lengkapi Data');
            bindformdetail();
            setenableddetail(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-lengkapi-data").html('Ubah Data');
            bindformdetail();
            setenableddetail(true);
        }
        else {
            $("#modal-title-lengkapi-data").html('Lihat Data');
            bindformdetail();
            setenableddetail(false);
        }
        
        $("#m_formshowdetail").modal('show');
    }

    function hidemodaldetail() {
        $("#m_formshowdetail").modal('hide');
    }

</script>

@endsection
