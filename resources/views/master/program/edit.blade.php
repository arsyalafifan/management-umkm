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

            <form method="POST" action="{{ route('program.update', $program->progid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="progid" id="progid" value="{{ !is_null($program->progid) ? $program->progid : '' }}">

                <div class="form-group row">
                    <label for="progkode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Program *') }}</label>

                    <div class="col-md-12">
                        <input id="progkode" type="text" class="form-control @error('progkode') is-invalid @enderror" name="progkode" value="{{ old('progkode') ?? $program->progkode }}" required autocomplete="progkode">

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
                        <input id="prognama" type="text" class="form-control @error('prognama') is-invalid @enderror" name="prognama" value="{{ old('prognama') ??  $program->prognama }}" required autocomplete="name" autofocus>

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
    var id = '';
    var parentid = '';
    var kode = '';
    $(document).ready(function() {
        $('.form-control-select').select2();
        id = "{{ $program->progid }}";
        parentid = "{{ $program->provid }}";
        kode = "{{ $program->progkode }}";

        $('#provid').select2().on('change', function() {
            if ($('#provid').val() == "") {
                $('#progkode').val('');
            }
            else if ($('#provid').val() == parentid) {
                $('#progkode').val(kode);
            }
            else {
                var url = "{{ route('program.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#provid').val());
                url = url.replace(':id', id);
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
</script>
@endsection
