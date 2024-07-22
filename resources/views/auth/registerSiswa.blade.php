@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8  align-items-center">
            <div class="text-center">
                <img src="{{ asset('assets/img/logo_unnes.png') }}" alt="logo" style="width: 15%">
            </div>
            <div class="card">
                <div class="card-header" style="background-color: blue;  text-align: center; color: white; font-weight: bold;">Register</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('create-siswa') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nis" class="col-md-4 col-form-label text-md-end">{{ __('NIS') }}</label>
                            <div class="col-md-6">
                                <input id="nis" type="text" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis') }}" required autocomplete="nis" autofocus>

                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="row mb-3">
                            <label for="kelas" class="col-md-4 col-form-label text-md-end">Kelas</label>
                            <div class="col-md-6">
                            <select class="form-control js-example-basic-single" id="kelas" name="kelas" style="width: 100%" required>
                                <option>--Pilih Kelas--</option>
                                @php
                                  $kelas = ['12 MIPA 1','12 MIPA 2','12 MIPA 3','12 MIPA 4','12 MIPA 5','12 IPS 1','12 IPS 2','12 IPS 3','12 IPS 4'];
                                @endphp
                                @foreach ($kelas  as $k)  
                                <option value="{{ $k }}">{{ $k}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  for="foto" class="col-md-4 col-form-label text-md-end">Foto Profile</label>
                            <div class="col-md-6">
                                <input  type="file" class="form-control" name="foto" placeholder="Pilih Foto"/>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
