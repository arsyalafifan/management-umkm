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
        <h5 class="card-title text-uppercase">DAFTAR STOCK</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="search" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                        </div>
                        <div class="col-md-9">
                            <input id="search" type="text" class="col-md-12 form-control" name="search" value="{{ old('search') }}" maxlength="100" autocomplete="search" placeholder="-- Filter --">
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
                    <table class="table table-bordered yajra-datatable table-striped" id="stock-management-table">
                        <thead>
                            <tr>
                                <th>Kode Stok</th>
                                <th>Nama Stok</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>stockid</th>
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
    
        var stockmanagementable = $('#stock-management-table').DataTable({
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
                url: "{{ route('stockmanagement.index') }}",
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
                // {
                //     text: '<i class="fa fa-plus-circle" aria-hidden="true"></i> Pengajuan Kebutuhan Sarpras',
                //     className: 'edit btn btn-info mb-3 btn-datatable',
                //     action: function(event) {

                //         if (stockmanagementable.rows( { selected: true } ).count() <= 0) {
                //             swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diajukan", "error");
                //             return;
                //         }
                //         var id = stockmanagementable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                        
                //         url = url.replace(':id', id);

                //         let status = stockmanagementable.rows( { selected: true } ).data()[0]['status']

                //         if(status > 1){
                //             if(status == 2){
                //                 swal.fire('Error!', 'Status sudah dalam pengajuan, dalam proses verifikasi', 'error')
                //             }
                //             else if(status == 3){
                //                 swal.fire('Error!', 'Tidak dapat mengajukan data yang sudah DISETUJUI', 'error')
                //             }
                //             else if(status == 5) {
                //                 swal.fire('Error!', 'Tidak Dapat mengajukan data yang sudah berstatus PROSES TENDER', 'error')
                //             }
                //             else if(status == 4){
                //                 swal.fire('Error!', 'Status pengajuan adalah ditolak', 'error')
                //             }
                //         }else{
                //             swal.fire({
                //                 title: "Konfirmasi",   
                //                 text: "Apakah anda yakin untuk pengajuan sarpras?",   
                //                 icon: "warning",   
                //                 showCancelButton: true,   
                //                 confirmButtonText: "Ya, lanjutkan!",   
                //                 closeOnConfirm: false 
                //             }).then((result) => {
                //                 if (result.isConfirmed) {
                //                         $.ajaxSetup({
                //                             headers: {
                //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //                             }
                //                         });
                //                         $.ajax({
                //                             type: "POST",
                //                             cache:false,
                //                             url: url,
                //                             dataType: 'JSON',
                //                             data: {
                //                                 "_token": $('meta[name="csrf-token"]').attr('content')
                //                             },
                //                             success: function(json){
                //                                 var success = json.success;
                //                                 var message = json.message;
                //                                 var data = json.data;
                //                                 console.log(data);
                                                
                //                                 if (success == 'true' || success == true) {
                //                                     swal.fire("Berhasil!", "Data anda telah diajukan.", "success"); 
                //                                     stockmanagementable.draw();
                //                                 }
                //                                 else {
                //                                     swal.fire("Error!", data, "error"); 
                //                                 }
                //                             }
                //                         });  
                //                     // }
                //                 }           
                //             });
                //         }
                //     }
                // },
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function() {

                        if (stockmanagementable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var id = stockmanagementable.rows( { selected: true } ).data()[0]['stockid'];
                            var url = "{{ route('stockmanagement.show', ':id') }}"
                            url = url.replace(':id', id);
                            window.location = url;
                        }
                    }
                },
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (stockmanagementable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        let status = stockmanagementable.rows( { selected: true } ).data()[0]['status']

                        if(status == 3){
                            swal.fire('Error!', 'Tidak dapat mengubah data yang sudah berstatus DISETUJUI', 'error');
                        }else if(status == 5) {
                            swal.fire('Error!', 'Tidak dapat mengubah data yang sudah berstatus PROSES TENDER', 'error');
                        }else{
                            var id = stockmanagementable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                            var url = "{{ route('stockmanagement.edit', ':id') }}"
                            url = url.replace(':id', id);
                            window.location = url;
                        }
                    }
                }, 
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (stockmanagementable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }

                        let status = stockmanagementable.rows( { selected: true } ).data()[0]['status']

                        if (status == 2) {
                            swal.fire('Error!', 'Data yang sedang dalam pengajuan tidak dapat dihapus', 'error');
                        }else if(status == 3) {
                            swal.fire('Error!', 'Tidak dapat menghapus, data telah disetujui pada verifikasi permintaan sarpras', 'error');
                        }else if(status == 5) {
                            swal.fire('Error!', 'Tidak dapat menghapus, data sudah berstatus proses tender', 'error');
                        }else {
                            var id = stockmanagementable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                            var url = "{{ route('stockmanagement.destroy', ':id') }}"
                            url = url.replace(':id', id);
                            // var nama =  stockmanagementable.rows( { selected: true } ).data()[0]['namasekolah'];
                            swal.fire({   
                                title: "Apakah anda yakin akan menghapus data ini?",   
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
                                                stockmanagementable.draw();
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
                }]
            },
            columns: [
                {'orderData': 1, data: 'kodestock', name: 'kodestock'},
                {'orderData': 2, data: 'namastock', name: 'namastock',
                    // render: function(data, type, row) {
                    //     if(row.jeniskebutuhan != null) {
                    //         var listJenisKebutuhan = @json(enum::listJenisKebutuhan($id = ''));
                    //         // let listJenisKebutuhan = JSON.parse('{!! json_encode(enum::listJenisKebutuhan()) !!}');
                    //         let Desc;
                    //         listJenisKebutuhan.forEach((value, index) => {
                    //             if(row.jeniskebutuhan == index + 1) {
                    //                 Desc = value;
                    //             }
                    //         });
                    //         return Desc;
                    //     }else {
                    //         return '---'
                    //     }
                    // }
                },
                {'orderData': 3, data: 'jumlah', name: 'jumlah'},
                {'orderData': 4, data: 'harga', name: 'harga',
                    render: function(data, type, row) {
                        if(row.harga != null) {
                            return rupiah(row.harga)
                        }
                        else{
                            return '-'
                        }
                    }
                },
                {'orderData': 5, data: 'stockid', name: 'stockid', visible: false},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        // $('#jenis').change( function() { 
        //     stockmanagementable.draw();
        // });
        // $('#jenjang').change( function() { 
        //     stockmanagementable.draw();
        // });
        $('#sekolahid').change( function() { 
            stockmanagementable.draw();
        });

        // $('#sekolahid').change( function() { 
        //     stockmanagementable.draw();
        // });
        $('#sekolahid').trigger('change');

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                stockmanagementable.draw();
            }
        });

    });
