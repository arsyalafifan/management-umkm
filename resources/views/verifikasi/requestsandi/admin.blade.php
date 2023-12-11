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
<div id="modalFormVerifikasi" class="modal fade" role="dialog" aria-labelledby="titleFormVerifikasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleFormVerifikasi">Verifikasi Request Sandi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="tolakForm">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="keterangan" class="col-md-3 col-form-label text-md-left">{{ __('Alasan') }}</label>
                            <div class="col-md-9">
                                <textarea id="keterangan" type="text" class="form-control" name="keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" onclick="verifikasi();"">Verifikasi</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR REQUEST SANDI</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="instansi" class="col-md-12 col-form-label text-md-left">{{ __('Instansi') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="instansi" class="col-md-12 custom-select form-control" name='instansi' autofocus>
                                <option value="">-- Semua --</option>
                                <option value="0">{{ 'Perusahaan' }}</option>
                                <option value="1">{{ 'Tenaga Kerja' }}</option>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="requestsandi-table">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan / Nama Tenaga Kerja</th>
                                <th>NIB / NIK</th>
                                <th>Instansi</th>
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
    var requestSanditable = null;

    $(document).ready(function () {
        $('.custom-select').select2();
    
        requestSanditable = $('#requestsandi-table').DataTable({
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
                url: "{{ route('requestsandi.admin') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "instansi": $("#instansi").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (requestSanditable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = requestSanditable.rows( { selected: true } ).data()[0]['requestsandiid'];
                        var url = "{{ route('requestsandi.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                },
                {
                    text: 'Terima',
                    className: 'edit btn btn-success btn-sm btn-datatable',
                    action: function () {
                        if (requestSanditable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diterima", "error");
                            return;
                        }
                        $status = requestSanditable.rows( { selected: true } ).data()[0]['status'];

                        if(parseInt($status)!==0) {
                            swal("Request Sandi", "Data tidak boleh diubah", "error");
                            return;
                        }

                        var id = requestSanditable.rows( { selected: true } ).data()[0]['requestsandiid'];
                        var url = "{{ route('requestsandi.terima') }}";
                        var nama =  requestSanditable.rows( { selected: true } ).data()[0]['nama'];
                        swal({   
                            title: "",   
                            text: "Apakah benar anda akan MENERIMA Request Sandi dan selanjutnya akan dikirimkan password kepada " + nama + "?",   
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
                                        requestSanditable.draw();
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
                    text: 'Tolak',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (requestSanditable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan ditolak", "error");
                            return;
                        }
                        $status = requestSanditable.rows( { selected: true } ).data()[0]['status'];

                        if(parseInt($status)!==0) {
                            swal("Request Sandi", "Data tidak boleh diubah", "error");
                            return;
                        }

                        $('#modalFormVerifikasi').modal('show');
                        return;
                    }
                }
                ]
            },
            columns: [
                {'orderData': 1, data: 'nama', name: 'nama'},
                {'orderData': 2, data: 'instansi',
                    render: function ( data, type, row ) {
                        if(row.instansi=="0")  return row.nib;
                        else if(row.instansi=="1")  return row.nik;
                        else return "-";
                    }, 
                },
                {'orderData': 3, data: 'instansi',
                    render: function ( data, type, row ) {
                        if(row.instansi=="0")  return 'Perusahaan';
                        else if(row.instansi=="1")  return 'Tenaga Kerja'
                        else return "-";
                    }, 
                },
                {data: 'status',
                render: function ( data, type, row ) {
                    if (row.status != null && row.status == '0') {
                        return '<span class="badge badge-pill badge-secondary">Menunggu Verifikasi</span>';
                    }
                    else if (row.status != null && row.status == '1') {
                        return '<span class="badge badge-pill badge-success">Diterima</span>';
                    }
                    else if (row.status != null && row.status == '2') {
                        return '<span class="badge badge-pill badge-danger">Ditolak</span>';
                    }
                }, 
                name: 'status'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#instansi').change( function() { 
            requestSanditable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                requestSanditable.draw();
            }
        });

    });

    function verifikasi() {
        let keterangan = $("#keterangan").val();
        if(keterangan == "" || keterangan == null){
            swal("Request Sandi", "Alasan tidak boleh kosong", "error");
            return;
        }
        var id = requestSanditable.rows( { selected: true } ).data()[0]['requestsandiid'];
        var url = "{{ route('requestsandi.tolak') }}";
        var nama =  requestSanditable.rows( { selected: true } ).data()[0]['nama'];
        swal({   
            title: "",   
            text: "Apakah benar anda akan MENOLAK Request Sandi dari " + nama + "?",   
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
                data: {
                    id: id,
                    keterangan: keterangan
                },
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
                        $('#modalFormVerifikasi').modal('hide');
                        requestSanditable.draw();
                    }
                    else {
                        swal("Error!", data, "error"); 
                    }
                }
            });                
        });
    }
</script>

@endsection