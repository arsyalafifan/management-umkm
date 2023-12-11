<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('bidangusaha.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('bidangusaha.edit', $bidangusaha->bidangusahaid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="bidang" class="col-md-12 col-form-label text-md-left">{{ __('Bidang') }}</label>

            <div class="col-md-12">
                <input id="bidang" type="text" class="form-control" name="bidang" 
                    @if ($bidangusaha->bidang == enum::BIDANG_PERTANIAN) value="Pertanian" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_PRODUKSI_BAHAN_MENTAH) value="Produksi Bahan Mentah" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_MANUFAKTUR) value="Manufaktur" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_KONSTRUKSI) value="Konstruksi" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_TRANSPORTASI) value="Transportasi" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_KOMUNIKASI) value="Komunikasi" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_PERDAGANGAN_BESAR_KECIL) value="Perdagangan Besar/Kecil" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_FINANSIAL) value="Finansial" @endif
                    @if ($bidangusaha->bidang == enum::BIDANG_JASA) value="Jasa" @endif
                readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="bidangusaha" class="col-md-12 col-form-label text-md-left">{{ __('Bidang Usaha') }}</label>

            <div class="col-md-12">
                <input id="bidangusaha" type="text" class="form-control" name="bidangusaha" value="{{ $bidangusaha->bidangusaha }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('bidangusaha.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Bidang Usaha') }}
                </a>
                <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                    {{ __('Home') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    });
</script>
@endsection
