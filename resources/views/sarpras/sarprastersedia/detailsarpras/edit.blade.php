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
</style>

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h3 class="card-title text-uppercase">TAMBAH DETAIL SARPRAS</h3><hr />
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

            <form method="POST" action="{{ route('sarprastersedia.updateDetailSarpras', $detailsarpras->detailsarprasid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="detailsarprasid" id="detailsarprasid" value="{{ $detailsarpras->detailsarprasid }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thperolehan" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Perolehan *') }}</label>
        
                            <div class="col-md-12">
                                <select id="thperolehan" class="custom-select form-control @error('thperolehan') is-invalid @enderror" name='thperolehan' required>
                                    <option value="">-- Pilih Tahun Perolehan --</option>
                                    @foreach (enum::listTahun() as $id)
                                    <option {{ old('thperolehan') != '' && old('thperolehan') == $id || $detailsarpras->thperolehan == $id ? 'selected' : '' }} value="{{$id}}">{{ enum::listTahun('desc')[$loop->index]}}</option>
                                    @endforeach
                                </select>
        
                                @error('thperolehan')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="koderekening" class="col-md-12 col-form-label text-md-left">{{ __('Kode Rekening *') }}</label>
        
                            <div class="col-md-12">
                                <select id="koderekening" class="custom-select form-control @error('koderekening') is-invalid @enderror" name='koderekening' required>
                                    <option value="">-- Kode Rekening --</option>
                                    @foreach ($koderekening as $item)
                                        <option {{ old('koderekening') != '' && old('koderekening') != $item->jenid || $detailsarpras->jenid == $item->jenid ? 'selected' : '' }} value="{{ old('koderekening') ?? $item->jenid }}">{{ $item->jenkode . ' ' . $item->jennama }}</option>
                                    @endforeach
                                </select>
        
                                @error('koderekening')
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
                            <label for="subkegid" class="col-md-12 col-form-label text-md-left">{{ __('Sub Kegiatan *') }}</label>
        
                            <div class="col-md-12">
                                <select id="subkegid" class="custom-select form-control @error('subkegid') is-invalid @enderror" name='subkegid'>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                    @foreach ($subkegiatan as $item)
                                    <option {{ old('subkegid') != '' && old('subkegid') == $item->subkegid || $item->subkegid == $detailsarpras->subkegid ? 'selected' : '' }} value="{{$item->subkegid}}">{{ $item->progkode .  $item->kegkode .  $item->subkegkode . ' ' . $item->subkegnama}}</option>
                                    @endforeach
                                </select>
        
                                @error('subkegid')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumberdana" class="col-md-12 col-form-label text-md-left">{{ __('Sumber Dana *') }}</label>
        
                            <div class="col-md-12">
                                <select id="sumberdana" class="custom-select form-control @error('sumberdana') is-invalid @enderror" name='sumberdana' required>
                                    <option value="">-- Pilih Sumber Dana --</option>
                                    @foreach (enum::listSumberDana('desc') as $id)
                                        <option {{ old('sumberdana') != '' && old('sumberdana') == $id || $detailsarpras->sumberdana == $id ? 'selected' : '' }} value="{{ $id }}">{{ enum::listSumberDana('desc')[$loop->index] }}</option>
                                    @endforeach
                                    {{-- <option {{ old('sumberdana') != '' && old('sumberdana') == 'DAK' || $detailsarpras->sumberdana == 'DAK' ? 'selected' : '' }} value="DAK">{{ __('DAK') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'BOS' || $detailsarpras->sumberdana == 'BOS' ? 'selected' : '' }} value="BOS">{{ __('BOS') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'SPP' || $detailsarpras->sumberdana == 'SPP' ? 'selected' : '' }} value="SPP">{{ __('SPP') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'APBD' || $detailsarpras->sumberdana == 'APBD' ? 'selected' : '' }} value="APBD">{{ __('APBD') }}</option> --}}
                                </select>
        
                                @error('sumberdana')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subdetailkeg" class="col-md-12 col-form-label text-md-left">{{ __('Sub Detail Kegiatan *') }}</label>
        
                            <div class="col-md-12">
                                <input id="subdetailkeg" required type="text" class="form-control @error('subdetailkeg') is-invalid @enderror" name="subdetailkeg" value="{{ old('subdetailkeg') ?? $detailsarpras->subdetailkegiatan }}" maxlength="255">
        
                                @error('subdetailkeg')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <h4 class="card-title text-uppercase text-bold m-t-40">Upload Foto Kebutuhan Sarpras</h4><hr /> --}}

                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-pagu-sarpras-table" style="font-weight: 300;">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Jenis Pagu</th>
                                <th class="text-center" rowspan="2">Nilai Pagu</th>
                                <th class="text-center" rowspan="2">No Kontrak</th>
                                <th class="text-center" rowspan="2">Nilai Kontrak</th>
                                <th class="text-center" rowspan="2">Perusahaan</th>
                                <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                                <th class="text-center" rowspan="2">Upload File</th>
                                <th class="text-center" rowspan="2">Preview</th>
                            </tr>
                            <tr>
                                <th class="text-center">Dari</th>
                                <th class="text-center">Sampai</th>
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
            </form>
            <!-- modal tambah -->
            <div class="modal" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Tambah Detail Pagu</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <form method="POST" id="tambahDetailPaguSarpras" name="tambahDetailPaguSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                                <div class="form-group">
                                    <label for="jenispagu" class="control-label">Jenis Pagu:</label>
                                    <select id="jenispagu" class="custom-select-add-pagu form-control @error('jenispagu') is-invalid @enderror" name='jenispagu' required>
                                        <option value="">-- Pilih Jenis Pagu --</option>
                                        @foreach (enum::listJenisPagu() as $id)
                                        <option value="{{ $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nilaipagu" class="control-label">Nilai Pagu:</label>
                                    <input id="nilaipagu" type="number" class="form-control @error('nilaipagu') is-invalid @enderror" name="nilaipagu" value="{{ (old('nilaipagu')) }}" maxlength="100" required autocomplete="name">
                                </div>
                                <div class="form-group">
                                    <label for="nokontrak" class="control-label">Nomor Kontrak:</label>
                                    <input id="nokontrak" type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak" value="{{ (old('nokontrak')) }}" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilaikontrak" class="control-label">Nilai Kontrak:</label>
                                    <input id="nilaikontrak" type="number" class="form-control @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak" value="{{ (old('nilaikontrak')) }}" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label for="perusahaanid" class="control-label">Perusahaan:</label>
                                    <select id="perusahaanid" class="custom-select-add-pagu form-control @error('perusahaanid') is-invalid @enderror" name="perusahaanid" required>
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach ($perusahaan as $item)
                                        <option value="{{ $item->perusahaanid }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tgldari" class="control-label">Dari Tanggal:</label>
                                    <input type="date" class="form-control @error('tgldari') is-invalid @enderror" id="tgldari" name="tgldari" value="{{ old('tgldari') }}" required onchange="compareDates()">
                                    @error('tgldari')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tglsampai" class="control-label">Sampai Tanggal:</label>
                                    <input type="date" class="form-control @error('tglsampai') is-invalid @enderror" id="tglsampai" name="tglsampai" value="{{ old('tglsampai') }}" required onchange="compareDates()">
                                    @error('tglsampai')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="control-label">File:</label>
                                    <input type="file" class="file-input fileinput fileinput-new input-group" name="file" required/>
                                    <span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 5MB</span>
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button value="storeDetailPaguSarpras" type="submit" id="storeDetailPaguSarpras" class="btn btn-primary storeDetailPaguSarpras"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal edit -->
            <div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <div class="modal-header d-flex">
                            <h4 class="modal-title" id="exampleModalLabel">Edit Detail Pagu</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg">
                                <ul></ul>
                            </div>
                            <form method="POST" id="editDetailPaguSarpras" name="editDetailPaguSarpras" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/>
                                <div class="form-group">
                                    <label for="jenispagu" class="control-label">Jenis Pagu:</label>
                                    <select id="jenispagu-edit" class="custom-select-edit-pagu form-control @error('jenispagu') is-invalid @enderror" name='jenispagu' required>
                                        <option value="">-- Pilih Jenis Pagu --</option>
                                        @foreach (enum::listJenisPagu() as $id)
                                        <option {{ $id != '' ? 'selected' : '' }} value="{{ $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nilaipagu" class="control-label">Nilai Pagu:</label>
                                    <input id="nilaipagu-edit" type="number" class="form-control @error('nilaipagu') is-invalid @enderror" name="nilaipagu" value="{{ (old('nilaipagu')) }}" maxlength="100" required autocomplete="name">
                                </div>
                                <div class="form-group">
                                    <label for="nokontrak" class="control-label">Nomor Kontrak:</label>
                                    <input id="nokontrak-edit" type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak" value="{{ (old('nokontrak')) }}" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilaikontrak" class="control-label">Nilai Kontrak:</label>
                                    <input id="nilaikontrak-edit" type="number" class="form-control @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak" value="{{ (old('nilaikontrak')) }}" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label for="perusahaanid" class="control-label">Perusahaan:</label>
                                    <select id="perusahaanid-edit" class="custom-select-edit-pagu form-control @error('perusahaanid') is-invalid @enderror" name="perusahaanid" required>
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach ($perusahaan as $item)
                                        <option value="{{ $item->perusahaanid }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tgldari" class="control-label">Dari Tanggal:</label>
                                    <input type="date" class="form-control @error('tgldari') is-invalid @enderror" id="tgldari-edit" name="tgldari" value="{{ old('tgldari') }}" required onchange="compareDates()">
                                    @error('tgldari')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tglsampai" class="control-label">Sampai Tanggal:</label>
                                    <input type="date" class="form-control @error('tglsampai') is-invalid @enderror" id="tglsampai-edit" name="tglsampai" value="{{ old('tglsampai') }}" required onchange="compareDates()">
                                    @error('tglsampai')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="control-label">File:</label>
                                    <input type="file" class="form-control file-input" name="file" /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 5MB</span>
                                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button value="storeDetailPaguSarpras" type="submit" id="storeDetailPaguSarpras" class="btn btn-primary storeDetailPaguSarpras"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                                    </button>
                                </div>
                            </form>
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

