<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')

<style>
    div.dt-buttons {
        float: right;
    }

    thead th,
    tfoot th {
        vertical-align: middle;
        text-align: center;
    }

    input[readonly] {
        background-color: #e9ecef;
        border: none;
    }

    .loadingdata {
        width: 100%;
        height: 100%;
        top: 0px;
        position: fixed;
        z-index: 99999;
        margin-left: -245px;
        background-color:rgba(0, 0, 0, 0.15);
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        /*border-bottom: none;
        border-top: none;*/
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff; 
        /*border-bottom: 1px solid #d4d4d4; */
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9; 
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: #e9ecef !important; /*DodgerBlue*/
        /*color: #ffffff; */
    }
</style>
<div class="loadingdata" style="display: none;">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Load Data</p>
    </div>
</div>
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($akses->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
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

            <form id="akses-form" method="POST" action="{{ $akses->exists ? route('akses.update', $akses->aksesid) : route('akses.store') }}"  class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @if($akses->exists)
            {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="aksesid" id="aksesid" value="{{ $akses->exists ? $akses->aksesid : '' }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="row">
                                <label for="akseskode" class="col-md-12 col-form-label text-md-left">{{ __('Kode *') }}</label>
                                {{-- <div class="col-md-12">
                                    <input id="akseskode" type="text" class="form-control @error('akseskode') is-invalid @enderror" name="akseskode" value="{{ old('akseskode', isset($akses->akseskode) ? $akses->akseskode : '') }}" maxlength="10" required>

                                    @if ($errors->has('akseskode'))
                                    @error('akseskode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Kode Hak Akses harus diisi</strong>
                                    </span>
                                    @endif
                                    <span class="invalid-feedback" role="alert" id="errakseskode"></span>
                                </div> --}}
                            </div>
                            <div class="row">
                                <label for="grup" class="col-md-12 col-form-label text-md-left">{{ __('Grup') }}</label>
                                <div class="col-md-12">
                                    <select id="grup" class="col-md-12 custom-select form-control" name='grup' autofocus {{ $akses->exists ? 'disabled' : '' }}>
                                        <option value="">-- Hak Akses --</option>
                                        <option @if (old("grup", $akses->grup)==enum::USER_SUPERADMIN) selected @endif value="{{enum::USER_SUPERADMIN}}">{{ 'Superadmin' }}</option>
                                        <option @if (old("grup", $akses->grup)==enum::USER_ADMIN_DISDIK) selected @endif value="{{enum::USER_ADMIN_DISDIK}}">{{ 'Admin Disdik' }}</option>
                                        <option @if (old("grup", $akses->grup)==enum::USER_SEKOLAH) selected @endif value="{{enum::USER_SEKOLAH}}">{{ 'Sekolah' }}</option>
                                        <option @if (old("grup", $akses->grup)==enum::USER_PERUSAHAAN) selected @endif value="{{enum::USER_PERUSAHAAN}}">{{ 'Perusahaan' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="grup" class="col-md-12 col-form-label text-md-left">{{ __('Nama Akses') }}</label>
                                    <input type="text" value="{{ $akses->exists ? $akses->aksesnama : '' }}" name='aksesnama' id="aksesnama" class="form-control"  {{ $akses->exists ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                <h5 class="card-title text-uppercase">DETAIL HAK AKSES</h5><hr />
                    
                    <span class="text-danger small errorspan" role="alert" id="erraksesmenu">
                        
                    </span>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="text-danger small errorspan" role="alert" id="erraksesmenu">
                                    
                                    </span>
                                    <div>
                                        <table class="table table-bordered yajra-datatable table-striped" id="aksesmenu-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Nama Menu</th>
                                                    <th class="bg-success">Semua</th>
                                                    <th>Tambah</th>
                                                    <th>Ubah</th>
                                                    <th>Hapus</th>
                                                    <th>Lihat</th>
                                                    <th>Cetak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(old('aksesmenu', $aksesmenu) as $dataAksesmenu)
                                                @php $dataAksesmenu = (object) $dataAksesmenu; @endphp
                                                <tr>
                                                    <td>{{$dataAksesmenu->jenis}}</td>
                                                    <td class="details-control">
                                                        <input type="hidden" name="aksesmenu[{{$loop->index}}][aksesmenuid]" id="aksesmenuid{{$loop->index}}" value="{{$dataAksesmenu->aksesmenuid}}">
                                                        <input type="hidden" name="aksesmenu[{{$loop->index}}][menuid]" id="menuid{{$loop->index}}" value="{{$dataAksesmenu->menuid}}">
                                                        <input type="hidden" name="aksesmenu[{{$loop->index}}][parent]" id="parent{{$loop->index}}" value="{{$dataAksesmenu->parent}}">
                                                        <input type="hidden" name="aksesmenu[{{$loop->index}}][menu]" id="menu{{$loop->index}}" value="{{$dataAksesmenu->menu}}">
                                                        <input type="hidden" name="aksesmenu[{{$loop->index}}][jenis]" id="jenis{{$loop->index}}" value="{{$dataAksesmenu->jenis}}">
                                                    </td>
                                                    <td>
                                                        @if ($dataAksesmenu->parent != $dataAksesmenu->menu) 
                                                            {{ $dataAksesmenu->parent . ' - ' . $dataAksesmenu->menu }}
                                                        @else 
                                                            {{ $dataAksesmenu->menu }}
                                                        @endif
                                                    </td>
                                                    <td width="15" class="text-center bg-success">
                                                        <input name="aksesmenu[{{$loop->index}}][semua]" type="hidden" value="0"/>
                                                        <input name="aksesmenu[{{$loop->index}}][semua]" id="chkmenuall{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->semua==true ? ' checked' : '' }} onclick="setMenuAllCheckbox(this, {{$dataAksesmenu->menuid}});"/>
                                                    </td>
                                                    <td width="15" class="text-center">
                                                        <input name="aksesmenu[{{$loop->index}}][tambah]" type="hidden" value="0"/>
                                                        <input name="aksesmenu[{{$loop->index}}][tambah]" id="chkmenutambah{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->tambah==true ? ' checked' : '' }} onclick="setAllCheckbox(this, {{$dataAksesmenu->menuid}},'tambah');"/>
                                                    </td>
                                                    <td width="15" class="text-center">
                                                        <input name="aksesmenu[{{$loop->index}}][ubah]" type="hidden" value="0"/>
                                                        <input name="aksesmenu[{{$loop->index}}][ubah]" id="chkmenuubah{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->ubah==true ? ' checked' : '' }} onclick="setAllCheckbox(this, {{$dataAksesmenu->menuid}},'ubah');"/>
                                                    </td>
                                                    <td width="15" class="text-center">
                                                        <input name="aksesmenu[{{$loop->index}}][hapus]" type="hidden" value="0"/>
                                                        <input name="aksesmenu[{{$loop->index}}][hapus]" id="chkmenuhapus{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->hapus==true ? ' checked' : '' }} onclick="setAllCheckbox(this, {{$dataAksesmenu->menuid}},'hapus');"/>
                                                    </td>
                                                    <td width="15" class="text-center">
                                                        <input name="aksesmenu[{{$loop->index}}][lihat]" type="hidden" value="0"/>
                                                        <input name="aksesmenu[{{$loop->index}}][lihat]" id="chkmenulihat{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->lihat==true ? ' checked' : '' }} onclick="setAllCheckbox(this, {{$dataAksesmenu->menuid}},'lihat');"/>
                                                    </td>
                                                    <td width="15" class="text-center">
                                                    <input name="aksesmenu[{{$loop->index}}][cetak]" type="hidden" value="0"/> 
                                                        <input name="aksesmenu[{{$loop->index}}][cetak]" id="chkmenucetak{{$dataAksesmenu->menuid}}" class="checkmenu" type="checkbox" value="1" {{ $dataAksesmenu->cetak==true ? ' checked' : '' }} onclick="setAllCheckbox(this, {{$dataAksesmenu->menuid}},'cetak');"/>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                        {{ __('Simpan') }}
                    </button>
                    <a href="{{ route('akses.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                        {{ __('Index Hak Akses') }}
                    </a>
                    {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                        {{ __('Home') }}
                    </a> --}}
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var collapsedGroups = {};
    var aksesmenutable = $('#aksesmenu-table').DataTable({
        responsive: true,
        processing: true,
        searching: false, 
        paging: false, 
        info: false,
        select: false,
        ordering: false,
        asStripeClasses: [],
        rowGroup: {
            dataSrc: 0,
        },
        columnDefs: [{ visible: false, targets: 0 }],
        initComplete: function (settings, json) {
            $(".btn-datatable").removeClass("dt-button");
        },
        drawCallback: function( settings ) {
            $("#aksesmenu-table").wrap( "<div class='table-responsive'></div>" );
        }
    });

    function setMenuAllCheckbox(ev, menuid) {
        let newvalue = ev.checked;

        $('#chkmenutambah'+menuid).prop("checked",newvalue);
        $('#chkmenuubah'+menuid).prop("checked",newvalue);
        $('#chkmenuhapus'+menuid).prop("checked",newvalue);
        $('#chkmenulihat'+menuid).prop("checked",newvalue);
        $('#chkmenucetak'+menuid).prop("checked",newvalue);
    }

    function setAllCheckbox(ev, menuid, aksi) {
        let newvalue = ev.checked;
        if(newvalue===true){
            let isAllChecked = true;

            if ($('#chkmenutambah'+menuid).is(":checked")!=newvalue && aksi!="tambah") isAllChecked = false;
            if ($('#chkmenuubah'+menuid).is(":checked")!=newvalue && aksi!="ubah") isAllChecked = false;
            if ($('#chkmenuhapus'+menuid).is(":checked")!=newvalue && aksi!="hapus") isAllChecked = false;
            if ($('#chkmenulihat'+menuid).is(":checked")!=newvalue && aksi!="lihat") isAllChecked = false;
            if ($('#chkmenucetak'+menuid).is(":checked")!=newvalue && aksi!="cetak") isAllChecked = false;

            if(isAllChecked) $('#chkmenuall'+menuid).prop("checked",true);
        }else{
            $('#chkmenuall'+menuid).prop("checked",false);
        }
    }

    $(document).ready(function () {
        $('.custom-select').select2();
        @if(!$akses->exists) 
            getNextKode() 
        @endif
    });

    function getNextKode(){
        var url = "{{ route('akses.nextno') }}"
        $.ajax({
            url:url,
            type:'GET',
            success:function(response) {
                $('#akseskode').val(response.data);
            }
        });
    }
</script>
@endsection
