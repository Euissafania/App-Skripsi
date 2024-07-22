@extends('layouts.index')
@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Rule Pohon Keputusan</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                    <thead>
                        <tr>
                            <th style="width: 15%">No</th>
                            <th>Rule</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>If ( {{ $RihtNode[0] }} >= {{  $RihtNode[1] }}
                                && {{ $RihtNode[2] }} >= {{  $RihtNode[3] }} 
                                && {{ $RihtNode[4] }} >= {{  $RihtNode[5] }} )
                                <br> Hasil = 
                                @foreach($RihtNode[6] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach

                            </td>
                            
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>If ( {{ $RihtNode[0] }} >= {{  $RihtNode[1] }}
                                && {{ $RihtNode[2] }} >= {{  $RihtNode[3] }} 
                                && {{ $RihtNode[4] }} < {{  $RihtNode[5] }} )
                                <br> Hasil = 
                                @foreach($RihtNode[7] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach

                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>If ( {{ $RihtNode[0] }} >= {{  $RihtNode[1] }}
                                && {{ $RihtNode[2] }} < {{  $RihtNode[3] }} 
                                && {{ $RihtNode[4] }} >= {{  $RihtNode[5] }} )
                                <br> Hasil = 
                                @foreach($RihtNode[10] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>If ( {{ $RihtNode[0] }} >= {{  $RihtNode[1] }}
                                && {{ $RihtNode[2] }} < {{  $RihtNode[3] }} 
                                && {{ $RihtNode[4] }} < {{  $RihtNode[5] }} )
                                <br> Hasil = 
                                @foreach($RihtNode[11] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>If ( {{ $LeftNode[0] }} < {{  $LeftNode[1] }}
                                && {{ $LeftNode[2] }} >= {{  $LeftNode[3] }} 
                                && {{ $LeftNode[4] }} >= {{  $LeftNode[5] }} )
                                <br> Hasil = 
                                @foreach($LeftNode[6] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>If ( {{ $LeftNode[0] }} < {{  $LeftNode[1] }}
                                && {{ $LeftNode[2] }} >= {{  $LeftNode[3] }} 
                                && {{ $LeftNode[4] }} <{{  $LeftNode[5] }} )
                                <br> Hasil = 
                                @foreach($LeftNode[7] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>If ( {{ $LeftNode[0] }} < {{  $LeftNode[1] }}
                                && {{ $LeftNode[2] }} < {{  $LeftNode[3] }} 
                                && {{ $LeftNode[4] }} >={{  $LeftNode[5] }} )
                                <br> Hasil = 
                                @foreach($LeftNode[10] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>If ( {{ $LeftNode[0] }} < {{  $LeftNode[1] }}
                                && {{ $LeftNode[2] }} < {{  $LeftNode[3] }} 
                                && {{ $LeftNode[4] }} <{{  $LeftNode[5] }} )
                                <br> Hasil = 
                                @foreach($LeftNode[11] as $key => $value)
                                    @foreach($data_prodi as $prodi)
                                        @if ($prodi->id_prodi == $key)
                                            {{ $prodi->nama_prodi }}, 
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection