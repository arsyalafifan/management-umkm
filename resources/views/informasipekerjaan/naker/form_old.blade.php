<?php
use App\enumVar as enum;
use Carbon\Carbon;

$errorsNaker = [];
$errorsRiwayatKerja = [];
$errorsSertifikat = [];
$errorsRiwayatPendidikan = [];
//Memisahkan error array
if (count($errors) > 0)
    foreach ($errors->messages() as $key => $value) {
        $keyArr = explode(".",$key);
        if($keyArr[0]==="riwayatkerja"){
            $indexRiwayat = $keyArr[1];
            $urutanRiwayat = array_search($indexRiwayat, array_column(old('riwayatkerja'), 'indexriwayatkerja'));
            foreach ($value as $errField) {
                $errorsRiwayatKerja[$urutanRiwayat][] = $errField;
            }
        }else if($keyArr[0]==="sertifikat"){
            $indexSertifikat = $keyArr[1];
            $urutanSertifikat = array_search($indexSertifikat, array_column(old('sertifikat'), 'indexsertifikat'));
            foreach ($value as $errField) {
                $errorsSertifikat[$urutanSertifikat][] = $errField;
            }
        }else if($keyArr[0]==="riwayatpendidikan"){
            $indexRiwayatPendidikan = $keyArr[1];
            $urutanRiwayatPendidikan = array_search($indexRiwayatPendidikan, array_column(old('riwayatpendidikan'), 'indexriwayatpendidikan'));
            foreach ($value as $errField) {
                $errorsRiwayatPendidikan[$urutanRiwayatPendidikan][] = $errField;
            }
        }else{
            $errorsNaker[$key] = $value;
        }
    }
?>
@extends('layouts.master')

@section('content')
<style>
    input[disabled]{
      background-color:#ddd !important;
    }

    .badge {
        border-radius: 50%;
        width: 34px;
        height: 34px;
        padding: 6px;
        background: #719fd7;
        border: 3px solid #000;
        color: #000;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
    }

    .badge-active {
        background: #fff !important;
    }

