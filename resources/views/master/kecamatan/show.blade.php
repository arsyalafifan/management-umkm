@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kecamatan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('kecamatan.edit', $kecamatan->kecamatanid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>

            <div class="col-md-12">
                <input id="kotaid" type="text" class="form-control" name="kotaid" value="{{ $kecamatan->kota->kodekota . ' ' . $kecamatan->kota->namakota }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kodekec" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kecamatan') }}</label>

            <div class="col-md-12">
                <input id="kodekec" type="text" class="form-control" name="kodekec" value="{{ $kecamatan->kodekec }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="namakec" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kecamatan') }}</label>

            <div class="col-md-12">
                <input id="namakec" type="text" class="form-control" name="namakec" value="{{ $kecamatan->namakec }}" readonly>
            </div>
        </div>

        {{-- <div class="form-group row">
            <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

            <div class="col-md-12">
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input type="checkbox" class="form-control custom-control-input" id="status" name="status" value="1" onclick="return false;" {{ ($kecamatan->status == '1' ? ' checked' : '') }}>
                    <label class="custom-control-label" for="status">Aktif</label>
                </div>
            </div>
        </div> --}}

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kecamatan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kecamatan') }}
                </a>
                {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                    {{ __('Home') }}
                </a> --}}
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    });
</script>
@endsection
