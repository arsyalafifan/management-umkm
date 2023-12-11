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
        <h5 class="card-title text-uppercase">DAFTAR KELURAHAN</h5><hr />
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
                                    <option value="{{$item->kotaid}}">{{ $item->namaprov . ' - ' . $item->kodekota . ' ' . $item->namakota }}</option>
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
                                    <option value="{{$item->kecamatanid}}">{{ $item->kodekec . ' ' . $item->namakec }}</option>
                                @endforeach
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
                    <table class="table table-bordered yajra-datatable table-striped" id="kelurahan-table">
                        <thead>
                            <tr>
                                <!-- <th>Kelurahan ID</th> -->
                                <th>Nama Kota/Kabupaten</th>
                                <th>Nama Kecamatan</th>
                                <th>Kode Kelurahan</th>
                                <th>Nama Kelurahan</th>
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
    var v_listDataKecamatan = <?php echo json_encode($kecamatan); ?>;

    $(document).ready(function () {
        $('.custom-select').select2();
    
        var kelurahantable = $('#kelurahan-table').DataTable({
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
                url: "{{ route('kelurahan.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        "kotaid": $("#kotaid").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (kelurahantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = kelurahantable.rows( { selected: true } ).data()[0]['kelurahanid'];
                        var url = "{{ route('kelurahan.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (kelurahantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = kelurahantable.rows( { selected: true } ).data()[0]['kelurahanid'];
                        var url = "{{ route('kelurahan.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (kelurahantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = kelurahantable.rows( { selected: true } ).data()[0]['kelurahanid'];
                        var url = "{{ route('kelurahan.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var kode =  kelurahantable.rows( { selected: true } ).data()[0]['kodekel'];
                        var nama =  kelurahantable.rows( { selected: true } ).data()[0]['namakel'];
                        swal({   
                            title: "Apakah anda yakin akan menghapus Kelurahan " + nama + "?",   
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
                                        kelurahantable.draw();
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
                // {'orderData': 0, data: 'kelurahanid', name: 'kelurahanid'},
                {'orderData': 1, data: 'namakota',
                    render: function ( data, type, row ) {
                        return row.kodekota + ' ' + row.namakota;
                    }, 
                    name: 'kotaview'},
                {'orderData': 2, data: 'namakec',
                    render: function ( data, type, row ) {
                        return row.kodekec + ' ' + row.namakec;
                    }, 
                    name: 'kecview'},
                {'orderData': 3, data: 'kodekel',
                    render: function ( data, type, row ) {
                        return row.kodekel;
                    }, 
                    name: 'kodekel'},
                {'orderData': 4, data: 'namakel', name: 'namakel'},
                {data: 'status',
                render: function ( data, type, row ) {
                    if (row.status != null && row.status != '0') {
                        return '<span class="badge badge-pill badge-success">Aktif</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                    }
                }, 
                name: 'status'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
    
        $('#kecamatanid').change( function() { 
            kelurahantable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                kelurahantable.draw();
            }
        });

        $('#kotaid').change( function() {
            $('#kecamatanid').empty();
            $('#kecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
            var v_filter = v_listDataKecamatan;
            if ($('#kotaid').val() != '') {
                v_filter = v_listDataKecamatan.filter(function (p_element) {
                    return p_element.kotaid == $('#kotaid').val();
                });
            }
            if (v_filter != null && v_filter != '') {
                $.each( v_filter, function( p_key, p_value ) {
                    $('#kecamatanid').append($("<option></option>").attr("data-kota", p_value.kotaid).attr("data-kode", p_value.kodekec).attr("data-nama", p_value.namakec).attr("value", p_value.kecamatanid).text(p_value.kodekec + ' ' + p_value.namakec));
                });
                $('#kecamatanid').select2();
                $('#kecamatanid').val('').trigger('change');
            }        

            kelurahantable.draw();
        });

    });
</script>

@endsection