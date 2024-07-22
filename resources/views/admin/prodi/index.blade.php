@extends('layouts.index_admin')
@section('content')
   
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Prodi</h4>
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
                        <a href="#">Data Prodi</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Program Studi & Mata Pelajaran Pendukung</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal -->
                            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h3 class="modal-title">
                                                <span class="fw-mediumbold">
                                                Tambah</span> 
                                                <span class="fw-light">
                                                 Program Studi
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ url('add_prodi') }}">
                                                @csrf
                                                    <div class="form-group form-group-default">
                                                        <label  for="nama_prodi" >Nama Program Studi</label>
                                                        <input id="nama_prodi" name="nama_prodi"  type="text" class="form-control @error('nama_prodi') is-invalid @else is-valid @enderror" 
                                                        value="{{ old('nama_prodi') }}">
                                                        @error('nama_prodi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group form-group-default">
                                                        <label>Mata Pelajaran Pilihan</label>
                                                        <select class="form-control js-example-basic-multiple" name="mapel_id[]" multiple="multiple" style="width: 100%;">
                                                            <option value="">Pilih Mapel</option>
                                                            @foreach($data_mapel as $mapel)
                                                            <option value="{{ $mapel->id_mapel }}">{{ $mapel->nama_mapel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                <div class="modal-footer no-bd">
                                                    <button type="submit"  class="btn btn-primary">Add</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal --}}

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr  align="center">
                                            <th>No</th>
                                            <th>Nama Program Studi</th>
                                            <th>Mata Pelajaran Pendukung</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_prodi as $prodi)
                                        <tr  align="center">
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $prodi ->nama_prodi }}</td>
                                            <td>
                                                @foreach($data_mapel_prodi as $mapel_prodi)
                                                   @if ($prodi->id_prodi == $mapel_prodi->prodi_id)
                                                       {{ $mapel_prodi->nama_mapel }} <br>
                                                   @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a  data-toggle="modal" data-target="#edit{{ $prodi->id_prodi }}" type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('delete',  $prodi->id_prodi) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                         <!-- Edit Modal -->
                                            <div class="modal fade" id="edit{{ $prodi->id_prodi }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header no-bd">
                                                            <h3 class="modal-title">
                                                                <span class="fw-mediumbold">
                                                                Edit</span> 
                                                                <span class="fw-light">
                                                                Program Studi
                                                                </span>
                                                            </h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ url('update_data',$prodi->id_prodi) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                    <div class="form-group form-group-default">
                                                                        <label  for="nama_prodi" >Nama Program Studi</label>
                                                                        <input id="nama_prodi" name="nama_prodi"  type="text" class="form-control" 
                                                                        value="{{ $prodi ->nama_prodi }}"  required>
                                                                    </div>
                                                                    <div class="">
                                                                        <label  for="nama_prodi" >Data Lama</label>
                                                                        <p>
                                                                            @foreach($data_mapel_prodi as $mapel_prodi)
                                                                            @if ($prodi->id_prodi == $mapel_prodi->prodi_id)
                                                                                > {{ $mapel_prodi->nama_mapel }} <br>
                                                                            @endif
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                    <div class="form-group form-group-default">
                                                                        <label>Mata Pelajaran Pilihan</label>
                                                                        <select class="form-control js-example-basic-multiple" name="mapel_id[]" multiple="multiple" style="width: 100%;" required>
                                                                            <option value="">Pilih Mapel</option>
                                                                            @foreach($data_mapel as $mapel)
                                                                            <option value="{{ $mapel->id_mapel }}">{{ $mapel->nama_mapel }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                <div class="modal-footer no-bd">
                                                                    <button type="submit"  class="btn btn-primary">Update</button>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal --}}
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