{{-- <script>
    $(document).ready(function() {
        // $(".alert").hide();
        // $("#myWish").click(function showAlert() {
        //     $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
        //         $("#success-alert").slideUp(500);
        //     });
        // });
        // $(".alert").fadeTo(2000, 500).slideUp(500, function() {
        //     $(".alert").slideUp(500);
        // });
        // setTimeout(function() {
        //     $(".alert").hide();
        // }, 2000);

        $(".alert").delay(4000).slideUp(200, function() {
            $(this).hide();
        });
        });
</script> --}}

<script>

    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 4000);
    });    

    $('.custom-select-add-pagu').select2({
        dropdownParent: $("#modal-tambah .modal-content")
    });
    $('.custom-select-edit-pagu').select2({
        dropdownParent: $("#modal-edit .modal-content")
    });

function compareDates() {
    var startDate = Date.parse($('#tglpelaksanaan').val());
    var startDate2 = Date.parse($('#tglpelaksanaan-edit').val());
    var today = new Date();
    var todayYMD = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
    if (!isNaN(startDate) && startDate > today.getTime() ) {
        // alert("The first date is after the second date!");
        swal.fire('Peringatan!', `Tanggal pengajuan tidak boleh melebihi tanggal ${todayYMD}`, 'warning');
        $('#tglpelaksanaan').val('');
    }
    if (!isNaN(startDate2) && startDate2 > today.getTime() ) {
        // alert("The first date is after the second date!");
        swal.fire('Peringatan!', `Tanggal pengajuan tidak boleh melebihi tanggal ${todayYMD}`, 'warning');
        $('#tglpelaksanaan-edit').val('');
    }
}

