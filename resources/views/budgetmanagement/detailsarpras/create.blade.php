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

            <form method="POST" id="detailsarpras-form" action="{{ route('sarprastersedia.storeDetailSarpras') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" onsubmit="return handleSubmit();">
                @csrf
                <input type="hidden" name="sarprastersediaid" id="sarprastersediaid" value="{{ old('sarprastersediaid', $sarprastersedia->sarprastersediaid) }}">

                <div class="row m-b-40">
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
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'DAK' ? 'selected' : '' }} value="DAK">{{ __('DAK') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'BOS' ? 'selected' : '' }} value="BOS">{{ __('BOS') }}</option>
                                    <option {{ old('sumberdana') != '' && old('sumberdana') == 'SPP' ? 'selected' : '' }} value="SPP">{{ __('SPP') }}</option>
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

                <div class="col-lg-12">
                    <table class="table table-bordered yajra-datatable table-striped" id="aktivitashariandetail-table" width="100%">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="m_formshowdetail" role="dialog">
	<div class="modal-dialog modal-lg" style="max-width: 90%;">
	<!-- Modal content-->
	  <div class="modal-content">
	  	<div class="modal-header">
	      <h4 class="modal-title" id="d_titledetail">-</h4>
		</div>
		
		<div class="modal-body">
			<form method="POST" id="aktivitashariandetail-form" class="form-horizontal form-material" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="detail_detail_mode" id="detail_detail_mode">
                <input type="hidden" name="detail_detail_detailpagusarprasid" id="detail_detail_detailpagusarprasid">
                <input type="hidden" name="detail_pagu_data" id="detail_pagu_data" value="">
                {{-- <input type="hidden" name="detailsarprasid" value={{ $detailsarpras->detailsarprasid }} id="detailsarprasid"/> --}}
                <div class="form-group">
                    <label for="detail_detail_jenispagu" class="control-label">Jenis Pagu:</label>
                    <select id="detail_detail_jenispagu" class="custom-select-add-pagu form-control @error('detail_detail_jenispagu') is-invalid @enderror" name='detail_detail_jenispagu' required>
                        <option value="">-- Pilih Jenis Pagu --</option>
                        @foreach (enum::listJenisPagu() as $id)
                        <option value="{{ $id }}">{{ enum::listJenisPagu('desc')[$loop->index] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="detail_detail_nilaipagu" class="control-label">Nilai Pagu:</label>
                    <input id="detail_detail_nilaipagu" type="number" class="form-control @error('detail_detail_nilaipagu') is-invalid @enderror" name="detail_detail_nilaipagu" value="{{ (old('detail_detail_nilaipagu')) }}" maxlength="100" required autocomplete="name">
                </div>
                <div class="form-group">
                    <label for="detail_detail_nokontrak" class="control-label">Nomor Kontrak:</label>
                    <input id="detail_detail_nokontrak" type="text" class="form-control @error('detail_detail_nokontrak') is-invalid @enderror" name="detail_detail_nokontrak" value="{{ (old('detail_detail_nokontrak')) }}" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="detail_detail_nilaikontrak" class="control-label">Nilai Kontrak:</label>
                    <input id="detail_detail_nilaikontrak" type="number" class="form-control @error('detail_detail_nilaikontrak') is-invalid @enderror" name="detail_detail_nilaikontrak" value="{{ (old('detail_detail_nilaikontrak')) }}" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="detail_detail_perusahaanid" class="control-label">Perusahaan:</label>
                    <select id="detail_detail_perusahaanid" class="custom-select-add-pagu form-control @error('detail_detail_perusahaanid') is-invalid @enderror" name="detail_detail_perusahaanid" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($perusahaan as $item)
                        <option value="{{ $item->perusahaanid }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="detail_detail_tgldari" class="control-label">Dari Tanggal:</label>
                    <input type="date" class="form-control @error('detail_detail_tgldari') is-invalid @enderror" id="detail_detail_tgldari" name="detail_detail_tgldari" value="{{ old('detail_detail_tgldari') }}" required onchange="compareDates()">
                    @error('detail_detail_tgldari')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="detail_detail_tglsampai" class="control-label">Sampai Tanggal:</label>
                    <input type="date" class="form-control @error('detail_detail_tglsampai') is-invalid @enderror" id="detail_detail_tglsampai" name="detail_detail_tglsampai" value="{{ old('detail_detail_tglsampai') }}" required onchange="compareDates()">
                    @error('detail_detail_tglsampai')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="detail_detail_file" class="control-label">File:</label>
                    <input type="file" class="file-input fileinput fileinput-new input-group" data-provides="fileinput" name="detail_detail_file" id="detail_detail_file" required/><span style="font-size: 12px" class="help-block">Format: PDF, JPG, JPEG, PNG | Max: 2MB</span>
                    <div class="param_img_holder d-flex justify-content-center align-items-center">
                    </div>
                </div>
			</form>
		</div>
	    <div class="modal-footer">
       	 	<button type="button" class="btn btn-info btn-save" id="btn_simpan_detail">OK</button>
       	 	<button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
	    </div>
	  </div>
	</div>
</div>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script>


<script>

    var v_listDataDetail = [];
    var v_listDetailDeleted = [];

    // @php $listdetailpagu = old('detail_pagu_data'); @endphp


    // var v_listDataDetail = [
    //     {{--@foreach($listdetailpagu as $datadetailpagu)
    //     { 
    //         "indexdetailpagu" : "{{$loop->index}}",
    //         "detailpagusarprasid": "{{(isset($datadetailpagu['detailpagusarprasid']) ? $datadetailpagu['detailpagusarprasid'] : "")}}",
    //         "jenispagu": "{{$datadetailpagu['jenispagu']}}",
    //         "nilaipagu": "{{$datadetailpagu['nilaipagu']}}",
    //         "nokontrak": "{{$datadetailpagu['nokontrak']}}",
    //         "nilaikontrak": "{{$datadetailpagu['nilaikontrak']}}",
    //         "perusahaanid": "{{$datadetailpagu['perusahaanid']}}",
    //         "tgldari": "{{$datadetailpagu['tgldari']}}",
    //         "tglsampai": "{{$datadetailpagu['tglsampai']}}",
    //         "file": "{{$datadetailpagu['file']}}",
    //     },
    //     @endforeach --}}
    // ];

    

    var aktivitashariandetailtable = $('#aktivitashariandetail-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
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
        data: v_listDataDetail,
        buttons: {
            buttons: [
            {
                text: 'Lihat',
                className: 'view btn btn-primary btn-sm btn-datatable',
                action: function () {
                    if (aktivitashariandetailtable.rows( { selected: true } ).count() <= 0) {
                        swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                        return;
                    }
                    
                    showmodaldetail('view');
                }
            },
            {
                text: 'Tambah',
                className: 'add btn btn-info btn-sm btn-datatable',
                action: function () {
                    showmodaldetail('add');
                }
            },
            {
                text: 'Ubah',
                className: 'edit btn btn-warning btn-sm btn-datatable',
                action: function () {
                    if (aktivitashariandetailtable.rows( { selected: true } ).count() <= 0) {
                        swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                        return;
                    }
                    
                    showmodaldetail('edit');
                }
            },
            {
                text: 'Hapus',
                className: 'delete btn btn-danger btn-sm btn-datatable',
                action: function () {
                    if (aktivitashariandetailtable.rows( { selected: true } ).count() <= 0) {
                        swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                        return;
                    }
                    var id = aktivitashariandetailtable.rows( { selected: true } ).data()[0]['detailpagusarprasid'];
                    deleteDataDetail(id);
                }
            },
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
                            return row.perusahaanid
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
        drawCallback: function( settings ) {
            $("#aktivitashariandetail-table").wrap( "<div class='table-responsive'></div>" );
        }
    });

    function resettable() {
        var v_listDataDetail = [];
        var v_listDetailDeleted = [];
        reloadTableDetail();
    }

    $("#btn_simpan_detail").click(function(){
        simpandatadetail();
    });

    function resetformdetail() {
        $("#aktivitashariandetail-form")[0].reset();
        var v_max = 1;
        if (v_listDataDetail.length > 0) {
            var v_maxobj = v_listDataDetail.reduce((prev, current) => (prev && prev.nourut > current.nourut) ? prev : current);
            v_max = parseInt(v_maxobj.nourut)+1;
        }
        $("#detail_detail_nourut").val(v_max);
        //alert(v_listDataDetail.length);
        //alert(v_listDataDetail.length + '->' + JSON.stringify(max));

        $('span[id^="err_detail_detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            $('#'+el.id).html("");
        });

        $('select[id^="detail_detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            if (inputname != "mode") {
                $("#"+el.id).val("").trigger('change');
            }
        });
    }

    function bindformdetail() {
        $('textarea[id^="detail_detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(aktivitashariandetailtable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('input[id^="detail_detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(aktivitashariandetailtable.rows( { selected: true } ).data()[0][inputname]);
            }
        });
        
        $('select[id^="detail_detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            var inputname = el.id.substring(14, el.id.length);
            //alert(inputname);
            if (inputname != "mode") {
                $("#"+el.id).val(aktivitashariandetailtable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
            }
        });
    }

    function setenableddetail(value) {
        if (value) {
            $("#btn_simpan").show();
        }
        else {
            $("#btn_simpan").hide();
        }
        
        $('textarea[id^="detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('input[id^="detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            $("#"+el.id).prop("readonly", !value);
        });
        $('select[id^="detail_"]', "#aktivitashariandetail-form").each(function(index, el){
            $("#"+el.id).prop("disabled", !value);
        });
    }

    var v_modedetail = "";
    function showmodaldetail(mode) {
        v_modedetail = mode;
        $("#detail_detail_mode").val(mode);
        resetformdetail();
        if (mode == "add") {
            $("#d_titledetail").html('Tambah Data');
            setenableddetail(true);
        }
        else if (mode == "edit") {
            $("#d_titledetail").html('Ubah Data');
            bindformdetail();
            setenableddetail(true);
        }
        else {
            $("#d_titledetail").html('Lihat Data');
            bindformdetail();
            setenableddetail(false);
        }
        
        $("#m_formshowdetail").modal('show');
    }

    function hidemodaldetail() {
        $("#m_formshowdetail").modal('hide');
    }
    
    var v_detailTmpId = 0;
    function simpandatadetail() {
        if ($('#detail_detail_status').val() == "") {
            swal("Status Proyek harus diisi", "Silahkan isi Status Proyek terlebih dahulu", "warning");
            return;
        }
        if ($('#detail_detail_tindakan').val() == "") {
            swal("Tindakan harus diisi", "Silahkan isi Tindakan terlebih dahulu", "warning");
            return;
        }

        if ($('#detail_detail_mode').val().toLowerCase() == 'add') {
            v_detailTmpId ++;
            var v_newData = {	
                // "detailpagusarprasid": "tmp__"+v_detailTmpId, 
                "detailpagusarprasid": v_detailTmpId, 
                // "aktivitasharianid": $("#detail_aktivitasharianid").val(),
                "jenispagu": $('#detail_detail_jenispagu').val(),
                "nilaipagu": $('#detail_detail_nilaipagu').val(),
                "nokontrak": $('#detail_detail_nokontrak').val(),
                "nilaikontrak": $('#detail_detail_nilaikontrak').val(),
                "perusahaanid": $('#detail_detail_perusahaanid').val(),
                "tgldari": $('#detail_detail_tgldari').val(),
                "tglsampai": $('#detail_detail_tglsampai').val(),
                // "file": $('#detail_detail_file').val(),
                "file": document.getElementById("detail_detail_file").files[0].name,
                "status": $('#detail_detail_status').val(),
                "statusvw": $('#detail_detail_status option:selected').text(),
            };
            v_listDataDetail.push(v_newData);
            console.log(v_listDataDetail);
        }
        else {
            $.each( v_listDataDetail, function( p_key, p_value ) {
                if (p_value.detailpagusarprasid ==  $('#detail_detail_detailpagusarprasid').val()) {
                    p_value.status = $('#detail_detail_status').val();
                    p_value.statusvw = $('#detail_detail_status option:selected').text();
                    p_value.jenispagu = $('#detail_detail_jenispagu').val();
                    p_value.nilaipagu = $('#detail_detail_nilaipagu').val();
                    p_value.nokontrak = $('#detail_detail_nokontrak').val();
                    p_value.nilaikontrak = $('#detail_detail_nilaikontrak').val();
                    p_value.perusahaanid = $('#detail_detail_perusahaanid').val();
                    p_value.tgldari = $('#detail_detail_tgldari').val();
                    p_value.tglsampai = $('#detail_detail_tglsampai').val();
                    // p_value.file = $('#detail_detail_file').val();
                    p_value.file = document.getElementById("detail_detail_file").files[0].name;
                    
                    return false;
                }	
            });
        }

        $.each(v_listDataDetail, function( p_idx, p_obj ) {
            $.each(p_obj, function(obj_key, obj_val){
                if(obj_key == 'file'){
                    $("<input />").attr("type", "file")
                    .attr("class", `datadetailpagu d-none`)
                    .attr("name", `filedetailpagu[${p_idx}][${obj_key}]`)
                    .attr("value", obj_val)
                    .appendTo("#detailsarpras-form");
                }else{
                    $("<input />").attr("type", "hidden")
                    .attr("class", `datadetailpagu`)
                    .attr("name", `datadetailpagu[${p_idx}][${obj_key}]`)
                    .attr("value", obj_val)
                    .appendTo("#detailsarpras-form");
                }
            });
        });
		
        $('detail_pagu_data').val(v_listDataDetail)

		hidemodaldetail();
		
        reloadTableDetail();
	}

    function reloadTableDetail() {
		$("#detail_aktivitashariandetail").val(JSON.stringify(v_listDataDetail));

        aktivitashariandetailtable.clear();
        aktivitashariandetailtable.rows.add(v_listDataDetail);
        aktivitashariandetailtable.draw();
    }

	function deleteDataDetail(p_id) {
        if (p_id != '' && p_id != null) {
            var v_newData = {"id": p_id, "model": "detail"};
            v_listDetailDeleted.push(v_newData);
        }
        v_listDataDetail.forEach(function(p_hasil, p_index) {
            if(p_hasil['detailpagusarprasid'] === p_id) {
                v_listDataDetail.splice(p_index, 1);
            }    
        });

        // v_listDataDetail.forEach(function(p_hasil, p_index) {
        //     if(p_hasil['detailpagusarprasid'].toString() === p_id.toString()) {
        //         v_listDataDetail.splice(p_index, 1);
        //     }    
        // });
        
		$("#detail_aktivitashariandetaildel").val(JSON.stringify(v_listDetailDeleted));
        reloadTableDetail();
	}

    function hapusRiwayatKerja(idx){
        swal({   
            title: "Apakah anda yakin akan menghapus Riwayat Pekerjaan ini ?",   
            text: "Data yang terhapus tidak dapat dikembalikan lagi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, lanjutkan!",   
            closeOnConfirm: true 
        }, function(){
            v_listDataRiwayatKerja.forEach(function(p_hasil, p_index) {
                if(p_hasil['indexriwayatkerja'].toString() === idx.toString()) {
                v_listDataRiwayatKerja.splice(p_index, 1);
                }    
            });
            
            loadDataRiwayatKerja();
        });
    }

    function handleSubmit(){
        $.each(v_listDataDetail, function( p_idx, p_obj ) {
            $.each(p_obj, function(obj_key, obj_val){
                if(obj_key == 'file'){
                    $("<input />").attr("type", "file")
                    .attr("class", `datadetailpagu d-none`)
                    .attr("name", `filedetailpagu[${p_idx}][${obj_key}]`)
                    // .attr("value", obj_val)
                    .appendTo("#detailsarpras-form");
                }else{
                    $("<input />").attr("type", "hidden")
                    .attr("class", `datadetailpagu`)
                    .attr("name", `datadetailpagu[${p_idx}][${obj_key}]`)
                    .attr("value", obj_val)
                    .appendTo("#detailsarpras-form");
                }
            });
        });
    }
    
    $('#detail_proyekid').change(function(){
        $('#detail_aplikasiid').empty();
        $('#detail_aplikasiid').append($("<option></option>").attr("value", "").text("-- Pilih Aplikasi --"));

        $('#detail_klienid').empty();
        $('#detail_klienid').append($("<option></option>").attr("value", "").text("-- Pilih Klien --"));

        if ($('#detail_proyekid').val() == "") return;
        var url = "http://68.183.229.155:9080/aktivitasharian/aplikasi"
        $.ajax({
            url:url,
            type:'GET',
            data: {
                'proyekid' : $('#detail_proyekid').val(),
            },
            success:function(data) {
                $.each(data.data, function(key, value) {
                    $('#detail_aplikasiid').append($("<option></option>").attr("value", value.aplikasiid).text(value.aplikasinama));
                });
                $('#detail_aplikasiid').select2();
                $('#detail_aplikasiid').val(v_aplikasiid).trigger('change');
            }
        });

        url = "http://68.183.229.155:9080/aktivitasharian/klien"
        $.ajax({
            url:url,
            type:'GET',
            data: {
                'proyekid' : $('#detail_proyekid').val(),
            },
            success:function(data) {
                var v_default = $("#detail_tmp_klienid").val();
                $.each(data.data, function(key, value) {
                    $('#detail_klienid').append($("<option></option>").attr("value", value.klienid).text(value.kliennama));
                });
                $('#detail_klienid').select2();
                $('#detail_klienid').val(v_klienid).trigger('change');
            }
        });
    });
