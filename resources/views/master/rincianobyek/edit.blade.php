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

            <form method="POST" action="{{ route('rincianobyek.update', $roby->robyid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="robyid" id="robyid" value="{{ !is_null($roby->robyid) ? $roby->robyid : '' }}">

                <div class="form-group row">
                    <label for="obyid" class="col-md-12 col-form-label text-md-left">{{ __('Obyek *') }}</label>

                    <div class="col-md-12">
                        <select id="obyid" class="form-control-select form-control @error('obyid') is-invalid @enderror" name='obyid' required autofocus>
                            <option value="">-- Pilih Obyek --</option>
                            @foreach ($oby as $item)
                                <option value="{{$item->obyid}}" @if ($roby->obyid == $item->obyid) selected @endif>{{ $item->obykode . ' ' . $item->obynama }}</option>
                            @endforeach
                        </select>

                        @error('obyid')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="robykode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Rincian Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="robykode" type="text" class="form-control @error('robykode') is-invalid @enderror" name="robykode" value="{{ old('robykode') ?? $roby->robykode }}" required autocomplete="robykode">

                        @error('robykode')
                            <span class="invalid-feedback" role="alert">
                                <p class="text-danger">{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="robynama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Rincian Obyek *') }}</label>

                    <div class="col-md-12">
                        <input id="robynama" type="text" class="form-control @error('robynama') is-invalid @enderror" name="robynama" value="{{ $roby->robynama }}" required autocomplete="name" autofocus>

                        @error('robynama')
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
                        <a href="{{ route('rincianobyek.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Rincian Obyek') }}
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
        id = "{{ $roby->robyid }}";
        parentid = "{{ $roby->obyid }}";
        kode = "{{ $roby->robykode }}";

        $('#obyid').select2().on('change', function() {
            if ($('#obyid').val() == "") {
                $('#robykode').val('');
            }
            else if ($('#obyid').val() == parentid) {
                $('#robykode').val(kode);
            }
            else {
                var url = "{{ route('rincianobyek.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#obyid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#robykode').val(data);
                    }
                });
            }
        }).trigger('change');
    });
</script>
@endsection