// tambah detail sarpras kebutuhan
$(document).on('submit', '#tambahDetailPaguSarpras', (e) => {
       e.preventDefault();
       
       let formData = new FormData($('#tambahDetailPaguSarpras')[0]);

       let url = "{{ route('sarprastersedia.storeDetailPagu') }}"

       $.ajax({
           type: 'POST',
           url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (json) => {
               let success = json.success;
               let message = json.message;
               let data = json.data;
            //    let error = json.errors;

               detailPaguSarprasTable.draw();
               $('#jenispagu').val('');
               $('#nilaipagu').val('');
               $('#perusahaanid').val('');
               $('#tglpelaksanaan').val('');
            //    $('#file').val('');
               $('#tambahDetailPaguSarpras').trigger("reset");
               $('#modal-tambah').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data detail pagu berhasil ditambah.", "success"); 
               }
               else{
                   swal.fire("Error!", data, "error"); 
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
   $(document).on('submit', '#editDetailPaguSarpras', function(e){
       e.preventDefault();
       let id = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['detailpagusarprasid'];
       
       let formData = new FormData($('#editDetailPaguSarpras')[0]);

       let url = "{{ route('sarprastersedia.updateDetailPagu', ':id') }}"
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
               let data = json.data;

               detailPaguSarprasTable.draw();
               $('#jenispagu-edit').val('');
               $('#nilaipagu-edit').val('');
               $('#perusahaanid-edit').val('');
               $('#tglpelaksanaan-edit').val('');
            //    $('#file').val('');
               $('#editDetailPaguSarpras').trigger("reset");
               $('#modal-edit').modal('hide');

               if (success == 'true' || success == true) {
                   swal.fire("Berhasil!", "Data detail sarpras kebutuhan berhasil diubah.", "success"); 
               }
               else {
                   swal.fire("Error!", data, "error"); 
               }
           },
           error: function(jqXHR, textStatus, errorThrown) {

            var errors = jqXHR.responseJSON;
                $.each(errors.errors,function (key, value) {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html:
                        '<p>' + value + '</p>',
                        // confirmButtonText: 'Close',
                        // confirmButtonColor: '#d33',
                    })
                });   
            }
       })
})


