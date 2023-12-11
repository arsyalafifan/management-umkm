<?php
use App\enumVar as enum;
?>

@extends('layouts.master')

@section('content')
<style>
    .loadingdata {
        width: 100%;
        height: 100%;
        top: 0px;
        position: fixed;
        z-index: 99999;
        margin-left: -245px;
        background-color:rgba(0, 0, 0, 0.15);
    }
</style>
<div class="loadingdata" style="display: none;">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Load Data</p>
    </div>
</div>
<div id="formPerusahaan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titlePerusahaan" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="/*max-width: none; width:90%*/">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titlePerusahaan">Pilih Perusahaan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="height: 75vh; max-height: 75vh; overflow-y: auto;">
                <div class="card-body">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="searchperusahaan" class="col-md-12 col-form-label text-md-left">{{ __('Filter') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="searchperusahaan" type="text" class="col-md-12 form-control" name="searchperusahaan" value="" maxlength="100" autocomplete="searchperusahaan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable table-striped" id="perusahaan-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Daftar</th>
                                    <th>Nama Perusahaan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" onclick="pilihPerusahaan();" >Simpan</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="jenisrpt" id="rptperusahaanbylokasi" value="rptperusahaanbylokasi">
                    <label class="form-check-label align-middle" for="rptperusahaanbylokasi">Daftar Perusahaan Berdasarkan Lokasi</label>
                </div>
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="jenisrpt" id="rptjumlahnakerbyperusahaan" value="rptjumlahnakerbyperusahaan">
                    <label class="form-check-label align-middle" for="rptjumlahnakerbyperusahaan">Jumlah Tenaga Kerja Berdasarkan Perusahaan</label>
                </div>
            </div>
        </div><hr />
        <div class="form-row mb-1">
            <div class="col-md-2">
                <label for="perusahaanid" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan') }}</label>
            </div>
            <div class="col-md-8">
                <input id="perusahaanid" type="hidden" name="perusahaanid">
                <input id="perusahaanvw" type="text" class="col-md-12 form-control" name="perusahaanvw" readonly="">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-info waves-effect waves-light m-r-10 btn-block" onclick="showFormPerusahaan()">
                    {{ __('CARI') }}
                </button>
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-md-2">
                <label for="kecamatanid" class="col-md-12 col-form-label text-md-left">{{ __('Kecamatan') }}</label>
            </div>
            <div class="col-md-4">
                <select id="kecamatanid" class="col-md-12 custom-select form-control" name='kecamatanid' autofocus>
                    <option value="all">{ SEMUA }</option>
                    @foreach ($kecamatan as $item)
                    <option value="{{$item->kecamatanid}}">{{ $item->namakec }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="KBLI" class="col-md-12 col-form-label text-md-left">{{ __('KBLI') }}</label>
            </div>
            <div class="col-md-4">
                <select id="KBLI" class="col-md-12 custom-select form-control" name='KBLI'>
                    <option value="all">{ SEMUA }</option>
                </select>
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-md-2">
                <label for="kelurahanid" class="col-md-12 col-form-label text-md-left">{{ __('Kelurahan') }}</label>
            </div>
            <div class="col-md-4">
                <select id="kelurahanid" class="col-md-12 custom-select form-control" name='kelurahanid' autofocus>
                    <option value="all">{ SEMUA }</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="col-md-12 col-form-label text-md-left">Status</label>
            </div>
            <div class="col-md-4">
                <select id="status" class="col-md-12 custom-select form-control" name='status'>
                    <option value="all">{ SEMUA }</option>
                    <option value="{{enum::STATUS_BADANUSAHA_PUSAT}}">{{ 'Pusat' }}</option>
                    <option value="{{enum::STATUS_BADANUSAHA_CABANG}}">{{ 'Cabang' }}</option>
                </select>
            </div>
        </div><hr />
        <div class="row">
            <div class="col ml-3">
                <div class="form-row mb-1">
                    <div class="col-md-4">
                        <div class="row">
                            <input class="col-md-1 align-self-center" type="radio" name="jenisperiode" id="periodetanggal" value="tanggal">
                            <label for="periodetanggal" class="col-md-11 col-form-label text-md-left">Per-Tanggal</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input id="tanggal" type="date" class="col-md-12 form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>" maxlength="100">
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-md-4">
                        <div class="row">
                            <input class="col-md-1 align-self-center" type="radio" name="jenisperiode" id="periodebulan" value="bulan">
                            <label for="periodebulan" class="col-md-11 col-form-label text-md-left">Per-Bulan</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select id="bulan" class="col-md-12 form-control" name='bulan'>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="tahunbulan" class="col-md-12 custom-select form-control" name='tahunbulan'>
                            @foreach ($tahun as $item)
                            <option value="{{$item->tahun}}" @if(date("Y")==$item->tahun) selected @endif>{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col ml-3">
                <div class="form-row mb-1">
                    <div class="col-md-4">
                        <div class="row">
                            <input class="col-md-1 align-self-center" type="radio" name="jenisperiode" id="periodetriwulan" value="triwulan">
                            <label for="periodetriwulan" class="col-md-11 col-form-label text-md-left">Per-Triwulan</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select id="triwulan" class="col-md-12 form-control" name='triwulan'>
                            <option value="1">I</option>
                            <option value="2">II</option>
                            <option value="3">III</option>
                            <option value="4">IV</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="tahuntriwulan" class="col-md-12 custom-select form-control" name='tahuntriwulan'>
                            @foreach ($tahun as $item)
                            <option value="{{$item->tahun}}" @if(date("Y")==$item->tahun) selected @endif>{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-md-4">
                        <div class="row">
                            <input class="col-md-1 align-self-center" type="radio" name="jenisperiode" id="periodetahun" value="tahun">
                            <label for="periodetahun" class="col-md-11 col-form-label text-md-left">Per-Tahun</label></div>
                        </div>
                    <div class="col-md-8">
                        <select id="tahun" class="col-md-12 custom-select form-control" name='tahun'>
                            @foreach ($tahun as $item)
                            <option value="{{$item->tahun}}" @if(date("Y")==$item->tahun) selected @endif>{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div><hr>
        <div class="form-row mb-1">
            <div class="col-md-2">
                <label for="tglcetak" class="col-md-12 col-form-label text-md-left">Tanggal</label>
            </div>
            <div class="col-md-4">
            <input id="tglcetak" type="date" class="col-md-12 form-control" name="tglcetak" value="<?php echo date('Y-m-d'); ?>" maxlength="100">
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-info waves-effect waves-light m-r-10" onclick="printDoc('pdf')">
                    {{ __('Cetak PDF') }}
                </button>
                <button type="button" class="btn btn-info waves-effect waves-light m-r-10" onclick="printDoc('excel')">
                    {{ __('Cetak Excel') }}
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var perusahaantable = null;
    $(document).ready(function () {
        $('.custom-select').select2();

        perusahaantable = $('#perusahaan-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            dom: 'frtip',
            // select: true,
            ordering: false,
            searching: false,
            language: {
                lengthMenu: "Menampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data",
                info: "Halaman _PAGE_ dari _PAGES_ (Total: _TOTAL_ Data)",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ data)",
                search: "Pencarian :",
                paginate: {
                   previous: "Sebelumnya",
                   next: "Selanjutnya",
                }
            },
            ajax: {
                url: "{{ route('laporandinas.perusahaan') }}",
                dataSrc: function(response){
                    response.recordsTotal = response.data.count;
                    response.recordsFiltered = response.data.count;
                    return response.data.data;
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "search": $("#searchperusahaan").val().toLowerCase(),
                    } );
                }
            },
            columns: [
                {'orderData': 1, data: 'kodedaftar', name: 'kodedaftar'},
                {'orderData': 2, data: 'nama', name: 'nama'}
            ],
            initComplete: function (settings, json) {
                $(".btn-datatable").removeClass("dt-button");
            },
            //order: [[1, 'asc']]
        });

        $('#kecamatanid').change( function() {
            loadKelurahan();
        });
        
        $('#searchperusahaan').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        $('#searchperusahaan').on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                perusahaantable.draw();
            }
        });

        $('#perusahaan-table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                perusahaantable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        loadKelurahan();
    });

    function loadKelurahan(){
        $('#kelurahanid').empty();
        $('#kelurahanid').append($("<option></option>").attr("value", "all").text("{ SEMUA }"));
        
        var url = "{{ route('laporandinas.kelurahan', ':parentid') }}";
        url = url.replace(':parentid', ($('#kecamatanid').val() == "" || $('#kecamatanid').val() == null || $('#kecamatanid').val() == "all" ? "-1" : $('#kecamatanid').val()));

        $.ajax({
            url: url,
            type:'GET',
            data:{
                kecamatanid:$('#kecamatanid').val()
            },
            success:function(res) {
                $.each(res.data, function(key, value) {
                    $('#kelurahanid').append($("<option></option>").attr("value", value.kelurahanid).text(value.namakel));
                });
                $('#kelurahanid').select2();
                $('#kelurahanid').val("all").trigger('change');
            }
        });
    }

    function printDoc(jenisreport = "pdf"){
        var jenisrpt = $('input[name="jenisrpt"]:checked').val();
        var tglcetak = $('#tglcetak').val();
        var perusahaanid = $('#perusahaanid').val();
        var kecamatanid = $('#kecamatanid').val();
        var kelurahanid = $('#kelurahanid').val();
        var kbli = $('#kbli').val();
        var status = $('#status').val();

        var jenisperiode = $('input[name="jenisperiode"]:checked').val();
        var tanggal = $('#tanggal').val();
        var bulan = $('#bulan').val();
        var triwulan = $('#triwulan').val();
        var tahunbulan = $('#tahunbulan').val();
        var tahuntriwulan = $('#tahuntriwulan').val();
        var tahun = $('#tahun').val();
        if (jenisperiode == 'bulan') {
            tahun = $('#tahunbulan').val();
        } else if (jenisperiode == 'triwulan') {
            tahun = $('#tahuntriwulan').val();
        } else if (jenisperiode == 'semester') {
            tahun = $('#tahunsemester').val();
        } else if (jenisperiode == 'tanggal') {
            tahun = "{{ date("Y") }}";
        } 
        if(!jenisrpt){
            swal("Laporan Dinas", "Silahkan Pilih Jenis Laporan terlebih dahulu", "error");
            return;
        }
        //Jika cetak laporan yang per Perusahaan
        if((jenisrpt=='rptperperusahaanid') && perusahaanid==""){
            swal("Laporan Dinas", "Silahkan Pilih Perusahaan terlebih dahulu", "error");
            return;
        }

        var url = new URL('{{ route("laporandinas.cetak") }}');

        var params = {
            jenisreport: jenisreport,
            jenisrpt: jenisrpt,
            tglcetak: tglcetak,
            perusahaanid: perusahaanid,
            kecamatanid: kecamatanid,
            kelurahanid: kelurahanid,
            kbli: kbli,
            status: status,            
            jenisperiode: jenisperiode,
            tanggal: tanggal,
            bulan: bulan,
            triwulan: triwulan,
            tahunbulan: tahunbulan,
            tahuntriwulan: tahuntriwulan,
            tahun: tahun
        };
        url.search = new URLSearchParams(params).toString();

        if(jenisreport == "pdf") {
            window.open(url,'_blank');
            return
        }

        $(".loadingdata").find('.loader__label').html("Mencetak data, Silahkan tunggu...");
        $(".loadingdata").show();

        fetch(url)
        .then(res => {
            if (res.status == 200) {
                // return res.blob();
                return res.arrayBuffer();
            }
            else {
                res.text().then(text => {
                    var data = JSON.parse(text);
                    var errMsg = res.statusText;
                    if('success' in data && data.success==false){
                        errMsg = data.message;
                    }
                    swal("Laporan Dinas", "Gagal cetak laporan: ["+res.status+"] "+errMsg, "error");
                })
                throw new Error(res.status+" "+res.statusText)
            }
        })
        .then(blob => { 
            // set the blog type to final pdf
            const file = new Blob([blob], {type:  (jenisreport=="excel" ? 'application/vnd.ms-excel' : 'application/pdf')});

            var url = window.URL.createObjectURL(file);
            var a = document.createElement('a');
            a.href = url;
            a.download = jenisrpt+"_" + new Date() + (jenisreport=="excel" ? ".xlsx" : ".pdf");
            document.body.appendChild(a); // we need to append the element to the dom -> otherwise it will not work in firefox
            a.click();    
            a.remove();  //afterwards we remove the element again       
            $(".loadingdata").hide();
        })
        .catch(err => { 
            $(".loadingdata").hide();
            // console.error(err)
        })
    }

    function showFormPerusahaan(){
        perusahaantable.draw();
        $('#formPerusahaan').modal('show');
    }

    function pilihPerusahaan(){
        let data = perusahaantable.row('.selected').data();
        if(data !== undefined){
            $("#perusahaanid").val(data.perusahaanid);
            $("#perusahaanvw").val(data.nama);
            $('#formPerusahaan').modal('hide');
        }else{
            swal("Laporan Dinas", "Silahkan Pilih Perusahaan terlebih dahulu", "error");
        }
    }

</script>
@endsection
