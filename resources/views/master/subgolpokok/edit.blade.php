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
                <p class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </p>
            @endif

            <form method="POST" action="{{ route('subgolpokok.update', $subgolpokok->subgolpokokid) }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                
                <input type="hidden" name="subgolpokokid" id="subgolpokokid" value="{{ !is_null($subgolpokok->subgolpokokid) ? $subgolpokok->subgolpokokid : '' }}">

                <div class="form-group row">
                    <label for="golpokokid" class="col-md-12 col-form-label text-md-left">{{ __('Gol. Pokok *') }}</label>

                    <div class="col-md-12">
                        <select id="golpokokid" class="form-control-select form-control @error('golpokokid') is-invalid @enderror" name='golpokokid' required autofocus>
                            <option value="">-- Pilih Gol. Pokok --</option>
                            @foreach ($golpokok as $item)
                                <option value="{{$item->golpokokid}}" @if (old('golpokokid', $subgolpokok->golpokokid) == $item->golpokokid) selected @endif>{{ $item->kode . ' ' . $item->nama }}</option>
                            @endforeach
                        </select>

                        @error('golpokokid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Sub Gol. Pokok *') }}</label>

                    <div class="col-md-12">
                        <input id="kode" type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $subgolpokok->kode) }}" required autocomplete="kode">

                        @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Sub Gol. Pokok *') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $subgolpokok->nama) }}" required autocomplete="name" autofocus>

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-info">Golongan</h4>
                    </div>
                    <div class="col-md-6">
                        <button onclick="javascript:addGol();" type="button" id="btnaddgol" class="btn btn-sm btn-info pull-right">Tambah</button> 
                    </div>
                </div>
                <div class="table-responsive">
                    @php
                        $resdatagol = array();
                        if(old('gol')){
                            $oldgolrelation = array();
                            $oldgoladdition = array();
                            foreach(old('gol') as $result){
                                if($result["golid"]!="")
                                    $oldgolrelation[] = $result;
                                else
                                    $oldgoladdition[] = $result;
                            }

                            $oldgolrelation = array_column(array_merge($subgolpokok->gol->toArray(),$oldgolrelation), NULL, 'golid');
                            $resdatagol = array_merge( $oldgolrelation, $oldgoladdition );
                        }
                        else
                            $resdatagol = $subgolpokok->gol->toArray();
                    @endphp
                    <table class="table table-bordered yajra-datatable table-striped" id="gol-table">
                        <thead>
                            <tr>
                                <th style="width: 65px">Kode</th>
                                <th style="width: 220px">Nama Golongan</th>
                                <th style="width: 15px">Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resdatagol as $dataGol)
                                <tr>
                                    <td>
                                        <input type="text" name="gol[{{$loop->index}}][kode]" value="{{$dataGol['kode']}}" class="form-control" id="kode{{$loop->index}}" required>
                                        <input type="hidden" name="gol[{{$loop->index}}][golid]" id="golid{{$loop->index}}" value="{{$dataGol['golid']}}">
                                    </td>
                                    <td>
                                        <input type="text" name="gol[{{$loop->index}}][nama]" value="{{$dataGol['nama']}}" class="form-control" id="nama{{$loop->index}}" required>
                                    </td>
                                    <td>
                                        <button title="Hapus data" type="button" onclick="deleteRow(this)" class="btn btn-danger"><i class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('subgolpokok.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Sub Golongan Pokok ') }}
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
    var row_number = {{ 
    (
        null!==(old('gol')) && count(old('gol')) > 0 ?  (count(old('gol'))+1) 
            : (count($subgolpokok->gol) > 0 ? (count($subgolpokok->gol)+1) : 1)
    ) 
    }} ;

    var id = '';
    var parentid = '';
    var kode = '';
    $(document).ready(function() {
        $('.form-control-select').select2();
        id = "{{ $subgolpokok->subgolpokokid }}";
        parentid = "{{ $subgolpokok->golpokokid }}";
        kode = "{{ $subgolpokok->kode }}";

        $('#golpokokid').select2().on('change', function() {
            if ($('#golpokokid').val() == "") {
                $('#kode').val('');
            }
            else if ($('#golpokokid').val() == parentid) {
                $('#kode').val(kode);
            }
            else {
                var url = "{{ route('subgolpokok.nextno', ':parentid') }}"
                url = url.replace(':parentid', $('#golpokokid').val());
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        $('#kode').val(data);
                    }
                });
            }
        }).trigger('change');
    });

    function addGol() {
        let new_row_number = row_number - 1;
        console.log(new_row_number);
        var table = document.getElementById("gol-table");
        var row = table.insertRow(table.rows.length);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        
        var maxVal = 0;
        for(var i = 1; i < table.rows.length; i++)
        {
            if(table.rows[i].cells[0].children[0] !== undefined){
                let value = parseInt(table.rows[i].cells[0].children[0].value.replace(/\./g,''));
                if(!Number.isInteger(value)) value = 0;
                if(i === 1){
                    maxVal = value;
                }
                else if(maxVal < value)
                {
                    maxVal = value;
                }
            }
        }
        cell1.innerHTML = '<input type="text" required name="gol['+new_row_number+'][kode]" value="'+pad((maxVal+1), 2)+'.'+'" class="form-control" id="kode'+new_row_number+'"><input type="hidden" name="gol['+new_row_number+'][golid]" value="" id="golid'+new_row_number+'">'; 
        cell2.innerHTML = '<input type="text" required name="gol['+new_row_number+'][nama]" value="" class="form-control" id="nama'+new_row_number+'">';
        cell3.innerHTML = '<button title="Hapus data" type="button" onclick="deleteRow(this)" class="btn btn-danger"><i class="fa fa-trash"></i> </button>'; 
        row_number++;
    }

    function deleteRow(btn){
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function pad(num, size) {
        num = num.toString();
        while (num.length < size) num = "0" + num;
        return num;
    }
</script>
@endsection
