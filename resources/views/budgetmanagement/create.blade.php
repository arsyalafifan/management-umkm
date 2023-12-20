<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">TAMBAH DATA</h5><hr />
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

            <form method="POST" action="{{ route('sarprastersedia.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$sekolah->sekolahid) }}">
                <div class="form-group row">
                    <label for="jenissarpras" class="col-md-12 col-form-label text-md-left">{{ __('Jenis Sarpras Tersedia *') }}</label>

                    <div class="col-md-12">
                        <select id="jenissarpras" class="custom-select form-control @error('jenissarpras') is-invalid @enderror" name='jenissarpras' required>
                            <option value="">-- Pilih Jenis Sarpras Tersedia --</option>
                            <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_UTAMA ? 'selected' : '' }} value="{{ enum::SARPRAS_UTAMA }}">{{ __('Sarpras Utama') }}</option>
                            <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PENUNJANG ? 'selected' : '' }} value="{{ enum::SARPRAS_PENUNJANG }}">{{ __('Sarpras Penunjang') }}</option>
                            <option {{ old('jenissarpras') != '' && old('jenissarpras') == enum::SARPRAS_PERALATAN ? 'selected' : '' }} value="{{ enum::SARPRAS_PERALATAN }}">{{ __('Sarpras Peralatan') }}</option>
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
                            {{-- @foreach ($namasarpras as $item)
                            <option value="{{$item->namasarprasid}}">{{ $item->namasarpras }}</option>
                            @endforeach --}}
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
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ (old('jumlah')) }}" maxlength="100" required autocomplete="jumlah">
        
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
                                    <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ (old('satuan')) }}" maxlength="100" required autocomplete="satuan">
            
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
                                        <option value="{{ $id }}"> {{ enum::listTahun('desc')[$loop->index] }}</option>
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

                {{-- <table id="demo-foo-addrow-sarprastersedia" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">Kondisi</th>
                            <th data-sort-initial="true" data-toggle="true">Jumlah</th>
                            <th data-sort-initial="true" data-toggle="true">Upload File</th>
                            <th data-sort-ignore="true" data-toggle="true">Delete</th>
                        </tr>
                    </thead>
                    <div class="padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-6 text-right m-b-20">
                                <div class="form-group">
                                    <input id="demo-input-search2" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6 text-right m-b-20">
                                <button type="button" id="demo-btn-addrow-sarprastersedia" class="btn btn-primary"><i class="icon wb-plus" aria-hidden="true"></i>Tambah
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <tbody id="tbody-sarprastersedia">
                        <tr>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table> --}}

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('sarprastersedia.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sarpras Tersedia') }}
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

        // $('#kotaid').select2().on('change', function() {
        //     if ($('#kotaid').val() == "") {
        //         $('#kodekec').val('');
        //     }
        //     else {
        //         var url = "{{ route('kecamatan.nextno', ':parentid') }}"
        //         url = url.replace(':parentid', $('#kotaid').val());
        //         $.ajax({
        //             url:url,
        //             type:'GET',
        //             success:function(data) {
        //                 $('#kodekec').val(data);
        //             }
        //         });
        //     }
        // }).trigger('change');
    });
</script>

<!-- Sarpras Tersedia -->
<script>
    $(window).on('load', function() {

    // Search input
    $('#demo-input-search2').on('input', function (e) {
        e.preventDefault();
        addrow.trigger('footable_filter', {filter: $(this).val()});
    });

    // Add & Remove Row
    var addrow = $('#demo-foo-addrow-sarprastersedia');
    addrow.footable().on('click', '.delete-row-btn', function() {

        //get the footable object
        var footable = addrow.data('footable');

        //get the row we are wanting to delete
        var row = $(this).parents('tr:first');

        //delete the row
        footable.removeRow(row);
    });
    // Add Row Button
    $('#demo-btn-addrow-sarprastersedia').click(function() {

        //get the footable object
        var footable = addrow.data('footable');
        
        //build up the row we are wanting to add
        var newRow = '<tr><td><select id="kondisi" class="col-md-12 custom-select form-control" name="kondisi[]"><option value="">-- Pilih Kondisi --</option><option value="{{enum::KONDISI_SARPRAS_BAIK}}">Baik</option><option value="{{enum::KONDISI_SARPRAS_RUSAK_BERAT}}">Rusak Berat</option><option value="{{enum::KONDISI_SARPRAS_RUSAK_SEDANG}}">Rusak Sedang</option><option value="{{enum::KONDISI_SARPRAS_RUSAK_RINGAN}}">Rusak Ringan</option><option value="{{enum::KONDISI_SARPRAS_BELUM_SELESAI}}">Belum Selesai</option></select></td><td><input type="number" class="form-control" name="jumlahunit[]" id="jumlahunit" placeholder="Jumlah"></td><td><input type="file" class="form-control" name="filesarprastersedia[]" id="filesarprastersedia"></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';

        //add it
        footable.appendRow(newRow);

    });
});
</script>
@endsection
