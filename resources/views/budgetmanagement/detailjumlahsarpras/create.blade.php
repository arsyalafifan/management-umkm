<?php
use App\enumVar as enum;
?>
@extends('layouts.master')
<style>
    input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}

.param_img_holder {
  display: none;  
}

.param_img_holder img.img-fluid {
  width: 110px;
  height: 70px;
  margin-bottom: 10px;
}

/* .modal{
    display: block !important;
} */
.modal-dialog{
    /* overflow-y: initial !important */
}
.modal-body{
  max-height: 80vh;
  overflow-y: auto !important;
}
.modal-open .modal {
    /* overflow-x: hidden; */
    overflow-y: hidden !important;
}

/* .tambah-foto.show:nth-of-type(even) {
    z-index: 1051 !important;
}
.edit-foto.show:nth-of-type(even) {
    z-index: 1051 !important;
} */
</style>

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h3 class="card-title text-uppercase">TAMBAH DETAIL JUMLAH SARPRAS</h3><hr />
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

            {{-- <form method="POST" action="{{ route('sarprastersedia.storeDetailJumlahSarpras') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data"> --}}
                @csrf
                <input type="hidden" name="detailsarprasid" id="detailsarprasid" value="{{ old('detailsarprasid', $detailsarpras->detailsarprasid) }}">

                {{-- <h4 class="card-title text-uppercase text-bold m-t-40">Upload Foto Kebutuhan Sarpras</h4><hr /> --}}

                {{-- <table id="demo-foo-addrow-sarprastersedia" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">Kondisi</th>
                            <th data-sort-initial="true" data-toggle="true">Jumlah</th>
                            <th data-sort-initial="true" data-toggle="true">Upload File</th>
                            <th data-sort-initial="true" data-toggle="true">Preview</th>
                            <th data-sort-ignore="true" data-toggle="true">Hapus</th>
                        </tr>
                    </thead>
                    <div class="padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-12 text-right m-b-5">
                                <button type="button" id="demo-btn-addrow-sarprastersedia" class="btn btn-primary"><i class="fldemo glyphicon glyphicon-plus"></i> Tambah
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <tbody id="tbody-sarprastersedia">
                        <tr>
                            <td class="border-0">
                                <select id="kondisi" class="form-control @error('kondisi') is-invalid @enderror" name='kondisi[]' required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    @foreach (enum::listKondisiSarpras() as $id)
                                    <option {{ old('kondisi') != '' || old('kondisi') != null ? 'selected' : '' }} value="{{ old('kondisi') ?? $id }}">{{ enum::listKondisiSarpras('desc')[$loop->index] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border-0">
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah[]" value="{{ (old('jumlah')) }}" maxlength="100" requied autocomplete="jumlah">
                            </td>
                            <td class="border-0">
                                <input type="file" class="form-control file-input" name="file[]" multiple/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                            </td>
                            <td class="border-0">
                                <div class="param_img_holder d-flex justify-content-center align-items-center">
                                </div>
                            </td>
                            <td class="border-0">
                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table> --}}

                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-jumlah-sarpras-table">
                        <thead>
                            <tr>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                                {{-- <th>Preview</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sarprastersedia.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Tersedia') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a> --}}
                    </div>
                </div>
            {{-- </form> --}}
            <!-- modal tambah -->
            <div class="modal" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Tambah Detail Jumlah Sarpras</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" id="tambahDetailJumlahSarpras" name="tambahDetailJumlahSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body">
                                <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                                <div class="form-group">
                                    <label for="kondisi" class="control-label">Kondisi:</label>
                                    <select id="kondisi" class="custom-select form-control @error('kondisi') is-invalid @enderror" name='kondisi' required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        @foreach (enum::listKondisiSarpras() as $id)
                                        <option {{ old('kondisi') != '' || old('kondisi') != null ? 'selected' : '' }} value="{{ old('kondisi') ?? $id }}">{{ enum::listKondisiSarpras('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah" class="control-label">Jumlah:</label>
                                    <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ (old('jumlah')) }}" maxlength="100" requied autocomplete="jumlah">
                                </div>
                                <div class="form-group">
                                    <label for="file" class="control-label">File:</label>
                                    <input id="file" type="file" class="form-control file-input" name="file[]" multiple /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button value="storeDetaiJumlahSarpras" type="submit" id="storeDetaiJumlahSarpras" class="btn btn-primary storeDetaiJumlahSarpras"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal edit -->
            <div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Edit Detail Jumlah Sarpras</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" id="editDetailJumlahSarpras" name="editDetailJumlahSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                                <div class="form-group">
                                    <label for="kondisi" class="control-label">Kondisi:</label>
                                    <select id="kondisi-edit" class="form-control @error('kondisi') is-invalid @enderror" name='kondisi' required>
                                        <option value="">-- Pilih Jenis Pagu --</option>
                                        @foreach (enum::listKondisiSarpras() as $id)
                                        <option {{ old('kondisi') != '' || old('kondisi') != null ? 'selected' : '' }} value="{{ old('kondisi') ?? $id }}">{{ enum::listKondisiSarpras('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah" class="control-label">Jumlah:</label>
                                    <input id="jumlah-edit" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ (old('jumlah')) }}" maxlength="100" requied autocomplete="jumlah">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered yajra-datatable table-striped" id="foto-detail-jumlah-sarpras-table-edit">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button value="updateDetaiJumlahSarpras" type="submit" id="updateDetaiJumlahSarpras" class="btn btn-primary updateDetaiJumlahSarpras"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-foto-detail-jumlah-sarpras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Foto Detail Jumlah Sarpras</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable table-striped" id="foto-detail-jumlah-sarpras-table">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal tambah-foto" id="modal-tambah-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Tambah Foto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" id="tambahFoto" name="tambahFoto" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file" class="control-label">File:</label>
                                    <input id="file-edit" type="file" class="form-control file-input" name="file" /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button value="storeFoto" type="submit" id="storeFoto" class="btn btn-primary storeFoto"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal edit-foto" id="modal-edit-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Edit Foto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" id="editFoto" name="editFoto" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file" class="control-label">File:</label>
                                    <input id="file-edit" type="file" class="form-control file-input" name="file" /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button value="updateFoto" type="submit" id="updateFoto" class="btn btn-primary updateFoto"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        {{-- <a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">Modals in Modal</a>


        <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <a href="#myModal1" role="button" class="btn btn-primary" data-toggle="modal">Launch other modal 1</a>
                        <a href="#myModal2" role="button" class="btn btn-primary" data-toggle="modal">Launch other modal 2</a>
                    </div>

                </div>
            </div>
        </div>

        <div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header 1</h4>
                    </div>
                    <div class="modal-body">
                        <p>Two modal body…1</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>

                </div>
            </div>
        </div>

        <div id="myModal2" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header 2</h4>
                    </div>
                    <div class="modal-body">
                        <p>Modal body…2</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>

                </div>
            </div>
        </div> --}}
        </div>
    </div>
</div>

<!-- foo table -->
{{-- <script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script> --}}

<script>

    // tambah detail jumlah sarpras
$(document).on('submit', '#tambahDetailJumlahSarpras', (e) => {
       e.preventDefault();
       
       let formData = new FormData($('#tambahDetailJumlahSarpras')[0]);

       let url = "{{ route('sarprastersedia.storeDetailJumlahSarpras') }}"

       $.ajax({
           type: 'POST',
           url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (json) => {
               let success = json.success;
               let message = json.message;
            //    let data = json.masterplan;

               detailJumlahSarprasTable.draw();
               $('#kondisi').val('');
               $('#jumlah').val('');
               $('#file').val('');
               $('#tambahDetailJumlahSarpras').trigger("reset");
               $('#modal-tambah').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data detail jumlah sarpras berhasil ditambah.", "success"); 
               }
               else {
                   swal.fire("Error!", data, "error"); 
               }
           }
       })
})

   // edit detail jumlah sarpras
   $(document).on('submit', '#editDetailJumlahSarpras', function(e){
       e.preventDefault();
       let id = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['detailjumlahsarprasid'];
       
       let formData = new FormData($('#editDetailJumlahSarpras')[0]);

       let url = "{{ route('sarprastersedia.updateDetailJumlahSarpras', ':id') }}"
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

               detailJumlahSarprasTable.draw();
               $('#kondisi-edit').val('');
               $('#jumlah-edit').val('');
               $('#file-edit').val('');
               $('#editDetailPaguSarpras').trigger("reset");
               $('#modal-edit').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data detail jumlah sarpras berhasil diubah.", "success"); 
               }
               else {
                   swal.fire("Error!", data, "error"); 
               }
           }
       })
})

var id = $('#detailsarprasid').val();
console.log(id);
var dataUrl = "{{ route('sarprastersedia.createDetailJumlahSarpras', ':id') }}";
dataUrl = dataUrl.replace(':id', id);
var detailJumlahSarprasTable = $('#detail-jumlah-sarpras-table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    pageLength: 50,
    dom: 'Bfrtip',
    select: true,
    ordering: true,
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
        url: dataUrl,
        dataSrc: function(response){
            response.recordsTotal = response.data.count;
            response.recordsFiltered = response.data.count;
            return response.data.data;
        },
        data: function ( d ) {
            return $.extend( {}, d, {
                // "kotaid": $("#kotaid").val().toLowerCase(),
                // "sekolahid": $("#sekolahid").val().toLowerCase(),
                // // "jenjang": $("#jenjang").val().toLowerCase(),
                // // "jenis": $("#jenis").val().toLowerCase(),
                // "search": $("#search").val().toLowerCase()
            } );
        }
    },
    buttons: {
        buttons: [
        {
            text: 'Tambah',
            className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
            action: () => {
                $('#modal-tambah').modal('show');
            }
        },
        {
            text: 'Ubah',
            className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
            action: () => {
                if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                    return;
                }
                var rowData = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                var detailjumlahsarprasid = rowData.detailjumlahsarprasid;
                console.log(detailjumlahsarprasid)
                let kondisi = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['kondisi'];
                let jumlah = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['jumlah'];

                $('#modal-edit').modal('show');

                $('#kondisi-edit option[value="'+kondisi+'"]').prop('selected', true);
                $('#jumlah-edit').val(jumlah);

                showFotoDetailJumlahSarprasEdit(detailjumlahsarprasid)
            }
        },  
        {
            text: 'Hapus',
            className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
            action: () => {
                if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                    return;
                }
                let id = detailJumlahSarprasTable.rows( { selected: true } ).data()[0]['detailjumlahsarprasid'];
                let url = "{{ route('sarprastersedia.destroyDetailJumlahSarpras', ':id') }}"
                url = url.replace(':id', id);
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
                                    detailJumlahSarprasTable.draw();
                                }
                                else {
                                    swal.fire("Error!", data, "error"); 
                                }
                            }
                        });  
                    }           
                });
            }
        },
        {
            text: 'Lihat Foto',
            className: 'edit btn btn-info btn-sm mb-3 btn-datatable',
            action: function() {

                if (detailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                    return;
                }
                else{
                    var rowData = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                    var detailjumlahsarprasid = rowData.detailjumlahsarprasid;
                    // var detailpagusarprasid = rowData.detailpagusarprasid;
                    console.log(detailjumlahsarprasid);
                    $('#modal-foto-detail-jumlah-sarpras').modal('show');
                    showFotoDetailJumlahSarpras(detailjumlahsarprasid)
                }
            }
        },
    ]
    },
    columns: [
        {'orderData': 1, data: 'kondisi', name: 'kondisi',
            render: function(data, type, row){
                if (row.kondisi != null || row.kondisi != '') {
                    if (row.kondisi == "{{ enum::KONDISI_SARPRAS_BAIK }}") {
                        return 'Baik'
                    } else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_BERAT }}"){
                        return 'Rusak Berat'
                    }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_SEDANG }}"){
                        return 'Rusak Sedang'
                    }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_RUSAK_RINGAN }}"){
                        return 'Rusak Ringan'
                    }else if (row.kondisi == "{{ enum::KONDISI_SARPRAS_BELUM_SELESAI }}"){
                        return 'Belum Selesai'
                    }
                }
            }
        },
        {'orderData': 2, data: 'jumlah', name: 'jumlah'},
    ],
    initComplete: function (settings, json) {
        $(".btn-datatable").removeClass("dt-button");
    },
});

