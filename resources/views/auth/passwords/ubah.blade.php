<?php
   use App\apptemplate as apps;
   $mode = config('app.app_mode', '-');
?>
@extends('layouts.login')

@section('content')
<div class="container" >
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('forceubahpassword.save') }}">
                        @csrf
                        <h5 class="card-title text-center mb-5">Silahkan ganti sandi (password) akun anda, sebelum ke Menu Utama</h5>

                        <label for="password" class="card-text">Silahkan input sandi yang Anda dapatkan dari email Anda di {{$email}} pada sandi saat ini.</label>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Sandi saat ini*:') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <label for="password" class="card-text">Silahkan input sandi Anda yang terdiri dari huruf kapital, angka (0-9), serta symbol(~!?><#$, dll)</label>
                        <div class="form-group row">
                            <label for="newpassword" class="col-md-4 col-form-label text-md-left">{{ __('Sandi baru*:') }}</label>

                            <div class="col-md-8">
                                <input id="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror" name="newpassword" value="{{ old('newpassword') }}" required>

                                @error('newpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <label for="password" class="card-text">Silahkan input ulang sandi Anda yang sama dengan sandi baru Anda.</label>
                        <div class="form-group row">
                            <label for="newpassword_confirmation" class="col-md-4 col-form-label text-md-left">{{ __('Ulang sandi baru*:') }}</label>

                            <div class="col-md-8">
                                <input id="newpassword_confirmation" type="password" class="form-control" name="newpassword_confirmation" value="{{ old('newpassword_confirmation') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('UBAH SANDI') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
