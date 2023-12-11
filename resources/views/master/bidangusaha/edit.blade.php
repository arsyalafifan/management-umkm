<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">UBAH DATA</h5><hr />
            @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </p>
            @endforeach
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <form method="POST" action="{{ route('bidangusaha.update', $bidangusaha->bidangusahaid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="bidangusahaid" id="bidangusahaid" value="{{ !is_null($bidangusaha->bidangusahaid) ? $bidangusaha->bidangusahaid : '' }}">

                <div class="form-group row">
                    <label for="bidang" class="col-md-12 col-form-label text-md-left">{{ __('Bidang *') }}</label>

                    <div class="col-md-12">
                        <select id="bidang" class="custom-select form-control @error('bidang') is-invalid @enderror" name='bidang' required autofocus>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="{{enum::BIDANG_PERTANIAN}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_PERTANIAN) selected @endif>{{ 'Pertanian' }}</option>
                            <option value="{{enum::BIDANG_PRODUKSI_BAHAN_MENTAH}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_PRODUKSI_BAHAN_MENTAH) selected @endif>{{ 'Produksi Bahan Mentah' }}</option>
                            <option value="{{enum::BIDANG_MANUFAKTUR}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_MANUFAKTUR) selected @endif>{{ 'Manufaktur' }}</option>
                            <option value="{{enum::BIDANG_KONSTRUKSI}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_KONSTRUKSI) selected @endif>{{ 'Konstruksi' }}</option>
                            <option value="{{enum::BIDANG_TRANSPORTASI}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_TRANSPORTASI) selected @endif>{{ 'Transportasi' }}</option>
                            <option value="{{enum::BIDANG_KOMUNIKASI}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_KOMUNIKASI) selected @endif>{{ 'Komunikasi' }}</option>
                            <option value="{{enum::BIDANG_PERDAGANGAN_BESAR_KECIL}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_PERDAGANGAN_BESAR_KECIL) selected @endif>{{ 'Perdagangan Besar/Kecil' }}</option>
                            <option value="{{enum::BIDANG_FINANSIAL}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_FINANSIAL) selected @endif>{{ 'Finansial' }}</option>
                            <option value="{{enum::BIDANG_JASA}}" @if (old('bidang', $bidangusaha->bidang) == enum::BIDANG_JASA) selected @endif>{{ 'Jasa' }}</option>
                        </select>

                        @error('bidang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kodebidang" class="col-md-12 col-form-label text-md-left">{{ __('Kode *') }}</label>

                    <div class="col-md-6">
                        <input id="kodebidang" type="text" class="form-control @error('kodebidang') is-invalid @enderror" name="kodebidang" value="{{ old('kodebidang', $bidangusaha->kodebidang) }}" maxlength="100" required autocomplete="kodebidang" readonly>

                        @error('kodebidang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <input id="kode" type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $bidangusaha-> kode) }}" maxlength="100" required autocomplete="kode">

                        @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bidangusaha" class="col-md-12 col-form-label text-md-left">{{ __('Bidang Usaha *') }}</label>

                    <div class="col-md-12">
                        <input id="bidangusaha" type="text" class="form-control @error('bidangusaha') is-invalid @enderror" name="bidangusaha" value="{{ old('bidangusaha', $bidangusaha->bidangusaha) }}" required autocomplete="name" autofocus>

                        @error('bidangusaha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('bidangusaha.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Bidang Usaha ') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var id = '';
    var parentid = '';
    var kode = '';
    $(document).ready(function() {
        $('.form-control-select').select2();
        id = "{{ old('bidangusahaid', $bidangusaha->bidangusahaid) }}";
        parentid = "{{ old('bidang', $bidangusaha->bidang) }}";
        kode = "{{ old('kode', $bidangusaha->kode) }}";

        $('#bidang').select2().on('change', function() {
            if ($('#bidang').val() != "") {
                $('#kodebidang').val($('#bidang').val()+'.');
            }
            if ($('#bidang').val() == "") {
                $('#kode').val('');
            }
            else if ($('#bidang').val() == parentid) {
                $('#kode').val(kode);
            }
            else {
                var url = "{{ route('bidangusaha.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#bidang').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
