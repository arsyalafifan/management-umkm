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
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR BIDANG USAHA</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="bidangid" class="col-md-12 col-form-label text-md-left">{{ __('Bidang') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="bidangid" class="col-md-12 custom-select form-control" name='bidangid' autofocus>
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidang as $item)
                                    <option value="{{$item->bidangid}}">{{ $item->kode .' '. $item->bidang }}</option>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="bidangusaha-table">
                        <thead>
                            <tr>
                                <!-- <th>Bidang Usaha ID</th> -->
                                <th>Bidang</th>
                                <th>Bidang Usaha</th>
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
    
        var bidangusahatable = $('#bidangusaha-table').DataTable({
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
                url: "{{ route('bidangusaha.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "bidangid": $("#bidangid").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                // {
                //     text: 'Lihat',
                //     className: 'view btn btn-primary btn-sm btn-datatable',
                //     action: function () {
                //         if (bidangusahatable.rows( { selected: true } ).count() <= 0) {
                //             swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                //             return;
                //         }
                //         var id = bidangusahatable.rows( { selected: true } ).data()[0]['bidangusahaid'];
                //         var url = "{{ route('bidangusaha.show', ':id') }}"
                //         url = url.replace(':id', id);
                //         window.location = url;
                //     }
                // }, {
                //     text: 'Ubah',
                //     className: 'edit btn btn-warning btn-sm btn-datatable',
                //     action: function () {
                //         if (bidangusahatable.rows( { selected: true } ).count() <= 0) {
                //             swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                //             return;
                //         }
                //         var id = bidangusahatable.rows( { selected: true } ).data()[0]['bidangusahaid'];
                //         var url = "{{ route('bidangusaha.edit', ':id') }}"
                //         url = url.replace(':id', id);
                //         window.location = url;
                //     }
                // }, {
                //     text: 'Hapus',
                //     className: 'edit btn btn-danger btn-sm btn-datatable',
                //     action: function () {
                //         if (bidangusahatable.rows( { selected: true } ).count() <= 0) {
                //             swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                //             return;
                //         }
                //         var id = bidangusahatable.rows( { selected: true } ).data()[0]['bidangusahaid'];
                //         var url = "{{ route('bidangusaha.destroy', ':id') }}"
                //         url = url.replace(':id', id);
                //         var nama =  bidangusahatable.rows( { selected: true } ).data()[0]['bidangusaha'];
                //         swal({   
                //             title: "Apakah anda yakin akan menghapus Bidang Usaha " + nama + "?",   
                //             text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                //             type: "warning",   
                //             showCancelButton: true,   
                //             confirmButtonColor: "#DD6B55",   
                //             confirmButtonText: "Ya, lanjutkan!",   
                //             closeOnConfirm: false 
                //         }, function(){   
                //             $.ajaxSetup({
                //                 headers: {
                //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //                 }
                //             });
                //             $.ajax({
                //                 type: "DELETE",
                //                 cache:false,
                //                 url: url,
                //                 success: function(json){
                //                     var success = json.success;
                //                     var message = json.message;
                //                     var data = json.data;
                                    
                //                     if (success == 'true' || success == true) {
                //                         swal("Berhasil!", "Data anda telah dihapus.", "success"); 
                //                         bidangusahatable.draw();
                //                     }
                //                     else {
                //                         swal("Error!", data, "error"); 
                //                     }
                //                 }
                //             });                
                //         });
                //     }
                // }
                ]
            },
            columns: [
                // {'orderData': 0, data: 'bidangusahaid', name: 'bidangusahaid'},
                {'orderData': 1, data: 'bidangvw',
                    render: function ( data, type, row ) {
                        return (row.bidangparent ? row.bidangparent.kode + ' ' + row.bidangparent.bidang : '-');
                    }, 
                    name: 'bidang'},
                {'orderData': 2, data: 'bidangusaha',
                    render: function ( data, type, row ) {
                        return row.kode + ' ' + row.bidangusaha;
                    }, 
                    name: 'bidangusaha'}
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
        
        $('#bidangid').change( function() { 
            bidangusahatable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                bidangusahatable.draw();
            }
        });

    });
</script>

@endsection