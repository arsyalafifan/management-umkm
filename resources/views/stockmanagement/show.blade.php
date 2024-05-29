<?php
use App\enumVar as enum;
?>
@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title text-uppercase">LIHAT DATA</h5><hr />
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

            <form method="POST" action="{{ route('stockmanagement.update', $stock->stockid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                {{-- <input type="hidden" name="sekolahid" id="sekolahid" value="{{ old('sekolahid',$stock->sekolahid) }}"> --}}
                <input type="hidden" name="stockid" id="stockid" value="{{ $stock->stockid }}">

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="kodestock" class="col-md-12 col-form-label text-md-left">{{ __('Kode Stock *') }}</label>
        
                            <div class="col-md-12">
                                <input id="kodestock" type="text" class="form-control @error('kodestock') is-invalid @enderror" name="kodestock" value="{{ $stock->kodestock }}" maxlength="100" disabled autocomplete="kodestock" autofocus>
        
                                @error('kodestock')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namastock" class="col-md-12 col-form-label text-md-left">{{ __('Nama Stock *') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control @error('namastock') is-invalid @enderror" id="namastock" name="namastock" value="{{ $stock->namastock }}" disabled>
                                @error('namastock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah" class="col-md-12 col-form-label text-md-left">{{ __('Jumlah *') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ $stock->jumlah }}" disabled>
                                @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga" class="col-md-12 col-form-label text-md-left">{{ __('Harga *') }}</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ $stock->harga }}" disabled>
                                @error('harga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="box-title text-uppercase m-b-0">Foto</h3><hr />
                        {{-- <p class="text-muted m-b-20">Klik Tambah Master Plan Sekolah untuk menambah data </p> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered yajra-datatable table-striped" id="foto-table">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('stockmanagement.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Kembali') }}
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
<script src="{{asset('/dist/plugins/bower_components/dropify/dist/js/dropify.min.js')}}"></script>

<!-- table sarpras kebutuhan -->
<script>
   function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
   
   var url = "{{ route('stockmanagement.show', ':id') }}"
   url = url.replace(':id', $('#stockid').val());
   console.log(url);
   var fototable = $('#foto-table').DataTable({
       responsive: true,
       processing: true,
       serverSide: true,
       pageLength: 50,
       dom: 'Bfrtip',
       select: true,
       ordering: false,
       searching: false,
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
       ajax: {
           url: url,
           dataSrc: function(response){
               response.recordsTotal = response.data.countFileStock;
               response.recordsFiltered = response.data.countFileStock;
               return response.data.filestock;
           },
           data: function ( d ) {
               return $.extend( {}, d, {
                   "stockid": $("#stockid").val().toLowerCase(),
               } );
           }
       },
       buttons: {
           buttons: [
        //    {
        //        text: '<i class="fa fa-download" aria-hidden="true"></i> Download',
        //        className: 'edit btn btn-success btn-datatable mb-3',
        //        action: () => {
        //            if (fototable.rows( { selected: true } ).count() <= 0) {
        //                swal.fire("Data belum dipilih", "Silahkan pilih data yang akan didownload", "error");
        //                return;
        //            }
        //            let id = fototable.rows( { selected: true } ).data()[0]['filestockid'];
        //            let url = ""
        //            url = url.replace(':id', id);
        //            console.log(url);
        //            let today = new Date();
        //            let dateTime = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+ "_"+today.getHours() + today.getMinutes() + today.getSeconds();
        //            let namaFile = `SARPRAS_KEBUTUHAN_${dateTime}`
        //            $.ajax({
        //                    type: "GET",
        //                    cache:false,
        //                    processData: false,
        //                    contentType: false,
        //                    // defining the response as a binary file
        //                    xhrFields: {
        //                        responseType: 'blob' 
        //                    },  
        //                    url: url,
        //                    success: (data) => {
        //                        let a = document.createElement('a');
        //                        let url = window.URL.createObjectURL(data);
        //                        a.href = url;
        //                        a.download = namaFile;
        //                        document.body.append(a);
        //                        a.click();
        //                        a.remove();
        //                        window.URL.revokeObjectURL(url);
        //                    }
        //            });
        //        }
        //    },
       ]
       },
       columns: [
           // {'orderData': 1, data: 'akreditasi', name: 'akreditasi'},
        //    {'orderData': 1, data: 'kondisi',
        //        render: function ( data, type, row ) {
        //            if(row.kondisi!=null){
        //                if(row.kondisi=="{{enum::KONDISI_SARPRAS_BAIK}}") 
        //                    return 'Baik';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_BERAT}}") 
        //                    return 'Rusak Berat';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_SEDANG}}") 
        //                    return 'Rusak Sedang';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_RUSAK_RINGAN}}") 
        //                    return 'Rusak Ringan';
        //                else if(row.kondisi=="{{enum::KONDISI_SARPRAS_BELUM_SELESAI}}") 
        //                    return 'Belum Selesai';
        //                else return "-";
        //            }else
        //                return "-";
        //        }, 
        //        name: 'kondisi'},
        //    {'orderData': 2, data: 'jumlahunit', name: 'jumlahunit'},
        //    {'orderData': 1, data: 'filestockid', name: 'filestockid'},
           {'orderData': 1, data: 'file', name: 'file'},
           {'orderData': 2, data: 'file', 
            render: function (data, type, row){
                if(row.file != null){
                    return "<div class=\"d-flex justify-content-center align-items-center\"><img src=\"/storage/uploaded/stockmanagement/"+row.file+"\" height=\"200\"/></div>";
                }
            }
            },
       ],
       initComplete: function (settings, json) {
           $(".btn-datatable").removeClass("dt-button");
       },
       //order: [[1, 'asc']]
   });
   $('#search').keydown(function(event){
       if(event.keyCode == 13) {
           event.preventDefault();
           return false;
       }
   });
   
   $('#search').on('keyup', function (e) {
       if (e.key === 'Enter' || e.keyCode === 13) {
           sekolahtable.draw();
       }
   });
</script>

<script>
    $(document).ready(function() {
        $('.custom-select').select2();
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
        var newRow = '<tr><td><input type="file" onchange="readURL(this);" name="file[]" id="file" class="dropify"/></td><td><button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></td></tr>';


        //add it
        footable.appendRow(newRow);

    });
});
</script>
@endsection
