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
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR USER</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kota / Kabupaten') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kotaid" class="col-md-12 custom-select form-control" name='kotaid' autofocus>
                                <option value="">-- Pilih kota --</option>
                                @foreach ($kota as $item)
                                <option value="{{$item->kotaid}}">{{ $item->namakota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatan as $item)
                                    <option value="{{$item->kecamatanid}}">{{ $item->kodekec .' '. $item->namakec }}</option>
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

                {{-- @if (session()->has('success'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif --}}
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="user-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama Pengguna</th>
                                <th>Nama Hak Akses</th>
                                <th>Status</th>
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
    
        var usertable = $('#user-table').DataTable({
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
                url: "{{ route('user.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (usertable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = usertable.rows( { selected: true } ).data()[0]['userid'];
                        var url = "{{ route('user.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (usertable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = usertable.rows( { selected: true } ).data()[0]['userid'];
                        var url = "{{ route('user.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, 
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (usertable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = usertable.rows( { selected: true } ).data()[0]['userid'];
                        var url = "{{ route('user.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var nama =  usertable.rows( { selected: true } ).data()[0]['nama'];
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus User " + nama + "?",   
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
                                    success: function(json){
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            usertable.draw();
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });  
                            }
                        });
                    }
                }
            ]
            },
            columns: [
                // {'orderData': 0, data: 'userid', name: 'userid'},
                {'orderData': 1, data: 'login', name: 'login', title: "Login"},
                // {'orderData': 2, data: 'nik',
                //     render: function ( data, type, row ) {
                //         return row.nik;
                //     }, 
                //     name: 'nik'},
                {'orderData': 2, data: 'nama', name: 'nama'},
                {'orderData': 3, data: 'aksesnama', name: 'aksesnama'},
                // {'orderData': 5, data: 'perusahaanid',
                //     render: function ( data, type, row ) {
                //         return row.perusahaan;
                //     }, 
                //     name: 'perusahaanid'},
                {data: 'isaktif',
                render: function ( data, type, row ) {
                    if (row.isaktif != null && row.isaktif != '0') {
                        return '<span class="badge badge-pill badge-success">Aktif</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                    }
                }, 
                name: 'isaktif'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#kotaid').select2().on('change', function() {
            var url = "{{ route('helper.getkecamatan', ':id') }}";
            url = url.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#kecamatanid').empty();
                    $('#kecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
                    $.each(data.data, function(key, value) {
                        $('#kecamatanid').append($("<option></option>").attr("value", value.kecamatanid).text(value.kodekec + ' - ' + value.namakec));
                    });
                    $('#kecamatanid').select2();
                    // $('#kecamatanid').val(kecamatanid);
                    $('#kecamatanid').trigger('change');

                }
            })
        })
    
        $('#kotaid').change( function() { 
            usertable.draw();
        });


        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                usertable.draw();
            }
        });

    });
</script>

@endsection