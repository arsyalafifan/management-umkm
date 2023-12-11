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
        <h5 class="card-title text-uppercase">DAFTAR PEGAWAI</h5>
        <hr />
        <form class="form-filter form-material">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="unit" class="col-md-12 col-form-label text-md-left">{{ __('Unit') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="unit" class="col-md-12 custom-select form-control" name="unit" autofocus {{ $isSekolah ? 'disabled' : '' }}>
                                <option value="{{ $isSekolah ? enum::UNIT_SEKOLAH : '' }}">{{ $isSekolah ? enum::UNIT_DESC_SEKOLAH : '-- Pilih Unit --' }}</option>
                                @foreach (enum::listUnit() as $id)
                                <option value="{{ $id }}">{{ enum::listUnit('desc')[$loop->index] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="form-group row filter1">
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
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="kecamatanid"
                                class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid'
                                autofocus>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatan as $item)
                                <option value="{{$item->kecamatanid}}">{{  $item->kodekec . ' ' . $item->namakec }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row filter1">
                <div class="col-md-6 @if($isSekolah) d-none @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jenjang"
                                class="col-md-12 col-form-label text-md-left">{{ __('Jenjang') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="jenjang" class="col-md-12 custom-select form-control" name="jenjang" autofocus>
                                <option value="">-- Pilih Jenjang --</option>
                                @foreach (enum::listJenjang() as $jenjang)
                                <option value="{{ $jenjang }}">{{ enum::listJenjang('desc')[$loop->index] }}</option>
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
                            <select id="sekolahid" class="col-md-12 custom-select form-control" name='sekolahid' {{ $isSekolah ? 'disabled' : '' }}>
                                <option value="{{ $isSekolah ? $userSekolah->sekolahid : '' }}">{{ $isSekolah ? $userSekolah->namasekolah : '-- Pilih Sekolah --' }}</option>
                                @foreach ($sekolah as $item)
                                <option value="{{ $item->sekolahid }}">{{  $item->namasekolah }}</option>
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
                    <table class="table table-bordered yajra-datatable table-striped" id="pegawai1-table">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
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
        $('.custom-select').select2();

        var pegawaitable = $('#pegawai1-table').DataTable({
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
                url: "{{ route('pegawai.index') }}",
                dataSrc: function (response) {
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function (d) {
                    return $.extend({}, d, {
                        "unit": $("#unit").val().toLowerCase(),
                        "kotaid": $("#kotaid").val().toLowerCase(),
                        "kecamatanid": $("#kecamatanid").val().toLowerCase(),
                        "jenjang": $("#jenjang").val().toLowerCase(),
                        "sekolahid": $("#sekolahid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase(),
                    });
                }
            },
            buttons: {
                buttons: [{

                        text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                        className: 'edit btn btn-warning btn-sm btn-datatable',
                        action: function () {
                            if (pegawaitable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data yang akan diubah", "error");
                                return;
                            }
                            var id = pegawaitable.rows({
                                selected: true
                            }).data()[0]['pegawaiid'];
                            var url = "{{ route('pegawai.edit', ':id') }}"
                            url = url.replace(':id', id);
                            window.location = url;
                        }
                    }, {
                        text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                        className: 'edit btn btn-danger btn-sm btn-datatable',
                        action: function () {
                            if (pegawaitable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data yang akan dihapus", "error");
                                return;
                            }
                            var id = pegawaitable.rows({
                                selected: true
                            }).data()[0]['pegawaiid'];
                            var url = "{{ route('pegawai.destroy', ':id') }}"
                            url = url.replace(':id', id);
                            var nama = pegawaitable.rows({
                                selected: true
                            }).data()[0]['nama'];
                            swal.fire({
                                title: "Apakah anda yakin akan menghapus Pegawai " +
                                    nama + "?",
                                text: "Data yang terhapus tidak dapat dikembalikan lagi!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Ya, lanjutkan!",
                                closeOnConfirm: false
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]')
                                                .attr(
                                                    'content')
                                        }
                                    });
                                    $.ajax({
                                        type: "DELETE",
                                        cache: false,
                                        url: url,
                                        dataType: 'JSON',
                                        data: {
                                            "_token": $(
                                                    'meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        success: function (json) {
                                            var success = json.success;
                                            var message = json.message;
                                            var data = json.data;
                                            console.log(data);

                                            if (success == 'true' ||
                                                success ==
                                                true) {
                                                swal.fire("Berhasil!",
                                                    "Data anda telah dihapus.",
                                                    "success");
                                                pegawaitable.draw();
                                            } else {
                                                swal.fire("Error!", data,
                                                    "error");
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }
                ]
            },
            columns: [{
                    'orderData': 1,
                    data: 'nama',
                    render: function (data, type, row) {
                        return (row.nama);
                    },
                    name: 'nama'
                },
                {
                    'orderData': 2,
                    data: 'nip',
                    name: 'nip'
                },
                {
                    'orderData': 3,
                    data: 'jabatan',
                    render: function (data, type, row) {
                        if (row.unit == {{ enum::UNIT_OPD }}) {
                            if(row.jabatan == {{ enum::JABATAN_OPD_KEPALADINAS}}){
                                return '<p>{{ enum::JABATAN_OPD_DESC_KEPALADINAS }}</p>';
                            }else if(row.jabatan == {{ enum::JABATAN_OPD_STAFDINAS}}){
                                return '<p>{{ enum::JABATAN_OPD_DESC_STAFDINAS }}</p>';
                            }
                        } else {
                            if(row.jabatan == {{ enum::JABATAN_SEKOLAH_KEPALASEKOLAH}}){
                                return '<p>{{ enum::JABATAN_SEKOLAH_DESC_KEPALASEKOLAH }}</p>';
                            }else if(row.jabatan == {{ enum::JABATAN_SEKOLAH_BENDAHARABOS}}){
                                return '<p>{{ enum::JABATAN_SEKOLAH_DESC_BENDAHARABOS }}</p>';
                            }else if(row.jabatan == {{ enum::JABATAN_SEKOLAH_BENDAHARASPP}}){
                                return '<p>{{ enum::JABATAN_SEKOLAH_DESC_BENDAHARASPP }}</p>';
                            }else if(row.jabatan == {{ enum::JABATAN_SEKOLAH_PENGURUSBARANG}}){
                                return '<p>{{ enum::JABATAN_SEKOLAH_DESC_PENGURUSBARANG }}</p>';
                            }
                        }
                    },
                    name: 'jabatan'
                },
                {
                    'orderData': 4,
                    data: 'status',
                    render: function (data, type, row) {
                        if (row.status == 1) {
                            return '<p class="text-success">Aktif</p>';
                        } else {
                            return '<p class="text-danger">Tidak Aktif</p>';
                        }
                    },
                    name: 'status'
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });
       
        $('#unit').change(function () {
            if ($(this).val() === '{{ enum::UNIT_OPD }}') {
                $('.filter1').hide();
                $('#kotaid').val('');
                $('#kecamatanid').val('');
                $('#jenjang').val('');
                $('#sekolahid').val('');
            } else {
                $('.filter1').show();
            }

            pegawaitable.draw();
            pegawaitable.clear().draw();
            
        });
        //kota change
        $('#kotaid').change(function () {
            pegawaitable.draw();
            if (this.value) {
                $.ajax({
                    url: "{{ route('helper.getkecamatan', ':id') }}".replace(':id', this.value),
                }).done(function (result) {
                    let dataWr = result.data;
                    
                    $("#kecamatanid").html("");
                    var d = new Option("-- Semua Kecamatan --", "");
                    $("#kecamatanid").append(d);
            
                    if (dataWr) {
                        dataWr.forEach((element) => {
                            var text = element.kodekec + ' - ' + element.namakec; 
                            var o = new Option(text, element.kecamatanid);
                            $("#kecamatanid").append(o);
                        });
                    }
                });
            }else{

                $("#kecamatanid").html("");
                
                var dd = new Option("-- Pilih Kecamatan --", "");
                $("#kecamatanid").append(dd);
            }
        });
        //kecamatan change
        $('#kecamatanid').change(function () {
            pegawaitable.draw();
            let kecamatanid = this.value;
            let jenjangValue = $('#jenjang').val();
            if (this.value) {
                if(jenjangValue != ''){
                    var link = "{{ route('helper.getsekolahjenjang', [':jenjang', ':kecamatanid']) }}".replace(':jenjang', jenjangValue).replace(':kecamatanid', kecamatanid);
                }else{
                    var link = "{{ route('helper.getsekolah', ':kecamatanid') }}".replace(':kecamatanid', kecamatanid);
                }
                
                $.ajax({
                    url: link,
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
        //jenjang change
        $('#jenjang').change(function () {
            pegawaitable.draw();
            let kecamatanid = $('#kecamatanid').val();
            let jenjangValue = this.value;
            if (this.value) {
                if(kecamatanid != ''){
                    var link = "{{ route('helper.getsekolahjenjang', [':jenjang', ':kecamatanid']) }}".replace(':jenjang', jenjangValue).replace(':kecamatanid', kecamatanid);
                }else{
                    var link = "{{ route('helper.getsekolahjenjang2', ':jenjang') }}".replace(':jenjang', jenjangValue);
                }
                
                $.ajax({
                    url: link,
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
            pegawaitable.draw();
        });

        $('#search').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#search').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                pegawaitable.draw();
            }
        });

        $('#btnTambah').click(function (event) {
        event.preventDefault(); // Prevent the default link behavior

        var sekolahId = $('#sekolahid').val();
        var unit = $('#unit').val();

        if (sekolahId === '' && unit === '') {
            swal.fire("Silakan pilih unit terlebih dahulu", "", "error");
        } else if (sekolahId === '' && unit === "{{ enum::UNIT_SEKOLAH }}") {
            swal.fire("Silakan pilih sekolah terlebih dahulu", "", "error");
        } else if (unit === "{{ enum::UNIT_SEKOLAH }}" && sekolahId !== '') {
            var url = "{{ route('pegawai.createWithSekolah', ['sekolahId' => ':id']) }}";
            url = url.replace(':id', sekolahId);
            window.location.href = url;
        } else if (unit === "{{ enum::UNIT_OPD }}" && sekolahId === '') {
            var url = "{{ route('pegawai.create') }}";
            window.location.href = url;
        }else {
            swal.fire("Silakan pilih unit terlebih dahulu", "", "error");
        }
    });

    });

</script>

@endsection
