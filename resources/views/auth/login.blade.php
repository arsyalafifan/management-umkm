<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
@extends('layouts.login')
<style>

.hero-image {
  background-image: url("{{ asset('/images/news/login-bg.png') }}");
  background-color: #cccccc;
  background-size: 80%;
  background-position: center center;
  background-repeat: no-repeat;
  position: absolute;
}
</style>

{{-- <style>
    /* * { box-sizing:border-box; } */

    /* body {
        font-family: Helvetica;
        background: #eee;
    -webkit-font-smoothing: antialiased;
    } */

    hgroup { 
        text-align:center;
        margin-top: 4em;
    }

    .box-title{
        margin-bottom: 2rem;
    }

    /* h1, h3 { font-weight: 300; }

    h1 { color: #636363; }

    h3 { color: #4a89dc; } */

    /* form {
        width: 380px;
        margin: 4em auto;
        padding: 3em 2em 2em 2em;
        background: #fafafa;
        border: 1px solid #ebebeb;
        box-shadow: rgba(0,0,0,0.14902) 0px 1px 1px 0px,rgba(0,0,0,0.09804) 0px 1px 2px 0px;
    } */

    .group { 
        position: relative; 
        margin-bottom: 45px; 
    }

    input {
        font-size: 18px;
        padding: 10px 10px 10px 5px;
        -webkit-appearance: none;
        display: block;
        /* background: #fafafa; */
        color: #636363;
        width: 100%;
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #757575;
    }

    input:focus { outline: none; }


    /* Label */

    label {
        color: #999; 
        font-size: 18px;
        font-weight: normal;
        position: absolute;
        pointer-events: none;
        left: 5px;
        top: 10px;
        transition: all 0.2s ease;
    }


    /* active */

    input:focus ~ label, input.used ~ label {
        top: -20px;
    transform: scale(.75); left: -2px;
        /* font-size: 14px; */
        color: #4a89dc;
    }


    /* Underline */

    .bar {
        position: relative;
        display: block;
        width: 100%;
    }

    .bar:before, .bar:after {
        content: '';
        height: 2px; 
        width: 0;
        bottom: 1px; 
        position: absolute;
        background: #4a89dc; 
        transition: all 0.2s ease;
    }

    .bar:before { left: 50%; }

    .bar:after { right: 50%; }


    /* active */

    input:focus ~ .bar:before, input:focus ~ .bar:after { width: 50%; }


    /* Highlight */

    .highlight {
        position: absolute;
        height: 60%; 
        width: 100px; 
        top: 25%; 
        left: 0;
        pointer-events: none;
        opacity: 0.5;
    }


    /* active */

    input:focus ~ .highlight {
        animation: inputHighlighter 0.3s ease;
    }


    /* Animations */

    @keyframes inputHighlighter {
        from { background: #4a89dc; }
        to 	{ width: 0; background: transparent; }
    }


    /* Button */

    .button {
    position: relative;
    display: inline-block;
    padding: 12px 24px;
    margin: .3em 0 1em 0;
    width: 100%;
    vertical-align: middle;
    color: #fff;
    font-size: 16px;
    line-height: 20px;
    -webkit-font-smoothing: antialiased;
    text-align: center;
    letter-spacing: 1px;
    background: transparent;
    border: 0;
    border-bottom: 2px solid #3160B6;
    cursor: pointer;
    transition: all 0.15s ease;
    }
    .button:focus { outline: 0; }


    /* Button modifiers */

    .buttonBlue {
    background: #4a89dc;
    text-shadow: 1px 1px 0 rgba(39, 110, 204, .5);
    }

    .buttonBlue:hover { background: #357bd8; }


    /* Ripples container */

    .ripples {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: transparent;
    }


    /* Ripples circle */

    .ripplesCircle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.25);
    }

    .ripples.is-active .ripplesCircle {
    animation: ripples .4s ease-in;
    }


    /* Ripples animation */

    @keyframes ripples {
    0% { opacity: 0; }

    25% { opacity: 1; }

    100% {
        width: 200%;
        padding-bottom: 200%;
        opacity: 0;
    }
    }

    footer { text-align: center; }

    footer p {
        color: #888;
        font-size: 13px;
        letter-spacing: .4px;
    }

    footer a {
        color: #4a89dc;
        text-decoration: none;
        transition: all .2s ease;
    }

    footer a:hover {
        color: #666;
        text-decoration: underline;
    }

    footer img {
        width: 80px;
        transition: all .2s ease;
    }

    footer img:hover { opacity: .83; }

    footer img:focus , footer a:focus { outline: none; }

</style> --}}
@section('content')

    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
                @endif
                <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="m-b-20 text-center">Login</h2>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input placeholder="Username" type="text" id="login" type="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('username') }}" required autocomplete="off" autofocus><span class="highlight"></span><span class="bar"></span>
                            @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input placeholder="Password" type="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off"><span class="highlight"></span><span class="bar"></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- <input class="form-control" type="password" required="" placeholder="Password"> --}}
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-xs-12">
                            <select id="thang" class="form-control @error('thang') is-invalid @enderror" name='thang'>
                                <option value="">-- Pilih Tahun --</option>
                                <option value="2023" selected>2023</option>
                            </select>
    
                            @error('thang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">{{ __('Log In') }}</button>
                        </div>
                    </div>
                </form>
                {{-- <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
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
                </form> --}}
            </div>
        </div>
    </section>

    {{-- <div class="card" style="height: 100vh; background-color: transparent; align-items:center;justify-content:center;">
            <div class="col-lg-3 col-md-4" style="height: 100vh; background-color: #fff">
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
    
                <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="box-title m-t-0 m-b-2">Login</h3>
                    <div class="group">
                        <input type="text" id="login" type="login" class="@error('login') is-invalid @enderror" name="login" value="{{ old('username') }}" required autocomplete="off" autofocus><span class="highlight"></span><span class="bar"></span>
                        <label>Username</label>
                        @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="group">
                        <input type="password" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="off"><span class="highlight"></span><span class="bar"></span>
                        <label>Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <select id="thang" class="form-control @error('thang') is-invalid @enderror" name='thang'>
                                <option value="">-- Pilih Tahun --</option>
                                <option value="2023">2023</option>
                            </select>
    
                            @error('thang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input class="form-check-input custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label custom-control-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
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
                </div>
            </div>
    </div> --}}
{{-- <script>
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

        @if (session()->has('status'))
        $("#message-alert").fadeTo(2000, 500);
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

        @error('email')
        $("#loginform").hide();
        $("#recoverform").show();
        @enderror

        $("#recoverform").submit(function () {
            $("#resetbutton").attr("disabled", true);
            return true;
        });
    });
</script> --}}

