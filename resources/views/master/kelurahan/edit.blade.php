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

            <form method="POST" action="{{ route('kelurahan.update', $kelurahan->kelurahanid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="kelurahanid" id="kelurahanid" value="{{ !is_null($kelurahan->kelurahanid) ? $kelurahan->kelurahanid : '' }}">

                <div class="form-group row">
                    <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten *') }}</label>

                    <div class="col-md-12">
                        <select id="kotaid" class="form-control-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach ($kota as $item)
                                <option value="{{$item->kotaid}}" @if ($kelurahan->kecamatan->kotaid == $item->kotaid) selected @endif>{{ $item->namaprov . ' - ' . $item->kodekota . ' ' . $item->namakota }}</option>
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
                        <select id="kecamatanid" class="form-control-select form-control @error('kecamatanid') is-invalid @enderror" name='kecamatanid' required autofocus>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatan as $item)
                                <option value="{{$item->kecamatanid}}" @if ($kelurahan->kecamatanid == $item->kecamatanid) selected @endif>{{ $item->kodekec . ' ' . $item->namakec }}</option>
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
                    <label for="kodekel" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kelurahan *') }}</label>

                    <div class="col-md-12">
                        <input id="kodekel" type="text" class="form-control @error('kodekel') is-invalid @enderror" name="kodekel" value="{{ $kelurahan->kodekel }}" required autocomplete="kodekel">

                        @error('kodekel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namakel" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kelurahan *') }}</label>

                    <div class="col-md-12">
                        <input id="namakel" type="text" class="form-control @error('namakel') is-invalid @enderror" name="namakel" value="{{ $kelurahan->namakel }}" required autocomplete="name" autofocus>

                        @error('namakel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1"{{ ($kelurahan->status == '1' ? ' checked' : '') }}>
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
                        <a href="{{ route('kelurahan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kelurahan') }}
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
    var kecamatanid = '{{ old("kecamatanid", $kelurahan->kecamatanid) }}';

    $(document).ready(function() {
        $('.form-control-select').select2();
        id = "{{ $kelurahan->kelurahanid }}";
        parentid = "{{ $kelurahan->kecamatanid }}";
        kode = "{{ $kelurahan->kodekel }}";

        $('#kotaid').select2().on('change', function() {
            var url = "{{ route('kelurahan.kecamatan', ':parentid') }}";
            url = url.replace(':parentid', $('#kotaid').val());
                            
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
        }).trigger('change');

        $('#kecamatanid').select2().on('change', function() {
            if ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null) {
                $('#kodekel').val('');
            }
            else if ($('#kecamatanid').val() == parentid) {
                $('#kodekel').val(kode);
            }
            else {
                var url = "{{ route('kelurahan.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#kecamatanid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kodekel').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
</script>
@endsection
