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

            <form method="POST" action="{{ route('perusahaan.update', $perusahaan->perusahaanid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" id="formPerusahaan">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="perusahaanid" id="perusahaanid" value="{{ !is_null($perusahaan->perusahaanid) ? $perusahaan->perusahaanid : '' }}">

                <div class="form-group row">
                    <label for="kodedaftar" class="col-md-12 col-form-label text-md-left">{{ __('Kode Daftar Perusahaan *') }}</label>

                    <div class="col-md-12">
                        <input id="kodedaftar" type="text" class="form-control @error('kodedaftar') is-invalid @enderror" name="kodedaftar" value="{{ old('kodedaftar', $perusahaan->kodedaftar) }}" required autocomplete="name">

                        @error('kodedaftar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="badanusaha" class="col-md-12 col-form-label text-md-left">{{ __('Badan Usaha *') }}</label>

                    <div class="col-md-12">
                        <select id="badanusaha" class="custom-select form-control @error('badanusaha') is-invalid @enderror" name='badanusaha' required autofocus>
                            <option value="">-- Pilih Badan Usaha --</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_PERUSAHAAN_PERSEORANGAN) selected @endif value="{{enum::BADANUSAHA_PERUSAHAAN_PERSEORANGAN}}">{{ 'Perusahaan Perseorangan' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_FIRMA) selected @endif value="{{enum::BADANUSAHA_FIRMA}}">{{ 'Firma' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_CV) selected @endif value="{{enum::BADANUSAHA_CV}}">{{ 'CV' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_PT) selected @endif value="{{enum::BADANUSAHA_PT}}">{{ 'PT' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_PERSERO) selected @endif value="{{enum::BADANUSAHA_PERSERO}}">{{ 'Persero' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_BUMD) selected @endif value="{{enum::BADANUSAHA_BUMD}}">{{ 'BUMD' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_BUMN) selected @endif value="{{enum::BADANUSAHA_BUMN}}">{{ 'BUMN' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_KOPERASI) selected @endif value="{{enum::BADANUSAHA_KOPERASI}}">{{ 'Koperasi' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_YAYASAN) selected @endif value="{{enum::BADANUSAHA_YAYASAN}}">{{ 'Yayasan' }}</option>
                            <option @if (old("badanusaha", $perusahaan->badanusaha)==enum::BADANUSAHA_LAINNYA) selected @endif value="{{enum::BADANUSAHA_LAINNYA}}">{{ 'Lainnya' }}</option>
                        </select>

                        @error('badanusaha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Perusahaan *') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $perusahaan->nama) }}" required autocomplete="name">

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status *') }}</label>

                    <div class="col-md-12">
                        <select id="status" class="custom-select form-control @error('status') is-invalid @enderror" name='status' required autofocus>
                            <option value="">-- Pilih Status --</option>
                            <option value="{{enum::STATUS_BADANUSAHA_PUSAT}}" @if (old("status", $perusahaan->status)==enum::STATUS_BADANUSAHA_PUSAT) selected @endif>{{ 'Pusat' }}</option>
                            <option value="{{enum::STATUS_BADANUSAHA_CABANG}}" @if (old("status", $perusahaan->status)==enum::STATUS_BADANUSAHA_CABANG) selected @endif>{{ 'Cabang' }}</option>
                        </select>

                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kawasanid" class="col-md-12 col-form-label text-md-left">{{ __('Kawasan Industri') }}</label>

                    <div class="col-md-12">
                        <select id="kawasanid" class="custom-select form-control @error('kawasanid') is-invalid @enderror" name='kawasanid' autofocus>
                            <option value="">-- Pilih Kawasan Industri --</option>
                            @foreach ($kawasan as $item)
                            <option data-provid="{{$item->provid}}" data-kotaid="{{$item->kotaid}}" data-kecamatanid="{{$item->kecamatanid}}" data-kelurahanid="{{$item->kelurahanid}}" value="{{$item->kawasanid}}" @if (old("kawasanid", $perusahaan->kawasanid)==$item->kawasanid) selected @endif>{{ $item->namainstansi }}</option>
                            @endforeach
                        </select>

                        @error('kawasanid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                    <div class="col-md-12">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name">{{ old('alamat', $perusahaan->alamat) }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="provinsiid" class="col-md-12 col-form-label text-md-left">{{ __('Provinsi *') }}</label>

                    <div class="col-md-12">
                        <select id="provinsiid" class="custom-select form-control @error('provinsiid') is-invalid @enderror" name='provinsiid' required autofocus>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($prov as $item)
                            <option value="{{$item->provid}}" @if (old('provinsiid', $perusahaan->provinsiid) == $item->provid) selected @endif>{{ $item->kodeprov . ' ' . $item->namaprov }}</option>
                            @endforeach
                        </select>

                        @error('provinsiid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota *') }}</label>

                    <div class="col-md-12">
                        <select id="kotaid" class="custom-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus>
                            <option value="">-- Pilih Kota --</option>
                            @foreach ($kota as $item)
                            <option value="{{$item->kotaid}}" @if (old('kotaid', $perusahaan->kotaid) == $item->kotaid) selected @endif>{{ $item->kodekota . ' ' . $item->namakota }}</option>
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
                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $perusahaan->email) }}" autocomplete="name">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="website" class="col-md-12 col-form-label text-md-left">{{ __('Website') }}</label>

                    <div class="col-md-12">
                        <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $perusahaan->website) }}" autocomplete="name">

                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telp" class="col-md-12 col-form-label text-md-left">{{ __('Telp *') }}</label>

                    <div class="col-md-12">
                        <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp', $perusahaan->telp) }}" required autocomplete="name">

                        @error('telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="npwp" class="col-md-12 col-form-label text-md-left">{{ __('NPWP *') }}</label>

                    <div class="col-md-12">
                        <input id="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ old('npwp', $perusahaan->npwp) }}" required autocomplete="name">

                        @error('npwp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nib" class="col-md-12 col-form-label text-md-left">{{ __('NIB *') }}</label>

                    <div class="col-md-12">
                        <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" name="nib" value="{{ old('nib', $perusahaan->nib) }}" required autocomplete="name">

                        @error('nib')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bidangusahaid" class="col-md-12 col-form-label text-md-left">{{ __('Bidang Usaha *') }}</label>

                    <div class="col-md-12">
                        <select id="bidangusahaid" class="custom-select form-control @error('bidangusahaid') is-invalid @enderror" name='bidangusahaid' required autofocus>
                            <option value="" data-kode="">-- Pilih Bidang Usaha --</option>
                            @foreach ($bidangusaha as $item)
                            <option value="{{$item->bidangusahaid}}" data-kode="{{$item->kode}}" @if (old("bidangusahaid", $perusahaan->bidangusahaid)==$item->bidangusahaid) selected @endif>{{ $item->bidangusaha }}</option>
                            @endforeach
                        </select>

                        @error('bidangusahaid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kbli" class="col-md-12 col-form-label text-md-left">{{ __('KBLI *') }}</label>

                    <div class="col-md-12">
                        <input id="kbli" type="text" class="form-control @error('kbli') is-invalid @enderror" name="kbli" value="{{ old('kbli', $perusahaan->kbli) }}" required autocomplete="name">

                        @error('kbli')
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
                        <a href="{{ route('perusahaan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Perusahaan') }}
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
    var kotaid = '{{ old("kotaid", $perusahaan->kotaid) }}';
    var kecamatanid = '{{ old("kecamatanid", $perusahaan->kecamatanid) }}';
    var kelurahanid = '{{ old("kelurahanid", $perusahaan->kelurahanid) }}';

    $(document).ready(function() {
        $('.custom-select').select2();

        $('#kawasanid').select2().on('change', function() {
            var kawasanprovid = $(this).find(":selected").data("provid");
            var kawasankotaid = $(this).find(":selected").data("kotaid");
            var kawasankecamatanid = $(this).find(":selected").data("kecamatanid");
            var kawasankelurahanid = $(this).find(":selected").data("kelurahanid");

            kotaid = kawasankotaid;
            kecamatanid = kawasankecamatanid;
            kelurahanid = kawasankelurahanid;

            $('#provinsiid').select2();
            $('#provinsiid').val(kawasanprovid);
            $('#provinsiid').trigger('change');
        });
        
        $('#provinsiid').select2().on('change', function() {
            var url = "{{ route('perusahaan.kota', ':parentid') }}";
            url = url.replace(':parentid', ($('#provinsiid').val() == "" || $('#provinsiid').val() == null ? "-1" : $('#provinsiid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#kotaid').empty();
                    $('#kotaid').append($("<option></option>").attr("value", "").text("-- Pilih Kota --"));
                    $.each(data.data, function(key, value) {
                        $('#kotaid').append($("<option></option>").attr("value", value.kotaid).text(value.kodekota + ' ' + value.namakota));
                    });
                    $('#kotaid').select2();
                    $('#kotaid').val(kotaid);
                    $('#kotaid').trigger('change');
                }
            });
        }).trigger('change');

        $('#kotaid').select2().on('change', function() {
            var url = "{{ route('perusahaan.kecamatan', ':parentid') }}";
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
        }).trigger('change');

        $('#kecamatanid').select2().on('change', function() {
            var url = "{{ route('perusahaan.kelurahan', ':parentid') }}";
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
        }).trigger('change');

        $('#bidangusahaid').select2().on('change', function() {
            var kode = $(this).find(":selected").data("kode");
            
            $('#kbli').val(kode);
        });

        //TO BE DISABLED NEXT
        // $('#provinsiid').prop('disabled', true);

        $('#formPerusahaan').on('submit', function() {
            $('#provinsiid').prop('disabled', false);
        });
    });
</script>
@endsection
