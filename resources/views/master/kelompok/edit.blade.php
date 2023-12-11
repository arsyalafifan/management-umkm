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

            <form method="POST" action="{{ route('kelompok.update', $kelompok->kelid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="kelid" id="kelid" value="{{ !is_null($kelompok->kelid) ? $kelompok->kelid : '' }}">

                <div class="form-group row">
                    <label for="strukid" class="col-md-12 col-form-label text-md-left">{{ __('Struktur *') }}</label>

                    <div class="col-md-12">
                        <select id="strukid" class="form-control-select form-control @error('strukid') is-invalid @enderror" name='strukid' required autofocus>
                            <option value="">-- Pilih Struktur --</option>
                            @foreach ($struk as $item)
                                <option value="{{$item->strukid}}" @if ($kelompok->strukid == $item->strukid) selected @endif>{{ $item->strukkode . ' ' . $item->struknama }}</option>
                            @endforeach
                        </select>

                        @error('strukid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kelkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kelompok *') }}</label>

                    <div class="col-md-12">
                        <input id="kelkode" type="text" class="form-control @error('kelkode') is-invalid @enderror" name="kelkode" value="{{ old('kelkode') ?? $kelompok->kelkode }}" required autocomplete="kelkode">

                        @error('kelkode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kelnama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kelompok *') }}</label>

                    <div class="col-md-12">
                        <input id="kelnama" type="text" class="form-control @error('kelnama') is-invalid @enderror" name="kelnama" value="{{ $kelompok->kelnama }}" required autocomplete="name" autofocus>

                        @error('kelnama')
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
                        <a href="{{ route('kelompok.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Kelompok') }}
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
        id = "{{ $kelompok->kelid }}";
        parentid = "{{ $kelompok->strukid }}";
        kode = "{{ $kelompok->kelkode }}";

        $('#strukid').select2().on('change', function() {
            if ($('#strukid').val() == "") {
                $('#kelkode').val('');
            }
            else if ($('#strukid').val() == parentid) {
                $('#kelkode').val(kode);
            }
            else {
                var url = "{{ route('kelompok.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#strukid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kelkode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
</script>
@endsection
