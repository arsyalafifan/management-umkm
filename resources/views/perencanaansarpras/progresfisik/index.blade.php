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

    /* #detail-laporan-table {
        display: none;
    } */
    .btn-view-pengajuan:hover{
        background-color: rgb(24, 106, 154);
    }
    .modal {
        overflow-y:auto;
    }
</style>
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">DAFTAR PROGRES FISIK</h5>
        <hr />
        <form class="form-material">
            <div class="form-group row">
                <div class="col-md-6 ">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="perusahaanid" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan') }}</label>
                        </div>
                        <div class="col-md-9">
                            <select id="perusahaanid" class="col-md-12 custom-select form-control" name='perusahaanid' autofocus>
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach ($perusahaan as $item)
                                    <option value="{{$item->perusahaanid}}">{{ $item->nama }}</option>
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

                @if (session()->has('success'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- <h3 class="card-title text-uppercase">PENGANGGARAN</h3> --}}
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="kebutuhan-sarpras-table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Perusahaan</th>
                                <th>Sub Kegiatan</th>
                                <th>Sub Detail Kegiatan</th>
                                <th>No Kontrak</th>
                                <th>Nilai Kontrak</th>
                                <th>Progres</th>
                                <th>Selesai</th>
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
<div class="card p-4 mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <h3 class="card-title text-uppercase">DETAIL LAPORAN</h3>
                    <hr>
                    <table class="table table-bordered yajra-datatable table-striped" id="detail-laporan-table">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Minggu</th>
                                <th class="text-center" colspan="2">Waktu Pengerjaan</th>
                                <th class="text-center" rowspan="2">Progres</th>
                                <th class="text-center" rowspan="2">Keterangan</th>
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
            </div>
        </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal" id="modal-detail-laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document" style="max-width: 720px;">
        <div class="modal-content p-3">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="modal-title-detail-laporan"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form method="POST" id="detailLaporan-form" name="detailLaporan-form" class="form-horizontal form-material needs-validation" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/> --}}
                    <input type="hidden" id="detailpaguanggaranid" name="detailpaguanggaranid">
                    <input type="hidden" name="detail_mode" id="detail_mode"/>
                    <div class="form-group">
                        <label for="minggu" class="control-label">Minggu:</label>
                        <select id="detail_minggu" class="custom-select-edit-detail form-control" name='minggu'>
                            <option value="">-- Pilih Minggu --</option>
                            {{-- @foreach (enum::listJenisPagu() as $id)
                            <option value="{{ $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="daritgl" class="control-label">Dari Tanggal:</label>
                        <input id="detail_daritgl" type="date" class="form-control @error('daritgl') is-invalid @enderror" name="daritgl" value="{{ (old('daritgl')) }}" maxlength="100" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="sampaitgl" class="control-label">Sampai Tanggal:</label>
                        <input id="detail_sampaitgl" type="date" class="form-control @error('sampaitgl') is-invalid @enderror" name="sampaitgl" value="{{ (old('sampaitgl')) }}" maxlength="100" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="progres" class="control-label">Progres (%):</label>
                        <input id="detail_progres" type="number" class="form-control @error('progres') is-invalid @enderror" name="progres" value="{{ (old('progres')) }}" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="progres" class="control-label">Keterangan:</label>
                        <textarea class="form-control @error('progres') is-invalid @enderror" name="keterangan" id="detail_keterangan" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button value="btnSubmit" type="submit" id="btnSubmit" class="btn btn-primary btnSubmit"><i class="icon wb-plus" aria-hidden="true"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>

<script>
    
</script>

<!-- validasi jumlah yang disetujui -->
<script>

    // $('table').on("focus", ".nilaipagu", function(){
    //     $( '.nilaipagu' ).mask('000,000,000,000,000', {reverse: true});
    //     // $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    // })
    // $('table').on("blur", ".nilaipagu", function(){
    //     $('.nilaipagu').val(+Number($('.nilaipagu').val().replace(/[^0-9.-]+/g,"")))
    // })

    // $('table').on('blur', 'nilaipagu', function() {
    //     const value = this.value.replace(/,/g, '');
    //     this.value = parseFloat(value).toLocaleString('en-US', {
    //         style: 'decimal',
    //         maximumFractionDigits: 2,
    //         minimumFractionDigits: 2
    //     });
    // });
    function changeHandler(val)
    {
        if (Number(val.value) > 100)
        {
        val.value = 100
        }
    }

    function compareJumlah() {
        var jumlahSetuju = $('#jumlahsetuju').val();
        var jumlah = $('#jumlah').val();
        if (!isNaN(jumlahSetuju) && jumlahSetuju > jumlah) {
            // alert("The first date is after the second date!");
            swal.fire('Peringatan!', `Jumlah yang disetujui tidak boleh melebihi dari jumlah yang diajukan (${jumlah})`, 'warning');
            $('#jumlahsetuju').val('');
        }
    }

    $(document).on("change", ".count-pagu", function() {
        var sum = 0;
        $(".count-pagu").each(function(){
            sum += +Number($(this).val().replace(/[^0-9.-]+/g,""));
        });
        console.log(sum)
        $(".total").val(sum);
        $(".total").text(rupiah(sum));
        $(".rupiahTerbilang").text(`(${terbilang(sum)})`);
    });
    $(document).on("click", ".delete-row-btn", function() {
        var sum = 0;
        $(".count-pagu").each(function(){
            sum += +Number($(this).val().replace(/[^0-9.-]+/g,""));
        });
        $(".total").val(sum);
        $(".total").text(rupiah(sum));
        $(".rupiahTerbilang").text(`(${terbilang(sum)})`);
    });
</script>
<script>

    $(document).ready(function () {

        $('.custom-select-detail').select2({
            dropdownParent: $('#modal-detailanggaran')
        });

        $('.custom-select-edit').select2({
            dropdownParent: $('#modal-detail-pagu-penganggaran')
        });
        $('.custom-select-edit-detail').select2({
            dropdownParent: $('#modal-detail-laporan .modal-content')
        });

        $('.custom-select').select2();

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

        // FILTER SEKOLAH - START
        $('#kotaid').select2().on('select2:select', function() {

            var urlSekolahKota = "{{ route('helper.getsekolahkota', ':id') }}";
            urlSekolahKota = urlSekolahKota.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: urlSekolahKota,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                }
            })

            var url = "{{ route('helper.getkecamatan', ':id') }}";
            url = url.replace(':id', ($('#kotaid').val() == "" || $('#kotaid').val() == null ? "-1" : $('#kotaid').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#kecamatanid').empty();
                    $('#kecamatanid').append($("<option></option>").attr("value", "").text("-- Pilih Kecamatan --"));
                    $.each(data.data, function(key, value) {
                        $('#kecamatanid').append($("<option></option>").attr("value", value.kecamatanid).text(value.kodekec + ' - ' + value.namakec));
                    });
                    $('#kecamatanid').select2();
                    // $('#kecamatanid').val(kecamatanid);
                    $('#kecamatanid').trigger('change');
                }
            })

            if($('#kecamatanid').val() == '' && $('#jenjang').val() != '' && $('#jenis').val() != '') {
                var urlSekolahKotaJenjangJenis = "{{ route('helper.getSekolahKotaJenjangJenis', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang', 'jenis' => ':jenis']) }}";
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':kotaid', $('#kotaid').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenjang', $('#jenjang').val() == "" );
                urlSekolahKotaJenjangJenis = urlSekolahKotaJenjangJenis.replace(':jenis', $('#jenis').val() == "" );

                $.ajax({
                    url: urlSekolahKotaJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.npsn + ' - ' + value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                    }
                })
            }
        });

        $('#kecamatanid').select2().on('select2:select', function() {
            var jenis = $('#jenis').val();
            var jenjang = $('#jenjang').val();
            url = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
            url = url.replace(':jenis', ($('#jenis').val() == "" || $('#jenis').val() == null ? "-1" : $('#jenis').val()));
            url = url.replace(':jenjang', ($('#jenjang').val() == "" || $('#jenjang').val() == null ? "-1" : $('#jenjang').val()));
            url = url.replace(':kecamatanid', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()))
            // var url = "{{ route('helper.getkecamatan', ':id') }}";
            // url = url.replace(':id', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null ? "-1" : $('#kecamatanid').val()));

            var urlSekolah = "{{ route('helper.getsekolah', ':id') }}";
            urlSekolah = urlSekolah.replace(':id', $('#kecamatanid').val())

            $.ajax({
                url: urlSekolah,
                type: "GET",
                success: function(data) {
                    $('#sekolahid').empty();
                    $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                    $.each(data.data, function(key, value) {
                        $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                    });
                    $('#sekolahid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#sekolahid').trigger('change');
                    $('#detail-sarpras-table').hide();
                    $('#detail-jumlah-sarpras-table').hide();

                }
            })

            if($('#kecamatanid').val() != '' && $('#jenjang').val() != '' && $('#jenis').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenjang').select2().on('select2:select', function() {
            if($('#kecamatanid').val() != '' && $('#kotaid').val() != '') {
                var urlSekolah = "{{ route('helper.getsekolahjenjang', ['kecamatanid' => ':kecamatanid', 'jenjang' => ':jenjang']) }}";
                urlSekolah = urlSekolah.replace(':kecamatanid', $('#kecamatanid').val());
                urlSekolah = urlSekolah.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolah,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() != '' && $('#kecamatanid').val() == '') {
                var urlSekolahKotaJenjang = "{{ route('helper.getSekolahKotaJenjang1', ['kotaid' => ':kotaid', 'jenjang' => ':jenjang']) }}";
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':kotaid', $('#kotaid').val());
                urlSekolahKotaJenjang = urlSekolahKotaJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahKotaJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kotaid').val() == '' && $('#kecamatanid').val() == '') {
                var urlSekolahJenjang = "{{ route('helper.getsekolahjenjang2', ['jenjang' => ':jenjang']) }}";
                urlSekolahJenjang = urlSekolahJenjang.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenjang,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });

        $('#jenis').select2().on('select2:select', function(){
            if($('#kecamatanid').val() != '' && $('#jenjang').val() != ''){
                var urlSekolahJenjangJenis = "{{ route('helper.getsekolahjenis', ['jenis' => ':jenis', 'jenjang' => ':jenjang', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenis', $('#jenis').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':jenjang', $('#jenjang').val());
                urlSekolahJenjangJenis = urlSekolahJenjangJenis.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenjangJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() != '' && $('#jenjang').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjeniskecamatan', ['jenis' => ':jenis', 'kecamatanid' => ':kecamatanid']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':kecamatanid', $('#kecamatanid').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '') {
                var urlSekolahJenisKec = "{{ route('helper.getsekolahjenisjenjang', ['jenis' => ':jenis', 'jenjang' => ':jenjang']) }}";
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenis', $('#jenis').val());
                urlSekolahJenisKec = urlSekolahJenisKec.replace(':jenjang', $('#jenjang').val());

                $.ajax({
                    url: urlSekolahJenisKec,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
            if($('#kecamatanid').val() == '' && $('#kotaid').val() == '' && $('#jenjang').val() == ''){
                var urlSekolahJenis = "{{ route('helper.getsekolahjenis2', ':jenis') }}";
                urlSekolahJenis = urlSekolahJenis.replace(':jenis', $('#jenis').val());

                $.ajax({
                    url: urlSekolahJenis,
                    type: "GET",
                    success: function(data) {
                        $('#sekolahid').empty();
                        $('#sekolahid').append($("<option></option>").attr("value", "").text("-- Pilih Sekolah --"));
                        $.each(data.data, function(key, value) {
                            $('#sekolahid').append($("<option></option>").attr("value", value.sekolahid).text(value.namasekolah));
                        });
                        $('#sekolahid').select2();
                        // $('#sekolahid').val(sekolahid);
                        $('#sekolahid').trigger('change');
                        $('#detail-sarpras-table').hide();
                        $('#detail-jumlah-sarpras-table').hide();

                    }
                })
            }
        });
        // FILTER SEKOLAH - END


        $('#kotaid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-laporan-table').hide();
        });
        $('#kecamatanid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-laporan-table').hide();
        });
        $('#jenjang').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-laporan-table').hide();
        });
        $('#jenis').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-laporan-table').hide();
        });
        $('#sekolahid').change(function () {
            kebutuhansarprastable.draw();
            $('#detail-laporan-table').hide();
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
                 $('#detail-laporan-table').hide();
            }
        });
    });

    function setenabledtbutton(option) {
        detailPaguPenganggaranTable.buttons( '.view' ).disable();
        //detailPaguPenganggaranTable.buttons( '.print' ).disable();
        detailPaguPenganggaranTable.buttons( '.add' ).disable();
        detailPaguPenganggaranTable.buttons( '.edit' ).disable();
        detailPaguPenganggaranTable.buttons( '.delete' ).disable();

        if (option == "0") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
            detailPaguPenganggaranTable.buttons( '.add' ).enable();
            detailPaguPenganggaranTable.buttons( '.edit' ).enable();
            detailPaguPenganggaranTable.buttons( '.delete' ).enable();
        }
        else if (option == "1") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
            detailPaguPenganggaranTable.buttons( '.print' ).enable();
        }
        else if (option == "3" || option == "5" || option == "2" || option == "4" || option == "6") {
            detailPaguPenganggaranTable.buttons( '.view' ).enable();
        }
    }

        var detailaporantable;
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
                url: "{{ route('progresfisik.index') }}",
                dataSrc: function (response) {
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function (d) {
                    return $.extend({}, d, {
                        "perusahaanid": $("#perusahaanid").val().toLowerCase(),
                        "search": $("#search").val().toLowerCase()
                    });
                }
            },
            buttons: {
                buttons: [
                    //sementara dinonaktifkan untuk btn setuju
                    {
                        attr: {id: 'btn-prosestender'},
                        text: '<i class="fa fa-check-square" aria-hidden="true"></i> Proses Tender',
                        className: 'edit btn btn-success btn-datatable mb-2',
                        action: function () {
                            if (kebutuhansarprastable.rows({
                                    selected: true
                                }).count() <= 0) {
                                swal.fire("Data belum dipilih",
                                    "Silahkan pilih data terlebih dahulu", "error");
                                return;
                            }

                            let status = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'];
                            let statusDesc = kebutuhansarprastable.rows( { selected: true } ).data()[0]['status'] == 5 ? 'Proses Tender' : '';

                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                            console.log(sarpraskebutuhanid)
                            let nopengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['nopengajuan'];
                            let tglpengajuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['tglpengajuan'];

                            let url = "{{ route('penganggaran.prosestender', ':id') }}"
                            url = url.replace(':id', sarpraskebutuhanid);

                            if(status == 5){
                                swal.fire("Tidak dapat melakukan proses tender",
                                    `Data yang anda pilih sudah berstatus ${status == 5 ? statusDesc : ''}`, "error");
                                return;
                            }else {
                                swal.fire({   
                                title: "Konfirmasi",   
                                text: `Apakah anda yakin melakukan proses tender pengajuan kebutuhan sarpras dengan nomor pengajuan ${nopengajuan}?`,   
                                icon: "warning",   
                                showCancelButton: true,   
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
                                        success: function(json){
                                            var success = json.success;
                                            var message = json.message;
                                            var data = json.data;
                                            console.log(data);
                                            
                                            if (success == 'true' || success == true) {
                                                swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                                // detailaporantable.draw();
                                                var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                                                var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                                                kebutuhansarprastable.draw();
                                            }
                                            else {
                                                swal.fire("Error!", data, "error"); 
                                            }
                                        }
                                    });  
                                }           
                            });
                            }

                        }
                    },
                ]
            },
            columns: [
                {
                    'orderData': 1,
                    data: 'jenispagu',
                    render: function (data, type, row) {
                        if (row.jenispagu != null) {
                            if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PERENCANAAN }}") {
                                return 'Konsultan Perencanaan'
                            } else if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PENGAWAS }}") {
                                return 'Konsultan Pengawasan'
                            }
                            else if (row.jenispagu == "{{ enum::JENIS_PAGU_BANGUNAN }}") {
                                return 'Bangunan'
                            }
                            else {
                                return 'Pengadaan'
                            }
                        }
                    },
                    name: 'jenispagu'
                },
                {
                    'orderData': 2,
                    data: 'nama',
                    render: function(data, type, row){
                        return (row.nama);
                    },
                    name: 'nama'
                },
                {
                    'orderData': 3,
                    data: 'subkegnama',
                    render: function (data, type, row) {
                        return row.subkegnama;
                    },
                    name: 'subkegnama'
                },
                {'orderData': 4, data: 'subdetailkegiatan',
                    render: function ( data, type, row ) {
                        return row.subdetailkegiatan;
                    }, 
                    name: 'subdetailkegiatan'
                },
                {
                    'orderData': 6,
                    data: 'nokontrak',
                    render: function (data, type, row) {
                        return (row.nokontrak);
                    },
                    name: 'nokontrak',
                },
                {
                    'orderData': 7,
                    data: 'nilaikontrak',
                    render: function (data, type, row) {
                        if(row.nilaikontrak != null) { 
                            return rupiah(row.nilaikontrak);
                        }
                    },
                    name: 'nilaikontrak',
                },
                {
                    'orderData': 8,
                    data: 'progres',
                    render: function (data, type, row) {
                        if(row.progres != null) { 
                            return `${row.progres} %`;
                        }
                    },
                    name: 'progres',
                },
                {
                    'orderData': 9,
                    data: 'isselesai',
                    render: function (data, type, row) {
                        if(row.isselesai != null || row.selesai == true) { 
                            return '<span class="badge badge-pill badge-success">V</span>';
                        }else {
                            return '<span class="badge badge-pill badge-danger">X</span>';
                        }
                    },
                    name: 'isselesai',
                },
                // {'orderData': 7, data: 'status', 
                //     render: function(data, type, row){
                //         if(row.status != null){
                //             if(row.status == 1){
                //                 return '<span class="badge bg-secondary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT }}</span>';
                //             }else if(row.status == 2){
                //                 return '<span class="badge bg-info">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN }}</span>';
                //             }else if (row.status == 3){
                //                 return '<span class="badge bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI }}</span>';
                //             }else if (row.status == 5){
                //                 return '<span class="badge bg-primary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PROSES_TENDER }}</span>';
                //             }else{
                //                 return '<span class="badge bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
                //             }
                //         }else{
                //             return '-'
                //         }
                //     },
                //     name: 'status',
                // },
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

    function showDetailPaguPenganggaran(detailpenganggaranid) {
            // var rowData = detailaporantable.rows({ selected: true }).data()[0]; // Get selected row data
            // var detailpenganggaranid = rowData.detailpenganggaranid;
            var url = "{{ route('penganggaran.showDetailPenganggaran', ':id') }}";
            url = url.replace(':id', detailpenganggaranid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailPaguPenganggaranTable.clear();

                    // let nilaiPagu = 0;
                    for (var i = 0; i < response.data.count; i++) {
                        detailPaguPenganggaranTable.row.add({
                            jenispagu: response.data.data[i].jenispagu,
                            nilaipagu: response.data.data[i].nilaipagu,
                            nokontrak: response.data.data[i].nokontrak,
                            nilaikontrak: response.data.data[i].nilaikontrak,
                            perusahaanid: response.data.data[i].perusahaanid,
                            nama: response.data.data[i].nama,
                            tgldari: response.data.data[i].tgldari,
                            tglsampai: response.data.data[i].tglsampai,
                            file: response.data.data[i].file,
                            detailpaguanggaranid: response.data.data[i].detailpaguanggaranid,
                        });
                        
                        let loop = response.data.data[i].nilaipagu;
                        
                        nilaiPagu =+ +loop;
                    }

                    let totalPagu = response.data.sumPagu[0].countpagu;
                    let totalKontrak = response.data.sumPagu[0].countkontrak;
                    let terbilangNilaiPagu = response.data.terbilangNilaiPagu;
                    let terbilangNilaiKontrak = response.data.terbilangNilaiKontrak;
                    console.log(terbilangNilaiKontrak);

                    $(".totalpagu").text(rupiah(totalPagu));
                    $(".totalpagu").val(totalPagu);
                    $(".terbilangNilaiPagu").text(`(${terbilangNilaiPagu})`);

                    $(".totalkontrak").text(rupiah(totalKontrak));
                    $(".totalkontrak").val(totalPagu);
                    $(".terbilangNilaiKontrak").text(terbilangNilaiKontrak == '' ? '(Nol Rupiah)' : `(${terbilangNilaiKontrak})`);
                    
                    detailPaguPenganggaranTable.draw();
                    $('#detail-pagu-penganggaran-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function loadDetailLaporan(detailpaguanggaranid) {
            var url = "{{ route('progresfisik.loadDetailLaporan', ':id') }}";
            url = url.replace(':id', detailpaguanggaranid);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {

                    detailaporantable.clear();

                    for (var i = 0; i < response.data.count; i++) {
                        detailaporantable.row.add({
                            detaillaporanid: response.data.data[i].detaillaporanid,
                            minggu: response.data.data[i].minggu,
                            daritgl: response.data.data[i].daritgl,
                            sampaitgl: response.data.data[i].sampaitgl,
                            progres: response.data.data[i].progres,
                            keterangan: response.data.data[i].keterangan,
                        });
                    }

                    detailaporantable.draw();
                    $('#detail-laporan-table').show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // Listen for row selection event on kebutuhan-sarpras-table
        kebutuhansarprastable.on('select', function (e, dt, type, indexes) {
            var rowData = kebutuhansarprastable.rows(indexes).data()[0]; // Get selected row data
            var detailpaguanggaranid = rowData.detailpaguanggaranid;

            // Load history table with selected detailpaguanggaranid
            loadDetailLaporan(detailpaguanggaranid);
        });

        kebutuhansarprastable.on('deselect', function ( e, dt, type, indexes ) {
            // hide history table
            $('#detail-laporan-table').hide();
        });


        // hide histiry table
        $('#detail-laporan-table').hide();

    // Initialize history table
    var detailaporantable = $('#detail-laporan-table').DataTable({
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
        // ... your detail-laporan-table initialization options ...
        columns: [
            {
                data: 'minggu',
                name: 'minggu',
                render: function(data, type, row) {
                    if(row.minggu != null) {
                        return row.minggu;
                    }
                }
            },
            {
                data: 'daritgl',
                name: 'daritgl'
            },
            {
                data: 'sampaitgl',
                name: 'sampaitgl'
            },
            {
                data: 'progres',
                name: 'progres'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            // {'orderData': 2, data: 'status', 
            //     render: function(data, type, row){
            //         if(row.status != null){
            //             if(row.status == 1){
            //                 return '<span class="badge bg-secondary">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT }}</span>';
            //             }else if(row.status == 2){
            //                 return '<span class="badge bg-info">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN }}</span>';
            //             }else if (row.status == 3){
            //                 return '<span class="badge bg-success">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI }}</span>';
            //             }else{
            //                 return '<span class="badge bg-danger">{{ enum::STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK }}</span>';
            //             }
            //         }else{
            //             return '-'
            //         }
            //     },
            //     name: 'status',
            // },
            // {
            //     data: 'keterangan',
            //     name: 'keterangan'
            // }
        ],
        buttons: {
            buttons: [
                {
                    text: '<i class="fa fa-plus-circle aria-hidden="true"></i> Tambah',
                    className: 'edit btn btn-primary mb-3 btn-datatable',
                    action: function () {
                        if (kebutuhansarprastable.rows( {selected: true} ).count() <= 0) {
                            swal.fire("Data permintaan sarpras belum dipilih", "Silakan pilih data permintaan sarpras terlebih dahulu", "error");
                            return;
                        }
                        else{
                            var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                            var detailpaguanggaranid = rowData.detailpaguanggaranid;

                            $('#detailpaguanggaranid').val(detailpaguanggaranid);

                            $('#modal-detail-laporan').modal('show');
                            showmodaldetail('add');
                        }
                    }
                },
                {
                    text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Lihat Detail',
                    className: 'edit btn btn-info mb-3 btn-datatable',
                    action: function() {

                        if (detailaporantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silakan pilih data yang ingin dilihat", "error");
                            return;
                        }
                        else{
                            var rowData = detailaporantable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpenganggaranid = rowData.detailpenganggaranid;
                            // var detailpagupenganggaranid = rowData.detailpagupenganggaranid;

                            let subkegid = detailaporantable.rows({ selected: true }).data()[0]['subkegid']
                            let sumberdana = detailaporantable.rows({ selected: true }).data()[0]['sumberdana']
                            let subdetailkeg = detailaporantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                            let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                            let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];

                            $('#subkegid-detail').val(subkegid).trigger('change').attr('disabled', 'disabled');
                            $('#sumberdana-detail').val(sumberdana).trigger('change').attr('disabled', 'disabled');
                            $('#subdetailkeg-detail').val(subdetailkeg).attr('disabled', 'disabled');
                            $('#jumlah-detail').val(jumlah);
                            $('#satuan-detail').val(satuan);

                            $('#modal-detail-pagu-penganggaran').modal('show');
                            $('#btnSubmitParent').hide();
                            $('#title-modal-detail-penganggaran').text('LIHAT DETAIL PENGANGGARAN');

                            showDetailPaguPenganggaran(detailpenganggaranid);
                            setenabledtbutton("");
                        }
                    }
                },  
                {
                    text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                    className: 'edit btn btn-warning mb-3 btn-datatable',
                    action: function () {
                        if (detailaporantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        // var id = detailaporantable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                        var rowData = detailaporantable.rows({ selected: true }).data()[0]; // Get selected row data
                        var detailpenganggaranid = rowData.detailpenganggaranid;

                        let subkegnama = detailaporantable.rows({ selected: true }).data()[0]['subkegnama']
                        let subkegid = detailaporantable.rows({ selected: true }).data()[0]['subkegid']
                        let sumberdana = detailaporantable.rows({ selected: true }).data()[0]['sumberdana']
                        let subdetailkeg = detailaporantable.rows({ selected: true }).data()[0]['subdetailkegiatan']
                        let jumlah = kebutuhansarprastable.rows( { selected: true } ).data()[0]['jumlahsetuju'];
                        let satuan = kebutuhansarprastable.rows( { selected: true } ).data()[0]['satuansetuju'];
                        $('#modal-detail-laporan').modal('show');
                        showmodaldetail('edit');

                        $('#subkegid-detail').val(subkegid).trigger('change').removeAttr('disabled');
                        $('#sumberdana-detail').val(sumberdana).trigger('change').removeAttr('disabled');
                        $('#subdetailkeg-detail').val(subdetailkeg).removeAttr('disabled');
                        $('#jumlah-detail').val(jumlah);
                        $('#satuan-detail').val(satuan);
                        $('#detailpenganggaranid').val(detailpenganggaranid);

                        // $('#subkegid-edit option[value="'+subkegid+'"]').prop('selected', true);

                        $('#modal-detail-laporan-penganggaran').modal('show');
                        $('#btnSubmitParent').show();
                        $('#title-modal-detail-penganggaran').text('EDIT DETAIL PENGANGGARAN');
                        showDetailPaguPenganggaran(detailpenganggaranid);
                        setenabledtbutton("0");
                        console.log(detailpenganggaranid);
                    }
                }, 
                {
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                    className: 'edit btn btn-danger mb-3 btn-datatable',
                    action: function () {
                        if (detailaporantable.rows( { selected: true } ).count() <= 0) {
                            swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        var id = detailaporantable.rows( { selected: true } ).data()[0]['detailpenganggaranid'];
                        var url = "{{ route('penganggaran.destroy', ':id') }}"
                        url = url.replace(':id', id);
                        // var nama =  detailaporantable.rows( { selected: true } ).data()[0]['namasekolah'];
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
                                    type: "DELETE",
                                    cache:false,
                                    url: url,
                                    dataType: 'JSON',
                                    data: {
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(json){
                                        var success = json.success;
                                        var message = json.message;
                                        var data = json.data;
                                        console.log(data);
                                        
                                        if (success == 'true' || success == true) {
                                            swal.fire("Berhasil!", "Data anda telah dihapus.", "success"); 
                                            // detailaporantable.draw();
                                            var rowData = kebutuhansarprastable.rows( {selected: true} ).data()[0]; // Get selected row data
                                            var sarpraskebutuhanid = rowData.sarpraskebutuhanid;
                                            loadDetailLaporan(sarpraskebutuhanid);
                                        }
                                        else {
                                            swal.fire("Error!", data, "error"); 
                                        }
                                    }
                                });  
                            }           
                        });
                    }
                }
            ]
        },
    });

    // hide detail sarpras table table
    $('#detail-pagu-penganggaran-table').hide();
    var detailPaguPenganggaranTable = $('#detail-pagu-penganggaran-table').DataTable({
            responsive: true,
            processing: true,
            // serverSide: true,
            pageLength: 50,
            dom: 'Bfrtip',
            select: true,
            ordering: true,
            // searching: true,
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
                        text: '<i class="fa fa-info-circle" aria-hidden="true"></i> Tambah',
                        className: 'add btn btn-primary mb-3 btn-datatable',
                        action: function() {
                            $('#modal-detail-laporan').modal('show');
                            showmodaldetail('add');
                        }
                    }, 
                    {
                        text: '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah',
                        className: 'edit btn btn-warning mb-3 btn-datatable',
                        action: function () {
                            if (detailPaguPenganggaranTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                                return;
                            }
                            // var id = detailPaguPenganggaranTable.rows( { selected: true } ).data()[0]['detailsaprasid'];
                            var rowData = detailPaguPenganggaranTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var id = rowData.sarpraskebutuhanid;

                            $('#modal-detail-laporan').modal('show');
                            // setenabledtbutton("0");
                            showmodaldetail('edit');
                        }
                    }, 
                    {
                        text: '<i class="fa fa-trash" aria-hidden="true"></i> Hapus',
                        className: 'delete btn btn-danger mb-3 btn-datatable',
                        action: function () {
                            if (detailPaguPenganggaranTable.rows( { selected: true } ).count() <= 0) {
                                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                                return;
                            }
                            var rowData = detailPaguPenganggaranTable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpaguanggaranid = rowData.detailpaguanggaranid;
                            var url = "{{ route('penganggaran.deleteDetailPaguPenganggaran', ':id') }}"
                            url = url.replace(':id', detailpaguanggaranid);
                            // var nama =  detailPaguPenganggaranTable.rows( { selected: true } ).data()[0]['namasekolah'];

                            var rowDataAnggaran = detailaporantable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpenganggaranid = rowDataAnggaran.detailpenganggaranid;
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
                                        success: function(json){
                                            var success = json.success;
                                            var message = json.message;
                                            var data = json.data;
                                            console.log(data);
                                            
                                            if (success == 'true' || success == true) {
                                                swal.fire("Berhasil!", "Data anda telah dihapus.", "success");
                                                
                                                showDetailPaguPenganggaran(detailpenganggaranid);
                                            }
                                            else {
                                                swal.fire("Error!", data, "error"); 
                                            }
                                        }
                                    });  
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
                            if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PERENCANAAN }}") {
                                return 'Konsultan Perencanaan'
                            } else if (row.jenispagu == "{{ enum::JENIS_PAGU_KONSULTAN_PENGAWAS }}") {
                                return 'Konsultan Pengawasan'
                            }
                            else if (row.jenispagu == "{{ enum::JENIS_PAGU_BANGUNAN }}") {
                                return 'Bangunan'
                            }
                            else {
                                return 'Pengadaan'
                            }
                        }
                    }
                },
                {'orderData': 2, data: 'nilaipagu', name: 'nilaipagu',
                    render: (data, type, row) => {
                        if(row.nilaipagu != null) {
                            return rupiah(row.nilaipagu);
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
                            return rupiah(row.nilaikontrak);
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
                            return DateFormat(row.tgldari);
                        }else{
                            return '---'
                        }
                    }
                },
                {'orderData': 7, data: 'tglsampai', name: 'tglsampai',
                    render: function(data, type, row) {
                        if(row.tglsampai != null) {
                            return DateFormat(row.tglsampai);
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

    function bindformdetail() {
        $('textarea[id^="detail_"]', "#detailLaporan-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="detail_"]', "#detailLaporan-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('select[id^="detail_"]', "#detailLaporan-form").each(function(index, el){
            var inputname = el.id.substring(7, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(detailPaguPenganggaranTable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
            }
        });
    }

    function setenableddetail(value) {
        if (value) {
            $("#btnSubmit").show();
        }
        else {
            $("#btnSubmit").hide();
        }
        
        $('textarea[id^=""]', "#detailLaporan-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^=""]', "#detailLaporan-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^=""]', "#detailLaporan-form").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modedetail = "";
    function showmodaldetail(mode) {
        v_modedetail = mode;
        $("#detail_mode").val(mode);
        // resetformdetail();
        if (mode == "add") {
            $("#modal-title-detail-laporan").html('Tambah Data');
            setenableddetail(true);
            // console.log($("#detail_mode").val());
        }
        else if (mode == "edit") {
            $("#modal-title-detail-laporan").html('Ubah Data');
            bindformdetail();
            setenableddetail(true);
        }
        else {
            $("#modal-title-detail-laporan").html('Lihat Data');
            bindformdetail();
            setenableddetail(false);
        }
        
        $("#m_formshowdetail").modal('show');
    }

    function hidemodaldetail() {
        $("#m_formshowdetail").modal('hide');
    }

    // verifikasi kebutuhan sarpras 
    $(document).on('submit', '#detailLaporan-form', function(e){
            var url = '';
            // var id = detailaporantable.rows( { selected: true } ).data()[0]['detaillaporanid'];
            
            e.preventDefault();
            
            var formData = new FormData($('#detailLaporan-form')[0]);

            if($("#detail_mode").val() == "add") {
                var url = "{{ route('progresfisik.storeDetailLaporan') }}"
                // url = url.replace(':id', id);   
            }else if($("#detail_mode").val() == "edit") {
                var url = "{{ route('progresfisik.updateDetailLaporan', ':id') }}"
                // url = url.replace(':id', id); 
            }

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
                    let errors = json.errors;

                    if (success == 'true' || success == true) {
                            swal.fire("Berhasil!", "Data progres fisik berhasil ditambah.", "success");
                            var rowData = kebutuhansarprastable.rows({ selected: true }).data()[0]; // Get selected row data
                            var detailpaguanggaranid = rowData.detailpaguanggaranid;
                            loadDetailLaporan(detailpaguanggaranid);

                            $('#detailLaporan-form').trigger("reset");
                            $('#modal-detail-laporan').modal('hide'); 
                    }
                    // else{
                    //     console.log(errors)
                    // }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        console.log(data.errors);// this will be the error bag.
                        // printErrorMsg(data.errors);
                }
            })
        })

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
        // var row = $(this).parents('tr:first');
        var row = $(this).parents('tr:first');

        //delete the row
        footable.removeRow(row);
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

            //get the footable object
            var footable = addrow.data('footable');
            
            //build up the row we are wanting to add
            var newRow = '<tr><td class="border-0"><select id="jenispagu" class="custom-select-detail form-control jenispagu @error("jenispagu") is-invalid @enderror" name="jenispagu[]" required><option value="">-- Pilih Jenis Pagu --</option>@foreach (enum::listJenisPagu() as $id)<option {{ old("jenispagu") != "" || old("jenispagu") != null ? "selected" : "" }} value="{{ old("jenispagu") ?? $id }}">{{ enum::listJenisPagu("desc")[$loop->index] }}</option>@endforeach</select></td><td class="border-0" style="width: 200px"><div class="input-group"><span class="p-2">Rp </span><input id="nilaipagu" required type="text" class="form-control nilaipagu count-pagu @error("nilaipagu") is-invalid @enderror" name="nilaipagu[]" value="{{ (old("nilaipagu")) }}"></div></td><td class="border-0"><input id="nokontrak" disabled type="text" class="form-control @error("nokontrak") is-invalid @enderror" name="nokontrak[]" value="{{ (old("nokontrak")) }}" maxlength="100"></td><td class="border-0"><input id="nilaikontrak" disabled type="number" class="form-control @error("nilaikontrak") is-invalid @enderror" name="nilaikontrak[]" value="{{ (old("nilaikontrak")) }}" maxlength="100"></td><td class="border-0"><select id="perusahaanid" class="custom-select-detail form-control perusahaanid @error("perusahaanid") is-invalid @enderror" name="perusahaanid[]" disabled><option value="">-- Pilih Perusahaan --</option>@foreach ($perusahaan as $item)<option {{ old("perusahaanid") != '' || old("perusahaanid") != null ? "selected" : '' }} value="{{ old("perusahaanid") ?? $item->perusahaanid }}">{{ $item->nama }}</option>@endforeach</select></td><td class="border-0"><input disabled type="date" class="form-control @error("tgldari") is-invalid @enderror" id="tgldari" name="tgldari[]" value="{{ old("tgldari") }}" required onchange="compareDates()"></td><td class="border-0"><input type="date" class="form-control @error("tglsampai") is-invalid @enderror" id="tglsampai" name="tglsampai[]" value="{{ old("tglsampai") }}" disabled onchange="compareDates()"></td><td class="border-0"><input type="file" class="form-control file-input" name="file[]" disabled/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span></td><td class="border-0"><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="close" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

            // let imgParams = <td class="border-0"><div class="param_img_holder d-flex justify-content-center align-items-center d-none"></div></td>
            
            // var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="filesarpraskebutuhan[]" id="filesarpraskebutuhan" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


            //add it
            footable.appendRow(newRow);
    });
});
</script>

@endsection
