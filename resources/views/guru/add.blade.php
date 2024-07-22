
@php
  $user = Auth::user();
  $id = $user->id;
  $user_siswa =DB::table('siswa')
        ->join('users', 'users.id', '=', 'siswa.id_siswa')
        ->select('siswa.*', 'users.*')
        ->where('users.id', $id)
        ->first(); 
$user_guru =DB::table('guru')
->join('users', 'users.id', '=', 'guru.user_id')
->select('users.nama as nama_guru','guru.*', 'users.*')
->where('users.id', $id)
->first(); 
@endphp
@extends('layouts.index')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
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
                    <a href="#">Forms</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Add Data Perangkingan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Add Data Penentuan Program Studi</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('add_data') }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                   
                                    @if( $user_siswa->nama != null)
                                        <div class="form-group">
                                            <label for="nama_siswa">Nama Siswa</label>
                                            <input id="nama_siswa" name="nama_siswa" type="text" class="form-control" 
                                            value="{{ $user_siswa->nama }}" required>
                                        </div>
                                    @endif
                                    @if( $user_siswa->nama == null)
                                    <input type="hidden" value="{{ $user_guru->id_guru }}" name="guru_id">
                                    <div class="form-group">
                                        <label for="nama_siswa">Nama Siswa</label>
                                        <input id="nama_siswa" name="nama_siswa" type="text" class="form-control" 
                                        value="{{ old('nama_siswa') }}" required>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="kriteria_id">{{ $data_kriteria[0]->nama_kriteria }}</label>
                                        <input type="hidden" value="{{ $data_kriteria[0]->id_kriteria}}" name="kriteria_id[]">
                                        <input type="hidden" value="-" name="pilihan_ke[]">
                                        <input id="nilai_kriteria" name="nilai_kriteria[]"  type="text" class="form-control" required>
                                    </div>

                                    {{-- Strat Prodi pilihan 1--}}
                                    <div class="form-group">
                                        <label for="prodi_id">Pilihan Prodi 1</label>
                                        <select class="form-control js-example-basic-single" id="prodi_id" name="prodi_id[]" style="width: 100%" required>
                                            <option>Pilih Prodi</option>
                                            @foreach ($data_prodi as $prodi)  
                                            <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mapel_id" id="mapel_id">{{  $data_kriteria[1]->nama_kriteria }}</label>
                                        <input type="hidden" value="pilihan 1" name="pilihan_ke[]">
                                        <input type="hidden" name="kriteria_id[]" value="{{ $data_kriteria[1]->id_kriteria }}">
                                        <input name="nilai_kriteria[]" type="text" class="form-control" require>
                                    </div>
                                    {{-- End Prodi Pilihan --}}
                                      
                                        {{-- Strat Prodi pilihan 2--}}
                                        <div class="form-group">
                                            <label for="prodi_id">Pilihan Prodi 2</label>
                                            <select class="form-control js-example-basic-single" id="prodi_id2" name="prodi_id[]" style="width: 100%" required>
                                                <option>Pilih Prodi</option>
                                                @foreach ($data_prodi as $prodi)  
                                                <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="mapel_id" id="mapel_id2">{{ $data_kriteria[1]->nama_kriteria }}</label>
                                            <input type="hidden" value="pilihan 2" name="pilihan_ke[]">
                                            <input type="hidden" name="kriteria_id[]" value="{{ $data_kriteria[1]->id_kriteria }}">
                                            <input name="nilai_kriteria[]" type="text" class="form-control" require>
                                        </div>
                                        {{-- End Prodi Pilihan --}}
                                </div>
                                <div class="col-6">
                                    @if( $user_siswa->nama != null)
                                    <div class="form-group">
                                        <label for="nis">Nomor Induk Siswa (NIS)</label>
                                        <input id="nis" name="nis"  type="text" class="form-control" 
                                        value="{{ $user_siswa->nis }}" required>
                                    </div>
                                    @endif

                                    @if( $user_siswa->nama == null)
                                    <div class="form-group">
                                        <label for="nis">Nomor Induk Siswa (NIS)</label>
                                        <input id="nis" name="nis"  type="text" class="form-control" 
                                        value="{{ old('nis') }}" required>
                                    </div>
                                    @endif
                                    @if( $user_siswa->nama != null)
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        <input id="kelas" name="kelas"  type="text" class="form-control" 
                                        value="{{ $user_siswa->kelas }}" required>
                                    </div>
                                    @endif
                                    
                                    @if( $user_siswa->nama == null)
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
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
                                    @endif

                                        {{-- Strat Prodi pilihan 3--}}
                                        <div class="form-group">
                                            <label for="prodi_id">Pilihan Prodi 3</label>
                                            <select class="form-control js-example-basic-single" id="prodi_id3" name="prodi_id[]" style="width: 100%" required>
                                                <option>Pilih Prodi</option>
                                                @foreach ($data_prodi as $prodi)  
                                                <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="mapel_id3" id="mapel_id3">{{  $data_kriteria[1]->nama_kriteria }}</label>
                                            <input type="hidden" name="kriteria_id[]" value="{{ $data_kriteria[1]->id_kriteria }}">
                                            <input type="hidden" value="pilihan 3" name="pilihan_ke[]">
                                            <input name="nilai_kriteria[]" type="text" class="form-control" require>
                                        </div>
                                        {{-- End Prodi Pilihan --}}

                                    <div class="form-group">
                                        <label >{{ $data_kriteria[2]->nama_kriteria }}</label>
                                        <div class="input-group hdtuto control-group lst increment" >
                                            <input type="hidden" name="kriteria_id[]" value="{{ $data_kriteria[2]->id_kriteria }}">
                                            <input type="hidden" value="-" name="pilihan_ke[]">
                                            <input type="file" name="data_prestasi[]" class="form-control myfrm">
                                            <div class="input-group-btn"> 
                                            <button class="btn btn-primary" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Live search selact --}}
