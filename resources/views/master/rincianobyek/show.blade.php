@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('rincianobyek.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('rincianobyek.edit', $roby->robyid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="obyid" class="col-md-12 col-form-label text-md-left">{{ __('Obyek') }}</label>

            <div class="col-md-12">
                <select id="obyid" class="form-control-select form-control @error('obyid') is-invalid @enderror" name='obyid' disabled>
                    <option value="">-- Pilih Obyek --</option>
                    @foreach ($oby as $item)
                        <option value="{{$item->obyid}}" @if ($roby->obyid == $item->obyid) selected @endif>{{ $item->obykode . ' ' . $item->obynama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="robykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Rincian Obyek') }}</label>

            <div class="col-md-12">
                <input id="robykode" type="text" class="form-control" name="robykode" value="{{ $roby->robykode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="robynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Rincian Obyek') }}</label>

            <div class="col-md-12">
                <input id="robynama" type="text" class="form-control" name="robynama" value="{{ $roby->robynama }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('rincianobyek.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Rincian Obyek') }}
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
