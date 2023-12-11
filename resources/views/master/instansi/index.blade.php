@extends('layouts.master')

@section('content')

<form method="POST" action="{{ route('instansi.save') }}" class="form-material m-t-10" novalidate enctype="multipart/form-data" style="padding=0; margin:0;">
@csrf
<div class="card">
    <div class="row">
        <div class="col-lg-3 col-md-4 p-4">
            <div class="card-body inbox-panel">
                <div class="list-group">
                    <u><h5 class="card-title text-uppercase">LOGO INSTANSI</h5></u>
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <img id="imglogo" class="col-md-12 img-fluid img-thumbnail rounded" src="{{ old('logofile', (!is_null($instansi) && isset($instansi->logo) ? 'storage/uploaded/instansi/'.$instansi->logo : '')) }}" alt="Logo Instansi" />
                            {{-- <img id="imglogo" class="col-md-12 img-fluid img-thumbnail rounded" src="{{ old('logofile', (!is_null($instansi) && isset($instansi->logo) ? 'storage/uploaded/sarpraskebutuhan/2023-09-05_435_1622415878_kotabatam.png' : '')) }}" alt="Logo Instansi" /> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <input id="logo" type="file" onchange="readURL(this)" class="form-control @error('logo') is-invalid @enderror" name="logo" autocomplete="logo">

                                            @if ($errors->has('logo'))
                                            @error('logo')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @else
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Logo harus dipilih</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 bg-light border-left p-4">
            <div class="card-body">
                <h5 class="card-title text-uppercase">SETTING INSTANSI</h5><hr />
                {{-- <button>button</button> --}}
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
                    
                    @if (session()->has('success'))
                        <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </p>
                    @endif

                    <input type="hidden" name="instansiid" id="instansiid" value="{{ old('instansiid', $instansi->instansiid) }}">
                    <input type="hidden" name="logofile" id="logofile" value="{{ old('logofile', (!is_null($instansi) ? 'images/'.$instansi->logo : '')) }}">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="namainstansi" class="col-md-12 col-form-label text-md-left">{{ __('Nama Instansi *') }}</label>

                                <div class="col-md-12">
                                    <input id="namainstansi" type="text" class="form-control @error('namainstansi') is-invalid @enderror" name="namainstansi" value="{{ old('namainstansi', $instansi->namainstansi) }}" autocomplete="namainstansi" autofocus required>
                                    @if ($errors->has('namainstansi'))
                                    @error('namainstansi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Nama Instansi harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="col-md-12 col-form-label text-md-left">{{ __('Alamat *') }}</label>

                                <div class="col-md-12">
                                    <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat', $instansi->alamat) }}" required autocomplete="name">

                                    @if ($errors->has('alamat'))
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Alamat harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="telp" class="col-md-12 col-form-label text-md-left">{{ __('Nomor Telp *') }}</label>

                                <div class="col-md-12">
                                    <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp', $instansi->telp) }}" required autocomplete="telp" autofocus>

                                    @if ($errors->has('telp'))
                                    @error('telp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Nomor Telp harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="col-md-12 col-form-label text-md-left">{{ __('Fax') }}</label>

                                <div class="col-md-12">
                                    <input id="fax" type="text" class="form-control @error('fax') is-invalid @enderror" name="fax" value="{{ old('fax', $instansi->fax) }}" autocomplete="name">

                                    @if ($errors->has('fax'))
                                    @error('fax')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Fax harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="kodepos" class="col-md-12 col-form-label text-md-left">{{ __('Kode Pos *') }}</label>

                                <div class="col-md-12">
                                    <input id="kodepos" type="text" class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" value="{{ old('kodepos', $instansi->kodepos) }}" required autocomplete="kodepos" autofocus>

                                    @if ($errors->has('kodepos'))
                                    @error('kodepos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Kode Pos harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('E-mail *') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $instansi->email) }}" required autocomplete="name">

                                    @if ($errors->has('email'))
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>E-mail harus diisi/valid</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="jenisinstansi" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Instansi *') }}</label>

                                <div class="col-md-12">
                                    <input id="jenisinstansi" type="text" class="form-control @error('jenisinstansi') is-invalid @enderror" name="jenisinstansi" value="{{ old('jenisinstansi', $instansi->jenisinstansi) }}" required autocomplete="name">

                                    @if ($errors->has('jenisinstansi'))
                                    @error('jenisinstansi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Jenis Instansi harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="jenisdaerah" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Daerah *') }}</label>

                                <div class="col-md-12">
                                    <select id="jenisdaerah" class="form-control-select form-control @error('jenisdaerah') is-invalid @enderror" name='jenisdaerah' required autofocus>
                                        <option value="">-- Pilih Jenis Daerah --</option>
                                        {{-- <option value="1" @if (old("jenisdaerah", $instansi->jenisdaerah)==1) selected @endif>{{ 'Provinsi' }}</option> --}}
                                        <option value="1" @if (old("jenisdaerah", $instansi->jenisdaerah)==1) selected @endif>{{ 'Kota' }}</option>
                                        <option value="2" @if (old("jenisdaerah", $instansi->jenisdaerah)==2) selected @endif>{{ 'Kabupaten' }}</option>
                                    </select>

                                    @if ($errors->has('jenisdaerah'))
                                    @error('jenisdaerah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Jenis Daerah harus dipilih</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="kepda" class="col-md-12 col-form-label text-md-left">{{ __('Kepala Daerah *') }}</label>

                                <div class="col-md-12">
                                    <input id="kepda" type="text" class="form-control @error('kepda') is-invalid @enderror" name="kepda" value="{{ old('kepda', $instansi->kepda) }}" required autocomplete="kepda" autofocus>

                                    @if ($errors->has('kepda'))
                                    @error('kepda')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Kepala Daerah harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="namakepda" class="col-md-12 col-form-label text-md-left">{{ __('Nama Kepala Daerah *') }}</label>

                                <div class="col-md-12">
                                    <input id="namakepda" type="text" class="form-control @error('namakepda') is-invalid @enderror" name="namakepda" value="{{ old('namakepda', $instansi->namakepda) }}" required autocomplete="name">

                                    @if ($errors->has('namakepda'))
                                    @error('namakepda')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Nama Kepala Daerah harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="provinsi" class="col-md-12 col-form-label text-md-left">{{ __('Nama Provinsi') }}</label>

                                <div class="col-md-12">
                                    <input id="provinsi" type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" value="{{ old('provinsi', $instansi->provinsi) }}" autocomplete="provinsi">

                                    @if ($errors->has('provinsi'))
                                    @error('provinsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Ibu Kota harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ibukota" class="col-md-12 col-form-label text-md-left">{{ __('Ibukota') }}</label>

                                <div class="col-md-12">
                                    <input id="ibukota" type="text" class="form-control @error('ibukota') is-invalid @enderror" name="ibukota" value="{{ old('ibukota', $instansi->ibukota) }}" autocomplete="ibukota">

                                    @if ($errors->has('ibukota'))
                                    @error('ibukota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @else
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Ibu Kota harus diisi</strong>
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 pull-right">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<script>
    var kotaid = '{{ old("kota", $instansi->kota) }}';

    $(document).ready(function() {
        $('.form-control-select').select2();
        
        $('#provinsi').select2().on('change', function() {
            var url = "{{ route('instansi.kota', ':parentid') }}";
            url = url.replace(':parentid', ($('#provinsi').val() == "" || $('#provinsi').val() == null ? "-1" : $('#provinsi').val()));
                            
            $.ajax({
                url:url,
                type:'GET',
                success:function(data) {
                    $('#kota').empty();
                    $('#kota').append($("<option></option>").attr("value", "").text("-- Pilih Kota --"));
                    $.each(data.data, function(key, value) {
                        $('#kota').append($("<option></option>").attr("value", value.kotaid).text(value.kodekota + ' ' + value.namakota));
                    });
                    $('#kota').select2();
                    $('#kota').val(kotaid);
                    $('#kota').trigger('change');
                }
            });
        }).trigger('change');

        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Isi field ini terlebih dahulu");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
        elements = document.getElementsByTagName("SELECT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Pilih salah satu item pada list");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    });

    const validExtensions = ['pdf', 'jpeg', 'jpg', 'png', 'gif', 'webp'];

    $('#logo').on('change', function(){
        const $input = $(this);
        var url = $input.val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (validExtensions.includes(ext)) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imglogo').attr('src', e.target.result);
            }
            reader.readAsDataURL($input[0].files[0]);
        }
        else{
            $('#imglogo').attr('src', '/assets/no_preview.png');
        }
    })

    function readURL(input) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imglogo').attr('src', e.target.result);
            }
            reader.readAsDataURL(input[0].files[0]);
        }
        else{
            $('#imglogo').attr('src', '/assets/no_preview.png');
        }
    }
</script>
@endsection
