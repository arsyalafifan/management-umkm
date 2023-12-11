@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('obyek.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('obyek.edit', $obyek->obyid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="jenid" class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>

            <div class="col-md-12">
                <select id="jenid" class="form-control-select form-control @error('jenid') is-invalid @enderror" name='jenid' disabled>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach ($jen as $item)
                        <option value="{{$item->jenid}}" @if ($obyek->jenid == $item->jenid) selected @endif>{{ $item->jenkode . ' ' . $item->jennama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="obykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Obyek') }}</label>

            <div class="col-md-12">
                <input id="obykode" type="text" class="form-control" name="obykode" value="{{ $obyek->obykode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="obynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Obyek') }}</label>

            <div class="col-md-12">
                <input id="obynama" type="text" class="form-control" name="obynama" value="{{ $obyek->obynama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('obyek.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Obyek') }}
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