function showFotoDetailJumlahSarpras(detailjumlahsarprasid) {
    var url = "{{ route('sarprastersedia.showFotoDetailJumlahSarpras', ':id') }}";
    url = url.replace(':id', detailjumlahsarprasid);

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {

            fotoDetailJumlahSarprasTable.clear();

            for (var i = 0; i < response.data.count; i++) {
                fotoDetailJumlahSarprasTable.row.add({
                    filedetailjumlahsarprasid: response.data.data[i].filedetailjumlahsarprasid,
                    file: response.data.data[i].file,
                });
            }

            fotoDetailJumlahSarprasTable.draw();
            $('#foto-detail-jumlah-sarpras-table').show();
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function showFotoDetailJumlahSarprasEdit(detailjumlahsarprasid) {
    var url = "{{ route('sarprastersedia.showFotoDetailJumlahSarpras', ':id') }}";
    url = url.replace(':id', detailjumlahsarprasid);

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {

            fotoDetailJumlahSarprasTableEdit.clear();

            for (var i = 0; i < response.data.count; i++) {
                fotoDetailJumlahSarprasTableEdit.row.add({
                    filedetailjumlahsarprasid: response.data.data[i].filedetailjumlahsarprasid,
                    file: response.data.data[i].file,
                });
            }

            fotoDetailJumlahSarprasTableEdit.draw();
            $('#foto-detail-jumlah-sarpras-table-edit').show();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

var fotoDetailJumlahSarprasTable = $('#foto-detail-jumlah-sarpras-table').DataTable({
    responsive: true,
    processing: true,
    // serverSide: true,
    pageLength: 50,
    dom: 'Bfrtip',
    select: true,
    ordering: true,
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
    buttons: {
        buttons: [
        {
            text: 'Download File',
            className: 'edit btn btn-success mb-3 btn-datatable',
            action: () => {
            if (fotoDetailJumlahSarprasTable.rows( { selected: true } ).count() <= 0) {
                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                return;
            }
            let id = fotoDetailJumlahSarprasTable.rows( { selected: true } ).data()[0]['filedetailjumlahsarprasid'];
            let namaFile = fotoDetailJumlahSarprasTable.rows( { selected: true } ).data()[0]['file'];
            let url = "{{ route('sarprastersedia.downloadFileDetailJumlahSarpras', ':id') }}"
            url = url.replace(':id', id);
            console.log(url);
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
            }
            );
            }
        }
    ]
    },
    columns: [
        {'orderData': 1, data: 'file', name: 'file'},
        {'orderData': 2, data: 'file', name: 'preview', 
            render: function (data, type, row){
                if(row.file != null){
                    return "<div class=\"d-flex justify-content-center align-items-center\"><img src=\"/storage/uploaded/sarprastersedia/detailjumlahsarpras/"+row.file+"\" height=\"300\" /></div>";
                }
            }
        },
    ],
    initComplete: function (settings, json) {
        $(".btn-datatable").removeClass("dt-button");
    },
});

// tambah file detail jumlah sarpras
$(document).on('submit', '#tambahFoto', (e) => {
    e.preventDefault();
       
    let formData = new FormData($('#tambahFoto')[0]);

    var rowData = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
    var detailjumlahsarprasid = rowData.detailjumlahsarprasid;

    let url = "{{ route('sarprastersedia.storeFileDetailJumlahSarpras', ':detailjumlahsarprasid') }}";
    url = url.replace(':detailjumlahsarprasid', detailjumlahsarprasid);


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

               showFotoDetailJumlahSarprasEdit(detailjumlahsarprasid)
               $('#file').val('');
               $('#tambahFoto').trigger("reset");
               $('.pip').remove();
               $('#modal-tambah-foto').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data detail pagu berhasil ditambah.", "success"); 
               }
               else {
                   swal.fire("Error!", data, "error"); 
               }
           }
       })
})

   // edit file detail jumlah sarpras
   $(document).on('submit', '#editFoto', function(e){
       e.preventDefault();
        var rowData = fotoDetailJumlahSarprasTableEdit.rows({ selected: true }).data()[0]; // Get selected row data
        var filedetailjumlahsarprasid = rowData.filedetailjumlahsarprasid;
       
        let formData = new FormData($('#editFoto')[0]);

        let url = "{{ route('sarprastersedia.updateFileDetailJumlahSarpras', ':id') }}"
        url = url.replace(':id', filedetailjumlahsarprasid);

        var row = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
        var detailjumlahsarprasid = row.detailjumlahsarprasid;

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

               showFotoDetailJumlahSarprasEdit(detailjumlahsarprasid)
               $('#file').val('');
               $('#editFoto').trigger("reset");
               $('.pip').remove();
               $('#modal-edit-foto').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data file detail jumlah sarpras berhasil diubah.", "success"); 
               }
               else {
                   swal.fire("Error!", data, "error"); 
               }
           }
       })
})

var fotoDetailJumlahSarprasTableEdit = $('#foto-detail-jumlah-sarpras-table-edit').DataTable({
    responsive: true,
    processing: true,
    // serverSide: true,
    pageLength: 50,
    dom: 'Bfrtip',
    select: true,
    ordering: true,
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
    buttons: {
        buttons: [
        {
            text: 'Tambah',
            className: 'edit btn btn-primary btn-sm btn-datatable mb-3',
            action: () => {
                $('#modal-tambah-foto').modal('show');
            }
        },
        {
            text: 'Ubah',
            className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
            action: () => {
                if (fotoDetailJumlahSarprasTableEdit.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                    return;
                }

                $('#modal-edit-foto').modal('show');
            }
        },
        {
            text: 'Hapus',
            className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
            action: () => {
                if (fotoDetailJumlahSarprasTableEdit.rows( { selected: true } ).count() <= 0) {
                    swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                    return;
                }
                let rowData = fotoDetailJumlahSarprasTableEdit.rows( { selected: true } ).data()[0];
                var id = rowData.filedetailjumlahsarprasid;
                
                let url = "{{ route('sarprastersedia.destroyFileDetailJumlahSarpras', ':id') }}"
                url = url.replace(':id', id);
                var row = detailJumlahSarprasTable.rows({ selected: true }).data()[0]; // Get selected row data
                var detailjumlahsarprasid = row.detailjumlahsarprasid;
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
                                    // fotoDetailJumlahSarprasTableEdit.draw();
                                    console.log(detailjumlahsarprasid);
                                    showFotoDetailJumlahSarprasEdit(detailjumlahsarprasid)
                                }
                                else {
                                    swal.fire("Error!", data, "error"); 
                                }
                            }
                        });  
                    }           
                });
            }
        }, 
        ]
    },
    columns: [
        {'orderData': 1, data: 'file', name: 'file'},
        {'orderData': 2, data: 'file', name: 'preview', 
            render: function (data, type, row){
                if(row.file != null){
                    return "<div class=\"d-flex justify-content-center align-items-center\"><img src=\"/storage/uploaded/sarprastersedia/detailjumlahsarpras/"+row.file+"\" height=\"300\" /></div>";
                }
            }
        },
    ],
    initComplete: function (settings, json) {
        $(".btn-datatable").removeClass("dt-button");
    },
});
//     $(function() {
//     // Multiple images preview with JavaScript
//     var previewImages = function(input, imgPreviewPlaceholder) {
 
