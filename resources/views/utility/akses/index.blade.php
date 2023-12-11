<?php
use App\globalFunction;
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

    table.dataTable thead th,
    table.dataTable tfoot th {
        vertical-align: middle;
        text-align: center;
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
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR HAK AKSES</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="search" class="col-md-2 col-form-label text-md-left">{{ __('Filter') }}</label>
                    <input id="search" type="text" class="col-md-9 form-control" name="search" value="{{ old('search') }}" maxlength="100" autocomplete="search">
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
                
                <div>
                    <table class="table table-bordered yajra-datatable table-striped" id="akses-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
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
    
        var aksestable = $('#akses-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 30,
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
                // beforeSend: getHeaderAjax,
                url: "{{ route('akses.index') }}",
                //dataSrc: "data.data",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        //"searchparams": JSON.stringify({
                            "search": $("#search").val().toLowerCase(),
                        //})
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (aksestable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = aksestable.rows( { selected: true } ).data()[0]['aksesid'];
                        var url = "{{ route('akses.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, 
                // {
                //     text: 'Hapus',
                //     className: 'edit btn btn-danger btn-sm btn-datatable',
                //     action: function () {
                //         if (aksestable.rows( { selected: true } ).count() <= 0) {
                //             swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                //             return;
                //         }
                //         var id = aksestable.rows( { selected: true } ).data()[0]['aksesid'];
                //         var url = "{{ route('akses.destroy', ':id') }}"
                //         url = url.replace(':id', id);
                        
                //         swal.fire({   
                //             title: "Apakah anda yakin akan menghapus data Hak Akses yang dipilih?",   
                //             text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                //             type: "warning",   
                //             showCancelButton: true,   
                //             confirmButtonColor: "#DD6B55",   
                //             confirmButtonText: "Ya, lanjutkan!",   
                //             closeOnConfirm: false 
                //         }).then((result) => {
                //             if(result.isConfirmed){
                //                 $.ajaxSetup({
                //                     headers: {
                //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //                     }
                //                 });
                //                 $.ajax({
                //                     type: "DELETE",
                //                     cache:false,
                //                     url: url,
                //                     success: function(json){
                //                         var success = json.success;
                //                         var message = json.message;
                //                         var data = json.data;
                                        
                //                         if (success == 'true' || success == true) {
                //                             swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                //                             aksestable.draw();
                //                         }
                //                         else {
                //                             swal.fire("Error!", data, "error"); 
                //                         }
                //                     }
                //                 });
                //             }         
                //         })
                //     }
                // }
            ]
            },
            columns: [
                {'orderData': 1, data: 'aksesid', name: 'aksesid', title: "Akses ID"},
                {'orderData': 2, data: 'aksesnama', name: 'aksesnama', title: "Nama Hak Akses"},
                // {'orderData': 3, data: 'status',
                //     render: function ( data, type, row ) {
                //         if (row.status != null && row.status != '0') {
                //             return '<span class="badge badge-pill badge-success">Aktif</span>';
                //         }
                //         else {
                //             return '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                //         }
                //     }, 
                //     name: 'status', title: 'Status'},
                // {'orderData': 4, data: 'keterangan', name: 'keterangan', title: "Keterangan"},
                
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
            drawCallback: function( settings ) {
                $("#akses-table").wrap( "<div class='table-responsive'></div>" );
            }
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                aksestable.draw();
            }
        });
    });
</script>

@endsection