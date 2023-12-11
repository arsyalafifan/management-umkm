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
        <h5 class="card-title text-uppercase">DAFTAR SUB GOLONGAN POKOK</h5><hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="golpokokid" class="col-md-12 col-form-label text-md-left">{{ __('Gol. Pokok') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="golpokokid" class="col-md-12 custom-select form-control" name='golpokokid' autofocus>
                                <option value="">-- Pilih Gol. Pokok --</option>
                                @foreach ($golpokok as $item)
                                    <option value="{{$item->golpokokid}}">{{ $item->kode .' '. $item->nama }}</option>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="subgolpokok-table">
                        <thead>
                            <tr>
                                <!-- <th>Sub Golongan Pokok ID</th> -->
                                <th></th>
                                <th>Golongan Pokok</th>
                                <th>Kode</th>
                                <th>Nama Sub Golongan Pokok</th>
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
    
        var subgolpokoktable = $('#subgolpokok-table').DataTable({
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
                url: "{{ route('subgolpokok.index') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase(),
                        "golpokokid": $("#golpokokid").val().toLowerCase()
                    } );
                }
            },
            buttons: {
                buttons: [
                {
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (subgolpokoktable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        var id = subgolpokoktable.rows( { selected: true } ).data()[0]['subgolpokokid'];
                        var url = "{{ route('subgolpokok.show', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (subgolpokoktable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        var id = subgolpokoktable.rows( { selected: true } ).data()[0]['subgolpokokid'];
                        var url = "{{ route('subgolpokok.edit', ':id') }}"
                        url = url.replace(':id', id);
                        window.location = url;
                    }
                }, {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (subgolpokoktable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = subgolpokoktable.rows( { selected: true } ).data()[0]['subgolpokokid'];
                        var url = "{{ route('subgolpokok.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        var kode =  subgolpokoktable.rows( { selected: true } ).data()[0]['kode'];
                        var nama =  subgolpokoktable.rows( { selected: true } ).data()[0]['nama'];
                        swal({   
                            title: "Apakah anda yakin akan menghapus Sub Golongan Pokok " + nama + "?",   
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
                                        subgolpokoktable.draw();
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
                // {'orderData': 0, data: 'subgolpokokid', name: 'subgolpokokid'},
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": "<i class='fa fa-plus-circle'></i>"
                }, 
                {'orderData': 1, data: 'golpokok',
                    render: function ( data, type, row ) {
                        return row.golpokok.kode + ' ' + row.golpokok.nama;
                    }, 
                    name: 'golpokokview'},
                {'orderData': 1, data: 'kode',
                    render: function ( data, type, row ) {
                        return row.kode;
                    }, 
                    name: 'kode'},
                {'orderData': 2, data: 'nama', name: 'nama'}
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
    
        $('#golpokokid').change( function() { 
            subgolpokoktable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                subgolpokoktable.draw();
            }
        });

        $('#subgolpokok-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = subgolpokoktable.row( tr );
     
            if ( row.child.isShown() ) {
                row.child.hide();
                $(this).html("<i class='fa fa-plus-circle'></i>");
            }
            else {
                row.child( detailFormat(row.data()) ).show();
                $(this).html("<i class='fa fa-minus-circle'></i>");
                
            }
        } );

        function detailFormat ( d ) {
            var tblcontent = "<table class='table table-bordered yajra-datatable table-striped'>" +
            "<thead><tr>"+
                "<th>Kode Golongan</th>"+
                "<th>Nama Golongan</th>"+
            "</tr></thead><tbody>";
            (d.gol).forEach((entry) => {
                tblcontent += "<tr>"+
                    "<td>"+entry.kode+"</td>"+
                    "<td>"+entry.nama+"</td>"+
                "</tr>";
            });
            tblcontent += "</tbody></table>";
            return tblcontent;
        }

    });
</script>

@endsection