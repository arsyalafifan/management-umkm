<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5><hr />
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

            <form method="POST" action="{{ route('kegiatan.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="progid" class="col-md-12 col-form-label text-md-left">{{ __('Program *') }}</label>

                    <div class="col-md-12">
                        <select id="progid" class="custom-select form-control @error('progid') is-invalid @enderror" name='progid' required autofocus>
                            <option value="">-- Pilih Program --</option>
                            @foreach ($program as $item)
                            <option value="{{$item->progid}}">{{ $item->progkode . ' ' . $item->prognama }}</option>
                            @endforeach
                        </select>

                        @error('progid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kegkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kegiatan *') }}</label>

                    <div class="col-md-12">
                        <input id="kegkode" type="text" class="form-control @error('kegkode') is-invalid @enderror" name="kegkode" value="{{ (old('kegkode') ?? $kegkode) }}" maxlength="100" required autocomplete="kegkode" autofocus>

                        @error('kegkode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kegnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kegiatan *') }}</label>

                    <div class="col-md-12">
                        <input id="kegnama" type="text" class="form-control @error('kegnama') is-invalid @enderror" name="kegnama" value="{{ old('kegnama') }}" required autocomplete="name">

                        @error('kegnama')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kegiatan') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        $('#progid').select2().on('change', function() {
            if ($('#progid').val() == "") {
                $('#kegkode').val('');
            }
            else {
                var url = "{{ route('kegiatan.nextno', ':id') }}"
                url = url.replace(':id', $('#progid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kegkode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
