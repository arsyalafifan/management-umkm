<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
@extends('layouts.master')

@section('content')
<div class="row">
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
</div>
    <!-- Column -->
    

<script>
	startTime();
	
	function startTime() {
	    var today = new Date();
	    var h = today.getHours();
	    var m = today.getMinutes();
	    var s = today.getSeconds();
	    h = checkTime(h);
	    m = checkTime(m);
	    s = checkTime(s);
	    document.getElementById('d_time').innerHTML =
	    h + ":" + m + ":" + s;
	    var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
		document.getElementById("d_day").innerHTML = days[today.getDay()];
	    var months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agus", "Sep", "Okt", "Nov", "Des"];
		document.getElementById("d_fulldate").innerHTML = today.getDate() +' '+ months[today.getMonth()] +' '+ today.getFullYear();
	    var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
	    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	    return i;
	}

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
        @if (session()->has('error'))
        swal({
            title: "",
            text: "{{ session('error') }}",
            icon: "error",
            button: "Ok!",
            type: "error",
        });
        @endif
        @if (session()->has('status'))
        swal({
            title: "",
            text: "{{ session('status') }}",
            icon: "success",
            button: "Ok!",
            type: "success",
        });
        @endif
    });
</script>
@endsection
