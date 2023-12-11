<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<link href="{{asset('/dist/plugins/bower_components/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
<style>
    input[disabled]{
      background-color:#ddd !important;
    }
</style>
<div class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-uppercase">@if($isshow) LIHAT DATA @elseif($user->exists) UBAH DATA @else TAMBAH DATA @endif</h5><hr />
        @if($isshow)
        <div class="form-group row mb-0 text-md-right">
            <div class="col-md-12">
                {{-- <a href="{{ route('user.create') }}" class="btn btn-info btn-sm waves-effect waves-light m-r-5">{{ __('Tambah') }}</a> --}}
                <a href="{{ route('user.edit', $user->userid) }}" class="btn btn-warning btn-sm waves-effect waves-light m-r-5">{{ __('Ubah') }}</a>
            </div>
        </div>
        @endif
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

            <form method="POST" action="{{ $user->exists ? route('user.update', $user->userid) : route('user.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                @if($user->exists)
                {{ method_field('PUT') }}
                @endif

                <input type="hidden" name="userid" id="userid" value="{{ $user->exists ? $user->userid : '' }}">
                <input type="hidden" name="grup" id="grup" value="{{ $user->exists ? $user->grup : '' }}">

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group row">
                            <label for="aksesid" class="col-md-12 col-form-label text-md-left">{{ __('Hak Akses *') }}</label>

                            <div class="col-md-12">
                                <select id="aksesid" class="custom-select form-control @error('aksesid') is-invalid @enderror" name='aksesid' required autofocus @if($isshow) disabled @endif>
                                    @foreach ($akses as $item)
                                    <option @if (old("aksesid", $user->aksesid)==$item->aksesid) selected @endif value="{{$item->aksesid}}" data-grup="{{$item->grup}}">{{ $item->aksesnama }}</option>
                                    @endforeach
                                </select>

                                @error('aksesid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sekolahid" class="col-md-12 col-form-label text-md-left">{{ __('Sekolah') }}</label>

                            <div class="col-md-12">
                                <select id="sekolahid" class="custom-select form-control @error('sekolahid') is-invalid @enderror" name='sekolahid' autofocus disabled>
                                    <option value="">-- Pilih sekolah --</option>
                                    @foreach ($sekolah as $item)
                                    <option @if (old("sekolahid", $user->sekolahid)==$item->sekolahid) selected @endif value="{{$item->sekolahid}}">{{ $item->npsn . ' ' . $item->namasekolah }}</option>
                                    @endforeach
                                </select>

                                @error('sekolahid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="perusahaanid" class="col-md-12 col-form-label text-md-left">{{ __('Perusahaan') }}</label>

                            <div class="col-md-12">
                                <select id="perusahaanid" class="custom-select form-control @error('perusahaanid') is-invalid @enderror" name='perusahaanid' autofocus disabled>
                                    <option value="">-- Pilih perusahaan --</option>
                                    @foreach ($perusahaan as $item)
                                    <option @if (old("perusahaanid", $user->perusahaanid)==$item->perusahaanid) selected @endif value="{{$item->perusahaanid}}">{{ $item->nama }}</option>
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
                            <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Lengkap *') }}</label>

                            <div class="col-md-12">
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $user->nama) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="login" class="col-md-12 col-form-label text-md-left">{{ __('Login *') }}</label>

                            <div class="col-md-12">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login', $user->login) }}" required autocomplete="name" @if($isshow) disabled @endif>

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(!$user->exists)
                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-left">{{ __('Password *') }}</label>
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password', isset($user->password) ? $user->password : '') }}" maxlength="30" required>

                               @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-12 col-form-label text-md-left">{{ __('Ulangi Password') }}</label>
                            <div class="col-md-12">
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation', isset($user->password_confirmation) ? $user->password_confirmation : '') }}" maxlength="30" required>

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="isaktif" class="col-md-12 col-form-label text-md-left">{{ __('Status') }}</label>

                            <div class="col-md-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" data-size="small" data-color="#ffca4a" class="js-switch @error('isaktif') is-invalid @enderror" id="isaktif" name="isaktif" value="1" @if (old("isaktif", $user->isaktif)=="1" || !$user->exists) checked @endif @if($isshow) onclick="return false;" @endif>
                                    <label class="custom-control-label" for="isaktif">Aktif</label>
                                </div>
                                @error('isaktif')
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
                                <a href="{{ route('user.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                                    {{ __('Index User') }}
                                </a>
                                {{-- <a href="{{ route('home') }}" class="btn btn-dark waves-effect waves-light m-r-10">
                                    {{ __('Home') }}
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h5 class="card-title text-uppercase">DETAIL HAK AKSES</h5>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <table class="table table-bordered yajra-datatable table-striped" id="aksesmenu-table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('/dist/plugins/bower_components/switchery/dist/switchery.min.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    });
    </script>

<script>
    var v_listDataMenu = <?php echo json_encode($aksesmenu); ?>;
    var v_listDataMenuFilter = Array();

    $(document).ready(function() {
        $('.custom-select').select2();

        filterAksesmenu();
        <?php if(!$isshow) {?>
        setupCombosProp();

        $('#aksesid').select2().on('change', function() {
            setComboDisable();
            setupCombosProp();
            filterAksesmenu();
        })

        $('#pegawaiid').select2().on('change', function() {
            var nama = $(this).find(":selected").data("nama");
            var nip = $(this).find(":selected").data("nip");

            $('#nama').val(nama);
            $('#login').val(nip);
        });

        $('#nakerid').select2().on('change', function() {
            var namalengkap = $(this).find(":selected").data("namalengkap");
            var nik = $(this).find(":selected").data("nik");

            $('#nama').val(namalengkap);
            $('#login').val(nik);
        });

        function setComboDisable(){
            $('#sekolahid').prop('disabled', true);
            $('#perusahaanid').prop('disabled', true);
            $('#nakerid').prop('disabled', true);
        }

        function setupCombosProp(){
            $('#grup').val($('#aksesid').find(":selected").data("grup"));
            if ($('#aksesid').find(":selected").data("grup") == "{{enum::USER_SEKOLAH}}") {
                $('#sekolahid').prop('disabled', false);
                $('#perusahaanid').val('').trigger('change');
            }else if ($('#aksesid').find(":selected").data("grup") == "{{enum::USER_SUPERADMIN}}" || $('#aksesid').find(":selected").data("grup") == "{{enum::USER_ADMIN_DISDIK}}"){
                $('#sekolahid').prop('disabled', true);
                $('#sekolahid').val('').trigger('change');
                $('#perusahaanid').val('').trigger('change');
                // $('#nakerid').prop('disabled', false);
            }else if($('#aksesid').find(":selected").data("grup") == "{{enum::USER_PERUSAHAAN}}") {
                $('#perusahaanid').prop('disabled', false);
                $('#sekolahid').val('').trigger('change');
            }
        }
        <?php } ?>
    });

    var aksesmenutable = $('#aksesmenu-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        searching: false, 
        paging: false, 
        info: false,
        select: false,
        ordering: false,
        asStripeClasses: [],
        language: {
            lengthMenu: "Menampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data",
            info: "Halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            search: "Pencarian :",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            }
        },
        data: v_listDataMenuFilter,
        columns: [
            {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": "",
                    visible: false
                }, 
            {'orderData': 1, data: 'jenis', name: 'jenis', visible: false},
            {'orderData': 2, data: 'menu', 
                render: function ( data, type, row ) {
                    if (row.parent != row.menu) {
                        return row.menu;
                        return row.parent + ' - ' + row.menu;
                    }
                    else {
                        return row.menu;
                    }
                }, 
                name: 'menu', title: 'Nama Menu'},
            {'orderData': 3, data: 'menu', width: '15px', name: 'semua', visible: false},
            {'orderData': 4, data: 'tambah', width: '15px', 
                render: function ( data, type, row ) {
                    if (row.tambah != null && row.tambah != '0') {
                        return '<span class="badge badge-pill badge-success">V</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">X</span>';
                    }
                }, sClass : "text-center", 
                name: 'tambah', title: '<span class="badge badge-pill badge-dark">Tambah</span>'},
            {'orderData': 5, data: 'ubah', width: '5px', 
                render: function ( data, type, row ) {
                    if (row.ubah != null && row.ubah != '0') {
                        return '<span class="badge badge-pill badge-success">V</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">X</span>';
                    }
                }, sClass : "text-center", 
                name: 'ubah', title: '<span class="badge badge-pill badge-dark">Ubah</span>'},
            {'orderData': 6, data: 'hapus', width: '15px', 
                render: function ( data, type, row ) {
                    if (row.hapus != null && row.hapus != '0') {
                        return '<span class="badge badge-pill badge-success">V</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">X</span>';
                    }
                }, sClass : "text-center", 
                name: 'hapus', title: '<span class="badge badge-pill badge-dark">Hapus</span>'},
            {'orderData': 7, data: 'lihat', width: '15px', 
                render: function ( data, type, row ) {
                    if (row.lihat != null && row.lihat != '0') {
                        return '<span class="badge badge-pill badge-success">V</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">X</span>';
                    }
                }, sClass : "text-center", 
                name: 'lihat', title: '<span class="badge badge-pill badge-dark">Lihat</span>'},
            {'orderData': 8, data: 'cetak', width: '15px', 
                render: function ( data, type, row ) {
                    if (row.cetak != null && row.cetak != '0') {
                        return '<span class="badge badge-pill badge-success">V</span>';
                    }
                    else {
                        return '<span class="badge badge-pill badge-danger">X</span>';
                    }
                }, sClass : "text-center", 
                name: 'cetak', title: '<span class="badge badge-pill badge-dark">Cetak</span>'},
        ],
        rowGroup: {
            dataSrc: 'jenis',
        },
        drawCallback: function( settings ) {
            $("#aksesmenu-table").wrap( "<div class='table-responsive'></div>" );
        }
        //order: [[1, 'asc']]
    });

    function filterAksesmenu() {
        v_listDataMenuFilter = v_listDataMenu.filter(function (p_element) {
            return p_element.aksesid == $('#aksesid').val();
        });
        aksesmenutable.clear();
        aksesmenutable.rows.add(v_listDataMenuFilter);
        aksesmenutable.draw();
    }
</script>
@endsection
