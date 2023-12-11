@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kawasan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('kawasan.edit', $kawasan->kawasanid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="namainstansi" class="col-md-12 col-form-label text-md-left">{{ __('Nama Instansi') }}</label>

            <div class="col-md-12">
                <input id="namainstansi" type="text" class="form-control" name="namainstansi" value="{{ $kawasan->namainstansi }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat') }}</label>

            <div class="col-md-12">
                <textarea id="alamat" class="form-control" name="alamat" readonly>{{ $kawasan->alamat }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>

            <div class="col-md-12">
                <input id="kotaid" type="text" class="form-control" name="kotaid" value="{{ $kawasan->kelurahan->kecamatan->kota->prov->namaprov . ' - ' . $kawasan->kelurahan->kecamatan->kota->kodekota . ' ' . $kawasan->kelurahan->kecamatan->kota->namakota }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>

            <div class="col-md-12">
                <input id="kecamatanid" type="text" class="form-control" name="kecamatanid" value="{{ $kawasan->kelurahan->kecamatan->kodekec . ' ' . $kawasan->kelurahan->kecamatan->namakec }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kelurahan" class="col-md-12 col-form-label text-md-left">{{ __('Kelurahan') }}</label>

            <div class="col-md-12">
                <input id="kelurahan" type="text" class="form-control" name="kelurahan" value="{{ $kawasan->kelurahan->kodekel . ' ' . $kawasan->kelurahan->namakel }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="notelp" class="col-md-12 col-form-label text-md-left">{{ __('No Telp') }}</label>

            <div class="col-md-12">
                <input id="notelp" type="text" class="form-control" name="notelp" value="{{ $kawasan->notelp }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

            <div class="col-md-12">
                <input id="email" type="email" class="form-control" name="email" value="{{ $kawasan->email }}" readonly>
            </div>
        </div>

        

        <div class="form-group row">
            <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

            <div class="col-md-12">
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input type="checkbox" class="form-control custom-control-input" id="status" name="status" value="1" onclick="return false;" {{ ($kawasan->status == '1' ? ' checked' : '') }}>
                    <label class="custom-control-label" for="status">Aktif</label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kawasan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kawasan') }}
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
