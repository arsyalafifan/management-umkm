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
</style>
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">DAFTAR PENGAJUAN KEBUTUHAN SARPRAS</h5>
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
                                value="{{ old('search') }}" maxlength="100" autocomplete="search" placeholder="-- Filter --">
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
                    <h3 class="card-title text-uppercase">DAFTAR PENGAJUAN SARPRAS</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="kebutuhan-sarpras-table">
                            <thead>
                                <tr>
                                    <th>Sekolah</th>
                                    <th>Jenis Kebutuhan</th>
                                    <th>No Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Sarpras</th>
                                    <th>Jumlah</th>
                                    <th width="2%">Status</th>
                                    <th>pegawaiid</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <h3 class="card-title text-uppercase">STATUS PENGAJUAN SARPRAS</h3>
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
<!-- modal verifikasi -->
<div class="modal" id="modal-verifikasi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" style="max-width: 1100px" role="document">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="exampleModalLabel">Verifikasi Kebutuhan Sarpras</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="verifikasiKebutuhanSarpras" name="verifikasiKebutuhanSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="sarpraskebutuhanid" name="sarpraskebutuhanid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nopengajuan" class="col-md-12 col-form-label text-md-left">{{ __('Nomor Pengajuan *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="nopengajuan" type="text" class="form-control @error('nopengajuan') is-invalid @enderror" name="nopengajuan" value="" maxlength="100" required autocomplete="nopengajuan" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tglpengajuan" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal Pengajuan *') }}</label>
                                <div class="col-md-12">
                                    <input type="date" class="form-control @error('tglpengajuan') is-invalid @enderror" id="tglpengajuan" name="tglpengajuan" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jeniskebutuhan" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Kebutuhan *') }}</label>
            
                                <div class="col-md-12">
                                    {{-- <select id="pegawaiid" class="custom-select form-control @error('pegawai') is-invalid @enderror" name='pegawaiid'>
                                        <option value=""></option>
                                    </select> --}}
                                    <input id="jeniskebutuhan" type="text" class="form-control @error('jeniskebutuhan') is-invalid @enderror" name="jeniskebutuhan" value="" maxlength="100" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenissarpras" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Sarpras Tersedia *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="jenissarpras" type="text" class="form-control @error('jenissarpras') is-invalid @enderror" name="jenissarpras" value="" maxlength="100" required autocomplete="jenissarpras" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kepalasekolah" class="col-md-12 col-form-label text-md-left">{{ __('Kepala Sekolah *') }}</label>
            
                                <div class="col-md-12">
                                    {{-- <select id="pegawaiid" class="custom-select form-control @error('pegawai') is-invalid @enderror" name='pegawaiid'>
                                        <option value=""></option>
                                    </select> --}}
                                    <input id="pegawaiid" type="text" class="form-control @error('pegawaiid') is-invalid @enderror" name="pegawaiid" value="" maxlength="100" required autocomplete="pegawaiid" autofocus>
                                </div>
                            </div>
                        </div>
                        
                    </div>
    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="namasarpras" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpras *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="namasarprasid" type="text" class="form-control @error('namasarprasid') is-invalid @enderror" name="namasarprasid" value="" maxlength="100" required autocomplete="namasarprasid" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="" maxlength="100" required autocomplete="jumlah">
            
                                    @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="" maxlength="100" required autocomplete="satuan">
            
                                    @error('satuan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="box-title text-uppercase m-b-0">Foto Kebutuhan Sarpras</h3><hr />
                            {{-- <p class="text-muted m-b-20">Klik Tambah Master Plan Sekolah untuk menambah data </p> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="foto-sarpras-kebutuhan-table">
                                    <thead>
                                        <tr>
                                            <th>File</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h3 class="box-title text-uppercase m-b-0">Jumlah Yang Disetujui</h3><hr />
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlahsetuju" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
                
                                    <div class="col-md-12">
                                        <input id="jumlahsetuju" type="number" class="form-control @error('jumlahsetuju') is-invalid @enderror" name="jumlahsetuju" value="" maxlength="100" required autocomplete="jumlahsetuju" onchange="compareJumlah()">
                
                                        @error('jumlahsetuju')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
                
                                    <div class="col-md-12">
                                        <input id="satuansetuju" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="" maxlength="100" required autocomplete="satuan">
                
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="button-close-verifikasi" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button value="verifikasiSetuju" type="submit" id="verifikasiSetuju" class="btn btn-success verifikasiSetuju"><i class="fa fa-check" aria-hidden="true"></i> Setuju
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modal-tolak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Keterangan Penolakan</h4>
            </div>
            <div class="modal-body">
                <form id="keterangan-tolak" name="keterangan-tolak" class="form-horizontal" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="hidden" name="sarpraskebutuhanid" id="sarpraskebutuhanid">
                                    <textarea name="keterangan" class="form-control" id="keterangan"
                                        placeholder="Keterangan" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input id="button-close-tolak" type="submit" class="btn btn-danger" value="Tolak">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- validasi jumlah yang disetujui -->
<script>
    function compareJumlah() {
        var jumlahSetuju = $('#jumlahsetuju').val();
        var jumlah = $('#jumlah').val();
        if (!isNaN(jumlahSetuju) && jumlahSetuju > jumlah) {
            // alert("The first date is after the second date!");
            swal.fire('Peringatan!', `Jumlah yang disetujui tidak boleh melebihi dari jumlah yang diajukan (${jumlah})`, 'warning');
            $('#jumlahsetuju').val('');
        }
    }
</script>
<script>

    $(document).ready(function () {

        // verifikasi kebutuhan sarpras 
        $(document).on('submit', '#verifikasiKebutuhanSarpras', function(e){
            e.preventDefault();
            let id = kebutuhansarprastable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
            
            let formData = new FormData($('#verifikasiKebutuhanSarpras')[0]);

            let url = "{{ route('verifikasikebutuhansarpras.setuju', ':id') }}"
            url = url.replace(':id', id);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (json) => {
                    let success = json.success;
                    let message = json.message;
                    let data = json.akreditasi;
                    let errors = json.errors;

                    // kebutuhansarprastable
                    // .on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
                    //     if(success == 'true' || success == true){
                    //         e.preventDefault();
                    //     }
                    // } );

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Status berhasil diubah menjadi disetujui.", "success");
                            kebutuhansarprastable.draw();
                            // historytable.draw();
                            loadHistoryTable(id)
                            $('#jumlahsetuju').val('');
                            $('#satuan').val('');
                            $('#verifikasiKebutuhanSarpras').trigger("reset");
                            $('#modal-verifikasi').modal('hide'); 
                            console.log( kebutuhansarprastable.rows( { selected: true } ));
                            kebutuhansarprastable.rows( { selected: true } ).data()[0];
                    }
                    else {
                            // var data = jqXHR.responseJSON;
                            console.log(errors);// this will be the error bag.
                            // printErrorMsg(errors);
                            // swal.fire("Error!", errors, "error"); 
                            swal.fire("Error!", errors.keterangan[0], "error"); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        printErrorMsg(data.errors);
                    }
            })
        })
        
        // edit detail sarpras kebutuhan
        $(document).on('submit', '#keterangan-tolak', function(e){
            e.preventDefault();
            let id = kebutuhansarprastable.rows( { selected: true } ).data()[0]['sarpraskebutuhanid'];
            
            let formData = new FormData($('#keterangan-tolak')[0]);

            let url = "{{ route('verifikasikebutuhansarpras.tolak', ':id') }}"
            url = url.replace(':id', id);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (json) => {
                    let success = json.success;
                    let message = json.message;
                    let data = json.akreditasi;
                    let errors = json.errors;

                    // kebutuhansarprastable
                    // .on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
                    //     if(success == 'true' || success == true){
                    //         e.preventDefault();
                    //     }
                    // } );

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Status berhasil diubah menjadi ditolak.", "success");
                            kebutuhansarprastable.draw();
                            // historytable.draw();
                            loadHistoryTable(id)
                            $('#keterangan').val('');
                            $('#keterangan-tolak').trigger("reset");
                            $('#modal-tolak').modal('hide'); 
                            console.log( kebutuhansarprastable.rows( { selected: true } ));
                            kebutuhansarprastable.rows( { selected: true } ).data()[0];
                    }
                    else {
                            // var data = jqXHR.responseJSON;
                            console.log(errors);// this will be the error bag.
                            // printErrorMsg(errors);
                            // swal.fire("Error!", errors, "error"); 
                            swal.fire("Error!", errors.keterangan[0], "error"); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        printErrorMsg(data.errors);
                    }
            })
        })

        function setenableverifikasibutton(status = '') {
            kebutuhansarprastable.buttons( '#btn-tolak' ).disable();
            kebutuhansarprastable.buttons( '#btn-verifikasi' ).disable();
            if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_DISETUJUI }}') {
                kebutuhansarprastable.buttons( '#btn-tolak' ).enable();
                kebutuhansarprastable.buttons( '#btn-verifikasi' ).disable();
            }
            else if(status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_PENGAJUAN }}') {
                kebutuhansarprastable.buttons( '#btn-tolak' ).enable();
                kebutuhansarprastable.buttons( '#btn-verifikasi' ).enable();
            }
            else if (status == '{{ enum::STATUS_KEBUTUHAN_SARPRAS_DITOLAK }}') {
                kebutuhansarprastable.buttons( '#btn-tolak' ).disable();
                kebutuhansarprastable.buttons( '#btn-verifikasi' ).enable();
            }
        }

        $('.custom-select').select2();
        var historytable;
        var kebutuhansarprastable = $('#kebutuhan-sarpras-table').DataTable({
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
                url: "{{ route('verifikasikebutuhansarpras.index') }}",
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
                    {
                        attr: {id: 'btn-verifikasi'},
                        text: '<i class="fa fa-check-square" aria-hidden="true"></i> Verifikasi',
                        className: 'edit btn btn-info btn-datatable mb-2',
                        action: function () {
                            if (kebutuhansarprastable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }

                            let status = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'];
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 3 ? 'Disetujui' : '';

                            // if(status > 2){
                            //     swal.fire("Tidak dapat melakukan verifikasi",
                            //         `Data yang anda pilih sudah berstatus ${status == 3 ? statusDesc : 'Ditolak'}`, "error");
                            //     return;
                            // }

                            // for (var i = 0; i < response.data.count; i++) {
                            //     kebutuhansarprastable.row.add({
                            //         pegawaiid: response.data.data[i].pegawaiid,
                            //         nama: response.data.data[i].nama,
                            //         nip: response.data.data[i].nip
                            //     });
                            // }

                            // console.log(kebutuhansarprastable);

                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                            console.log(sarpraskebutuhanid)
                            let nopengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nopengajuan'];
                            let tglpengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['tglpengajuan'];
                            let nip = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nip'];
                            let nama = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nama'];
                            let jenissarpras = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jenissarpras'];
                            let jeniskebutuhan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jeniskebutuhan'];
                            let namasarpras = kebutuhansarprastable.rows( { selected: true } ).data()[0]['namasarpras'];
                            let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlah'];
                            let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuan'];

                            let sarprasutama = "Sarpras Utama";
                            let sarpraspenunjang = "Sarpras Penunjang";
                            let sarprasperalatan = "Sarpras Peralatan";

                            var listJenisKebutuhan = @json(enum::listJenisKebutuhan($id = ''));
                            // let listJenisKebutuhan = JSON.parse('{!! json_encode(enum::listJenisKebutuhan()) !!}');
                            let Desc;
                            listJenisKebutuhan.forEach((value, index) => {
                                if(jeniskebutuhan == index + 1) {
                                    Desc = value;
                                }
                            });
                            // return Desc;
                            
                            // $('#kondisi-edit option[value="'+kondisi+'"]').prop('selected', true);
                            $('#sarpraskebutuhanid').val(sarpraskebutuhanid);
                            $('#nopengajuan').val(nopengajuan).prop('disabled', true);
                            $('#tglpengajuan').val(tglpengajuan).prop('disabled', true);
                            $('#pegawaiid').val(`NIP: ${nip}  |  Nama: ${nama}`).prop('disabled', true);
                            // $('#pegawaiid').val(`${jenissarpras == 1 ? "Sarpras Utama" : (jenissarpras == 2 : "Sarpras Penunjang" : (jenissarpras == 3 ? "Sarpras Peralatan"))})
                            $('#jenissarpras').val(`${jenissarpras == 1 ? sarprasutama : (jenissarpras == 2 ? sarpraspenunjang : (jenissarpras == 3 ? sarprasperalatan : ''))}`).prop('disabled', true);
                            $('#jeniskebutuhan').val(Desc).prop('disabled', true);
                            $('#namasarprasid').val(namasarpras).prop('disabled', true);
                            $('#jumlah').val(jumlah).prop('disabled', true);
                            $('#satuan').val(satuan).prop('disabled', true);

                            $('#jumlahsetuju').val('');
                            $('#satuansetuju').val('');
                                
                            $('#modal-verifikasi').modal('show');

                            showFotoDetailKebutuhanSarpras(sarpraskebutuhanid)
                        }
                    },
                    {
                        attr: {id: 'btn-tolak'},
                        text: '<i class="fa fa-times-circle" aria-hidden="true"></i> Tolak',
                        className: 'edit btn btn-danger btn-datatable mb-2',
                        action: function () {
                            if (kebutuhansarprastable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }

                            let status = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'];
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 3 ? 'Disetujui' : '';

                            // if(status > 2){
                            //     swal.fire("Tidak dapat tolak verifikasi",
                            //         `Data yang anda pilih sudah berstatus ${status == 3 ? statusDesc : 'Ditolak'}`, "error");
                            //     return;
                            // }
                            $('#keterangan').val('');
                            $('#modal-tolak').modal('show');
                        }
                    }
                ]
            },
            columns: [
                {
                    'orderData': 1,
                    data: 'sekolahid',
                    render: function (data, type, row) {
                        return (row.namasekolah);
                    },
                    name: 'namasekolah'
                },
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
                {
                    'orderData': 3,
                    data: 'nopengajuan',
                    render: function(data, type, row){
                        return (row.nopengajuan);
                    },
                    name: 'nopengajuan'
                },
                {
                    'orderData': 4,
                    data: 'tglpengajuan',
                    render: function (data, type, row) {
                        return (DateFormat(row.tglpengajuan));
                    },
                    name: 'tglpengajuan'
                },
                {'orderData': 5, data: 'namasarprasid',
                    render: function ( data, type, row ) {
                        if(row.namasarprasid!=null){
                            return row.namasarpras;
                        }else
                            return "-";
                    }, 
                    name: 'namasarprasid'
                },
                {
                    'orderData': 6,
                    data: 'jumlah',
                    render: function (data, type, row) {
                        return `${row.jumlah} ${row.satuan}`;
                    },
                    name: 'jumlah',
                },
                {'orderData': 7, data: 'status', 
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
                            }else if (row.status == 7){
                                return '<span class="badge badge-pill bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_SELESAI }}</span>';
                            }
                            else{
                                return '<span class="badge badge-pill bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                            }
                        }else{
                            return '-'
                        }
                    },
                    name: 'status',
                },
                {
                    'orderData': 8,
                    data: 'pegawaiid',
                    render: function (data, type, row) {
                        if(row.pegawaiid != null) { 
                            return `${row.nip} ${row.nama}`;
                        }
                    },
                    name: 'pegawaiid',
                    visible: false
                },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#kotaid').change(function () {
            kebutuhansarprastable.draw();
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
            kebutuhansarprastable.draw();
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
                kebutuhansarprastable.draw();
                 $('#history-table').hide();
            }
        });

        function showFotoDetailKebutuhanSarpras(kebutuhansarprasid) {
            var url = "{{ route('verifikasikebutuhansarpras.showFotoKebutuhanSarpras', ':id') }}";
            url = url.replace(':id', kebutuhansarprasid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    fotoSarprasKebutuhanTable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        fotoSarprasKebutuhanTable.row.add({
                            filesarpraskebutuhanid: response.data.data[i].filesarpraskebutuhanid,
                            filesarpraskebutuhan: response.data.data[i].filesarpraskebutuhan,
                            // file: response.data.data[i].file,
                        });
                    }

                    fotoSarprasKebutuhanTable.draw();
                    $('#foto-sarpras-kebutuhan-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Initialize history table
        var fotoSarprasKebutuhanTable = $('#foto-sarpras-kebutuhan-table').DataTable({
            responsive: true,
            processing: true,
            // serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: false,
            searching: false,
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
            columns: [
                {
                    data: 'filesarpraskebutuhan',
                    name: 'filesarpraskebutuhan'
                },
                {
                    orderData: 2, data: 'filesarpraskebutuhan', name: 'file',
                    render: function(data, type, row) {
                        if(row.filesarpraskebutuhan) {
                            return "<div class=\"d-flex justify-content-center align-items-center\"><iframe src=\"/storage/uploaded/sarpraskebutuhan/"+row.filesarpraskebutuhan+"\" height=\"300\" /></div>";
                        }
                    }
                }
            ],
            buttons: {
                buttons: [
                    {
                        text: '<i class="fa fa-download" aria-hidden="true"></i> Download',
                        className: 'edit btn btn-success btn-datatable mb-3',
                        action: () => {
                            if (fotoSarprasKebutuhanTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                                return;
                            }
                            let id = fotoSarprasKebutuhanTable.rows( { selected: true } ).data()[0]['filesarpraskebutuhanid'];
                            let url = "{{ route('sarpraskebutuhan.downloadfilesarpraskebutuhan', ':id') }}"
                            url = url.replace(':id', id);
                            console.log(url);
                            let today = new Date();
                            let dateTime = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+ "_"+today.getHours() + today.getMinutes() + today.getSeconds();
                            let namaFile = `SARPRAS_KEBUTUHAN_${dateTime}`
                            $.ajax({
                                    type: "GET",
                                    cache:false,
                                    processData: false,
                                    contentType: false,
                                    // defining the response as a binary file
                                    xhrFields: {
                                        responseType: 'blob' 
                                    },  
                                    url: url,
                                    success: (data) => {
                                        let a = document.createElement('a');
                                        let url = window.URL.createObjectURL(data);
                                        a.href = url;
                                        a.download = namaFile;
                                        document.body.append(a);
                                        a.click();
                                        a.remove();
                                        window.URL.revokeObjectURL(url);
                                    }
                            });
                        }
                    },
                ]
            }
        });

        function loadHistoryTable(sarpraskebutuhanid) {
            var url = "{{ route('verifikasikebutuhansarpras.history', ':id') }}";
            url = url.replace(':id', sarpraskebutuhanid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    historytable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        historytable.row.add({
                            tgl: response.data.data[i].tgl,
                            status: response.data.data[i].status,
                            keterangan: response.data.data[i].keterangan,
                            sarpraskebutuhanid: response.data.data[i].sarpraskebutuhanid
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

        // Listen for row selection event on kebutuhan-sarpras-table
        kebutuhansarprastable.on('select', function (e, dt, type, indexes) {
            var rowData = kebutuhansarprastable.rows(indexes).data()[0]; // Get selected row data
            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
            var status = rowData.status;

            setenableverifikasibutton(status);
            // Load history table with selected sarpraskebutuhanid
            loadHistoryTable(sarpraskebutuhanid);
        });

        kebutuhansarprastable.on('deselect', function ( e, dt, type, indexes ) {
            setenableverifikasibutton();
            // hide history table
            $('#history-table').hide();
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
                    data: 'tgl',
                    name: 'tgl',
                    render: function(data, type, row) {
                        if(row.tgl != null) {
                            return (DateFormat(row.tgl));
                        }
                        else{
                            return '-'
                        }
                    }
                },
                {'orderData': 2, data: 'status', 
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
                            }else if (row.status == 7){
                                return '<span class="badge badge-pill bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_SELESAI }}</span>';
                            }
                            else{
                                return '<span class="badge badge-pill bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                            }
                        }else{
                            return '-'
                        }
                    },
                    name: 'status',
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
