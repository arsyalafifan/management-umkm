@extends('layouts.landing', ['p_nav_bg_color' => '#077fd5'])

@section('content')

    <section class="page-section mt-5">
        <div class="container">
            @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
            @endif

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('requestsandi.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" onSubmit="document.getElementById('submit').disabled=true;">
                @csrf

                <div class="form-group row my-2">
                    <label for="email" class="col-md-2 col-form-label text-md-left">{{ __('Email *') }}</label>

                    <div class="col-md-8">
                        <input type="hidden" name="isverified" id="isverified" value="{{ old('isverified', '0') }}">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="name" required> 

                        @error('email')
                            {{-- <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> --}}
                        @enderror
                        <small id="emailHelp" class="form-text text-muted">
                            <span>Status : 
                                @if(old('isverified', '0')=='0')
                                <b id="statusEmail" style="color: red">Email belum terverifikasi</b>
                                @endif
                                @if(old('isverified', '0')=='1')
                                <b id="statusEmail" style="color: green">Email berhasil diverifikasi</b>
                                @endif
                            </span>
                        </small>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning btn-block waves-effect waves-light m-r-10" onclick="validasiEmail();">
                            {{ __('Verifikasi') }}
                        </button>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="norequest" class="col-md-2 col-form-label text-md-left">{{ __('Kode Request *') }}</label>

                    <div class="col-md-3">
                        <input id="norequest" type="text" class="form-control @error('norequest') is-invalid @enderror" name="norequest" value="{{ old('norequest') }}" required autocomplete="name" readonly="">

                        @error('norequest')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-7">
                        <input id="textrequest" type="text" class="form-control @error('textrequest') is-invalid @enderror" name="textrequest" value="{{ old('textrequest') }}" required autocomplete="name" readonly="">

                        @error('textrequest')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="instansi" class="col-md-2 col-form-label text-md-left">{{ __('Instansi *') }}</label>

                    <div class="col-md-10">
                        <select id="instansi" class="custom-select form-control @error('instansi') is-invalid @enderror" name='instansi' autofocus required>
                            <option value="" selected>-- Pilih Instansi --</option>
                            <option @if (old("instansi")===strval(0)) selected @endif value="0">{{ 'Perusahaan' }}</option>
                            <option @if (old("instansi")===strval(1)) selected @endif value="1">{{ 'Tenaga Kerja' }}</option>
                        </select>

                        @error('instansi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-md-2"></div>
                    <label for="akun" class="col-md-8 col-form-label text-md-left" id="labelAkun"></label>
                </div>

                <div class="form-group row my-2">
                    <label for="akun" class="col-md-2 col-form-label text-md-left">{{ __('Akun *') }}</label>

                    <div class="col-md-10" id="divNib" style="display: none;">
                        <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" name="nib" value="{{ old('nib') }}" autocomplete="name" >

                        @error('nib')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-10" id="divNik" style="display: none;">
                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" autocomplete="name" >

                        @error('nik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row my-2" id="divFotoktp" style="display: none;">
                    <label for="fotoktp" class="col-md-2 col-form-label text-md-left">{{ __('Foto KTP *') }}</label>
                    <div class="col-md-10">
                        <input name="fotoktp" class="form-control @error('fotoktp') is-invalid @enderror" type="file" id="fotoktp">

                        @error('fotoktp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row my-2" id="divNoakte" style="display: none;">
                    <label for="noakte" class="col-md-2 col-form-label text-md-left">{{ __('No. Akte Pendirian Perusahaan*') }}</label>

                    <div class="col-md-10">
                        <input id="noakte" type="text" class="form-control @error('noakte') is-invalid @enderror" name="noakte" value="{{ old('noakte') }}" autocomplete="name" >

                        @error('noakte')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="col-xs-12 input-group captcha">
                            <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" name="captcha" placeholder="{{ __('Captcha') }}" required autocomplete="off">
                            <!-- <div class="input-group-append"> -->
                                <span class="input-group-text" id="span-captcha">
                                    {!! captcha_img('flat') !!}
                                </span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            <!-- </div> -->
                            @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" id="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Kirim Request') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>        
        
    {{-- modal verifikasi --}}
    <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Email</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- <span style="text-align:justify">Klik tombol Kirim Kode untuk mengirim kode verifikasi ke e-mail anda.
                        Setelah itu, silahkan cek e-mail (cek folder spam jika tidak ditemukan), lalu masukkan kode yang telah dikirim ke e-mail anda ke kolom kode
                        verifikasi di bawah.</span> -->

                    <form>
                        <div class="form-group">
                            <label for="email-kode" class="col-form-label">Email:</label>
                            <div class="row">
                                <div class="col-md-7"><input
                                        onkeyup="this.value = this.value.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '')"
                                        type="email" class="form-control" id="email-kode" name="email-kode" readonly>
                                </div>
                                <div class="col-md-5"><button type="button" class="btn btn-success btn-kode"
                                        style="width: 100%">REQUEST PIN</button></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kode-text" class="col-form-label">PIN:</label>
                            <input onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')"
                                onkeyup="this.value = this.value.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '')"
                                type="text" class="form-control" id="kode-text" name="kode-text">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="verifikasikode()">Verifikasi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
       
    <script type="text/javascript">

        $(document).ready(function() {

            $.ajax({
                url: "{{ route('requestsandi.nextno') }}",
                type:'GET',
                success:function(data) {
                    $('#norequest').val(data.no);
                    $('#textrequest').val(data.text);
                }
            });

            if('{{ old("instansi", "") }}'!=''){
                setShowHideInput('{{ old("instansi") }}');
            }
        });

        function setShowHideInput(value){
            let labelAkun = "";
            if(value=="0") {
                labelAkun = "Silakan masukkan NIB Perusahaan";
                $("#divFotoktp").hide();
                $('#fotoktp').removeAttr("required");$("#fotoktp").val(null);
                $("#divNoakte").show();
                $("#noakte").attr("required","");
                $("#divNib").show();
                $("#nib").attr("required","");
                $("#divNik").hide();
                $('#nik').removeAttr("required");$("#nik").val(null);
            }
            else if(value=="1") {
                labelAkun= "Silakan masukkan NIK Anda";
                $("#divFotoktp").show();
                $("#fotoktp").attr("required","");
                $("#divNoakte").hide();
                $('#noakte').removeAttr("required");$("#noakte").val(null);
                $("#divNib").hide();
                $('#nib').removeAttr("required");$("#nib").val(null);
                $("#divNik").show();
                $("#nik").attr("required","");
            }

            $("#labelAkun").text(labelAkun);
        }

        $('#instansi').on('change', function() {
            setShowHideInput($(this).val());
        });

        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ route("requestsandi.reloadcaptcha") }}',
                success: function (data) {
                    $("#span-captcha").html(data.captcha);
                }
            });
        });

        function validasiEmail() {
            var email = $("input[name=email]").val();
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                if (email) {
                    $('#verifikasiModal').modal('show');
                } else {
                    swal({
                        title: "Validasi email",
                        text: "Format email yang dimasukkan salah. Contoh format email: namaemail@domain.com",
                        icon: "warning",
                        button: "Ok!",
                        type: "warning",
                    });
                }
            } else {
                swal({
                    title: "Validasi email",
                    text: "Format email yang dimasukkan salah. Contoh format email: namaemail@domain.com",
                    icon: "warning",
                    button: "Ok!",
                    type: "warning",
                });
            }
        }

        $('#verifikasiModal').on('show.bs.modal', function(event) {
            var email = $("input[name=email]").val();
            var modal = $(this)

            modal.find('.modal-title').text('Verifikasi Email')
            modal.find('.modal-body input[name=email-kode]').val(email)
        })

        $(".btn-kode").click(function(e) {
            e.preventDefault();
            var email = $("input[name=email-kode]").val();

            $.ajax({
                type: 'POST',
                url: `{{ route('requestsandi.sendmailkodeverifikasi') }}`,
                data: {
                    "_token": "{{ csrf_token() }}",
                    email: email
                },
                beforeSend: function() {
                    swal({
                        title: `Mohon tunggu`,
                        text: "Sedang memproses email",
                        icon: "warning",
                        buttons: false,
                        type: "info",
                        closeOnClickOutside: false,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(data) {
                    localStorage.setItem('dataKode', data)
                    if (data == 'email sudah digunakan') {
                        swal({
                            title: "Gagal!",
                            text: "E-mail address sudah digunakan oleh pengguna lain, silakan gunakan alamat email lain...",
                            icon: "warning",
                            button: "Ok!",
                            type: "warning",
                        });
                        return;
                    }

                    swal({
                        title: `Kode verifikasi email telah berhasil dikirim ke email id anda : ${email}.`,
                        text: "Silakan buka email anda, dan masukkan kode verifikasi yang anda terima pada e-mail ke dalam kolom yang disediakan",
                        icon: "success",
                        button: "Ok!",
                        type: "success",
                    });
                }
            });
        });

        function verifikasikode() {
            var data = localStorage.getItem('dataKode');
            var kode = $("input[name=kode-text]").val();

            $.ajax({
                type: 'POST',
                url: `{{ route('requestsandi.verifikasikode') }}`,
                data: {
                    "_token": "{{ csrf_token() }}",
                    kode: kode,
                    data: data
                },
                beforeSend: function() {
                    swal({
                        title: `Mohon tunggu`,
                        text: "Sedang memproses verifikasi",
                        icon: "warning",
                        buttons: false,
                        type: "info",
                    });
                },
                success: function(data) {
                    if (data == true) {
                        swal({
                            title: "Berhasil!",
                            text: "Email anda telah diverifikasi!",
                            icon: "success",
                            button: "Ok!",
                            type: "success",
                        }, function(){   
                            $('#verifikasiModal').modal('hide');
                            $('#statusEmail').text('Email berhasil diverifikasi');
                            $('#statusEmail').css('color', 'green');
                            $('#isverified').val('1');
                        });
                    } else {
                        swal({
                            title: "Gagal!",
                            text: "Email gagal diverifikasi!",
                            icon: "warning",
                            button: "Coba lagi!",
                            type: "warning",
                        }, function() {
                            $('#statusEmail').text('Email belum terverifikasi');
                            $('#statusEmail').css('color', 'red');
                            $('#isverified').val('0');
                        });
                    }
                }
            });


        }

    </script>

@endsection