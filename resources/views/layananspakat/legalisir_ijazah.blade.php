<?php
use App\enumVar as enum;
use App\Helpers\Get_field;
?>
@extends('landing.index')

@section('content1')
<style>
    @import url(https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700);
    
    #ijazah-preview-container,
    #ktp-preview-container {
        display: none;
    }
    section {
        margin: -15%;
        text-align: left;
        color: black;
    }
    #legalisir {
        height: 20em;
        /* background-color: rgba(255, 255, 255, 0.5); */
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
    }
    .legalisir {
        /* border-radius: 3%; */
        border: none;
        border-radius: 1em;
        padding-left: 3em;
        padding-right: 3em;
        padding-bottom: 2em;
        padding-top: 2em;
        background-color: white;
    }

    .form-control {
        border-radius: 0.9em;
        font-size: 14px;
        padding: 10px;
    }

    .cari {
        width: 100%;
        border-radius: 0.9em;
        background-color: #299AA7;
        border-color: white;
    }
    .cari:hover{
        background-color: #A2C8A7;
    }
    .swal2-title, .swal2-content,.swal2-confirm ,.data h3,
    section, .cari:hover, .cari, .form-control, .legalisir, #legalisir
    {
        font-family: 'Poppins', sans-serif;
        font-weight: 300;
    }
    .history{
        background-color: black;
        color: white;
        padding: 5px;
    }
    /* wrap text */
    table td {
        word-break: break-word;
        vertical-align: top;
        white-space: normal !important;
    }

    @media (min-width:460px) and (max-width: 700px) {
            .card {
            padding: 70px;
        }
    }

    @media (min-width:310px) and (max-width: 450px) {
            .card {
            padding: 50px;
        }
        .swal2-popup {
                font-size: 11px;
        }
        section, .btn, .card, .form-control {
            font-size: 11px;
        }
        .alert-danger {
            width: 80%;
        }
    }
    @media (max-width: 300px) {
            .card {
            padding: 10px;
        }
        .swal2-popup {
                font-size: 10px;
        }
        section, .btn, .card, .form-control {
            font-size: 10px;
        }
        .alert-danger {
            width: 80%;
        }
    }