</script>
<script>
    var aktivitashariantable = null;
    var v_aplikasiid = "";
    var v_klienid = "";
    $(document).ready(function () {
        $('.custom-select').select2();
    
        aktivitashariantable = $('#aktivitasharian-table').DataTable({
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
                url: "http://68.183.229.155:9080/aktivitasharian",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "searchparams": JSON.stringify({
                            "search": $("#search").val(),
                            "pegawaiid": $("#pegawaiid").val(),
                            "proyekid": $("#proyekid").val(),
                            "aplikasiid": $("#aplikasiid").val(),
                            "klienid": $("#klienid").val(),
                            "tahun": "2023"
                        })
                    } );
                }
                /*data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#search").val().toLowerCase()
                    } );
                }*/
            },
            buttons: {
                buttons: [
                {
                    text: 'Lihat',
                    className: 'view btn btn-primary btn-sm btn-datatable',
                    action: function () {
                        if (aktivitashariantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dilihat", "error");
                            return;
                        }
                        showmodal("view");
                    }
                },
                {
                    text: 'Cetak',
                    className: 'print btn btn-success btn-sm btn-datatable',
                    action: function () {
                        showmodalprint();
                    }
                },
                                {
                    text: 'Tambah',
                    className: 'add btn btn-info btn-sm btn-datatable',
                    action: function () {
                        showmodal("add");
                    }
                },
                                                {
                    text: 'Ubah',
                    className: 'edit btn btn-warning btn-sm btn-datatable',
                    action: function () {
                        if (aktivitashariantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diubah", "error");
                            return;
                        }
                        if (aktivitashariantable.rows( { selected: true } ).data()[0]['statuslaporan'] != "0") {
                            swal("Data tidak dapat diproses", "Silahkan cek kembali status data", "error");
                            return;
                        }
                        
                        showmodal("edit");
                    }
                },
                                                {
                    text: 'Posting',
                    className: 'posting btn btn-secondary btn-sm btn-datatable',
                    action: function () {
                        if (aktivitashariantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diposting", "error");
                            return;
                        }
                        if (aktivitashariantable.rows( { selected: true } ).data()[0]['statuslaporan'] != "0") {
                            swal("Data tidak dapat diproses", "Silahkan cek kembali status data", "error");
                            return;
                        }

                        var id = aktivitashariantable.rows( { selected: true } ).data()[0]['aktivitasharianid'];
                        var url = getUrlAjax("http://68.183.229.155:9080/aktivitasharian/posting/paramaktivitasharian"); 
                        url = url.replace('paramaktivitasharian', id);
                        var kode = aktivitashariantable.rows( { selected: true } ).data()[0]['issue'] + '-' + aktivitashariantable.rows( { selected: true } ).data()[0]['tindakan'];
                        swal({   
                            text: "Apakah anda yakin akan melakukan posting data " + kode + " ?",   
                            title: "Status data yang telah diposting tidak dapat dikembalikan lagi",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
                            //$(".loadingdata").find('.loader__label').html("Proses Hapus Data");
                            //$(".loadingdata").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                cache:false,
                                url: url,
                                success: function(html){
                                    var success = false;
                                    var message = "";
                                    var data = "Error";
                                    
                                    $.each(html, function( index, value ) {
                                        if (index == 'success')
                                        success = value;
                                        else if (index == 'message')
                                            message = value;
                                        else if (index == 'data')
                                            data = value;
                                    });
                                    if (success == 'true' || success == true) {
                                        swal("Berhasil!", "Data anda telah diposting.", "success"); 
                                        aktivitashariantable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                },
                                error: function(jqXhr, json, errorThrown){
                                    if (jqXhr.status==422){
                                        var jdata = jqXhr.responseText;
                                        $(".errorspan").html("");
                                        $.each(JSON.parse(jdata).data, function (index, value) {
                                            $("#err_detail_"+index.replaceAll(".", "")).html(value.join(", "));
                                            
                                        });
                                        swal("Validasi", JSON.parse(jdata).message, "error"); 
                                    }else{
                                        var jdata = JSON.parse(jqXhr.responseText);
                                        swal("Error!", jdata.data, "error"); 
                                    }
                                    //$(".loadingdata").hide();
                                }
                            });
                        });
                    }
                },
                                                {
                    text: 'Unposting',
                    className: 'unposting btn btn-dark btn-sm btn-datatable',
                    action: function () {
                        if (aktivitashariantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan diunposting", "error");
                            return;
                        }
                        if (aktivitashariantable.rows( { selected: true } ).data()[0]['statuslaporan'] != "1") {
                            swal("Data tidak dapat diproses", "Silahkan cek kembali status data", "error");
                            return;
                        }

                        var id = aktivitashariantable.rows( { selected: true } ).data()[0]['aktivitasharianid'];
                        var url = getUrlAjax("http://68.183.229.155:9080/aktivitasharian/unposting/paramaktivitasharian"); 
                        url = url.replace('paramaktivitasharian', id);
                        var kode = aktivitashariantable.rows( { selected: true } ).data()[0]['issue'] + '-' + aktivitashariantable.rows( { selected: true } ).data()[0]['tindakan'];
                        swal({   
                            text: "Apakah anda yakin akan melakukan unposting data " + kode + " ?",   
                            title: "Status data yang telah diunposting tidak dapat dikembalikan lagi",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
                            //$(".loadingdata").find('.loader__label').html("Proses Hapus Data");
                            //$(".loadingdata").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                cache:false,
                                url: url,
                                success: function(html){
                                    var success = false;
                                    var message = "";
                                    var data = "Error";
                                    
                                    $.each(html, function( index, value ) {
                                        if (index == 'success')
                                        success = value;
                                        else if (index == 'message')
                                            message = value;
                                        else if (index == 'data')
                                            data = value;
                                    });
                                    if (success == 'true' || success == true) {
                                        swal("Berhasil!", "Data anda telah unposting.", "success"); 
                                        aktivitashariantable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                },
                                error: function(jqXhr, json, errorThrown){
                                    if (jqXhr.status==422){
                                        var jdata = jqXhr.responseText;
                                        $(".errorspan").html("");
                                        //alert(JSON.parse(jdata).data);
                                        $.each(JSON.parse(jdata).data, function (index, value) {
                                            $("#err_detail_"+index.replaceAll(".", "")).html(value.join(", "));
                                            
                                        });
                                        swal("Validasi", JSON.parse(jdata).message, "error"); 
                                    }else{
                                        var jdata = JSON.parse(jqXhr.responseText);
                                        swal("Error!", jdata.data, "error"); 
                                    }
                                    //$(".loadingdata").hide();
                                }
                            });                
                        });
                    }
                },
                                                {
                    text: 'Hapus',
                    className: 'delete btn btn-danger btn-sm btn-datatable',
                    action: function () {
                        if (aktivitashariantable.rows( { selected: true } ).count() <= 0) {
                            swal("Data belum dipilih", "Silahkan pilih data yang akan dihapus", "error");
                            return;
                        }
                        if (aktivitashariantable.rows( { selected: true } ).data()[0]['statuslaporan'] != "0") {
                            swal("Data tidak dapat diproses", "Silahkan cek kembali status data", "error");
                            return;
                        }

                        var id = aktivitashariantable.rows( { selected: true } ).data()[0]['aktivitasharianid'];
                        var url = getUrlAjax("http://68.183.229.155:9080/aktivitasharian/paramaktivitasharian"); 
                        url = url.replace('paramaktivitasharian', id);
                        var kode =  aktivitashariantable.rows( { selected: true } ).data()[0]['issue'] + '-' + aktivitashariantable.rows( { selected: true } ).data()[0]['tindakan'];
                        swal({   
                            text: "Apakah anda yakin akan menghapus data Departemen " + kode + " ?",   
                            title: "Data yang terhapus tidak dapat dikembalikan lagi",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText: "Ya, lanjutkan!",   
                            closeOnConfirm: false 
                        }, function(){   
                            //$(".loadingdata").find('.loader__label').html("Proses Hapus Data");
                            //$(".loadingdata").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "DELETE",
                                cache:false,
                                url: url,
                                success: function(html){
                                    var success = false;
                                    var message = "";
                                    var data = "Error";
                                    
                                    $.each(html, function( index, value ) {
                                        if (index == 'success')
                                        success = value;
                                        else if (index == 'message')
                                            message = value;
                                        else if (index == 'data')
                                            data = value;
                                    });
                                    if (success == 'true' || success == true) {
                                        swal("Berhasil!", "Data anda telah dihapus.", "success"); 
                                        aktivitashariantable.draw();
                                    }
                                    else {
                                        swal("Error!", data, "error"); 
                                    }
                                },
                                error: function(jqXhr, json, errorThrown){
                                    if (jqXhr.status==422){
                                        var jdata = jqXhr.responseText;
                                        $(".errorspan").html("");
                                        $.each(JSON.parse(jdata).data, function (index, value) {
                                            $("#err_detail_"+index.replaceAll(".", "")).html(value.join(", "));
                                            
                                        });
                                        swal("Validasi", JSON.parse(jdata).message, "error"); 
                                    }else{
                                        var jdata = JSON.parse(jqXhr.responseText);
                                        swal("Error!", jdata.data, "error"); 
                                    }
                                    //$(".loadingdata").hide();
                                }
                            });                
                        });
                    }
                },
                                ]
            },
            columns: [
                {data: 'aktivitasharianid', name: 'aktivitasharianid', visible: false},
                {data: 'tanggal', name: 'tanggal', visible: false},
                {data: 'klasifikasivw', 
                    render: function ( data, type, row ) {
                        return '<span class="badge badge-pill badge-dark">'+data+'</span>';
                    }, 
                    name: 'klasifikasivw'},
                {data: 'issue', name: 'issue'},
                {data: 'tindakan', name: 'tindakan'},
                {data: 'kliennama', name: 'kliennama'},
                {data: 'proyeknama', name: 'proyeknama'},
                {data: 'aplikasinama', name: 'aplikasinama'},
                {data: 'statuslaporanvw', 
                    render: function ( data, type, row ) {
                        return '<span class="badge badge-pill '+row.badge+'">'+data+'</span>';
                    }, 
                    name: 'statuslaporan'},
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
                //table.buttons( 'myButtonName:name' ).disable();
                setenabledtbutton("");
            },
            rowGroup: {
                startRender: function ( rows, group, level ) {
                    if (level === 1) {
                        return $('<tr/>')
                            .append( '<td colspan="7" class="bg-success font-weight-bold">'+group+'</td>' );
                    } else if (level === 0) {
                        return DateFormat(group) + " (" + rows.count() + ")";
                    }
                },
                dataSrc: [ 'tanggal' ]
            },
            drawCallback: function( settings ) {
                $("#aktivitasharian-table").wrap( "<div class='table-responsive'></div>" );
            }
        });

        function setenabledtbutton(option) {
            aktivitashariantable.buttons( '.view' ).disable();
            //aktivitashariantable.buttons( '.print' ).disable();
            //aktivitashariantable.buttons( '.add' ).disable();
            aktivitashariantable.buttons( '.edit' ).disable();
            aktivitashariantable.buttons( '.posting' ).disable();
            aktivitashariantable.buttons( '.unposting' ).disable();
            aktivitashariantable.buttons( '.delete' ).disable();

            if (option == "0") {
                aktivitashariantable.buttons( '.view' ).enable();
                aktivitashariantable.buttons( '.print' ).enable();
                aktivitashariantable.buttons( '.add' ).enable();
                aktivitashariantable.buttons( '.edit' ).enable();
                aktivitashariantable.buttons( '.posting' ).enable();
                //aktivitashariantable.buttons( '.unposting' ).enable();
                aktivitashariantable.buttons( '.delete' ).enable();
            }
            else if (option == "1") {
                aktivitashariantable.buttons( '.view' ).enable();
                aktivitashariantable.buttons( '.print' ).enable();
                aktivitashariantable.buttons( '.unposting' ).enable();
            }
            else if (option == "3" || option == "5" || option == "2" || option == "4" || option == "6") {
                aktivitashariantable.buttons( '.view' ).enable();
                aktivitashariantable.buttons( '.print' ).enable();
            }
        }

        aktivitashariantable
            .on( 'select', function ( e, dt, type, indexes ) {
                setenabledtbutton(aktivitashariantable.rows( { selected: true } ).data()[0]['statuslaporan']);
            } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                setenabledtbutton("");
            } );


        $("#btn_simpan").click(function(){
            simpandata();
        });

        function resetform() {
            resettable();
            $("#aktivitasharian-form")[0].reset();
            
            $('select[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                $('#'+el.id).val("").trigger('change');
            });

            $('span[id^="err_detail_"]', "#aktivitasharian-form").each(function(index, el){
                $('#'+el.id).html("");
            });
        }

        function bindform() {
            v_aplikasiid = aktivitashariantable.rows( { selected: true } ).data()[0]['aplikasiid'];
            v_klienid = aktivitashariantable.rows( { selected: true } ).data()[0]['klienid'];
            
            $('input[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                var inputname = el.id.substring(7, el.id.length);
                if (inputname != "mode") {
                    $("#"+el.id).val(aktivitashariantable.rows( { selected: true } ).data()[0][inputname]);
                }
            });
            
            $('select[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                var inputname = el.id.substring(7, el.id.length);
                if (inputname != "mode") {
                    $("#"+el.id).val(aktivitashariantable.rows( { selected: true } ).data()[0][inputname]).trigger('change');
                }
            });

            loadDetail($("#detail_aktivitasharianid").val());
        }

        function setenabled(value) {
            if (value) {
                $("#btn_simpan").show();
            }
            else {
                $("#btn_simpan").hide();
            }
            
            $('input[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                $("#"+el.id).prop("readonly", !value);
            });
            $('select[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                $("#"+el.id).prop("disabled", !value);
            });
        }

        function showmodal(mode) {
            v_mode = mode;
            $("#detail_mode").val(mode);
            resetform();
            if (mode == "add") {
                $("#d_title").html('Tambah Data');
                setenabled(true);
            }
            else if (mode == "edit") {
                $("#d_title").html('Ubah Data');
                bindform();
                setenabled(true);
            }
            else {
                $("#d_title").html('Lihat Data');
                bindform();
                setenabled(false);
            }
            
            $("#m_formshow").modal('show');
        }

        function hidemodal() {
            $("#m_formshow").modal('hide');
        }

        function simpandata() {
            var url = "";
            var type = "";
            var data = {};
            $('input[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                var inputname = el.id.substring(7, el.id.length);
                if (inputname != "mode" && inputname != "aktivitasharianid") {
                    data[inputname] = $("#"+el.id).val();
                }
            });
            $('select[id^="detail_"]', "#aktivitasharian-form").each(function(index, el){
                var inputname = el.id.substring(7, el.id.length);
                if (inputname != "mode" && inputname != "aktivitasharianid") {
                    data[inputname] = $("#"+el.id).val();
                }
            });
            if ($("#detail_mode").val() == 'add') {
                url = "http://68.183.229.155:9080/aktivitasharian";
                type = "POST";
            }
            else if ($("#detail_mode").val() == "edit") {
                url = "http://68.183.229.155:9080/aktivitasharian/paramaktivitasharian";
                url = url.replace('paramaktivitasharian', $("#detail_aktivitasharianid").val());
                type = "PUT";
                //type = "POST";
            }
            
            $.ajax({
                url:url,
                type:type,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success:function(data) {
                    //var jdata = JSON.parse(data);
                    aktivitashariantable.draw();
                    swal("Simpan Data", "Berhasil menyimpan data", "info");
                    hidemodal();

                },
                error: function(jqXhr, json, errorThrown){
                    if (jqXhr.status==422){
                        var jdata = jqXhr.responseText;
                        $(".errorspan").html("");
                        //alert(JSON.parse(jdata).data);
                        $.each(JSON.parse(jdata).data, function (index, value) {
                            $("#err_detail_"+index.replaceAll(".", "")).html(value.join(", "));
                            
                        });
                        swal("Validasi", JSON.parse(jdata).message, "error"); 
                    }else{
                        var jdata = JSON.parse(jqXhr.responseText);
                        swal("Error!", jdata.data, "error"); 
                    }
                    //$(".loadingdata").hide();
                }
            });
        }

        $("#search").keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $("#search").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                reloadTable();
            }
        });
    
        $("#pegawaiid").change(function(){
            reloadTable();
        });
    
        $("#proyekid").change(function(){
            reloadTable();
        });
    
        $("#aplikasiid").change(function(){
            reloadTable();
        });
    
        $("#klienid").change(function(){
            reloadTable();
        });

        function reloadTable() {
            aktivitashariantable.draw();
        }

        function loadDetail(aktivitasharianid) {
            var url = "http://68.183.229.155:9080/aktivitasharian/detail";
            
            $.ajax({
                url:url,
                type:'GET',
                data: {
                    'aktivitasharianid' : aktivitasharianid
                },
                success:function(data) {
                    v_listDataDetail = data.data;
                    reloadTableDetail();
                }
            });
        }
    
        //modal print
        function showmodalprint() {
            $("#d_titleprint").html('Cetak Data');
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $("#detail_print_tanggal").val(today);
            $("#m_formshowprint").modal('show');
        }

        function hidemodalprint() {
            $("#m_formshowprint").modal('hide');
        }

        $("#btn_cetak").click(function(){
            cetak();
        });

        function cetak(){
            if ($('#detail_print_tanggal').val()=="" || $('#detail_print_tanggal').val()=="null") {
                swal("Tanggal harus dipilih", "Pilih Tanggal terlebih dahulu", "error");
                return;
            }
            $('#m_formshowprint').modal('hide');

            var v_tanggal = $('#detail_print_tanggal').val();

            var url = new URL(getUrlAjax("http://68.183.229.155:9080/aktivitasharian/print"));

            var params = {
                'pegawaiid': $('#detail_print_pegawaiid').val(),
                'tanggal': $('#detail_print_tanggal').val()
            };
            url.search = new URLSearchParams(params).toString();


            /*
            $.ajax({
                url:url,
                type:'GET',
                //data: params,
                success:function(data) {
                    v_listDataDetail = data.data;
                    reloadTableDetail();
                }
            });

            return;*/
            
            fetch(url)
            .then(res => {
                if (res.status == 200) {
                    return res.arrayBuffer();
                }
                else {
                    res.text().then(text => {
                        var data = JSON.parse(text);
                        var errMsg = res.statusText;
                        if('success' in data && data.success==false){
                            errMsg = data.message;
                        }
                        swal("Aktivitas Harian", "Gagal cetak laporan: ["+res.status+"] "+errMsg, "error");
                    })
                    throw new Error(res.status+" "+res.statusText)
                }
            })
            .then(blob => { 
                const file = new Blob([blob], {type: 'application/pdf'});

                var now = new Date();
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var v_today = now.getFullYear().toString(10)
                            + (now.getMonth()+1).toString(10).padStart(2,'0')
                            + now.getDate().toString(10).padStart(2,'0')
                            + now.getHours().toString(10).padStart(2,'0')
                            + now.getMinutes().toString(10).padStart(2,'0')  
                            + now.getSeconds().toString(10).padStart(2,'0')
                var url = window.URL.createObjectURL(file);
                var a = document.createElement('a');
                a.href = url;
                a.download = "rptAktivitas_" + v_today + ".pdf";
                document.body.appendChild(a); 
                a.click();    
                a.remove();  
            })
            .catch(err => { 
                // console.error(err)
            })
        }
    });
</script>
<!-- script detail -->


<script>
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
    });
</script>
@endsection
