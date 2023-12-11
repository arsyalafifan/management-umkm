@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('subrincianobyek.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('subrincianobyek.edit', $sroby->srobyid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Ubah') }}</a>
            </div>
        </div>

        <div class="form-group row">
            <label for="robyid" class="col-md-12 col-form-label text-md-left">{{ __('Rincian Obyek') }}</label>

            <div class="col-md-12">
                <select id="robyid" class="form-control-select form-control @error('robyid') is-invalid @enderror" name='robyid' disabled>
                    <option value="">-- Pilih Rincian Obyek --</option>
                    @foreach ($roby as $item)
                        <option value="{{$item->robyid}}" @if ($sroby->robyid == $item->robyid) selected @endif>{{ $item->robykode . ' ' . $item->robynama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="srobykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Rincian Obyek') }}</label>

            <div class="col-md-12">
                <input id="srobykode" type="text" class="form-control" name="srobykode" value="{{ $sroby->srobykode }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="srobynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Rincian Obyek') }}</label>

            <div class="col-md-12">
                <input id="srobynama" type="text" class="form-control" name="srobynama" value="{{ $sroby->srobynama }}" readonly>
            </div>
        </div>

        <div class="form-group row col-lg-12">
            <div class="form-group col-lg-6">
                <label for="isskpd" class="form-control-label text-right">Rek SKPD</label>
                <input type="checkbox" id="isskpd" name="isskpd" value="1" {{ $sroby->isskpd ? 'checked' : '' }} disabled>
            </div>
            <div class="form-group col-lg-6">
                <label for="isssh" class="form-control-label text-right">Tanpa SSH</label>
                <input type="checkbox" id="isssh" name="isssh" value="1" {{ $sroby->isssh ?  '' : 'checked' }} disabled>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('subrincianobyek.index') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Sub Rincian Obyek') }}
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
