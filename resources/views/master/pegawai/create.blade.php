<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5>
        <hr />
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

        <form method="POST" action="{{ route('pegawai.store') }}"
            class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                @if($sekolah == null)
                <input type="hidden" name="sekolahid" id="sekolahid">
                @else
                <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$sekolah->sekolahid) }}">
                @endif
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="nip">NIP*</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
                            value="{{ old('nip') }}" autofocus required>
                        @error('nip')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="nama">Nama Pegawai*</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}" autofocus required>
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="jabatan">Jabatan*</label>
                        <select id="jabatan" class="col-md-12 custom-select form-control" name="jabatan" autofocus
                            required>
                            @if($sekolah == null)
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach (enum::listJabatanOPD() as $id)
                            <option value="{{ $id }}"> {{ enum::listJabatanOPD('desc')[$loop->index] }}</option>
                            @endforeach
                            @else
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach (enum::listJabatanSekolah() as $id)
                            <option value="{{ $id }}"> {{ enum::listJabatanSekolah('desc')[$loop->index] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="npwp">NPWP*</label>
                        <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"
                            name="npwp" value="{{ old('npwp') }}" autofocus required>
                        @error('npwp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="ketjabatan">Keterangan Jabatan</label>
                        <input type="text" class="form-control @error('ketjabatan') is-invalid @enderror"
                            id="ketjabatan" name="ketjabatan" value="{{ old('ketjabatan') }}" autofocus>
                        @error('ketjabatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="judulsk">Judul SK</label>
                        <input type="text" class="form-control @error('judulsk') is-invalid @enderror" id="judulsk"
                            name="judulsk" value="{{ old('judulsk') }}" autofocus>
                        @error('judulsk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="nosk">Nomor SK</label>
                        <input type="text" class="form-control @error('nosk') is-invalid @enderror" id="nosk"
                            name="nosk" value="{{ old('nosk') }}" autofocus>
                        @error('nosk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="tgl_sk">Tgl SK</label>
                        <input type="date" class="form-control @error('tgl_sk') is-invalid @enderror" id="tgl_sk"
                            name="tgl_sk" value="{{ old('tgl_sk') }}" autofocus>
                        @error('tgl_sk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="form-control-label text-right mr-2 mt-3" for="status">Status</label>
                        <input type="checkbox" id="status" name="status" value="1">
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group row mb-0">
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                        {{ __('Simpan') }}
                    </button>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                        {{ __('Index Pegawai') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>

<script>
    //     document.addEventListener('DOMContentLoaded', function () {
    //         const ttdInput = document.getElementById('file_ttd');

    //         ttdInput.addEventListener('change', function () {
    //             const file = ttdInput.files[0];

    //             if (file) {
    //                 if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/jpg') {
    //                     alert('Masukkan file jpg/png/jpeg yang valid.');
    //                     ttdInput.value = ''; 
    //                 }
    //             }
    //         });
    //     });
    // 

</script>
@endsection
