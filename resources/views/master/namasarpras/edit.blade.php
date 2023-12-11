<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">EDIT DATA</h5><hr />
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

            <form method="POST" action="{{ route('namasarpras.update', $namasarpras->namasarprasid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group row">
                    <label for="namasarpras" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpas *') }}</label>

                    <div class="col-md-12">
                        <input id="namasarpras" type="text" class="form-control @error('namasarpras') is-invalid @enderror" name="namasarpras" value="{{ old('namasarpras') ?? $namasarpras->namasarpras }}" maxlength="100" required autocomplete="namasarpras" autofocus>

                        @error('namasarpras')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kategorisarpras" class="col-md-12 col-form-label text-md-left">{{ __('Kategori Sarpras *') }}</label>

                    <div class="col-md-12">
                        <select id="kategorisarpras" class="custom-select form-control @error('kategorisarpras') is-invalid @enderror" name='kategorisarpras' required autofocus>
                            @foreach (enum::listJenisSarpras() as $id)
                            <option value="{{ $id }}" {{ $namasarpras->kategorisarpras == $id ? 'selected' : '' }}> {{ enum::listJenisSarpras('desc')[$loop->index] }}</option>
                            @endforeach
                            {{-- <option value="{{ old('kategorisarpras') ?? $namasarpras->kategorisarpras }}">-- Pilih Sarpras --</option>
                            <option value="{{enum::SARPRAS_UTAMA}}">{{ 'Sarpras Utama' }}</option>
                            <option value="{{enum::SARPRAS_PENUNJANG}}">{{ 'Sarpras Penunjang' }}</option>
                            <option value="{{enum::SARPRAS_PERALATAN}}">{{ 'Sarpras Peralatan' }}</option> --}}
                        </select>

                        @error('kategorisarpras')
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
                        <a href="{{ route('kota.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kota') }}
                        </a>
                        {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        $('#provid').select2().on('change', function() {
            if ($('#provid').val() == "") {
                $('#kodekota').val('');
            }
            else {
                var url = "{{ route('kota.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#provid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kodekota').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
