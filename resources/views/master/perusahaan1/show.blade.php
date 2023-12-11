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
                <a href="{{ route('perusahaan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('perusahaan.edit', $perusahaan->perusahaanid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kodedaftar" class="col-md-12 col-form-label text-md-left">{{ __('Kode Daftar Perusahaan *') }}</label>

            <div class="col-md-12">
                <input id="kodedaftar" type="text" class="form-control" name="kodedaftar" value="{{ $perusahaan->kodedaftar }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="badanusaha" class="col-md-12 col-form-label text-md-left">{{ __('Badan Usaha *') }}</label>

            <div class="col-md-12">
                @if (old("badanusaha")==enum::BADANUSAHA_PERUSAHAAN_PERSEORANGAN) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Perusahaan Perseorangan' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_FIRMA) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Firma' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_CV) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'CV' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_PT) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'PT' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_PERSERO) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Persero' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_BUMD) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'BUMD' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_BUMN) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'BUMN' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_KOPERASI) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Koperasi' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_YAYASAN) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Yayasan' }}" readonly> @endif
                @if (old("badanusaha")==enum::BADANUSAHA_LAINNYA) <input id="badanusaha" type="text" class="form-control" name="badanusaha" value="{{ 'Lainnya' }}" readonly> @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Perusahaan *') }}</label>
            <div class="col-md-12">
                <input id="nama" type="text" class="form-control" name="nama" value="{{ $perusahaan->nama }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status *') }}</label>
            <div class="col-md-12">
                @if (old("status")==enum::STATUS_BADANUSAHA_PUSAT) <input id="status" type="text" class="form-control" name="status" value="{{ 'Pusat' }}" readonly> @endif
                @if (old("status")==enum::STATUS_BADANUSAHA_CABANG) <input id="status" type="text" class="form-control" name="status" value="{{ 'Cabang' }}" readonly> @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="kawasanid" class="col-md-12 col-form-label text-md-left">{{ __('Kawasan Industri') }}</label>
            <div class="col-md-12">
                <input id="kawasanid" type="text" class="form-control" name="kawasanid" value="{{ ( $perusahaan->kawasan ? $perusahaan->kawasan->namainstansi : "") }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>
            <div class="col-md-12">
                <textarea id="alamat" class="form-control" name="alamat" readonly>{{ $perusahaan->alamat }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="provinsiid" class="col-md-12 col-form-label text-md-left">{{ __('Provinsi *') }}</label>
            <div class="col-md-12">
                <input id="provinsiid" type="text" class="form-control" name="provinsiid" value="{{ $perusahaan->prov->namaprov }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota *') }}</label>
            <div class="col-md-12">
                <input id="kotaid" type="text" class="form-control" name="kotaid" value="{{ $perusahaan->kota->namakota }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan *') }}</label>
            <div class="col-md-12">
                <input id="kecamatanid" type="text" class="form-control" name="kecamatanid" value="{{ ($perusahaan->kecamatan ? $perusahaan->kecamatan->namakec : "") }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kelurahanid" class="col-md-12 col-form-label text-md-left">{{ __('Kelurahan *') }}</label>
            <div class="col-md-12">
                <input id="kelurahanid" type="text" class="form-control" name="kelurahanid" value="{{ ($perusahaan->kelurahan ? $perusahaan->kelurahan->namakel : "") }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>
            <div class="col-md-12">
                <input id="email" type="text" class="form-control" name="email" value="{{ $perusahaan->email }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="website" class="col-md-12 col-form-label text-md-left">{{ __('Website') }}</label>
            <div class="col-md-12">
                <input id="website" type="text" class="form-control" name="website" value="{{ $perusahaan->website }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="telp" class="col-md-12 col-form-label text-md-left">{{ __('Telp *') }}</label>
            <div class="col-md-12">
                <input id="telp" type="text" class="form-control" name="telp" value="{{ $perusahaan->telp }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="npwp" class="col-md-12 col-form-label text-md-left">{{ __('NPWP *') }}</label>
            <div class="col-md-12">
                <input id="npwp" type="text" class="form-control" name="npwp" value="{{ $perusahaan->npwp }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="nib" class="col-md-12 col-form-label text-md-left">{{ __('NIB *') }}</label>
            <div class="col-md-12">
                <input id="nib" type="text" class="form-control" name="nib" value="{{ $perusahaan->nib }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="bidangusahaid" class="col-md-12 col-form-label text-md-left">{{ __('Bidang Usaha *') }}</label>
            <div class="col-md-12">
                <input id="bidangusahaid" type="text" class="form-control" name="bidangusahaid" value="{{ ($perusahaan->bidangusaha ? $perusahaan->bidangusaha->bidangparent->kode.$perusahaan->bidangusaha->kode." ".$perusahaan->bidangusaha->bidangusaha : "") }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kbli" class="col-md-12 col-form-label text-md-left">{{ __('KBLI *') }}</label>
            <div class="col-md-12">
                <input id="kbli" type="text" class="form-control" name="kbli" value="{{ $perusahaan->kbli }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('perusahaan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Perusahaan') }}
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
