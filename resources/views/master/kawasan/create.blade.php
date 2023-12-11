<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
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

            <form method="POST" action="{{ route('kawasan.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="namainstansi" class="col-md-12 col-form-label text-md-left">{{ __('Nama Instansi *') }}</label>

                    <div class="col-md-12">
                        <input id="namainstansi" type="text" class="form-control @error('namainstansi') is-invalid @enderror" name="namainstansi" value="{{ old('namainstansi') }}" required autocomplete="name">

                        @error('namainstansi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                    <div class="col-md-12">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name">{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten *') }}</label>

                    <div class="col-md-12">
                        <select id="kotaid" class="custom-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach ($kota as $item)
                            <option value="{{$item->kotaid}}">{{ $item->namaprov . ' - ' . $item->kodekota . ' ' . $item->namakota }}</option>
                            @endforeach
                        </select>

                        @error('kotaid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan *') }}</label>

                    <div class="col-md-12">
                        <select id="kecamatanid" class="custom-select form-control @error('kecamatanid') is-invalid @enderror" name='kecamatanid' required autofocus>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatan as $item)
                            <option value="{{$item->kecamatanid}}">{{ $item->kodekec . ' ' . $item->namakec }}</option>
                            @endforeach
                        </select>

                        @error('kecamatanid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kelurahanid" class="col-md-12 col-form-label text-md-left">{{ __('Kelurahan *') }}</label>

                    <div class="col-md-12">
                        <select id="kelurahanid" class="custom-select form-control @error('kelurahanid') is-invalid @enderror" name='kelurahanid' required autofocus>
                            <option value="">-- Pilih Kelurahan --</option>
                            @foreach ($kelurahan as $item)
                            <option value="{{$item->kelurahanid}}">{{ $item->kodekel . ' ' . $item->namakel }}</option>
                            @endforeach
                        </select>

                        @error('kelurahanid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="notelp" class="col-md-12 col-form-label text-md-left">{{ __('No Telp *') }}</label>

                    <div class="col-md-12">
                        <input id="notelp" type="text" class="form-control @error('notelp') is-invalid @enderror" name="notelp" value="{{ old('notelp') }}" required autocomplete="name">

                        @error('notelp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email *') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="name">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
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
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('kawasan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kawasan') }}
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
    var kecamatanid = '{{ old("kecamatanid") }}';
    var kelurahanid = '{{ old("kelurahanid") }}';

    $(document).ready(function() {
        $('.custom-select').select2();

        $('#kotaid').select2().on('change', function() {
            var url = "{{ route('kawasan.kecamatan', ':parentid') }}";
            url = url.replace(':parentid', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#kecamatanid').empty();
                    $('#kecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
                    $.each(data.data, function(key, value) {
                        $('#kecamatanid').append($("<option></option>").attr("value", value.kecamatanid).text(value.kodekec + ' ' + value.namakec));
                    });
                    $('#kecamatanid').select2();
                    $('#kecamatanid').val(kecamatanid);
                    $('#kecamatanid').trigger('change');
                }
            });
        })/*.trigger('change');*/

        $('#kecamatanid').select2().on('change', function() {
            var url = "{{ route('kawasan.kelurahan', ':parentid') }}";
            url = url.replace(':parentid', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#kelurahanid').empty();
                    $('#kelurahanid').append($("<option></option>").attr("value", "").text("-- Pilih Kelurahan --"));
                    $.each(data.data, function(key, value) {
                        $('#kelurahanid').append($("<option></option>").attr("value", value.kelurahanid).text(value.kodekel + ' ' + value.namakel));
                    });
                    $('#kelurahanid').select2();
                    $('#kelurahanid').val(kelurahanid);
                    $('#kelurahanid').trigger('change');
                }
            });
        })/*.trigger('change');*/
    });
</script>
@endsection
