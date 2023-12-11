<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<style>
    input[disabled]{
      background-color:#ddd !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($tahun->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
        @if($isshow)
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('tahun.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('tahun.edit', $tahun->tahunid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>
        @endif
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

            <form method="POST" action="{{ $tahun->exists ? route('tahun.update', $tahun->tahunid) : route('tahun.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                @if($tahun->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="tahunid" id="tahunid" value="{{ $tahun->exists ? $tahun->tahunid : '' }}">

                <div class="form-group row">
                    <label for="tahun" class="col-md-12 col-form-label text-md-left">{{ __('Tahun *') }}</label>

                    <div class="col-md-12">
                        <input id="tahun" type="number" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ old('tahun', $tahun->tahun) }}" required autocomplete="name" @if($isshow) disabled @endif maxlength="4">

                        @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $tahun->nama) }}" autocomplete="name" @if($isshow) disabled @endif>

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1" @if (old("status", $tahun->status)=="1" || !$tahun->exists) checked @endif @if($isshow) onclick="return false;" @endif>
                            <label class="custom-control-label" for="status">Aktif</label>
                        </div>
                        @error('status')
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
                        <a href="{{ route('tahun.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Tahun') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();
    });

    @if(!$isshow)

    @endif
</script>
@endsection
