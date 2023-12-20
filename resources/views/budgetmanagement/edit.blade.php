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

            <form method="POST" action="{{ route('sarprastersedia.update', $sarprastersedia->sarprastersediaid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" name="idsarprastersedia" value={{ $sarprastersedia->sarprastersediaid }} id="idsarprastersedia"/>
                <div class="form-group row">
                    <label for="jenissarpras" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Sarpras Tersedia *') }}</label>

                    <div class="col-md-12">
                        <select id="jenissarpras" class="custom-select form-control @error('jenissarpras') is-invalid @enderror" name='jenissarpras' required>
                            <option value="{{ old('jenissarpras') ?? $sarprastersedia->jenissarpras }}">-- Pilih Jenis Sarpras Tersedia --</option>
                            <option {{ $sarprastersedia->jenissarpras == enum::SARPRAS_UTAMA ? 'selected' : '' }} value="{{ enum::SARPRAS_UTAMA }}">{{ __('Sarpras Utama') }}</option>
                            <option {{ $sarprastersedia->jenissarpras == enum::SARPRAS_PENUNJANG ? 'selected' : '' }} value="{{ enum::SARPRAS_PENUNJANG }}">{{ __('Sarpras Penunjang') }}</option>
                            <option {{ $sarprastersedia->jenissarpras == enum::SARPRAS_PERALATAN ? 'selected' : '' }} value="{{ enum::SARPRAS_PERALATAN }}">{{ __('Sarpras Peralatan') }}</option>
                        </select>

                        @error('jenissarpras')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namasarpras" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sarpras *') }}</label>

                    <div class="col-md-12">
                        <select id="namasarprasid" class="custom-select form-control @error('namasarpras') is-invalid @enderror" name='namasarprasid' required>
                            <option value="">-- Pilih Nama Sarpras --</option>
                            @foreach ($namasarpras as $item)
                            <option {{ $item->namasarprasid == $sarprastersedia->namasarprasid ? 'selected' : '' }} value="{{$item->namasarprasid}}">{{ $item->namasarpras }}</option>
                            @endforeach
                        </select>

                        @error('namasarpras')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah Unit *') }}</label>
        
                            <div class="col-md-12">
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') ?? $sarprastersedia->jumlahunit }}" maxlength="100" required autocomplete="jumlah">
        
                                @error('jumlah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- <div class="col-md-3"> --}}
                            <div class="form-group">
                                <label for="satuan" class="col-md-12 col-form-label text-md-left">{{ __('Satuan *') }}</label>
            
                                <div class="col-md-12">
                                    <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ (old('satuan')) ?? $sarprastersedia->satuan }}" maxlength="100" required autocomplete="satuan">
            
                                    @error('satuan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thang" class="col-md-12 col-form-label text-md-left">{{ __('Tahun Anggaran *') }}</label>

                            <div class="col-md-12">
                                <select id="thang" class="custom-select form-control @error('thang') is-invalid @enderror" name='thang' required>
                                    <option value="">-- Tahun Anggaran --</option>
                                    @foreach (enum::listTahun() as $id)
                                        <option {{ $sarprastersedia->thang == $id ? 'selected' : '' }} value="{{ $id }}"> {{ enum::listTahun('desc')[$loop->index] }}</option>
                                    @endforeach
                                </select>

                                @error('thang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sarprastersedia.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Tersedia') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- foo table -->
<script src="{{asset('/dist/js/pages/footable-init.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/dist/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        $('#jenissarpras').select2().on('change', function() {
            var url = "{{ route('sarprastersedia.getNamaSarpras', ':parentid') }}";
            url = url.replace(':parentid', ($('#jenissarpras').val() == "" || $('#jenissarpras').val() == null ? "-1" : $('#jenissarpras').val()));

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#namasarprasid').empty();
                    $('#namasarprasid').append($("<option></option>").attr("value", "").text("-- Pilih Nama Sarpras --"));
                    $.each(data.data, function(key, value) {
                        $('#namasarprasid').append($("<option></option>").attr("value", value.namasarprasid).text(value.namasarpras));
                    });
                    $('#namasarprasid').select2();
                    // $('#sekolahid').val(sekolahid);
                    $('#namasarprasid').trigger('change');
                }
            })
        })
    });
</script>

@endsection
