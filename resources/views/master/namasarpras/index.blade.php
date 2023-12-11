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
        <h5 class="card-title text-uppercase">DAFTAR NAMA SARPRAS</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="search" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                        </div>
                        <div class="col-md-8">
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
                    <table class="table table-bordered yajra-datatable table-striped" id="nama-sarpras-table">
                        <thead>
                            <tr>
                                {{-- <th>Kota ID</th> --}}
                                {{-- <th>Nama Provinsi</th>
                                <th>Jenis</th> --}}
                                <th>Nama Sarpras</th>
                                <th>Kategori Sarpras</th>
                                {{-- <th>Status</th> --}}
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

<script type="text/javascript">
    $(document).ready(function () {
        $('.custom-select').select2();
    
        var namasarprastable = $('#nama-sarpras-table').DataTable({
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
                url: "{{ route('namasarpras.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        // "provid": $("#provid").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (namasarprastable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = namasarprastable.rows( { selected: true } ).data()[0]['namasarprasid'];
                        var url = "{{ route('namasarpras.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (namasarprastable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = namasarprastable.rows( { selected: true } ).data()[0]['namasarprasid'];
                        var url = "{{ route('namasarpras.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (namasarprastable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = namasarprastable.rows( { selected: true } ).data()[0]['namasarprasid'];
                        var url = "{{ route('namasarpras.destroy', ':id') }}"
                        var nama = namasarprastable.rows({ selected: true } ).data()[0]['namasarpras']
                        url = url.replace(':id', id);
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus Nama Sarpras " + nama + "?",
                            icon: 'warning',   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            // type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            // closeOnConfirm: false 
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
                                            namasarprastable.draw();
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });   
                            }          
                        })
                        // }, function(){   
                        //     $.ajaxSetup({
                        //         headers: {
                        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //         }
                        //     });
                        //     $.ajax({
                        //         type: "DELETE",
                        //         cache:false,
                        //         url: url,
                        //         dataType: 'JSON',
                        //         data: {
                        //             "_token": $('meta[name="csrf-token"]').attr('content')
                        //         },
                        //         success: function(json){
                        //             var success = json.success;
                        //             var message = json.message;
                        //             var data = json.data;
                        //             console.log(data);
                                    
                        //             if (success == 'true' || success == true) {
                        //                 swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                        //                 namasarprastable.draw();
                        //             }
                        //             else {
                        //                 swal.fire("Error!", data, "error"); 
                        //             }
                        //         }
                        //     });                
                        // });
                    }
                }]
            },
            columns: [
                {'orderData': 1, data: 'namasarpras', name: 'namasarpras'},
                {'orderData': 2, data: 'kategorisarpras',
                render: function ( data, type, row ) {
                    if(row.kategorisarpras=="{{enum::SARPRAS_UTAMA}}") return "Sarpras Utama";
                    else if(row.kategorisarpras=="{{enum::SARPRAS_PENUNJANG}}") return "Sarpras Penunjang";
                    else if(row.kategorisarpras=="{{enum::SARPRAS_PERALATAN}}") return "Sarpras Peralatan";
                    else return "-";
                }, 
                name: 'kategorisarpras'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
        });
    
        // $('#provid').change( function() { 
        //     namasarprastable.draw();
        // });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                namasarprastable.draw();
            }
        });

    });
</script>

@endsection