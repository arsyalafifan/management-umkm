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
<div id="formImport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titleImport" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleImport">Import Data Tenaga Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Pilih file excel :<label><br>
                            <input type="file" id="fileexcel" name="fileexcel" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                        <div class="col-lg-12">
                            <b>Unduh format excel: </b><a href="{{ route('naker.downloadformatexcel') }}">Download</a>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-danger" id="judulerrorexcel" style="display: none;">Impor tidak dapat dilakukan, lengkapi kolom pada file excel!</div>
                            <div class="text-danger" id="diverrorexcel"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn btn-info waves-effect" onclick="confirmImport();" >Jalankan</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="formGenerateUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titleGenerateUser" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: none; width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleGenerateUser">Generate User Tenaga Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="height: 75vh; max-height: 75vh; overflow-y: auto;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6"><p>Daftar Tenaga Kerja yang belum memiliki user:</p></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="searchnouser" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="searchnouser" type="text" class="col-md-12 form-control" name="searchnouser" value="" maxlength="100" autocomplete="searchnouser">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="perusahaanidnouser" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan') }}</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="perusahaanidnouser" class="col-md-12 custom-select-generate form-control" name='perusahaanidnouser' autofocus>
                                                <option value="">-- Pilih Perusahaan --</option>
                                                @foreach ($perusahaan as $item)
                                                    <option value="{{$item->perusahaanid}}" @if (!is_null($perusahaanid) && $perusahaanid == $item->perusahaanid) selected @endif>{{ $item->kodedaftar .' '. $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="naker-nouser-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama Tenaga Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6"><p>Daftar Tenaga Kerja yang akan digenerate user:</p></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="searchgenerateuser" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="searchgenerateuser" type="text" class="col-md-12 form-control" name="searchgenerateuser" value="" maxlength="100" autocomplete="searchgenerateuser">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="naker-generateuser-table">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama Tenaga Kerja</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" onclick="confirmGenerate();" >Jalankan</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR TENAGA KERJA</h5><hr />
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
                    <table class="table table-bordered yajra-datatable table-striped" id="naker-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status Pekerjaan</th>
                                <th>Masa Kerja</th>
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
    var nakertable = null;
    var nakernousertable = null;
    var nakergenerateusertable = null;

    $(document).ready(function () {
        $('.custom-select').select2();
        
        $('.custom-select-generate').select2({
            dropdownParent: $("#formGenerateUser .modal-content")
        });

        nakertable = $('#naker-table').DataTable({
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
                url: "{{ route('naker.index') }}",
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
                    text: 'Import Data',
                    className: 'importnaker btn btn-info btn-sm btn-datatable',
                    action: function () {
                        addData();
                        return;
                    }
                },
                {
                    text: 'Generate User',
                    className: 'generateusr btn btn-success btn-sm btn-datatable',
                    action: function () {
                        showGenerateForm();
                        return;
                    }
                },
                /*{
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (nakertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = nakertable.rows( { selected: true } ).data()[0]['nakerid'];
                        var url = "{{ route('naker.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                },*/ {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (nakertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = nakertable.rows( { selected: true } ).data()[0]['nakerid'];
                        var url = "{{ route('naker.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (nakertable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = nakertable.rows( { selected: true } ).data()[0]['nakerid'];
                        var url = "{{ route('naker.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var nama =  nakertable.rows( { selected: true } ).data()[0]['namalengkap'];
                        swal({   
                            title: "Apakah anda yakin akan menghapus Tenaga Kerja " + nama + "?",   
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
                                        nakertable.draw();
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
                {'orderData': 1, data: 'user',
                    render: function ( data, type, row ) {
                        if(row.user_count<1) return "<span class='text-danger'><b>X</b></span>";
                        else return "<span class='text-success'><b>V</b></span>";
                    }, 
                    name: 'user'},
                {'orderData': 2, data: 'nik', name: 'nik'},
                {'orderData': 3, data: 'namalengkap', name: 'namalengkap'},
                {'orderData': 4, data: 'latestriwayatkerja',
                    render: function ( data, type, row ) {
                        if(row.latestriwayatkerja!=null){
                            if(row.latestriwayatkerja.statuspekerjaan=="{{enum::STATUS_PEKERJAAN_FULL_TIME}}") 
                                return 'Karyawan (full time)';
                            else if(row.latestriwayatkerja.statuspekerjaan=="{{enum::STATUS_PEKERJAAN_PART_TIME}}") 
                                return 'Karyawan paruh waktu (part time)';
                            else if(row.latestriwayatkerja.statuspekerjaan=="{{enum::STATUS_PEKERJAAN_WIRAUSAHA}}") 
                                return 'Wirausaha';
                            else if(row.latestriwayatkerja.statuspekerjaan=="{{enum::STATUS_PEKERJAAN_PEKERJA_LEPAS}}") 
                                return 'Pekerja Lepas';
                            else if(row.latestriwayatkerja.statuspekerjaan=="{{enum::STATUS_PEKERJAAN_MAGANG}}") 
                                return 'Magang (intern)';
                            else return "-";
                        }else
                            return "-";
                    }, 
                    name: 'lamabekerja'},
                {'orderData': 5, data: 'latestriwayatkerja',
                    render: function ( data, type, row ) {
                        if(row.latestriwayatkerja!=null){
                            return row.latestriwayatkerja.lamabekerja;
                        }else
                            return "-";
                    }, 
                    name: 'lamabekerja'},
                {'orderData': 6, data: 'latestriwayatkerja',
                    render: function ( data, type, row ) {
                        if(row.latestriwayatkerja!=null){
                            if(row.latestriwayatkerja.perusahaan!=null){
                                return row.latestriwayatkerja.perusahaan.nama;
                            }else{
                                return "-";    
                            }
                        }else
                            return "-";
                    }, 
                    name: 'lamabekerja'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
        
        nakernousertable = $('#naker-nouser-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
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
                url: "{{ route('naker.nakernouser') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    let excludeids = [];
                    if(nakergenerateusertable!=null){
                        let data = nakergenerateusertable.rows().data();

                        for (var i=0; i < data.length ;i++){
                            excludeids.push(data[i]["nakerid"]);
                        }
                    }
                    return $.extend( {}, d, {
                        "search": $("#searchnouser").val().toLowerCase(),
                        "excludeids": excludeids,
                        "perusahaanid": $("#perusahaanidnouser").val()
                    } );
                }
            },
            buttons: {
                buttons: [
                    {
                        text: 'Tambahkan ke Daftar Tenaga Kerja yang akan digenerate user',
                        className: 'addgenerate btn btn-info btn-sm btn-datatable',
                        action: function () {
                            let data = nakernousertable.rows( { selected: true } ).data();

                            if(data.length>0){
                                for (var i=0; i < data.length ;i++){
                                    var indexes = nakergenerateusertable
                                      .rows()
                                      .indexes()
                                      .filter( function ( value, index ) {
                                        return data[i]["nakerid"] === nakergenerateusertable.row(value).data()["nakerid"];
                                      })

                                    if (indexes[0] === undefined) nakergenerateusertable.row.add(data[i]).draw();
                                }

                                nakernousertable.draw();
                            }
                        }
                    }
                ]
            },
            columns: [
                {'orderData': 1, data: 'nik', name: 'nik'},
                {'orderData': 2, data: 'namalengkap', name: 'namalengkap'}
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        nakergenerateusertable = $('#naker-generateuser-table').DataTable({
            responsive: true,
            // processing: true,
            // serverSide: true,
            pageLength: 10,
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
            buttons: {
                buttons: [
                    {
                        text: 'Hapus dari Daftar Tenaga Kerja yang akan digenerate user',
                        className: 'addgenerate btn btn-danger btn-sm btn-datatable',
                        action: function () {
                            let data = nakergenerateusertable.rows( { selected: true } ).data();

                            if(data.length>0){
                                nakergenerateusertable.rows( '.selected' ).remove().draw();
                                nakernousertable.draw();
                            }
                        }
                    }
                ]
            },
            columns: [
                {'orderData': 1, data: 'nik', name: 'nik'},
                {'orderData': 2, data: 'namalengkap', name: 'namalengkap'}
            ],
            // initComplete: function (settings, json) {
            //     $(".btn-datatable").removeClass("dt-button");
            // },
            //order: [[1, 'asc']]
        });

        $('#perusahaanid').change( function() { 
            nakertable.draw();
        });

        $('#perusahaanidnouser').change( function() { 
            nakernousertable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                nakertable.draw();
            }
        });

        $('#searchnouser').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#searchnouser').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                nakernousertable.draw();
            }
        });

        $('#searchgenerateuser').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#searchgenerateuser').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                nakergenerateusertable.search(this.value).draw();
            }
        });

    });

    function confirmImport(){
        if ($('#fileexcel').val()==null || !$('#fileexcel').val() || $('#fileexcel').val()==""){
            swal("Daftar Tenaga Kerja", "Pilih file excel terlebih dahulu", "error");
            return;
        }

        swal({   
            title: "Warning !",   
            text: "Data Tenaga Kerja dengan NIK yang sama dengan yang sudah ada di database beserta Riwayat Pekerjaan (NIB, Mulai Kerja dan Sampai Kerja yang sama) akan diupdate, Lanjutkan?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){ 
            setTimeout(() => importExcel(), 300);
        })
    }

    function importExcel(){
        if ($('#fileexcel').val()==null || !$('#fileexcel').val() || $('#fileexcel').val()==""){
            swal("Daftar Tenaga Kerja", "Pilih file excel terlebih dahulu", "error");
            return;
        }
        
        var file_data = $('#fileexcel').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('fileexcel', file_data);
        form_data.append('perusahaanid', $("#perusahaanid").val());
        $(".loadingdata").find('.loader__label').html("Import Data");
        $(".loadingdata").show();
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('naker.importexcel') }}", 
            dataType: 'text',  
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(response){
                $('#formImport').modal('hide');
                swal("Berhasil!", "Data excel berhasil di import.", "success"); 
                nakertable.draw();
                $(".loadingdata").hide();
                $('#fileexcel').val('');
                $("#diverrorexcel").html("");
                $("#judulerrorexcel").hide();
            },
            error: function(jqXhr, json, errorThrown){
                if (jqXhr.status==422){
                    var jdata = JSON.parse(jqXhr.responseText);
                    $(".errorspan").html("");
                    var prevbariske = 0;
                    var tagmsg = "";
                    $.each(jdata.errors, function (indmsg, valmsg) {
                        var ind = indmsg.split(".");
                        var bariske = parseInt(ind[1])+2;
                        if (prevbariske!=bariske) {
                            tagmsg += "<br>Baris ke "+bariske+" :<br>";
                        }
                        $.each(valmsg, function (index, value) {
                            tagmsg += "- "+value+"<br>";
                        });
                        prevbariske = bariske;
                    });
                    $("#diverrorexcel").html(tagmsg);
                    $("#judulerrorexcel").show();

                }else if (jqXhr.status==403){
                    $("#diverrorexcel").html((jqXhr.statusText ? jqXhr.statusText : "Forbidden"));
                    $("#judulerrorexcel").hide();
                }
                $(".loadingdata").hide();
                $('#fileexcel').val('');
            }
         });
    }

    function addData(){
        $('#formImport').modal('show');
    }

    function showGenerateForm(){
        nakergenerateusertable.rows().remove().draw();
        nakernousertable.draw();
        $('#formGenerateUser').modal('show');
    }

    function confirmGenerate(){
        swal({   
            title: "Warning !",   
            text: 'Data Tenaga Kerja pada Tabel "Daftar Tenaga Kerja yang akan digenerate user" akan digenerate user-nya, Lanjutkan ?',   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){ 
            setTimeout(() => generateUser(), 300);
        })
    }

    function generateUser(){
        let nakerids = [];
        if(nakergenerateusertable!=null){
            let data = nakergenerateusertable.rows().data();

            for (var i=0; i < data.length ;i++){
                nakerids.push(data[i]["nakerid"]);
            }
        }

        if(nakerids.length==0){
            swal("Warning", "Silahkan pilih tenaga kerja terlebih dahulu", "warning");
            return;
        }

        $(".loadingdata").find('.loader__label').html("Generate Data User Tenaga Kerja");
        $(".loadingdata").show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('naker.generateuser') }}", 
            method:"POST",
            data: {
                nakerids: nakerids
            },
            type: 'post',
            success: function(response){
                $('#formGenerateUser').modal('hide');
                swal("Berhasil!", "Data user tenaga kerja berhasil digenerate.", "success"); 
                nakergenerateusertable.rows().remove().draw();
                nakernousertable.draw();
                nakertable.draw();
                $(".loadingdata").hide();

            },
            error: function(jqXhr, json, errorThrown){
                swal("Error", "Gagal saat generate user", "error");
                $(".loadingdata").hide();
                return;
            }
         });
    }
</script>

@endsection