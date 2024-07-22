@extends('layouts.index')
@section('content')
<div class="page-inner">
    <div class="row justify-content-center"> 
        <div class="col-md-8">
            <div class="card justify-content-center">
                <div class="card-header">
                    <div class="card-title"><b>Detail Data</b></div>
                </div>
                <div class="card-body">
                    <table width="90%" cellpadding="10" >
                        <tbody>
                            <tr>
                                <td width="30%">Nomor Induk Siswa</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['nis'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Nama Siswa</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['nama_siswa'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Kelas</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['kelas'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Prodi Terpilih</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['nama_prodi'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Nilai Kriteria 1</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['C-01'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Nilai Kriteria 2</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['C-02'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Nilai Kriteria 3</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['C-03'] }} Sertifikat</td>
                            </tr>
                            <tr>
                                <td width="30%">Status Validitas</td>
                                <td width="3%">:</td>
                                <td>{{ $formattedData[0]['status_validitas'] }}</td>
                            </tr>
                      
                        </tbody>
                     </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection