@extends('layouts.master-no-nav')

@section('content')
<!--<a href="javascript:;" class="text-white btn btn-block btn-danger"><h4 class="font-weight-bold">Anggaran Kas</h4></a>-->
<div class="row el-element-overlay">
    <div class="col-md-12">
        <h4 class="card-title">DAFTAR DASHBOARD</h4>
        <h6 class="card-subtitle m-b-20 text-muted">Pilih salah satu menu dashboard yang akan ditampilkan</h6>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-warning text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/01-rkas.png') }}" alt="RKAS" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">RKA-FKTP</h4>
                        <medium>Perbandingan Pagu Dana Kapitasi<br />dan Belanja Kapitasi</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-info text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/02-rkas-progres.png') }}" alt="Progres Entri RKAS" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Progres Entri RKA-FKTP</h4>
                        <medium>Kontrol Progres<br />Entri RKA-FKTP</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-danger text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/03-anggarankas.png') }}" alt="Anggaran Kas" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Anggaran Kas</h4>
                        <medium>Perbandingan<br />Data Anggaran Kas per Bulan</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-success text-white p-20">
                <div class="el-card-item text-center">
                <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/04-realisasi.png') }}" alt="Realisasi" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Realisasi</h4>
                        <medium>Perbandingan antara RKA-FKTP<br />dan Belanja Dana Kapitasi</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-purple text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/05-sptjm.png') }}" alt="Kontrol Data SPTJM" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Kontrol Data SPTJM</h4>
                        <medium>Kontrol Entri</br>Data SPTJM per FKTP</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-primary text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/06-kpj.png') }}" alt="Kontrol Pertanggungjawaban" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">KPJ</h4>
                        <medium>Kontrol Pertanggungjawaban<br />per FKTP</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-cyan text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/07-penggunaan-dana.png') }}" alt="Penggunaan Dana" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Penggunaan Dana</h4>
                        <medium>Laporan Penggunaan<br />Dana Kapitasi</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-warning text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/08-penyaluran.png') }}" alt="Penyaluran Dana Kapitasi" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Penyaluran Dana</h4>
                        <medium>Laporan Penyaluran<br />Dana Kapitasi</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-danger text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/09-saldokas.png') }}" alt="Saldo Kas" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Saldo Kas</h4>
                        <medium>Saldo Sisa<br />Dana Kapitasi per Bulan</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-success text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/10-aset.png') }}" alt="Aset BMD" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Aset BMD</h4>
                        <medium>Perbandingan Belanja Modal<br />dan Aset BMD</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-purple text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/11-aset-progres.png') }}" alt="Progres Entri Aset" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Progres Entri Aset BMD</h4>
                        <medium>Kontrol Progres<br />Entri Aset BMD</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="javascript:;">
            <div class="card bg-info text-white p-20">
                <div class="el-card-item text-center">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('/images/icon/12-pajak.png') }}" alt="Pajak Belanja Dana Kapitasi" style="height: 50px;" />
                    </div>
                    <div class="el-card-content p-t-10">
                        <h4 class="font-weight-bold">Pajak Belanja</h4>
                        <medium>Kontrol Potongan Pajak dan Setoran Pajak<br />untuk Belanja Dana Kapitasi</medium>
                        <br/> </div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
