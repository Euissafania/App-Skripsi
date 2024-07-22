@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center">
            <img src="{{ asset('assets/img/logo_unnes.png') }}" alt="logo" style="width: 10%">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Halaman Home</div>

                <div class="card-body text-center">
                    <h3> <b>Selamat Datang !!</b></h3>
                    <h3><b>Integrasi Algoritma F-AHP dan Decision Tree C4.5 Dalam Menentukan Pilihan Program Studi Bagi Calon Mahasiswa</b></h3>
                    <h4 class="mt-5">Silahkan Login</h4>
                    <a class="btn btn-round ml-auto" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" style="background-color: blue; color: white;">
                       Login
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    {{-- <a href="{{ route('logout') }}" class="btn btn-round ml-auto" style="background-color: blue; color: white;">
                       <b> Login</b>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
