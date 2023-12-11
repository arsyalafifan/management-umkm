<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">UBAH DATA</h5><hr />
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

            <form method="POST" action="{{ route('jenis.update', $jenis->jenid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="jenid" id="jenid" value="{{ !is_null($jenis->jenid) ? $jenis->jenid : '' }}">

                <div class="form-group row">
                    <label for="kelid" class="col-md-12 col-form-label text-md-left">{{ __('Kelompok *') }}</label>

                    <div class="col-md-12">
                        <select id="kelid" class="form-control-select form-control @error('kelid') is-invalid @enderror" name='kelid' required autofocus>
                            <option value="">-- Pilih Kelompok --</option>
                            @foreach ($kel as $item)
                                <option value="{{$item->kelid}}" @if ($jenis->kelid == $item->kelid) selected @endif>{{ $item->kelkode . ' ' . $item->kelnama }}</option>
                            @endforeach
                        </select>

                        @error('kelid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Jenis *') }}</label>

                    <div class="col-md-12">
                        <input id="jenkode" type="text" class="form-control @error('jenkode') is-invalid @enderror" name="jenkode" value="{{ old('jenkode') ?? $jenis->jenkode }}" required autocomplete="jenkode">

                        @error('jenkode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jennama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Jenis *') }}</label>

                    <div class="col-md-12">
                        <input id="jennama" type="text" class="form-control @error('jennama') is-invalid @enderror" name="jennama" value="{{ $jenis->jennama }}" required autocomplete="name" autofocus>

                        @error('jennama')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dasarhukum" class="col-md-12 col-form-label text-md-left">{{ __('Dasar Hukum') }}</label>

                    <div class="col-md-12">
                        <input id="dasarhukum" type="text" class="form-control @error('dasarhukum') is-invalid @enderror" name="dasarhukum" value="{{ $jenis->dasarhukum }}" autocomplete="name" autofocus>

                        @error('dasarhukum')
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
                        <a href="{{ route('jenis.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Jenis') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var id = '';
    var parentid = '';
    var kode = '';
    $(document).ready(function() {
        $('.form-control-select').select2();
        id = "{{ $jenis->jenid }}";
        parentid = "{{ $jenis->kelid }}";
        kode = "{{ $jenis->jenkode }}";

        $('#kelid').select2().on('change', function() {
            if ($('#kelid').val() == "") {
                $('#jenkode').val('');
            }
            else if ($('#kelid').val() == parentid) {
                $('#jenkode').val(kode);
            }
            else {
                var url = "{{ route('jenis.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#kelid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#jenkode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
</script>
@endsection