//         if (input.files) {
//             var filesAmount = input.files.length;
 
//             for (i = 0; i < filesAmount; i++) {
//                 var reader = new FileReader();
 
//                 reader.onload = function(event) {
//                     $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
//                 }
 
//                 reader.readAsDataURL(input.files[i]);
//             }
//         }
 
//     };
 
//     $('#filesarpraskebutuhan').on('change', function() {
//         previewImages(this, 'div.images-preview-div');
//     });
//   });

// $(document).ready(function (e) {
 
   
//  $('.image').change(function(){
          
//   let reader = new FileReader();

//   reader.onload = (e) => { 

//     $('#preview-image-before-upload').attr('src', e.target.result); 
//   }

//   reader.readAsDataURL(this.files[0]); 
 
//  });
 
// });

const validExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];

$('form').on('change', '.file-input', function(e) {
  const $input = $(this);
  const imgPath = $input.val();
  const $imgPreview = $input.closest('form').find('.param_img_holder');
  const extension = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

var clickedButton = this;
var files = e.target.files,
filesLength = files.length;

  if (typeof(FileReader) == 'undefined') {
    $imgPreview.html('This browser does not support FileReader');
    return;
  }

  for (let i = 0; i < filesLength; i++) {
    
    var f = files[i];

    if (validExtensions.includes(extension)) {
        $imgPreview.empty();
        var reader = new FileReader();
        reader.onload = function(e) {
            var file = e.target
            // $('<iframe/>', {
            //     src: e.target.result,
            //     height: 300,
            //     width: 300,
            // }).appendTo($imgPreview);

            $("<div class=\"pip\">" +
            "<img width=\"100%\" height=\"600px\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" />" +
            // "<br/><div class=\"remove\">Remove image</div>" +
            "</div>").appendTo($imgPreview);
            // $(".remove").click(function(){
            //     $(this).parent(".pip").remove();
            // });
        }
        // $imgPreview.show();
        // reader.readAsDataURL($input[0].files[0]);
        reader.readAsDataURL(f);
  } else {
    $imgPreview.empty();
  }

  }
});