</style>
<div id="modalFormRiwayatKerja" class="modal fade" role="dialog" aria-labelledby="titleRiwayatKerja" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleRiwayatKerja">Tambah Riwayat Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="riwayatKerjaForm">
                <input type="hidden" name="modalrwytidx" id="modalrwytidx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalrwytstatuspekerjaan" class="col-md-3 col-form-label text-md-left">{{ __('Status Pekerjaan') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytstatuspekerjaan" class="custom-select-riwayat form-control" name='modalrwytstatuspekerjaan' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Status Pekerjaan --</option>
                                    <option value="{{enum::STATUS_PEKERJAAN_FULL_TIME}}">{{ 'Karyawan (full time)' }}</option>
                                    <option value="{{enum::STATUS_PEKERJAAN_PART_TIME}}">{{ 'Karyawan paruh waktu (part time)' }}</option>
                                    <option value="{{enum::STATUS_PEKERJAAN_WIRAUSAHA}}">{{ 'Wirausaha' }}</option>
                                    <option value="{{enum::STATUS_PEKERJAAN_PEKERJA_LEPAS}}">{{ 'Pekerja Lepas' }}</option>
                                    <option value="{{enum::STATUS_PEKERJAAN_MAGANG}}">{{ 'Magang (intern)' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytperusahaanid" class="col-md-3 col-form-label text-md-left">{{ __('Perusahaan') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytperusahaanid" class="custom-select-riwayat form-control" name='modalrwytperusahaanid' autofocus @if($isshow) disabled @endif>
                                    <option value="" data-nama="" data-provid="" data-kotaid="" data-kecamatanid="" data-kelurahanid="">-- Pilih Perusahaan --</option>
                                    @foreach ($perusahaan as $item)
                                    <option value="{{$item->perusahaanid}}" data-nama="{{ $item->nama }}" data-provid="{{$item->provid}}" data-kotaid="{{$item->kotaid}}" data-kecamatanid="{{$item->kecamatanid}}" data-kelurahanid="{{$item->kelurahanid}}">{{ $item->kodedaftar . ' ' . $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytprovinsiid" class="col-md-3 col-form-label text-md-left">{{ __('Provinsi') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytprovinsiid" class="custom-select-riwayat form-control" name='modalrwytprovinsiid' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($prov as $item)
                                    <option value="{{$item->provid}}" @if (!is_null($instansi) && $instansi->provinsi == $item->provid) selected @endif>{{ $item->kodeprov . ' ' . $item->namaprov }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytkotaid" class="col-md-3 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytkotaid" class="custom-select-riwayat form-control" name='modalrwytkotaid' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                    @foreach ($kota as $item)
                                        <option value="{{$item->kotaid}}">{{ $item->kodekota . ' ' . $item->namakota }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytkecamatanid" class="col-md-3 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytkecamatanid" class="custom-select-riwayat form-control" name='modalrwytkecamatanid' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{$item->kecamatanid}}">{{ $item->kodekec . ' ' . $item->namakec }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytkelurahanid" class="col-md-3 col-form-label text-md-left">{{ __('Kelurahan') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytkelurahanid" class="custom-select-riwayat form-control" name='modalrwytkelurahanid' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Kelurahan --</option>
                                    @foreach ($kelurahan as $item)
                                        <option value="{{$item->kelurahanid}}">{{ $item->kodekel . ' ' . $item->namakel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytgolid" class="col-md-3 col-form-label text-md-left">{{ __('Golongan') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytgolid" class="custom-select-riwayat form-control" name='modalrwytgolid' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Golongan --</option>
                                    @foreach ($gol as $item)
                                    <option value="{{$item->golid}}">{{ $item->golpokoknama . ' - ' . $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytlevel" class="col-md-3 col-form-label text-md-left">{{ __('Level') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytlevel" class="custom-select-riwayat form-control" name='modalrwytlevel' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="{{enum::LEVEL_NON_STAFF}}">{{ 'Karyawan Non Staff' }}</option>
                                    <option value="{{enum::LEVEL_SENIOR_NON_STAFF}}">{{ 'Karyawan Senior Non Staff' }}</option>
                                    <option value="{{enum::LEVEL_STAFF}}">{{ 'Karyawan Staff' }}</option>
                                    <option value="{{enum::LEVEL_SENIOR_STAFF}}">{{ 'Karyawan Senior Staff' }}</option>
                                    <option value="{{enum::LEVEL_SUPERVISOR}}">{{ 'Supervisor' }}</option>
                                    <option value="{{enum::LEVEL_MANAGER}}">{{ 'Manager' }}</option>
                                    <option value="{{enum::LEVEL_GENERAL_MANAGER}}">{{ 'General Manager' }}</option>
                                    <option value="{{enum::LEVEL_DIRECTOR}}">{{ 'Director' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytketpekerjaan" class="col-md-3 col-form-label text-md-left">{{ __('Ket Pekerjaan') }}</label>
                            <div class="col-md-9">
                                <input id="modalrwytketpekerjaan" type="text" class="form-control" name="modalrwytketpekerjaan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytdivisi" class="col-md-3 col-form-label text-md-left">{{ __('Divisi') }}</label>
                            <div class="col-md-9">
                                <input id="modalrwytdivisi" type="text" class="form-control" name="modalrwytdivisi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytiscurrent" class="col-md-3 col-form-label text-md-left">{{ __('Masih Bekerja di sini?') }}</label>

                            <div class="col-md-9">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="form-control custom-control-input" id="modalrwytiscurrent" name="modalrwytiscurrent" value="1">
                                    <label class="custom-control-label" for="modalrwytiscurrent">Ya</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwyttglmulai" class="col-md-3 col-form-label text-md-left">{{ __('Masa Kerja') }} :</label>
                            <div class="col-md-3">
                                <input class="form-control dp-text" type="date" type="text" name="modalrwyttglmulai" id="modalrwyttglmulai" required />
                            </div>
                            <label for="modalrwyttglsampai" class="col-md-3 col-form-label text-md-left">{{ __('Sampai') }} :</label>
                            <div class="col-md-3">
                                <input class="form-control dp-text" type="date" type="text" name="modalrwyttglsampai" id="modalrwyttglsampai"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" onclick="validateRiwayatKerja();"">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="modalFormSertifikat" class="modal fade" role="dialog" aria-labelledby="titleSertifikat" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleSertifikat">Tambah Sertifikat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="sertifikatForm">
                <input type="hidden" name="modalsrtidx" id="modalsrtidx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalsrtnama" class="col-md-3 col-form-label text-md-left">{{ __('Nama Sertifikat') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrtnama" type="text" class="form-control" name="modalsrtnama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtpemberi" class="col-md-3 col-form-label text-md-left">{{ __('Pemberi Sertifikat') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrtpemberi" type="text" class="form-control" name="modalsrtpemberi" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtno" class="col-md-3 col-form-label text-md-left">{{ __('No Sertifikat') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrtno" type="text" class="form-control" name="modalsrtno">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtbidangkeahlian" class="col-md-3 col-form-label text-md-left">{{ __('Bidang Keahlian') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrtbidangkeahlian" type="text" class="form-control" name="modalsrtbidangkeahlian">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-left"><b>{{ __('Tanggal Sertifikat') }}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtbulan" class="col-md-3 col-form-label text-md-left">{{ __('Bulan') }}</label>
                            <div class="col-md-3">
                                <select id="modalsrtbulan" class="custom-select-sertifikat form-control" name='modalsrtbulan' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="{{enum::BULAN_JAN}}">{{ 'Januari' }}</option>
                                    <option value="{{enum::BULAN_FEB}}">{{ 'Februari' }}</option>
                                    <option value="{{enum::BULAN_MAR}}">{{ 'Maret' }}</option>
                                    <option value="{{enum::BULAN_APR}}">{{ 'April' }}</option>
                                    <option value="{{enum::BULAN_MEI}}">{{ 'Mei' }}</option>
                                    <option value="{{enum::BULAN_JUN}}">{{ 'Juni' }}</option>
                                    <option value="{{enum::BULAN_JUL}}">{{ 'Juli' }}</option>
                                    <option value="{{enum::BULAN_AGU}}">{{ 'Agustus' }}</option>
                                    <option value="{{enum::BULAN_SEP}}">{{ 'September' }}</option>
                                    <option value="{{enum::BULAN_OKT }}">{{ 'Oktober' }}</option>
                                    <option value="{{enum::BULAN_NOV }}">{{ 'November' }}</option>
                                    <option value="{{enum::BULAN_DES }}">{{ 'Desember' }}</option>
                                </select>
                            </div>
                            <label for="modalsrttahun" class="col-md-3 col-form-label text-md-left">{{ __('Tahun') }}</label>
                            <div class="col-md-3">
                                <select id="modalsrttahun" class="custom-select-sertifikat form-control" name='modalsrttahun' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahun as $item)
                                    <option value="{{$item->tahunid}}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtisexpired" class="col-md-3 col-form-label text-md-left">{{ __('Masa berlaku *') }}</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="modalsrtisexpired" id="modalsrtisexpired0" value="0" onchange="setMasaBerlakuRule(0)">
                                    <label class="form-check-label" for="modalsrtisexpired0">Sertifikat ini tidak memiliki masa berlaku</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="modalsrtisexpired" id="modalsrtisexpired1" value="1" onchange="setMasaBerlakuRule(1)" checked>
                                    <label class="form-check-label" for="modalsrtisexpired1">Sertifikat ini memiliki masa berlaku</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtbulanexp" class="col-md-3 col-form-label text-md-left">{{ __('Bulan') }}</label>
                            <div class="col-md-3">
                                <select id="modalsrtbulanexp" class="custom-select-sertifikat form-control" name='modalsrtbulanexp' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="{{enum::BULAN_JAN}}">{{ 'Januari' }}</option>
                                    <option value="{{enum::BULAN_FEB}}">{{ 'Februari' }}</option>
                                    <option value="{{enum::BULAN_MAR}}">{{ 'Maret' }}</option>
                                    <option value="{{enum::BULAN_APR}}">{{ 'April' }}</option>
                                    <option value="{{enum::BULAN_MEI}}">{{ 'Mei' }}</option>
                                    <option value="{{enum::BULAN_JUN}}">{{ 'Juni' }}</option>
                                    <option value="{{enum::BULAN_JUL}}">{{ 'Juli' }}</option>
                                    <option value="{{enum::BULAN_AGU}}">{{ 'Agustus' }}</option>
                                    <option value="{{enum::BULAN_SEP}}">{{ 'September' }}</option>
                                    <option value="{{enum::BULAN_OKT }}">{{ 'Oktober' }}</option>
                                    <option value="{{enum::BULAN_NOV }}">{{ 'November' }}</option>
                                    <option value="{{enum::BULAN_DES }}">{{ 'Desember' }}</option>
                                </select>
                            </div>
                            <label for="modalsrttahunexp" class="col-md-3 col-form-label text-md-left">{{ __('Tahun') }}</label>
                            <div class="col-md-3">
                                <select id="modalsrttahunexp" class="custom-select-sertifikat form-control" name='modalsrttahunexp' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahun as $item)
                                    <option value="{{$item->tahunid}}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrturl" class="col-md-3 col-form-label text-md-left">{{ __('URL Sertifikat') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrturl" type="url" class="form-control" name="modalsrturl">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" onclick="validateSertifikat();"">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="modalFormRiwayatPendidikan" class="modal fade" role="dialog" aria-labelledby="titleRiwayatPendidikan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleRiwayatPendidikan">Tambah Riwayat Pendidikan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="riwayatPendidikanForm">
                <input type="hidden" name="modalrwytpddidx" id="modalrwytpddidx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalrwytpddnamainstitusi" class="col-md-3 col-form-label text-md-left">{{ __('Nama Institusi Pendidikan') }}</label>
                            <div class="col-md-9">
                                <input id="modalrwytpddnamainstitusi" type="text" class="form-control" name="modalrwytpddnamainstitusi" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytpddjenjang" class="col-md-3 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                            <div class="col-md-9">
                                <select id="modalrwytpddjenjang" class="custom-select-riwayat-pendidikan form-control" name='modalrwytpddjenjang' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_SD}}">{{ 'SD dan Sederajat' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_SMP}}">{{ 'SMP dan Sederajat' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_SMA}}">{{ 'SMA dan Sederajat' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_D1}}">{{ 'DI' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_D2}}">{{ 'DII' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_D3}}">{{ 'DIII' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_S1}}">{{ 'S1/DIV' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_S2}}">{{ 'S2' }}</option>
                                    <option value="{{enum::JENJANG_PENDIDIKAN_S3}}">{{ 'S3' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytpddprogramstudi" class="col-md-3 col-form-label text-md-left">{{ __('Program Studi') }}</label>
                            <div class="col-md-9">
                                <input id="modalrwytpddprogramstudi" type="text" class="form-control" name="modalrwytpddprogramstudi" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-left"><b>{{ __('Tanggal Masuk') }}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytpddbulanmasuk" class="col-md-3 col-form-label text-md-left">{{ __('Bulan') }}</label>
                            <div class="col-md-3">
                                <select id="modalrwytpddbulanmasuk" class="custom-select-riwayat-pendidikan form-control" name='modalrwytpddbulanmasuk' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="{{enum::BULAN_JAN}}">{{ 'Januari' }}</option>
                                    <option value="{{enum::BULAN_FEB}}">{{ 'Februari' }}</option>
                                    <option value="{{enum::BULAN_MAR}}">{{ 'Maret' }}</option>
                                    <option value="{{enum::BULAN_APR}}">{{ 'April' }}</option>
                                    <option value="{{enum::BULAN_MEI}}">{{ 'Mei' }}</option>
                                    <option value="{{enum::BULAN_JUN}}">{{ 'Juni' }}</option>
                                    <option value="{{enum::BULAN_JUL}}">{{ 'Juli' }}</option>
                                    <option value="{{enum::BULAN_AGU}}">{{ 'Agustus' }}</option>
                                    <option value="{{enum::BULAN_SEP}}">{{ 'September' }}</option>
                                    <option value="{{enum::BULAN_OKT }}">{{ 'Oktober' }}</option>
                                    <option value="{{enum::BULAN_NOV }}">{{ 'November' }}</option>
                                    <option value="{{enum::BULAN_DES }}">{{ 'Desember' }}</option>
                                </select>
                            </div>
                            <label for="modalrwytpddtahunmasuk" class="col-md-3 col-form-label text-md-left">{{ __('Tahun') }}</label>
                            <div class="col-md-3">
                                <select id="modalrwytpddtahunmasuk" class="custom-select-riwayat-pendidikan form-control" name='modalrwytpddtahunmasuk' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahun as $item)
                                    <option value="{{$item->tahunid}}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-left"><b>{{ __('Tanggal Lulus') }}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytpddbulanlulus" class="col-md-3 col-form-label text-md-left">{{ __('Bulan') }}</label>
                            <div class="col-md-3">
                                <select id="modalrwytpddbulanlulus" class="custom-select-riwayat-pendidikan form-control" name='modalrwytpddbulanlulus' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="{{enum::BULAN_JAN}}">{{ 'Januari' }}</option>
                                    <option value="{{enum::BULAN_FEB}}">{{ 'Februari' }}</option>
                                    <option value="{{enum::BULAN_MAR}}">{{ 'Maret' }}</option>
                                    <option value="{{enum::BULAN_APR}}">{{ 'April' }}</option>
                                    <option value="{{enum::BULAN_MEI}}">{{ 'Mei' }}</option>
                                    <option value="{{enum::BULAN_JUN}}">{{ 'Juni' }}</option>
                                    <option value="{{enum::BULAN_JUL}}">{{ 'Juli' }}</option>
                                    <option value="{{enum::BULAN_AGU}}">{{ 'Agustus' }}</option>
                                    <option value="{{enum::BULAN_SEP}}">{{ 'September' }}</option>
                                    <option value="{{enum::BULAN_OKT }}">{{ 'Oktober' }}</option>
                                    <option value="{{enum::BULAN_NOV }}">{{ 'November' }}</option>
                                    <option value="{{enum::BULAN_DES }}">{{ 'Desember' }}</option>
                                </select>
                            </div>
                            <label for="modalrwytpddtahunlulus" class="col-md-3 col-form-label text-md-left">{{ __('Tahun') }}</label>
                            <div class="col-md-3">
                                <select id="modalrwytpddtahunlulus" class="custom-select-riwayat-pendidikan form-control" name='modalrwytpddtahunlulus' autofocus @if($isshow) disabled @endif required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach ($tahun as $item)
                                    <option value="{{$item->tahunid}}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalrwytpddnilaiakhir" class="col-md-3 col-form-label text-md-left">{{ __('Nilai Akhir') }}</label>
                            <div class="col-md-9">
                                <input id="modalrwytpddnilaiakhir" type="text" class="form-control" name="modalrwytpddnilaiakhir">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" onclick="validateRiwayatPendidikan();"">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($naker->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
        @if($isshow)
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('naker.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('naker.edit', $naker->nakerid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>
        @endif
            @if (count($errors) > 0)
            @foreach ($errorsNaker as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($error as $errorMsg)
                    <span>{{ $errorMsg }}</span><br>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </p>
            @endforeach

            @foreach ($errorsRiwayatPendidikan as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail Riwayat Pendidikan baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
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

            @foreach ($errorsRiwayatKerja as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail Riwayat Pekerjaan baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
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

            @foreach ($errorsSertifikat as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail Sertifikat baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
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
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <!-- <div class="row">
                <div class="col-md-2">
                    <div id="containerBadge1" class="d-flex flex-row align-items-center justify-content-start">
                        <div id="badge1" class="badge badge-active">1</div>
                        <div class="ml-2"><b>Data Pribadi</b></div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div id="containerBadge2" class="flex-row align-items-center" style="display: none;">
                        <div id="badge2" class="badge">2</div>
                        <div class="ml-2"><b>Curiculum Vitae</b></div>
                    </div>
                </div>
            </div> -->

            <ul class="nav nav-tabs" id="nakerTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="nakerdata-tab" data-toggle="tab" href="#nakerdata" role="tab" aria-controls="nakerdata" aria-selected="true"><b>Data Pribadi</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nakercv-tab" data-toggle="tab" href="#nakercv" role="tab" aria-controls="nakercv" aria-selected="false"><b>Curiculum Vitae</b></a>
                </li>
            </ul>

            <form id="nakerForm" method="POST" action="{{ $naker->exists ? route('naker.update', $naker->nakerid) : route('naker.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" onsubmit="return validateAll();">
                @csrf
                @if($naker->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="nakerid" id="nakerid" value="{{ $naker->exists ? $naker->nakerid : '' }}">
                <div class="tab-content" id="nakerTabContent">
                    <!-- <div id="step1"> -->
                    <div class="tab-pane fade show active" id="nakerdata" role="tabpanel" aria-labelledby="nakerdata-tab">
                        <div class="form-group row">
                            <label for="namalengkap" class="col-md-12 col-form-label text-md-left">{{ __('Nama Lengkap*') }}</label>

                            <div class="col-md-12">
                                <input id="namalengkap" type="text" class="form-control @error('namalengkap') is-invalid @enderror" name="namalengkap" value="{{ old('namalengkap', $naker->namalengkap) }}" required autocomplete="name" @if($isshow) disabled @endif onblur="setAtasNama()">

                                @error('namalengkap')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="iswni" class="col-md-12 col-form-label text-md-left">{{ __('Kewarganegaraan *') }}</label>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="iswni" id="iswni1" value="1" onchange="setJenisNik(1)" @if (old("iswni", $naker->iswni)==="1") checked @endif @if($isshow) onclick="return false;" @endif>
                                            <label class="form-check-label" for="iswni1">WNI</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="iswni" id="iswni0" value="0" onchange="setJenisNik(0)" @if (old("iswni", $naker->iswni)==="0") checked @endif @if($isshow) onclick="return false;" @endif>
                                            <label class="form-check-label" for="iswni0">WNA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="negaraid" class="col-md-12 col-form-label text-md-left">{{ __('Negara') }}</label>

                                    <div class="col-md-12">
                                        <select id="negaraid" class="custom-select form-control @error('negaraid') is-invalid @enderror" name='negaraid' autofocus @if($isshow) disabled @endif>
                                            <option value="">-- Pilih Negara --</option>
                                            @foreach ($negara as $item)
                                            <option @if (old("negaraid", $naker->negaraid)==strval($item->negaraid)) selected @endif value="{{$item->negaraid}}">{{ $item->negara }}</option>
                                            @endforeach
                                        </select>

                                        @error('pangkat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="jenisnik" class="col-md-12 col-form-label text-md-left">{{ __('Jenis NIK') }}</label>

                                    <div class="col-md-12">
                                        <select id="jenisnik" class="custom-select form-control @error('jenisnik') is-invalid @enderror" name='jenisnik' autofocus disabled required>
                                            <option value="" selected>-- Pilih Jenis NIK --</option>
                                            <option @if (old("jenisnik", $naker->jenisnik)==strval(enum::JENISNIK_KTP)) selected @endif value="{{enum::JENISNIK_KTP}}">{{ 'KTP' }}</option>
                                            <option @if (old("jenisnik", $naker->jenisnik)==strval(enum::JENISNIK_KITAS)) selected @endif value="{{enum::JENISNIK_KITAS}}">{{ 'KITAS' }}</option>
                                        </select>

                                        @error('jenisnik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="nik" class="col-md-12 col-form-label text-md-left">{{ __('NIK *') }}</label>

                                    <div class="col-md-12">
                                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik', $naker->nik) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tempatlahir" class="col-md-12 col-form-label text-md-left">{{ __('Tempat Lahir *') }}</label>

                            <div class="col-md-12">
                                <input id="tempatlahir" type="text" class="form-control @error('tempatlahir') is-invalid @enderror" name="tempatlahir" value="{{ old('tempatlahir', $naker->tempatlahir) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('tempatlahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tgllahir" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal Lahir *') }} :</label>
                                    <div class="col-md-12">
                                        <input class="form-control dp-text" type="date" type="text" name="tgllahir" id="tgllahir" max="{{ Carbon::now()->subYears(15)->isoFormat('YYYY-MM-DD') }}" value="{{ ($naker->exists ? $naker->tgllahir : old('tgllahir', Carbon::now()->subYears(15)->isoFormat('YYYY-MM-DD'))) }}" required />

                                         @error('tgllahir')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="jeniskelamin" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Kelamin *') }}</label>

                                    <div class="col-md-12">
                                        <select id="jeniskelamin" class="custom-select form-control @error('jeniskelamin') is-invalid @enderror" name='jeniskelamin' autofocus required>
                                            <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                            <option @if (old("jeniskelamin", $naker->jeniskelamin)==strval(enum::JENISKELAMIN_LAKILAKI)) selected @endif value="{{enum::JENISKELAMIN_LAKILAKI}}">{{ 'Laki-Laki' }}</option>
                                            <option @if (old("jeniskelamin", $naker->jeniskelamin)==strval(enum::JENISKELAMIN_PEREMPUAN)) selected @endif value="{{enum::JENISKELAMIN_PEREMPUAN}}">{{ 'Perempuan' }}</option>
                                        </select>

                                        @error('jeniskelamin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                            <div class="col-md-12">
                                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name">{{ old('alamat', $naker->alamat) }}</textarea>

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
                                    <option @if (old("provinsiid", $naker->provinsiid)==strval($item->provid)) selected @endif value="{{$item->provid}}">{{ $item->kodeprov . ' ' . $item->namaprov }}</option>
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
                            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten *') }}</label>

                            <div class="col-md-12">
                                <select id="kotaid" class="custom-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus>
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                    @foreach ($kota as $item)
                                    <option @if (old("kotaid", $naker->kotaid)==strval($item->kotaid)) selected @endif value="{{$item->kotaid}}">{{ $item->kodekota . ' ' . $item->namakota }}</option>
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
                                    <option @if (old("kecamatanid", $naker->kecamatanid)==strval($item->kecamatanid)) selected @endif value="{{$item->kecamatanid}}">{{ $item->kodekec . ' ' . $item->namakec }}</option>
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
                                    <option @if (old("kelurahanid", $naker->kelurahanid)==strval($item->kelurahanid)) selected @endif value="{{$item->kelurahanid}}">{{ $item->kodekel . ' ' . $item->namakel }}</option>
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
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="telp" class="col-md-12 col-form-label text-md-left">{{ __('Telp') }}</label>

                                    <div class="col-md-12">
                                        <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp', $naker->telp) }}" autocomplete="name">

                                        @error('telp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $naker->email) }}" autocomplete="name">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="agama" class="col-md-12 col-form-label text-md-left">{{ __('Agama') }}</label>

                                    <div class="col-md-12">
                                        <select id="agama" class="custom-select form-control @error('agama') is-invalid @enderror" name='agama' autofocus>
                                            <option value="" selected>-- Pilih Agama --</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_BUDDHA)) selected @endif value="{{enum::AGAMA_BUDDHA}}">{{ 'Buddha' }}</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_HINDU)) selected @endif value="{{enum::AGAMA_HINDU}}">{{ 'Hindu' }}</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_ISLAM)) selected @endif value="{{enum::AGAMA_ISLAM}}">{{ 'Islam' }}</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_KATOLIK)) selected @endif value="{{enum::AGAMA_KATOLIK}}">{{ 'Katolik' }}</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_KONGHUCHU)) selected @endif value="{{enum::AGAMA_KONGHUCHU}}">{{ 'Konghuchu' }}</option>
                                            <option @if (old("agama", $naker->agama)==strval(enum::AGAMA_PROTESTAN)) selected @endif value="{{enum::AGAMA_PROTESTAN}}">{{ 'Protestan' }}</option>
                                        </select>

                                        @error('agama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="statusnikah" class="col-md-12 col-form-label text-md-left">{{ __('Status Pernikahan') }}</label>

                                    <div class="col-md-12">
                                        <select id="statusnikah" class="custom-select form-control @error('statusnikah') is-invalid @enderror" name='statusnikah' autofocus>
                                            <option value="" selected>-- Pilih Status Pernikahan --</option>
                                            <option @if (old("statusnikah", $naker->statusnikah)==strval(enum::STATUS_NIKAH_BELUM_KAWIN)) selected @endif value="{{enum::STATUS_NIKAH_BELUM_KAWIN}}">{{ 'Belum Kawin' }}</option>
                                            <option @if (old("statusnikah", $naker->statusnikah)==strval(enum::STATUS_NIKAH_KAWIN)) selected @endif value="{{enum::STATUS_NIKAH_KAWIN}}">{{ 'Kawin' }}</option>
                                            <option @if (old("statusnikah", $naker->statusnikah)==strval(enum::STATUS_NIKAH_CERAI_HIDUP)) selected @endif value="{{enum::STATUS_NIKAH_CERAI_HIDUP}}">{{ 'Cerai Hidup' }}</option>
                                            <option @if (old("statusnikah", $naker->statusnikah)==strval(enum::STATUS_NIKAH_CERAI_MATI)) selected @endif value="{{enum::STATUS_NIKAH_CERAI_MATI}}">{{ 'Cerai Mati' }}</option>
                                        </select>

                                        @error('statusnikah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--<div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ptkpid" class="col-md-12 col-form-label text-md-left">{{ __('PTKP') }}</label>

                                    <div class="col-md-12">
                                        <select id="ptkpid" class="custom-select form-control @error('ptkpid') is-invalid @enderror" name='ptkpid' autofocus>
                                            <option value="">-- Pilih PTKP --</option>
                                            @foreach ($ptkp as $item)
                                            <option @if (old("ptkpid", $naker->ptkpid)==strval($item->ptkpid)) selected @endif value="{{$item->ptkpid}}">{{ $item->jenis . ' - ' . $item->keterangan }}</option>
                                            @endforeach
                                        </select>

                                        @error('ptkpid')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="npwp" class="col-md-12 col-form-label text-md-left">{{ __('NPWP') }}</label>

                                    <div class="col-md-12">
                                        <input id="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ old('npwp', $naker->npwp) }}" autocomplete="name">

                                        @error('npwp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank" class="col-md-12 col-form-label text-md-left">{{ __('Nama Bank') }}</label>

                            <div class="col-md-12">
                                <input id="bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ old('bank', $naker->bank) }}" autocomplete="name">

                                @error('bank')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="norek" class="col-md-12 col-form-label text-md-left">{{ __('No Rek') }}</label>

                                    <div class="col-md-12">
                                        <input id="norek" type="text" class="form-control @error('norek') is-invalid @enderror" name="norek" value="{{ old('norek', $naker->norek) }}" autocomplete="name">

                                        @error('norek')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="atasnama" class="col-md-12 col-form-label text-md-left">{{ __('Atas Nama') }}</label>

                                    <div class="col-md-12">
                                        <input id="atasnama" type="text" class="form-control @error('atasnama') is-invalid @enderror" name="atasnama" value="{{ old('atasnama', $naker->atasnama) }}" autocomplete="name">

                                        @error('atasnama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group row">
                            <label for="nobpjs" class="col-md-12 col-form-label text-md-left">{{ __('No. BPJS Kesehatan') }}</label>

                            <div class="col-md-12">
                                <input id="nobpjs" type="text" class="form-control @error('nobpjs') is-invalid @enderror" name="nobpjs" value="{{ old('nobpjs', $naker->nobpjs) }}" autocomplete="name" minlength="15" maxlength="16">

                                @error('nobpjs')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nobpjsnaker" class="col-md-12 col-form-label text-md-left">{{ __('No. BPJS Ketenagakerjaan') }}</label>

                            <div class="col-md-12">
                                <input id="nobpjsnaker" type="text" class="form-control @error('nobpjsnaker') is-invalid @enderror" name="nobpjsnaker" value="{{ old('nobpjsnaker', $naker->nobpjsnaker) }}" autocomplete="name">

                                @error('nobpjsnaker')
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
                                    <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1" @if (old("status", $naker->status)=="1" || !$naker->exists) checked @endif @if($isshow) onclick="return false;" @endif>
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
                                <!-- <button type="button" class="btn btn-info waves-effect waves-light m-r-10" onclick="goToStep(2, 1);">
                                    {{ __('Selanjutnya') }}
                                </button> -->
                            </div>
                        </div>
                    </div>

                    <!-- <div id="step2" style="display: none;"> -->
                    <div class="tab-pane fade" id="nakercv" role="tabpanel" aria-labelledby="nakercv-tab">
                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <h4 class="text-info">Riwayat Pendidikan</h4>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="javascript:addRiwayatPendidikan();" type="button" id="btnaddriwayatpendidikan" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                </div>
                            </div>
                            <div id="riwayatPendidikanListContainer">
                                @if(old('riwayatpendidikan'))
                                    @foreach(old('riwayatpendidikan') as $dataRiwayatPendidikan)
                                    <div class="p-2 border" id="riwayatpendidikan{{$loop->index}}">
                                        <!-- HIIDEN FIELDS -->
                                        <input type="hidden" id="riwayatpendidikanid{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][riwayatpendidikanid]" value="{{(isset($dataRiwayatPendidikan['riwayatpendidikanid']) ? $dataRiwayatPendidikan['riwayatpendidikanid'] : "")}}">
                                        <input type="hidden" id="indexriwayatpendidikan{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][indexriwayatpendidikan]" value="{{$loop->index}}">
                                        <input type="hidden" id="namainstitusi{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][namainstitusi]" value="{{$dataRiwayatPendidikan['namainstitusi']}}">
                                        <input type="hidden" id="jenjang{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][jenjang]" value="{{$dataRiwayatPendidikan['jenjang']}}">
                                        <input type="hidden" id="programstudi{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][programstudi]" value="{{$dataRiwayatPendidikan['programstudi']}}">
                                        <input type="hidden" id="bulanmasuk{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanmasuk]" value="{{$dataRiwayatPendidikan['bulanmasuk']}}">
                                        <input type="hidden" id="tahunmasuk{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][tahunmasuk]" value="{{$dataRiwayatPendidikan['tahunmasuk']}}">
                                        <input type="hidden" id="bulanlulus{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanlulus]" value="{{$dataRiwayatPendidikan['bulanlulus']}}">
                                        <input type="hidden" id="tahunlulus{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][tahunlulus]" value="{{$dataRiwayatPendidikan['tahunlulus']}}">
                                        <input type="hidden" id="nilaiakhir{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][nilaiakhir]" value="{{$dataRiwayatPendidikan['nilaiakhir']}}">
                                        <input type="hidden" id="jenjangnama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][jenjangnama]" value="{{$dataRiwayatPendidikan['jenjangnama']}}">
                                        <input type="hidden" id="bulanmasuknama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanmasuknama]" value="{{$dataRiwayatPendidikan['bulanmasuknama']}}">
                                        <input type="hidden" id="bulanlulusnama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanlulusnama]" value="{{$dataRiwayatPendidikan['bulanlulusnama']}}">
                                        <!--============= -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5><b id="labelnamainstitusi{{$loop->index}}">{{$dataRiwayatPendidikan['namainstitusi']}}</b></h5>
                                            </div>
                                            <div class="col-md-4">
                                                <button onclick="javascript:hapusRiwayatPendidikan({{$loop->index}});" type="button" id="btndltriwayatpendidikan" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>
                                                <button onclick="javascript:editRiwayatPendidikan({{$loop->index}});" type="button" id="btneditriwayatpendidikan" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span id="labelmasariwayatpendidikan{{$loop->index}}">{{$dataRiwayatPendidikan['bulanmasuknama']. ' s/d '. $dataRiwayatPendidikan['bulanlulusnama']}}</span>
                                                <h5 id="labeljenjang{{$loop->index}}">{{$dataRiwayatPendidikan['jenjangnama']}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach($naker->riwayatpendidikan as $dataRiwayatPendidikan)
                                        <div class="p-2 border" id="riwayatpendidikan{{$loop->index}}">
                                            <!-- HIIDEN FIELDS -->
                                            <input type="hidden" id="riwayatpendidikanid{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][riwayatpendidikanid]" value="{{$dataRiwayatPendidikan['riwayatpendidikanid']}}">
                                            <input type="hidden" id="indexriwayatpendidikan{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][indexriwayatpendidikan]" value="{{$loop->index}}">
                                            <input type="hidden" id="namainstitusi{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][namainstitusi]" value="{{$dataRiwayatPendidikan['namainstitusi']}}">
                                            <input type="hidden" id="jenjang{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][jenjang]" value="{{$dataRiwayatPendidikan['jenjang']}}">
                                            <input type="hidden" id="programstudi{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][programstudi]" value="{{$dataRiwayatPendidikan['programstudi']}}">
                                            <input type="hidden" id="bulanmasuk{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanmasuk]" value="{{$dataRiwayatPendidikan['bulanmasuk']}}">
                                            <input type="hidden" id="tahunmasuk{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][tahunmasuk]" value="{{$dataRiwayatPendidikan['tahunmasuk']}}">
                                            <input type="hidden" id="bulanlulus{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanlulus]" value="{{$dataRiwayatPendidikan['bulanlulus']}}">
                                            <input type="hidden" id="tahunlulus{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][tahunlulus]" value="{{$dataRiwayatPendidikan['tahunlulus']}}">
                                            <input type="hidden" id="nilaiakhir{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][nilaiakhir]" value="{{$dataRiwayatPendidikan['nilaiakhir']}}">
                                            <input type="hidden" id="jenjangnama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][jenjangnama]" value="{{$dataRiwayatPendidikan['jenjangnama']}}">
                                            <input type="hidden" id="bulanmasuknama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanmasuknama]" value="{{$dataRiwayatPendidikan['bulanmasuknama']}}">
                                            <input type="hidden" id="bulanlulusnama{{$loop->index}}" name="riwayatpendidikan[{{$loop->index}}][bulanlulusnama]" value="{{$dataRiwayatPendidikan['bulanlulusnama']}}">
                                            <!--============= -->
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5><b id="labelnamainstitusi{{$loop->index}}">{{$dataRiwayatPendidikan['namainstitusi']}}</b></h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <button onclick="javascript:hapusRiwayatPendidikan({{$loop->index}});" type="button" id="btndltriwayatpendidikan" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>
                                                    <button onclick="javascript:editRiwayatPendidikan({{$loop->index}});" type="button" id="btneditriwayatpendidikan" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span id="labelmasariwayatpendidikan{{$loop->index}}">{{$dataRiwayatPendidikan['bulanmasuknama'].' s/d ' .$dataRiwayatPendidikan['bulanlulusnama']}}</span>
                                                    <h5 id="labeljenjang{{$loop->index}}">{{$dataRiwayatPendidikan['jenjangnama']}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <h4 class="text-info">Riwayat Pekerjaan</h4>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="javascript:addRiwayatKerja();" type="button" id="btnaddriwayatkerja" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                </div>
                            </div>
                            <div id="riwayatKerjaListContainer">
                                @if(old('riwayatkerja'))
                                    @foreach(old('riwayatkerja') as $dataRiwayatKerja)
                                    <div class="p-2 border" id="riwayatkerja{{$loop->index}}">
                                        <!-- HIIDEN FIELDS -->
                                        <input type="hidden" id="riwayatkerjaid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][riwayatkerjaid]" value="{{(isset($dataRiwayatKerja['riwayatkerjaid']) ? $dataRiwayatKerja['riwayatkerjaid'] : "")}}">
                                        <input type="hidden" id="indexriwayatkerja{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][indexriwayatkerja]" value="{{$loop->index}}">
                                        <input type="hidden" id="statuspekerjaan{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][statuspekerjaan]" value="{{$dataRiwayatKerja['statuspekerjaan']}}">
                                        <input type="hidden" id="perusahaanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][perusahaanid]" value="{{$dataRiwayatKerja['perusahaanid']}}">
                                        <input type="hidden" id="provinsiid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][provinsiid]" value="{{$dataRiwayatKerja['provinsiid']}}">
                                        <input type="hidden" id="kotaid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kotaid]" value="{{$dataRiwayatKerja['kotaid']}}">
                                        <input type="hidden" id="kecamatanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kecamatanid]" value="{{$dataRiwayatKerja['kecamatanid']}}">
                                        <input type="hidden" id="kelurahanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kelurahanid]" value="{{$dataRiwayatKerja['kelurahanid']}}">
                                        <input type="hidden" id="golid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][golid]" value="{{$dataRiwayatKerja['golid']}}">
                                        <input type="hidden" id="level{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][level]" value="{{$dataRiwayatKerja['level']}}">
                                        <input type="hidden" id="ketpekerjaan{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][ketpekerjaan]" value="{{$dataRiwayatKerja['ketpekerjaan']}}">
                                        <input type="hidden" id="divisi{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][divisi]" value="{{$dataRiwayatKerja['divisi']}}">
                                        <input type="hidden" id="iscurrent{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][iscurrent]" value="{{$dataRiwayatKerja['iscurrent']}}">
                                        <input type="hidden" id="tglmulai{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][tglmulai]" value="{{$dataRiwayatKerja['tglmulai']}}">
                                        <input type="hidden" id="tglsampai{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][tglsampai]" value="{{$dataRiwayatKerja['tglsampai']}}">
                                        <input type="hidden" id="createdby{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][createdby]" value="{{$dataRiwayatKerja['createdby']}}">
                                        <input type="hidden" id="perusahaannama{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][perusahaannama]" value="{{$dataRiwayatKerja['perusahaannama']}}">
                                        <input type="hidden" id="lamabekerja{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][lamabekerja]" value="{{$dataRiwayatKerja['lamabekerja']}}">
                                        <!--============= -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5><b id="labelperusahaannama{{$loop->index}}">{{$dataRiwayatKerja['perusahaannama']}}</b></h5>
                                            </div>
                                            <div class="col-md-4">
                                                <button onclick="javascript:hapusRiwayatKerja({{$loop->index}});" type="button" id="btndltriwayatkerja" class="mx-1 btn btn-sm btn-danger pull-right" 
                                                    @if(Auth::user()->akses->grup===enum::USER_NAKER && $dataRiwayatKerja['createdby']==1)
                                                        disabled 
                                                    @endif>
                                                    Hapus
                                                </button>
                                                <button onclick="javascript:editRiwayatKerja({{$loop->index}});" type="button" id="btneditriwayatkerja" class="mx-1 btn btn-sm btn-warning pull-right"
                                                    @if(Auth::user()->akses->grup===enum::USER_NAKER && $dataRiwayatKerja['createdby']==1)
                                                        disabled 
                                                    @endif>
                                                    Ubah
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span id="labellamabekerja{{$loop->index}}">{{$dataRiwayatKerja['lamabekerja']}}</span>
                                                <h5 id="labelketpekerjaan{{$loop->index}}">{{$dataRiwayatKerja['ketpekerjaan']}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach($naker->riwayatkerja as $dataRiwayatKerja)
                                        <div class="p-2 border" id="riwayatkerja{{$loop->index}}">
                                            <!-- HIIDEN FIELDS -->
                                            <input type="hidden" id="riwayatkerjaid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][riwayatkerjaid]" value="{{$dataRiwayatKerja['riwayatkerjaid']}}">
                                            <input type="hidden" id="indexriwayatkerja{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][indexriwayatkerja]" value="{{$loop->index}}">
                                            <input type="hidden" id="statuspekerjaan{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][statuspekerjaan]" value="{{$dataRiwayatKerja['statuspekerjaan']}}">
                                            <input type="hidden" id="perusahaanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][perusahaanid]" value="{{$dataRiwayatKerja['perusahaanid']}}">
                                            <input type="hidden" id="provinsiid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][provinsiid]" value="{{$dataRiwayatKerja['provinsiid']}}">
                                            <input type="hidden" id="kotaid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kotaid]" value="{{$dataRiwayatKerja['kotaid']}}">
                                            <input type="hidden" id="kecamatanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kecamatanid]" value="{{$dataRiwayatKerja['kecamatanid']}}">
                                            <input type="hidden" id="kelurahanid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][kelurahanid]" value="{{$dataRiwayatKerja['kelurahanid']}}">
                                            <input type="hidden" id="golid{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][golid]" value="{{$dataRiwayatKerja['golid']}}">
                                            <input type="hidden" id="level{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][level]" value="{{$dataRiwayatKerja['level']}}">
                                            <input type="hidden" id="ketpekerjaan{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][ketpekerjaan]" value="{{$dataRiwayatKerja['ketpekerjaan']}}">
                                            <input type="hidden" id="divisi{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][divisi]" value="{{$dataRiwayatKerja['divisi']}}">
                                            <input type="hidden" id="iscurrent{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][iscurrent]" value="{{$dataRiwayatKerja['iscurrent']}}">
                                            <input type="hidden" id="tglmulai{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][tglmulai]" value="{{$dataRiwayatKerja['tglmulai']}}">
                                            <input type="hidden" id="tglsampai{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][tglsampai]" value="{{$dataRiwayatKerja['tglsampai']}}">
                                            <input type="hidden" id="createdby{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][createdby]" value="{{$dataRiwayatKerja['createdby']}}">
                                            <input type="hidden" id="perusahaannama{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][perusahaannama]" value="{{($dataRiwayatKerja['perusahaan'] ? $dataRiwayatKerja['perusahaan']['nama'] : '')}}">
                                            <input type="hidden" id="lamabekerja{{$loop->index}}" name="riwayatkerja[{{$loop->index}}][lamabekerja]" value="{{$dataRiwayatKerja['lamabekerja']}}">
                                            <!--============= -->
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5><b id="labelperusahaannama{{$loop->index}}">{{($dataRiwayatKerja['perusahaan'] ? $dataRiwayatKerja['perusahaan']['nama'] : '')}}</b></h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <button onclick="javascript:hapusRiwayatKerja({{$loop->index}});" type="button" id="btndltriwayatkerja" class="mx-1 btn btn-sm btn-danger pull-right"
                                                    @if(Auth::user()->akses->grup===enum::USER_NAKER && $dataRiwayatKerja['createdby']==1)
                                                        disabled 
                                                    @endif
                                                    >
                                                        Hapus
                                                    </button>
                                                    <button onclick="javascript:editRiwayatKerja({{$loop->index}});" type="button" id="btneditriwayatkerja" class="mx-1 btn btn-sm btn-warning pull-right"
                                                    @if(Auth::user()->akses->grup===enum::USER_NAKER && $dataRiwayatKerja['createdby']==1)
                                                        disabled 
                                                    @endif
                                                    >
                                                        Ubah
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span id="labellamabekerja{{$loop->index}}">{{$dataRiwayatKerja['lamabekerja']}}</span>
                                                    <h5 id="labelketpekerjaan{{$loop->index}}">{{$dataRiwayatKerja['ketpekerjaan']}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <hr/>
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <h4 class="text-info">Sertifikat</h4>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="javascript:addSertifikat();" type="button" id="btnaddserifikat" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                </div>
                            </div>
                            <div id="sertifikatListContainer">
                                @if(old('sertifikat'))
                                    @foreach(old('sertifikat') as $dataSertifikat)
                                    <div class="p-2 border" id="sertifikat{{$loop->index}}">
                                        <!-- HIIDEN FIELDS -->
                                        <input type="hidden" id="sertifikatid{{$loop->index}}" name="sertifikat[{{$loop->index}}][sertifikatid]" value="{{(isset($dataSertifikat['sertifikatid']) ? $dataSertifikat['sertifikatid'] : "")}}">
                                        <input type="hidden" id="indexsertifikat{{$loop->index}}" name="sertifikat[{{$loop->index}}][indexsertifikat]" value="{{$loop->index}}">
                                        <input type="hidden" id="nama{{$loop->index}}" name="sertifikat[{{$loop->index}}][nama]" value="{{$dataSertifikat['nama']}}">
                                        <input type="hidden" id="pemberi{{$loop->index}}" name="sertifikat[{{$loop->index}}][pemberi]" value="{{$dataSertifikat['pemberi']}}">
                                        <input type="hidden" id="no{{$loop->index}}" name="sertifikat[{{$loop->index}}][no]" value="{{$dataSertifikat['no']}}">
                                        <input type="hidden" id="bulan{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulan]" value="{{$dataSertifikat['bulan']}}">
                                        <input type="hidden" id="tahun{{$loop->index}}" name="sertifikat[{{$loop->index}}][tahun]" value="{{$dataSertifikat['tahun']}}">
                                        <input type="hidden" id="isexpired{{$loop->index}}" name="sertifikat[{{$loop->index}}][isexpired]" value="{{$dataSertifikat['isexpired']}}">
                                        <input type="hidden" id="bulanexp{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulanexp]" value="{{$dataSertifikat['bulanexp']}}">
                                        <input type="hidden" id="tahunexp{{$loop->index}}" name="sertifikat[{{$loop->index}}][tahunexp]" value="{{$dataSertifikat['tahunexp']}}">
                                        <input type="hidden" id="url{{$loop->index}}" name="sertifikat[{{$loop->index}}][url]" value="{{$dataSertifikat['url']}}">
                                        <input type="hidden" id="bulannama{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulannama]" value="{{$dataSertifikat['bulannama']}}">
                                        <input type="hidden" id="bulanexpnama{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulanexpnama]" value="{{$dataSertifikat['bulanexpnama']}}">
                                        <input type="hidden" id="bidangkeahlian{{$loop->index}}" name="sertifikat[{{$loop->index}}][bidangkeahlian]" value="{{$dataSertifikat['bidangkeahlian']}}">
                                        <!--============= -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5><b id="labelnama{{$loop->index}}">{{$dataSertifikat['nama']}}</b></h5>
                                            </div>
                                            <div class="col-md-4">
                                                <button onclick="javascript:hapusSertifikat({{$loop->index}});" type="button" id="btndltsertifikat" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>
                                                <button onclick="javascript:editSertifikat({{$loop->index}});" type="button" id="btneditsertifikat" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span id="labelmasasertifikat{{$loop->index}}">{{$dataSertifikat['bulannama']. ' s/d '. $dataSertifikat['bulanexpnama']}}</span>
                                                <h5 id="labelpemberi{{$loop->index}}">{{$dataSertifikat['pemberi']}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach($naker->sertifikat as $dataSertifikat)
                                        <div class="p-2 border" id="sertifikat{{$loop->index}}">
                                            <!-- HIIDEN FIELDS -->
                                            <input type="hidden" id="sertifikatid{{$loop->index}}" name="sertifikat[{{$loop->index}}][sertifikatid]" value="{{$dataSertifikat['sertifikatid']}}">
                                            <input type="hidden" id="indexsertifikat{{$loop->index}}" name="sertifikat[{{$loop->index}}][indexsertifikat]" value="{{$loop->index}}">
                                            <input type="hidden" id="nama{{$loop->index}}" name="sertifikat[{{$loop->index}}][nama]" value="{{$dataSertifikat['nama']}}">
                                            <input type="hidden" id="pemberi{{$loop->index}}" name="sertifikat[{{$loop->index}}][pemberi]" value="{{$dataSertifikat['pemberi']}}">
                                            <input type="hidden" id="no{{$loop->index}}" name="sertifikat[{{$loop->index}}][no]" value="{{$dataSertifikat['no']}}">
                                            <input type="hidden" id="bulan{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulan]" value="{{$dataSertifikat['bulan']}}">
                                            <input type="hidden" id="tahun{{$loop->index}}" name="sertifikat[{{$loop->index}}][tahun]" value="{{$dataSertifikat['tahun']}}">
                                            <input type="hidden" id="isexpired{{$loop->index}}" name="sertifikat[{{$loop->index}}][isexpired]" value="{{$dataSertifikat['isexpired']}}">
                                            <input type="hidden" id="bulanexp{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulanexp]" value="{{$dataSertifikat['bulanexp']}}">
                                            <input type="hidden" id="tahunexp{{$loop->index}}" name="sertifikat[{{$loop->index}}][tahunexp]" value="{{$dataSertifikat['tahunexp']}}">
                                            <input type="hidden" id="url{{$loop->index}}" name="sertifikat[{{$loop->index}}][url]" value="{{$dataSertifikat['url']}}">
                                            <input type="hidden" id="bulannama{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulannama]" value="{{$dataSertifikat['bulannama']}}">
                                            <input type="hidden" id="bulanexpnama{{$loop->index}}" name="sertifikat[{{$loop->index}}][bulanexpnama]" value="{{$dataSertifikat['bulanexpnama']}}">
                                            <input type="hidden" id="bidangkeahlian{{$loop->index}}" name="sertifikat[{{$loop->index}}][bidangkeahlian]" value="{{$dataSertifikat['bidangkeahlian']}}">
                                            <!--============= -->
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5><b id="labelnama{{$loop->index}}">{{$dataSertifikat['nama']}}</b></h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <button onclick="javascript:hapusSertifikat({{$loop->index}});" type="button" id="btndltsertifikat" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>
                                                    <button onclick="javascript:editSertifikat({{$loop->index}});" type="button" id="btneditsertifikat" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span id="labelmasasertifikat{{$loop->index}}">{{$dataSertifikat['bulannama'].' s/d ' .$dataSertifikat['bulanexpnama']}}</span>
                                                    <h5 id="labelpemberi{{$loop->index}}">{{$dataSertifikat['pemberi']}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <!-- <button type="button" class="btn btn-light waves-effect waves-light m-r-10" onclick="goToStep(1, 2);">
                                    {{ __('Sebelumnya') }}
                                </button> -->
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var $validator = $("#nakerForm").validate({
        ignore: [],
        errorClass: 'invalid-feedback',
        rules: {
            namalengkap : {
                required: true
            },
            iswni: {
                required: true
            },
            negaraid: {
                required: function(element){
                    return $('input[name="iswni"]:checked').val()=="0";
                }
            },
            alamat: {
                required: true
            },
            jeniskelamin: {
                required: true
            },
        },
        messages : {
            namalengkap: {
                required: "Nama Lengkap harus diisi"
            },
            iswni: {
                required: "Kewarganegaraan harus dipilih"
            },
            negaraid: {
                required: "Negara harus dipilih"
            },
            nik: {
                required: "NIK harus diisi"
            },
            alamat: {
                required: "Alamat harus diisi"
            },
            jeniskelamin: {
                required: "Jenis Kelamin harus dipilih"
            },
            tempatlahir: {
                required: "Tempat Lahir harus diisi"
            },
            tgllahir: {
                required: "Tanggal Lahir harus diisi",
                max: "Tanggal Lahir harus sebelum {{ Carbon::now()->subYears(15)->translatedFormat('d F Y') }}"
            },
            provinsiid: {
                required: "Provinsi harus dipilih"
            },
            kotaid: {
                required: "Kota/Kabupaten harus dipilih"
            },
            kecamatanid: {
                required: "Kecamatan harus dipilih"
            },
            kelurahanid: {
                required: "Kelurahan harus dipilih"
            },
            email: {
                email: "Email tidak valid"
            },
            nobpjs: {
                minlength: "No. BPJS Kesehatan minimal 15 Karakter",
                maxlength: "No. BPJS Kesehatan maksimal 16 Karakter"
            },
        }
    });

    var $validatorRiwayatKerja = $("#riwayatKerjaForm").validate({
        errorClass: 'invalid-feedback',
        rules: {
            modalrwytperusahaanid: {
                required: function(element){
                    return (
                        $('#modalrwytstatuspekerjaan').val()==="{{enum::STATUS_PEKERJAAN_FULL_TIME}}" ||
                        $('#modalrwytstatuspekerjaan').val()==="{{enum::STATUS_PEKERJAAN_PART_TIME}}" ||
                        $('#modalrwytstatuspekerjaan').val()==="{{enum::STATUS_PEKERJAAN_MAGANG}}"
                    );
                }
            },
            modalrwyttglmulai: {
                // required: function(element){
                //     return $('input[name="modalrwytiscurrent"]:checked').length == 0;
                // }
                max: function(){
                    if($('input[name="modalrwytiscurrent"]:checked').length == 0){
                        return $('#modalrwyttglsampai').val();
                    }else{
                        return "{{ Carbon::now()->isoFormat('YYYY-MM-DD') }}";
                    }
                }
            },
            modalrwyttglsampai: {
                required: function(element){
                    return $('input[name="modalrwytiscurrent"]:checked').length == 0;
                },
                min: function(){
                    return $('#modalrwyttglmulai').val();
                }
            },
        },
        messages : {
            modalrwytstatuspekerjaan: {
                required: "Status Pekerjaan harus dipilih"
            },
            modalrwytperusahaanid: {
                required: "Perusahaan harus dipilih"
            },
            modalrwytprovinsiid: {
                required: "Provinsi harus dipilih"
            },
            modalrwytkotaid: {
                required: "Kota harus dipilih"
            },
            modalrwyttglmulai: {
                required: "Masa Kerja Mulai harus dipilih",
                max: function(){
                    if($('input[name="modalrwytiscurrent"]:checked').length == 0){
                        return "Masa Kerja Mulai harus lebih kecil dari Masa Kerja Sampai"
                    }else{
                        return "Masa Kerja Mulai harus lebih kecil dari Tanggal Hari Ini"
                    }
                }
            },
            modalrwyttglsampai: {
                required: "Masa Kerja Sampai harus dipilih",
                min: "Masa Kerja Sampai harus lebih besar dari Masa Kerja Mulai"
            },
            modalrwytketpekerjaan: {
                required: "Ket Pekerjaan harus diisi"
            }
        }
    });

    var $validatorSertifikat = $("#sertifikatForm").validate({
        errorClass: 'invalid-feedback',
        rules: {
            modalsrtbulanexp: {
                required: function(element){
                    return $('input[name="modalsrtisexpired"]:checked').val()==1;
                }
            },
            modalsrttahunexp: {
                required: function(element){
                    return $('input[name="modalsrtisexpired"]:checked').val()==1;
                }
            }
        },
        messages : {
            modalsrtnama: {
                required: "Nama Sertifikat harus diisi"
            },
            modalsrtpemberi: {
                required: "Pemberi Sertifikat harus diisi"
            },
            modalsrtbulan: {
                required: "Tanggal Sertifikat - Bulan harus dipilih"
            },
            modalsrttahun: {
                required: "Tanggal Sertifikat - Tahun harus dipilih"
            },
            modalsrtbulanexp: {
                required: "Masa Berlaku - Bulan harus dipilih"
            },
            modalsrttahunexp: {
                required: "Masa Berlaku - Tahun harus dipilih"
            },
            modalsrturl: {
                url: "URL Sertifikat harus berformat URL"
            },
        }
    });

    var $validatorRiwayatPendidikan = $("#riwayatPendidikanForm").validate({
        errorClass: 'invalid-feedback',
        messages : {
            modalrwytpddnamainstitusi: {
                required: "Nama Institusi Pendidikan harus diisi"
            },
            modalrwytpddjenjang: {
                required: "Jenjang harus dipilih"
            },
            modalrwytpddprogramstudi: {
                required: "Program Studi harus diisi"
            },
            modalrwytpddbulanlulus: {
                required: "Tanggal Masuk - Bulan harus dipilih"
            },
            modalrwytpddtahunlulus: {
                required: "Tanggal Masuk - Tahun harus dipilih"
            },
            modalrwytpddbulanmasuk: {
                required: "Tanggal Lulus - Bulan harus dipilih"
            },
            modalrwytpddtahunmasuk: {
                required: "Tanggal Lulus - Tahun harus dipilih"
            },
        }
    });

    var row_number_riwayat = {{ 
        (
            null!==(old('riwayatkerja')) && count(old('riwayatkerja')) > 0 ?  (count(old('riwayatkerja'))+1) 
                : (count($naker->riwayatkerja) > 0 ? (count($naker->riwayatkerja)+1) : 1)
        ) 
    }} ;

    var row_number_sertifikat = {{ 
        (
            null!==(old('sertifikat')) && count(old('sertifikat')) > 0 ?  (count(old('sertifikat'))+1) 
                : (count($naker->sertifikat) > 0 ? (count($naker->sertifikat)+1) : 1)
        ) 
    }} ;

    var row_number_riwayatpendidikan = {{ 
        (
            null!==(old('riwayatpendidikan')) && count(old('riwayatpendidikan')) > 0 ?  (count(old('riwayatpendidikan'))+1) 
                : (count($naker->riwayatpendidikan) > 0 ? (count($naker->riwayatpendidikan)+1) : 1)
        ) 
    }} ;

    var kotaid = '{{ old("kotaid", $naker->kotaid) }}';
    var kecamatanid = '{{ old("kecamatanid", $naker->kecamatanid) }}';
    var kelurahanid = '{{ old("kelurahanid", $naker->kelurahanid) }}';

    var riwayatkerjakotaid = '';
    var riwayatkerjakecamatanid = '';
    var riwayatkerjakelurahanid = '';

    $(document).ready(function() {
        setJenisNik();

        $('.custom-select').select2();

        $('.custom-select-riwayat').select2({
            dropdownParent: $("#modalFormRiwayatKerja .modal-content")
        });

        $('.custom-select-sertifikat').select2({
            dropdownParent: $("#modalFormSertifikat .modal-content")
        });

        $('.custom-select-riwayat-pendidikan').select2({
            dropdownParent: $("#modalFormRiwayatPendidikan .modal-content")
        });

        $('#provinsiid').select2().on('change', function() {
            var url = "{{ route('naker.kota', ':parentid') }}";
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
            var url = "{{ route('naker.kecamatan', ':parentid') }}";
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
            var url = "{{ route('naker.kelurahan', ':parentid') }}";
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

        $('#modalrwytperusahaanid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")}).on('change', function() {
            let perusahaanprovid = $(this).find(":selected").data("provid");
            let perusahaankotaid = $(this).find(":selected").data("kotaid");
            let perusahaankecamatanid = $(this).find(":selected").data("kecamatanid");
            let perusahaankelurahanid = $(this).find(":selected").data("kelurahanid");

            riwayatkerjakotaid = perusahaankotaid;
            riwayatkerjakecamatanid = perusahaankecamatanid;
            riwayatkerjakelurahanid = perusahaankelurahanid;

            $('#modalrwytprovinsiid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")});
            $('#modalrwytprovinsiid').val(perusahaanprovid);
            $('#modalrwytprovinsiid').trigger('change');
        });

        $('#modalrwytprovinsiid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")}).on('change', function() {
            var url = "{{ route('naker.kota', ':parentid') }}";
            url = url.replace(':parentid', ($('#modalrwytprovinsiid').val() == "" || $('#modalrwytprovinsiid').val() == null ? "-1" : $('#modalrwytprovinsiid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#modalrwytkotaid').empty();
                    $('#modalrwytkotaid').append($("<option></option>").attr("value", "").text("-- Pilih Kota --"));
                    $.each(data.data, function(key, value) {
                        $('#modalrwytkotaid').append($("<option></option>").attr("value", value.kotaid).text(value.kodekota + ' ' + value.namakota));
                    });
                    $('#modalrwytkotaid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")});
                    $('#modalrwytkotaid').val(riwayatkerjakotaid);
                    $('#modalrwytkotaid').trigger('change');
                }
            }); 
        }).trigger('change');

        $('#modalrwytkotaid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")}).on('change', function() {
            var url = "{{ route('naker.kecamatan', ':parentid') }}";
            url = url.replace(':parentid', ($('#modalrwytkotaid').val() == "" || $('#modalrwytkotaid').val() == null ? "-1" : $('#modalrwytkotaid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#modalrwytkecamatanid').empty();
                    $('#modalrwytkecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
                    $.each(data.data, function(key, value) {
                        $('#modalrwytkecamatanid').append($("<option></option>").attr("value", value.kecamatanid).text(value.kodekec + ' ' + value.namakec));
                    });
                    $('#modalrwytkecamatanid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")});
                    $('#modalrwytkecamatanid').val(riwayatkerjakecamatanid);
                    $('#modalrwytkecamatanid').trigger('change');
                }
            });
        }).trigger('change');

        $('#modalrwytkecamatanid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")}).on('change', function() {
            var url = "{{ route('naker.kelurahan', ':parentid') }}";
            url = url.replace(':parentid', ($('#modalrwytkecamatanid').val() == "" || $('#modalrwytkecamatanid').val() == null ? "-1" : $('#modalrwytkecamatanid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#modalrwytkelurahanid').empty();
                    $('#modalrwytkelurahanid').append($("<option></option>").attr("value", "").text("-- Pilih Kelurahan --"));
                    $.each(data.data, function(key, value) {
                        $('#modalrwytkelurahanid').append($("<option></option>").attr("value", value.kelurahanid).text(value.kodekel + ' ' + value.namakel));
                    });
                    $('#modalrwytkelurahanid').select2({dropdownParent: $("#modalFormRiwayatKerja .modal-content")});
                    $('#modalrwytkelurahanid').val(riwayatkerjakelurahanid);
                    $('#modalrwytkelurahanid').trigger('change');
                }
            });
        })/*.trigger('change');*/

        $('#nakerForm').on('submit', function() {
            $('#jenisnik').prop('disabled', false);
        });
    });

    function goToStep(step, currentStep){
        if(step > currentStep){
            let isValid = validate(currentStep);
            if(!isValid) {
                swal("Validasi", "Pengisian data belum tepat", "error"); 
                return;
            }
        }

        $("#step"+currentStep).hide();
        $("#step"+step).fadeIn("slow");

        $("#badge"+currentStep).removeClass("badge-active");

        $("#badge"+step).addClass("badge-active");
        $("#containerBadge"+step).addClass("d-flex");

        //Total Step in View
        let totalStep = 2;

        for (var i = (step+1); i <= totalStep; i++) {
            $("#containerBadge"+i).removeClass("d-flex");
            $("#containerBadge"+i).hide();
        }
    }

    function setJenisNik(){
        let isWni = $('input[name="iswni"]:checked').val();

        $('#jenisnik').select2();
        if(isWni==1) {
            $('#jenisnik').val("{{enum::JENISNIK_KTP}}");
            $('#negaraid').prop('disabled', true);
        }
        else {
            $('#jenisnik').val("{{enum::JENISNIK_KITAS}}");
            $('#negaraid').prop('disabled', false);
        }
        $('#jenisnik').trigger('change');
    }

    $('input[type=radio][name=iswni]').change(function() {
        setJenisNik();
    });

    function setMasaBerlakuRule(){
        let isExpired = $('input[name="modalsrtisexpired"]:checked').val();

        if(isExpired==1) {
            $('#modalsrtbulanexp').prop('disabled', false);
            $('#modalsrttahunexp').prop('disabled', false);
        }
        else {
            $('#modalsrtbulanexp').prop('disabled', true);
            $('#modalsrttahunexp').prop('disabled', true);
        }
    }

    $('input[type=radio][name=modalsrtisexpired]').change(function() {
        setMasaBerlakuRule();
    });

    function setAtasNama() {
      // var namalengkap = $('#namalengkap').val();
      // $('#atasnama').val(namalengkap);
    }

    function validate(step) {
        var isValid = true;

        if(step == 1){
            const fieldsObject = {
                namalengkapValid : $("#namalengkap").valid(), 
                negaraidValid : $("#negaraid").valid(),
                jenisnikValid : $("#jenisnik").valid(),
                nikValid : $("#nik").valid(),
                tempatlahirValid : $("#tempatlahir").valid(),
                tgllahirValid : $("#tgllahir").valid(),
                jeniskelaminValid : $("#jeniskelamin").valid(),
                alamatValid : $("#alamat").valid(),
                provinsiidValid : $("#provinsiid").valid(),
                kotaidValid : $("#kotaid").valid(),
                kecamatanidValid : $("#kecamatanid").valid(),
                kelurahanidValid : $("#kelurahanid").valid(),
                telpValid : $("#telp").valid(),
                emailValid : $("#email").valid(),
                agamaValid : $("#agama").valid(),
                statusnikahValid : $("#statusnikah").valid(),
                // ptkpidValid : $("#ptkpid").valid(),
                // npwpValid : $("#npwp").valid(),
                // bankValid : $("#bank").valid(),
                // norekValid : $("#norek").valid(),
                // atasnamaValid : $("#atasnama").valid(),
                nobpjsValid : $("#nobpjs").valid(),
            }
            
            for (var key in fieldsObject) {
                if(fieldsObject[key]===false) isValid = false;
            }
        }

        return isValid;
    }

    function addRiwayatKerja(){
        resetFormRiwayatKerja();
        $('#titleRiwayatKerja').text('Tambah Riwayat Kerja');
        $('#modalFormRiwayatKerja').modal('show');
    }

    function addSertifikat(){
        resetFormSertifikat();
        $('#titleSertifikat').text('Tambah Sertifikat');
        $('#modalFormSertifikat').modal('show');
    }

    function addRiwayatPendidikan(){
        resetFormRiwayatPendidikan();
        $('#titleRiwayatPendidikan').text('Tambah Riwayat Pendidikan');
        $('#modalFormRiwayatPendidikan').modal('show');
    }

    $('#modalrwytiscurrent').click(function(){
        setMasaKerjaRule($(this).is(':checked'));
    });

    function setMasaKerjaRule(isChecked){
       if(isChecked){
            // $('#modalrwyttglmulai').prop('disabled', true);
            $('#modalrwyttglsampai').prop('disabled', true);
        } else {
            // $('#modalrwyttglmulai').prop('disabled', false);
            $('#modalrwyttglsampai').prop('disabled', false);
        } 
    }

    function validateRiwayatKerja(){
        var isValid = true;

        if ($('#riwayatKerjaForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data Riwayat Kerja belum tepat", "error"); 
            return;
        }else{
            saveRiwayatKerjaArray();
            $('#modalFormRiwayatKerja').modal('hide');
            return;
        }
    }

    function validateSertifikat(){
        var isValid = true;

        if ($('#sertifikatForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data Sertifikat belum tepat", "error"); 
            return;
        }else{
            saveSertifikatArray();
            $('#modalFormSertifikat').modal('hide');
            return;
        }
    }

    function validateRiwayatPendidikan(){
        var isValid = true;

        if ($('#riwayatPendidikanForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data Riwayat Pendidikan belum tepat", "error"); 
            return;
        }else{
            saveRiwayatPendidikanArray();
            $('#modalFormRiwayatPendidikan').modal('hide');
            return;
        }
    }

    function saveRiwayatKerjaArray(){
        let new_row_number = row_number_riwayat - 1;

        let modalrwytstatuspekerjaan = $('#modalrwytstatuspekerjaan').val();
        let modalrwytperusahaanid = $('#modalrwytperusahaanid').val();
        let modalrwytprovinsiid = $('#modalrwytprovinsiid').val();
        let modalrwytkotaid = $('#modalrwytkotaid').val();
        let modalrwytkecamatanid = $('#modalrwytkecamatanid').val();
        let modalrwytkelurahanid = $('#modalrwytkelurahanid').val();
        let modalrwytgolid = $('#modalrwytgolid').val();
        let modalrwytlevel = $('#modalrwytlevel').val();
        let modalrwytketpekerjaan = $('#modalrwytketpekerjaan').val();
        let modalrwytdivisi = $('#modalrwytdivisi').val();
        let modalrwytiscurrent = $('#modalrwytiscurrent').is(":checked") ? "1" : "0";
        let modalrwyttglmulai = $('#modalrwyttglmulai').val();
        let modalrwyttglsampai = $('#modalrwyttglsampai').val();

        let perusahaannama = $("#modalrwytperusahaanid").find(":selected").data("nama");
        let lamabekerja = "";
        if(modalrwytiscurrent==0 && modalrwyttglmulai!="" && modalrwyttglsampai!=""){
            var momenttglmulai = moment(modalrwyttglmulai, 'YYYY-MM-DD');
            var momenttglsampai = moment(modalrwyttglsampai, 'YYYY-MM-DD');  

            var months = momenttglsampai.diff(momenttglmulai, 'months');
            if(months==0){
                //Hari
                lamabekerja = momenttglsampai.diff(momenttglmulai, 'days')+" Hari";
            }else if(months<12){
                //Bulan
                lamabekerja = months+" Bulan";
            }else{
                //Tahun
                lamabekerja = momenttglsampai.diff(momenttglmulai, 'years')+" Tahun";
            }
        }

        if($('#modalrwytidx').val()==""){
            var html = '';
            html += '<div class="p-2 border" id="riwayatkerja'+new_row_number+'">';
            //HIIDEN FIELDS
            html += '<input type="hidden" id="indexriwayatkerja'+new_row_number+'" name="riwayatkerja['+new_row_number+'][indexriwayatkerja]" value="'+new_row_number+'">';
            html += '<input type="hidden" id="statuspekerjaan'+new_row_number+'" name="riwayatkerja['+new_row_number+'][statuspekerjaan]" value="'+modalrwytstatuspekerjaan+'">';
            html += '<input type="hidden" id="perusahaanid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][perusahaanid]" value="'+modalrwytperusahaanid+'">';
            html += '<input type="hidden" id="provinsiid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][provinsiid]" value="'+modalrwytprovinsiid+'">';
            html += '<input type="hidden" id="kotaid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][kotaid]" value="'+modalrwytkotaid+'">';
            html += '<input type="hidden" id="kecamatanid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][kecamatanid]" value="'+modalrwytkecamatanid+'">';
            html += '<input type="hidden" id="kelurahanid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][kelurahanid]" value="'+modalrwytkelurahanid+'">';
            html += '<input type="hidden" id="golid'+new_row_number+'" name="riwayatkerja['+new_row_number+'][golid]" value="'+modalrwytgolid+'">';
            html += '<input type="hidden" id="level'+new_row_number+'" name="riwayatkerja['+new_row_number+'][level]" value="'+modalrwytlevel+'">';
            html += '<input type="hidden" id="ketpekerjaan'+new_row_number+'" name="riwayatkerja['+new_row_number+'][ketpekerjaan]" value="'+modalrwytketpekerjaan+'">';
            html += '<input type="hidden" id="divisi'+new_row_number+'" name="riwayatkerja['+new_row_number+'][divisi]" value="'+modalrwytdivisi+'">';
            html += '<input type="hidden" id="iscurrent'+new_row_number+'" name="riwayatkerja['+new_row_number+'][iscurrent]" value="'+modalrwytiscurrent+'">';
            html += '<input type="hidden" id="tglmulai'+new_row_number+'" name="riwayatkerja['+new_row_number+'][tglmulai]" value="'+modalrwyttglmulai+'">';
            html += '<input type="hidden" id="tglsampai'+new_row_number+'" name="riwayatkerja['+new_row_number+'][tglsampai]" value="'+modalrwyttglsampai+'">';
            html += '<input type="hidden" id="createdby'+new_row_number+'" name="riwayatkerja['+new_row_number+'][createdby]" value="">';
            html += '<input type="hidden" id="perusahaannama'+new_row_number+'" name="riwayatkerja['+new_row_number+'][perusahaannama]" value="'+perusahaannama+'">';
            html += '<input type="hidden" id="lamabekerja'+new_row_number+'" name="riwayatkerja['+new_row_number+'][lamabekerja]" value="'+lamabekerja+'">';
            //=============
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b id="labelperusahaannama'+new_row_number+'">'+perusahaannama+'</b></h5></div>';
            html += '<div class="col-md-4">'
            html += '<button onclick="javascript:hapusRiwayatKerja('+new_row_number+');" type="button" id="btnaddsubgolpokok" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editRiwayatKerja('+new_row_number+');" type="button" id="btnaddsubgolpokok" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span id="labellamabekerja'+new_row_number+'">'+lamabekerja+'</span><h5 id="labelketpekerjaan'+new_row_number+'">'+modalrwytketpekerjaan+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#riwayatKerjaListContainer").append(html);

            row_number_riwayat++;
        }else{
            let modalrwytidx = $('#modalrwytidx').val();

            $("#statuspekerjaan"+modalrwytidx).val(modalrwytstatuspekerjaan);
            $("#perusahaanid"+modalrwytidx).val(modalrwytperusahaanid);
            $("#provinsiid"+modalrwytidx).val(modalrwytprovinsiid);
            $("#kotaid"+modalrwytidx).val(modalrwytkotaid);
            $("#kecamatanid"+modalrwytidx).val(modalrwytkecamatanid);
            $("#kelurahanid"+modalrwytidx).val(modalrwytkelurahanid);
            $("#golid"+modalrwytidx).val(modalrwytgolid);
            $("#level"+modalrwytidx).val(modalrwytlevel);
            $("#ketpekerjaan"+modalrwytidx).val(modalrwytketpekerjaan);
            $("#divisi"+modalrwytidx).val(modalrwytdivisi);
            $("#iscurrent"+modalrwytidx).val(modalrwytiscurrent);
            $("#tglmulai"+modalrwytidx).val(modalrwyttglmulai);
            $("#tglsampai"+modalrwytidx).val(modalrwyttglsampai);

            $("#perusahaannama"+modalrwytidx).val(perusahaannama);
            $("#lamabekerja"+modalrwytidx).val(lamabekerja);

            $("#labelperusahaannama"+modalrwytidx).text(perusahaannama);
            $("#labellamabekerja"+modalrwytidx).text(lamabekerja);
            $("#labelketpekerjaan"+modalrwytidx).text(modalrwytketpekerjaan);
        }
    }

    function saveSertifikatArray(){
        let new_row_number = row_number_sertifikat - 1;

        let modalsrtnama = $('#modalsrtnama').val();
        let modalsrtpemberi = $('#modalsrtpemberi').val();
        let modalsrtno = $('#modalsrtno').val();
        let modalsrtbulan = $('#modalsrtbulan').val();
        let modalsrttahun = $('#modalsrttahun').val();
        let modalsrtisexpired = $('input[name="modalsrtisexpired"]:checked').val();
        let modalsrtbulanexp = $('#modalsrtbulanexp').val();
        let modalsrttahunexp = $('#modalsrttahunexp').val();
        let modalsrturl = $('#modalsrturl').val();
        let modalsrtbidangkeahlian = $('#modalsrtbidangkeahlian').val();

        let bulannama = $("#modalsrtbulan").find(":selected").text()+' '+$('#modalsrttahun').find(":selected").text();
        let bulanexpnama = ($('input[name="modalsrtisexpired"]:checked').val() == "1" ? $("#modalsrtbulanexp").find(":selected").text()+' '+$('#modalsrttahunexp').find(":selected").text() : "Sekarang");

        if($('#modalsrtidx').val()==""){
            var html = '';
            html += '<div class="p-2 border" id="sertifikat'+new_row_number+'">';
            //HIIDEN FIELDS
            html += '<input type="hidden" id="indexsertifikat'+new_row_number+'" name="sertifikat['+new_row_number+'][indexsertifikat]" value="'+new_row_number+'">';
            html += '<input type="hidden" id="nama'+new_row_number+'" name="sertifikat['+new_row_number+'][nama]" value="'+modalsrtnama+'">';
            html += '<input type="hidden" id="pemberi'+new_row_number+'" name="sertifikat['+new_row_number+'][pemberi]" value="'+modalsrtpemberi+'">';
            html += '<input type="hidden" id="no'+new_row_number+'" name="sertifikat['+new_row_number+'][no]" value="'+modalsrtno+'">';
            html += '<input type="hidden" id="bulan'+new_row_number+'" name="sertifikat['+new_row_number+'][bulan]" value="'+modalsrtbulan+'">';
            html += '<input type="hidden" id="tahun'+new_row_number+'" name="sertifikat['+new_row_number+'][tahun]" value="'+modalsrttahun+'">';
            html += '<input type="hidden" id="isexpired'+new_row_number+'" name="sertifikat['+new_row_number+'][isexpired]" value="'+modalsrtisexpired+'">';
            html += '<input type="hidden" id="bulanexp'+new_row_number+'" name="sertifikat['+new_row_number+'][bulanexp]" value="'+modalsrtbulanexp+'">';
            html += '<input type="hidden" id="tahunexp'+new_row_number+'" name="sertifikat['+new_row_number+'][tahunexp]" value="'+modalsrttahunexp+'">';
            html += '<input type="hidden" id="url'+new_row_number+'" name="sertifikat['+new_row_number+'][url]" value="'+modalsrturl+'">';
            html += '<input type="hidden" id="bulannama'+new_row_number+'" name="sertifikat['+new_row_number+'][bulannama]" value="'+bulannama+'">';
            html += '<input type="hidden" id="bulanexpnama'+new_row_number+'" name="sertifikat['+new_row_number+'][bulanexpnama]" value="'+bulanexpnama+'">';
            html += '<input type="hidden" id="bidangkeahlian'+new_row_number+'" name="sertifikat['+new_row_number+'][bidangkeahlian]" value="'+modalsrtbidangkeahlian+'">';
            //=============
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b id="labelnama'+new_row_number+'">'+modalsrtnama+'</b></h5></div>';
            html += '<div class="col-md-4">';
            html += '<button onclick="javascript:hapusSertifikat('+new_row_number+');" type="button" id="btndltsertifikat" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editSertifikat('+new_row_number+');" type="button" id="btneditsertifikat" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span id="labelmasasertifikat'+new_row_number+'">'+bulannama+' s/d '+bulanexpnama+'</span><h5 id="labelpemberi'+new_row_number+'">'+modalsrtpemberi+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#sertifikatListContainer").append(html);

            row_number_sertifikat++;
        }else{
            let modalsrtidx = $('#modalsrtidx').val();

            $("#nama"+modalsrtidx).val(modalsrtnama);
            $("#pemberi"+modalsrtidx).val(modalsrtpemberi);
            $("#no"+modalsrtidx).val(modalsrtno);
            $("#bulan"+modalsrtidx).val(modalsrtbulan);
            $("#tahun"+modalsrtidx).val(modalsrttahun);
            $("#isexpired"+modalsrtidx).val(modalsrtisexpired);
            $("#bulanexp"+modalsrtidx).val(modalsrtbulanexp);
            $("#tahunexp"+modalsrtidx).val(modalsrttahunexp);
            $("#url"+modalsrtidx).val(modalsrturl);
            $("#bidangkeahlian"+modalsrtidx).val(modalsrtbidangkeahlian);

            $("#bulannama"+modalsrtidx).val(bulannama);
            $("#bulanexpnama"+modalsrtidx).val(bulanexpnama);

            $("#labelnama"+modalsrtidx).text(modalsrtnama);
            $("#labelmasasertifikat"+modalsrtidx).text(bulannama+' s/d '+bulanexpnama);
            $("#labelpemberi"+modalsrtidx).text(modalsrtpemberi);
        }
    }

    function saveRiwayatPendidikanArray(){
        let new_row_number = row_number_riwayatpendidikan - 1;

        let modalrwytpddnamainstitusi = $('#modalrwytpddnamainstitusi').val();
        let modalrwytpddjenjang = $('#modalrwytpddjenjang').val();
        let modalrwytpddprogramstudi = $('#modalrwytpddprogramstudi').val();
        let modalrwytpddbulanmasuk = $('#modalrwytpddbulanmasuk').val();
        let modalrwytpddtahunmasuk = $('#modalrwytpddtahunmasuk').val();
        let modalrwytpddbulanlulus = $('#modalrwytpddbulanlulus').val();
        let modalrwytpddtahunlulus = $('#modalrwytpddtahunlulus').val();
        let modalrwytpddnilaiakhir = $('#modalrwytpddnilaiakhir').val();

        let jenjangnama = $("#modalrwytpddjenjang").find(":selected").text();
        let bulanmasuknama = $("#modalrwytpddbulanmasuk").find(":selected").text()+' '+$('#modalrwytpddtahunmasuk').find(":selected").text();
        let bulanlulusnama = $("#modalrwytpddbulanlulus").find(":selected").text()+' '+$('#modalrwytpddtahunlulus').find(":selected").text();

        if($('#modalrwytpddidx').val()==""){
            var html = '';
            html += '<div class="p-2 border" id="riwayatpendidikan'+new_row_number+'">';
            //HIIDEN FIELDS
            html += '<input type="hidden" id="indexriwayatpendidikan'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][indexriwayatpendidikan]" value="'+new_row_number+'">';
            html += '<input type="hidden" id="namainstitusi'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][namainstitusi]" value="'+modalrwytpddnamainstitusi+'">';
            html += '<input type="hidden" id="jenjang'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][jenjang]" value="'+modalrwytpddjenjang+'">';
            html += '<input type="hidden" id="programstudi'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][programstudi]" value="'+modalrwytpddprogramstudi+'">';
            html += '<input type="hidden" id="bulanmasuk'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][bulanmasuk]" value="'+modalrwytpddbulanmasuk+'">';
            html += '<input type="hidden" id="tahunmasuk'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][tahunmasuk]" value="'+modalrwytpddtahunmasuk+'">';
            html += '<input type="hidden" id="bulanlulus'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][bulanlulus]" value="'+modalrwytpddbulanlulus+'">';
            html += '<input type="hidden" id="tahunlulus'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][tahunlulus]" value="'+modalrwytpddtahunlulus+'">';
            html += '<input type="hidden" id="nilaiakhir'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][nilaiakhir]" value="'+modalrwytpddnilaiakhir+'">';
            html += '<input type="hidden" id="jenjangnama'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][jenjangnama]" value="'+jenjangnama+'">';
            html += '<input type="hidden" id="bulanmasuknama'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][bulanmasuknama]" value="'+bulanmasuknama+'">';
            html += '<input type="hidden" id="bulanlulusnama'+new_row_number+'" name="riwayatpendidikan['+new_row_number+'][bulanlulusnama]" value="'+bulanlulusnama+'">';
            //=============
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b id="labelnamainstitusi'+new_row_number+'">'+modalrwytpddnamainstitusi+'</b></h5></div>';
            html += '<div class="col-md-4">';
            html += '<button onclick="javascript:hapusRiwayatPendidikan('+new_row_number+');" type="button" id="btndltriwayatpendidikan" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editRiwayatPendidikan('+new_row_number+');" type="button" id="btneditriwayatpendidikan" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span id="labelmasariwayatpendidikan'+new_row_number+'">'+bulanmasuknama+' s/d '+bulanlulusnama+'</span><h5 id="labeljenjang'+new_row_number+'">'+jenjangnama+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#riwayatPendidikanListContainer").append(html);

            row_number_riwayatpendidikan++;
        }else{
            let modalrwytpddidx = $('#modalrwytpddidx').val();

            $("#namainstitusi"+modalrwytpddidx).val(modalrwytpddnamainstitusi);
            $("#jenjang"+modalrwytpddidx).val(modalrwytpddjenjang);
            $("#programstudi"+modalrwytpddidx).val(modalrwytpddprogramstudi);
            $("#bulanmasuk"+modalrwytpddidx).val(modalrwytpddbulanmasuk);
            $("#tahunmasuk"+modalrwytpddidx).val(modalrwytpddtahunmasuk);
            $("#bulanlulus"+modalrwytpddidx).val(modalrwytpddbulanlulus);
            $("#tahunlulus"+modalrwytpddidx).val(modalrwytpddtahunlulus);
            $("#nilaiakhir"+modalrwytpddidx).val(modalrwytpddnilaiakhir);

            $("#jenjangnama"+modalrwytpddidx).val(jenjangnama);
            $("#bulanmasuknama"+modalrwytpddidx).val(bulanmasuknama);
            $("#bulanlulusnama"+modalrwytpddidx).val(bulanlulusnama);

            $("#labelnamainstitusi"+modalrwytpddidx).text(modalrwytpddnamainstitusi);
            $("#labelmasariwayatpendidikan"+modalrwytpddidx).text(bulanmasuknama+' s/d '+bulanlulusnama);
            $("#labeljenjang"+modalrwytpddidx).text(jenjangnama);
        }
    }

    function hapusRiwayatKerja(idx){
        swal({   
            title: "Apakah anda yakin akan menghapus Riwayat Pekerjaan ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            $("#riwayatkerja"+idx).remove();
        });
    }

    function hapusSertifikat(idx){
        swal({   
            title: "Apakah anda yakin akan menghapus Sertifikat ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            $("#sertifikat"+idx).remove();
        });
    }

    function hapusRiwayatPendidikan(idx){
        swal({   
            title: "Apakah anda yakin akan menghapus Riwayat Pendidikan ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            $("#riwayatpendidikan"+idx).remove();
        });
    }

    function editRiwayatKerja(idx){
        // resetFormRiwayatKerja();

        let riwayatkerja_statuspekerjaan = $('#statuspekerjaan'+idx).val();
        let riwayatkerja_perusahaanid = $('#perusahaanid'+idx).val();
        let riwayatkerja_provinsiid = $('#provinsiid'+idx).val();
        let riwayatkerja_kotaid = $('#kotaid'+idx).val();
        let riwayatkerja_kecamatanid = $('#kecamatanid'+idx).val();
        let riwayatkerja_kelurahanid = $('#kelurahanid'+idx).val();
        let riwayatkerja_golid = $('#golid'+idx).val();
        let riwayatkerja_level = $('#level'+idx).val();
        let riwayatkerja_ketpekerjaan = $('#ketpekerjaan'+idx).val();
        let riwayatkerja_divisi = $('#divisi'+idx).val();
        let riwayatkerja_iscurrent = $('#iscurrent'+idx).val();
        let riwayatkerja_tglmulai = $('#tglmulai'+idx).val();
        let riwayatkerja_tglsampai = $('#tglsampai'+idx).val();

        
        riwayatkerjakotaid = riwayatkerja_kotaid;
        riwayatkerjakecamatanid = riwayatkerja_kecamatanid;
        riwayatkerjakelurahanid = riwayatkerja_kelurahanid;

        $('#modalrwytidx').val(idx);

        $('#modalrwytstatuspekerjaan').val(riwayatkerja_statuspekerjaan);
        // $('#modalrwytperusahaanid').val(riwayatkerja_perusahaanid);
        $("#modalrwytperusahaanid").val(riwayatkerja_perusahaanid).trigger('change.select2');
        $('#modalrwytprovinsiid').val(riwayatkerja_provinsiid);
        $('#modalrwytgolid').val(riwayatkerja_golid);
        $('#modalrwytlevel').val(riwayatkerja_level);
        $('#modalrwytketpekerjaan').val(riwayatkerja_ketpekerjaan);
        $('#modalrwytdivisi').val(riwayatkerja_divisi);
        $('#modalrwytiscurrent').prop('checked', (riwayatkerja_iscurrent=="1" ? true : false));
        $('#modalrwyttglmulai').val(riwayatkerja_tglmulai);
        $('#modalrwyttglsampai').val(riwayatkerja_tglsampai);

        $('#modalrwytstatuspekerjaan').trigger('change');
        // $('#modalrwytperusahaanid').trigger('change');
        $('#modalrwytprovinsiid').trigger('change');
        $('#modalrwytgolid').trigger('change');
        $('#modalrwytlevel').trigger('change');

        setMasaKerjaRule((riwayatkerja_iscurrent=="1" ? true : false));

        $('#titleRiwayatKerja').text('Ubah Riwayat Kerja');
        $('#modalFormRiwayatKerja').modal('show');
    }

    function editSertifikat(idx){
        // resetFormSertifikat();

        let sertifikat_nama = $('#nama'+idx).val();
        let sertifikat_pemberi = $('#pemberi'+idx).val();
        let sertifikat_no = $('#no'+idx).val();
        let sertifikat_bulan = $('#bulan'+idx).val();
        let sertifikat_tahun = $('#tahun'+idx).val();
        let sertifikat_isexpired = $('#isexpired'+idx).val();
        let sertifikat_bulanexp = $('#bulanexp'+idx).val();
        let sertifikat_tahunexp = $('#tahunexp'+idx).val();
        let sertifikat_url = $('#url'+idx).val();
        let sertifikat_bidangkeahlian = $('#bidangkeahlian'+idx).val();

        $('#modalsrtidx').val(idx);

        $('#modalsrtnama').val(sertifikat_nama);
        $('#modalsrtpemberi').val(sertifikat_pemberi);
        $('#modalsrtno').val(sertifikat_no);
        $('#modalsrtbulan').val(sertifikat_bulan);
        $('#modalsrttahun').val(sertifikat_tahun);
        $('#modalsrtisexpired1').prop('checked', (sertifikat_isexpired=="1" ? true : false));
        $('#modalsrtisexpired0').prop('checked', (sertifikat_isexpired=="0" ? true : false));
        $('#modalsrtbulanexp').val(sertifikat_bulanexp);
        $('#modalsrttahunexp').val(sertifikat_tahunexp);
        $('#modalsrturl').val(sertifikat_url);
        $('#modalsrtbidangkeahlian').val(sertifikat_bidangkeahlian);

        $('#modalsrtbulan').trigger('change');
        $('#modalsrttahun').trigger('change');
        $('#modalsrtbulanexp').trigger('change');
        $('#modalsrttahunexp').trigger('change');

        setMasaKerjaRule();

        $('#titleSertifikat').text('Ubah Sertifikat');
        $('#modalFormSertifikat').modal('show');
    }

    function editRiwayatPendidikan(idx){
        // resetFormRiwayatPendidikan();

        let riwayatpendidikan_namainstitusi = $('#namainstitusi'+idx).val();
        let riwayatpendidikan_jenjang = $('#jenjang'+idx).val();
        let riwayatpendidikan_programstudi = $('#programstudi'+idx).val();
        let riwayatpendidikan_bulanmasuk = $('#bulanmasuk'+idx).val();
        let riwayatpendidikan_tahunmasuk = $('#tahunmasuk'+idx).val();
        let riwayatpendidikan_bulanlulus = $('#bulanlulus'+idx).val();
        let riwayatpendidikan_tahunlulus = $('#tahunlulus'+idx).val();
        let riwayatpendidikan_nilaiakhir = $('#nilaiakhir'+idx).val();

        $('#modalrwytpddidx').val(idx);

        $('#modalrwytpddnamainstitusi').val(riwayatpendidikan_namainstitusi);
        $('#modalrwytpddjenjang').val(riwayatpendidikan_jenjang);
        $('#modalrwytpddprogramstudi').val(riwayatpendidikan_programstudi);
        $('#modalrwytpddbulanmasuk').val(riwayatpendidikan_bulanmasuk);
        $('#modalrwytpddtahunmasuk').val(riwayatpendidikan_tahunmasuk);
        $('#modalrwytpddbulanlulus').val(riwayatpendidikan_bulanlulus);
        $('#modalrwytpddtahunlulus').val(riwayatpendidikan_tahunlulus);
        $('#modalrwytpddnilaiakhir').val(riwayatpendidikan_nilaiakhir);

        $('#modalrwytpddjenjang').trigger('change');
        $('#modalrwytpddbulanmasuk').trigger('change');
        $('#modalrwytpddtahunmasuk').trigger('change');
        $('#modalrwytpddbulanlulus').trigger('change');
        $('#modalrwytpddtahunlulus').trigger('change');

        $('#titleRiwayatPendidikan').text('Ubah Riwayat Pendidikan');
        $('#modalFormRiwayatPendidikan').modal('show');
    }

    function resetFormRiwayatKerja(){
        $('#riwayatKerjaForm').trigger("reset");

        $('#modalrwytidx').val("");

        $('#modalrwytstatuspekerjaan').trigger('change');
        // $('#modalrwytperusahaanid').trigger('change');
        $("#modalrwytperusahaanid").val("").trigger('change.select2');
        $('#modalrwytprovinsiid').trigger('change');
        $('#modalrwytkotaid').trigger('change');
        $('#modalrwytkecamatanid').trigger('change');
        $('#modalrwytkelurahanid').trigger('change');
        $('#modalrwytgolid').trigger('change');
        $('#modalrwytlevel').trigger('change');

        riwayatkerjakotaid = "";
        riwayatkerjakecamatanid = "";
        riwayatkerjakelurahanid = "";

        $validatorRiwayatKerja.resetForm();
        setMasaKerjaRule($('#modalrwytiscurrent').is(':checked'));
    }

    function resetFormSertifikat(){
        $('#sertifikatForm').trigger("reset");

        $('#modalsrtidx').val("");

        $('#modalsrtbulan').trigger('change');
        $('#modalsrttahun').trigger('change');
        $('#modalsrtbulanexp').trigger('change');
        $('#modalsrttahunexp').trigger('change');

        $validatorSertifikat.resetForm();
        setMasaBerlakuRule();
    }

    function resetFormRiwayatPendidikan(){
        $('#riwayatPendidikanForm').trigger("reset");

        $('#modalrwytpddidx').val("");

        $('#modalrwytpddjenjang').trigger('change');
        $('#modalrwytpddbulanmasuk').trigger('change');
        $('#modalrwytpddtahunmasuk').trigger('change');
        $('#modalrwytpddbulanlulus').trigger('change');
        $('#modalrwytpddtahunlulus').trigger('change');

        $validatorRiwayatPendidikan.resetForm();
    }

    $( "#modalrwytpddnamainstitusi" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "{{ route('naker.searchriwayatpendidikan') }}",
                dataType: "json",
                data: {
                    term: request.term,
                    type: "1"
                },
                success: function( data ) {
                    response( data );
                }
            } );
        },
        minLength: 2,
        appendTo: "#modalFormRiwayatPendidikan"
    });

    $( "#modalrwytpddprogramstudi" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "{{ route('naker.searchriwayatpendidikan') }}",
                dataType: "json",
                data: {
                    term: request.term,
                    type: "2"
                },
                success: function( data ) {
                    response( data );
                }
            } );
        },
        minLength: 2,
        appendTo: "#modalFormRiwayatPendidikan"
    });

    $( "#modalsrtbidangkeahlian" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "{{ route('naker.searchsertifikat') }}",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response( data );
                }
            } );
        },
        minLength: 2,
        appendTo: "#modalFormSertifikat"
    });

    function validateAll(){
        if($('#nakerForm').valid()===false){
            swal("Validasi", "Pengisian data pribadi belum tepat, silahkan cek kembali", "error"); 
            $('#nakerTab a[href="#nakerdata"]').tab('show');
            return false;
        }else{
            return true;
        }
    }

    @if(!$isshow)
    @endif
</script>
@endsection
