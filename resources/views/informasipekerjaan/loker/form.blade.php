<?php
use App\enumVar as enum;
use Carbon\Carbon;
$errorsLoker = [];
//Memisahkan error array
if (count($errors) > 0)
    foreach ($errors->messages() as $key => $value) {
        foreach ($value as $errField) {
            $errorsLoker[] = $errField;
        }
    }
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($loker->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
            @if($isshow)
            <div class="form-group row mb-0 text-md-right">
                <div class="col-md-12">
                    <a href="{{ route('loker.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a>
                    <a href="{{ route('loker.edit', $loker->lokerid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
                </div>
            </div>
            @endif

            @if (count($errors) > 0)
            @foreach ($errorsLoker as $error)
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

            <form method="POST" action="{{ $loker->exists ? route('loker.update', $loker->lokerid) : route('loker.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data" id="formLoker">
                @csrf
                @if($loker->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="lokerid" id="lokerid" value="{{ $loker->exists ? $loker->lokerid : '' }}">

                <div class="form-group row">
                    <label for="perusahaanid" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan *') }}</label>

                    <div class="col-md-12">
                        <select id="perusahaanid" class="custom-select form-control @error('perusahaanid') is-invalid @enderror" name='perusahaanid' required autofocus @if($isshow) disabled @endif>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($perusahaan as $item)
                            <option value="{{$item->perusahaanid}}" @if (old("perusahaanid", $loker->perusahaanid)==$item->perusahaanid) selected @endif >{{ $item->kodedaftar.' '.$item->nama }}</option>
                            @endforeach
                        </select>

                        @error('perusahaanid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="judul" class="col-md-12 col-form-label text-md-left">{{ __('Nama Pekerjaan *') }}</label>

                    <div class="col-md-12">
                        <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $loker->judul) }}" required autocomplete="name" @if($isshow) disabled @endif>

                        @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat Pengiriman lamaran *') }}</label>

                    <div class="col-md-12">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="name" @if($isshow) disabled @endif>{{ old('alamat', $loker->alamat) }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lokasi" class="col-md-12 col-form-label text-md-left"><b>{{ __('Lokasi Pekerjaan') }}</b></label>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="provid" class="col-md-12 col-form-label text-md-left">{{ __('Provinsi *') }}</label>

                            <div class="col-md-12">
                                <select id="provid" class="custom-select form-control @error('provid') is-invalid @enderror" name='provid' required autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($prov as $item)
                                    <option value="{{$item->provid}}" @if (old('provid', $loker->provid, (!is_null($instansi) ? $instansi->provinsi : '')) == $item->provid) selected @endif>{{ $item->kodeprov . ' ' . $item->namaprov }}</option>
                                    @endforeach
                                </select>

                                @error('provid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="kotaid" class="col-md-12 col-form-label text-md-left">{{ __('Kabupaten/Kota *') }}</label>

                            <div class="col-md-12">
                                <select id="kotaid" class="custom-select form-control @error('kotaid') is-invalid @enderror" name='kotaid' required autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Kota --</option>
                                    @foreach ($kota as $item)
                                    <option value="{{$item->kotaid}}"  @if (old('kotaid', $loker->kotaid, (!is_null($instansi) ? $instansi->kota : '')) == $item->kotaid) selected @endif>{{ $item->kodekota . ' ' . $item->namakota }}</option>
                                    @endforeach
                                </select>

                                @error('kotaid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $loker->email) }}" autocomplete="name" @if($isshow) disabled @endif>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <hr/>             
                <h4 class="text-info">Deskripsi Pekerjaan</h4>
                
                <div class="form-group row">
                    <label for="jobdesc" class="col-md-12 col-form-label text-md-left">{{ __('Tugas dan Tanggung Jawab *') }}</label>

                    <div class="col-md-12">
                        <textarea  rows="5" id="jobdesc" class="form-control @error('jobdesc') is-invalid @enderror" name="jobdesc" required autocomplete="name" @if($isshow) disabled @endif>{{ old('jobdesc', $loker->jobdesc) }}</textarea>

                        @error('jobdesc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="syarat" class="col-md-12 col-form-label text-md-left">{{ __('Persyaratan *') }}</label>

                    <div class="col-md-12">
                        <textarea  rows="5" id="syarat" class="form-control @error('syarat') is-invalid @enderror" name="syarat" required autocomplete="name" @if($isshow) disabled @endif>{{ old('syarat', $loker->syarat) }}</textarea>

                        @error('syarat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <hr/>             
                <h4 class="text-info">Informasi Tambahan</h4>
                <input type='hidden' value='0' name="lokerlevelpekerjaan[-1]">
                <input type='hidden' value='0' name="lokerjenjangpendidikan[-1]">
                <input type='hidden' value='0' name="lokerstatuspekerjaan[-1]">
                <div class="mb-5">                    
                    <div class="form-group row">
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="level" class="col-form-label text-md-left"><b>{{ __('Level Pekerjaan') }}</b></label>
                                </div>
                            </div>
                            @foreach ($listlevelpekerjaan as $item)
                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                <input type="checkbox" class="form-control custom-control-input" id="lokerlevelpekerjaan{{$item['levelpekerjaan']}}" name="lokerlevelpekerjaan[{{$item['levelpekerjaan']}}]" value="1" 
                                @if (
                                    array_key_exists(
                                        $item['levelpekerjaan'],
                                        old(
                                            'lokerlevelpekerjaan',
                                            array_fill_keys($loker->lokerlevelpekerjaan->pluck('levelpekerjaan')->all(),"1")
                                        )
                                    )
                                ) 
                                    checked
                                @endif
                                @if($isshow) onclick="return false;" @endif>
                                <label class="custom-control-label" for="lokerlevelpekerjaan{{$item['levelpekerjaan']}}">{{ $item['levelpekerjaanvw'] }}</label>
                            </div>
                            @endforeach       
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="jenjang" class="col-form-label text-md-left"><b>{{ __('Kualifikasi Pendidikan') }}</b></label>
                                </div>
                            </div>
                            @foreach ($listjenjang as $item)
                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                <input type="checkbox" class="form-control custom-control-input" id="lokerjenjangpendidikan{{$item['jenjangpendidikan']}}" name="lokerjenjangpendidikan[{{$item['jenjangpendidikan']}}]" value="1" 
                                @if (
                                    array_key_exists(
                                        $item['jenjangpendidikan'],
                                        old(
                                            'lokerjenjangpendidikan',
                                            array_fill_keys($loker->lokerjenjangpendidikan->pluck('jenjangpendidikan')->all(),"1")
                                        )
                                    )
                                ) 
                                    checked
                                @endif
                                @if($isshow) onclick="return false;" @endif>
                                <label class="custom-control-label" for="lokerjenjangpendidikan{{$item['jenjangpendidikan']}}">{{ $item['jenjangpendidikanvw'] }}</label>
                            </div>
                            @endforeach       
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="pengalaman" class="col-form-label text-md-left"><b>{{ __('Pengalaman Kerja') }}</b></label>
                                </div>
                            </div>
                            <div class="custom-control custom-switch" dir="ltr">
                                <input type="checkbox" class="form-control custom-control-input @error('ispengalaman') is-invalid @enderror" id="ispengalaman" name="ispengalaman" value="1" @if (old("ispengalaman", $loker->ispengalaman)=="1") checked @endif @if($isshow) onclick="return false;" @endif>
                                <label class="custom-control-label" for="ispengalaman">Berpengalaman</label>
                            </div>
                            <div class="col-md-12" id="divPengalaman">
                                <select id="pengalaman" class="custom-select form-control @error('pengalaman') is-invalid @enderror" name='pengalaman' autofocus @if($isshow) disabled @endif>
                                    <option value="">-- Pilih Pengalaman --</option>
                                    @foreach ($listpengalaman as $item)
                                    <option value="{{$item['pengalaman']}}" @if (old('pengalaman', $loker->pengalaman) === $item['pengalaman']) selected @endif>{{ $item['pengalamanvw'] }}</option>
                                    @endforeach
                                </select>

                                @error('pengalaman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="custom-control custom-switch mb-2 mt-2" dir="ltr">
                                <input type="checkbox" class="form-control custom-control-input @error('isfreshgraduate') is-invalid @enderror" id="isfreshgraduate" name="isfreshgraduate" value="1" @if (old("isfreshgraduate", $loker->isfreshgraduate)=="1") checked @endif @if($isshow) onclick="return false;" @endif>
                                <label class="custom-control-label" for="isfreshgraduate">Baru Lulus</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="status" class="col-form-label text-md-left"><b>{{ __('Jenis Pekerjaan') }}</b></label>
                                </div>
                            </div>
                            @foreach ($liststatus as $item)
                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                <input type="checkbox" class="form-control custom-control-input" id="lokerstatuspekerjaan{{$item['statuspekerjaan']}}" name="lokerstatuspekerjaan[{{$item['statuspekerjaan']}}]" value="1" 
                                @if (
                                    array_key_exists(
                                        $item['statuspekerjaan'],
                                        old(
                                            'lokerstatuspekerjaan',
                                            array_fill_keys($loker->lokerstatuspekerjaan->pluck('statuspekerjaan')->all(),"1")
                                        )
                                    )
                                ) 
                                    checked
                                @endif
                                @if($isshow) onclick="return false;" @endif>
                                <label class="custom-control-label" for="lokerstatuspekerjaan{{$item['statuspekerjaan']}}">{{ $item['statuspekerjaanvw'] }}</label>
                            </div>
                            @endforeach       
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gaji" class="col-md-12 col-form-label text-md-left"><b>{{ __('Gaji yang ditawarkan') }}</b></label>

                    <div class="col-md-4">
                        <div class="row">
                            <label for="gajimin" class="col-md-12 col-form-label text-md-left">{{ __('Dari (Rp)') }}</label>

                            <div class="col-md-12">
                                <input id="gajimin" type="number" class="form-control @error('gajimin') is-invalid @enderror" name="gajimin" value="{{ old('gajimin', $loker->gajimin) }}" autocomplete="name" @if($isshow) disabled @endif>

                                @error('gajimin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <label for="gajimax" class="col-md-12 col-form-label text-md-left">{{ __('Sampai (Rp)') }}</label>

                            <div class="col-md-12">
                                <input id="gajimax" type="number" class="form-control @error('gajimax') is-invalid @enderror" name="gajimax" value="{{ old('gajimax', $loker->gajimax) }}" autocomplete="name" @if($isshow) disabled @endif>

                                @error('gajimax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <label for="tglexpired" class="col-md-12 col-form-label text-md-left">{{ __('Batas akhir pengiriman lamaran') }} :</label>
                            <div class="col-md-12">
                                <input class="form-control dp-text" type="date" type="text" name="tglexpired" id="tglexpired" min="{{ Carbon::now()->isoFormat('YYYY-MM-DD') }}" value="{{ old('tglexpired', $loker->tglexpired) }}" @if($isshow) disabled @endif/>

                                 @error('tglexpired')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <!-- <label for="isshowgaji" class="col-md-12 col-form-label text-md-left">{{ __('Status') }}</label> -->

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('isshowgaji') is-invalid @enderror" id="isshowgaji" name="isshowgaji" value="1" @if (old("isshowgaji", $loker->isshowgaji)=="1" || !$loker->exists) checked @endif @if($isshow) onclick="return false;" @endif>
                            <label class="custom-control-label" for="isshowgaji">Tampilkan gaji yang ditawarkan</label>
                        </div>
                        @error('isshowgaji')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        @if(!$isshow)
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        @endif
                        <a href="{{ route('loker.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Perusahaan') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var kotaid = '{{ old("kotaid", $loker->kotaid, (!is_null($instansi) ? $instansi->kota : "")) }}';

    $(document).ready(function() {
        setCbPengalamanVisibility({{old("ispengalaman", $loker->ispengalaman)}});

        $('.custom-select').select2();

        $('#provid').select2().on('change', function() {
            var url = "{{ route('loker.kota', ':parentid') }}";
            url = url.replace(':parentid', ($('#provid').val() == "" || $('#provid').val() == null ? "-1" : $('#provid').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#kotaid').empty();
                    $('#kotaid').append($("<option></option>").attr("value", "").text("-- Pilih Kota --"));
                    $.each(data.data, function(key, value) {
                        $('#kotaid').append($("<option></option>").attr("value", value.kotaid).text(value.kodekota + ' ' + value.namakota));
                    });
                    $('#kotaid').select2();
                    $('#kotaid').val(kotaid);
                    $('#kotaid').trigger('change');
                }
            }); 
        }).trigger('change');

    });

    $('#ispengalaman').click(function(){
        @if(!$isshow)
        setCbPengalamanVisibility($(this).is(':checked'));
        @endif
    });

    function setCbPengalamanVisibility(isChecked){
       if(isChecked){
            $('#divPengalaman').show();
            @if(!$isshow)
            $('#pengalaman').prop('disabled', false);
            @endif
        } else {
            $('#divPengalaman').hide();
            @if(!$isshow)
            $('#pengalaman').prop('disabled', true);
            @endif
        } 
    }
</script>
@endsection
