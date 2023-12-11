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

            <form method="POST" action="{{ route('subrincianobyek.update', $sroby->srobyid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="srobyid" id="srobyid" value="{{ !is_null($sroby->srobyid) ? $sroby->srobyid : '' }}">

                <div class="form-group row">
                    <label for="robyid" class="col-md-12 col-form-label text-md-left">{{ __('Rincian Obyek *') }}</label>

                    <div class="col-md-12">
                        <select id="robyid" class="form-control-select form-control @error('robyid') is-invalid @enderror" name='robyid' required autofocus>
                            <option value="">-- Pilih Rincian Obyek --</option>
                            @foreach ($roby as $item)
                                <option value="{{$item->robyid}}" @if ($sroby->robyid == $item->robyid) selected @endif>{{ $item->robykode . ' ' . $item->robynama }}</option>
                            @endforeach
                        </select>

                        @error('robyid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="srobykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Rincian Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="srobykode" type="text" class="form-control @error('srobykode') is-invalid @enderror" name="srobykode" value="{{ old('srobykode') ?? $sroby->srobykode }}" required autocomplete="srobykode">

                        @error('srobykode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="srobynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Rincian Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="srobynama" type="text" class="form-control @error('srobynama') is-invalid @enderror" name="srobynama" value="{{ $sroby->srobynama }}" required autocomplete="name" autofocus>

                        @error('srobynama')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-lg-12">
                    <div class="form-group col-lg-6">
                        <label for="isskpd" class="form-control-label text-right">Rek SKPD</label>
                        <input type="checkbox" id="isskpd" name="isskpd" value="1" {{ $sroby->isskpd ? 'checked' : '' }}>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="isssh" class="form-control-label text-right">Tanpa SSH</label>
                        <input type="checkbox" id="isssh" name="isssh" value="1" {{ $sroby->isssh ?  '' : 'checked' }}>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('subrincianobyek.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sub Rincian Obyek') }}
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
        id = "{{ $sroby->srobyid }}";
        parentid = "{{ $sroby->robyid }}";
        kode = "{{ $sroby->srobykode }}";

        $('#robyid').select2().on('change', function() {
            if ($('#robyid').val() == "") {
                $('#srobykode').val('');
            }
            else if ($('#robyid').val() == parentid) {
                $('#srobykode').val(kode);
            }
            else {
                var url = "{{ route('subrincianobyek.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#robyid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#srobykode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
