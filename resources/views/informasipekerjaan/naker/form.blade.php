<?php
use App\enumVar as enum;
use Carbon\Carbon;

$errorsNaker = [];
$errorsRiwayatKerja = [];
$errorsSertifikat = [];
$errorsRiwayatPendidikan = [];
$errorsStatusnaker = [];
//Memisahkan error array
if (count($errors) > 0)
    foreach ($errors->messages() as $key => $value) {
        $keyArr = explode(".",$key);
        if($keyArr[0]==="riwayatkerja" && isset($keyArr[1])){
            $indexRiwayat = $keyArr[1];
            $urutanRiwayat = array_search($indexRiwayat, array_column(old('riwayatkerja'), 'indexriwayatkerja'));
            foreach ($value as $errField) {
                $errorsRiwayatKerja[$urutanRiwayat][] = $errField;
            }
        }else if($keyArr[0]==="sertifikat" && isset($keyArr[1])){
            $indexSertifikat = $keyArr[1];
            $urutanSertifikat = array_search($indexSertifikat, array_column(old('sertifikat'), 'indexsertifikat'));
            foreach ($value as $errField) {
                $errorsSertifikat[$urutanSertifikat][] = $errField;
            }
        }else if($keyArr[0]==="riwayatpendidikan" && isset($keyArr[1])){
            $indexRiwayatPendidikan = $keyArr[1];
            $urutanRiwayatPendidikan = array_search($indexRiwayatPendidikan, array_column(old('riwayatpendidikan'), 'indexriwayatpendidikan'));
            foreach ($value as $errField) {
                $errorsRiwayatPendidikan[$urutanRiwayatPendidikan][] = $errField;
            }
        }else if($keyArr[0]==="statusnaker" && isset($keyArr[1])){
            $indexStatusnaker = $keyArr[1];
            $urutanStatusnaker = array_search($indexStatusnaker, array_column(old('statusnaker'), 'indexstatusnaker'));
            foreach ($value as $errField) {
                $errorsStatusnaker[$urutanStatusnaker][] = $errField;
            }
        }else{
            foreach ($value as $errField) {
                $errorsNaker[] = $errField;
            }
        }
    }
?>
@extends('layouts.master')

