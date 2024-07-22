
@php
  $user = Auth::user();
@endphp

@extends('layouts.index')
@section('content')
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Siswa</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Tables</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Data Siswa</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Siswa</h4>

                                <div class="ml-auto">

                                    <a href="{{ url('/add_prangkingan') }}" class="btn btn-primary btn-round ml-auto">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data
                                    </a>
                                    @if($user->role == 'guru')
                                    <a href="{{ url('/export-data') }}" class="btn btn-success btn-round ml-auto" target="_blank" title="Export to Excel">
                                        <i class="fa fa-print"></i>
                                        Print Data
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Hasil Perangkingan</th>
                                            <th>Validitas</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr align="center">
                                              <td>{{ $loop->iteration}}</td>
                                              <td>{{ $data->nis }}</td>
                                              <td>{{ $data->nama_siswa }}</td>
                                              <td>{{ $data->kelas }}</td>
                                              @foreach ($data_prodi as $prodi)
                                                  @if ($data->prodi_terpilih != null && $data->prodi_terpilih==$prodi->id_prodi )
                                                      <td>{{ $prodi->nama_prodi }}</td>
                                                  @endif
                                              @endforeach
                                                  @if ($data->prodi_terpilih == null)   
                                                  <td>
                                                      <a href="{{ route('proses', $data->id_siswa) }}" class="btn btn-round ml-auto" style="background-color: #265073; color:white">
                                                          <i class="fas fa-sync-alt"></i>
                                                          Periksa
                                                      </a> 
                                                  </td>
                                                  @endif

                                                  @if ($data->status_validitas  != null)
                                                      <td>{{ $data->status_validitas }}</td>
                                                  @elseif ($data->status_validitas == null)   
                                                      <td>
                                                          <a href="{{ route('proses-2', $data->id_siswa) }}" class="btn btn-secondary btn-round ml-auto">
                                                              <i class="fa fa-check-double"></i>
                                                              Cek Validitas
                                                          </a>
                                                      </td>
                                                  @endif
                                             
                                              <td>
                                                  <div class="form-button-action">
                                                      <a href="{{ route('show-data', $data->id_siswa) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="View Data">
                                                          <i class="fa fa-eye"></i>
                                                      </a>
                                                      {{-- <a href="{{ route('delete', $data->id_siswa) }}" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                          <i class="fa fa-times"></i>
                                                      </a> --}}
                                                  </div>
                                              </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($user->role == 'guru')
                                <div style="background-color: #59D5E0; padding: 1%;" class="mt-5">
                                  @if ($DataValid == 0 && $DataAll == 0) 
                                    <b>Akurasi Data : 0 %</b>
                                  @else
                                    <b>Akurasi Data : ({{ $DataValid }}/{{ $DataAll }}) * 100% = {{  round(($DataValid/ $DataAll)*100,2)  }}%</b> 
                                  @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection