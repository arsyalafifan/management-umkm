@extends('layouts.landing')

@section('content')

    <section class="page-section">
        <div class="container ">
            <div class="row" style="height: 80vh;">
                <div class="col d-flex">
                    <div class="row justify-content-center align-self-center p-5 border border-dark">
                        <h1 class="py-2 fw-normal">Sudah punya akun tapi belum punya sandi ?</h1>
                        <a class="btn btn-primary btn-xl text-uppercase text-dark" href="{{route('requestsandi.index')}}"><h2>REQUEST SANDI</h2></a>
                    </div>
                </div>
                <div class="col" style="background-image: url('{{asset('dist/landing/assets/img/ONZFBE0.png')}}');background-position: center;background-size: cover;background-repeat: no-repeat;"></div>
            </div>
        </div>
    </section>
    
    <section class="page-section bg-light" >
        <div class="container">
            <div class="text-left">
                <h3 class="section-heading text-uppercase">Dinas Tenaga Kerja</h3>
                <p><b>KOTA BATAM</b></p>
                <p>Jl. Kartini I No.29-30, Sungai Harapan, Kec. Sekupang, Kota Batam, Kepulauan Riau 29422</p>
                <dt>Telp:</dt>
                <dd><p>(0778) 327601</p></dd><br>
                <a href="https://www.freepik.com/vectors/coloured-background">Vector by www.freepik.com</a>
            </div>
            
        </div>
    </section>

        
    <script type="text/javascript">
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
        });
    </script>

@endsection