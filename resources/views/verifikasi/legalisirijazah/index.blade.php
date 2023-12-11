<?php
use App\enumVar as enum;
use App\Helpers\Get_field;
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

    /* #history-table {
        display: none;
    } */
    .btn-view-pengajuan:hover{
        background-color: rgb(24, 106, 154);
    }
    table td {
        word-break: break-word;
        vertical-align: top;
        white-space: normal !important;
    }
</style>
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">DAFTAR PERMINTAAN LEGALISIR IJAZAH</h5>
        <hr />
        <form class="form-filter form-material">
            <div class="form-group row">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kotaid"
                                class="col-md-12 col-form-label text-md-left">{{ __('Kota/Kabupaten') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kotaid" class="col-md-12 custom-select form-control" name='kotaid' autofocus>
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                                @foreach ($kota as $item)
                                <option value="{{$item->kotaid}}">{{  $item->kodekota . ' ' . $item->namakota }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sekolahid"
                                class="col-md-12 col-form-label text-md-left">{{ __('Sekolah') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="sekolahid" class="col-md-12 custom-select form-control" name='sekolahid'
                                autofocus {{ $isSekolah ? 'disabled' : '' }}>
                                <option value="{{ $isSekolah ? $userSekolah->sekolahid : '' }}">{{ $isSekolah ? $userSekolah->namasekolah : '-- Pilih Sekolah --' }}</option>
                                @foreach ($sekolah as $item)
                                <option value="{{$item->sekolahid}}">{{  $item->namasekolah }}</option>
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
                            <input id="search" type="text" class="col-md-12 form-control" name="search"
                                value="{{ old('search') }}" maxlength="100" autocomplete="search">
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
                <div class="col-md-7">
                    <h3 class="card-title text-uppercase">DAFTAR PERMINTAAN LEGALISIR IJAZAH</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="legalisir-table">
                            <thead>
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>No Ijazah</th>
                                    <th>Sekolah Asal</th>
                                    <th width="2%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <h3 class="card-title text-uppercase">STATUS LEGALISIR IJAZAH</h3>
                        <hr>
                        <table class="table table-bordered yajra-datatable table-striped" id="history-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
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
</div>
<div class="modal" id="m_KetTolak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Keterangan Penolakan</h4>
            </div>
            <div class="modal-body">
                <form id="f_alasan" class="form-horizontal" action="{{route('legalisir.tolak', ':id')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="hidden" name="idhiddenlegalisir" id="idhiddenlegalisir">
                                    <textarea name="keterangan" class="form-control" id="keterangan"
                                        placeholder="Keterangan" required maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input id="btnTambah" type="submit" class="btn btn-danger" value="Tolak">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.custom-select').select2();
        function cekstatus(status = '') {
            legalisirtable.buttons( '#btn-tolak' ).enable();
            // console.log(status);
            if (status != '{{ enum::LEGALISIR_DITOLAK }}') {
                legalisirtable.buttons( '#btn-tolak' ).enable();
            }
            else{
                legalisirtable.buttons( '#btn-tolak' ).disable();
            }
        }
        var historytable;
        var legalisirtable = $('#legalisir-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: true,
            language: {
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
                url: "{{ route('legalisir.index') }}",
                dataSrc: function (response) {
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function (d) {
                    return $.extend({}, d, {
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "sekolahid": $("#sekolahid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    });
                }
            },
            buttons: {
                buttons: [
                    //sementara dinonaktifkan untuk btn setuju
                    // {
                    //     text: '<i class="fa fa-check-square" aria-hidden="true"></i> Setuju',
                    //     className: 'edit btn btn-success btn-sm btn-datatable',
                    //     action: function () {
                    //         if (legalisirtable.rows({
                    //                 selected: true
                    //             }).count() <= 0) {
                    //             swal.fire("Data belum dipilih",
                    //                 "Silahkan pilih data terlebih dahulu", "error");
                    //             return;
                    //         }
                    //         var id = legalisirtable.rows({
                    //             selected: true
                    //         }).data()[0]['legalisirid'];
                    //         var url = "{{ route('legalisir.setuju', ':id') }}"
                    //         url = url.replace(':id', id);
                    //         var nama = legalisirtable.rows({
                    //             selected: true
                    //         }).data()[0]['namasiswa'];
                    //         swal.fire({
                    //             title: "Setujui Permintaan Legalisir Ijazah Atas Nama " +
                    //                 nama + "?",
                    //             type: "warning",
                    //             showCancelButton: true,
                    //             confirmButtonColor: "#DD6B55",
                    //             confirmButtonText: "Ya, lanjutkan!",
                    //             closeOnConfirm: false
                    //         }).then(function (result) {
                    //             if (result.isConfirmed) {
                    //                 $.ajaxSetup({
                    //                     headers: {
                    //                         'X-CSRF-TOKEN': $(
                    //                                 'meta[name="csrf-token"]')
                    //                             .attr('content')
                    //                     }
                    //                 });
                    //                 $.ajax({
                    //                     type: "POST",
                    //                     cache: false,
                    //                     url: url,
                    //                     dataType: 'JSON',
                    //                     data: {
                    //                         "_token": $(
                    //                                 'meta[name="csrf-token"]')
                    //                             .attr('content')
                    //                     },
                    //                     success: function (json) {
                    //                         var success = json.success;
                    //                         var message = json.message;
                    //                         var data = json.data;
                    //                         console.log(data);

                    //                         if (success == 'true' ||
                    //                             success ==
                    //                             true) {
                    //                             swal.fire("Berhasil!",
                    //                                 "Data anda telah disetujui.",
                    //                                 "success");
                    //                             legalisirtable.draw();
                    //                         } else {
                    //                             swal.fire("Error!", data,
                    //                                 "error");
                    //                         }
                    //                     }
                    //                 });
                    //             }
                    //         });
                    //     }
                    // },
                    {
                        attr: {id: 'btn-tolak'},
                        text: '<i class="fa fa-times-circle" aria-hidden="true"></i> Tolak',
                        className: 'edit btn btn-danger btn-sm btn-datatable',
                        action: function () {
                            if (legalisirtable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }
                            var id = legalisirtable.rows({
                                selected: true
                            }).data()[0]['legalisirid'];

                            var nama = legalisirtable.rows({
                                selected: true
                            }).data()[0]['namasiswa'];
                            $("#m_KetTolak").modal();

                            var legalisirData = legalisirtable.rows({
                                selected: true
                            }).data()[0];

                            $("#idhiddenlegalisir").val(id);

                            $("#m_KetTolak").data('legalisirid', id);

                            var formAction = $("#f_alasan").attr("action");
                            formAction = formAction.replace(':id', id);
                            $("#f_alasan").attr("action", formAction);

                            $("#m_KetTolak").modal();

                        }
                    }
                ]
            },
            columns: [{
                    'orderData': 1,
                    data: 'ijazahid',
                    render: function (data, type, row) {
                        return (row.namasiswa);
                    },
                    name: 'namasiswa'
                },
                {
                    'orderData': 2,
                    data: 'noijazah',
                    name: 'noijazah'
                },
                {
                    'orderData': 3,
                    data: 'sekolahid',
                    render: function (data, type, row) {
                        return (row.namasekolah);
                    },
                    name: 'namasekolah'
                },
                {
                    'orderData': 4,
                    data: 'status',
                    render: function (data, type, row) {
                        if (row.status == '{{ enum::LEGALISIR_DITOLAK }}') {
                            return '<span class="badge bg-danger">{{ enum::LEGALISIR_DESC_DITOLAK }}</span>';
                        } else if (row.status == '{{ enum::LEGALISIR_DISETUJUI }}') {
                            return '<span class="badge bg-success">{{ enum::LEGALISIR_DESC_DISETUJUI }}</span>';
                        } else {
                            return '<span class="badge bg-secondary">{{ enum::LEGALISIR_DESC_DIAJUKAN }}</span>';
                        }
                        // return (row.status);
                    },
                    name: 'status'
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });


        $('#kotaid').change(function () {
            legalisirtable.draw();
            $('#history-table').hide();
            if (this.value) {
                $.ajax({
                    url: "{{ route('helper.getsekolahkota', ':id') }}".replace(':id', this.value),
                }).done(function (result) {
                    let dataWr = result.data;
                    
                    $("#sekolahid").html("");
                    var d = new Option("-- Semua Sekolah --", "");
                    $("#sekolahid").append(d);
            
                    if (dataWr) {
                        dataWr.forEach((element) => {
                            var text = element.namasekolah; 
                            var o = new Option(text, element.sekolahid);
                            $("#sekolahid").append(o);
                        });
                    }
                });
            }else{

                $("#sekolahid").html("");
                
                var dd = new Option("-- Pilih Sekolah --", "");
                $("#sekolahid").append(dd);
            }
        });
        $('#sekolahid').change(function () {
            legalisirtable.draw();
            $('#history-table').hide();
        });

        $('#search').keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                legalisirtable.draw();
                 $('#history-table').hide();
            }
        });

        function loadHistoryTable(ijazahid) {
            var url = "{{ route('legalisir.history', ':id') }}";
            url = url.replace(':id', ijazahid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    historytable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        historytable.row.add({
                            tanggal: response.data.data[i].tgl_pengajuan,
                            status: response.data.data[i].status,
                            keterangan: response.data.data[i].keterangan,
                            legalisirid: response.data.data[i].legalisirid
                        });
                    }

                    historytable.draw();
                    $('#history-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on legalisir-table
        legalisirtable.on('select', function (e, dt, type, indexes) {
            var rowData = legalisirtable.rows(indexes).data()[0]; // Get selected row data
            var ijazahid = rowData.ijazahid;
            var status = rowData.status;

            // Load history table with selected ijazahid
            loadHistoryTable(ijazahid);
            cekstatus(status);
        });

        legalisirtable.on('deselect', function ( e, dt, type, indexes ) {
            // hide history table
            $('#history-table').hide();
            cekstatus();
        });

        // Initialize history table
        var historytable = $('#history-table').DataTable({
            responsive: true,
            language: {
                // lengthMenu: "Menampilkan _MENU_ data per halaman",
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
            // ... your history-table initialization options ...
            columns: [{
                    data: 'tanggal',
                    name: 'tgl_pengajuan'
                },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        if (row.status == '{{ enum::LEGALISIR_DITOLAK }}') {
                            return '<span class="badge bg-danger">{{ enum::LEGALISIR_DESC_DITOLAK }}</span>';
                        } else if (row.status == '{{ enum::LEGALISIR_DISETUJUI }}') {
                            return '<span class="badge bg-success">{{ enum::LEGALISIR_DESC_DISETUJUI }}</span>';
                        } else {
                            return '<a href="{{ route('legalisir.viewpengajuan', '') }}/' + row.legalisirid + '" class="badge bg-secondary btn-view-pengajuan">{{ enum::LEGALISIR_DESC_DIAJUKAN }}</a>';
                        }
                        // return (row.status);
                    },
                    name: 'status'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                }
            ]
        });

        // hide histiry table
        $('#history-table').hide();
    });

</script>

@endsection
