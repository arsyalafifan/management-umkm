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

            <form method="POST" action="{{ route('sarprastersedia.storeDetailSarpras') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sarprastersediaid" id="sarprastersediaid" value="{{ old('sarprastersediaid', $sarprastersedia->sarprastersediaid) }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thperolehan" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Perolehan *') }}</label>
        
                            <div class="col-md-12">
                                <select id="thperolehan" class="custom-select form-control @error('thperolehan') is-invalid @enderror" name='thperolehan' required>
                                    <option value="">-- Pilih Tahun Perolehan --</option>
                                    @foreach (enum::listTahun() as $id)
                                    <option {{ old('thperolehan') != '' && old('thperolehan') == $id ? 'selected' : '' }} value="{{$id}}">{{ enum::listTahun('desc')[$loop->index]}}</option>
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
                                        <option {{ old('koderekening') != '' || old('koderekening') != null ? 'selected' : '' }} value="{{ old('koderekening') ?? $item->jenid }}">{{ $item->jenkode . ' ' . $item->jennama }}</option>
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
                                <select id="subkegid" class="custom-select form-control @error('subkegid') is-invalid @enderror" name='subkegid' required>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                    @foreach ($subkegiatan as $item)
                                    <option {{ old('subkegid') != '' && old('subkegid') == $item->subkegid ? 'selected' : '' }} value="{{$item->subkegid}}">{{ $item->progkode .  $item->kegkode .  $item->subkegkode . ' ' . $item->subkegnama}}</option>
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
                                        <option {{ old('sumberdana') != '' || old('sumberdana') != null ? 'selected' : '' }} value="{{ old('sumberdana') ?? $id }}">{{ enum::listSumberDana('desc')[$loop->index] }}</option>
                                    @endforeach
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
                                <input id="subdetailkeg" required type="text" class="form-control @error('subdetailkeg') is-invalid @enderror" name="subdetailkeg" value="{{ (old('subdetailkeg')) }}" maxlength="255">
        
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

                <table id="demo-foo-addrow-sarprastersedia" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead style="background-color: #d8d8d868;">
                        <tr>
                            <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Jenis Pagu</th>
                            <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Pagu</th>
                            <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">No Kontrak</th>
                            <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Nilai Kontrak</th>
                            <th class="text-center" rowspan="2" data-sort-initial="true" data-toggle="true">Perusahaan</th>
                            <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                            <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Upload File</th>
                            <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Preview</th>
                            <th class="text-center" rowspan="2" data-sort-ignore="true" data-toggle="true">Hapus</th>
                        </tr>
                        <tr>
                            <th class="text-center" data-sort-initial="true" data-toggle="true">Dari</th>
                            <th class="text-center" data-sort-initial="true" data-toggle="true">Sampai</th>
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
                        <tr class="tr-length">
                            <td class="border-0">
                                <div class="form-group">
                                    <select id="jenispagu" class="form-control custom-select-detail @error('jenispagu') is-invalid @enderror" name='jenispagu[]' required>
                                        <option value="">-- Pilih Jenis Pagu --</option>
                                        @foreach (enum::listJenisPagu() as $id)
                                        <option {{ old('jenispagu') != '' || old('jenispagu') != null ? 'selected' : '' }} value="{{ old('jenispagu') ?? $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="border-0" style="width: 200px">
                                <div class="input-group">
                                    <span class="p-2">Rp </span>
                                    <input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}">
                                </div>
                            </td>
                            <td class="border-0">
                                    <input id="nokontrak" type="text" class="form-control @error('nokontrak') is-invalid @enderror" name="nokontrak[]" value="{{ (old('nokontrak')) }}" maxlength="100">
                            </td>
                            <td class="border-0" style="width: 200px">
                                <div class="input-group">
                                    <span class="p-2">Rp </span>
                                    <input id="nilaikontrak" type="text" class="form-control nilaikontrak @error('nilaikontrak') is-invalid @enderror" name="nilaikontrak[]" value="{{ (old('nilaikontrak')) }}">
                                </div>
                            </td>
                            <td class="border-0">
                                <div class="perusahaanid-container">
                                    <select id="perusahaanid" class="form-control select-custom @error('perusahaanid') is-invalid @enderror" name="perusahaanid[0]" required>
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach ($perusahaan as $item)
                                        <option {{ old('perusahaanid') != '' || old('perusahaanid') != null ? 'selected' : '' }} value="{{ old('perusahaanid') ?? $item->perusahaanid }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="border-0">
                                <input type="date" class="form-control tgldari @error('tgldari') is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old('tgldari') }}" required onchange="return compareDates()">
                            </td>
                            <td class="border-0">
                                <input type="date" class="form-control tglsampai @error('tglsampai') is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old('tglsampai') }}" required onchange="return compareDates()">
                            </td>
                            <td class="border-0">
                                <input type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
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
                            <td colspan="10">
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
                        <a href="{{ route('sarprastersedia.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Tersedia') }}
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

