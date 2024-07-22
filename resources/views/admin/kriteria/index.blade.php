@extends('layouts.index_admin')
@section('content')
   
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Kriteria & Bobot</h4>
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
                        <a href="#">Data Kriteria & Bobot</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Kriteria & Bobot</h4>
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
                                                    Kriteria & Bobot
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ url('add_kriteria') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label  for="nama_kriteria" >Nama Kriteria</label>
                                                            <input id="nama_kriteria" name="nama_kriteria"  type="text" class="form-control @error('nama_kriteria') is-invalid @else is-valid @enderror" 
                                                            value="{{ old('nama_kriteria') }}">
                                                            @error('nama_kriteria')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group form-group-default">
                                                            <label  for="bobot" >Bobot Kriteria</label>
                                                            <input id="bobot" name="bobot"  type="text" class="form-control @error('bobot') is-invalid @else is-valid @enderror" 
                                                            value="{{ old('bobot') }}">
                                                            @error('bobot')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
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
                                            <th>Kriteria</th>
                                            <th>Bobot Kriteria</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_kriteria as $kriteria)
                                        <tr  align="center">
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $kriteria ->nama_kriteria }}</td>
                                            <td>{{ $kriteria ->bobot }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a  data-toggle="modal" data-target="#edit{{ $kriteria->id_kriteria }}" type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('delete', $kriteria->id_kriteria) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- edit -->
                                        <div class="modal fade" id="edit{{ $kriteria->id_kriteria }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header no-bd">
                                                        <h3 class="modal-title">
                                                            <span class="fw-mediumbold">
                                                            Edit</span> 
                                                            <span class="fw-light">
                                                                Kriteria & Bobot
                                                            </span>
                                                        </h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ url('update_data',$kriteria->id_kriteria)  }}">
                                                            @csrf
                                                             @method('PUT')
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-group-default">
                                                                        <label  for="nama_kriteria" >Nama Kriteria</label>
                                                                        <input id="nama_kriteria" name="nama_kriteria"  type="text" class="form-control" 
                                                                        value="{{ $kriteria->nama_kriteria }}" required>
                                                                    </div>
                                                                    <div class="form-group form-group-default">
                                                                        <label  for="bobot" >Bobot Kriteria</label>
                                                                        <input id="bobot" name="bobot"  type="text" class="form-control" 
                                                                        value="{{ $kriteria->bobot }}" required>
                                                                    </div>
                                                                </div>
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