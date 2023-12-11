<?php
use App\enumVar as enum;
use Carbon\Carbon;
$errorsPerusahaan = [];
$errorsPerusahaanKbli = [];
$errorsUpah = [];
//Memisahkan error array
if (count($errors) > 0)
    foreach ($errors->messages() as $key => $value) {
        $keyArr = explode(".",$key);
        if($keyArr[0]==="perusahaankbli" && isset($keyArr[1])){
            $indexPerusahaanKbli = $keyArr[1];
            $urutanPerusahaanKbli = array_search($indexPerusahaanKbli, array_column(old('perusahaankbli'), 'indexperusahaankbli'));
            foreach ($value as $errField) {
                $errorsPerusahaanKbli[$urutanPerusahaanKbli][] = $errField;
            }
        }else if($keyArr[0]==="upah" && isset($keyArr[1])){
            $indexUpah = $keyArr[1];
            $urutanUpah = array_search($indexUpah, array_column(old('upah'), 'indexupah'));
            foreach ($value as $errField) {
                $errorsUpah[$urutanUpah][] = $errField;
            }
        }else{
            foreach ($value as $errField) {
                $errorsPerusahaan[] = $errField;
            }
        }
    }
?>
@extends('layouts.master')

@section('content')
<div id="modalFormPerusahaanKbli" class="modal fade" role="dialog" aria-labelledby="titlePerusahaanKbli" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titlePerusahaanKbli">Tambah KBLI</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="perusahaanKbliForm">
                <input type="hidden" name="modalkbliidx" id="modalkbliidx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalkblibidangusahaid" class="col-md-3 col-form-label text-md-left">{{ __('Bidang Usaha *') }}</label>

                            <div class="col-md-9">
                                <select id="modalkblibidangusahaid" class="custom-select-kbli form-control" name='modalkblibidangusahaid' required>
                                    <option value="" data-kode="">-- Pilih Bidang Usaha --</option>
                                    @foreach ($bidangusaha as $item)
                                    <option value="{{$item->bidangusahaid}}" data-kode="{{$item->kode}}">{{ $item->bidangusaha }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalkblikbli" class="col-md-3 col-form-label text-md-left">{{ __('KBLI *') }}</label>

                            <div class="col-md-9">
                                <input id="modalkblikbli" type="text" class="form-control" name="modalkblikbli" required >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" onclick="validateKbli();"">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="modalFormUpah" class="modal fade" role="dialog" aria-labelledby="titleUpah" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleUpah">Tambah KBLI</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <form id="upahForm">
                <input type="hidden" name="modalupahidx" id="modalupahidx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalupahlevel" class="col-md-3 col-form-label text-md-left">{{ __('Level *') }}</label>
                            <div class="col-md-9">
                                <select id="modalupahlevel" class="custom-select-upah form-control" name='modalupahlevel' required @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Level --</option>
                                    @foreach ($listlevelpekerjaan as $item)
                                    <option value="{{$item['levelpekerjaan']}}">{{ $item['levelpekerjaanvw'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalupahgolid" class="col-md-3 col-form-label text-md-left">{{ __('Golongan Pekerjaan') }}</label>

                            <div class="col-md-9">
                                <select id="modalupahgolid" class="custom-select-upah form-control" name='modalupahgolid' @if($isshow) disabled @endif>
                                    <option value="" data-kode="">-- Pilih Golongan Pekerjaan --</option>
                                    @foreach ($gol as $item)
                                    <option value="{{$item->golid}}">{{ $item->golpokoknama . ' - ' . $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalupahket" class="col-md-3 col-form-label text-md-left">{{ __('Ket. Pekerjaan') }}</label>

                            <div class="col-md-9">
                                <input id="modalupahket" type="text" class="form-control" name="modalupahket" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalupahupahmin" class="col-md-3 col-form-label text-md-left">{{ __('Upah Minimum (Rp)') }}</label>

                            <div class="col-md-9">
                                <input id="modalupahupahmin" type="number" class="form-control" name="modalupahupahmin" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" onclick="tutupFormUpah();"">Tutup</button>
                    <button type="button" class="btn btn-info waves-effect" onclick="validateUpah();"">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($perusahaan->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
            @if($isshow)
            <div class="form-group row mb-0 text-md-right">
                <div class="col-md-12">
                    <a href="{{ route('perusahaan.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                    <a href="{{ route('perusahaan.edit', $perusahaan->perusahaanid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
                </div>
            </div>
            @endif

            @if (count($errors) > 0)
            @foreach ($errorsPerusahaan as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </p>
            @endforeach
            @endif

            @foreach ($errorsPerusahaanKbli as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail KBLI baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
                    <ul>
                        @foreach ($error as $errorMsg)
                        <li><span>{{ $errorMsg }}</span></li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach

            @foreach ($errorsUpah as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail Upah baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
                    <ul>
                        @foreach ($error as $errorMsg)
                        <li><span>{{ $errorMsg }}</span></li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach

            @if (session()->has('message'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <ul class="nav nav-tabs" id="perusahaanTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="perusahaandataumum-tab" data-toggle="tab" href="#perusahaandataumum" role="tab" aria-controls="perusahaandataumum" aria-selected="true"><b>Data Umum</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="perusahaanwaktukerja-tab" data-toggle="tab" href="#perusahaanwaktukerja" role="tab" aria-controls="perusahaanwaktukerja" aria-selected="false"><b>Waktu Kerja</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="perusahaanfasilitas-tab" data-toggle="tab" href="#perusahaanfasilitas" role="tab" aria-controls="perusahaanfasilitas" aria-selected="false"><b>Fasilitas</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="perusahaanupah-tab" data-toggle="tab" href="#perusahaanupah" role="tab" aria-controls="perusahaanupah" aria-selected="false"><b>Upah</b>
                    </a>
                </li>
            </ul>

            <form method="POST" action="{{ $perusahaan->exists ? route('perusahaan.update', $perusahaan->perusahaanid) : route('perusahaan.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" id="formPerusahaan" onsubmit="return validate();">
                @csrf
                @if($perusahaan->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="perusahaanid" id="perusahaanid" value="{{ $perusahaan->exists ? $perusahaan->perusahaanid : '' }}">

                <div class="tab-content" id="perusahaanTabContent">
                    <div class="tab-pane fade show active" id="perusahaandataumum" role="tabpanel" aria-labelledby="perusahaandataumum-tab">
                        <div class="form-group row">
                            <label for="kodedaftar" class="col-md-12 col-form-label text-md-left">{{ __('Kode Daftar Perusahaan *') }}</label>

                            <div class="col-md-12">
                                <input id="kodedaftar" type="text" class="form-control @error('kodedaftar') is-invalid @enderror" name="kodedaftar" value="{{ old('kodedaftar', $perusahaan->kodedaftar) }}" required autocomplete="name" @if($isshow) disabled @endif>

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
                                <select id="badanusaha" class="custom-select form-control @error('badanusaha') is-invalid @enderror" name='badanusaha' required autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Badan Usaha --</option>
                                    @foreach ($listbadanusaha as $item)
                                    <option @if (old("badanusaha", $perusahaan->badanusaha)===$item['badanusaha']) selected @endif value="{{$item['badanusaha']}}">{{ $item['badanusahavw'] }}</option>
                                    @endforeach
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
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $perusahaan->nama) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="namapemilik" class="col-md-12 col-form-label text-md-left">{{ __('Nama Pemilik *') }}</label>

                            <div class="col-md-12">
                                <input id="namapemilik" type="text" class="form-control @error('namapemilik') is-invalid @enderror" name="namapemilik" value="{{ old('namapemilik', $perusahaan->namapemilik) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('namapemilik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="namapenanggungjawab" class="col-md-12 col-form-label text-md-left">{{ __('Nama Penanggung jawab *') }}</label>

                            <div class="col-md-12">
                                <input id="namapenanggungjawab" type="text" class="form-control @error('namapenanggungjawab') is-invalid @enderror" name="namapenanggungjawab" value="{{ old('namapenanggungjawab', $perusahaan->namapenanggungjawab) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('namapenanggungjawab')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="statuspermodalan" class="col-md-12 col-form-label text-md-left">{{ __('Status Permodalan') }}</label>

                            <div class="col-md-12">
                                <select id="statuspermodalan" class="custom-select form-control @error('statuspermodalan') is-invalid @enderror" name='statuspermodalan' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Status Permodalan--</option>
                                    @foreach ($liststatuspermodalan as $item)
                                    <option value="{{$item['statuspermodalan']}}" @if (old("statuspermodalan", $perusahaan->statuspermodalan)===$item['statuspermodalan']) selected @endif>{{ $item['statuspermodalanvw'] }}</option>
                                    @endforeach
                                </select>

                                @error('statuspermodalan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="noaktapendirian" class="col-md-12 col-form-label text-md-left"><b>{{ __('Akta Pendirian') }}</b></label>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="noaktapendirian" class="col-md-12 col-form-label text-md-left">{{ __('No. Akta') }}</label>

                                    <div class="col-md-12">
                                        <input id="noaktapendirian" type="text" class="form-control @error('noaktapendirian') is-invalid @enderror" name="noaktapendirian" value="{{ old('noaktapendirian', $perusahaan->noaktapendirian) }}" autocomplete="name" @if($isshow) disabled @endif>

                                        @error('noaktapendirian')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tglaktapendirian" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal Akta') }}</label>
                                    <div class="col-md-12">
                                        <input class="form-control dp-text" type="date" type="text" name="tglaktapendirian" id="tglaktapendirian" value="{{ old('tglaktapendirian', $perusahaan->tglaktapendirian) }}" @if($isshow) disabled @endif/>

                                         @error('tglaktapendirian')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="noperubahanaktapendirian" class="col-md-12 col-form-label text-md-left"><b>{{ __('Perubahan Akta Pendirian') }}</b></label>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="noperubahanaktapendirian" class="col-md-12 col-form-label text-md-left">{{ __('No. Akta') }}</label>

                                    <div class="col-md-12">
                                        <input id="noperubahanaktapendirian" type="text" class="form-control @error('noperubahanaktapendirian') is-invalid @enderror" name="noperubahanaktapendirian" value="{{ old('noperubahanaktapendirian', $perusahaan->noperubahanaktapendirian) }}" autocomplete="name" @if($isshow) disabled @endif>

                                        @error('noperubahanaktapendirian')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tglperubahanaktapendirian" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal Akta') }}</label>
                                    <div class="col-md-12">
                                        <input class="form-control dp-text" type="date" type="text" name="tglperubahanaktapendirian" id="tglperubahanaktapendirian" value="{{ old('tglperubahanaktapendirian', $perusahaan->tglperubahanaktapendirian) }}" @if($isshow) disabled @endif/>

                                         @error('tglperubahanaktapendirian')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status *') }}</label>

                            <div class="col-md-12">
                                <select id="status" class="custom-select form-control @error('status') is-invalid @enderror" name='status' required autofocus @if($isshow) disabled @endif>
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
                                <select id="kawasanid" class="custom-select form-control @error('kawasanid') is-invalid @enderror" name='kawasanid' autofocus @if($isshow) disabled @endif>
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
                                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name" @if($isshow) disabled @endif>{{ old('alamat', $perusahaan->alamat) }}</textarea>

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
                                <select id="provinsiid" class="custom-select form-control @error('provinsiid') is-invalid @enderror" name='provinsiid' required autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($prov as $item)
                                    <option value="{{$item->provid}}" @if (old('provinsiid', $perusahaan->provinsiid, (!is_null($instansi) ? $instansi->provinsi : '')) == $item->provid) selected @endif>{{ $item->kodeprov . ' ' . $item->namaprov }}</option>
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
                                <select id="kotaid" class="custom-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Kota --</option>
                                    @foreach ($kota as $item)
                                    <option value="{{$item->kotaid}}"  @if (old('kotaid', $perusahaan->kotaid, (!is_null($instansi) ? $instansi->kota : '')) == $item->kotaid) selected @endif>{{ $item->kodekota . ' ' . $item->namakota }}</option>
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
                                <select id="kecamatanid" class="custom-select form-control @error('kecamatanid') is-invalid @enderror" name='kecamatanid' required autofocus @if($isshow) disabled @endif>
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
                                <select id="kelurahanid" class="custom-select form-control @error('kelurahanid') is-invalid @enderror" name='kelurahanid' required autofocus @if($isshow) disabled @endif>
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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $perusahaan->email) }}" autocomplete="name" @if($isshow) disabled @endif>

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
                                <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $perusahaan->website) }}" autocomplete="name" @if($isshow) disabled @endif>

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
                                <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp', $perusahaan->telp) }}" required autocomplete="name" @if($isshow) disabled @endif>

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
                                <input id="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ old('npwp', $perusahaan->npwp) }}" required autocomplete="name" @if($isshow) disabled @endif>

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
                                <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" name="nib" value="{{ old('nib', $perusahaan->nib) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('nib')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <h4 class="text-info">KBLI</h4>
                                </div>
                                <div class="col-md-6">
                                    @if(!$isshow)
                                    <button onclick="javascript:addKbli();" type="button" id="btnaddkbli" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="kbli-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th style="width: 220px">Bidang Usaha</th>
                                            <th style="width: 65px">KBLI</th>
                                            <th style="width: 15px">Operator</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <div class="form-group row mb-0">
                            <div class="col-md-12">
                                @if(!$isshow)
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                    {{ __('Simpan') }}
                                </button>
                                @endif
                                <a href="{{ route('perusahaan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                                    {{ __('Index Perusahaan') }}
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </div> -->
                    </div>
                    <div class="tab-pane fade" id="perusahaanwaktukerja" role="tabpanel" aria-labelledby="perusahaanwaktukerja-tab">
                        <input type='hidden' value='0' name="perusahaanwaktukerja[0]">
                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4 class="text-info">Waktu Kerja Normal</h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @foreach ($waktukerjanormal as $col)
                                    <div class="col">
                                        @foreach ($col as $item)
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="form-control custom-control-input" id="perusahaanwaktukerja{{$item->waktukerjaid}}" name="perusahaanwaktukerja[{{$item->waktukerjaid}}]" value="1"  
                                            @if (
                                                array_key_exists(
                                                    $item->waktukerjaid,
                                                    old(
                                                        'perusahaanwaktukerja',
                                                        array_fill_keys($perusahaan->perusahaanwaktukerja->pluck('waktukerjaid')->all(),"1")
                                                    )
                                                )
                                            ) 
                                                checked
                                            @endif 
                                            @if($isshow) onclick="return false;" @endif>
                                            <label class="custom-control-label" for="perusahaanwaktukerja{{$item->waktukerjaid}}">{{ $item->deskripsi }}</label>
                                        </div>
                                        @endforeach        
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4 class="text-info">Sektor Pertambangan</h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @foreach ($waktukerjatambang as $col)
                                    <div class="col">
                                        @foreach ($col as $item)
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="form-control custom-control-input" id="perusahaanwaktukerja{{$item->waktukerjaid}}" name="perusahaanwaktukerja[{{$item->waktukerjaid}}]" value="1" 
                                            @if (
                                                array_key_exists(
                                                    $item->waktukerjaid,
                                                    old(
                                                        'perusahaanwaktukerja',
                                                        array_fill_keys($perusahaan->perusahaanwaktukerja->pluck('waktukerjaid')->all(),"1")
                                                    )
                                                )
                                            ) 
                                                checked
                                            @endif
                                            @if($isshow) onclick="return false;" @endif>
                                            <label class="custom-control-label" for="perusahaanwaktukerja{{$item->waktukerjaid}}">{{ $item->deskripsi }}</label>
                                        </div>
                                        @endforeach        
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4 class="text-info">Sektor ESDM</h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @foreach ($waktukerjaesdm as $col)
                                    <div class="col">
                                        @foreach ($col as $item)
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="form-control custom-control-input" id="perusahaanwaktukerja{{$item->waktukerjaid}}" name="perusahaanwaktukerja[{{$item->waktukerjaid}}]" value="1" 
                                            @if (
                                                array_key_exists(
                                                    $item->waktukerjaid,
                                                    old(
                                                        'perusahaanwaktukerja',
                                                        array_fill_keys($perusahaan->perusahaanwaktukerja->pluck('waktukerjaid')->all(),"1")
                                                    )
                                                )
                                            ) 
                                                checked
                                            @endif
                                            @if($isshow) onclick="return false;" @endif>
                                            <label class="custom-control-label" for="perusahaanwaktukerja{{$item->waktukerjaid}}">{{ $item->deskripsi }}</label>
                                        </div>
                                        @endforeach        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="perusahaanfasilitas" role="tabpanel" aria-labelledby="perusahaanfasilitas-tab">
                        <input type='hidden' value='0' name="perusahaanfasilitas[0]">
                        <input type='hidden' value='0' name="perusahaansubfasilitas[0]">
                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4 class="text-info">Fasilitas Perusahaan</h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                @foreach ($fasilitas as $col)
                                    <div class="col">
                                        @foreach ($col as $item)
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="form-control custom-control-input chk-perusahaanfasilitas" id="perusahaanfasilitas{{$item->fasilitasid}}" name="perusahaanfasilitas[{{$item->fasilitasid}}]" value="1" 
                                            @if (
                                                array_key_exists(
                                                    $item->fasilitasid,
                                                    old(
                                                        'perusahaanfasilitas',
                                                        array_fill_keys($perusahaan->perusahaanfasilitas->pluck('fasilitasid')->all(),"1")
                                                    )
                                                )
                                            ) 
                                                checked
                                            @endif
                                            @if($isshow) onclick="return false;" @endif>
                                            <label class="custom-control-label" for="perusahaanfasilitas{{$item->fasilitasid}}">{{ $item->deskripsi }}</label>
                                            @foreach ($item->subfasilitas as $subitem)
                                            <div class="custom-control custom-switch mt-2" dir="ltr">
                                                <input type="checkbox" class="form-control custom-control-input subperusahaanfasilitas{{$item->fasilitasid}}" id="perusahaansubfasilitas{{$subitem->subfasilitasid}}" name="perusahaansubfasilitas[{{$subitem->subfasilitasid}}]" value="1" 
                                                @if (
                                                    array_key_exists(
                                                        $subitem->subfasilitasid,
                                                        old(
                                                            'perusahaansubfasilitas',
                                                            array_fill_keys($perusahaan->perusahaansubfasilitas->pluck('subfasilitasid')->all(),"1")
                                                        )
                                                    )
                                                ) 
                                                    checked
                                                @endif
                                                @if (
                                                    !array_key_exists(
                                                        $item->fasilitasid,
                                                        old(
                                                            'perusahaanfasilitas',
                                                            array_fill_keys($perusahaan->perusahaanfasilitas->pluck('fasilitasid')->all(),"1")
                                                        )
                                                    )
                                                ) 
                                                    disabled
                                                @endif
                                                @if($isshow) onclick="return false;" @endif>
                                                <label class="custom-control-label" for="perusahaansubfasilitas{{$subitem->subfasilitasid}}">{{ $subitem->deskripsi }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="perusahaanupah" role="tabpanel" aria-labelledby="perusahaanupah-tab">
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="filterupahlevel" class="col-md-3 col-form-label text-md-left">{{ __('Level') }}</label>
                                        <div class="col-md-9">
                                            <select id="filterupahlevel" class="custom-select form-control" name='filterupahlevel'>
                                                <option value="">-- Pilih Level --</option>
                                                @foreach ($listlevelpekerjaan as $item)
                                                <option value="{{$item['levelpekerjaan']}}">{{ $item['levelpekerjaanvw'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if(!$isshow)
                                    <button onclick="javascript:addUpah();" type="button" id="btnaddupah" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="upah-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">Level</th>
                                            <th style="width: 100px">Golongan Pekerjaan</th>
                                            <th style="width: 100px">Ket. Pekerjaan</th>
                                            <th style="width: 100px">Upah Minimum</th>
                                            <th style="width: 15px">Operator</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                @if(!$isshow)
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                    {{ __('Simpan') }}
                                </button>
                                @endif
                                <a href="{{ route('perusahaan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                                    {{ __('Index Perusahaan') }}
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var kotaid = '{{ old("kotaid", $perusahaan->kotaid, (!is_null($instansi) ? $instansi->kota : "")) }}';
    var kecamatanid = '{{ old("kecamatanid", $perusahaan->kecamatanid) }}';
    var kelurahanid = '{{ old("kelurahanid", $perusahaan->kelurahanid) }}';

    @php $listperusahaankbli = old('perusahaankbli', $perusahaan->perusahaankbli); @endphp

    var v_listDataKbli = [
        @foreach($listperusahaankbli as $dataKbli)
        { 
            "indexperusahaankbli" : "{{$loop->index}}",
            "perusahaankbliid": "{{(isset($dataKbli['perusahaankbliid']) ? $dataKbli['perusahaankbliid'] : "")}}",
            "bidangusahaid": "{{$dataKbli['bidangusahaid']}}", 
            "kbli": "{{$dataKbli['kbli']}}",
            "bidangusahanama": "{{old('perusahaankbli','')==='' ? ($dataKbli['bidangusaha'] ? ($dataKbli['bidangusaha']['bidangparent'] ? $dataKbli['bidangusaha']['bidangparent']['kode'] : '').$dataKbli['bidangusaha']['kode'].' '.$dataKbli['bidangusaha']['bidangusaha'] : '') : $dataKbli['bidangusahanama']}}", 
        },
        @endforeach
    ];

    @php $listupah = old('upah', $perusahaan->upah); @endphp

    var v_listDataUpah = [
        @foreach($listupah as $dataUpah)
        { 
            "indexupah" : "{{$loop->index}}",
            "upahid": "{{(isset($dataUpah['upahid']) ? $dataUpah['upahid'] : "")}}",
            "level": "{{$dataUpah['level']}}",
            "golid": "{{$dataUpah['golid']}}", 
            "ket": "{{$dataUpah['ket']}}",
            "upahmin": "{{$dataUpah['upahmin']}}",            
            "golnama": "{{old('upah','')==='' ? ($dataUpah['gol'] ? ($dataUpah['gol']['subgolpokok'] ? ($dataUpah['gol']['subgolpokok']['golpokok'] ? $dataUpah['gol']['subgolpokok']['golpokok']['nama'].' - ' : '') : '').$dataUpah['gol']['nama'] : '' ) : $dataUpah['golnama']}}", 
            "levelnama": "{{$dataUpah['levelnama']}}", 
        },
        @endforeach
    ];

    var $validatorKbli = $("#perusahaanKbliForm").validate({
        errorClass: 'invalid-feedback',
        messages : {
            modalkblibidangusahaid: {
                required: "Bidang Usaha harus dipilih"
            },
            modalkblikbli: {
                required: "KBLI harus diisi"
            }
        }
    });

    var $validator = $("#formPerusahaan").validate({
        ignore: [],
        errorClass: 'invalid-feedback',
        messages : {
            kodedaftar: {
                required: "Kode Daftar Perusahaan harus diisi"
            },
            badanusaha: {
                required: "Badan Usaha harus dipilih"
            },
            nama: {
                required: "Nama Perusahaan harus diisi"  
            },
            namapemilik: {
                required: "Nama Pemilik harus diisi"
            },
            namapenanggungjawab: {
                required: "Nama Penanggung jawab harus diisi"
            },
            status: {
                required: "Status harus dipilih"
            },
            alamat: {
                required: "Alamat harus diisi"
            },
            provinsiid: {
                required: "Provinsi harus dipilih"
            },
            kotaid: {
                required: "Kota harus dipilih"
            },
            kecamatanid: {
                required: "Kecamatan harus dipilih"
            },
            kelurahanid: {
                required: "Kelurahan  harus dipilih"
            },
            telp: {
                required: "Telp harus diisi"
            },
            npwp: {
                required: "NPWP harus diisi"
            },
            nib: {
                required: "NIB harus diisi"
            },
        }
    });

    var $validatorUpah = $("#upahForm").validate({
        errorClass: 'invalid-feedback',
        rules: {
            modalupahket: {
                required: function(element){
                    return $('#modalupahgolid').val()==="";
                }
            },
            modalupahupahmin: {
                digits: true
            }
        },
        messages : {
            modalupahlevel: {
                required: "Level harus dipilih"
            },
            modalupahket: {
                required: "Ket. Pekerjaan harus diisi"
            },
            modalupahupahmin: {
                digits: "Upah Minimum tidak boleh berkoma"
            },
        }
    });

    var row_number_kbli = {{ 
        (
            null!==(old('perusahaankbli')) && count(old('perusahaankbli')) > 0 ?  (count(old('perusahaankbli'))+1) 
                : (count($perusahaan->perusahaankbli) > 0 ? (count($perusahaan->perusahaankbli)+1) : 1)
        ) 
    }} ;

    var row_number_upah = {{ 
        (
            null!==(old('upah')) && count(old('upah')) > 0 ?  (count(old('upah'))+1) 
                : (count($perusahaan->upah) > 0 ? (count($perusahaan->upah)+1) : 1)
        ) 
    }} ;

    var upahtable = null;

    $(document).ready(function() {
        upahtable = $('#upah-table').DataTable( {
            paging: true,
            "ordering": false
        });

        loadDataKbli();
        loadDataUpah();

        $('.custom-select').select2();

        $('.custom-select-kbli').select2({
            dropdownParent: $("#modalFormPerusahaanKbli .modal-content")
        });

        $('.custom-select-upah').select2({
            dropdownParent: $("#modalFormUpah .modal-content")
        });

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

        $('#modalkblibidangusahaid').select2().on('change', function() {
            var kode = $(this).find(":selected").data("kode");
            
            $('#modalkblikbli').val(kode);
        });

        $('#filterupahlevel').select2().on('change', function() {
            loadDataUpah();
        });
        
        //TO BE DISABLED NEXT
        // $('#provinsiid').prop('disabled', true);

        $('#formPerusahaan').on('submit', function() {
            $('#provinsiid').prop('disabled', false);
        });
    });
    
    function addKbli(){
        resetFormKbli();
        $('#titlePerusahaanKbli').text('Tambah KBLI');
        $('#modalFormPerusahaanKbli').modal('show');
    }

    function addUpah(){
        resetFormUpah();
        $('#titleUpah').text('Tambah Upah');
        $('#modalFormUpah').modal('show');
    }

    function validateKbli(){
        var isValid = true;

        if ($('#perusahaanKbliForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data KBLI belum tepat", "error"); 
            return;
        }else{
            saveKbliArray();
            $('#modalFormPerusahaanKbli').modal('hide');
            return;
        }
    }

    function validateUpah(){
        var isValid = true;

        if ($('#upahForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data Upah belum tepat", "error"); 
            return;
        }else{
            saveUpahArray();
            $('#modalFormUpah').modal('hide');
            return;
        }
    }

    function saveKbliArray(){
        let new_row_number = row_number_kbli - 1;

        let modalkblibidangusahaid = $('#modalkblibidangusahaid').val();
        let modalkblikbli = $('#modalkblikbli').val();

        let bidangusahanama = $("#modalkblibidangusahaid").find(":selected").text();

        if($('#modalkbliidx').val()==""){
            var v_newData = {   
                "indexperusahaankbli": new_row_number,
                "bidangusahaid": modalkblibidangusahaid, 
                "kbli": modalkblikbli,
                "bidangusahanama": bidangusahanama, 
            };
            v_listDataKbli.push(v_newData);

            row_number_kbli++;
        }else{
            let modalkbliidx = $('#modalkbliidx').val();

            $.each( v_listDataKbli, function( p_key, p_value ) {
                if (p_value.indexperusahaankbli ==  modalkbliidx) {
                    p_value.bidangusahaid = modalkblibidangusahaid;
                    p_value.kbli = modalkblikbli;
                    p_value.bidangusahanama = bidangusahanama;
                    
                    return false;
                }   
            });
        }

        loadDataKbli();
    }

    function saveUpahArray(){
        let new_row_number = row_number_upah - 1;

        let modalupahlevel = $('#modalupahlevel').val();
        let modalupahgolid = $('#modalupahgolid').val();
        let modalupahket = $('#modalupahket').val();
        let modalupahupahmin = $('#modalupahupahmin').val();

        let golnama = $("#modalupahgolid").val()==="" ? "" : $("#modalupahgolid").find(":selected").text();
        let levelnama = $("#modalupahlevel").find(":selected").text();

        if($('#modalupahidx').val()==""){
            var v_newData = {   
                "indexupah": new_row_number,
                "level": modalupahlevel,
                "golid": modalupahgolid, 
                "ket": modalupahket,
                "upahmin": modalupahupahmin,
                "golnama": golnama, 
                "levelnama": levelnama, 
            };
            v_listDataUpah.push(v_newData);

            row_number_upah++;
        }else{
            let modalupahidx = $('#modalupahidx').val();

            $.each( v_listDataUpah, function( p_key, p_value ) {
                if (p_value.indexupah ==  modalupahidx) {                    
                    p_value.level = modalupahlevel;
                    p_value.golid = modalupahgolid;
                    p_value.ket = modalupahket;
                    p_value.upahmin = modalupahupahmin;
                    p_value.golnama = golnama;
                    p_value.levelnama = levelnama;
                    return false;
                }   
            });
        }

        loadDataUpah();
    }

    function resetFormKbli(){
        $('#perusahaanKbliForm').trigger("reset");

        $('#modalkbliidx').val("");

        $('#modalkblibidangusahaid').trigger('change');

        $validatorKbli.resetForm();
    }

    function resetFormUpah(){
        $('#upahForm').trigger("reset");

        $('#modalupahidx').val("");

        $('#modalupahlevel').trigger('change');
        $('#modalupahgolid').trigger('change');

        $validatorUpah.resetForm();
    }

    function loadDataKbli() {
        $("#kbli-table").find("tr:gt(0)").remove();

        var v_filter = v_listDataKbli;
        var v_noUrut = 1;
        var table = document.getElementById("kbli-table");
        
        $.each( v_filter, function( p_key, p_value ) {
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = v_noUrut; 
            cell2.innerHTML = p_value.bidangusahanama;
            cell3.innerHTML = p_value.kbli;
            @if(!$isshow)
            cell4.innerHTML = '<button title="Edit data" type="button" onclick="editKbli(\''+p_value.indexperusahaankbli+'\')" class="btn btn-warning"><i class="fa fa-pencil"></i> </button><button title="Hapus data" type="button" onclick="deleteKbli(\''+p_value.indexperusahaankbli+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> </button>'; 
            @endif

            v_noUrut ++;
        });
    }

    function loadDataUpah() {
        let level = $("#filterupahlevel").val()!="" ? $("#filterupahlevel").val() : null;
        upahtable.clear().draw();

        var v_filter = v_listDataUpah;
        var v_noUrut = 1;
        
        $.each( v_filter, function( p_key, p_value ) {
            if(level!=null && level!=p_value.level) return;

            let btnHTML = "";
            @if(!$isshow)
            btnHTML = '<button title="Edit data" type="button" onclick="editUpah(\''+p_value.indexupah+'\')" class="btn btn-warning"><i class="fa fa-pencil"></i> </button><button title="Hapus data" type="button" onclick="deleteUpah(\''+p_value.indexupah+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> </button>'; 
            @endif

            upahtable.row.add([p_value.levelnama, p_value.golnama, p_value.ket, p_value.upahmin, btnHTML]).draw();

            v_noUrut ++;
        });
    }

    function deleteKbli(p_id) {
        swal({   
            title: "Apakah anda yakin akan menghapus KBLI ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            v_listDataKbli.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexperusahaankbli'].toString() === p_id.toString()) {
                v_listDataKbli.splice(p_index, 1);
                }    
            });
            
            loadDataKbli();
        });
    }

    function deleteUpah(p_id) {
        swal({   
            title: "Apakah anda yakin akan menghapus Upah ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            v_listDataUpah.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexupah'].toString() === p_id.toString()) {
                v_listDataUpah.splice(p_index, 1);
                }    
            });
            
            loadDataUpah();
        });
    }

    function editKbli(idx){
        var v_filter = v_listDataKbli.filter(function (p_element) {
            return p_element.indexperusahaankbli.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                $('#modalkbliidx').val(idx);

                $("#modalkblibidangusahaid").val(p_value.bidangusahaid).trigger('change.select2');
                $("#modalkblikbli").val(p_value.kbli);

            });
        }

        $('#titlePerusahaanKbli').text('Ubah KBLI');
        $('#modalFormPerusahaanKbli').modal('show');
    }

    function editUpah(idx){
        var v_filter = v_listDataUpah.filter(function (p_element) {
            return p_element.indexupah.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                $('#modalupahidx').val(idx);

                $("#modalupahlevel").val(p_value.level).trigger('change.select2');
                $("#modalupahgolid").val(p_value.golid).trigger('change.select2');
                $("#modalupahket").val(p_value.ket);
                $("#modalupahupahmin").val(p_value.upahmin);

            });
        }

        $('#titleUpah').text('Ubah Upah');
        $('#modalFormUpah').modal('show');
    }

    function validate(){
        if($('#formPerusahaan').valid()===false){
            swal("Validasi", "Pengisian data umum belum tepat, silahkan cek kembali", "error"); 
            $('#perusahaanTab a[href="#perusahaandataumum"]').tab('show');
            return false;
        }else{
            $('.perusahaankblifield').remove();
            $('.upahfield').remove();

            $.each(v_listDataKbli, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    $("<input />").attr("type", "hidden")
                        .attr("class", `perusahaankblifield`)
                        .attr("name", `perusahaankbli[${p_idx}][${obj_key}]`)
                        .attr("value", obj_val)
                        .appendTo("#formPerusahaan");
                });
            });

            $.each(v_listDataUpah, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    $("<input />").attr("type", "hidden")
                        .attr("class", `upahfield`)
                        .attr("name", `upah[${p_idx}][${obj_key}]`)
                        .attr("value", obj_val)
                        .appendTo("#formPerusahaan");
                });
            });

            return true;
        }
    }

    function tutupFormUpah(){
        swal({   
            title: "",   
            text: "Data Anda belum tersimpan? Yakin menutup form sebelum menyimpan data?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",
            closeOnConfirm: true 
        }, function(){
            $('#modalFormUpah').modal('hide');
        });
    }

    $('.chk-perusahaanfasilitas').change(function() {
        if(this.checked) {
            $(`.sub${this.id}`).prop('disabled', false);
        }else{
            $(`.sub${this.id}`).prop('disabled', true);
        }
    });

</script>
@endsection
