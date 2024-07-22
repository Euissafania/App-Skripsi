@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <img src="{{ asset('assets/img/logo_unnes.png') }}" alt="logo" style="width: 15%">
            </div>
            <div class="card">
                <div class="card-header" style="background-color: blue;  text-align: center; color: white; font-weight: bold;">Pilih Posisi</div>

                <div class="card-body mt-4">
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <a href="{{ url('Regis-Guru') }}" class="btn btn-outline-primary" type="button">Guru</a>
                        <a href="{{ url('Regis-Siswa') }}" class="btn btn-outline-primary" type="button">Siswa</a>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