@section('content')
<style>
    input[disabled]{
      background-color:#ddd !important;
    }

    /*.badge {
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
    }*/

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
                                    @foreach ($liststatus as $item)
                                    <option value="{{$item['statuspekerjaan']}}">{{ $item['statuspekerjaanvw'] }}</option>
                                    @endforeach
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
                                    @foreach ($listlevelpekerjaan as $item)
                                    <option value="{{$item['levelpekerjaan']}}">{{ $item['levelpekerjaanvw'] }}</option>
                                    @endforeach
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
                                <input id="modalsrtno" type="text" class="form-control" name="modalsrtno" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalsrtbidangkeahlian" class="col-md-3 col-form-label text-md-left">{{ __('Bidang Keahlian') }}</label>
                            <div class="col-md-9">
                                <input id="modalsrtbidangkeahlian" type="text" class="form-control" name="modalsrtbidangkeahlian" placeholder="Cari Bidang Keahlian...">
                                <div class="card">
                                  <div class="card-body" id="bidangkeahlianListContainer">
                                  </div>
                                </div>
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
                                    @foreach ($listbulan as $item)
                                    <option value="{{$item['bulan']}}">{{ $item['bulanvw'] }}</option>
                                    @endforeach
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
                                    @foreach ($listbulan as $item)
                                    <option value="{{$item['bulan']}}">{{ $item['bulanvw'] }}</option>
                                    @endforeach
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
                                    @foreach ($listjenjang as $item)
                                    <option value="{{$item['jenjangpendidikan']}}">{{ $item['jenjangpendidikanvw'] }}</option>
                                    @endforeach
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
                                    @foreach ($listbulan as $item)
                                    <option value="{{$item['bulan']}}">{{ $item['bulanvw'] }}</option>
                                    @endforeach
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
                                    @foreach ($listbulan as $item)
                                    <option value="{{$item['bulan']}}">{{ $item['bulanvw'] }}</option>
                                    @endforeach
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
<div id="modalFormStatusnaker" class="modal fade" role="dialog" aria-labelledby="titleStatusnaker" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleStatusnaker">Tambah Status Tenaga Kerja</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <form id="statusnakerForm">
                <input type="hidden" name="modalstatusnakeridx" id="modalstatusnakeridx">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="modalstatusnakerstatus" class="col-md-3 col-form-label text-md-left">{{ __('Status *') }}</label>
                            <div class="col-md-9">
                                <select id="modalstatusnakerstatus" class="custom-select-statusnaker form-control" name='modalstatusnakerstatus' required @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($liststatusnaker as $item)
                                    <option value="{{$item['statusnaker']}}">{{ $item['statusnakervw'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalstatusnakernodokumen" class="col-md-3 col-form-label text-md-left">{{ __('No. Dokumen') }}</label>

                            <div class="col-md-9">
                                <input id="modalstatusnakernodokumen" type="text" class="form-control" name="modalstatusnakernodokumen" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalstatusnakernamadokumen" class="col-md-3 col-form-label text-md-left">{{ __('Nama Dokumen') }}</label>

                            <div class="col-md-9">
                                <input id="modalstatusnakernamadokumen" type="text" class="form-control" name="modalstatusnakernamadokumen" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalstatusnakertglmulai" class="col-md-3 col-form-label text-md-left">{{ __('Tanggal Mulai') }} :</label>
                            <div class="col-md-3">
                                <input class="form-control dp-text" type="date" name="modalstatusnakertglmulai" id="modalstatusnakertglmulai" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalstatusnakertglsampai" class="col-md-3 col-form-label text-md-left">{{ __('Tanggal Sampai') }} :</label>
                            <div class="col-md-3">
                                <input class="form-control dp-text" type="date" name="modalstatusnakertglsampai" id="modalstatusnakertglsampai" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modalstatusnakerket" class="col-md-3 col-form-label text-md-left">{{ __('Keterangan') }}</label>

                            <div class="col-md-9">
                                <textarea id="modalstatusnakerket" class="form-control" name="modalstatusnakerket" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" onclick="tutupFormStatusnaker();"">Tutup</button>
                    <button type="button" class="btn btn-info waves-effect" onclick="validateStatusnaker();"">Simpan</button>
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
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
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

            @foreach ($errorsStatusnaker as $key => $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Detail Status Tenaga Kerja baris ke-{{(intval($key)+1)}}, pengisian belum tepat:</strong>
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
                <li class="nav-item">
                    <a class="nav-link" id="nakerstatusnaker-tab" data-toggle="tab" href="#nakerstatusnaker" role="tab" aria-controls="nakerstatusnaker" aria-selected="false"><b>Status Tenaga Kerja</b>
                    </a>
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
                                            @foreach ($listjenisnik as $item)
                                            <option value="{{$item['jenisnik']}}" @if (old("jenisnik", $naker->jenisnik)==strval($item['jenisnik'])) selected @endif >{{ $item['jenisnikvw'] }}</option>
                                            @endforeach
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
                                            @foreach ($listjeniskelamin as $item)
                                            <option value="{{$item['jeniskelamin']}}" @if (old("jeniskelamin", $naker->jeniskelamin)==strval($item['jeniskelamin'])) selected @endif >{{ $item['jeniskelaminvw'] }}</option>
                                            @endforeach
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
                                            @foreach ($listagama as $item)
                                            <option value="{{$item['agama']}}" @if (old("agama", $naker->agama)==strval($item['agama'])) selected @endif >{{ $item['agamavw'] }}</option>
                                            @endforeach
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
                                            @foreach ($liststatusnikah as $item)
                                            <option value="{{$item['statusnikah']}}" @if (old("statusnikah", $naker->statusnikah)==strval($item['statusnikah'])) selected @endif >{{ $item['statusnikahvw'] }}</option>
                                            @endforeach
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
                            </div>
                        </div>

                       <!--  <div class="form-group row mb-0">
                            <div class="col-md-12"> -->
                                <!-- <button type="button" class="btn btn-light waves-effect waves-light m-r-10" onclick="goToStep(1, 2);">
                                    {{ __('Sebelumnya') }}
                                </button> -->
                              <!--   <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div> -->
                    </div>

                    <div class="tab-pane fade" id="nakerstatusnaker" role="tabpanel" aria-labelledby="nakerstatusnaker-tab">
                        <div class="mb-5">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    @if(!$isshow)
                                    <button onclick="javascript:addStatusnaker();" type="button" id="btnaddstatusnaker" class="btn btn-sm btn-info pull-right">Tambah</button> 
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="statusnaker-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">Status Tenaga Kerja</th>
                                            <th style="width: 100px">Tanggal Mulai</th>
                                            <th style="width: 100px">Tanggal Sampai</th>
                                            <th style="width: 100px">No. Dokumen</th>
                                            <th style="width: 100px">Keterangan</th>
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
            modalsrtno: {
                required: "No Sertifikat harus diisi"
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

    var $validatorStatusnaker = $("#statusnakerForm").validate({
        errorClass: 'invalid-feedback',
        rules: {
            modalstatusnakertglmulai: {
                max: function(){
                    if($('#modalstatusnakerstatus').val() == "{{enum::STATUS_NAKER_PKWT}}"){
                        return $('#modalstatusnakertglmulai').val();
                    }
                }
            },
            modalstatusnakertglsampai: {
                required: function(element){
                    return $('#modalstatusnakerstatus').val() == "{{enum::STATUS_NAKER_PKWT}}";
                },
                min: function(){
                    return $('#modalstatusnakertglmulai').val();
                }
            }
        },
        messages : {
            modalstatusnakerstatus: {
                required: "Status harus dipilih"
            },
            modalstatusnakertglmulai: {
                required: "Tanggal Mulai harus dipilih",
                max: function(){
                    if($('#modalstatusnakerstatus').val() == "{{enum::STATUS_NAKER_PKWT}}"){
                        return "Tanggal Mulai harus lebih kecil atau sama dengan Tanggal Sampai"
                    }
                }
            },
            modalstatusnakertglsampai: {
                required: "Tanggal Sampai harus dipilih",
                min: "Tanggal Sampai harus lebih besar atau sama dengan Tanggal Mulai"
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

    var row_number_sertifikatbidangkeahlian = 1;

    var row_number_statusnaker = {{ 
        (
            null!==(old('statusnaker')) && count(old('statusnaker')) > 0 ?  (count(old('statusnaker'))+1) 
                : (count($naker->statusnaker) > 0 ? (count($naker->statusnaker)+1) : 1)
        ) 
    }} ;

    var kotaid = '{{ old("kotaid", $naker->kotaid) }}';
    var kecamatanid = '{{ old("kecamatanid", $naker->kecamatanid) }}';
    var kelurahanid = '{{ old("kelurahanid", $naker->kelurahanid) }}';

    var riwayatkerjakotaid = '';
    var riwayatkerjakecamatanid = '';
    var riwayatkerjakelurahanid = '';

    @php $listriwayatkerja = old('riwayatkerja', $naker->riwayatkerja); @endphp
    @php $listriwayatpendidikan = old('riwayatpendidikan', $naker->riwayatpendidikan); @endphp
    @php $listsertifikat = old('sertifikat', $naker->sertifikat); @endphp
    @php $liststatusnaker = old('statusnaker', $naker->statusnaker); @endphp

    var v_listDataRiwayatKerja = [
        @foreach($listriwayatkerja as $dataRiwayatKerja)
        { 
            "indexriwayatkerja" : "{{$loop->index}}",
            "riwayatkerjaid": "{{(isset($dataRiwayatKerja['riwayatkerjaid']) ? $dataRiwayatKerja['riwayatkerjaid'] : "")}}",
            "statuspekerjaan": "{{$dataRiwayatKerja['statuspekerjaan']}}",
            "perusahaanid": "{{$dataRiwayatKerja['perusahaanid']}}",
            "provinsiid": "{{$dataRiwayatKerja['provinsiid']}}",
            "kotaid": "{{$dataRiwayatKerja['kotaid']}}",
            "kecamatanid": "{{$dataRiwayatKerja['kecamatanid']}}",
            "kelurahanid": "{{$dataRiwayatKerja['kelurahanid']}}",
            "golid": "{{$dataRiwayatKerja['golid']}}",
            "level": "{{$dataRiwayatKerja['level']}}",
            "ketpekerjaan": "{{$dataRiwayatKerja['ketpekerjaan']}}",
            "divisi": "{{$dataRiwayatKerja['divisi']}}",
            "iscurrent": "{{$dataRiwayatKerja['iscurrent']}}",
            "tglmulai": "{{$dataRiwayatKerja['tglmulai']}}",
            "tglsampai": "{{$dataRiwayatKerja['tglsampai']}}",
            "createdby": "{{$dataRiwayatKerja['createdby']}}",
            "lamabekerja": "{{$dataRiwayatKerja['lamabekerja']}}",
            "perusahaannama": "{{old('riwayatkerja','')==='' ? ($dataRiwayatKerja['perusahaan'] ? $dataRiwayatKerja['perusahaan']['nama'] : '') : $dataRiwayatKerja['perusahaannama']}}", 
        },
        @endforeach
    ];

    var v_listDataRiwayatPendidikan = [
        @foreach($listriwayatpendidikan as $dataRiwayatPendidikan)
        { 
            "indexriwayatpendidikan" : "{{$loop->index}}",
            "riwayatpendidikanid": "{{(isset($dataRiwayatPendidikan['riwayatpendidikanid']) ? $dataRiwayatPendidikan['riwayatpendidikanid'] : "")}}",
            "namainstitusi": "{{$dataRiwayatPendidikan['namainstitusi']}}",
            "jenjang": "{{$dataRiwayatPendidikan['jenjang']}}",
            "programstudi": "{{$dataRiwayatPendidikan['programstudi']}}",
            "bulanmasuk": "{{$dataRiwayatPendidikan['bulanmasuk']}}",
            "tahunmasuk": "{{$dataRiwayatPendidikan['tahunmasuk']}}",
            "bulanlulus": "{{$dataRiwayatPendidikan['bulanlulus']}}",
            "tahunlulus": "{{$dataRiwayatPendidikan['tahunlulus']}}",
            "nilaiakhir": "{{$dataRiwayatPendidikan['nilaiakhir']}}",
            "jenjangnama": "{{$dataRiwayatPendidikan['jenjangnama']}}",
            "bulanmasuknama": "{{$dataRiwayatPendidikan['bulanmasuknama']}}",
            "bulanlulusnama": "{{$dataRiwayatPendidikan['bulanlulusnama']}}",
        },
        @endforeach
    ];

    var v_listDataSertifikat = [
        @foreach($listsertifikat as $dataSertifikat)
        { 
            "indexsertifikat" : "{{$loop->index}}",
            "sertifikatid": "{{(isset($dataSertifikat['sertifikatid']) ? $dataSertifikat['sertifikatid'] : "")}}",
            "nama": "{{$dataSertifikat['nama']}}",
            "pemberi": "{{$dataSertifikat['pemberi']}}",
            "no": "{{$dataSertifikat['no']}}",
            "bulan": "{{$dataSertifikat['bulan']}}",
            "tahun": "{{$dataSertifikat['tahun']}}",
            "isexpired": "{{$dataSertifikat['isexpired']}}",
            "bulanexp": "{{$dataSertifikat['bulanexp']}}",
            "tahunexp": "{{$dataSertifikat['tahunexp']}}",
            "url": "{{$dataSertifikat['url']}}",
            "bulannama": "{{$dataSertifikat['bulannama']}}",
            "bulanexpnama": "{{$dataSertifikat['bulanexpnama']}}",
            "bidangkeahlian": [
                @if(isset($dataSertifikat['bidangkeahlian']))
                    @foreach($dataSertifikat['bidangkeahlian'] as $dataBidangKeahlian)
                    {   
                        "bidangkeahlianid": "{{$dataBidangKeahlian['bidangkeahlianid']}}",
                        "bidangkeahlian": "{{$dataBidangKeahlian['bidangkeahlian']}}"
                    },
                    @endforeach
                @endif
            ]
        },
        @endforeach
    ];

    var v_listDataStatusnaker = [
        @foreach($liststatusnaker as $dataStatusnaker)
        { 
            "indexstatusnaker" : "{{$loop->index}}",
            "statusid": "{{(isset($dataStatusnaker['statusid']) ? $dataStatusnaker['statusid'] : "")}}",
            "status": "{{$dataStatusnaker['status']}}",
            "nodokumen": "{{$dataStatusnaker['nodokumen']}}",
            "namadokumen": "{{$dataStatusnaker['namadokumen']}}",
            "tglmulai": "{{$dataStatusnaker['tglmulai']}}",
            "tglsampai": "{{$dataStatusnaker['tglsampai']}}",
            "ket": "{{$dataStatusnaker['ket']}}",
            "statusnama": "{{$dataStatusnaker['statusnama']}}", 
        },
        @endforeach
    ];

    var statusnakertable = null;

    $(document).ready(function() {
        statusnakertable = $('#statusnaker-table').DataTable( {
            paging: true,
            "ordering": false
        });

        setJenisNik();
        loadDataRiwayatKerja();
        loadDataRiwayatPendidikan();
        loadDataSertifikat();
        loadDataStatusnaker();

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

        $('.custom-select-statusnaker').select2({
            dropdownParent: $("#modalFormStatusnaker .modal-content")
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

        $('#modalsrtbidangkeahlian').on('keyup', function (e) {
            if ((e.key === 'Enter' || e.keyCode === 13) && $(this).val()!="") {
                let isexist = false;
                let bidangkeahlian = $(this).val();

                $('#bidangkeahlianListContainer').children().each(function (index, element) {
                    if(bidangkeahlian==$(this).find('.modalsrtbidangkeahlian').val().toLowerCase()) isexist = true;
                });
                if(!isexist) addBidangKeahlian(bidangkeahlian, "", row_number_sertifikatbidangkeahlian);
                $(this).val("");
            }
        });

        $('#modalstatusnakerstatus').select2().on('change', function() {
            setTanggalsampaiStatusnakerRule();
        });

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

    function setTanggalsampaiStatusnakerRule(){
        if($('#modalstatusnakerstatus').val() == "{{enum::STATUS_NAKER_PKWTT}}"){
            $("#modalstatusnakertglsampai").prop("disabled", true);
        }else{
            $("#modalstatusnakertglsampai").prop("disabled", false);
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

    function addStatusnaker(){
        resetFormStatusnaker();
        $('#titleStatusnaker').text('Tambah Status Tenaga Kerja');
        $('#modalFormStatusnaker').modal('show');
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

    function validateStatusnaker(){
        var isValid = true;

        if ($('#statusnakerForm').valid()===false){
            isValid = false;
        }

        if(!isValid){
            swal("Validasi", "Pengisian data Status Tenaga Kerja belum tepat", "error"); 
            return;
        }else{
            saveStatusnakerArray();
            $('#modalFormStatusnaker').modal('hide');
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
        if(modalrwyttglmulai!="" || modalrwyttglsampai!=""){
            var momenttglmulai = moment(modalrwyttglmulai, 'YYYY-MM-DD');
            var momenttglsampai = moment((modalrwytiscurrent!=1 ? modalrwyttglsampai : "{{Carbon::now()->isoFormat('YYYY-MM-DD')}}"), 'YYYY-MM-DD');  

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
             var v_newData = {   
                "indexriwayatkerja": new_row_number,
                "statuspekerjaan": modalrwytstatuspekerjaan,
                "perusahaanid": modalrwytperusahaanid,
                "provinsiid": modalrwytprovinsiid,
                "kotaid": modalrwytkotaid,
                "kecamatanid": modalrwytkecamatanid,
                "kelurahanid": modalrwytkelurahanid,
                "golid": modalrwytgolid,
                "level": modalrwytlevel,
                "ketpekerjaan": modalrwytketpekerjaan,
                "divisi": modalrwytdivisi,
                "iscurrent": modalrwytiscurrent,
                "tglmulai": modalrwyttglmulai,
                "tglsampai": modalrwyttglsampai,
                "createdby": '',
                "perusahaannama": perusahaannama,
                "lamabekerja": lamabekerja,
            };
            v_listDataRiwayatKerja.push(v_newData);

            row_number_riwayat++;
        }else{
            let modalrwytidx = $('#modalrwytidx').val();

            $.each( v_listDataRiwayatKerja, function( p_key, p_value ) {
                if (p_value.indexriwayatkerja ==  modalrwytidx) {
                    p_value.statuspekerjaan = modalrwytstatuspekerjaan;
                    p_value.perusahaanid = modalrwytperusahaanid;
                    p_value.provinsiid = modalrwytprovinsiid;
                    p_value.kotaid = modalrwytkotaid;
                    p_value.kecamatanid = modalrwytkecamatanid;
                    p_value.kelurahanid = modalrwytkelurahanid;
                    p_value.golid = modalrwytgolid;
                    p_value.level = modalrwytlevel;
                    p_value.ketpekerjaan = modalrwytketpekerjaan;
                    p_value.divisi = modalrwytdivisi;
                    p_value.iscurrent = modalrwytiscurrent;
                    p_value.tglmulai = modalrwyttglmulai;
                    p_value.tglsampai = modalrwyttglsampai;
                    p_value.createdby = '';
                    p_value.perusahaannama = perusahaannama;
                    p_value.lamabekerja = lamabekerja;
                    
                    return false;
                }   
            });

        }

        loadDataRiwayatKerja();
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
        // let modalsrtbidangkeahlian = $('#modalsrtbidangkeahlian').val();

        let bulannama = $("#modalsrtbulan").find(":selected").text()+' '+$('#modalsrttahun').find(":selected").text();
        let bulanexpnama = ($('input[name="modalsrtisexpired"]:checked').val() == "1" ? $("#modalsrtbulanexp").find(":selected").text()+' '+$('#modalsrttahunexp').find(":selected").text() : "Sekarang");

        let bidangkeahlian = [];

        $('#bidangkeahlianListContainer').children().each(function (index, element) {
            bidangkeahlian.push({
                bidangkeahlianid: $(this).find('.modalsrtbidangkeahlianid').val(),
                bidangkeahlian: $(this).find('.modalsrtbidangkeahlian').val()
            });
        });

        if($('#modalsrtidx').val()==""){
            var v_newData = {   
                "indexsertifikat": new_row_number,
                "nama": modalsrtnama,
                "pemberi": modalsrtpemberi,
                "no": modalsrtno,
                "bulan": modalsrtbulan,
                "tahun": modalsrttahun,
                "isexpired": modalsrtisexpired,
                "bulanexp": modalsrtbulanexp,
                "tahunexp": modalsrttahunexp,
                "url": modalsrturl,
                "bulannama": bulannama,
                "bulanexpnama": bulanexpnama,
                "bidangkeahlian": bidangkeahlian,
            };
            v_listDataSertifikat.push(v_newData);

            row_number_sertifikat++;
        }else{
            let modalsrtidx = $('#modalsrtidx').val();

            $.each( v_listDataSertifikat, function( p_key, p_value ) {
                if (p_value.indexsertifikat ==  modalsrtidx) {
                    p_value.nama = modalsrtnama;
                    p_value.pemberi = modalsrtpemberi;
                    p_value.no = modalsrtno;
                    p_value.bulan = modalsrtbulan;
                    p_value.tahun = modalsrttahun;
                    p_value.isexpired = modalsrtisexpired;
                    p_value.bulanexp = modalsrtbulanexp;
                    p_value.tahunexp = modalsrttahunexp;
                    p_value.url = modalsrturl;
                    p_value.bulannama = bulannama;
                    p_value.bulanexpnama = bulanexpnama;
                    p_value.bidangkeahlian = bidangkeahlian;
                    return false;
                }   
            });

        }

        loadDataSertifikat();
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
            var v_newData = {   
                "indexriwayatpendidikan": new_row_number,
                "namainstitusi": modalrwytpddnamainstitusi,
                "jenjang": modalrwytpddjenjang,
                "programstudi": modalrwytpddprogramstudi,
                "bulanmasuk": modalrwytpddbulanmasuk,
                "tahunmasuk": modalrwytpddtahunmasuk,
                "bulanlulus": modalrwytpddbulanlulus,
                "tahunlulus": modalrwytpddtahunlulus,
                "nilaiakhir": modalrwytpddnilaiakhir,
                "jenjangnama": jenjangnama,
                "bulanmasuknama": bulanmasuknama,
                "bulanlulusnama": bulanlulusnama,
            };
            v_listDataRiwayatPendidikan.push(v_newData);

            row_number_riwayatpendidikan++;
        }else{
            let modalrwytpddidx = $('#modalrwytpddidx').val();

            $.each( v_listDataRiwayatPendidikan, function( p_key, p_value ) {
                if (p_value.indexriwayatpendidikan ==  modalrwytpddidx) {
                    p_value.namainstitusi = modalrwytpddnamainstitusi;
                    p_value.jenjang = modalrwytpddjenjang;
                    p_value.programstudi = modalrwytpddprogramstudi;
                    p_value.bulanmasuk = modalrwytpddbulanmasuk;
                    p_value.tahunmasuk = modalrwytpddtahunmasuk;
                    p_value.bulanlulus = modalrwytpddbulanlulus;
                    p_value.tahunlulus = modalrwytpddtahunlulus;
                    p_value.nilaiakhir = modalrwytpddnilaiakhir;
                    p_value.jenjangnama = jenjangnama;
                    p_value.bulanmasuknama = bulanmasuknama;
                    p_value.bulanlulusnama = bulanlulusnama;
                    return false;
                }   
            });

        }

        loadDataRiwayatPendidikan();
    }

    function saveStatusnakerArray(){
        let new_row_number = row_number_statusnaker - 1;

        let modalstatusnakerstatus = $('#modalstatusnakerstatus').val();
        let modalstatusnakernodokumen = $('#modalstatusnakernodokumen').val();
        let modalstatusnakernamadokumen = $('#modalstatusnakernamadokumen').val();
        let modalstatusnakertglmulai = $('#modalstatusnakertglmulai').val();
        let modalstatusnakertglsampai = $("#modalstatusnakertglsampai").is(":disabled") ? "" : $('#modalstatusnakertglsampai').val();
        let modalstatusnakerket = $('#modalstatusnakerket').val();
        let statusnama = $("#modalstatusnakerstatus").find(":selected").text();

        if($('#modalstatusnakeridx').val()==""){
            var v_newData = {   
                "indexstatusnaker": new_row_number,
                "status": modalstatusnakerstatus,
                "nodokumen": modalstatusnakernodokumen,
                "namadokumen": modalstatusnakernamadokumen,
                "tglmulai": modalstatusnakertglmulai,
                "tglsampai": modalstatusnakertglsampai,
                "ket": modalstatusnakerket,
                "statusnama": statusnama, 
            };
            v_listDataStatusnaker.push(v_newData);

            row_number_statusnaker++;
        }else{
            let modalstatusnakeridx = $('#modalstatusnakeridx').val();

            $.each( v_listDataStatusnaker, function( p_key, p_value ) {
                if (p_value.indexstatusnaker ==  modalstatusnakeridx) {
                    p_value.status = modalstatusnakerstatus;
                    p_value.nodokumen = modalstatusnakernodokumen;
                    p_value.namadokumen = modalstatusnakernamadokumen;
                    p_value.tglmulai = modalstatusnakertglmulai;
                    p_value.tglsampai = modalstatusnakertglsampai;
                    p_value.ket = modalstatusnakerket;
                    p_value.statusnama = statusnama;

                    return false;
                }   
            });
        }

        loadDataStatusnaker();
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
            v_listDataRiwayatKerja.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexriwayatkerja'].toString() === idx.toString()) {
                v_listDataRiwayatKerja.splice(p_index, 1);
                }    
            });
            
            loadDataRiwayatKerja();
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
            v_listDataSertifikat.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexsertifikat'].toString() === idx.toString()) {
                v_listDataSertifikat.splice(p_index, 1);
                }    
            });
            
            loadDataSertifikat();
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
            v_listDataRiwayatPendidikan.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexriwayatpendidikan'].toString() === idx.toString()) {
                v_listDataRiwayatPendidikan.splice(p_index, 1);
                }    
            });
            
            loadDataRiwayatPendidikan();
        });
    }

    function editRiwayatKerja(idx){
        // resetFormRiwayatKerja();

        var v_filter = v_listDataRiwayatKerja.filter(function (p_element) {
            return p_element.indexriwayatkerja.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                riwayatkerjakotaid = p_value.kotaid;
                riwayatkerjakecamatanid = p_value.kecamatanid;
                riwayatkerjakelurahanid = p_value.kelurahanid;

                $('#modalrwytidx').val(idx);

                $('#modalrwytstatuspekerjaan').val(p_value.statuspekerjaan);
                $("#modalrwytperusahaanid").val(p_value.perusahaanid).trigger('change.select2');
                $('#modalrwytprovinsiid').val(p_value.provinsiid);
                $('#modalrwytgolid').val(p_value.golid);
                $('#modalrwytlevel').val(p_value.level);
                $('#modalrwytketpekerjaan').val(p_value.ketpekerjaan);
                $('#modalrwytdivisi').val(p_value.divisi);
                $('#modalrwytiscurrent').prop('checked', (p_value.iscurrent=="1" ? true : false));
                $('#modalrwyttglmulai').val(p_value.tglmulai);
                $('#modalrwyttglsampai').val(p_value.tglsampai);

                $('#modalrwytstatuspekerjaan').trigger('change');
                $('#modalrwytprovinsiid').trigger('change');
                $('#modalrwytgolid').trigger('change');
                $('#modalrwytlevel').trigger('change');

                setMasaKerjaRule((p_value.iscurrent=="1" ? true : false));

            });
        }

        $('#titleRiwayatKerja').text('Ubah Riwayat Kerja');
        $('#modalFormRiwayatKerja').modal('show');
    }

    function editSertifikat(idx){
        // resetFormSertifikat();

        var v_filter = v_listDataSertifikat.filter(function (p_element) {
            return p_element.indexsertifikat.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                $('#modalsrtidx').val(idx);

                $('#modalsrtnama').val(p_value.nama);
                $('#modalsrtpemberi').val(p_value.pemberi);
                $('#modalsrtno').val(p_value.no);
                $('#modalsrtbulan').val(p_value.bulan);
                $('#modalsrttahun').val(p_value.tahun);
                $('#modalsrtisexpired1').prop('checked', (p_value.isexpired=="1" ? true : false));
                $('#modalsrtisexpired0').prop('checked', (p_value.isexpired=="0" ? true : false));
                $('#modalsrtbulanexp').val(p_value.bulanexp);
                $('#modalsrttahunexp').val(p_value.tahunexp);
                $('#modalsrturl').val(p_value.url);
                $('#modalsrtbidangkeahlian').val("");

                $('#modalsrtbulan').trigger('change');
                $('#modalsrttahun').trigger('change');
                $('#modalsrtbulanexp').trigger('change');
                $('#modalsrttahunexp').trigger('change');

                row_number_sertifikatbidangkeahlian = 1;

                loadDataBidangKeahlian(idx);
            });
        }

        setMasaKerjaRule();

        $('#titleSertifikat').text('Ubah Sertifikat');
        $('#modalFormSertifikat').modal('show');
    }

    function editRiwayatPendidikan(idx){
        // resetFormRiwayatPendidikan();

        var v_filter = v_listDataRiwayatPendidikan.filter(function (p_element) {
            return p_element.indexriwayatpendidikan.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                $('#modalrwytpddidx').val(idx);

                $('#modalrwytpddnamainstitusi').val(p_value.namainstitusi);
                $('#modalrwytpddjenjang').val(p_value.jenjang);
                $('#modalrwytpddprogramstudi').val(p_value.programstudi);
                $('#modalrwytpddbulanmasuk').val(p_value.bulanmasuk);
                $('#modalrwytpddtahunmasuk').val(p_value.tahunmasuk);
                $('#modalrwytpddbulanlulus').val(p_value.bulanlulus);
                $('#modalrwytpddtahunlulus').val(p_value.tahunlulus);
                $('#modalrwytpddnilaiakhir').val(p_value.nilaiakhir);

                $('#modalrwytpddjenjang').trigger('change');
                $('#modalrwytpddbulanmasuk').trigger('change');
                $('#modalrwytpddtahunmasuk').trigger('change');
                $('#modalrwytpddbulanlulus').trigger('change');
                $('#modalrwytpddtahunlulus').trigger('change');

            });
        }

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

        $("#bidangkeahlianListContainer").empty();

        row_number_sertifikatbidangkeahlian = 1;

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

    function resetFormStatusnaker(){
        $('#statusnakerForm').trigger("reset");

        $('#modalstatusnakeridx').val("");

        $('#modalstatusnakerstatus').trigger('change');

        $validatorStatusnaker.resetForm();
        setTanggalsampaiStatusnakerRule();
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
            let excludeids = [];
            $('#bidangkeahlianListContainer').children().each(function (index, element) {
                let bidangkeahlianid = $(this).find('.modalsrtbidangkeahlianid').val();
                if(bidangkeahlianid!="")
                    excludeids.push(bidangkeahlianid);
            });
            $.ajax( {
                url: "{{ route('naker.searchbidangkeahlian') }}",
                dataType: "json",
                data: {
                    term: request.term,
                    excludeids: excludeids
                },
                success: function( data ) {
                    // response( data );
                    response($.map(data, function (value, key) {
                        return {
                            label: value.bidangkeahlian,
                            value: value.bidangkeahlianid
                        }
                    }));
                }
            } );
        },
        minLength: 2,
        appendTo: "#modalFormSertifikat",
        select: function(event, ui) { 
            if(ui.item) {
                let isexist = false;
                $('#bidangkeahlianListContainer').children().each(function (index, element) {
                    if(ui.item.value==$(this).find('.modalsrtbidangkeahlianid').val()) isexist = true;
                });
                if(!isexist) addBidangKeahlian(ui.item.label, ui.item.value, row_number_sertifikatbidangkeahlian);
                $("#modalsrtbidangkeahlian").val("");
            }
            return false;
        },
    });

    function validateAll(){
        if($('#nakerForm').valid()===false){
            swal("Validasi", "Pengisian data pribadi belum tepat, silahkan cek kembali", "error"); 
            $('#nakerTab a[href="#nakerdata"]').tab('show');
            return false;
        }else{
            $('.riwayatkerjafield').remove();
            $('.sertifikatfield').remove();
            $('.riwayatpendidikanfield').remove();
            $('.statusnakerfield').remove();

            $.each(v_listDataRiwayatKerja, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    $("<input />").attr("type", "hidden")
                        .attr("class", `riwayatkerjafield`)
                        .attr("name", `riwayatkerja[${p_idx}][${obj_key}]`)
                        .attr("value", obj_val)
                        .appendTo("#nakerForm");
                });
            });

            $.each(v_listDataSertifikat, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    if(obj_key==='bidangkeahlian'){
                        $.each(obj_val, function( sub_p_idx, sub_p_obj ) {
                            $.each(sub_p_obj, function(sub_obj_key, sub_obj_val){
                                $("<input />").attr("type", "hidden")
                                    .attr("class", `sertifikatfield`)
                                    .attr("name", `sertifikat[${p_idx}][${obj_key}][${sub_p_idx}][${sub_obj_key}]`)
                                    .attr("value", sub_obj_val)
                                    .appendTo("#nakerForm");
                            });
                        });
                    }
                    else{
                        $("<input />").attr("type", "hidden")
                            .attr("class", `sertifikatfield`)
                            .attr("name", `sertifikat[${p_idx}][${obj_key}]`)
                            .attr("value", obj_val)
                            .appendTo("#nakerForm");
                    }
                });
            });

            $.each(v_listDataRiwayatPendidikan, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    $("<input />").attr("type", "hidden")
                        .attr("class", `riwayatpendidikanfield`)
                        .attr("name", `riwayatpendidikan[${p_idx}][${obj_key}]`)
                        .attr("value", obj_val)
                        .appendTo("#nakerForm");
                });
            });

            $.each(v_listDataStatusnaker, function( p_idx, p_obj ) {
                $.each(p_obj, function(obj_key, obj_val){
                    $("<input />").attr("type", "hidden")
                        .attr("class", `statusnakerfield`)
                        .attr("name", `statusnaker[${p_idx}][${obj_key}]`)
                        .attr("value", obj_val)
                        .appendTo("#nakerForm");
                });
            });

            return true;
        }
    }

    function tutupFormStatusnaker(){
        swal({   
            title: "",   
            text: "Data Anda belum tersimpan? Yakin menutup form sebelum menyimpan data?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",
            closeOnConfirm: true 
        }, function(){
            $('#modalFormStatusnaker').modal('hide');
        });
    }

    function loadDataRiwayatKerja() {
        $("#riwayatKerjaListContainer").empty();

        var v_filter = v_listDataRiwayatKerja;
        
        $.each( v_filter, function( p_key, p_value ) {
            let html = '';
            html += '<div class="p-2 border" id="riwayatkerja'+p_value.indexriwayatkerja+'">';
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b>'+p_value.perusahaannama+'</b></h5></div>';
            html += '<div class="col-md-4">';
            @if(!$isshow)
            html += '<button onclick="javascript:hapusRiwayatKerja('+p_value.indexriwayatkerja+');" type="button" id="btnaddsubgolpokok" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editRiwayatKerja('+p_value.indexriwayatkerja+');" type="button" id="btnaddsubgolpokok" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            @endif
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span>'+p_value.lamabekerja+'</span><h5>'+p_value.ketpekerjaan+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#riwayatKerjaListContainer").append(html);

        });
    }

    function loadDataRiwayatPendidikan() {
        $("#riwayatPendidikanListContainer").empty();

        var v_filter = v_listDataRiwayatPendidikan;
        
        $.each( v_filter, function( p_key, p_value ) {
            let html = '';
            html += '<div class="p-2 border" id="riwayatpendidikan'+p_value.indexriwayatpendidikan+'">';
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b>'+p_value.namainstitusi+'</b></h5></div>';
            html += '<div class="col-md-4">';
            @if(!$isshow)
            html += '<button onclick="javascript:hapusRiwayatPendidikan('+p_value.indexriwayatpendidikan+');" type="button" id="btndltriwayatpendidikan" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editRiwayatPendidikan('+p_value.indexriwayatpendidikan+');" type="button" id="btneditriwayatpendidikan" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            @endif
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span>'+p_value.bulanmasuknama+' s/d '+p_value.bulanlulusnama+'</span><h5>'+p_value.jenjangnama+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#riwayatPendidikanListContainer").append(html);
        });
    }

    function loadDataSertifikat() {
        $("#sertifikatListContainer").empty();

        var v_filter = v_listDataSertifikat;
        
        $.each( v_filter, function( p_key, p_value ) {
            let html = '';
            html += '<div class="p-2 border" id="sertifikat'+p_value.indexsertifikat+'">';
            html += '<div class="row">';
            html += '<div class="col-md-8"><h5><b>'+p_value.nama+'</b></h5></div>';
            html += '<div class="col-md-4">';
            html += '<button onclick="javascript:hapusSertifikat('+p_value.indexsertifikat+');" type="button" id="btndltsertifikat" class="mx-1 btn btn-sm btn-danger pull-right">Hapus</button>';
            html += '<button onclick="javascript:editSertifikat('+p_value.indexsertifikat+');" type="button" id="btneditsertifikat" class="mx-1 btn btn-sm btn-warning pull-right">Ubah</button>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<span>'+p_value.bulannama+' s/d '+p_value.bulanexpnama+'</span><h5>'+p_value.pemberi+'</h5>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("#sertifikatListContainer").append(html);
        });
    }

    function loadDataBidangKeahlian(idx) {
        $("#bidangkeahlianListContainer").empty();

        var v_filter = v_listDataSertifikat;

        $.each( v_filter[idx].bidangkeahlian, function( p_key, p_value ) {
            addBidangKeahlian(p_value.bidangkeahlian, p_value.bidangkeahlianid, p_key);            
        });

    }

    function loadDataStatusnaker() {
        statusnakertable.clear().draw();

        var v_filter = v_listDataStatusnaker;
        var v_noUrut = 1;
        
        $.each( v_filter, function( p_key, p_value ) {
            let btnHTML = "";
            @if(!$isshow)
            btnHTML = '<button title="Edit data" type="button" onclick="editStatusnaker(\''+p_value.indexstatusnaker+'\')" class="btn btn-warning"><i class="fa fa-pencil"></i> </button><button title="Hapus data" type="button" onclick="deleteStatusnaker(\''+p_value.indexstatusnaker+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> </button>'; 
            @endif

            statusnakertable.row.add([p_value.statusnama, p_value.tglmulai, p_value.tglsampai, p_value.nodokumen, p_value.ket, btnHTML]).draw();

            v_noUrut ++;
        });
    }

    function addBidangKeahlian(bidangkeahlian, bidangkeahlianid = "", idx) {
        let html = '';
        html += '<span class="badge badge-info mb-1 mx-1" style="line-height: 2;" id="modalsrtbidangkeahlianbadge'+idx+'">';
        html += '<input class="modalsrtbidangkeahlianid" id="modalsrtbidangkeahlianid'+idx+'" type="hidden" name="modalsrtbidangkeahlianid'+idx+'" value="'+bidangkeahlianid+'">';
        html += '<input class="modalsrtbidangkeahlian" id="modalsrtbidangkeahlian'+idx+'" type="hidden" name="modalsrtbidangkeahlian'+idx+'" value="'+bidangkeahlian+'">';
        html += bidangkeahlian;
        html += '<button type="button" class="close" aria-label="Close" onclick="hapusBidangKeahlian('+idx+');"><span aria-hidden="true">&times;</span></button>';
        html += '</span>';

        $("#bidangkeahlianListContainer").append(html);

        row_number_sertifikatbidangkeahlian = 1 + idx;
    }

    function hapusBidangKeahlian(idx){
        $('#modalsrtbidangkeahlianbadge'+idx).remove();
    }

    function deleteStatusnaker(p_id) {
        swal({   
            title: "Apakah anda yakin akan menghapus Status Tenaga Kerja ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            v_listDataStatusnaker.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexstatusnaker'].toString() === p_id.toString()) {
                v_listDataStatusnaker.splice(p_index, 1);
                }    
            });
            
            loadDataStatusnaker();
        });
    }

    function editStatusnaker(idx){
        var v_filter = v_listDataStatusnaker.filter(function (p_element) {
            return p_element.indexstatusnaker.toString() === idx.toString();
        });
        if (v_filter != null && v_filter != '') {
            $.each( v_filter, function( p_key, p_value ) {
                $('#modalstatusnakeridx').val(idx);

                $("#modalstatusnakerstatus").val(p_value.status).trigger('change.select2');
                $("#modalstatusnakernodokumen").val(p_value.nodokumen);
                $("#modalstatusnakernamadokumen").val(p_value.namadokumen);
                $("#modalstatusnakertglmulai").val(p_value.tglmulai);
                $("#modalstatusnakertglsampai").val(p_value.tglsampai);
                $("#modalstatusnakerket").val(p_value.ket);

            });
        }

        setTanggalsampaiStatusnakerRule();

        $('#titleStatusnaker').text('Ubah Status Tenaga Kerja');
        $('#modalFormStatusnaker').modal('show');
    }

    @if(!$isshow)
    @endif
</script>
@endsection
