@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('subgolpokok.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('subgolpokok.edit', $subgolpokok->subgolpokokid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="golpokokid" class="col-md-12 col-form-label text-md-left">{{ __('Gol. Pokok') }}</label>

            <div class="col-md-12">
                <input id="golpokokid" type="text" class="form-control" name="golpokokid" value="{{ $subgolpokok->golpokok->kode . ' ' . $subgolpokok->golpokok->nama }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Gol. Pokok') }}</label>

            <div class="col-md-12">
                <input id="kode" type="text" class="form-control" name="kode" value="{{ $subgolpokok->kode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Gol. Pokok') }}</label>

            <div class="col-md-12">
                <input id="nama" type="text" class="form-control" name="nama" value="{{ $subgolpokok->nama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('subgolpokok.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Sub Golongan Pokok') }}
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
