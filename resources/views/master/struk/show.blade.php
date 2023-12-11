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
                <a href="{{ route('struk.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('struk.edit', $struk->strukid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="strukkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Struktur') }}</label>

            <div class="col-md-12">
                <input id="strukkode" type="text" class="form-control" name="strukkode" value="{{ $struk->strukkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="struknama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Struktur') }}</label>

            <div class="col-md-12">
                <input id="struknama" type="text" class="form-control" name="struknama" value="{{ $struk->struknama }}" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('struk.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Struktur') }}
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
