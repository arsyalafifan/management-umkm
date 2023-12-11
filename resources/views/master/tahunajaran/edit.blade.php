<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">EDIT DATA</h5><hr />
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

            <form method="POST" action="{{ route('tahunajaran.update', $tahunajaran->tahunajaranid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="tahunajaranid" id="tahunajaranid" value="{{ !is_null($tahunajaran->tahunajaranid) ? $tahunajaran->tahunajaranid : '' }}">
                <div class="form-group row">
                    <label for="daritahun" class="col-md-12 col-form-label text-md-left">{{ __('Dari Tahun *') }}</label>

                    <div class="col-md-12">
                        <select id="daritahun" class="custom-select form-control @error('daritahun') is-invalid @enderror" name='daritahun' required autofocus>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($listtahun as $tahun)
                                <option {{ $tahunajaran->daritahun == $tahun['tahun'] ? 'selected' : '' }} value="{{ old('daritahun') ?? $tahun['tahun'] }}">{{ $tahun['tahun'] }}</option>
                            @endforeach
                        </select>

                        @error('daritahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="daribulan" class="col-md-12 col-form-label text-md-left">{{ __('Dari Bulan *') }}</label>

                    <div class="col-md-12">
                        <select id="daribulan" class="custom-select form-control @error('daribulan') is-invalid @enderror" name='daribulan' required autofocus>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach ($listbulan as $bulan)
                                <option {{ $tahunajaran->daribulan == $bulan['bulan'] ? 'selected' : '' }} value="{{ old('daribulan') ?? $bulan['bulan'] }}">{{ $bulan['bulanvw'] }}</option>
                            @endforeach
                        </select>

                        @error('daribulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sampaitahun" class="col-md-12 col-form-label text-md-left">{{ __('Sampai Tahun *') }}</label>

                    <div class="col-md-12">
                        <select id="sampaitahun" class="custom-select form-control @error('sampaitahun') is-invalid @enderror" name='sampaitahun' required autofocus>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($listtahun as $tahun)
                                <option {{ $tahunajaran->sampaitahun == $tahun['tahun'] ? 'selected' : '' }} value="{{ old('sampaitahun') ?? $tahun['tahun'] }}">{{ $tahun['tahun'] }}</option>
                            @endforeach
                        </select>

                        @error('sampaitahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sampaibulan" class="col-md-12 col-form-label text-md-left">{{ __('Sampai Bulan *') }}</label>

                    <div class="col-md-12">
                        <select id="sampaibulan" class="custom-select form-control @error('sampaibulan') is-invalid @enderror" name='sampaibulan' required autofocus>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach ($listbulan as $bulan)
                                <option {{ $tahunajaran->sampaibulan == $bulan['bulan'] ? 'selected' : '' }} value="{{ old('sampaibulan') ?? $bulan['bulan'] }}">{{ $bulan['bulanvw'] }}</option>
                            @endforeach
                        </select>

                        @error('sampaibulan')
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
                        <a href="{{ route('tahunajaran.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Tahun Ajaran') }}
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

        // $('#provid').select2().on('change', function() {
        //     if ($('#provid').val() == "") {
        //         $('#kodekota').val('');
        //     }
        //     else {
        //         var url = "{{ route('kota.nextno', ':parentid') }}"
        //         url = url.replace(':parentid', $('#provid').val());
        //         $.ajax({
        //             url:url,
        //             type:'GET',
        //             success:function(data) {
        //                 $('#kodekota').val(data);
        //             }
        //         });
        //     }
        // }).trigger('change');
    });
</script>
@endsection