function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            // $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            swal.fire("Error!", value, "error"); 
            console.log(string(value))
        });
    }

var id = $('#detailsarprasid').val();
console.log(id);
var dataUrl = "{{ route('sarprastersedia.editDetailSarpras', ':id') }}";
dataUrl = dataUrl.replace(':id', id);
var detailPaguSarprasTable = $('#detail-pagu-sarpras-table').DataTable({
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

                        $('#jenispagu option[value=""]');
                        // $('#jenispagu').val('');
                        $('#nilaipagu').val('');
                        $('#nokontrak').val('');
                        $('#nilaikontrak').val('');
                        $('#perusahaanid option[value=""]').prop('selected', false);
                        $('#tgldari').val('');
                        $('#tglsampai').val('');
                    }
                },
                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable mb-3',
                    action: () => {
                        if (detailPaguSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        let jenispagu = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['jenispagu'];
                        let nilaipagu = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['nilaipagu'];
                        let nokontrak = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['nokontrak'];
                        let nilaikontrak = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['nilaikontrak'];
                        let perusahaanid = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['perusahaanid'];
                        let tgldari = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['tgldari'];
                        let tglsampai = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['tglsampai'];
                        $('#modal-edit').modal('show');
                        $('#jenispagu-edit option[value="'+jenispagu+'"]').prop('selected', true).trigger('change');
                        $('#nilaipagu-edit').val(nilaipagu);
                        $('#nokontrak-edit').val(nokontrak);
                        $('#nilaikontrak-edit').val(nilaikontrak);
                        $('#perusahaanid-edit option[value="'+perusahaanid+'"]').prop('selected', true).trigger('change');
                        $('#tgldari-edit').val(tgldari);
                        $('#tglsampai-edit').val(tglsampai);
                    }
                },  
                {
                    text: 'Hapus',
                    className: 'edit btn btn-danger btn-sm btn-datatable mb-3',
                    action: () => {
                        if (detailPaguSarprasTable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        let id = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['detailpagusarprasid'];
                        let url = "{{ route('sarprastersedia.destroyDetailPagu', ':id') }}"
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
                            if(result.isConfirmed){
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
                                            detailPaguSarprasTable.draw();
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
                    text: 'Download File',
                    className: 'btn btn-success btn-sm mb-3 btn-datatable',
                    action: () => {
                   if (detailPaguSarprasTable.rows( { selected: true } ).count() <= 0) {
                       swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
                       return;
                   }
                   let id = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['detailpagusarprasid'];
                   let namaFile = detailPaguSarprasTable.rows( { selected: true } ).data()[0]['file'];
                   let url = "{{ route('sarprastersedia.downloadFileDetailPagu', ':id') }}"
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
                   });
                    }
                }
            ]
            },
            columns: [
                {'orderData': 1, data: 'jenispagu', name: 'jenispagu',
                    render: function(data, type, row) {
                        if(row.jenispagu != null){
                            // if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PERENCANAAN }}") {
                            //     return 'Konsultan Perencanaan'
                            // } else if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PENGAWAS }}") {
                            //     return 'Konsultan Pengawasan'
                            // }
                            // else if (row.jenispagu == "{{ enum::JENIS_PAGU_BANGUNAN }}") {
                            //     return 'Bangunan'
                            // }
                            // else {
                            //     return 'Pengadaan'
                            // }

                            // var listMinggu = @json(enum::listMinggu($id));
                            let listJenisPagu = JSON.parse('{!! json_encode(enum::listJenisPagu($id)) !!}');
                            let jenisPaguDesc;
                            listJenisPagu.forEach((value, index) => {
                                if(row.jenispagu == index + 1) {
                                    jenisPaguDesc = value;
                                }
                            });
                            return jenisPaguDesc;
                        }
                    }
                },
                {'orderData': 2, data: 'nilaipagu', name: 'nilaipagu',
                    render: (data, type, row) => {
                        if(row.nilaipagu != null) {
                            return row.nilaipagu;
                        }else{
                            return '---';
                        }
                    }
                },
                {'orderData': 3, data: 'nokontrak', name: 'nokontrak',
                    render: function(data, type, row) {
                        if(row.nokontrak != null) {
                            return row.nokontrak
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 4, data: 'nilaikontrak', name: 'nilaikontrak',
                    render: function(data, type, row) {
                        if(row.nilaikontrak != null) {
                            return row.nilaikontrak
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 5, data: 'perusahaanid', name: 'nama',
                    render: function(data, type, row) {
                        if(row.perusahaanid != null) {
                            return row.nama
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 6, data: 'tgldari', name: 'tgldari', 
                    render: function(data, type, row) {
                        if(row.tgldari != null) {
                            return row.tgldari
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 7, data: 'tglsampai', name: 'tglsampai',
                    render: function(data, type, row) {
                        if(row.tglsampai != null) {
                            return row.tglsampai
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 8, data: 'file', name: 'file', 
                    render: function(data, type, row) {
                        if(row.file != null) {
                            return row.file;
                        }else{
                            return '---';
                        }
                    }
                },
                {'orderData': 9, data: 'file', name: 'preview', 
                    render: function (data, type, row){
                        if(row.file != null){
                            return "<div class=\"d-flex justify-content-center align-items-center\"><iframe src=\"/storage/uploaded/sarprastersedia/detailsarpras/"+row.file+"\" height=\"300\" /></div>";
                        }else{
                            return '---'
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

const validExtensions = ['pdf', 'jpeg', 'jpg', 'png', 'gif', 'webp'];

$('form').on('change', '.file-input', function() {
  const $input = $(this);
  const imgPath = $input.val();
  const $imgPreview = $input.closest('form').find('.param_img_holder');
  const extension = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

  if (typeof(FileReader) == 'undefined') {
    $imgPreview.html('This browser does not support FileReader');
    return;
  }

  if (validExtensions.includes(extension)) {
    $imgPreview.empty();
    var reader = new FileReader();
    reader.onload = function(e) {
      $('<iframe/>', {
        src: e.target.result,
        height: 250,
        width: 250,
      }).appendTo($imgPreview);
    }
    $imgPreview.show();
    reader.readAsDataURL($input[0].files[0]);
  } else {
    $imgPreview.empty();
        swal.fire('Peringatan!', 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: PDF, JPEG, JPG, PNG.', 'warning');

        // remove file ketika validasi ekstensi file gagal
        if(this.value){
            try{
                this.value = ''; //for IE11, latest Chrome/Firefox/Opera...
            }catch(err){ }
            if(this.value){ //for IE5 ~ IE10
                var form = document.createElement('form'),
                    parentNode = this.parentNode, ref = this.nextSibling;
                form.appendChild(this);
                form.reset();
                parentNode.insertBefore(this,ref);
            }
        }
  }
});

// $(document).ready(function() {
//   if (window.File && window.FileList && window.FileReader) {
//     $(".files").on("change", function(e) {
//     	var clickedButton = this;
//       var files = e.target.files,
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
