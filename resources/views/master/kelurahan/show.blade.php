@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kelurahan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('kelurahan.edit', $kelurahan->kelurahanid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>

            <div class="col-md-12">
                <input id="kotaid" type="text" class="form-control" name="kotaid" value="{{ $kelurahan->kecamatan->kota->prov->namaprov . ' - ' . $kelurahan->kecamatan->kota->kodekota . ' ' . $kelurahan->kecamatan->kota->namakota }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>

            <div class="col-md-12">
                <input id="kecamatanid" type="text" class="form-control" name="kecamatanid" value="{{ $kelurahan->kecamatan->kodekec . ' ' . $kelurahan->kecamatan->namakec }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kodekel" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kemendagri') }}</label>

            <div class="col-md-12">
                <input id="kodekel" type="text" class="form-control" name="kodekel" value="{{ $kelurahan->kodekel }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="namakel" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kelurahan') }}</label>

            <div class="col-md-12">
                <input id="namakel" type="text" class="form-control" name="namakel" value="{{ $kelurahan->namakel }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

            <div class="col-md-12">
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input type="checkbox" class="form-control custom-control-input" id="status" name="status" value="1" onclick="return false;" {{ ($kelurahan->status == '1' ? ' checked' : '') }}>
                    <label class="custom-control-label" for="status">Aktif</label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kelurahan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kelurahan') }}
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