</style>
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="card" id="legalisir">
                @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show col-lg-6 text-center mx-auto" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="col-lg-6 col-md-8">
                    <div class="card-body legalisir">
                        <form action="{{ url('legalisir-dashboard/search') }}">
                            <div class="form-group text-center">
                                <label for="">Masukan No Ijazah</label>
                                <input type="text" name="query" class="form-control mt-3 query" required>
                            </div>
                            <div class="form-group mt-2 mb-2">
                                <button type="submit" class="btn cari text-white">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($results))
    <div class="container mt-5" id="datasiswa">
        <div class="row ">
            <div class="card data">
                <div class="card-body p-4 mb-5">
                    <div class="row">
                        <h3 class="text-center">Data Siswa</h3>
                        <div class="col-lg-10 mt-3 mx-auto">
                            <div class="form-group mt-3">
                                <table class="table mt-3">
                                    <tbody>
                                        <tr>
                                            <td width="25%">Nama Siswa</td>
                                            <td width="2%">:</td>
                                            <td>{{ $results->namasiswa }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Induk Siswa</td>
                                            <td>:</td>
                                            <td>{{ $results->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Ijazah</td>
                                            <td>:</td>
                                            <td>{{ $results->noijazah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Kelulusan</td>
                                            <td>:</td>
                                            <td>{{ Get_field::tgl_indo($results->tgl_lulus) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if(session('berhasil'))
                                <div class="alert alert-info alert-dismissible fade show col-lg-12 text-center align-center mx-auto" role="alert">
                                    {{ session('berhasil') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @else
                            <form class="pengajuan" action="{{ route('legalisir.storepengajuan') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ijazahid" id="ijazahid" value="{{ $results->ijazahid }}">
                                <div class=" mb-3">
                                    <label for="file_ijazah" class="form-label">Upload Ijazah</label>
                                    <br><span class="small text-danger">*File PDF | max : 5 MB</span>
                                    <input class="form-control  @error('file_ijazah') is-invalid @enderror" type="file"
                                        id="file_ijazah" name="file_ijazah" required>
                                    @error('file_ijazah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div id="ijazah-preview-container">
                                    <iframe id="ijazah-preview" width="100%" height="600px"></iframe>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="file_ktp" class="form-label">Upload KTP</label>
                                    <br><span class="small text-danger">*File PDF | max : 5 MB</span>
                                    <input class="form-control  @error('file_ktp') is-invalid @enderror" type="file"
                                        id="file_ktp" name="file_ktp" required>
                                    @error('file_ktp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div id="ktp-preview-container">
                                    <iframe id="ktp-preview" width="100%" height="600px"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info"
                                        onclick="return confirm('Apakah Anda Yakin untuk Pengajuan Legalisir Data?')">Pengajuan
                                        Legalisir Ijazah</button>
                                </div>
                            </form>
                            @endif
                            <div class="form-group mt-3">
                                <div>
                                    <div class="card-title text-center history">HISTORY</div>
                                </div>
                                <div class="table-responsive mt-3">
                                <table id="myTable" class="table table-hover " width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col" >File Legalisir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$history->isEmpty())
                                        @foreach ($history as $h)
                                        <tr>
                                            <td>{{ Get_field::tgl_indo($h->tgl_pengajuan) }}</td>
                                            <td>
                                                @if ($h->status == enum::LEGALISIR_DITOLAK)
                                                <span class="badge bg-danger">{{ enum::LEGALISIR_DESC_DITOLAK }}</span>
                                                @elseif($h->status ==  enum::LEGALISIR_DISETUJUI)
                                                <span class="badge bg-success">{{ enum::LEGALISIR_DESC_DISETUJUI }}</span>
                                                @else
                                                <span class="badge bg-info">{{ enum::LEGALISIR_DESC_DIAJUKAN }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $h->keterangan }}</td>
                                            <td> @if ($h->status == enum::LEGALISIR_DITOLAK)
                                                <span class="badge bg-danger">{{ enum::LEGALISIR_DESC_DITOLAK }}</span>
                                                @elseif ($h->status == enum::LEGALISIR_DISETUJUI && $h->masaberlaku >= $now )
                                                <a href="{{ asset('storage/' . $h->file_legalisir) }}" class="btn btn-warning btn-sm text-dark">Download Legalisir
                                                    Ijazah</a>
                                                @elseif ($h->status == enum::LEGALISIR_DISETUJUI && $h->masaberlaku < $now )
                                                <span class="badge bg-dark">Telah melewati batas waktu download file ijazah</span>
                                                @else
                                                <span class="badge bg-secondary">File legalisir belum
                                                    tersedia</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
<script>
    // scroll 
    document.addEventListener("DOMContentLoaded", function() {
        var scrollToElement = document.getElementById("datasiswa");
        if (scrollToElement) {
            var navbarHeight = document.querySelector('.navbar').offsetHeight; 
            window.scrollTo({
                top: scrollToElement.offsetTop - navbarHeight,
                behavior: "smooth"
            });
        }
    });
    // new DataTable('#myTable');
    // datatable
    var table = $('#myTable').DataTable({
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
        order: [[1, 'desc']],
        language: {
                lengthMenu: "Menampilkan _MENU_ data",
                zeroRecords: "Tidak ada data",
                info: "Halaman _PAGE_ dari _PAGES_",
                infoFiltered: "(difilter dari _MAX_ data)",
                search: "Pencarian :",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya",
                }
            },
    })
    // cek extentions flie
    document.addEventListener('DOMContentLoaded', function () {
        const ijazahInput = document.getElementById('file_ijazah');
        const ijazahPreviewContainer = document.getElementById('ijazah-preview-container');
        const ijazahPreview = document.getElementById('ijazah-preview');
        const ktpInput = document.getElementById('file_ktp');
        const ktpPreviewContainer = document.getElementById('ktp-preview-container');
        const ktpPreview = document.getElementById('ktp-preview');

        ijazahInput.addEventListener('change', function () {
            const file = ijazahInput.files[0];

            if (file) {
                if (file.type === 'application/pdf') {
                    const fileReader = new FileReader();

                    fileReader.onload = function (e) {
                        ijazahPreview.src = e.target.result;
                        ijazahPreviewContainer.style.display =
                            'block'; // Tampilkan kontainer saat sudah ada file
                    };

                    fileReader.readAsDataURL(file);
                } else {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: PDF.',
                        icon: 'info',
                    });
                    
                    ijazahInput.value = ''; // Reset the input value
                    ijazahPreviewContainer.style.display = 'none';
                }

            } else {
                ijazahPreviewContainer.style.display =
                    'none'; // Sembunyikan kontainer jika tidak ada file
            }
        });
        ktpInput.addEventListener('change', function () {
            const file = ktpInput.files[0];

            if (file) {
                if (file.type === 'application/pdf') {
                    const fileReader = new FileReader();

                    fileReader.onload = function (e) {
                        ktpPreview.src = e.target.result;
                        ktpPreviewContainer.style.display =
                            'block'; // Tampilkan kontainer saat sudah ada file
                    };

                    fileReader.readAsDataURL(file);
                } else {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: PDF.',
                        icon: 'info',
                    });
                    ktpInput.value = ''; // Reset the input value
                    ktpPreviewContainer.style.display = 'none';
                }

            } else {
                ktpPreviewContainer.style.display = 'none'; // Sembunyikan kontainer jika tidak ada file
            }
        });
    });
</script>

@endsection

