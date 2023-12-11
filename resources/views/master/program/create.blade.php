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

            <form method="POST" action="{{ route('program.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="progkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Program *') }}</label>

                    <div class="col-md-12">
                        <input id="progkode" type="text" class="form-control @error('progkode') is-invalid @enderror" name="progkode" value="{{ (old('progkode') ?? $progkode) }}" maxlength="100" required autocomplete="progkode" autofocus>

                        @error('progkode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="prognama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Program *') }}</label>

                    <div class="col-md-12">
                        <input id="prognama" type="text" class="form-control @error('prognama') is-invalid @enderror" name="prognama" value="{{ old('prognama') }}" required autocomplete="name">

                        @error('prognama')
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
                        <a href="{{ route('program.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Program') }}
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
                $('#progkode').val('');
            }
            else {
                var url = "{{ route('program.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#provid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#progkode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
