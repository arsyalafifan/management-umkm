@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('golpokok.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('golpokok.edit', $golpokok->golpokokid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Gol. Pokok') }}</label>

            <div class="col-md-12">
                <input id="kode" type="text" class="form-control" name="kode" value="{{ $golpokok->kode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Gol. Pokok') }}</label>

            <div class="col-md-12">
                <input id="nama" type="text" class="form-control" name="nama" value="{{ $golpokok->nama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('golpokok.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Golongan Pokok') }}
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
