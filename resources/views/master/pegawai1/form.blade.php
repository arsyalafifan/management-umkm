<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<style>
    input[disabled]{
      background-color:#ddd !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($pegawai->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
        @if($isshow)
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                <a href="{{ route('pegawai.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                <a href="{{ route('pegawai.edit', $pegawai->pegawaiid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>
        @endif
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

            <form method="POST" action="{{ $pegawai->exists ? route('pegawai.update', $pegawai->pegawaiid) : route('pegawai.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                @if($pegawai->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="pegawaiid" id="pegawaiid" value="{{ $pegawai->exists ? $pegawai->pegawaiid : '' }}">

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama *') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $pegawai->nama) }}" required autocomplete="name" @if($isshow) disabled @endif>

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nip" class="col-md-12 col-form-label text-md-left">{{ __('NIP *') }}</label>

                    <div class="col-md-12">
                        <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $pegawai->nip) }}" required autocomplete="name" @if($isshow) disabled @endif>

                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan" class="col-md-12 col-form-label text-md-left">{{ __('Jabatan') }}</label>

                    <div class="col-md-12">
                        <select id="jabatan" class="custom-select form-control @error('jabatan') is-invalid @enderror" name='jabatan' autofocus @if($isshow) disabled @endif>
                            <option value="" selected>-- Pilih Jabatan --</option>
                            @foreach ($listjabatan as $item)
                            <option @if (old("jabatan", $pegawai->jabatan)===strval($item['jabatan'])) selected @endif value="{{$item['jabatan']}}">{{ $item['jabatanvw'] }}</option>
                            @endforeach
                        </select>

                        @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pangkat" class="col-md-12 col-form-label text-md-left">{{ __('Pangkat') }}</label>

                    <div class="col-md-12">
                        <input id="pangkat" type="text" class="form-control @error('pangkat') is-invalid @enderror" name="pangkat" value="{{ old('pangkat', $pegawai->pangkat) }}" autocomplete="name" @if($isshow) disabled @endif>

                        @error('pangkat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email *') }}</label>

                    <div class="col-md-10">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $pegawai->email) }}" autocomplete="name" @if($isshow) disabled @endif> 

                        @error('email')
                            {{-- <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> --}}
                        @enderror
                        <small id="emailHelp" class="form-text text-muted">
                            <span>Status : 
                                @if(!$pegawai->exists || ($pegawai->exists && !$pegawai->isverified))
                                <b id="statusEmail" style="color: red">Email belum terverifikasi</b>
                                @endif
                                @if($pegawai->exists && $pegawai->isverified)
                                <b id="statusEmail" style="color: green">Email berhasil diverifikasi</b>
                                @endif
                            </span>
                        </small>
                    </div>
                    @if(!$isshow)
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning btn-block waves-effect waves-light m-r-10" onclick="validasiEmail();">
                            {{ __('Verifikasi') }}
                        </button>
                    </div>
                    @endif
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-12 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1" @if (old("status", $pegawai->status)=="1" || !$pegawai->exists) checked @endif @if($isshow) onclick="return false;" @endif>
                            <label class="custom-control-label" for="status">Aktif</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Pegawai') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal verifikasi --}}
<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span style="text-align:justify">Klik tombol Kirim Kode untuk mengirim kode verifikasi ke e-mail anda.
                    Setelah itu, silahkan cek e-mail (cek folder spam jika tidak ditemukan), lalu masukkan kode yang telah dikirim ke e-mail anda ke kolom kode
                    verifikasi di bawah.</span>

                <form>
                    <div class="form-group">
                        <label for="email-kode" class="col-form-label">email:</label>
                        <div class="row">
                            <input type="hidden" class="form-control" id="nipEmail" name="nipEmail">
                            <div class="col-md-7"><input
                                    onkeyup="this.value = this.value.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '')"
                                    type="email" class="form-control" id="email-kode" name="email-kode" readonly>
                            </div>
                            <div class="col-md-5"><button type="button" class="btn btn-success btn-kode"
                                    style="width: 100%">kirim kode</button></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kode-text" class="col-form-label">kode:</label>
                        <input onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')"
                            onkeyup="this.value = this.value.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '')"
                            type="text" class="form-control" id="kode-text" name="kode-text">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="verifikasikode()">Verifikasi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();
    });

    @if(!$isshow)
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
        var nip = $("input[name=nip]").val();
        var modal = $(this)

        $("input[name=nipEmail]").val(nip);
        modal.find('.modal-title').text('Verifikasi Email')
        modal.find('.modal-body input[name=email-kode]').val(email)
    })

    $(".btn-kode").click(function(e) {
        e.preventDefault();
        var nip = $("input[name=nipEmail]").val();
        var email = $("input[name=email-kode]").val();

        $.ajax({
            type: 'POST',
            url: `{{ route('pegawai.sendmail') }}`,
            data: {
                "_token": "{{ csrf_token() }}",
                email: email,
                nip: nip
            },
            beforeSend: function() {
                swal({
                    title: `Mohon tunggu`,
                    text: "Sedang memproses email",
                    icon: "warning",
                    buttons: false,
                    type: "info",
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
            url: `{{ route('pegawai.verifikasikode') }}`,
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
                    });
                }
            }
        });


    }

    @endif
</script>
@endsection
