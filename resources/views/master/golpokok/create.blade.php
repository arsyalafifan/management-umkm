@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
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

            <form method="POST" action="{{ route('golpokok.store') }}" class="form-horizontal form-material m-t-40 needs-validation" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="kode" class="col-md-12 col-form-label text-md-left">{{ __('Kode Gol. Pokok *') }}</label>

                    <div class="col-md-12">
                        <input id="kode" type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode') }}" maxlength="100" required autocomplete="kode" autofocus>

                        @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-12 col-form-label text-md-left">{{ __('Nama Gol. Pokok *') }}</label>

                    <div class="col-md-12">
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="name">

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
                        <h4 class="text-info">Sub Golongan Pokok</h4>
                    </div>
                    <div class="col-md-6">
                        <button onclick="javascript:addSubGolPokok();" type="button" id="btnaddsubgolpokok" class="btn btn-sm btn-info pull-right">Tambah</button> 
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable table-striped" id="subgolpokok-table">
                        <thead>
                            <tr>
                                <th style="width: 65px">Kode</th>
                                <th style="width: 220px">Nama Sub Golongan Pokok</th>
                                <th style="width: 15px">Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(old('subgolpokok'))
                                @foreach(old('subgolpokok') as $dataSubgolpokok)
                                    <tr>
                                        <td>
                                            <input type="text" name="subgolpokok[{{$loop->index}}][kode]" value="{{$dataSubgolpokok['kode']}}" class="form-control" id="kode{{$loop->index}}">
                                        </td>
                                        <td>
                                            <input type="text" name="subgolpokok[{{$loop->index}}][nama]" value="{{$dataSubgolpokok['nama']}}" class="form-control" id="nama{{$loop->index}}">
                                        </td>
                                        <td>
                                            <button title="Hapus data" type="button" onclick="deleteRow(this)" class="btn btn-danger"><i class="fa fa-trash"></i> </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('golpokok.index') }}" class="btn btn-primary waves-effect waves-light m-r-10">
                            {{ __('Index Golongan Pokok') }}
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
    var row_number = {{ (null!==(old('subgolpokok')) && count(old('subgolpokok')) > 0 ?  (count(old('subgolpokok'))+1) : 1) }} ;

    $(document).ready(function() {
        $('.custom-select').select2();

        var url = "{{ route('golpokok.nextno') }}"
        $.ajax({
            url:url,
            type:'GET',
            success:function(data) {
                $('#kode').val(data);
            }
        });
    });

    function addSubGolPokok() {
            let new_row_number = row_number - 1;

            var table = document.getElementById("subgolpokok-table");
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

            cell1.innerHTML = '<input type="text" required name="subgolpokok['+new_row_number+'][kode]" value="'+pad((maxVal+1), 2)+'.'+'" class="form-control" id="kode'+new_row_number+'">'; 
            cell2.innerHTML = '<input type="text" required name="subgolpokok['+new_row_number+'][nama]" value="" class="form-control" id="nama'+new_row_number+'">';
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
