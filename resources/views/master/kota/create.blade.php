<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5><hr />
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

            <form method="POST" action="{{ route('kota.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="kodekota" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kota/Kabupaten *') }}</label>

                    <div class="col-md-12">
                        <input id="kodekota" type="text" class="form-control @error('kodekota') is-invalid @enderror" name="kodekota" value="{{ (old('kodekota') ?? $kodekota) }}" maxlength="100" required autocomplete="kodekota" autofocus>

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
                        <select id="jenis" class="custom-select form-control @error('jenis') is-invalid @enderror" name='jenis' required autofocus>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="{{enum::JENISKOTA_KABUPATEN}}">{{ 'Kabupaten' }}</option>
                            <option value="{{enum::JENISKOTA_KOTA}}">{{ 'Kota' }}</option>
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
                        <input id="namakota" type="text" class="form-control @error('namakota') is-invalid @enderror" name="namakota" value="{{ old('namakota') }}" required autocomplete="name">

                        @error('namakota')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1" checked>
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
