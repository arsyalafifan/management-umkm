@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('kegiatan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('kegiatan.edit', $kegiatan->kegid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="progid" class="col-md-12 col-form-label text-md-left">{{ __('Program') }}</label>

            <div class="col-md-12">
                <input id="progid" type="text" class="form-control" name="progid" value="{{ $kegiatan->program->progkode . ' ' . $kegiatan->program->prognama }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kegkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kegiatan') }}</label>

            <div class="col-md-12">
                <input id="kegkode" type="text" class="form-control" name="kegkode" value="{{ $kegiatan->kegkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kegnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kegiatan') }}</label>

            <div class="col-md-12">
                <input id="kegnama" type="text" class="form-control" name="kegnama" value="{{ $kegiatan->kegnama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Kegiatan') }}
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