{{-- <script>
    // show error lgoin validation
    $(document).on('submit', '#loginform', (e) => {
        e.preventDefault();
        
        let formData = new FormData($('#loginform')[0]);

        let url = "{{ route('login') }}"

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

                if (success == 'false' || success == false) {
                    swal.fire("Gagal Login!", "Username dan atau password yang anda masukkan tidak valid.", "error"); 
                }
                else{
                    swal.fire("Error!", data, "error"); 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    var data = jqXHR.responseJSON;
                    console.log(data.errors);// this will be the error bag.
                    printErrorMsg(data.errors);
                }
        })
    })
</script> --}}

<script>
    $(window, document, undefined).ready(function() {

    $('input').blur(function() {
    var $this = $(this);
    if ($this.val())
        $this.addClass('used');
    else
        $this.removeClass('used');
    });

    var $ripples = $('.ripples');

    $ripples.on('click.Ripples', function(e) {

    var $this = $(this);
    var $offset = $this.parent().offset();
    var $circle = $this.find('.ripplesCircle');

    var x = e.pageX - $offset.left;
    var y = e.pageY - $offset.top;

    $circle.css({
        top: y + 'px',
        left: x + 'px'
    });

    $this.addClass('is-active');

    });

    $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
        $(this).removeClass('is-active');
    });

});
</script>

<!-- jQuery -->
<script src="{{asset('/dist/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('bootstrap/dist/js/tether.min.js')}}"></script>
<script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js')}}"></script>
<!--slimscroll JavaScript -->
<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('js/waves.js')}}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{asset('js/custom.min.js')}}"></script>
<!--Style Switcher -->
<script src="{{asset('/dist/plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>
@endsection