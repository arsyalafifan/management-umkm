<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5>
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

        <form method="POST" action="{{ route('ijazah.store') }}"
            class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$sekolah->sekolahid) }}">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="namasiswa">Nama Siswa</label>
                        <input type="text" class="form-control @error('namasiswa') is-invalid @enderror" id="namasiswa"
                            name="namasiswa" value="{{ old('namasiswa') }}" autofocus required>
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
                            id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" autofocus required>
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
                            name="tgl_lahir" value="{{ old('tgl_lahir') }}" autofocus required>
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
                            name="namaortu" value="{{ old('namaortu') }}" autofocus required>
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
                            value="{{ old('nis') }}" autofocus required>
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
                            name="noijazah" value="{{ old('noijazah') }}" autofocus required>
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
                            name="tgl_lulus" value="{{ old('tgl_lulus') }}" autofocus required>
                        @error('tgl_lulus')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row mb-0">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('ijazah.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index ijazah') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                        {{ __('Home') }}
                        </a> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<script>
</script>
@endsection