$('.modal-child').on('show.bs.modal', function () {
    var modalParent = $(this).attr('data-modal-parent');
    $(modalParent).css('opacity', 0);
});
 
$('.modal-child').on('hidden.bs.modal', function () {
    var modalParent = $(this).attr('data-modal-parent');
    $(modalParent).css('opacity', 1);
});

// $(document).ready(function() {
//   if (window.File && window.FileList && window.FileReader) {
//     $(".files").on("change", function(e) {
//     	var clickedButton = this;
//         var files = e.target.files,
//         filesLength = files.length;
//       for (var i = 0; i < filesLength; i++) {
//         var f = files[i]
//         var fileReader = new FileReader();
//         fileReader.onload = (function(e) {
//           var file = e.target;
//           $("<div class=\"pip\">" +
//             "<iframe width=\"100%\" height=\"600px\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"></iframe>" +
//             "<br/><div class=\"remove\">Remove image</div>" +
//             "</div>").insertAfter(clickedButton);
//           $(".remove").click(function(){
//             $(this).parent(".pip").remove();
//           });
//           });
//         fileReader.readAsDataURL(f);
//       }
//     });
//   } else {
//     alert("Your browser doesn't support to File API")
//   }
// });


$(document).ready(function() {
      $(".btn-success").click(function(){ 
          var lsthmtl = $(".clone").html();
          $(".increment").after(lsthmtl);
      });
      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });
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
{{-- <script>
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
        var newRow = '<tr><td class="border-0"><select id="kondisi" class="form-control @error("kondisi") is-invalid @enderror" name="kondisi[]" required><option value="">-- Pilih Kondisi --</option>@foreach (enum::listKondisiSarpras() as $id)<option {{ old("kondisi") != '' || old("kondisi") != null ? "selected" : '' }} value="{{ old("kondisi") ?? $id }}">{{ enum::listKondisiSarpras("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0"><input id="jumlah" type="number" class="form-control @error("jumlah") is-invalid @enderror" name="jumlah[]" value="{{ (old("jumlah")) }}" maxlength="100" requied autocomplete="jumlah"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" multiple/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td>';

        //add it
        footable.appendRow(newRow);

    });
});
</script> --}}

<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>
@endsection
