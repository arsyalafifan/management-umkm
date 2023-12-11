<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
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

            <form method="POST" action="{{ route('kota.update', $kota->kotaid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="kotaid" id="kotaid" value="{{ !is_null($kota->kotaid) ? $kota->kotaid : '' }}">

                <div class="form-group row">
                    <label for="kodekota" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kota/Kab *') }}</label>

                    <div class="col-md-12">
                        <input id="kodekota" type="text" class="form-control @error('kodekota') is-invalid @enderror" name="kodekota" value="{{ old('kodekota') ?? $kota->kodekota }}" required autocomplete="kodekota">

                        @error('kodekota')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis *') }}</label>

                    <div class="col-md-12">
                        <select id="jenis" class="form-control-select form-control @error('jenis') is-invalid @enderror" name='jenis' required autofocus>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="{{enum::JENISKOTA_KABUPATEN}}" @if ($kota->jenis == enum::JENISKOTA_KABUPATEN) selected @endif>{{ 'Kabupaten' }}</option>
                            <option value="{{enum::JENISKOTA_KOTA}}" @if ($kota->jenis == enum::JENISKOTA_KOTA) selected @endif>{{ 'Kota' }}</option>
                        </select>

                        @error('jenis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namakota" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kota/Kabupaten *') }}</label>

                    <div class="col-md-12">
                        <input id="namakota" type="text" class="form-control @error('namakota') is-invalid @enderror" name="namakota" value="{{ old('namakota') ??  $kota->namakota }}" required autocomplete="name" autofocus>

                        @error('namakota')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1"{{ ($kota->status == '1' ? ' checked' : '') }}>
                            <label class="custom-control-label" for="status">Aktif</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('kota.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kota') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a> --}}
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
        id = "{{ $kota->kotaid }}";
        parentid = "{{ $kota->provid }}";
        kode = "{{ $kota->kodekota }}";

        $('#provid').select2().on('change', function() {
            if ($('#provid').val() == "") {
                $('#kodekota').val('');
            }
            else if ($('#provid').val() == parentid) {
                $('#kodekota').val(kode);
            }
            else {
                var url = "{{ route('kota.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#provid').val());
                url = url.replace(':id', id);
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
</script>
@endsection