</script>
{{-- <script>

    const sekolahid = document.getElementById("sekolahid");
	
    window.onload = function() {
        localStorage.setItem("sekolahid", $('#sekolahid').val());
        // localStorage.setItem("email", $('#inputEmail').val());   
    }
    
    var test = localStorage.getItem('sekolahid');
    $('#sekolahid').val(test);

    $('#sekolahid').on('change', function(e) {
        localStorage.setItem("sekolahid", $('#sekolahid').val());

    })

</script> --}}

{{-- <script>

    const sekolahid = document.getElementById("sekolahid");
	
    window.onload = function() {
        localStorage.setItem("sekolahid", $('#sekolahid').val());
        // localStorage.setItem("email", $('#inputEmail').val());   
    }
    
    var test = localStorage.getItem('sekolahid');
    $('#sekolahid').val(test);

  
    var href = window.location.href;
    
    if(href.match('sarpraskebutuhan')[0] == 'sarpraskebutuhan') {
        $('#sekolahid').on('change', function(e) {
        localStorage.setItem("sekolahid", $('#sekolahid').val());
        console.log(href.match('sarpraskebutuhan')[0]);
        console.log(window.location.href);
        })
    }else {
        localStorage.setItem("sekolahid", '')
    }
</script> --}}

@endsection