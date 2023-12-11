@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
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

            <form method="POST" action="{{ route('prov.update', $prov->provid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="provid" id="provid" value="{{ !is_null($prov->provid) ? $prov->provid : '' }}">
                <div class="form-group row">
                    <label for="kodeprov" class="col-md-12 col-form-label text-md-left">{{ __('Kode Kemendagri *') }}</label>

                    <div class="col-md-12">
                        <input id="kodeprov" type="text" class="form-control @error('kodeprov') is-invalid @enderror" name="kodeprov" value="{{ $prov->kodeprov }}" required autocomplete="kodeprov">

                        @error('kodeprov')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namaprov" class="col-md-12 col-form-label text-md-left">{{ __('Nama Provinsi*') }}</label>

                    <div class="col-md-12">
                        <input id="namaprov" type="text" class="form-control @error('namaprov') is-invalid @enderror" name="namaprov" value="{{ $prov->namaprov }}" required autocomplete="name" autofocus>

                        @error('namaprov')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-3 col-form-label text-md-left">{{ __('Status') }}</label>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch mb-2" dir="ltr">
                            <input type="checkbox" class="form-control custom-control-input @error('status') is-invalid @enderror" id="status" name="status" value="1"{{ ($prov->status == '1' ? ' checked' : '') }}>
                            <label class="custom-control-label" for="status">Aktif</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('prov.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Provinsi') }}
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
    var id = '';
    var kode = '';
</script>
@endsection
