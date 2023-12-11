<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kota.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('kota.edit', $kota->kotaid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        {{-- <div class="form-group row">
            <label for="provid" class="col-md-12 col-form-label text-md-left">{{ __('Provinsi') }}</label>

            <div class="col-md-12">
                <input id="provid" type="text" class="form-control" name="provid" value="{{ $kota->prov->kodeprov . ' ' . $kota->prov->namaprov }}" readonly>
            </div>
        </div> --}}
        
        <div class="form-group row">
            <label for="kodekota" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kota') }}</label>

            <div class="col-md-12">
                <input id="kodekota" type="text" class="form-control" name="kodekota" value="{{ $kota->kodekota }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>

            <div class="col-md-12">
                <input id="jenis" type="text" class="form-control" name="jenis" @if ($kota->jenis == enum::JENISKOTA_KABUPATEN) value="Kabupaten" @endif @if ($kota->jenis == enum::JENISKOTA_KOTA) value="Kota" @endif readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="namakota" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kota/Kabupaten') }}</label>

            <div class="col-md-12">
                <input id="namakota" type="text" class="form-control" name="namakota" value="{{ $kota->namakota }}" readonly>
            </div>
        </div>

        {{-- <div class="form-group row">
            <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

            <div class="col-md-12">
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input type="checkbox" class="form-control custom-control-input" id="status" name="status" value="1" onclick="return false;" {{ ($kota->status == '1' ? ' checked' : '') }}>
                    <label class="custom-control-label" for="status">Aktif</label>
                </div>
            </div>
        </div> --}}

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kota.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kota') }}
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
