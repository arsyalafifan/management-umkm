@extends('layouts.landing', ['p_nav_bg_color' => '#077fd5'])

@section('content')
    <section class="mt-3">
        <div class="container">
            <h1 class="display-6">Daftar Lowongan Kerja</h1>
        </div>
            
        <div>
            <div class="container py-3">
                <form class="form-material">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="perusahaanid" class="col-md-12 text-md-left">{{ __('Perusahaan:') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <select id="perusahaanid" class="col-md-12 form-control" name='perusahaanid' autofocus>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="kawasanid" class="col-md-12 text-md-left">{{ __('Kawasan:') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <select id="kawasanid" class="col-md-12 form-control" name='kawasanid' autofocus>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-light">
            <div class="container py-4" style="min-height: 40vh;">
                <div class="row" id="noResultContainer" style="display: none;">
                    <div class="col-md-12">
                         <div class="card">
                            <div class="card-body">
                                <span class="text-center"><b>Maaf, Lowongan Tidak Ditemukan</b></span>
                            </div>
                         </div>
                    </div>
                </div>
                <div class="row" id="resultContainer">
                    <div id="lokerlistloadingContainer" class="col-md-4" style="display: none;">
                        <div class="card mb-2" aria-hidden="true">
                            <div class="card-body">
                                <h4 class="card-title placeholder-glow"><span class="placeholder col-5"></span></h4>
                                <h5 class="placeholder-glow"><span class="placeholder col-8"></span></h5>
                                <p class="card-text placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                    <span class="placeholder col-5"></span>
                                    <span class="placeholder col-7"></span>
                                    <span class="placeholder col-6"></span>
                                    <span class="placeholder col-5"></span>
                                </p>
                                <button class="btn btn-info mt-2 float-end disabled placeholder col-3"></button>
                            </div>
                        </div>
                    </div>
                    <div id="lokerlistContainer" class="col-md-4" style="overflow-x: hidden; overflow-y: scroll;max-height: 80vh;display: none;">
                    </div>
                    <div class="col-md-8 d-none d-sm-block">
                        <div class="card" id="lokerdetailContainer" style="display: none;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">Nama Perusahaan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerPerusahaanNama"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Nama Pekerjaan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerJudul"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Alamat Pengiriman Lamaran<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerAlamat"></span></div>
                                </div>
                                <span><b>Lokasi Pekerjaan</b></span><br>
                                <div class="row">
                                    <div class="col-4"><span><b>Provinsi: </b><span id="lokerProv"></span></span></div>
                                    <div class="col-8"><span><b>Kab/Kota: </b><span id="lokerKota"></span></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Email<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerEmail"></span></div>
                                </div><br>
                                    
                                <span><b>Deskripsi Pekerjaan</b></span><br>
                                <span>Tugas dan Tanggung Jawab:</span>
                                <p id="lokerJobdesc" style="white-space: pre-wrap;"></p>

                                <span>Persyaratan:</span>
                                <p id="lokerSyarat" style="white-space: pre-wrap;"></p>
                                    
                                <span><b>Informasi Tambahan</b></span>
                                <div class="row">
                                    <div class="col-4">Level Pekerjaan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerLevel"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Kualifikasi Pendidikan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerJenjang"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Pengalaman Kerja<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerPengalaman"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Jenis Pekerjaan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerStatus"></span></div>
                                </div>
                                <div class="row" id="lokerDivGaji">
                                    <div class="col-4">Gaji yang ditawarkan<span class="float-end">:</span></div>
                                    <div class="col-8"><span id="lokerGaji"></span></div>
                                </div>
                                @if(str_contains(strtoupper(Config::get('app.name')), "DEV"))
                                <div class="row">
                                    <div class="col">
                                        <a href="#" id="linkDaftar" class="btn btn-info mt-2 float-end">Daftar</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card" id="lokerdetailloadingContainer" style="display: none;">
                            <div class="card-body">
                                <p class="placeholder-glow">
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span><br>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span><br>
                                    
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span><br>

                                    <span class="placeholder col-2"></span>
                                    <br>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span><br>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span><br>
                                    <br>
                                        
                                    <span class="placeholder col-2"></span><br>
                                    <span class="placeholder col-2"></span><br>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span><br>

                                    <span class="placeholder col-2"></span><br>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-7"></span><br>
                                        
                                    <span class="placeholder col-2"></span><br>
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span>

                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-7"></span>
                                </p>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        var records_per_page = 30;

        var currentLokerId = null;

        var loadListLokerXhr = null;
        var loadLokerXhr = null;

        const isPhoneScreen = (screen.width < 768);

        $(document).ready(function() {
            @if (session()->has('success'))
            swal({
                title: "",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Ok!",
                type: "success",
            });
            @endif
            
            $("#perusahaanid").select2({
                placeholder: 'Cari Perusahaan...',
                allowClear: true,
                ajax: {
                    type: 'POST',
                    url: `{{ route('daftarloker.perusahaan') }}`,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            "_token": "{{ csrf_token() }}",
                        }
                    },
                    cache: true,
                    delay: 500,
                }
            }).on('change', function() {
                loadListLoker(1);
            });

            $("#kawasanid").select2({
                placeholder: 'Cari Kawasan Industri...',
                allowClear: true,
                ajax: {
                    type: 'POST',
                    url: `{{ route('daftarloker.kawasan') }}`,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            "_token": "{{ csrf_token() }}",
                        }
                    },
                    cache: true,
                    delay: 500,
                }
            }).on('change', function() {
                loadListLoker(1);
            });

            loadListLoker(1);

        });


        function loadListLoker(page){
            if(loadListLokerXhr !== null) loadListLokerXhr.abort();

            loadListLokerXhr = $.ajax({
                type: 'POST',
                url: `{{ route('daftarloker.index') }}`,
                data: {
                    "_token": "{{ csrf_token() }}",
                    start: ((page-1)==0 ? 0 : records_per_page*(page-1)),
                    length: records_per_page,
                    perusahaanid: $('#perusahaanid').val(),
                    kawasanid: $('#kawasanid').val()
                },
                beforeSend: function() {
                    clearLokerdetailData();

                    $('#lokerlistContainer').hide();
                    $('#lokerlistloadingContainer').show();

                    $('#noResultContainer').hide();
                    $('#resultContainer').show();
                },
                success: function(res) {
                    $('#lokerlistContainer').empty();
                    if(res.success){
                        $.each(res.data.data, function(key, value) {
                            let html = '';
                            html += '<div class="card mb-2 loker-item">';
                            html += '<div class="card-body">';
                            if(value.perusahaan.logo){
                                html += '<div class="mb-2">';
                                html += '<img src="/images/'+value.perusahaan.logo+'" height="50">';
                                html += '</div>';
                            }
                            html += '<h4 class="card-title">'+value.perusahaan.nama+'</h4>';
                            html += '<h5><b>'+value.judul+'</b></h5>';
                            html += '<div class="row">';
                            html += '<div class="col"><span><b>Provinsi: </b><span>'+(value.prov ? value.prov.namaprov : '-')+'</span></span></div>';
                            html += '<div class="col"><span><b>Kab/Kota: </b><span>'+(value.kota ? value.kota.namakota : '-')+'</span></span></div>';
                            html += '</div>';
                            if(value.isshowgaji=="1"){
                                html += '<div class="row mt-2">';
                                html += '<span><b>Gaji Yang Ditawarkan:</b></span>';
                                html += '<div>';
                                html += '<span><b>Dari </b><span>'+(value.gajimin ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'IDR' }).format(value.gajimin) : '-')+'</span></span>&nbsp;&nbsp;';
                                html += '<span><b>Sampai </b><span>'+(value.gajimax ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'IDR' }).format(value.gajimax) : '-')+'</span></span>';
                                html += '</div>';
                                html += '</div>';
                            }
                            if(!isPhoneScreen)
                                html += '<button class="btn btn-info mt-2 float-end" onClick="loadLoker('+value.lokerid+', this)">Detail</button>';
                            html += '</div>';
                            html += '</div>';

                            $('#lokerlistContainer').append(html);
                        });

                        let pagerHtml = '<div class="d-flex flex-row justify-content-around">';
                        let totalPage = Math.ceil(res.data.count/records_per_page);
                        
                        pagerHtml += '<button class="btn btn-primary my-1" onClick="loadListLoker('+(page-1)+')" '+((page-1)<1 ? 'disabled' : '')+'>Sebelumnya</button>';
                        pagerHtml += '<select class="p-3" id="cbPage">';
                        for (var i = 1; i <= totalPage; i++) {
                            pagerHtml += '<option value="'+i+'" '+(i==page ? 'selected' : '')+'>'+i+'</option>'
                        }
                        pagerHtml += '</select>'
                        pagerHtml += '<button class="btn btn-primary my-1" onClick="loadListLoker('+(page+1)+')" '+((page+1)>totalPage ? 'disabled' : '')+'>Selanjutnya</button>';
                        pagerHtml += '</div>';
                        $('#lokerlistContainer').append(pagerHtml);

                        const El = document.getElementById('lokerlistContainer');
                        El.scrollTo({top: 0});
                        // El.scrollTo({top: El.scrollHeight, behavior: 'smooth'});

                        if(res.data.count>0) {
                            $('#noResultContainer').hide();
                            $('#resultContainer').show();
                        }
                        else{
                            $('#noResultContainer').show();
                            $('#resultContainer').hide();
                        }

                        // swal.close()
                    }else{
                        swal({
                            title: "Gagal!",
                            text: "Gagal mendapatkan data dari server",
                            icon: "warning",
                            button: "Ok!",
                            type: "warning",
                        });
                    }

                    $('#lokerlistContainer').show();
                    $('#lokerlistloadingContainer').hide();
                },
                error: function (request, status, error) {
                    if(status == 'abort') return;

                    $('#lokerlistContainer').hide();
                    $('#lokerlistloadingContainer').hide();
                    $('#lokerdetailloadingContainer').hide();

                    $('#noResultContainer').hide();
                    $('#resultContainer').hide();

                    swal("Gagal!", "Gagal mendapatkan data dari server", "error");
                }
            });
        }

        $(document.body).on('change',"#cbPage",function (e) {
           var page = $("#cbPage option:selected").val();
           loadListLoker(parseInt(page));
        });

        function loadLoker(id, e){
            if(id==currentLokerId) return;

            if(isPhoneScreen) return;

            if(loadLokerXhr !== null) loadLokerXhr.abort();

            var url = "{{ route('daftarloker.show', ':id') }}"
            url = url.replace(':id', id);
            loadLokerXhr = $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    clearLokerdetailData();

                    $('#lokerdetailloadingContainer').show();
                },
                success: function(res) {
                    if(res.success){
                        let loker = res.data.data;

                        currentLokerId = loker.lokerid;

                        $(e).parents('.card').addClass("border border-info border-3");

                        $('#lokerPerusahaanNama').text(loker.perusahaan.nama);
                        $('#lokerJudul').text(loker.judul);
                        $('#lokerAlamat').text(loker.alamat);
                        $('#lokerProv').text((loker.prov ? loker.prov.namaprov : '-'));
                        $('#lokerKota').text((loker.kota ? loker.kota.namakota : '-'));
                        $('#lokerEmail').text(loker.email);
                        $('#lokerJobdesc').text(loker.jobdesc);
                        $('#lokerSyarat').text(loker.syarat);

                        let levelHtml = "";
                        loker.lokerlevelpekerjaan.forEach(function(level, idx) {
                            levelHtml += level.levelpekerjaanvw;
                            if (idx !== loker.lokerlevelpekerjaan.length - 1) levelHtml += ", ";
                        });
                        $('#lokerLevel').text(levelHtml);

                        let jenjangHtml = "";
                        loker.lokerjenjangpendidikan.forEach(function(jenjang, idx) {
                            jenjangHtml += jenjang.jenjangpendidikanvw;
                            if (idx !== loker.lokerjenjangpendidikan.length - 1) jenjangHtml += ", ";
                        });
                        $('#lokerJenjang').text(jenjangHtml);

                        let pengalamanHtml = "";
                        if(loker.ispengalaman){
                            pengalamanHtml += "Berpengalaman "+(loker.pengalamanvw ? "("+loker.pengalamanvw+")" : "");
                        }
                        if(loker.isfreshgraduate){
                            if(loker.ispengalaman) pengalamanHtml += ", ";
                            pengalamanHtml += "Baru Lulus";
                        }
                        $('#lokerPengalaman').text(pengalamanHtml);

                        let statusHtml = "";
                        loker.lokerstatuspekerjaan.forEach(function(status, idx) {
                            statusHtml += status.statuspekerjaanvw;
                            if (idx !== loker.lokerstatuspekerjaan.length - 1) statusHtml += ", ";
                        });
                        $('#lokerStatus').text(statusHtml);

                        let gajiHtml = "";
                        if(loker.isshowgaji=="1"){
                            gajiHtml += '<b>Dari </b>'+(loker.gajimin ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'IDR' }).format(loker.gajimin) : '-')+'&nbsp;&nbsp;';
                            gajiHtml += '<b>Sampai </b>'+(loker.gajimax ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'IDR' }).format(loker.gajimax) : '-');
                            $('#lokerDivGaji').show();
                        }else{
                            $('#lokerDivGaji').hide();
                        }
                        $('#lokerGaji').html(gajiHtml);

                        var linkDaftar = "{{ route('apply', ':id') }}"
                        linkDaftar = linkDaftar.replace(':id', currentLokerId);

                        $("#linkDaftar").attr("href", linkDaftar);

                        $('#lokerdetailContainer').show();

                        // swal.close()
                    }else{
                        swal({
                            title: "Gagal!",
                            text: "Gagal mendapatkan data dari server",
                            icon: "warning",
                            button: "Ok!",
                            type: "warning",
                        });
                    }

                    $('#lokerdetailloadingContainer').hide();
                },
                error: function (request, status, error) {
                    if(status == 'abort') return;

                    $('#lokerlistContainer').hide();
                    $('#lokerlistloadingContainer').hide();
                    $('#lokerdetailloadingContainer').hide();

                    $('#noResultContainer').hide();
                    $('#resultContainer').hide();

                    swal("Gagal!", "Gagal mendapatkan data dari server", "error");
                }
            });
        }

        function clearLokerdetailData(){
            currentLokerId = null;
            $('.loker-item').removeClass("border border-info border-3");

            $('#lokerdetailContainer').hide();
            $('#lokerdetailloadingContainer').hide();
            $('#lokerPerusahaanNama').empty();
            $('#lokerJudul').empty();
            $('#lokerAlamat').empty();
            $('#lokerProv').empty();
            $('#lokerKota').empty();
            $('#lokerEmail').empty();
            $('#lokerJobdesc').empty();
            $('#lokerSyarat').empty();
            $('#lokerLevel').empty();
            $('#lokerJenjang').empty();
            $('#lokerPengalaman').empty();
            $('#lokerStatus').empty();
            $('#lokerGaji').empty();
            $("#linkDaftar").attr("href", "#");
        }
    </script>
@endsection
