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
        <h5 class="card-title text-uppercase">DAFTAR KEBUTUHAN SARPRAS</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
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
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                                {{-- @foreach ($kecamatan as $item)
                                    <option value="{{$item->kecamatanid}}">{{  $item->kodekec . ' ' . $item->namakec }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="form-group row">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
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
                <div class="col-md-6 @if($isSekolah) d-none @endif">
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
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sekolahid" class="col-md-12 col-form-label text-md-left">{{ __('Sekolah') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="sekolahid" class="col-md-12 custom-select form-control" name='sekolahid' autofocus {{ $isSekolah ? 'disabled' : '' }}>
                                <option value="{{ $isSekolah ? $userSekolah->sekolahid : ''}}">{{ $isSekolah ? $userSekolah->namasekolah : '-- Pilih Sekolah --' }}</option>
                                @foreach ($sekolah as $item)
                                    <option  {{ $oldsekolahid != '' ? ($oldsekolahid == $item->sekolahid ? 'selected' : '') : '' }} value="{{$item->sekolahid}}">{{  $item->namasekolah }}</option>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="sarpras-kebutuhan-table">
                        <thead>
                            <tr>
                                <th>Nama Sekolah</th>
                                <th>Jenis Kebutuhan</th>
                                <th>No. Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Sarpras</th>
                                <th>Jenis Sarpras</th>
                                <th>Jumlah</th>
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

        @if (Session::has('oldsekolahid'))
            // toastr.success('{{ Session::get('oldsekolahid') }}');
            $('#sekolahid').val('{{ Session::get('oldsekolahid') }}');
            $('#sekolahid').trigger('change');
            console.log('{{ Session::get('oldsekolahid') }}');
        @endif

        // $('#kotaid').select2().on('change', function() {
        //     var url = "{{ route('sarpraskebutuhan.getSekolah', ':parentid') }}";
        //     url = url.replace(':parentid', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function(data) {
        //             $('#sekolahid').empty();
        //             $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
        //             $.each(data.data, function(key, value) {
        //                 $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
        //             });
        //             $('#sekolahid').select2();
        //             // $('#sekolahid').val(sekolahid);
        //             $('#sekolahid').trigger('change');

        //         }
        //     })
        // })
        $('.custom-select').select2();
    
        var sarpraskebutuhantable = $('#sarpras-kebutuhan-table').DataTable({
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
                url: "{{ route('sarpraskebutuhan.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "sekolahid": $("#sekolahid").val().toLowerCase(),
                        "jenjang": $("#jenjang").val().toLowerCase(),
                        "jenis": $("#jenis").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-plus-circle" aria-hidden="true"></i> Pengajuan Kebutuhan Sarpras',
                    className: 'edit btn btn-info mb-3 btn-datatable',
                    action: function(event) {

                        if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diajukan", "error");
                            return;
                        }
                        var id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                        var url = "{{ route('sarpraskebutuhan.pengajuan', ':id') }}"
                        url = url.replace(':id', id);

                        let status = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['status']

                        if(status > 1){
                            if(status == 2){
                                swal.fire('Error!', 'Status sudah dalam pengajuan, dalam proses verifikasi', 'error')
                            }
                            else if(status == 3){
                                swal.fire('Error!', 'Tidak dapat mengajukan data yang sudah DISETUJUI', 'error')
                            }
                            else if(status == 5) {
                                swal.fire('Error!', 'Tidak Dapat mengajukan data yang sudah berstatus PROSES TENDER', 'error')
                            }
                            else if(status == 4){
                                swal.fire('Error!', 'Status pengajuan adalah ditolak', 'error')
                            }
                        }else{
                            swal.fire({
                                title: "Konfirmasi",   
                                text: "Apakah anda yakin untuk pengajuan sarpras?",   
                                icon: "warning",   
                                showCancelButton: true,   
                                confirmButtonText: "Ya, lanjutkan!",   
                                closeOnConfirm: false 
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // event.preventDefault(); // Prevent the default link behavior

                                    // var sekolahId = $('#sekolahid').val();
                                    // if (sekolahId === '') {
                                    //     swal.fire("Error", "Silakan pilih sekolah terlebih dahulu", "error");
                                    // } else {
                                    //     var url = "{{  route('sarpraskebutuhan.createBySekolahId', ['sekolahid' => ':id']) }}";
                                    //     url = url.replace(':id', sekolahId);
                                    //     window.location.href = url;
                                    // }

                                    // if(status > 1){
                                    //     if(status == 2){
                                    //         swal.fire('Error!', 'Status sudah dalam pengajuan, dalam proses verifikasi', 'error')
                                    //     }
                                    //     else if(status == 3){
                                    //         swal.fire('Error!', 'Tidak dapat mengajukan data yang sudah DISETUJUI', 'error')
                                    //     }
                                    //     else if(status == 4){
                                    //         swal.fire('Error!', 'Status pengajuan adalah ditolak')
                                    //     }
                                    // }else{
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: "POST",
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
                                                    swal.fire("Berhasil!", "Data anda telah diajukan.", "success"); 
                                                    sarpraskebutuhantable.draw();
                                                }
                                                else {
                                                    swal.fire("Error!", data, "error"); 
                                                }
                                            }
                                        });  
                                    // }
                                }           
                            });
                        }
                    }
                },
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function() {

                        if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                            var url = "{{ route('sarpraskebutuhan.show', ':id') }}"
                            url = url.replace(':id', id);
                            window.location = url;
                        }
                    }
                },
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        let status = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['status']

                        if(status == 3){
                            swal.fire('Error!', 'Tidak dapat mengubah data yang sudah berstatus DISETUJUI', 'error');
                        }else if(status == 5) {
                            swal.fire('Error!', 'Tidak dapat mengubah data yang sudah berstatus PROSES TENDER', 'error');
                        }else{
                            var id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                            var url = "{{ route('sarpraskebutuhan.edit', ':id') }}"
                            url = url.replace(':id', id);
                            window.location = url;
                        }
                    }
                }, 
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }

                        let status = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['status']

                        if (status == 2) {
                            swal.fire('Error!', 'Data yang sedang dalam pengajuan tidak dapat dihapus', 'error');
                        }else if(status == 3) {
                            swal.fire('Error!', 'Tidak dapat menghapus, data telah disetujui pada verifikasi permintaan sarpras', 'error');
                        }else if(status == 5) {
                            swal.fire('Error!', 'Tidak dapat menghapus, data sudah berstatus proses tender', 'error');
                        }else {
                            var id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
                            var url = "{{ route('sarpraskebutuhan.destroy', ':id') }}"
                            url = url.replace(':id', id);
                            // var nama =  sarpraskebutuhantable.rows( { selected: true } ).data()[0]['namasekolah'];
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
                                                sarpraskebutuhantable.draw();
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
                {'orderData': 1, data: 'namasekolah', name: 'namasekolah'},
                {'orderData': 2, data: 'jeniskebutuhan', name: 'jeniskebutuhan',
                    render: function(data, type, row) {
                        if(row.jeniskebutuhan != null) {
                            var listJenisKebutuhan = @json(enum::listJenisKebutuhan($id = ''));
                            // let listJenisKebutuhan = JSON.parse('{!! json_encode(enum::listJenisKebutuhan()) !!}');
                            let Desc;
                            listJenisKebutuhan.forEach((value, index) => {
                                if(row.jeniskebutuhan == index + 1) {
                                    Desc = value;
                                }
                            });
                            return Desc;
                        }else {
                            return '---'
                        }
                    }
                },
                {'orderData': 3, data: 'nopengajuan', name: 'nopengajuan'},
                {'orderData': 4, data: 'tglpengajuan', name: 'tglpengajuan',
                    render: function(data, type, row) {
                        if(row.tglpengajuan != null) {
                            return DateFormat(row.tglpengajuan)
                        }
                        else{
                            return '-'
                        }
                    }
                },
                // {'orderData': 4, data: 'namasarprasid', name: 'namasarprasid'},
                {'orderData': 5, data: 'namasarprasid',
                    render: function ( data, type, row ) {
                        if(row.namasarprasid!=null){
                            return row.namasarpras;
                        }else
                            return "-";
                    }, 
                    name: 'namasarprasid'},
                // {'orderData': 5, data: 'jenissarpras', name: 'jenissarpras'},
                {'orderData': 6, data: 'jenissarpras',
                    render: function ( data, type, row ) {
                        if(row.jenissarpras!=null){
                            if(row.jenissarpras=="{{enum::SARPRAS_UTAMA}}") 
                                return 'Sarpras Peralatan';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PERALATAN}}") 
                                return 'Sarpas Peralatan';
                            else if(row.jenissarpras=="{{enum::SARPRAS_PENUNJANG}}") 
                                return 'Sarpras Penunjang';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'jenissarpras'},
                {'orderData': 7, data: 'jumlah', name: 'jumlah',
                    render: function(data, type, row) {
                        if(row.jumlah != null) {
                            return `${row.jumlah} ${row.satuan != null ? row.satuan : ''}`
                        }
                    }
                },
                {'orderData': 8, data: 'status', 
                    render: function(data, type, row){
                        if(row.status != null){
                            if(row.status == 1){
                                return '<span class="badge badge-pill bg-draft">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT }}</span>';
                            }else if(row.status == 2){
                                return '<span class="badge badge-pill bg-info">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN }}</span>';
                            }else if (row.status == 3){
                                return '<span class="badge badge-pill bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI }}</span>';
                            }else if (row.status == 5){
                                return '<span class="badge badge-pill bg-primary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROSES_TENDER }}</span>';
                            }else if (row.status == 6){
                                return '<span class="badge badge-pill bg-secondary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_PEMBANGUNAN }}</span>';
                            }else{
                                return '<span class="badge badge-pill bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                            }
                        }else{
                            return '-'
                        }
                    },
                    name: 'status',
                },
                // {'orderData': 3, data: 'kotaid',
                //     render: function ( data, type, row ) {
                //         return (row.namakota);
                //     }, 
                //     name: 'namakota'},
                // {'orderData': 5, data: 'jenis',
                //     render: function ( data, type, row ) {
                //         if(row.jenis!=null){
                //             if(row.jenis=="{{enum::JENIS_NEGERI}}") 
                //                 return '{{enum::JENIS_DESC_NEGERI}}';
                //             else if(row.jenis=="{{enum::JENIS_SWASTA}}") 
                //                 return '{{enum::JENIS_DESC_SWASTA}}';
                //             else return "-";
                //         }else
                //             return "-";
                //     }, 
                //     name: 'jenis'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        // FILTER SEKOLAH - START

        $('#kotaid').select2().on('select2:select', function() {

            var urlSekolahKota = "{{ route('helper.getsekolahkota', ':id') }}";
            urlSekolahKota = urlSekolahKota.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: urlSekolahKota,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                }
            })

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

            if($('#kecamatanid').val() == '' && $('#jenjang').val() != '' && $('#jenis').val() != '') {
                var urlSekolahKotaJenjangJenis = "{{ route('helper.getSekolahKotaJenjangJenis', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang', 'jenis' => ':jenis']) }}";
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':kotaid', $('#kotaid').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenjang', $('#jenjang').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenis', $('#jenis').val() == "" );

                $.ajax({
                    url: urlSekolahKotaJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                    }
                })
            }
        })
        $('#kecamatanid').select2().on('select2:select', function() {
            var jenis = $('#jenis').val();
            var jenjang = $('#jenjang').val();
            url = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
            url = url.replace(':jenis', ($('#jenis').val() == "" || $('#jenis').val() == null ? "-1" : $('#jenis').val()));
            url = url.replace(':jenjang', ($('#jenjang').val() == "" || $('#jenjang').val() == null ? "-1" : $('#jenjang').val()));
            url = url.replace(':kecamatanid', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()))
            // var url = "{{ route('helper.getkecamatan', ':id') }}";
            // url = url.replace(':id', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()));

            var urlSekolah = "{{ route('helper.getsekolah', ':id') }}";
            urlSekolah = urlSekolah.replace(':id', $('#kecamatanid').val())

            $.ajax({
                url: urlSekolah,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                    $('#detail-sarpras-table').hide();
                    $('#detail-jumlah-sarpras-table').hide();

                }
            })

            if($('#kecamatanid').val() != '' && $('#jenjang').val() != '' && $('#jenis').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenjang').select2().on('select2:select', function() {
            sarpraskebutuhantable.draw();
            if($('#kecamatanid').val() != '' && $('#kotaid').val() != '') {
                var urlSekolah = "{{ route('helper.getsekolahjenjang', ['kecamatanid' => ':kecamatanid', 'jenjang' => ':jenjang']) }}";
                urlSekolah = urlSekolah.replace(':kecamatanid', $('#kecamatanid').val());
                urlSekolah = urlSekolah.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolah,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() != '' && $('#kecamatanid').val() == '') {
                var urlSekolahKotaJenjang = "{{ route('helper.getSekolahKotaJenjang1', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang']) }}";
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':kotaid', $('#kotaid').val());
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahKotaJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() == '' && $('#kecamatanid').val() == '') {
                var urlSekolahJenjang = "{{ route('helper.getsekolahjenjang2', ['jenjang' => ':jenjang']) }}";
                urlSekolahJenjang = urlSekolahJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenis').select2().on('select2:select', function(){
            sarpraskebutuhantable.draw();
            if($('#kecamatanid').val() != '' && $('#jenjang').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() != '' && $('#jenjang').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjeniskecamatan', ['jenis' => ':jenis', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjenisjenjang', ['jenis' => ':jenis', 'jenjang' => ':jenjang']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '' && $('#jenjang').val() == ''){
                var urlSekolahJenis = "{{ route('helper.getsekolahjenis2', ':jenis') }}";
                urlSekolahJenis = urlSekolahJenis.replace(':jenis', $('#jenis').val());

                $.ajax({
                    url: urlSekolahJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        })

        // FILTER SEKOLAH - END

        // $('#jenis').change( function() { 
        //     sarpraskebutuhantable.draw();
        // });
        // $('#jenjang').change( function() { 
        //     sarpraskebutuhantable.draw();
        // });
        $('#sekolahid').change( function() { 
            sarpraskebutuhantable.draw();
        });

        // $('#sekolahid').change( function() { 
        //     sarpraskebutuhantable.draw();
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
                sarpraskebutuhantable.draw();
            }
        });

        $('#btnTambah').click(function (event) {
            event.preventDefault(); // Prevent the default link behavior

            var sekolahId = $('#sekolahid').val();
            if (sekolahId === '') {
                swal.fire("Silakan pilih sekolah terlebih dahulu", "", "error");
            } else {
                var url = "{{  route('sarpraskebutuhan.createBySekolahId', ['sekolahid' => ':id']) }}";
                url = url.replace(':id', sekolahId);
                window.location.href = url;
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