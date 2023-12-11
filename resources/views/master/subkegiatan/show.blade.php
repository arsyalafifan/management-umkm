@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('subkegiatan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('subkegiatan.edit', $subkegiatan->subkegid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kegid" class="col-md-12 col-form-label text-md-left">{{ __('Kegiatan') }}</label>

            <div class="col-md-12">
                <select id="kegid" class="form-control-select form-control @error('kegid') is-invalid @enderror" name='kegid' disabled>
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach ($kegiatan as $item)
                        <option value="{{$item->kegid}}" @if ($subkegiatan->kegid == $item->kegid) selected @endif>{{ $item->kegkode . ' ' . $item->kegnama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="subkegkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Kegiatan') }}</label>

            <div class="col-md-12">
                <input id="subkegkode" type="text" class="form-control" name="subkegkode" value="{{ $subkegiatan->subkegkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="subkegnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Kegiatan') }}</label>

            <div class="col-md-12">
                <input id="subkegnama" type="text" class="form-control" name="subkegnama" value="{{ $subkegiatan->subkegnama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('subkegiatan.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Sub Kegiatan') }}
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
