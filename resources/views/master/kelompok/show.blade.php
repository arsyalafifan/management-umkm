@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kelompok.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('kelompok.edit', $kelompok->kelid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="strukid" class="col-md-12 col-form-label text-md-left">{{ __('Struktur') }}</label>

            <div class="col-md-12">
                <input id="strukid" type="text" class="form-control" name="strukid" value="{{ $kelompok->struk->strukkode . ' ' . $kelompok->struk->struknama }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kelkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kelompok') }}</label>

            <div class="col-md-12">
                <input id="kelkode" type="text" class="form-control" name="kelkode" value="{{ $kelompok->kelkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kelnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kelompok') }}</label>

            <div class="col-md-12">
                <input id="kelnama" type="text" class="form-control" name="kelnama" value="{{ $kelompok->kelnama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kelompok.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kelompok') }}
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
