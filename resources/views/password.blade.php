@extends('layouts.master')
@php
//dd($user);
//dd(session()->all());
@endphp
@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30"> <img src="{{ asset('/1.jpg') }}" class="img-circle" width="150" />
                    <h4 class="card-title m-t-10">{{ $user->nama }}</h4>
                    @if ($user->akses->grup === Config::get('constants.grup.grup_superadmin'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_superadmin') }}</h6>
                    @elseif ($user->akses->grup === Config::get('constants.grup.grup_admin'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_admin') }}</h6>
                    @elseif ($user->akses->grup === Config::get('constants.grup.grup_hr'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_hr') }}</h6>
                    @elseif ($user->akses->grup === Config::get('constants.grup.grup_naker'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_naker') }}</h6>
                    @elseif ($user->akses->grup === Config::get('constants.grup.grup_eksekutif'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_eksekutif') }}</h6>
                    @elseif ($user->akses->grup === Config::get('constants.grup.grup_auditor'))
                    <h6 class="card-subtitle">Level : {{ Config::get('constants.grupnama.grupnama_auditor') }}</h6>
                    @endif
                    <div class="row text-center justify-content-md-center">
                        @if ($user->isaktif == '1')
                        <div class="col-4 text-success"><i class="icon-people"></i> <font class="font-medium">Aktif</font></div>
                        @else
                        <div class="col-4 text-danger"><i class="icon-picture"></i> <font class="font-medium">Tidak Aktif</font></div>
                        @endif
                    </div>
                </center>
            </div>
            <div>
                <hr> </div>
            <div class="card-body">
                <small class="text-muted">Username </small> <h6>{{ $user->login }}</h6>
                <!-- <small class="text-muted">Email </small> <h6>{{ $user->email }}</h6> -->
                <!-- <small class="text-muted p-t-30 db">Nomor HP</small> <h6>{{ $user->hp }}</h6> -->
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Ubah Password</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="card-body">
                        <h5>Untuk melakukan perubahan password, silakan masukkan password lama terlebih dahulu</h5>
                        <hr />
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
                            <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </p>
                        @endif

                        <form id="user-form" class="form-horizontal form-material" method="POST" action="{{ route('user.password') }}">
                        @csrf
                            <div class="form-group m-t-40 m-t-40">
                                <label for="password" class="col-md-12">Password Lama</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="" class="form-control form-control-line @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('password') }}" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newpassword" class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="" class="form-control form-control-line @error('newpassword') is-invalid @enderror" name="newpassword" id="newpassword" value="{{ old('newpassword') }}" required>

                                    @error('newpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newpassword_confirmation" class="col-md-12">Ulangi Password</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="" class="form-control form-control-line" name="newpassword_confirmation" id="newpassword_confirmation" value="{{ old('newpassword_confirmation') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                                        {{ __('Simpan') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Row -->
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

@endsection
