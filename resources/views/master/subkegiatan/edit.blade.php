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

            <form method="POST" action="{{ route('subkegiatan.update', $subkegiatan->subkegid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="subkegid" id="subkegid" value="{{ !is_null($subkegiatan->subkegid) ? $subkegiatan->subkegid : '' }}">

                <div class="form-group row">
                    <label for="kegid" class="col-md-12 col-form-label text-md-left">{{ __('Kegiatan *') }}</label>

                    <div class="col-md-12">
                        <select id="kegid" class="form-control-select form-control @error('kegid') is-invalid @enderror" name='kegid' required autofocus>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach ($kegiatan as $item)
                                <option value="{{$item->kegid}}" @if ($subkegiatan->kegid == $item->kegid) selected @endif>{{ $item->kegkode . ' ' . $item->kegnama }}</option>
                            @endforeach
                        </select>

                        @error('kegid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="subkegkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Kegiatan *') }}</label>

                    <div class="col-md-12">
                        <input id="subkegkode" type="text" class="form-control @error('subkegkode') is-invalid @enderror" name="subkegkode" value="{{ old('subkegkode') ?? $subkegiatan->subkegkode }}" required autocomplete="subkegkode">

                        @error('subkegkode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="subkegnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Kegiatan *') }}</label>

                    <div class="col-md-12">
                        <input id="subkegnama" type="text" class="form-control @error('subkegnama') is-invalid @enderror" name="subkegnama" value="{{ $subkegiatan->subkegnama }}" required autocomplete="name" autofocus>

                        @error('subkegnama')
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
                        <a href="{{ route('subkegiatan.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sub Kegiatan') }}
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
        id = "{{ $subkegiatan->subkegid }}";
        parentid = "{{ $subkegiatan->kegid }}";
        kode = "{{ $subkegiatan->subkegkode }}";

        $('#kegid').select2().on('change', function() {
            if ($('#kegid').val() == "") {
                $('#subkegkode').val('');
            }
            else if ($('#kegid').val() == parentid) {
                $('#subkegkode').val(kode);
            }
            else {
                var url = "{{ route('subkegiatan.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#kegid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#subkegkode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
