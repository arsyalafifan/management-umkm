<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
@extends('layouts.login')
<style>

.hero-image {
  background-image: url("{{ asset('/images/news/login-bg-executive.png') }}");
  background-color: #cccccc;
  background-size: 60%;
  background-position: center center;
  background-repeat: no-repeat;
  /*background-size: auto;*/
  position: absolute;
}
</style>
@section('content')

<div class="card" style="height: 550px; background-color: transparent;">
    <div class="row">
        <div class="col-lg-3 col-md-4" style="height: 550px; background-color: #fff">
            <div class="card-body inbox-panel">
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
            <p id="message-alert" class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('executive.postlogin') }}">
                @csrf
                <h3 class="box-title m-t-0 m-b-0">Login - Eksekutif</h3><small>Masukkan username dan password yang valid untuk dapat mengakses sistem ini</small>
                <div class="form-group m-t-10">
                    <div class="col-xs-12">
                        <input id="login" type="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('username') }}" placeholder="{{ __('Username') }}" required autocomplete="off" autofocus>
                        @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="off">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <select id="thang" class="form-control @error('thang') is-invalid @enderror" name='thang' required>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($tahun as $item)
                            <option value="{{$item->tahun}}">{{$item->namatahun}}</option>
                            @endforeach
                        </select>

                        @error('thang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <select id="wilayahid" class="custom-select form-control @error('wilayahid') is-invalid @enderror" name='wilayahid' required>
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach ($wilayah as $item)
                            <option value="{{$item->wilayahkode}}" data-prov="{{$item->provid}}" data-kabkota="{{$item->kabkotaid}}"{{ ($item->wilayahkode == $wilayahid) ? ' selected' : '' }}>{{$item->wilayahkode . ' - ' . $item->wilayahnama}}</option>
                            @endforeach
                        </select>

                        @error('wilayahid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if ($isUseCaptcha)
                <div class="form-group">
                    <div class="col-xs-12 input-group captcha">
                        <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" name="captcha" placeholder="{{ __('Captcha') }}" required autocomplete="off">
                        <div class="input-group-append">
                            <span class="form-control input-group-text ml-3" id="span-captcha">
                                {!! captcha_img() !!}
                            </span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                &#x21bb;
                            </button>
                        </div>
                        @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input class="form-check-input custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label custom-control-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            @if (Route::has('password.request'))
                                <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password?') }}
                                </a> -->
                            @endif
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a> 
                        </div>     
                    </div>
                </div>
                <div class="form-group text-center m-t-10">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">{{ __('Log In') }}</button>
                    </div>
                </div>
            </form>
            <form class="form-horizontal" id="recoverform" action="index.html">
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Masukkan Email yang digunakan pada akun anda dan selanjutnya anda akan menerima pesan pada email anda tentang petunjuk untuk perubahan password! </p>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="Email">
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>
                <div class="text-dark" id="login-footer">
                    <div class="card-body">
                    © 2021 {{ config('app.name', '') }} by {{ apps::gettemplate($mode, 'comp_name') }}
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!--<div class="col-lg-9 col-md-8 border-left hero-image" style="height: 550px; background-color: rgb(0, 66, 116);">-->
        <div class="col-lg-9 col-md-8 border-left hero-image" style="height: 550px; background-color: transparent;">
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        @if (count($errors) > 0)
        $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-danger").slideUp(500);
        });
        @endif

        @if (session()->has('message'))
        $("#message-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#message-alert").slideUp(500);
        });
        @endif

        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Isi field ini terlebih dahulu");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
        elements = document.getElementsByTagName("SELECT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Pilih salah satu item pada list");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }

        $("#thang").keydown(function(e){
            if (e.keyCode == 13) {
                $("#loginform").submit();
            }
        });

        $("#wilayahid").keydown(function(e){
            if (e.keyCode == 13) {
                $("#loginform").submit();
            }
        });

        @if ($isUseCaptcha)
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ route("reloadcaptcha") }}',
                success: function (data) {
                    $("#span-captcha").html(data.captcha);
                }
            });
        });
        @endif
        
        $('#login-footer').css('top', $('#login-box').height() + "px");
        //$('.login-register').height($('#login-box').height() + 50);
    });
</script>
@endsection