<script>
    function compareDates() {
        var startDate = Date.parse($('#tgldari').val());
        var dueDate = Date.parse($('#tglsampai').val());
        var today = new Date();
        var todayYMD = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
        if (!isNaN(startDate) && (startDate > today.getTime())) {
            // alert("The first date is after the second date!");
            swal.fire('Error!', `Tanggal tidak boleh melebihi tanggal ${todayYMD}`, 'error');
            $('#tgldari').val('');
        }
        if (!isNaN(dueDate) && (dueDate > today.getTime())) {
            swal.fire('Error!', `Tanggal tidak boleh melebihi tanggal ${todayYMD}`, 'error');
            $('#tglsampai').val('');
        }

        if (!isNaN(startDate) > !isNaN(dueDate)) {
            swal.fire('Error!', `Tanggal dari tidak boleh melebihi tanggal ${dueDate}`, 'error');
            $('#tglsampai').val('');
        }
    }

    // function compareTwoDates() {
    //     var startDate = Date.parse($('#tgldari').val());
    //     var dueDate = Date.parse($('#tglsampai').val());
    // }
</script>

<script>

    $('table').on("focus", ".nilaipagu", function(){
        $( '.nilaipagu' ).mask('000,000,000,000,000', {reverse: true});
        // $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    })
    $('table').on("focus", ".nilaikontrak", function(){
        $( '.nilaikontrak' ).mask('000,000,000,000,000', {reverse: true});
        // $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    })

const validExtensions = ['pdf', 'jpeg', 'jpg', 'png', 'gif', 'webp'];

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
      $('<iframe/>', {
        src: e.target.result,
        height: 300,
        width: 300,
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

$('table').on('focus', '.perusahaanid', function() {

    $('.custom-select-detail').select2();

//   const $input = $(this);
//   const imgPath = $input.val();
//   const $imgPreview = $input.closest('tr').find('.param_img_holder');
//   const extension = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

//   if (typeof(FileReader) == 'undefined') {
//     $imgPreview.html('This browser does not support FileReader');
//     return;
//   }

//   if (validExtensions.includes(extension)) {
//     $imgPreview.empty();
//     var reader = new FileReader();
//     reader.onload = function(e) {
//       $('<iframe/>', {
//         src: e.target.result,
//         height: 300,
//         width: 300,
//       }).appendTo($imgPreview);
//     }
//     $imgPreview.show();
//     reader.readAsDataURL($input[0].files[0]);
//   } else {
//     $imgPreview.empty();
//     swal.fire('Peringatan!', 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: PDF, JPEG, JPG, PNG.', 'warning');

//         // remove file ketika validasi ekstensi file gagal
//         if(this.value){
//             try{
//                 this.value = ''; //for IE11, latest Chrome/Firefox/Opera...
//             }catch(err){ }
//             if(this.value){ //for IE5 ~ IE10
//                 var form = document.createElement('form'),
//                     parentNode = this.parentNode, ref = this.nextSibling;
//                 form.appendChild(this);
//                 form.reset();
//                 parentNode.insertBefore(this,ref);
//             }
//         }
//   }
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
        $("#demo-foo-addrow-sarprastersedia > tbody").empty();
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

            // var index = $('.tr-length').length;
            // $('.tr-length:first').find("select").select2("destroy");
            // var $select2 = $('.tr-length:first').clone();
            // $service.find('select[name*=service]')
            // .val('')
            // .attr('name', 'items[' + index + '][service]')
            // .attr('id', 'service-' + index);



            //get the footable object
            var footable = addrow.data('footable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td class="border-0"><select id="jenispagu" class="custom-select-detail form-control jenispagu @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}"></div></td><td class="border-0"><input id="nokontrak" type="text" class="form-control @error("nokontrak") is-invalid @enderror" name="nokontrak[]" value="{{ (old("nokontrak")) }}" maxlength="100"></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaikontrak" type="text" class="form-control nilaikontrak @error("nilaikontrak") is-invalid @enderror" name="nilaikontrak[]" value="{{ (old("nilaikontrak")) }}"></div></td><td class="border-0"><div class="more-perusahaanid-container"><select id="perusahaanid" class="custom-select-detail form-control perusahaanid @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]"><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></div></td><td class="border-0"><input type="date" class="form-control tgldari @error("tgldari") is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old("tgldari") }}" required onchange="compareDates()"></td><td class="border-0"><input type="date" class="form-control tglsampai @error("tglsampai") is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old("tglsampai") }}" onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]"/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


            // var index = $('.perusahaanid-container').length;
            // $('.perusahaanid-container:first').find("select").select2("destroy");
            // var $perusahaanid = $('.perusahaanid-container:first').clone();

            // $perusahaanid.find('select[name*=perusahaanid]')
            // .val('')
            // .attr('name', 'perusahaanid['+index+']')
            // .attr('id', 'perusahaanid-' + index);

            // $perusahaanid.appendTo('.more-perusahaanid-container');

            // $('.perusahaanid-container').find("select").select2();

            // var newRow = '<tr><td class="border-0"><select id="jenispagu" class="form-control @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0"><input id="nilaipagu" type="number" class="form-control @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}" maxlength="100" required></td><td class="border-0"><select id="perusahaanid" class="form-control @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]" required><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></td><td class="border-0"><input type="date" class="form-control @error("tglpelaksanaan") is-invalid @enderror" id="tglpelaksanaan" name="tglpelaksanaan[]" value="{{ old("tglpelaksanaan") }}" required onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" required /><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center"></div></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

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
