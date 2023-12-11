<?php
use App\enumVar as enum;
use App\Helpers\Get_field;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA PENGAJUAN LEGALISIR IJAZAH</h5>
        <hr />
        <div class="col-md-12">
            <form action="{{ route('legalisir.setuju', $results->legalisirid) }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-group mt-3">
                <table class="table mt-3">
                    <tbody>
                        <tr>
                            <td width="25%">Tanggal Permintaan Verifikasi</td>
                            <td width="2%">:</td>
                            <td>{{ Get_field::tgl_indo($results->tgl_pengajuan) }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><span class="badge bg-info">{{ enum::statusLegalisir($results->status) }}<span></td>
                        </tr>
                        <tr>
                            <td>Penandatanganan*</td>
                            <td>:</td>
                            <td> <select id="pegawaiid" class="custom-select form-control @error('pegawaiid') is-invalid @enderror" name='pegawaiid' required autofocus>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach ($pegawai as $item)
                                    <option value="{{ $item->pegawaiid }}">
                                        {{ $item->nama .' - '. (isset($item->jabatan) ? enum::getDescJabatanOPD($item->jabatan) : 'No Jabatan') }}
                                    </option>
                                @endforeach
                            </select>
    
                            @error('pegawaiid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror</td>
                        </tr>
                        <tr>
                            <td>File Upload</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Ijazah</td>
                            <td></td>
                            <td><iframe src="{{ asset('storage/' . $results->file_ijazah) }}" width="60%"
                                    height="500"></iframe></td>
                        </tr>
                        <tr>
                            <td>Ktp</td>
                            <td></td>
                            <td><iframe src="{{ asset('storage/' . $results->file_ktp) }}" width="60%"
                                    height="500"></iframe></td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div class="col-md-12 mt-5">
                    <div class="form-group row mb-0 pull-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
                            {{ __('Setujui') }}
                        </button>
                        <a href="{{ route('legalisir.index') }}" class="btn btn-danger waves-effect waves-light m-r-10">
                            {{ __('Batal') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {});

</script>
@endsection
