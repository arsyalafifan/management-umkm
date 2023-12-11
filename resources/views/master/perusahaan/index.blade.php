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
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">DAFTAR PERUSAHAAN</h5><hr />
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

                {{-- @if (session()->has('success'))
                    <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </p>
                @endif --}}
                
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="perusahaan-table">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Jenis</th>
                                <th>Alamat</th>
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
    var perusahaantable = null;
    var perusahaannousertable = null;
    var perusahaangenerateusertable = null;
    $(document).ready(function () {
        $('.custom-select').select2();
    
        perusahaantable = $('#perusahaan-table').DataTable({
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
                url: "{{ route('perusahaan.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        // "kawasanid": $("#kawasanid").val().toLowerCase(),
                        // "statususer": $("#statususer").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (perusahaantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = perusahaantable.rows( { selected: true } ).data()[0]['perusahaanid'];
                        var url = "{{ route('perusahaan.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (perusahaantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = perusahaantable.rows( { selected: true } ).data()[0]['perusahaanid'];
                        var url = "{{ route('perusahaan.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (perusahaantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = perusahaantable.rows( { selected: true } ).data()[0]['perusahaanid'];
                        var url = "{{ route('perusahaan.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var nama =  perusahaantable.rows( { selected: true } ).data()[0]['nama'];
                        swal.fire({   
                            title: "Apakah anda yakin akan menghapus Perusahaan " + nama + "?",   
                            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                            icon: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!", 
                            // cancelButtonText: 'Tidak, cancel!',  
                            // closeOnConfirm: false 
                        }).then((result) => {
                            if(result.isConfirmed){
                                // function() {   
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        type: "DELETE",
                                        cache:false,
                                        url: url,
                                        success: (json) => {
                                            var success = json.success;
                                            var message = json.message;
                                            var data = json.data;
                                            
                                            if (success == 'true' || success == true) {
                                                swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                                perusahaantable.draw();
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
            ]
            },
            columns: [
                // {'orderData': 1, data: 'user',
                //     render: function ( data, type, row ) {
                //         if(row.user == 0) return "<span class='text-danger'><b>X</b></span>";
                //         else if(row.user > 0) return "<span class='text-success'><b>V</b></span>";
                //         else return "-";
                //     }, 
                //     name: 'user'},
                {'orderData': 1, data: 'nama', name: 'nama'},
                {'orderData': 2, data: 'jenis', name: 'jenis'},
                {'orderData': 3, data: 'alamat', name: 'alamat'},
                // {'orderData': 5, data: 'kawasan',
                //     render: function ( data, type, row ) {
                //         return (row.kawasan ? row.kawasan.namainstansi : '-');
                //     }, 
                //     name: 'bidangusahaview'},
                // {'orderData': 6, data: 'bidangusaha',
                //     render: function ( data, type, row ) {
                //         return (row.bidangusaha ? row.bidangusaha.bidangusaha : '-');
                //     }, 
                //     name: 'bidangusahaview'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        perusahaannousertable = $('#perusahaan-nouser-table').DataTable({
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
                url: "",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    let excludeids = [];
                    if(perusahaangenerateusertable!=null){
                        let data = perusahaangenerateusertable.rows().data();

                        for (var i=0; i < data.length ;i++){
                            excludeids.push(data[i]["perusahaanid"]);
                        }
                    }
                    return $.extend( {}, d, {
                        "search": $("#searchnouser").val().toLowerCase(),
                        "excludeids": excludeids
                    } );
                }
            },
            buttons: {
                buttons: [
                    {
                        text: 'Tambahkan ke Tabel List Perusahaan yang akan digenerate user',
                        className: 'addgenerate btn btn-info btn-sm btn-datatable',
                        action: function () {
                            let data = perusahaannousertable.rows( { selected: true } ).data();

                            if(data.length>0){
                                for (var i=0; i < data.length ;i++){
                                    var indexes = perusahaangenerateusertable
                                      .rows()
                                      .indexes()
                                      .filter( function ( value, index ) {
                                        return data[i]["perusahaanid"] === perusahaangenerateusertable.row(value).data()["perusahaanid"];
                                      })

                                    if (indexes[0] === undefined) perusahaangenerateusertable.row.add(data[i]).draw();
                                }

                                perusahaannousertable.draw();
                            }
                        }
                    }
                ]
            },
            columns: [
                {'orderData': 1, data: 'kodedaftar', name: 'kodedaftar'},
                {'orderData': 2, data: 'nama', name: 'nama'}
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        perusahaangenerateusertable = $('#perusahaan-generateuser-table').DataTable({
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
                        text: 'Hapus dari Tabel List Perusahaan yang akan digenerate user',
                        className: 'addgenerate btn btn-danger btn-sm btn-datatable',
                        action: function () {
                            let data = perusahaangenerateusertable.rows( { selected: true } ).data();

                            if(data.length>0){
                                perusahaangenerateusertable.rows( '.selected' ).remove().draw();
                                perusahaannousertable.draw();
                            }
                        }
                    }
                ]
            },
            columns: [
                {'orderData': 1, data: 'kodedaftar', name: 'kodedaftar'},
                {'orderData': 2, data: 'nama', name: 'nama'}
            ],
            // initComplete: function (settings, json) {
            //     $(".btn-datatable").removeClass("dt-button");
            // },
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
                perusahaantable.draw();
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
                perusahaannousertable.draw();
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
                perusahaangenerateusertable.search(this.value).draw();
            }
        });

    });
    
    function confirmImport(){
        if ($('#fileexcel').val()==null || !$('#fileexcel').val() || $('#fileexcel').val()==""){
            swal("Perusahaan", "Pilih file excel terlebih dahulu", "error");
            return;
        }

        swal({   
            title: "Warning !",   
            text: "Data Perusahaan dengan Kode Daftar yang sama dengan yang sudah ada di database akan diupdate, Lanjutkan ?",   
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
            swal("Perusahaan", "Pilih file excel terlebih dahulu", "error");
            return;
        }
        
        var file_data = $('#fileexcel').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('fileexcel', file_data);
        $(".loadingdata").find('.loader__label').html("Import Data");
        $(".loadingdata").show();
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "", 
            dataType: 'text',  
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(response){
                $('#formImport').modal('hide');
                swal("Berhasil!", "Data excel berhasil di import.", "success"); 
                perusahaantable.draw();
                $(".loadingdata").hide();
                $('#fileexcel').val('');

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

                }
                $(".loadingdata").hide();
                $('#fileexcel').val('');
            }
         });
    }

    function addData(){
        $('#formImport').modal('show');
    }

</script>

@endsection