<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
    });
</script>
<script>
    // Prodi 1
    $(document).ready(function() {
        $('#prodi_id').on('change', function() {
            var prodi_id = $(this).val();
            if(prodi_id) {
            $.ajax({
                url: '/get-mapel/'+prodi_id,
                type: "GET",
                dataType: "json",
                    success:function(data) {
                        $('#mapel_id').empty();

                        // Hapus input lama jika ada
                        //$('#nilai_kriteria_input').remove();

                        // Buat input baru untuk nilai kriteria
                       // var inputElement = '<input type="text" name="nilai_kriteria[]" id="nilai_kriteria_input" class="form-control" require data-prodi="' + prodi_id + '">';

                        $('#mapel_id').append('<label>Rata-Rata Nilai Mapel &nbsp</label>' +
                            data.map(function(value) {
                                return '<u>'+value.nama_mapel+'</u>';
                            }).join('&nbsp;&amp; ')
                        ); 
                      }
                    });
                } else {
                    $('#mapel_id').empty();
                }
            });
    });

     // Prodi 2
    $(document).ready(function() {
        $('#prodi_id2').on('change', function() {
            var prodi_id2 = $(this).val();
            if(prodi_id2) {
            $.ajax({
                url: '/get-mapel/'+prodi_id2,
                type: "GET",
                dataType: "json",
                    success:function(data) {
                        $('#mapel_id2').empty();
                        
                        $('#mapel_id2').append('<label>Rata-Rata Nilai Mapel &nbsp</label>' +
                        data.map(function(value) {
                            return '<u>'+value.nama_mapel+'</u>';
                        }).join('&nbsp;&amp; '));
                        
                        
                    }
                    });
                } else {
                    $('#mapel_id2').empty();
                }
            });
    });

     // Prodi 3
    $(document).ready(function() {
        $('#prodi_id3').on('change', function() {
            var prodi_id3 = $(this).val();
            if(prodi_id3) {
            $.ajax({
                url: '/get-mapel/'+prodi_id3,
                type: "GET",
                dataType: "json",
                    success:function(data) {
                        $('#mapel_id3').empty();
                        var jml = data.length;

                        $('#mapel_id3').append('<label>Rata-Rata Nilai Mapel &nbsp</label>' +
                        data.map(function(value) {
                            return '<u>'+value.nama_mapel+'</u>';
                        }).join('&nbsp;&amp; '));
                        // $.each(data, function(key, value){
                        // $('#mapel_id3').append('<label>'+value.nama_mapel+'</label>'+ '<input name="nilai_kriteria[]" type="text" class="form-control" require>');
                        // });
                        
                        
                    }
                    });
                } else {
                    $('#mapel_id3').empty();
                }
            });
    });

// Mutiple Input Files
    $(document).ready(function() {

        var formHTML = `
        <div class="clone hide">
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                <input type="file" name="data_prestasi[]" class="myfrm form-control">
                <div class="input-group-btn"> 
                <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                </div>
            </div>
        </div>
    `;
    
    $(".btn-primary").click(function() {
        $(".increment").after(formHTML);
        $(".clone").removeClass("hide");
     });

    //   $(".btn-primary").click(function(){ 
    //       var lsthmtl = $(".clone").html();
    //       $(".increment").after(lsthmtl);
    //   });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".hdtuto").remove();
      });
    });   
</script>
