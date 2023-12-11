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

            <form method="POST" action="{{ route('obyek.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="jenid" class="col-md-12 col-form-label text-md-left">{{ __('Jenis *') }}</label>

                    <div class="col-md-12">
                        <select id="jenid" class="custom-select form-control @error('jenid') is-invalid @enderror" name='jenid' required autofocus>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($jen as $item)
                            <option value="{{$item->jenid}}">{{ $item->jenkode . ' - ' . $item->jennama }}</option>
                            @endforeach
                        </select>

                        @error('jenid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="obykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="obykode" type="text" class="form-control @error('obykode') is-invalid @enderror" name="obykode" value="{{ (old('obykode') ?? $obykode) }}" maxlength="100" required autocomplete="obykode" autofocus>

                        @error('obykode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="obynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="obynama" type="text" class="form-control @error('obynama') is-invalid @enderror" name="obynama" value="{{ old('obynama') }}" required autocomplete="name">

                        @error('obynama')
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
                        <a href="{{ route('obyek.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Obyek') }}
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

        $('#jenid').select2().on('change', function() {
            if ($('#jenid').val() == "") {
                $('#obykode').val('');
            }
            else {
                var url = "{{ route('obyek.nextno', ':id') }}"
                url = url.replace(':id', $('#jenid').val());
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#obykode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
