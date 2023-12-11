<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5>
        <hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('ijazah.edit', $ijazah->ijazahid) }}"
                    class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="col-md-12">
            <input type="hidden" name="ijazahid" id="ijazahid"
                value="{{ !is_null($ijazah->ijazahid) ? $ijazah->ijazahid : '' }}">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="namasiswa">Nama Siswa</label>
                    <input type="text" class="form-control @error('namasiswa') is-invalid @enderror" id="namasiswa"
                        name="namasiswa" value="{{ old('namasiswa', $ijazah->namasiswa) }}" autofocus readonly>
                    @error('namasiswa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tempat_lahir">Tempat</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir',$ijazah->tempat_lahir) }}"
                        autofocus readonly>
                    @error('tempat_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir"
                        name="tgl_lahir" value="{{ old('tgl_lahir',$ijazah->tgl_lahir) }}" autofocus readonly>
                    @error('tgl_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="namaortu">Nama Orang Tua</label>
                    <input type="text" class="form-control @error('namaortu') is-invalid @enderror" id="namaortu"
                        name="namaortu" value="{{ old('namaortu', $ijazah->namaortu) }}" autofocus readonly>
                    @error('namaortu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="nis">Nomor Induk Siswa</label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis"
                        value="{{ old('nis',$ijazah->nis) }}" autofocus readonly>
                    @error('nis')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="noijazah">Nomor Ijazah</label>
                    <input type="text" class="form-control @error('noijazah') is-invalid @enderror" id="noijazah"
                        name="noijazah" value="{{ old('noijazah',$ijazah->noijazah) }}" autofocus readonly>
                    @error('noijazah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="tgl_lulus">Tanggal Kelulusan</label>
                    <input type="date" class="form-control @error('tgl_lulus') is-invalid @enderror" id="tgl_lulus"
                        name="tgl_lulus" value="{{ old('tgl_lulus',$ijazah->tgl_lulus) }}" autofocus readonly>
                    @error('tgl_lulus')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row mb-0">
                    <a href="{{ route('ijazah.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                        {{ __('Index Ijazah') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {});

</script>
@endsection
