<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">EDIT DATA</h5><hr />
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

            <form method="POST" action="{{ route('perusahaan.update', $perusahaan->perusahaanid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" id="formPerusahaan">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Perusahaan *') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?? $perusahaan->nama }}" required autocomplete="name">

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telp" class="col-md-12 col-form-label text-md-left">{{ __('Telepon *') }}</label>

                    <div class="col-md-12">
                        <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp') ?? $perusahaan->telp }}" required autocomplete="telp">

                        @error('telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis *') }}</label>

                    <div class="col-md-12">
                        <select id="jenis" class="custom-select form-control @error('jenis') is-invalid @enderror" name='jenis' required autofocus>
                            <option value="">-- Pilih Jenis --</option>
                            <option @if (old("jenis") != '' && old("jenis") == 'PT' || $perusahaan->jenis == 'PT') selected @endif value="{{ old('jenis') ?? "PT" }}">{{ 'PT' }}</option>
                            <option @if (old("jenis") != '' && old("jenis") == 'CV' || $perusahaan->jenis == 'CV') selected @endif value="{{ old('jenis') ?? "CV" }}">{{ 'CV' }}</option>
                            <option @if (old("jenis") != '' && old("jenis") == 'Lainnya' || $perusahaan->jenis == 'Lainnya') selected @endif value="{{ old('jenis') ?? "Lainnya" }}">{{ 'Lainnya' }}</option>
                        </select>

                        @error('jenis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="npwp" class="col-md-12 col-form-label text-md-left">{{ __('NPWP *') }}</label>

                    <div class="col-md-12">
                        <input id="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ old('npwp') ?? $perusahaan->npwp }}" required autocomplete="name">

                        @error('npwp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namapimpinan" class="col-md-12 col-form-label text-md-left">{{ __('Nama Pimpinan *') }}</label>

                    <div class="col-md-12">
                        <input id="namapimpinan" type="text" class="form-control @error('namapimpinan') is-invalid @enderror" name="namapimpinan" value="{{ old('namapimpinan') ?? $perusahaan->namapimpinan }}" required autocomplete="name">

                        @error('namapimpinan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                    <div class="col-md-12">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name">{{ old('alamat') ?? $perusahaan->alamat }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('perusahaan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Perusahaan') }}
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
    var kecamatanid = '{{ old("kecamatanid") }}';
    var kelurahanid = '{{ old("kelurahanid") }}';

    $(document).ready(function() {
        $('.custom-select').select2();
        //TO BE DISABLED NEXT
        // $('#provinsiid').prop('disabled', true);

        $('#formPerusahaan').on('submit', function() {
            $('#provinsiid').prop('disabled', false);
        });
    });
</script>
@endsection
