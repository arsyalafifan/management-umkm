<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">EDIT DATA</h5><hr />
            @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </p>
            @endforeach
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <form method="POST" action="{{ route('sarpraskebutuhan.update', $sarpraskebutuhan->sarpraskebutuhanid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$sarpraskebutuhan->sekolahid) }}">
                <input type="hidden" name="sarpraskebutuhanid" id="sarpraskebutuhanid" value="{{ $sarpraskebutuhan->sarpraskebutuhanid }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nopengajuan" class="col-md-12 col-form-label text-md-left">{{ __('Nomor Pengajuan *') }}</label>
        
                            <div class="col-md-12">
                                <input id="nopengajuan" type="text" class="form-control @error('nopengajuan') is-invalid @enderror" name="nopengajuan" value="{{ (old('nopengajuan')) ?? $sarpraskebutuhan->nopengajuan }}" maxlength="100" required autocomplete="nopengajuan" autofocus>
        
                                @error('nopengajuan')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tglpengajuan" class="col-md-12 col-form-label text-md-left">{{ __('Tanggal Pengajuan *') }}</label>
                            <div class="col-md-12">
                                <input type="date" class="form-control @error('tglpengajuan') is-invalid @enderror" id="tglpengajuan" name="tglpengajuan" value="{{ old('tglpengajuan') ?? $sarpraskebutuhan->tglpengajuan }}" required>
                                @error('tglpengajuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jeniskebutuhan" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Kebutuhan *') }}</label>
                            <div class="col-md-12">
                                <select id="jeniskebutuhan" class="custom-select form-control @error('jeniskebutuhan') is-invalid @enderror" name='jeniskebutuhan' required>
                                    <option value="">-- Jenis Kebutuhan --</option>
                                    @foreach (enum::listJenisKebutuhan() as $id)
                                        <option {{ $sarpraskebutuhan->jeniskebutuhan == $id ? 'selected' : '' }} value="{{ $id }}"> {{ enum::listJenisKebutuhan('desc')[$loop->index] }}</option>
                                    @endforeach
                                </select>
                                @error('jeniskebutuhan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kepalasekolah" class="col-md-12 col-form-label text-md-left">{{ __('Kepala Sekolah *') }}</label>
        
                            <div class="col-md-12">
                                <select id="pegawaiid" class="custom-select form-control @error('pegawai') is-invalid @enderror" name='pegawaiid' required>
                                    <option value="">-- Pilih Kepala Sekolah --</option>
                                    @foreach ($pegawai as $item)
                                    <option {{ $sarpraskebutuhan->pegawaiid == $item->pegawaiid ? 'selected' : '' }} value="{{$sarpraskebutuhan->pegawaiid}}">{{ 'NIP: ' . $item->nip . ' | NAMA: ' . $item->nama }}</option>
                                    @endforeach
                                </select>
        
                                @error('pegawaiid')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenissarpras" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Sarpras Tersedia *') }}</label>
        
                            <div class="col-md-12">
                                <select id="jenissarpras" class="custom-select form-control @error('jenissarpras') is-invalid @enderror" name='jenissarpras' required>
                                    <option value="">-- Pilih Jenis Sarpras Tersedia --</option>
                                    <option {{ $sarpraskebutuhan->jenissarpras == enum::SARPRAS_UTAMA ? 'selected' : '' }} value="{{ enum::SARPRAS_UTAMA }}">{{ __('Sarpras Utama') }}</option>
                                    <option {{ $sarpraskebutuhan->jenissarpras == enum::SARPRAS_PENUNJANG ? 'selected' : '' }} value="{{ enum::SARPRAS_PENUNJANG }}">{{ __('Sarpras Penunjang') }}</option>
                                    <option {{ $sarpraskebutuhan->jenissarpras == enum::SARPRAS_PERALATAN ? 'selected' : '' }} value="{{ enum::SARPRAS_PERALATAN }}">{{ __('Sarpras Peralatan') }}</option>
                                </select>
        
                                @error('jenissarpras')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
        
                            <div class="col-md-12">
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ (old('jumlah')) ?? $sarpraskebutuhan->jumlah }}" maxlength="100" required autocomplete="jumlah">
        
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
                                <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ (old('satuan')) ?? $sarpraskebutuhan->satuan }}" maxlength="100" required autocomplete="satuan">
        
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namasarpras" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpras *') }}</label>
        
                            <div class="col-md-12">
                                <select id="namasarprasid" class="custom-select form-control @error('namasarpras') is-invalid @enderror" name='namasarprasid' required>
                                    <option value="">-- Pilih Nama Sarpras --</option>
                                    @foreach ($namasarpras as $item)
                                    <option {{ $sarpraskebutuhan->namasarprasid == $item->namasarprasid ? 'selected' : '' }} value="{{$item->namasarprasid}}">{{ $item->namasarpras }}</option>
                                    @endforeach
                                </select>
        
                                @error('namasarpras')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thang" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Anggaran *') }}</label>

                            <div class="col-md-12">
                                <select id="thang" class="custom-select form-control @error('thang') is-invalid @enderror" name='thang' required>
                                    <option value="">-- Tahun Anggaran --</option>
                                    @foreach (enum::listTahun() as $id)
                                        <option {{ $sarpraskebutuhan->thang == $id ? 'selected' : '' }} value="{{ $id }}"> {{ enum::listTahun('desc')[$loop->index] }}</option>
                                    @endforeach
                                </select>

                                @error('thang')
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
                        <h3 class="box-title text-uppercase m-b-0">Detail Kebutuhan Sarpras</h3><hr />
                        {{-- <p class="text-muted m-b-20">Klik Tambah Master Plan Sekolah untuk menambah data </p> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered yajra-datatable table-striped" id="sarpras-kebutuhan-table">
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

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sarpraskebutuhan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Kebutuhan') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a> --}}
                    </div>
                </div>
            </form>
            <!-- modal tambah detail -->
            <div class="modal" id="modal-detail-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Tambah Detail Sarpras Kebutuhan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" id="tambahDetailSarprasKebutuhan" name="tambahDetailSarprasKebutuhan" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible print-error-msg" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <ul></ul>
                            </div>
                            @csrf
                                <input type="hidden" name="sarpraskebutuhanid" value={{ $sarpraskebutuhan->sarpraskebutuhanid }} id="sarpraskebutuhanid"/>
                                <div class="form-group">
                                    <label for="filesarpraskebutuhan" class="control-label">File:</label>
                                    <input type="file" name="filesarpraskebutuhan" class="form-control" id="filesarpraskebutuhan">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button value="storeDetailSarprasKebutuhan" type="submit" id="storeDetailSarprasKebutuhan" class="btn btn-primary storeDetailSarprasKebutuhan"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- modal edit detail -->
            <div class="modal" id="modal-detail-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Edit Detail Sarpras Kebutuhan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible print-error-msg" style="display:none">
                                <ul></ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </div>
                            <form method="POST" id="editDetailSarprasKebutuhan" name="editDetailSarprasKebutuhan" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="sarpraskebutuhanid" value={{ $sarpraskebutuhan->sarpraskebutuhanid }} id="sarpraskebutuhanid"/>
                                <div class="form-group">
                                    <label for="filesarpraskebutuhan" class="control-label">File:</label>
                                    <input type="file" name="filesarpraskebutuhan" class="form-control" id="filesarpraskebutuhan">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button value="updateDetailSarprasKebutuhan" type="submit" id="updateDetailSarprasKebutuhan" class="btn btn-primary updateDetailSarprasKebutuhan"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script>

<!-- table sarpras kebutuhan -->
<script>

    // tambah detail sarpras kebutuhan
    $(document).on('submit', '#tambahDetailSarprasKebutuhan', (e) => {
       e.preventDefault();
       
       let formData = new FormData($('#tambahDetailSarprasKebutuhan')[0]);

       let url = "{{ route('sarpraskebutuhan.storedetailsarpraskebutuhan') }}"

       $.ajax({
           type: 'POST',
           url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (json) => {
               let success = json.success;
               let message = json.message;
               let data = json.masterplan;
               let errors = json.errors;

               if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data detail sarpras kebutuhan berhasil ditambah.", "success"); 
                    sarpraskebutuhantable.draw();
                    $('#filesarpraskebutuhan').val('');
                    $('#tambahDetailSarprasKebutuhan').trigger("reset");
                    $('#modal-detail-tambah').modal('hide');
               }
               else {
                    console.log(errors);// this will be the error bag.
                    // printErrorMsg(errors);
                    swal.fire("Error!", errors.filesarpraskebutuhan[0], "error"); 
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
   $(document).on('submit', '#editDetailSarprasKebutuhan', function(e){
       e.preventDefault();
       let id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['filesarpraskebutuhanid'];
       
       let formData = new FormData($('#editDetailSarprasKebutuhan')[0]);

       let url = "{{ route('sarpraskebutuhan.updatedetailsarpraskebutuhan', ':id') }}"
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

               if (success == 'true' || success == true) {
                    swal.fire("Berhasil!", "Data detail sarpras kebutuhan berhasil diubah.", "success");
                    sarpraskebutuhantable.draw();
                    $('#filesarpraskebutuhan').val('');
                    $('#editDetailSarprasKebutuhan').trigger("reset");
                    $('#modal-detail-edit').modal('hide'); 
               }
               else {
                    // var data = jqXHR.responseJSON;
                    console.log(errors);// this will be the error bag.
                    // printErrorMsg(errors);
                    // swal.fire("Error!", errors, "error"); 
                    swal.fire("Error!", errors.filesarpraskebutuhan[0], "error"); 
               }
           },
           error: function(jqXHR, textStatus, errorThrown) {
                var data = jqXHR.responseJSON;
                console.log(data.errors);// this will be the error bag.
                printErrorMsg(data.errors);
            }
       })
   })

   function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
   
   var url = "{{ route('sarpraskebutuhan.edit', ':id') }}"
   url = url.replace(':id', $('#sarpraskebutuhanid').val());
   var sarpraskebutuhantable = $('#sarpras-kebutuhan-table').DataTable({
       responsive: true,
       processing: true,
       serverSide: true,
       pageLength: 50,
       dom: 'Bfrtip',
       select: true,
       ordering: false,
       searching: false,
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
           url: url,
           dataSrc: function(response){
               response.recordsTotal = response.data.countSarprasKebutuhan;
               response.recordsFiltered = response.data.countSarprasKebutuhan;
               return response.data.filesarpraskebutuhan;
           },
           data: function ( d ) {
               return $.extend( {}, d, {
                   "sarpraskebutuhanid": $("#sarpraskebutuhanid").val().toLowerCase(),
               } );
           }
       },
       buttons: {
           buttons: [
           {
               text: 'Tambah',
               className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
               action: () => {
                   $('#modal-detail-tambah').modal('show');
               }
           }, 
           {
               text: 'Ubah',
               className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
               action: () => {
                   if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                       swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                       return;
                   }
                //    let masterplan = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['masterplan'];
                   $('#modal-detail-edit').modal('show');
                //    $('#masterplan option[value="'+masterplan+'"]').prop('selected', true);
               }
           }, 
           {
               text: 'Hapus',
               className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
               action: () => {
                   if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                       swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                       return;
                   }
                   let id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['filesarpraskebutuhanid'];
                   let url = "{{ route('sarpraskebutuhan.hapusdetailsarpraskebutuhan', ':id') }}"
                   url = url.replace(':id', id);
                   swal.fire({   
                       title: "Apakah anda yakin akan menghapus file sarpras kebutuhan ini?",   
                       text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
                       type: "warning",   
                       showCancelButton: true,   
                       confirmButtonColor: "#DD6B55",   
                       confirmButtonText: "Ya, lanjutkan!",   
                       closeOnConfirm: false 
                   }).then(() => {
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
                           success: (json) => {
                               let success = json.success;
                               let message = json.message;
                               let data = json.data;
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
                   });
               }
           },
           {
               text: 'Download',
               className: 'edit btn btn-success btn-sm btn-datatable mb-3',
               action: () => {
                   if (sarpraskebutuhantable.rows( { selected: true } ).count() <= 0) {
                       swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                       return;
                   }
                   let id = sarpraskebutuhantable.rows( { selected: true } ).data()[0]['filesarpraskebutuhanid'];
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
       },
       columns: [
           // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
        //    {'orderData': 1, data: 'kondisi',
        //        render: function ( data, type, row ) {
        //            if(row.kondisi!=null){
        //                if(row.kondisi=="{{enum::KONDISI_SARPRAS_BAIK}}") 
        //                    return 'Baik';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_BERAT}}") 
        //                    return 'Rusak Berat';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_SEDANG}}") 
        //                    return 'Rusak Sedang';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_RINGAN}}") 
        //                    return 'Rusak Ringan';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_BELUM_SELESAI}}") 
        //                    return 'Belum Selesai';
        //                else return "-";
        //            }else
        //                return "-";
        //        }, 
        //        name: 'kondisi'},
        //    {'orderData': 2, data: 'jumlahunit', name: 'jumlahunit'},
        //    {'orderData': 1, data: 'filesarpraskebutuhanid', name: 'filesarpraskebutuhanid'},
           {'orderData': 1, data: 'filesarpraskebutuhan', name: 'filesarpraskebutuhan'},
           {'orderData': 2, data: 'filesarpraskebutuhan', 
            render: function (data, type, row){
                if(row.filesarpraskebutuhan != null){
                    return "<div class=\"d-flex justify-content-center align-items-center\"><img src=\"/storage/uploaded/sarpraskebutuhan/"+row.filesarpraskebutuhan+"\" height=\"200\"/></div>";
                }
            }
            },
       ],
       initComplete: function (settings, json) {
           $(".btn-datatable").removeClass("dt-button");
       },
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
           sekolahtable.draw();
       }
   });
</script>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        // var url = "{{ route('sarpraskebutuhan.nextno') }}"
        // // url = url.replace(':parentid', $('#kecamatanid').val());
        // $.ajax({
        //     url:url,
        //     type:"GET",
        //     success:function(data) {
        //         $('#nopengajuan').val(data);
        //     }
        // });

        $('#kotaid').select2().on('change', function() {
            if ($('#kotaid').val() == "") {
                $('#kodekec').val('');
            }
            else {
                var url = "{{ route('kecamatan.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#kotaid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kodekec').val(data);
                    }
                });
            }
        }).trigger('change');

        $('#jenissarpras').select2().on('change', function() {
            var url = "{{ route('sarpraskebutuhan.getNamaSarpras', ':parentid') }}";
            url = url.replace(':parentid', ($('#jenissarpras').val() == "" || $('#jenissarpras').val() == null ? "-1" : $('#jenissarpras').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#namasarprasid').empty();
                    $('#namasarprasid').append($("<option></option>").attr("value", "").text("-- Pilih Nama Sarpras --"));
                    $.each(data.data, function(key, value) {
                        $('#namasarprasid').append($("<option></option>").attr("value", value.namasarprasid).text(value.namasarpras));
                    });
                    $('#namasarprasid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#namasarprasid').trigger('change');

                }
            })
        })
    });
</script>

<!-- Sarpras Tersedia -->
<script>
    $(window).on('load', function() {

    // Search input
    $('#demo-input-search2').on('input', function (e) {
        e.preventDefault();
        addrow.trigger('footable_filter', {filter: $(this).val()});
    });

    // Add & Remove Row
    var addrow = $('#demo-foo-addrow-sarprastersedia');
    addrow.footable().on('click', '.delete-row-btn', function() {

        //get the footable object
        var footable = addrow.data('footable');

        //get the row we are wanting to delete
        var row = $(this).parents('tr:first');

        //delete the row
        footable.removeRow(row);
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

        //get the footable object
        var footable = addrow.data('footable');
        
        //build up the row we are wanting to add
        var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="filesarpraskebutuhan[]" id="filesarpraskebutuhan" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


        //add it
        footable.appendRow(newRow);

    });
});
</script>
@endsection
