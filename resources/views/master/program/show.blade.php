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
                <a href="{{ route('program.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('program.edit', $program->progid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="progkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Program') }}</label>

            <div class="col-md-12">
                <input id="progkode" type="text" class="form-control" name="progkode" value="{{ $program->progkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="prognama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Program') }}</label>

            <div class="col-md-12">
                <input id="prognama" type="text" class="form-control" name="prognama" value="{{ $program->prognama }}" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('program.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Program') }}
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
