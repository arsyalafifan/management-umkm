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
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5><hr />
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

            <form method="POST" action="{{ route('sarpraskebutuhan.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$sekolah->sekolahid) }}">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="nopengajuan" class="col-md-12 col-form-label text-md-left">{{ __('Nomor Pengajuan *') }}</label>
        
                            <div class="col-md-12">
                                <input id="nopengajuan" type="text" class="form-control @error('nopengajuan') is-invalid @enderror" name="nopengajuan" value="{{ (old('nopengajuan')) ?? $nopengajuan }}" maxlength="100" required autocomplete="nopengajuan" autofocus>
        
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
                                <input type="date" class="form-control @error('tglpengajuan') is-invalid @enderror" id="tglpengajuan" name="tglpengajuan" value="{{ old('tglpengajuan') }}" required onchange="compareDates()">
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
                                        <option value="{{ $id }}"> {{ enum::listJenisKebutuhan('desc')[$loop->index] }}</option>
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
                                    <option {{ old('pegawaiid') != '' && old('pegawaiid') == $item->pegawaiid ? 'selected' : '' }} value="{{$item->pegawaiid}}">{{ 'NIP: ' . $item->nip . ' | NAMA: ' . $item->nama }}</option>
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
                                    <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_UTAMA ? 'selected' : '' }} value="{{ enum::SARPRAS_UTAMA }}">{{ __('Sarpras Utama') }}</option>
                                    <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PENUNJANG ? 'selected' : '' }} value="{{ enum::SARPRAS_PENUNJANG }}">{{ __('Sarpras Penunjang') }}</option>
                                    <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PERALATAN ? 'selected' : '' }} value="{{ enum::SARPRAS_PERALATAN }}">{{ __('Sarpras Peralatan') }}</option>
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
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ (old('jumlah')) }}" maxlength="100" required autocomplete="jumlah">
        
                                @error('jumlah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
        
                            <div class="col-md-12">
                                <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ (old('satuan')) }}" maxlength="100" required autocomplete="satuan">
        
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
                                    {{-- @foreach ($namasarpras as $item)
                                    <option value="{{$item->namasarprasid}}">{{ $item->namasarpras }}</option>
                                    @endforeach --}}
                                </select>
        
                                @error('namasarpras')
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
                            <label for="thang" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Anggaran *') }}</label>

                            <div class="col-md-12">
                                <select id="thang" class="custom-select form-control @error('thang') is-invalid @enderror" name='thang' required>
                                    <option value="">-- Tahun Anggaran --</option>
                                    @foreach (enum::listTahun() as $id)
                                        <option value="{{ $id }}"> {{ enum::listTahun('desc')[$loop->index] }}</option>
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

                <h4 class="card-title text-uppercase text-bold m-t-40">Upload Foto Kebutuhan Sarpras</h4><hr />

                <table id="demo-foo-addrow-sarprastersedia" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead style="background-color: #d8d8d868;">
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">Upload File</th>
                            <th data-sort-ignore="true" data-toggle="true">Preview</th>
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
                    <tbody id="tbody-sarprastersedia" style="font-weight: 300;">
                        <tr>
                            <td class="border-0">
                                <input type="file" class="form-control file-input" name="filesarpraskebutuhan[]" required /><span style="font-size: 12px" class="help-block">Format: JPG, JPEG, PNG | Max: 2MB</spanv>
                            </td>
                            <td class="border-0">
                                <div class="param_img_holder d-flex justify-content-center align-items-center">
                                </div>
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
                </table>

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
        </div>
    </div>
</div>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script>

<!-- validasi tanggal pengajuan -->
<script>
    function compareDates() {
        var startDate = Date.parse($('#tglpengajuan').val());
        var today = new Date();
        var todayYMD = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
        if (!isNaN(startDate) && startDate > today.getTime()) {
            // alert("The first date is after the second date!");
            swal.fire('Peringatan!', `Tanggal pengajuan tidak boleh melebihi tanggal ${todayYMD}`, 'warning');
            $('#tglpengajuan').val('');
        }
    }
</script>

<script>
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

$('table').on('change', '.file-input', function() {
  const $input = $(this);
  const imgPath = $input.val();
  const $imgPreview = $input.closest('tr').find('.param_img_holder');
  const extension = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

  if (typeof(FileReader) == 'undefined') {
    $imgPreview.html('This browser does not support FileReader');
    return;
  }

  if (validExtensions.includes(extension)) {
    $imgPreview.empty();
    var reader = new FileReader();
    reader.onload = function(e) {
      $('<img/>', {
        src: e.target.result,
        class: 'img-fluid',
      }).appendTo($imgPreview);
    }
    $imgPreview.show();
    reader.readAsDataURL($input[0].files[0]);
  } else {
        $imgPreview.empty();
        swal.fire('Peringatan!', 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: JPEG, JPG, PNG.', 'warning');

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
        var newRow = '<tr><td class="border-0"><input type="file" class="form-control file-input" name="filesarpraskebutuhan[]" required /><span style="font-size: 12px" class="help-block">Format: JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';
        
        // var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="filesarpraskebutuhan[]" id="filesarpraskebutuhan" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


        //add it
        footable.appendRow(newRow);

    });
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
