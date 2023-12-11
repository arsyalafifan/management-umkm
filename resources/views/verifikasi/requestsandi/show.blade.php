@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />

        <form class="form-horizontal form-material m-t-40 needs-validation">
            <div class="form-group row my-2">
                <label for="email" class="col-md-3 col-form-label text-md-left">{{ __('Email') }}</label>

                <div class="col-md-9">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $requestsandi->email }}" disabled> 
                </div>
            </div>

            <div class="form-group row my-2">
                <label for="norequest" class="col-md-3 col-form-label text-md-left">{{ __('Kode Request ') }}</label>

                <div class="col-md-3">
                    <input id="norequest" type="text" class="form-control" name="norequest" value="{{ $requestsandi->norequest }}" disabled>
                </div>
                <div class="col-md-6">
                    <input id="textrequest" type="text" class="form-control" name="textrequest" value="{{ $requestsandi->textrequest }}" disabled>
                </div>
            </div>

            <div class="form-group row my-2">
                <label for="instansi" class="col-md-3 col-form-label text-md-left">{{ __('Instansi') }}</label>

                <div class="col-md-9">
                    <input id="instansi" type="name" class="form-control" name="instansi" value="{{ $requestsandi->instansi===0 ? 'Perusahaan' : ($requestsandi->instansi===1 ? 'Tenaga Kerja' : '')}}" disabled> 
                </div>
            </div>

            <div class="form-group row my-2">
                <label for="akun" class="col-md-3 col-form-label text-md-left">{{ __('Akun') }}</label>
                <div class="col-md-9">
                    <input id="akun" type="text" class="form-control" name="akun" value="{{ $requestsandi->instansi===0 ? $requestsandi->nib : ($requestsandi->instansi===1 ? $requestsandi->nik : '')}}" disabled>
                </div>
            </div>

            @if($requestsandi->instansi===0)
            
            @if(is_null($perusahaan))
            <div class="form-group row my-2">
                <b class="col-md-9 offset-md-3 text-md-left font-weight-bold text-warning">{{ __('Perusahaan dengan No Akun di atas belum ada di database') }}</b>
            </div>
            @else
                @if($perusahaan->noaktapendirian=="" || $perusahaan->noaktapendirian==null)
            <div class="form-group row my-2">
                <b class="col-md-9 offset-md-3 text-md-left font-weight-bold text-warning">{{ __('No akte perusahaan belum ada di data Perusahaan') }}</b>
            </div>
                @elseif($perusahaan->noaktapendirian==$requestsandi->noakte)
            <div class="form-group row my-2">
                <b class="col-md-9 offset-md-3 text-md-left font-weight-bold text-success">{{ __('No akte perusahaan sama dengan data perusahaan') }}</b>
            </div>
                @else
            <div class="form-group row my-2">
                <b class="col-md-9 offset-md-3 text-md-left font-weight-bold text-danger">{{ __('No akte perusahaan berbeda dengan data perusahaan') }}</b>
            </div>
                @endif
            @endif

            <div class="form-group row my-2">
                <label for="noakte" class="col-md-3 col-form-label text-md-left">{{ __('No. Akte Pendirian Perusahaan') }}</label>
                <div class="col-md-9">
                    <input id="noakte" type="text" class="form-control" name="noakte" value="{{ $requestsandi->noakte }}" disabled>
                </div>
            </div>
            @endif

            @if($requestsandi->instansi===1)
            <div class="form-group row my-2">
                <label for="fotoktp" class="col-md-3 col-form-label text-md-left">{{ __('Foto KTP') }}</label>
                <div class="col-md-9">
                    <img id="fotoktp" class="col-md-6 img-fluid img-thumbnail rounded" src="{{ isset($requestsandi->fotoktp) ? url('images/'.$requestsandi->fotoktp) : '' }}" alt="Foto KTP" />
                </div>
                </div>
            </div>
            @endif            
        </form>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <a href="{{ route('requestsandi.admin') }}" class="btn btn-info waves-effect waves-light m-r-10">
                    {{ __('Index Request Sandi') }}
                </a>
                <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                    {{ __('Home') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    });
</script>
@endsection