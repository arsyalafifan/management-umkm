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

            <form method="POST" action="{{ route('kecamatan.update', $kecamatan->kecamatanid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="kecamatanid" id="kecamatanid" value="{{ !is_null($kecamatan->kecamatanid) ? $kecamatan->kecamatanid : '' }}">

                <div class="form-group row">
                    <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten *') }}</label>

                    <div class="col-md-12">
                        <select id="kotaid" class="form-control-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach ($kota as $item)
                                <option value="{{$item->kotaid}}" @if ($kecamatan->kotaid == $item->kotaid) selected @endif>{{ $item->kodekota . ' ' . $item->namakota }}</option>
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
                    <label for="kodekec" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kecamatan *') }}</label>

                    <div class="col-md-12">
                        <input id="kodekec" type="text" class="form-control @error('kodekec') is-invalid @enderror" name="kodekec" value="{{ old('kodekec') ?? $kecamatan->kodekec }}" required autocomplete="kodekec">

                        @error('kodekec')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namakec" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kecamatan *') }}</label>

                    <div class="col-md-12">
                        <input id="namakec" type="text" class="form-control @error('namakec') is-invalid @enderror" name="namakec" value="{{ $kecamatan->namakec }}" required autocomplete="name" autofocus>

                        @error('namakec')
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
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1"{{ ($kecamatan->status == '1' ? ' checked' : '') }}>
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
                        <a href="{{ route('kecamatan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kecamatan') }}
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
        id = "{{ $kecamatan->kecamatanid }}";
        parentid = "{{ $kecamatan->kotaid }}";
        kode = "{{ $kecamatan->kodekec }}";

        $('#kotaid').select2().on('change', function() {
            if ($('#kotaid').val() == "") {
                $('#kodekec').val('');
            }
            else if ($('#kotaid').val() == parentid) {
                $('#kodekec').val(kode);
            }
            else {
                var url = "{{ route('kecamatan.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#kotaid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kodekec').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
</script>
@endsection
