<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('namasarpras.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5"><i class="fa fa-plus-circle"></i> {{ __('Tambah') }}</a>
                <a href="{{ route('namasarpras.edit', $namasarpras->namasarprasid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5"><i class="fa fa-pencil-square-o"></i> {{ __('Ubah') }}</a>
            </div>
        </div>
        <div class="form-group row">
            <label for="namasarpras" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpas *') }}</label>

            <div class="col-md-12">
                <input id="namasarpras" type="text" class="form-control @error('namasarpras') is-invalid @enderror" name="namasarpras" value="{{ old('namasarpras') ?? $namasarpras->namasarpras }}" maxlength="100" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="kategorisarpras" class="col-md-12 col-form-label text-md-left">{{ __('Kategori Sarpras *') }}</label>

            <div class="col-md-12">
                <input id="kategorisarpras" type="text" class="form-control" name="kategorisarpras" value="{{ $namasarpras->kategorisarpras == enum::SARPRAS_UTAMA ? "Sarpras Utama" : ($namasarpras->kategorisarpras == enum::SARPRAS_PENUNJANG ? "Sarpras Penunjang" : ($namasarpras->kategorisarpras == enum::SARPRAS_PERALATAN ? "Sarpras Peralatan" : "-" )) }}" maxlength="100" readonly>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Simpan') }}
                </button>
                <a href="{{ route('namasarpras.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                    {{ __('Index Nama Sarpras') }}
                </a>
                {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                    {{ __('Home') }}
                </a> --}}
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        $('#provid').select2().on('change', function() {
            if ($('#provid').val() == "") {
                $('#kodekota').val('');
            }
            else {
                var url = "{{ route('kota.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#provid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kodekota').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
