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
        <h2 class="card-title text-uppercase">DAFTAR REKENING</h2><hr />
        <form class="form-material">
            {{-- <div class="form-group row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="form-group row">
                <div class="col-md-6">
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
                <div class="col-md-6">
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
            </div> --}}
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
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="rekening-table">
                        <thead>
                            <tr>
                                <th>Bank</th>
                                <th>Kode Rekening</th>
                                <th>Saldo</th>
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
        <h2 class="card-title text-uppercase" id="detail-sarpras-title"></h2><hr />
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
                    <table class="table table-bordered yajra-datatable table-striped" id="budget-table">
                        <thead>
                            <tr>
                                <th>Judul Budget</th>
                                <th>Total Budget</th>
                                <th>Sudah Terealisasikan</th>
                                <th>Tanggal</th>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body p-4">
        <h2 class="card-title text-uppercase" id="alokasi-budget-title"></h2><hr />
        <div class="form-group row">
            <div class="col-md-12">
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="alokasi-budget-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Alokasi Budget</th>
                                <th>Terealisasikan</th>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="foto-alokasi-budget-table">
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

<!-- modal add rekening -->
<div class="modal" id="modal-rekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-jenis-sarpras" id="modal-title-jenis-sarpras"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="rekeningForm" name="rekeningForm" method="POST" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- {{ method_field('PUT') }} --}}
                    <input type="hidden" name="rekening" id="rekening_mode">
                    <div class="form-group row">
                        <label for="bank" class="col-md-12 col-form-label text-md-left">{{ __('Bank *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ (old('bank')) }}" maxlength="100" required autocomplete="bank">
    
                            @error('bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="koderekening" class="col-md-12 col-form-label text-md-left">{{ __('Kode Rekening *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_koderekening" type="text" class="form-control @error('koderekening') is-invalid @enderror" name="koderekening" value="{{ (old('koderekening')) }}" maxlength="100" required autocomplete="koderekening">
    
                            @error('koderekening')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="saldo" class="col-md-12 col-form-label text-md-left">{{ __('Saldo *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_saldo" type="text" class="form-control @error('saldo') is-invalid @enderror" name="saldo" value="{{ (old('saldo')) }}" maxlength="100" required autocomplete="saldo">
    
                            @error('saldo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

<!-- modal edit rekening -->
<div class="modal" id="modal-rekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-jenis-sarpras" id="modal-title-jenis-sarpras"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="rekeningForm" name="rekeningForm" method="POST" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- {{ method_field('PUT') }} --}}
                    <input type="hidden" name="rekening" id="rekening_mode">
                    <div class="form-group row">
                        <label for="bank" class="col-md-12 col-form-label text-md-left">{{ __('Bank *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ (old('bank')) }}" maxlength="100" required autocomplete="bank">
    
                            @error('bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="koderekening" class="col-md-12 col-form-label text-md-left">{{ __('Kode Rekening *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_koderekening" type="text" class="form-control @error('koderekening') is-invalid @enderror" name="koderekening" value="{{ (old('koderekening')) }}" maxlength="100" required autocomplete="koderekening">
    
                            @error('koderekening')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="saldo" class="col-md-12 col-form-label text-md-left">{{ __('Saldo *') }}</label>
                        <div class="col-md-12">
                            <input id="rekening_saldo" type="text" class="form-control @error('saldo') is-invalid @enderror" name="saldo" value="{{ (old('saldo')) }}" maxlength="100" required autocomplete="saldo">
    
                            @error('saldo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

<!-- modal budget -->
<div class="modal" id="modal-budget" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-budget" id="modal-title-budget"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="budgetForm" name="budgetForm" method="POST" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- {{ method_field('PUT') }} --}}
                    <input type="hidden" name="budget" id="budget_mode">
                    <div class="form-group row">
                        <label for="judul" class="col-md-12 col-form-label text-md-left">{{ __('Judul *') }}</label>
                        <div class="col-md-12">
                            <input id="budget_judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ (old('judul')) }}" maxlength="100" required autocomplete="judul">
    
                            @error('judul')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="totalbudget" class="col-md-12 col-form-label text-md-left">{{ __('Total Budget *') }}</label>
                        <div class="col-md-12">
                            <input id="budget_totalbudget" type="text" class="form-control @error('totalbudget') is-invalid @enderror" name="totalbudget" value="{{ (old('totalbudget')) }}" maxlength="100" required autocomplete="totalbudget">
    
                            @error('totalbudget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglbudget" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal *') }}</label>
                        <div class="col-md-12">
                            <input id="budget_tglbudget" type="date" class="form-control @error('tglbudget') is-invalid @enderror" name="tglbudget" value="{{ (old('tglbudget')) }}" maxlength="100" required autocomplete="tglbudget">
    
                            @error('tglbudget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button value="btnSubmitBudget" type="submit" id="btnSubmitBudget" class="btn btn-primary btnSubmitBudget"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal alokasi budget -->
<div class="modal" id="modal-alokasi-budget" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title-alokasi-budget" id="modal-title-alokasi-budget"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="alokasiBudgetForm" name="alokasiBudgetForm" method="POST" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- {{ method_field('PUT') }} --}}
                    <input type="hidden" name="alokasi-budget" id="alokasi_budget_mode">
                    <div class="form-group row">
                        <label for="judul_alokasi" class="col-md-12 col-form-label text-md-left">{{ __('Judul *') }}</label>
                        <div class="col-md-12">
                            <input id="alokasibudget_judul" type="text" class="form-control @error('judul_alokasi') is-invalid @enderror" name="judul_alokasi" value="{{ (old('judul_alokasi')) }}" maxlength="100" required autocomplete="judul_alokasi">
    
                            @error('judul_alokasi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alokasibudget" class="col-md-12 col-form-label text-md-left">{{ __('Alokasi Budget *') }}</label>
                        <div class="col-md-12">
                            <input id="alokasibudget_alokasibudget" type="text" class="form-control @error('alokasibudget') is-invalid @enderror" name="alokasibudget" value="{{ (old('alokasibudget')) }}" maxlength="100" required autocomplete="alokasibudget">
    
                            @error('alokasibudget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglalokasibudget" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal *') }}</label>
                        <div class="col-md-12">
                            <input id="alokasibudget_tglalokasibudget" type="date" class="form-control @error('tglalokasibudget') is-invalid @enderror" name="tglalokasibudget" value="{{ (old('tglalokasibudget')) }}" maxlength="100" required autocomplete="tglalokasibudget">
    
                            @error('tglalokasibudget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button value="btnSubmitAlokasiBudget" type="submit" id="btnSubmitAlokasiBudget" class="btn btn-primary btnSubmitAlokasiBudget"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // $('div.dataTables_filter').addClass('form-material');
    $(document).ready(function () {
        var alokasibudget_alokasibudget = document.getElementById('alokasibudget_alokasibudget');
        alokasibudget_alokasibudget.addEventListener('keyup', function(e)
        {
            alokasibudget_alokasibudget.value = formatRupiah(this.value);
        });

        var budget_totalbudget = document.getElementById('budget_totalbudget');
        budget_totalbudget.addEventListener('keyup', function(e)
        {
            budget_totalbudget.value = formatRupiah(this.value);
        });

        var rekening_saldo = document.getElementById('rekening_saldo');
        rekening_saldo.addEventListener('keyup', function(e)
        {
            rekening_saldo.value = formatRupiah(this.value);
        });

        // $('#rekening_jenissarpras').select2().on('change', function() {
        //     setComboDisable();
        //     setupCombosProp();
        // })

        function setComboDisable(){
            $('#rekening_jenisperalatanid').prop('disabled', true);
        }

        function setupCombosProp(){
            // $('#grup').val($('#aksesid').find(":selected").data("grup"));
            if ($('#rekening_jenissarpras').val() == "{{enum::SARPRAS_PERALATAN}}") {
                $('#rekening_jenisperalatanid').prop('disabled', false);
                $('#rekening_jenisperalatanid').val('').trigger('change');
            }else {
                $('#rekening_jenisperalatanid').prop('disabled', true);
                $('#rekening_jenisperalatanid').val('').trigger('change');
            }
        }

        // HANDLE SUBMIT REKENING
        $(document).on('submit', '#rekeningForm', function(e){
            e.preventDefault();
            var url = '';
            var type = '';
            var id = '';

            
            if($("#rekening_mode").val() == 'add') {
                url = "{{ route('budgetmanagement.storerekening') }}";
                type = 'POST'
                // url = url.replace(':id', id);   
            }else if($("#rekening_mode").val() == "edit") {
                url = "{{ route('budgetmanagement.updaterekening', ':id') }}";
                id = rekeningTable.rows( { selected: true } ).data()[0]['rekeningid'];
                url = url.replace(':id', id); 
                type = 'POST'
            }
            var formData = new FormData($('#rekeningForm')[0]);
            
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
                            swal.fire("Berhasil!", "Data rekening berhasil ditambah.", "success");

                            rekeningTable.draw();

                            $('#rekeningForm').trigger("reset");
                            $('#modal-rekening').modal('hide'); 
                    }
                },
            })
        })

        // HANDLE SUBMIT BUDGET
        $(document).on('submit', '#budgetForm', function(e){
            e.preventDefault();
            var url = '';
            var type = '';
            var id = '';
            var rekeningid = rekeningTable.rows( { selected: true } ).data()[0]['rekeningid'];

            
            if($("#budget_mode").val() == 'add') {
                url = "{{ route('budgetmanagement.storebudget', ':rekeningid') }}";
                url = url.replace(':rekeningid', rekeningid);
                type = 'POST'
                // url = url.replace(':id', id);   
            }else if($("#budget_mode").val() == "edit") {
                url = "{{ route('budgetmanagement.updatebudget', ':id') }}";
                id = budgetTable.rows( { selected: true } ).data()[0]['budgetid'];
                url = url.replace(':id', id); 
                type = 'POST'
            }
            var formData = new FormData($('#budgetForm')[0]);
            
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
                            swal.fire("Berhasil!", "Data rekening berhasil ditambah.", "success");

                            // rekeningTable.draw();
                            loadBudget(rekeningid)

                            $('#budgetForm').trigger("reset");
                            $('#modal-budget').modal('hide'); 
                    }
                },
            })
        })

        // HANDLE SUBMIT ALOKASI BUDGET
        $(document).on('submit', '#alokasiBudgetForm', function(e){
            e.preventDefault();
            var url = '';
            var type = '';
            var id = '';
            var budgetid = budgetTable.rows( { selected: true } ).data()[0]['budgetid'];

            
            if($("#alokasi_budget_mode").val() == 'add') {
                url = "{{ route('budgetmanagement.storeAlokasiBudget', ':budgetid') }}";
                url = url.replace(':budgetid', budgetid);
                type = 'POST'
                // url = url.replace(':id', id);   
            }else if($("#alokasi_budget_mode").val() == "edit") {
                url = "{{-- route('budgetmanagement.updateAlokasiBudget', ':id') --}}";
                id = alokasiBudgetTable.rows( { selected: true } ).data()[0]['alokasibudgetid'];
                url = url.replace(':id', id); 
                type = 'POST'
            }
            var formData = new FormData($('#alokasiBudgetForm')[0]);
            
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
                            swal.fire("Berhasil!", "Data alokasi budget berhasil ditambah.", "success");

                            // rekeningTable.draw();
                            loadAlokasiBudget(budgetid)

                            $('#alokasiBudgetForm').trigger("reset");
                            $('#modal-alokasi-budget').modal('hide'); 
                    }
                },
            })
        })



        $('.custom-select').select2();

        $('.custom-select1').select2({
            dropdownParent: $('#modal-rekening .modal-content')
        });

        // Get namasarpras when jenis sarpras selected
        $('#rekening_jenissarpras').select2().on('change', function() {
            setComboDisable();
            setupCombosProp();
            var url = "{{-- route('sarprastersedia.getNamaSarpras', ':parentid') --}}";
            url = url.replace(':parentid', ($('#rekening_jenissarpras').val() == "" || $('#rekening_jenissarpras').val() == null ? "-1" : $('#rekening_jenissarpras').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#rekening_namasarprasid').empty();
                    $('#rekening_namasarprasid').append($("<option></option>").attr("value", "").text("-- Pilih Nama Sarpras --"));
                    $.each(data.data, function(key, value) {
                        $('#rekening_namasarprasid').append($("<option></option>").attr("value", value.namasarprasid).text(value.namasarpras));
                    });
                    $('#rekening_namasarprasid').select2();
                    // $('#sekolahid').val(sekolahid);
                    var namasarprasid = rekeningTable.rows( { selected: true } ).data()[0]['namasarprasid'];
                    if ($('#rekening_mode').val() == 'edit') {
                        $('#rekening_namasarprasid').val(namasarprasid);
                    }
                    $('#rekening_namasarprasid').trigger('change');
                }
            })
        })

    // START HANDLE MODAL REKENING

    function resetformdetail() {
        $("#rekeningForm")[0].reset();

        $('select[id^="rekening_"]', "#rekeningForm").each(function(index, el){
            var inputname = el.id.substring(9, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindformdetail() {
        $('textarea[id^="rekening_"]', "#rekeningForm").each(function(index, el){
            var inputname = el.id.substring(9, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(rekeningTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="rekening_"]', "#rekeningForm").each(function(index, el){

            var inputname = el.id.substring(9, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(rekeningTable.rows( { selected: true } ).data()[0][inputname]);
                console.log(inputname);
            }
        });
        
        $('select[id^="rekening_"]', "#rekeningForm").each(function(index, el){
            var inputname = el.id.substring(9, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(rekeningTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
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
    function showmodalrekening(mode) {
        v_modejenissarpras = mode;
        $("#rekening_mode").val(mode);
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

    // END HANDLE MODAL REKENING

    // START HANDLE MODAL BUDGET

    function resetformbudget() {
        $("#budgetForm")[0].reset();

        $('select[id^="budget_"]', "#budgetForm").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindformbudget() {
        $('textarea[id^="budget_"]', "#budgetForm").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(budgetTable.rows( { selected: true } ).data()[0][inputname]);
                // $('#budget_totalbudget').prop('disabled', true);
            }
            // if(inputname == 'totalbudget')
            // {
            // }
        });
        
        $('input[id^="budget_"]', "#budgetForm").each(function(index, el){

            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(budgetTable.rows( { selected: true } ).data()[0][inputname]);
                console.log(inputname);
            }
        });
        
        $('select[id^="budget_"]', "#budgetForm").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(budgetTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
            }
        });
    }

    function setenabledbudget(value) {
        if (value) {
            $("#btnSubmit").show();
        }
        else {
            $("#btnSubmit").hide();
        }
        
        $('textarea[id^="budget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^="budget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^="budget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modebudget = "";
    function showmodalbudget(mode) {
        v_modebudget = mode;
        $("#budget_mode").val(mode);
        resetformbudget();
        if (mode == "add") {
            $("#modal-title-budget").html('Tambah Data');
            setenabledbudget(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-budget").html('Ubah Data');
            bindformbudget();
            setenabledbudget(true);
        }
        else {
            $("#modal-title-budget").html('Lihat Data');
            bindformbudget();
            setenabledbudget(false);
        }
        
        $("#modal-budget").modal('show');
    }

    function hidemodalbudget() {
        $("#m_formshowdetail").modal('hide');
    }

    // END HANDLE MODAL BUDGET

    // START HANDLE MODAL ALOKASI BUDGET

    function resetalokasiBudgetForm() {
        $("#alokasiBudgetForm")[0].reset();

        $('select[id^="alokasibudget_"]', "#alokasiBudgetForm").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindalokasiBudgetForm() {
        $('textarea[id^="alokasibudget_"]', "#alokasiBudgetForm").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(alokasiBudgetTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="alokasibudget_"]', "#alokasiBudgetForm").each(function(index, el){

            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(alokasiBudgetTable.rows( { selected: true } ).data()[0][inputname]);
                console.log(inputname);
            }
        });
        
        $('select[id^="alokasibudget_"]', "#alokasiBudgetForm").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(alokasiBudgetTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
            }
        });
    }

    function setenabledalokasibudget(value) {
        if (value) {
            $("#btnSubmit").show();
        }
        else {
            $("#btnSubmit").hide();
        }
        
        $('textarea[id^="alokasibudget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^="alokasibudget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^="alokasibudget_"]', "#tambahDetailPaguSarpras").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modebudget = "";
    function showmodalalokasibudget(mode) {
        v_modebudget = mode;
        $("#alokasi_budget_mode").val(mode);
        resetalokasiBudgetForm();
        if (mode == "add") {
            $("#modal-title-alokasi-budget").html('Tambah Data');
            setenabledalokasibudget(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-alokasi-budget").html('Ubah Data');
            bindalokasiBudgetForm();
            setenabledalokasibudget(true);
        }
        else {
            $("#modal-title-alokasi-budget").html('Lihat Data');
            bindalokasiBudgetForm();
            setenabledalokasibudget(false);
        }
        
        $("#modal-alokasi-budget").modal('show');
    }

    function hidemodalalokasibudget() {
        $("#m_formshowdetail").modal('hide');
    }

    // END HANDLE MODAL ALOKASI BUDGET

        var budgetTable;
        var alokasiBudgetTable;
    
        var rekeningTable = $('#rekening-table').DataTable({
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
                url: "{{ route('budgetmanagement.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        // "kotaid": $("#kotaid").val().toLowerCase(),
                        // "sekolahid": $("#sekolahid").val().toLowerCase(),
                        // "jenjang": $("#jenjang").val().toLowerCase(),
                        // "jenis": $("#jenis").val().toLowerCase(),
                        // "kecamatanid": $("#kecamatanid").val().toLowerCase(),
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
                            // var url = "{{--  route('sarprastersedia.createBySekolahId', ['sekolahid' => ':id']) --}}";
                            // url = url.replace(':id', id);
                            // window.location.href = url;

                            $('#modal-rekening').modal('show');
                            showmodalrekening('add');
                            $('#rekening_sekolahid').val($('#sekolahid').val());

                        }
                    }
                },
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (rekeningTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = rekeningTable.rows( { selected: true } ).data()[0]['rekeningid'];
                        var url = "{{-- route('sarprastersedia.edit', ':id') --}}"
                        // url = url.replace(':id', id);
                        // window.location = url;

                        $('#modal-rekening').modal('show');
                        showmodalrekening('edit');
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (rekeningTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = rekeningTable.rows( { selected: true } ).data()[0]['rekeningid'];
                        var url = "{{ route('budgetmanagement.destroy', ':id') }}"
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
                                            rekeningTable.draw();
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
                {'orderData': 1, data: 'bank',
                    render: function ( data, type, row ) {
                        if(row.bank!=null){
                            return row.bank;
                        }else
                        return "-";
                    }, 
                    name: 'bank'},
                {'orderData': 2, data: 'koderekening', name: 'koderekening'},
                {'orderData': 3, data: 'saldo', name: 'saldo',
                    render: function(data, type, row) {
                        if(row.saldo != null) {
                            return rupiah(row.saldo);
                        }
                        else {
                            return "-"
                        }
                    }
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
        $('#sekolahid').change( function() { 
            rekeningTable.draw();
            // hide detail sarpras table table
            $('#budget-table').hide();
            $('#alokasi-budget-table').hide();
        });

        // $('#jenis').select2().on('change', function() {

        //     rekeningTable.draw();

        // });

        // $('#jenis').change( function() { 
        //     rekeningTable.draw();
        //     // hide detail sarpras table table
        //     $('#budget-table').hide();
        //     $('#alokasi-budget-table').hide();
        // });

        // $('#jenjang').change( function() { 
        //     rekeningTable.draw();
        //     // hide detail sarpras table table
        //     $('#budget-table').hide();
        //     $('#alokasi-budget-table').hide();
        // });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                rekeningTable.draw();
                $('#budget-table').hide();
                $('#alokasi-budget-table').hide();
            }
        });

        function loadBudget(rekeningid) {
            var url = "{{ route('budgetmanagement.loadBudget', ':id') }}";
            url = url.replace(':id', rekeningid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    budgetTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        budgetTable.row.add({
                            budgetid: response.data.data[i].budgetid,
                            rekeningid: response.data.data[i].rekeningid,
                            judul: response.data.data[i].judul,
                            tglbudget: response.data.data[i].tglbudget,
                            totalbudget: response.data.data[i].totalbudget,
                            terealisasikan: response.data.data[i].terealisasikan,
                        });
                    }

                    budgetTable.draw();
                    $('#budget-table').show();
                    $('#alokasi-budget-table').hide();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on legalisir-table
        rekeningTable.on('select', function (e, dt, type, indexes) {
            var rowData = rekeningTable.rows(indexes).data()[0]; // Get selected row data
            var rekeningid = rowData.rekeningid;
            var bank = rowData.bank;

            $('#detail-sarpras-title').html(`daftar budget dari rekening ${bank}`)

            // Load history table with selected rekeningid
            loadBudget(rekeningid);
        });

        rekeningTable.on('deselect', function ( e, dt, type, indexes ) {
            $('#detail-sarpras-title').html(`daftar budget`)
            // hide histiry table
            $('#budget-table').hide();
            $('#alokasi-budget-table').hide();
        });

        var budgetTable = $('#budget-table').DataTable({
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
                        if (rekeningTable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Jenis Sarpras belum dipilih", "Silakan pilih jenis sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = rekeningTable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var rekeningid = rowData.rekeningid;
                            var url = "{{--  route('sarprastersedia.createDetailSarpras', ['rekeningid' => ':id']) --}}";
                            url = url.replace(':id', rekeningid);
                            // window.location.href = url;

                            // $('#modal-detail-sarpras').modal('show');
                            showmodalbudget('add');
                        }
                    }
                },
                // {
                //     text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                //     className: 'edit btn btn-info mb-3 btn-datatable',
                //     action: function() {

                //         if (budgetTable.rows( { selected: true } ).count() <= 0) {
                //             swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                //             return;
                //         }
                //         else{
                //             var rowData = budgetTable.rows({ selected: true }).data()[0]; // Get selected row data
                //             var detailsarprasid = rowData.detailsarprasid;
                //             // var detailpagusarprasid = rowData.detailpagusarprasid;
                //             console.log(detailsarprasid);
                //             $('#modal-detail-pagu-sarpras').modal('show');
                //             showDetailPaguSarpras(detailsarprasid)
                //         }
                //     }
                // },  
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (budgetTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        // var id = budgetTable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                        var rowData = budgetTable.rows({ selected: true }).data()[0]; // Get selected row data
                        var id = rowData.detailsarprasid;
                        var url = "{{-- route('sarprastersedia.editDetailSarpras', ':id') --}}"
                        // url = url.replace(':id', id);
                        // window.location = url;

                        $('#modal-budget').modal('show');
                        showmodalbudget('edit');
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (budgetTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = budgetTable.rows( { selected: true } ).data()[0]['budgetid'];
                        var url = "{{ route('budgetmanagement.destroybudget', ':id') }}"
                        url = url.replace(':id', id);
                        // var nama =  budgetTable.rows( { selected: true } ).data()[0]['namasekolah'];
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
                                            // budgetTable.draw();
                                            var rowData = rekeningTable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var rekeningid = rowData.rekeningid;
                                            loadBudget(rekeningid);
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
                {'orderData': 1, data: 'judul', name: 'judul', 
                    render: function(data, type, row){
                        return row.judul;
                    }
                },
                {'orderData': 2, data: 'totalbudget', name: 'totalbudget', 
                    render: function(data, type, row){
                        return rupiah(row.totalbudget);
                    }
                },
                {'orderData': 3, data: 'terealisasikan', name: 'terealisasikan', 
                    render: function(data, type, row){
                        let persen = row.terealisasikan / row.totalbudget * 100;
                        console.log(persen);
                        // return rupiah(row.terealisasikan);
                        return `<div class="progress progress-lg">` +
                                        `<div class="progress-bar ${persen <= 75 ? "progress-bar-info" : "progress-bar-success"} progress-bar-striped active" role="progressbar" style="width: ${persen}%; role="progressbar"">${rupiah(row.terealisasikan)} (${persen})% </div>` +
                                    `</div>`
                    }
                },
                {'orderData': 4, data: 'tglbudget', name: 'tglbudget',
                    render: function(data, type, row){
                        return DateFormat(row.tglbudget);
                    }
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        // hide detail jumlah sarpras table table
        $('#budget-table').hide();
        function loadAlokasiBudget(budgetid) {
            var url = "{{ route('budgetmanagement.loadAlokasiBudget', ':id') }}";
            url = url.replace(':id', budgetid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    alokasiBudgetTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        alokasiBudgetTable.row.add({
                            alokasibudgetid: response.data.data[i].alokasibudgetid,
                            budgetid: response.data.data[i].budgetid,
                            judul: response.data.data[i].judul,
                            tglalokasibudget: response.data.data[i].tglalokasibudget,
                            alokasibudget: response.data.data[i].alokasibudget,
                            statusrealisasi: response.data.data[i].statusrealisasi
                        });
                    }

                    alokasiBudgetTable.draw();
                    $('#alokasi-budget-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on legalisir-table
        budgetTable.on('select', function (e, dt, type, indexes) {
            var rowData = budgetTable.rows(indexes).data()[0]; // Get selected row data
            var budgetid = rowData.budgetid;
            var judul = rowData.judul;
            console.log(judul);
            // console.log(budgetid);
            $('#alokasi-budget-title').html(`daftar alokasi budget dari ${judul}`)

            // Load history table with selected detailjumlahpagusarprasid
            loadAlokasiBudget(budgetid);
        });

        budgetTable.on('deselect', function ( e, dt, type, indexes ) {
            // hide histiry table
            $('#alokasi-budget-title').html(`daftar alokasi budget`);
            $('#alokasi-budget-table').hide();
        });

        var alokasiBudgetTable = $('#alokasi-budget-table').DataTable({
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
                        if (budgetTable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Detail sarpras belum dipilih", "Silakan pilih detail sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = budgetTable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var detailsarprasid = rowData.detailsarprasid;
                            var url = "{{-- route('sarprastersedia.createDetailJumlahSarpras', ['detailsarprasid' => ':id']) --}}";
                            url = url.replace(':id', detailsarprasid);
                            // window.location.href = url;
                            showmodalalokasibudget('add');
                        }
                    }
                },
                {
                    text: '<i class="fa fa-check" aria-hidden="true"></i> Realisasikan',
                    className: 'edit btn btn-success mb-3 btn-datatable',
                    action: function() {

                        if (alokasiBudgetTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var rowData = alokasiBudgetTable.rows( { selected: true } ).data()[0];
                        var alokasibudgetid = rowData.alokasibudgetid;
                        let url = "{{ route('budgetmanagement.statusrealisasi', ':id') }}"
                        url = url.replace(':id', alokasibudgetid);
                        swal.fire({   
                            title: "Konfirmasi",   
                            text: "Apakah anda yakin ingin mengubah status realisasi?",   
                            type: "warning",   
                            showCancelButton: true,   
                            // confirmButtonColor: "#DD6B55",   
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
                                            swal.fire("Berhasil!", "Status berhasil diubah.", "success"); 
                                            var rowData = budgetTable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var budgetid = rowData.budgetid;
                                            // alokasiBudgetTable.draw();
                                            rekeningTable.draw();
                                            // loadAlokasiBudget(budgetid);
                                            $('#budget-table').hide();
                                            $('#alokasi-budget-table').hide();
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
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-datatable mb-3',
                    action: () => {
                        if (alokasiBudgetTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        let id = alokasiBudgetTable.rows( { selected: true } ).data()[0]['alokasibudgetid'];
                        let url = "{{ route('budgetmanagement.destroyalokasibudget', ':id') }}"
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
                                            var rowData = budgetTable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var budgetid = rowData.budgetid;
                                            // alokasiBudgetTable.draw();
                                            loadAlokasiBudget(budgetid);
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
            ]
            },

            columns: [
                {'orderData': 1, data: 'judul', name: 'judul', 
                    render: function(data, type, row){
                        if (row.judul != null || row.judul != '') {
                            return row.judul;
                        }
                        else {
                            return '---'
                        }
                    }
                },
                {'orderData': 2, data: 'tglalokasibudget', name: 'tglalokasibudget', 
                    render: function(data, type, row){
                        if (row.tglalokasibudget != null || row.tglalokasibudget != '') {
                            return DateFormat(row.tglalokasibudget);
                        }
                        else {
                            return '---'
                        }
                    }
                },
                {'orderData': 3, data: 'alokasibudget', name: 'alokasibudget', 
                    render: function(data, type, row){
                        if (row.alokasibudget != null || row.alokasibudget != '') {
                            return rupiah(row.alokasibudget);
                        }
                        else {
                            return '---'
                        }
                    }
                },
                {
                    'orderData': 4,
                    data: 'statusrealisasi',
                    render: function (data, type, row) {
                        if(row.statusrealisasi == 2) { 
                            return '<span class="badge badge-pill badge-success">V</span>';
                        }else {
                            return '<span class="badge badge-pill badge-danger">X</span>';
                        }
                    },
                    sClass : "text-center", 
                    name: 'statusrealisasi',
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
    });
    // hide detail sarpras table table
    $('#alokasi-budget-table').hide();

    // // Listen for row selection event on legalisir-table
    // budgetTable.on('select', function (e, dt, type, indexes) {
    //     var rowData = budgetTable.rows(indexes).data()[0]; // Get selected row data
    //     var budgetid = rowData.budgetid;
    //     var judul = rowData.judul;
    //     console.log(judul);
    //     // console.log(budgetid);
    //     $('#alokasi-budget-title').html(`daftar alokasi budget dari ${judul}`)

    //     // Load history table with selected detailjumlahpagusarprasid
    //     loadAlokasiBudget(budgetid);
    // });

    // budgetTable.on('deselect', function ( e, dt, type, indexes ) {
    //     // hide histiry table
    //     $('#alokasi-budget-title').html(`daftar alokasi budget`);
    //     $('#alokasi-budget-table').hide();
    // });

    function showDetailPaguSarpras(detailsarprasid) {
            var url = "{{-- route('sarprastersedia.showDetailPaguSarpras', ':id') --}}";
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
                   let url = "{{-- route('sarprastersedia.downloadFileDetailPagu', ':id') --}}"
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
                            return rupiah(row.nilaikontrak)
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
        var url = "{{-- route('sarprastersedia.showFotoDetailJumlahSarpras', ':id') --}}";
        url = url.replace(':id', detailjumlahsarprasid);

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {

                fotoalokasiBudgetTable.clear();

                for (var i = 0; i < response.data.count; i++) {
                    fotoalokasiBudgetTable.row.add({
                        filedetailjumlahsarprasid: response.data.data[i].filedetailjumlahsarprasid,
                        file: response.data.data[i].file,
                    });
                }

                fotoalokasiBudgetTable.draw();
                $('#foto-alokasi-budget-table').show();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    var fotoalokasiBudgetTable = $('#foto-alokasi-budget-table').DataTable({
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
                if (fotoalokasiBudgetTable.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                    return;
                }
                let id = fotoalokasiBudgetTable.rows( { selected: true } ).data()[0]['filedetailjumlahsarprasid'];
                let namaFile = fotoalokasiBudgetTable.rows( { selected: true } ).data()[0]['file'];
                let url = "{{-- route('sarprastersedia.downloadFileDetailJumlahSarpras', ':id') --}}"
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

{{-- <script src="{{asset('/assets/js/filterSekolah.js')}}" type="text/javascript"></script> --}}
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
            var footable = addrow.data('footwable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td class="border-0"><select id="jenispagu" class="custom-select-detail form-control jenispagu @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}"></div></td><td class="border-0"><input id="nokontrak" type="text" class="form-control @error("nokontrak") is-invalid @enderror" name="nokontrak[]" value="{{ (old("nokontrak")) }}" maxlength="100"></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaikontrak" type="number" class="form-control @error("nilaikontrak") is-invalid @enderror" name="nilaikontrak[]" value="{{ (old("nilaikontrak")) }}" maxlength="100"></div></td><td class="border-0"><div class="more-perusahaanid-container"><select id="perusahaanid" class="custom-select-detail form-control perusahaanid @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]"><option value="">-- Pilih Perusahaan --</option></select></div></td><td class="border-0"><input type="date" class="form-control @error("tgldari") is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old("tgldari") }}" required onchange="compareDates()"></td><td class="border-0"><input type="date" class="form-control @error("tglsampai") is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old("tglsampai") }}" onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]"/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            var index = $('.perusahaanid-container').length;
            $('.perusahaanid-container:first').find("select").select2("destroy")
            var $perusahaanid = $('.perusahaanid-container:first').clone();

            $perusahaanid.find('select[name*=perusahaanid]')
            .val('')
            .attr('name', 'items[' + index + '][perusahaanid]')
            .attr('id', 'perusahaanid-' + index);
            // var newRow = '<tr><td class="border-0"><select id="jenispagu" class="form-control @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0"><input id="nilaipagu" type="number" class="form-control @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}" maxlength="100" required></td><td class="border-0"><select id="perusahaanid" class="form-control @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]" required><option value="">-- Pilih Perusahaan --</option></select></td><td class="border-0"><input type="date" class="form-control @error("tglpelaksanaan") is-invalid @enderror" id="tglpelaksanaan" name="tglpelaksanaan[]" value="{{ old("tglpelaksanaan") }}" required onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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