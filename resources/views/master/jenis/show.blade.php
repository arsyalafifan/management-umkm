@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('jenis.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('jenis.edit', $jenis->jenid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="kelid" class="col-md-12 col-form-label text-md-left">{{ __('Kelompok') }}</label>

            <div class="col-md-12">
                <select id="kelid" class="form-control-select form-control @error('kelid') is-invalid @enderror" name='kelid' disabled>
                    <option value="">-- Pilih Kelompok --</option>
                    @foreach ($kel as $item)
                        <option value="{{$item->kelid}}" @if ($jenis->kelid == $item->kelid) selected @endif>{{ $item->kelkode . ' ' . $item->kelnama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="jenkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Jenis') }}</label>

            <div class="col-md-12">
                <input id="jenkode" type="text" class="form-control" name="jenkode" value="{{ $jenis->jenkode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="jennama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Jenis') }}</label>

            <div class="col-md-12">
                <input id="jennama" type="text" class="form-control" name="jennama" value="{{ $jenis->jennama }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="dasarhukum" class="col-md-12 col-form-label text-md-left">{{ __('Dasar Hukum') }}</label>

            <div class="col-md-12">
                <input id="dasarhukum" type="text" class="form-control" name="dasarhukum" value="{{ $jenis->dasarhukum }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('jenis.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Jenis') }}
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
