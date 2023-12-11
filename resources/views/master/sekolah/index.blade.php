<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }

    div.dt-buttons {
        float: right;
    }
</style>
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">DAFTAR SEKOLAH</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kotaid" class="col-md-12 custom-select form-control" name='kotaid' autofocus>
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                                @foreach ($kota as $item)
                                    <option value="{{$item->kotaid}}">{{  $item->kodekota . ' ' . $item->namakota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatan as $item)
                                    <option value="{{$item->kecamatanid}}">{{  $item->kodekec . ' ' . $item->namakec }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jenjang" class="col-md-12 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="jenjang" class="col-md-12 custom-select form-control" name='jenjang' autofocus>
                                <option value="">-- Pilih Jenjang --</option>
                                    <option value="{{enum::JENJANG_SMA}}">{{  enum::JENJANG_DESC_SMA }}</option>
                                    <option value="{{enum::JENJANG_SMK}}">{{  enum::JENJANG_DESC_SMK }}</option>
                                    <option value="{{enum::JENJANG_SLB}}">{{  enum::JENJANG_DESC_SLB }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jenis" class="col-md-12 col-form-label text-md-left">{{ __('Jenis') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="jenis" class="col-md-12 custom-select form-control" name='jenis' autofocus>
                                <option value="">-- Pilih Jenis --</option>
                                    <option value="{{enum::JENIS_NEGERI}}">{{  enum::JENIS_DESC_NEGERI }}</option>
                                    <option value="{{enum::JENIS_SWASTA}}">{{  enum::JENIS_DESC_SWASTA }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="search" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                        </div>
                        <div class="col-md-9">
                            <input id="search" type="text" class="col-md-12 form-control" name="search" value="{{ old('search') }}" maxlength="100" autocomplete="search">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-group row">
            <div class="col-md-12">
                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
                @endif

                @if (session()->has('success'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="sekolah-table">
                        <thead>
                            <tr>
                                <th>NO NPSN</th>
                                <th>Nama Sekolah</th>
                                <th>Kab/Kota</th>
                                <th>Jenjang</th>
                                <th>Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.custom-select').select2();
    
        var sekolahtable = $('#sekolah-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: false,
            language: {
                lengthMenu: "Menampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data",
                info: "Halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ data)",
                search: "Pencarian :",
                paginate: {
                   previous: "Sebelumnya",
                   next: "Selanjutnya",
                }
            },
            ajax: {
                url: "{{ route('sekolah.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        "jenjang": $("#jenjang").val().toLowerCase(),
                        "jenis": $("#jenis").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (sekolahtable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = sekolahtable.rows( { selected: true } ).data()[0]['sekolahid'];
                        var url = "{{ route('sekolah.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (sekolahtable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = sekolahtable.rows( { selected: true } ).data()[0]['sekolahid'];
                        var url = "{{ route('sekolah.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var nama =  sekolahtable.rows( { selected: true } ).data()[0]['namasekolah'];
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus Sekolah " + nama + "?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "DELETE",
                                    cache:false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(json){
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        console.log(data);
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            sekolahtable.draw();
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });  
                            }           
                        });
                    }
                }]
            },
            columns: [
                {'orderData': 1, data: 'npsn', name: 'npsn'},
                {'orderData': 2, data: 'namasekolah', name: 'namasekolah'},
                {'orderData': 3, data: 'kotaid',
                    render: function ( data, type, row ) {
                        return (row.namakota);
                    }, 
                    name: 'namakota'},
                {'orderData': 4, data: 'jenjang',
                    render: function ( data, type, row ) {
                        if(row.jenjang!=null){
                            if(row.jenjang=="{{enum::JENJANG_SMA}}") 
                                return '{{enum::JENJANG_DESC_SMA}}';
                            else if(row.jenjang=="{{enum::JENJANG_SMK}}") 
                                return '{{enum::JENJANG_DESC_SMK}}';
                            else if(row.jenjang=="{{enum::JENJANG_SLB}}") 
                                return '{{enum::JENJANG_DESC_SLB}}';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'jenjang'},
                {'orderData': 5, data: 'jenis',
                    render: function ( data, type, row ) {
                        if(row.jenis!=null){
                            if(row.jenis=="{{enum::JENIS_NEGERI}}") 
                                return '{{enum::JENIS_DESC_NEGERI}}';
                            else if(row.jenis=="{{enum::JENIS_SWASTA}}") 
                                return '{{enum::JENIS_DESC_SWASTA}}';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'jenis'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
        $('#kotaid').change( function() { 
            sekolahtable.draw();
            if (this.value) {
                $.ajax({
                    url: "{{ route('helper.getkecamatan', ':id') }}".replace(':id', this.value),
                }).done(function (result) {
                    let dataWr = result.data;
                    
                    $("#kecamatanid").html("");
                    var d = new Option("-- Semua Kecamatan --", "");
                    $("#kecamatanid").append(d);
            
                    if (dataWr) {
                        dataWr.forEach((element) => {
                            var text = element.kodekec + ' - ' + element.namakec; 
                            var o = new Option(text, element.kecamatanid);
                            $("#kecamatanid").append(o);
                        });
                    }
                });
            }else{

                $("#kecamatanid").html("");
                
                var dd = new Option("-- Pilih Kecamatan --", "");
                $("#kecamatanid").append(dd);
            }
        });
        $('#kecamatanid').change( function() { 
            sekolahtable.draw();
        });
        $('#jenjang').change( function() { 
            sekolahtable.draw();
        });
        $('#jenis').change( function() { 
            sekolahtable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                sekolahtable.draw();
            }
        });

    });
</script>

@endsection