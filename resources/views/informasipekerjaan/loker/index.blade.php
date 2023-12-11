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
        <h5 class="card-title text-uppercase">DAFTAR POSTING LOWONGAN KERJA</h5><hr />
        <form class="form-material">
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
                    <table class="table table-bordered yajra-datatable table-striped" id="loker-table">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Nama Pekerjaan</th>
                                <th>Gaji</th>
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
    var lokertable = null;
    $(document).ready(function () {
        $('.custom-select').select2();
    
        lokertable = $('#loker-table').DataTable({
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
                info: "Halaman _PAGE_ dari _PAGES_ (Total: _TOTAL_ Data)",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ data)",
                search: "Pencarian :",
                paginate: {
                   previous: "Sebelumnya",
                   next: "Selanjutnya",
                }
            },
            ajax: {
                url: "{{ route('loker.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (lokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = lokertable.rows( { selected: true } ).data()[0]['lokerid'];
                        var url = "{{ route('loker.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (lokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = lokertable.rows( { selected: true } ).data()[0]['lokerid'];
                        var url = "{{ route('loker.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (lokertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = lokertable.rows( { selected: true } ).data()[0]['lokerid'];
                        var url = "{{ route('loker.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var nama =  lokertable.rows( { selected: true } ).data()[0]['loker'];
                        swal({   
                            title: "Apakah anda yakin akan menghapus Loker ini ?",   
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
                                        lokertable.draw();
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
                {'orderData': 1, data: 'perusahaan',
                    render: function ( data, type, row ) {
                        return (row.perusahaan ? row.perusahaan.nama : '-');
                    }, 
                    name: 'bidangusahaview'},
                {'orderData': 2, data: 'judul', name: 'judul'},
                {'orderData': 3, data: 'gaji',
                    render: function ( data, type, row ) {
                        return (row.gajimin !== null ? row.gajimin.toString() : "")+(row.gajimax !== null ? " - "+row.gajimax.toString() : "");
                    }, 
                    name: 'gajiview'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                lokertable.draw();
            }
        });

    });
    
</script>

@endsection