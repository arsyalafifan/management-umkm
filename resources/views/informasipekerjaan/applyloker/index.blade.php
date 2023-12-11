<?php
use App\enumVar as enum;
$perusahaanid = null;
if(!Auth::user()->isSuperadmin()) $perusahaanid = Auth::user()->perusahaanid;
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

    .loadingdata {
        width: 100%;
        height: 100%;
        top: 0px;
        position: fixed;
        z-index: 99999;
        margin-left: -245px;
        background-color:rgba(0, 0, 0, 0.15);
    }
</style>
<div class="loadingdata" style="display: none;">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Load Data</p>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR PELAMAR</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="perusahaanid" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="perusahaanid" class="col-md-12 custom-select form-control" name='perusahaanid' autofocus>
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach ($perusahaan as $item)
                                    <option value="{{$item->perusahaanid}}" @if (!is_null($perusahaanid) && $perusahaanid == $item->perusahaanid) selected @endif>{{ $item->kodedaftar .' '. $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                    <table class="table table-bordered yajra-datatable table-striped" id="applyloker-table">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tanggal Daftar</th>
                                <th>Status Pelamar</th>
                                <th>Perusahaan</th>
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
    var applylokertable = null;

    $(document).ready(function () {
        $('.custom-select').select2();

        applylokertable = $('#applyloker-table').DataTable({
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
                url: "{{ route('applyloker.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "perusahaanid": $("#perusahaanid").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: 'Diterima',
                    className: 'edit btn btn-info btn-sm btn-datatable',
                    action: function () {
                        if (applylokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diterima", "error");
                            return;
                        }
                        $status = applylokertable.rows( { selected: true } ).data()[0]['status'];

                        if(parseInt($status)!=={{enum::STATUS_PELAMAR_MELAMAR}}) {
                            swal("Daftar Pelamar", "Data tidak boleh diubah", "error");
                            return;
                        }

                        var id = applylokertable.rows( { selected: true } ).data()[0]['applylokerid'];
                        var url = "{{ route('applyloker.terima') }}";
                        var nama =  applylokertable.rows( { selected: true } ).data()[0]['nama'];
                        swal({   
                            title: "",   
                            text: "Apakah benar anda akan MENERIMA lamaran ini?",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                cache:false,
                                url: url,
                                data: {id: id},
                                beforeSend: function() {
                                    swal({
                                        title: `Mohon tunggu`,
                                        text: "Sedang memproses data",
                                        icon: "warning",
                                        buttons: false,
                                        type: "info",
                                        closeOnClickOutside: false,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                                },
                                success: function(json){
                                    var success = json.success;
                                    var message = json.message;
                                    var data = json.data;
                                    
                                    if (success == 'true' || success == true) {
                                        swal("Berhasil!", "Data berhasil diubah.", "success"); 
                                        applylokertable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                }
                            });                
                        });
                    }
                },
                {
                    text: 'Tidak Diterima',
                    className: 'generateusr btn btn-success btn-sm btn-datatable',
                    action: function () {
                        if (applylokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan ditolak", "error");
                            return;
                        }
                        $status = applylokertable.rows( { selected: true } ).data()[0]['status'];

                        if(parseInt($status)!=={{enum::STATUS_PELAMAR_MELAMAR}}) {
                            swal("Daftar Pelamar", "Data tidak boleh diubah", "error");
                            return;
                        }

                        var id = applylokertable.rows( { selected: true } ).data()[0]['applylokerid'];
                        var url = "{{ route('applyloker.tolak') }}";
                        var nama =  applylokertable.rows( { selected: true } ).data()[0]['nama'];
                        swal({   
                            title: "",   
                            text: "Apakah benar anda akan MENOLAK lamaran ini?",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                cache:false,
                                url: url,
                                data: {id: id},
                                beforeSend: function() {
                                    swal({
                                        title: `Mohon tunggu`,
                                        text: "Sedang memproses data",
                                        icon: "warning",
                                        buttons: false,
                                        type: "info",
                                        closeOnClickOutside: false,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                                },
                                success: function(json){
                                    var success = json.success;
                                    var message = json.message;
                                    var data = json.data;
                                    
                                    if (success == 'true' || success == true) {
                                        swal("Berhasil!", "Data berhasil diubah.", "success"); 
                                        applylokertable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                }
                            });                
                        });
                    }
                }, 
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (applylokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        $status = applylokertable.rows( { selected: true } ).data()[0]['status'];

                        if(parseInt($status)!=={{enum::STATUS_PELAMAR_MELAMAR}}) {
                            swal("Daftar Pelamar", "Data tidak boleh diubah", "error");
                            return;
                        }
                        var id = applylokertable.rows( { selected: true } ).data()[0]['applylokerid'];
                        var url = "{{ route('applyloker.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (applylokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = applylokertable.rows( { selected: true } ).data()[0]['applylokerid'];
                        var url = "{{ route('applyloker.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        // var nama =  applylokertable.rows( { selected: true } ).data()[0]['namalengkap'];
                        swal({   
                            title: "Apakah anda yakin akan menghapus pelamar ini ?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
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
                                        swal("Berhasil!", "Data anda telah dihapus.", "success"); 
                                        applylokertable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                }
                            });                
                        });
                    }
                }]
            },
            columns: [
                {'orderData': 1, data: 'nik', name: 'nik'},
                {'orderData': 2, data: 'namalengkap', name: 'namalengkap'},
                {'orderData': 3, data: 'tglapplyvw', name: 'tglapplyvw'},
                {'orderData': 4, data: 'status',
                    render: function ( data, type, row ) {
                        if(row.status!=null){
                            if(row.status=="{{enum::STATUS_PELAMAR_MELAMAR}}") 
                                return '{{enum::STATUS_PELAMAR_DESC_MELAMAR}}';
                            if(row.status=="{{enum::STATUS_PELAMAR_DITERIMA}}") 
                                return '{{enum::STATUS_PELAMAR_DESC_DITERIMA}}';
                            if(row.status=="{{enum::STATUS_PELAMAR_TIDAK_DITERIMA}}") 
                                return '{{enum::STATUS_PELAMAR_DESC_TIDAK_DITERIMA}}';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'status'},
                {'orderData': 5, data: 'namaperusahaan', name: 'namaperusahaan'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#perusahaanid').change( function() { 
            applylokertable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                applylokertable.draw();
            }
        });

    });

</script>

@endsection