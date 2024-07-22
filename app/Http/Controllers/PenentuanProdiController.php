<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Prodi;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Validitas;
use App\Exports\DataExport;
use App\Models\Perangkingan;
use Illuminate\Http\Request;
use App\Models\MasterMapelProdi;
use App\Models\ProdiPerangkingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PenentuanProdiController extends Controller
{
    
    public function index()
    {
        
        $user = Auth::user();
        $id = $user->id;
        $data_prodi = Prodi::all();

        if($user->role == 'guru'){
        $datas = DB::table('perangkingan')
        ->join('siswa', 'siswa.id_siswa', '=', 'perangkingan.siswa_id')
        ->join('guru', 'guru.id_guru', '=','perangkingan.guru_id')
        ->select('siswa.*','perangkingan.*','guru.*')
        ->where('guru.user_id', $id)
        ->get();
        }elseif($user->role == 'siswa'){
            $datas = DB::table('perangkingan')
            ->join('siswa', 'siswa.id_siswa', '=', 'perangkingan.siswa_id')
            ->select('siswa.*','perangkingan.*')
            ->where('siswa.id_siswa', $id)
            ->get();  
        }
         // Data Menghitung Akurasi
         $DataValid = DB::table('perangkingan')
         ->join('guru', 'guru.id_guru', '=','perangkingan.guru_id')
         ->select('perangkingan.*','guru.*')
         ->where('guru.user_id', $id)
         ->where('perangkingan.status_validitas', 'Valid')
         ->count();
         $DataAll = DB::table('perangkingan')
         ->join('guru', 'guru.id_guru', '=','perangkingan.guru_id')
         ->select('perangkingan.*','guru.*')
         ->where('guru.user_id', $id)
         ->count();

      
        // $Akurasi = round(($DataValid/ $DataAll)*100,2);
      
       return view('guru.index', compact('datas','data_prodi','DataValid','DataAll'));
    }

    public function create()
    {
        
        $data_kriteria = Kriteria::all();
        $data_prodi = Prodi::all();
        $data_guru = Guru::all();
        $data_siswa = Siswa::all();
       
        return view('guru.add', compact('data_kriteria','data_prodi','data_guru','data_siswa'));
    }

    public function getMapel($prodi_id)
    {
        
        $mapel = MasterMapelProdi::where('prodi_id', $prodi_id)->pluck('mapel_id');
        $mapels = Mapel::whereIn('id_mapel', $mapel)->get(['id_mapel', 'nama_mapel']);

            $mapels->map(function ($mapel) use ($prodi_id) {
                $mapel->prodi_id = $prodi_id;
                return $mapel;
            });

        return response()->json($mapels);
    } 
    
    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     $id = $user->id;
       
       
    //     // Memeriksa apakah role pengguna adalah "siswa"
    //     if ($user->role == 'siswa') {
            
    //         DB::table('siswa')
    //         ->where('id_siswa', $id)
    //         ->update(['kelas' => $request->kelas]);
        
    //         $id_perangkingan = Perangkingan::create([ 
    //             'id_perangkingan' => 'reng-' . uniqid(),
    //             'siswa_id' => $id, 
    //             'guru_id' => '04', 
    //         ]);

    //     } elseif($user->role == 'guru')
    //     {
    //         $id_siswa = Siswa::create([
    //             'id_siswa'=>'si-'. uniqid(),
    //             'nama_siswa'=>$request->nama_siswa,
    //             'nis'=>$request->nis,
    //             'kelas'=>$request->kelas,
    //         ]);

    //         $id_perangkingan = Perangkingan::create([ 
    //             'id_perangkingan'=>'reng-'. uniqid(),
    //             'siswa_id'=>$id_siswa->id_siswa,
    //             'guru_id'=>$request->guru_id, 
    //         ]);     
    //     }

    //     $kriteria_ids = $request->input('kriteria_id');
    //         $nilai_kriteria = $request->input('nilai_kriteria');
    //         $pilihan = $request->input('pilihan_ke');
    //         $prodi_ids = $request->input('prodi_id');
    //         $prodi_1 = $prodi_ids[0];
    //         $prodi_2 = $prodi_ids[1];
    //         $prodi_3 = $prodi_ids[2];
    //         // $created_prodi_ids = [];
    //         $data_prestasi = $request->data_prestasi;
            
    //         if (count($nilai_kriteria ) != count($kriteria_ids) &&  $data_prestasi != null) {
    //             // Hitung berapa nilai_kriteria yang harus ditambahkan
    //             $jumlahNilaiKriteriaYangDitambahkan = count($kriteria_ids) - count($nilai_kriteria);
    
    //             // Tambahkan nilai "tidak ada" ke dalam array nilai_kriteria
    //             for ($i = 0; $i < $jumlahNilaiKriteriaYangDitambahkan; $i++) {
    //                 $nilai_kriteria[] = count($data_prestasi);
    //             }
    //         }elseif (count($nilai_kriteria ) != count($kriteria_ids) &&  $data_prestasi == null) {
    //             $jumlahNilaiKriteriaYangDitambahkan = count($kriteria_ids) - count($nilai_kriteria);
    
    //             // Tambahkan nilai "tidak ada" ke dalam array nilai_kriteria
    //             for ($i = 0; $i < $jumlahNilaiKriteriaYangDitambahkan; $i++) {
    //                 $nilai_kriteria[] = 0;
    //             }
    //         }
    
    //         foreach ($prodi_ids  as $prodi_id) {
    //             foreach ($kriteria_ids  as $index => $kriteria_id) {
    //                 $data = ProdiPerangkingan::create([
    //                     'perangkingan_id' => $id_perangkingan->id_perangkingan,
    //                     'prodi_id' => $prodi_id,
    //                     'kriteria_id' => $kriteria_id,
    //                     'nilai_kriteria' => $nilai_kriteria[$index],
    //                     'pilihan_ke' => $pilihan[$index],
    //                 ]);
    //             }
    //         }
    
    //         // Menghapus data berdasarkan kondisi tertentu
    //         ProdiPerangkingan::where('prodi_id', $prodi_1)
    //         ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
    //         ->whereNotIn('pilihan_ke', ['pilihan 1', '-'])
    //         ->delete();
    //         ProdiPerangkingan::where('prodi_id', $prodi_2)
    //         ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
    //         ->whereNotIn('pilihan_ke', ['pilihan 2', '-'])
    //         ->delete();
    //         ProdiPerangkingan::where('prodi_id', $prodi_3)
    //         ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
    //         ->whereNotIn('pilihan_ke', ['pilihan 3', '-'])
    //         ->delete();
    
    //         if ($request->hasFile('data_prestasi')) {
    //             foreach ($request->file('data_prestasi') as $file) {
    //                 $filename = 'pres-'.'.'.uniqid().'.'.$file->extension();
    //                 $file->move(public_path('/assets/data-prestasi'),$filename);
                    
    //                 DB::table('data_prestasi')->insert([
    //                     'perangkingan_id_pp' => $data->perangkingan_id,
    //                     'data_prestasi' => $filename // Menyimpan nama file atau path ke file
    //                 ]);
    //             }
    //         }
    
    //         return redirect('/perangkingan')->with('success','Data Berhasil Disimpan'); 
         
    // }

    public function store(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
    
        // Memeriksa apakah role pengguna adalah "siswa"
        if ($user->role == 'siswa') {
           
            $id_perangkingan = Perangkingan::create([
                'id_perangkingan' => 'reng-' . uniqid(),
                'siswa_id' => $id,
                'guru_id' => '04',
            ]);
        } elseif ($user->role == 'guru') {
            $id_siswa = Siswa::create([
                'id_siswa' => 'si-' . uniqid(),
                'nama_siswa' => $request->nama_siswa,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
            ]);
    
            $id_perangkingan = Perangkingan::create([
                'id_perangkingan' => 'reng-' . uniqid(),
                'siswa_id' => $id_siswa->id_siswa,
                'guru_id' => $request->guru_id,
            ]);
        }
    
        $kriteria_ids = $request->input('kriteria_id');
        $nilai_kriteria = $request->input('nilai_kriteria');
        $pilihan = $request->input('pilihan_ke');
        $prodi_ids = $request->input('prodi_id');
        $prodi_1 = $prodi_ids[0];
        $prodi_2 = $prodi_ids[1];
        $prodi_3 = $prodi_ids[2];
        $data_prestasi = $request->data_prestasi;
    
        if (count($nilai_kriteria) != count($kriteria_ids) && $data_prestasi != null) {
            // Hitung berapa nilai_kriteria yang harus ditambahkan
            $jumlahNilaiKriteriaYangDitambahkan = count($kriteria_ids) - count($nilai_kriteria);
    
            // Tambahkan nilai "tidak ada" ke dalam array nilai_kriteria
            for ($i = 0; $i < $jumlahNilaiKriteriaYangDitambahkan; $i++) {
                $nilai_kriteria[] = count($data_prestasi);
            }
        } elseif (count($nilai_kriteria) != count($kriteria_ids) && $data_prestasi == null) {
            $jumlahNilaiKriteriaYangDitambahkan = count($kriteria_ids) - count($nilai_kriteria);
    
            // Tambahkan nilai "tidak ada" ke dalam array nilai_kriteria
            for ($i = 0; $i < $jumlahNilaiKriteriaYangDitambahkan; $i++) {
                $nilai_kriteria[] = 0;
            }
        }
    
        foreach ($prodi_ids as $prodi_id) {
            foreach ($kriteria_ids as $index => $kriteria_id) {
                ProdiPerangkingan::create([
                    'perangkingan_id' => $id_perangkingan->id_perangkingan,
                    'prodi_id' => $prodi_id,
                    'kriteria_id' => $kriteria_id,
                    'nilai_kriteria' => $nilai_kriteria[$index],
                    'pilihan_ke' => $pilihan[$index],
                ]);
            }
        }
    
        // Menghapus data berdasarkan kondisi tertentu
        ProdiPerangkingan::where('prodi_id', $prodi_1)
            ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
            ->whereNotIn('pilihan_ke', ['pilihan 1', '-'])
            ->delete();
        ProdiPerangkingan::where('prodi_id', $prodi_2)
            ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
            ->whereNotIn('pilihan_ke', ['pilihan 2', '-'])
            ->delete();
        ProdiPerangkingan::where('prodi_id', $prodi_3)
            ->where('perangkingan_id', $id_perangkingan->id_perangkingan)
            ->whereNotIn('pilihan_ke', ['pilihan 3', '-'])
            ->delete();
    
        if ($request->hasFile('data_prestasi')) {
            foreach ($request->file('data_prestasi') as $file) {
                $filename = 'pres-' . uniqid() . '.' . $file->extension();
                $file->move(public_path('/assets/data-prestasi'), $filename);
    
                DB::table('data_prestasi')->insert([
                    'perangkingan_id_pp' => $id_perangkingan->id_perangkingan,
                    'data_prestasi' => $filename // Menyimpan nama file atau path ke file
                ]);
            }
        }
    
        return redirect('/perangkingan')->with('success', 'Data Berhasil Disimpan');
    }
    

     
    public function export()
    {
        return Excel::download(new DataExport,'DataSiswa.xlsx');
    }
   
    public function show(string $id)
    {
        $data = DB::table('prodi_perangkingan')
        ->join('prodi', 'prodi.id_prodi', '=', 'prodi_perangkingan.prodi_id')
        ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->join('siswa', 'siswa.id_siswa', '=', 'perangkingan.siswa_id')
        ->select('siswa.nis','siswa.nama_siswa','siswa.kelas','prodi.nama_prodi','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria','perangkingan.status_validitas')
        ->whereColumn('prodi.id_prodi', 'perangkingan.prodi_terpilih')
        ->where('siswa.id_siswa', $id) 
        ->get();
        // Inisialisasi struktur data yang diinginkan
        $formattedData = [];

        // Lakukan iterasi pada hasil query
        foreach ($data as $item) {
            // Buat array untuk setiap siswa berdasarkan NIS-nya
            if (!isset($formattedData[$item->nis])) {
                $formattedData[$item->nis] = [
                    "nis" => $item->nis,
                    "nama_siswa" => $item->nama_siswa,
                    "kelas" => $item->kelas,
                    "nama_prodi" => $item->nama_prodi,
                    "status_validitas" => $item->status_validitas
                ];
            }

            // Tambahkan nilai kriteria ke array siswa berdasarkan kriteria ID
            $formattedData[$item->nis][$item->kriteria_id] = $item->nilai_kriteria;
        }

        // Ubah array assoc menjadi indexed array
        $formattedData = array_values($formattedData);
        // die(var_dump($formattedData));
        return view('guru.show', compact('formattedData'));
        
    }

    public function destroy(string $id)
    {
        DB::table('prodi_perangkingan')
            ->join('prodi', 'prodi.id_prodi', '=', 'prodi_perangkingan.prodi_id')
            ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
            ->join('siswa', 'siswa.id_siswa', '=', 'perangkingan.siswa_id')
            ->select('siswa.nis','siswa.nama_siswa','siswa.kelas','prodi.nama_prodi','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria','perangkingan.status_validitas')
            ->whereColumn('prodi.id_prodi', 'perangkingan.prodi_terpilih')
            ->where('siswa.id_siswa', $id) 
            ->delete();
        
    }

    public function pilihrole()
    {
        return view('auth.choose');
    }
}
