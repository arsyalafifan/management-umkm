<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<!-- ============================================================== -->
<!-- Info box -->
<!-- ============================================================== -->
<!-- .row -->
<!-- /.row -->
<!-- ============================================================== -->
<!-- End Info box -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Over Visitor, Our income , slaes different and  sales prediction -->
<!-- ============================================================== -->
<!-- .row -->
<!-- /.row -->

{{-- <div class="row">
    <!-- Column -->
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <img class="img-responsive" src="{{ asset('/images/news/business-management.png') }}">
        </div>

        <div class="card">
            <img class="img-responsive" src="{{ asset('/images/news/image1.jpg') }}">
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body collapse show">
                <h3 class="card-title">Selamat Datang</h4>
                <p class="card-text font-weight-bold text-justify" style="height:380px;">{{ config('app.name', '-') }}</p>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-4 col-md-12">
        <div class="row">
            <!-- Column -->
            <div class="col-md-12">
                <div class="card bg-info text-white">
                    <div class="card-body ">
                        <div class="row weather">
                            <div class="col-8">
                                <div class="display-6" id="d_time">73<sup>°F</sup></div>
                                <p class="text-white">Kota Batam</p>
                            </div>
                            <div class="col-4 text-right">
                                <h1 class="m-b-"><i class="fa fa-clock-o"></i></h1>
                                <b class="text-white" id="d_day">SUNNEY DAY</b>
                                <p class="op-5" id="d_fulldate">April 14</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-12">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <div id="myCarouse2" class="carousel slide" data-ride="carousel">
                            <div class="active carousel-item">
                                <h6 style="height:50px;">{{ config('app.name', '-') }}</h6>
                                <div class="d-flex no-block">
                                    <span class="m-l-5">
                                    <div class="text-white m-b-0">Tim {{ config('app.name', '-') }}</div>
                                    <div class="text-white"></div>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <h6 style="height:50px;">{{ config('app.name', '-') }}</h6>
                                <div class="d-flex no-block">
                                    <span class="m-l-5">
                                    <div class="text-white m-b-0">Tim {{ config('app.name', '-') }}</div>
                                    <div class="text-white"></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-12">
                <div class="card bg-danger text-white">
                    <div class="card-body ">
                        <div class="row weather">
                            <div class="col-12 text-center">
                                <div class="display-5">{{ strtoupper(apps::gettemplate($mode, 'app_alias2')) }}</div>
                                <h2 class="text-white"></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>
</div> --}}


<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

{{-- <script>
    let myScript = document.createElement("script");
    myScript.setAttribute("src", "{{ asset('/default/dist/js/dashboard1.js') }}");
    document.body.appendChild(myScript);

    var ctxPie = document.getElementById('pieChart').getContext('2d');
    var ctxBar = document.getElementById('barChart').getContext('2d');
    var ctxLine = document.getElementById('lineChart').getContext('2d');

    var dataPie = {
        labels: [
            @foreach ($jumlahnakerbyjk as $item)
            "{{ $item->jenisvw }}",
            @endforeach
        ],
        datasets: [{
            label: "",
            backgroundColor: [
                @foreach ($jumlahnakerbyjk as $item)
                    @if($item->jeniskelamin==enum::JENISKELAMIN_LAKILAKI)
                    "#3ba3e8",
                    @elseif($item->jeniskelamin==enum::JENISKELAMIN_PEREMPUAN)
                    '#fc6485',
                    @endif
                @endforeach
            ],
            borderColor: 'rgb(255, 255, 255)',
            data: [
                @foreach ($jumlahnakerbyjk as $item)
                {{ $item->jumlah }},
                @endforeach
            ],
        }]
    };
    
    var dataBar = {
        labels: [
            @foreach ($jumlahnakerbykecbyjk as $item)
            "{{ $item->namakec }}",
            @endforeach
        ],
        datasets: [
            {
                label: "Perempuan",
                backgroundColor: '#fc6485',
                data: [
                    @foreach ($jumlahnakerbykecbyjk as $item)
                    {{ $item->jumlahperempuan }},
                    @endforeach
                ]
            },
            {
                label: "Laki-Laki",
                backgroundColor: '#3ba3e8',
                data: [
                    @foreach ($jumlahnakerbykecbyjk as $item)
                    {{ $item->jumlahlaki }},
                    @endforeach
                ]
            },
        ]
    };

    var dataLine = {
        labels: [
            @foreach ($jumlahnakerbybulanbystatus as $item)
            "{{ $item->bulanvw }}",
            @endforeach
        ],
        datasets: [
            {
                label: "Belum Bekerja",
                borderColor: '#fc6485',
                backgroundColor: 'rgba(0,0,0,0.0)',
                data: [
                    @foreach ($jumlahnakerbybulanbystatus as $item)
                    {{ $item->belumbekerja }},
                    @endforeach
                ]
            },
            {
                label: "Sedang Bekerja",
                borderColor: '#3ba3e8',
                backgroundColor: 'rgba(0,0,0,0.0)',
                data: [
                    @foreach ($jumlahnakerbybulanbystatus as $item)
                    {{ $item->sedangbekerja }},
                    @endforeach
                ]
            },
        ]
    };

    var pieChart = new Chart(ctxPie,{
        type: 'pie',
        data: dataPie,
        options: { responsive: false}
    });

    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: dataBar,
        options: {
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        // OR //
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
            },
            maintainAspectRatio: false,
        }
    });

    var lineChart = new Chart(ctxLine, {
        type: 'line',
        data: dataLine,
        options: {
            maintainAspectRatio: false,
            elements: {
                line: {
                    tension: 0, // disables bezier curves
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        // OR //
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
            },
        }
    });

    function filter(){
        window.location.href = window.location.pathname+"?"+$.param({'tahun': $("#tahun").val()})
    }
</script> --}}
@endsection
