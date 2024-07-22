@extends('layouts.index')
@section('content')
   
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/img/logo_unnes.png') }}" alt="logo" style="width: 9%"><br>
                        </div>
                        <div class="text-center mt-2">
                            <h2><b>Integrasi Algoritma Fuzzy Analytical Hierarchy Process dan Decision Tree C4.5</b></h2>
                            <h2><b>Untuk Penentuan Pilihan Program Studi Bagi Calon Mahasiswa</b></h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                           <h4><li class="fas fa-angle-double-right"></li> <b>Kriteria Dalam Menentukan Pilihan Program Studi</b></h4>
                           <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-3" style="width: 60%; margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th style="width: 15%">No</th>
                                    <th>Kritera</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_kriteria as $kriteria)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $kriteria ->nama_kriteria }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                        </div>
                        <div class="container mt-4">
                           <h4><li class="fas fa-angle-double-right"></li> <b>Data Program Studi dan Matapelajaran Pilihan</b></h4>
                           <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-3 " style="width: 60%; margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th style="width: 15%">No</th>
                                    <th>Nama Program Studi</th>
                                    <th>Mata Pelajaran Pendukung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_prodi as $prodi)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $prodi ->nama_prodi }}</td>
                                    <td>
                                        @foreach($data_mapel_prodi as $mapel_prodi)
                                           @if ($prodi->id_prodi == $mapel_prodi->prodi_id)
                                               {{ $mapel_prodi->nama_mapel }} <br>
                                           @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection