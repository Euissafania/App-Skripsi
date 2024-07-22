<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Prodi;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;


class ProsesAlgoritmaController extends Controller
{
    public function perangkingan(string $id)
    {
        // Mengambil data nilai pembobotan kriteria
        $data = Kriteria::all()->toArray();
        $jml = count($data);
       
// Proses perbandingan antar kriteria dan mengkonversi nilai ke skala TFN
        foreach ($data as $item1) 
        {
            foreach ($data as $item2) {
                // Kondisi untuk menangani setiap kemungkinan kombinasi
                if ($item1 === $item2) {
                    // Jika item1 dan item2 sama, misalnya C1:C1, C2:C2, C3:C3
                    $hasil_perbandingan = 1;
                } else {
                    // Jika item1 dan item2 berbeda, misalnya C1-C2, C1-C3, dll.
                    $hasil_perbandingan= $item1["bobot"]-$item2["bobot"];
        }

                 // Menentukan hasil_array berdasarkan kondisi skala TFN
                switch ($hasil_perbandingan) {
                    case 1:
                        $konversi_tfn[] = [1, 1, 1];
                        break;
                    case 2:
                        $konversi_tfn[] = [0.5, 1, 1.5];
                        break;
                    case 3:
                        $konversi_tfn[] = [1, 1.5, 2];
                        break;
                    case 4:
                        $konversi_tfn[] = [1.5, 2, 2.5];
                        break;
                    case 5:
                        $konversi_tfn[] = [2, 2.5, 3];
                        break;
                    case 6:
                        $konversi_tfn[] = [2.5, 3, 3.5];
                        break;
                    case 7:
                        $konversi_tfn[] = [3, 3.5, 4];
                        break;
                    case 8:
                        $konversi_tfn[] = [3.5, 4, 4.5];
                        break;
                    case 9:
                        $konversi_tfn[] = [4, 4.5, 4.5];
                        break;
                    case -1:
                        $konversi_tfn[] = [1, 1, 1];
                        break;
                    case -2:
                        $konversi_tfn[] = [0.67, 1, 2];
                        break;
                    case -3:
                        $konversi_tfn[] = [0.5, 0.67, 1];
                        break;
                    case -4:
                        $konversi_tfn[] = [0.4, 0.5, 0.67];
                        break;
                    case -5:
                        $konversi_tfn[] = [0.33, 0.4, 0.5];
                        break;
                    case -6:
                        $konversi_tfn[] = [0.28, 0.33, 0.4];
                        break;
                    case -7:
                        $konversi_tfn[] = [0.25, 0.28, 0.33];
                        break;
                    case -8:
                        $konversi_tfn[] = [0.22, 0.25, 0.28];
                        break;
                    case -9:
                        $konversi_tfn[] = [0.22, 0.22, 0.25];
                        break;
                }

            }
        }
       
        // Membagi array menjadi setiap kelompok tiga
        $hasil_konversi = array_chunk($konversi_tfn, $jml);
       
// Proses fuzzy synthetic 
// Prose menjumlah masing masing l,m,u untuk setiap kriteria
/* kode ini berfungsi untuk menggabungkan nilai-nilai dari array dua dimensi 
$hasil_konversi ke dalam array $hasil_jumlah berdasarkan indeks mereka. 
Jika indeks belum ada di $hasil_jumlah, nilai akan diinisialisasi. 
Jika sudah ada, nilai-nilai akan dijumlahkan.*/
         // Inisialisasi array untuk menyimpan hasil penjumlahan
         $hasil_jumlah = [];
         // Iterasi melalui array untuk menjumlahkan masing-masing indeks yang sama
         foreach ($hasil_konversi as $kelompok) {
             foreach ($kelompok as $index => $nilai) {
                 if (!isset($hasil_jumlah[$index])) {
                     // Jika indeks belum ada, inisialisasikan dengan nilai saat ini
                     $hasil_jumlah[$index] = $nilai;
                 } else {
                     // Jika indeks sudah ada, tambahkan nilai saat ini ke nilai yang sudah ada
                     for ($i = 0; $i < count($nilai); $i++) {
                         $hasil_jumlah[$index][$i] += $nilai[$i];
                     }
                 }
             }
           }
        
        //  Index 0 dan 2 ketuker
         $array_reverse= array_reverse($hasil_jumlah);
        
    // Menjumlah total masing-masing l,m,u
         // Inisialisasi array untuk menyimpan hasil penjumlahan
        $hasil_lmu = [];
        // Iterasi melalui array untuk menjumlahkan masing-masing indeks yang sama
        foreach ($array_reverse as $array) {
            foreach ($array as $index => $nilai) {
                if (!isset($hasil_lmu[$index])) {
                    // Jika indeks belum ada, inisialisasikan dengan nilai saat ini
                    $hasil_lmu[$index] = $nilai;
                } else {
                    // Jika indeks sudah ada, tambahkan nilai saat ini ke nilai yang sudah ada
                    $hasil_lmu[$index] += $nilai;
                }
            }
        }
    // Membagi masing-masing l,m,u dengan jumlah total dari l,m,u  
        // Membagi elemen-elemen array_reverse dengan elemen yang sesuai di array_jml
        for ($i = 0; $i < count($array_reverse); $i++) {
            $fuzzy_synthetic [$i][0] = round($array_reverse[$i][0] / $hasil_lmu[2],2);
            $fuzzy_synthetic [$i][1] = round($array_reverse[$i][1] / $hasil_lmu[1],2);
            $fuzzy_synthetic [$i][2] = round($array_reverse[$i][2] / $hasil_lmu[0],2);
        }
       
// Menghitung Nila Prioritas Vektor
        $hasil_prioritas = [];
        foreach ($fuzzy_synthetic  as $data1) {
            foreach ($fuzzy_synthetic  as $data2) {
                // Kondisi untuk menangani setiap kemungkinan kombinasi
                if ($data1[1] === $data2[1] || $data1[1] > $data2[1]) {
                    // Jika item1 dan item2 sama, misalnya C1:C1, C2:C2, C3:C3
                    $hasil_prioritas[] = 1;
                } else {
                    // Jika item1 dan item2 berbeda, misalnya C1-C2, C1-C3, dll.
                    
                    // $rumus = (-0.4/-0.5);
                    $rumus= ($data2[0] - $data1[2]) / (($data1[1] - $data1[2]) - ($data2[1] - $data2[0]));
                    $hasil_prioritas[] = round($rumus,2);
                }
            }
        }
        $array_prioritas = array_chunk($hasil_prioritas, $jml);
      
// Proses Defuzzifikasi dengan mencari nilai minimal
        $defuzzifikasi_minimal = [];
        foreach ($array_prioritas as $array) {
            // Menggunakan fungsi min() untuk mencari nilai minimum dari setiap array
            $defuzzifikasi_minimal[] = [min($array)];
        }
       
// Normalisasi bobot Vektor
    //  Menjumlahkan total hasil defuzzifikasi
        $total_defuzzifikasi_minimal = 0;
        foreach ($defuzzifikasi_minimal as $array) {
            // Menambahkan setiap elemen array ke total
            $total_defuzzifikasi_minimal += $array[0];
        }
    // Membagi masing-masing hasil defuzzifikasi dengan jumlah total hasil defuzzyfikasi
        // Memastikan total tidak nol untuk menghindari pembagian oleh nol
        if ($total_defuzzifikasi_minimal != 0) {
            // Fungsi callback untuk membagi setiap elemen dengan total
            $normalisasi = array_map(function($array) use ($total_defuzzifikasi_minimal) {

                return [ round($array[0] / $total_defuzzifikasi_minimal,2) ];
            }, $defuzzifikasi_minimal);
        }
// die(var_dump($normalisasi));
// Mempersiapkan Nilai kriteria Siswa
        $datas = DB::table('prodi_perangkingan')
        ->join('prodi', 'id_prodi', '=', 'prodi_perangkingan.prodi_id')
        ->join('perangkingan', 'id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->join('siswa', 'id_siswa', '=', 'perangkingan.siswa_id')
        ->select('siswa.*','perangkingan.*','prodi_perangkingan.*', 'prodi.*')
        ->where('siswa.id_siswa', $id)
        ->get();
    
        // $nilai_kriteria = [];

        foreach ($datas as $data) {
            // Decode nilai_kriteria sebagai array
            $nilai_kriteria[] = $data->nilai_kriteria;
        }
        $nilai_siswa = array_chunk($nilai_kriteria, $jml);
        $json_nilai = json_encode($nilai_siswa);

        // Melakukan perkalian masing-masing hasil FAHP dan nilai kriteria siswa
        $result = array();
        for ($i = 0; $i < count($nilai_siswa); $i++) {
            $temp = array();
            for ($j = 0; $j < count($nilai_siswa[$i]); $j++) {
                // Melakukan perkalian sesuai dengan instruksi
                $temp[] = round($nilai_siswa[$i][$j]*$normalisasi[$j][0],2);
            }
            $result[] = $temp;
        }
       

// Penetuan Prodi sesuai nilai yang paling tinggi
        // Array untuk menyimpan hasil penjumlahan masing-masing array
        $sum_nilai_fahp = [];

        // Melakukan penjumlahan masing-masing array
        foreach ($result as $array) {
            $sum_nilai= array_sum($array); // Menggunakan fungsi array_sum() untuk menjumlahkan elemen-elemen dalam array
            $sum_nilai_fahp[] = [$sum_nilai]; // Menyimpan hasil penjumlahan ke dalam array $sum_nilai_fahp
        }
       
        // Mendapatkan Nilai Tebesar dan Indexnya 
        // Nilai dan indeks awal yang akan diperbarui saat melakukan iterasi
        $max_value = NULL;
        $max_index = NULL;

        // Melakukan iterasi melalui array
        foreach ($sum_nilai_fahp as $index => $inner_array) {
            // Mengambil nilai dari array dalam array
            $value = $inner_array[0];
            
            // Memeriksa apakah nilai lebih besar dari yang sebelumnya
            if ($max_value === NULL || $value > $max_value) {
                $max_value = $value;
                $max_index = $index;
            }
        }

        // mengambil data prodi
        foreach ($datas as $data) {
            // Decode nilai_kriteria sebagai array
            $prodi[] = $data->id_prodi;
        }
        
        // Menghapus duplikat menggunakan array_unique()
        $prodi = array_unique($prodi);
        
        // Mendapatkan indeks array baru menggunakan array_values()
        $prodi = array_values($prodi);

// Melakukan update 
        if (isset($prodi[$max_index])) {
            $prodi_terpilih = $prodi[$max_index];
            
            // $prodi_terpilih = ['prd-1','prd-2']
            // Jika prodi_terpilih lebih dari satu, ambil yang pertama
            if (is_array($prodi_terpilih) && count($prodi_terpilih) > 1) {
                $prodi_terpilih = $prodi_terpilih[0];
            }
    
            // Lakukan update ke dalam tabel prodi_perangkingan
            DB::table('perangkingan')
                ->where('siswa_id', $id)
                ->update(['prodi_terpilih' => $prodi_terpilih]);
                    
            return redirect('/perangkingan')
                ->with('success', 'Prodi terpilih berhasil diupdate');
        }

    }

    public function home()
    {
        $data_kriteria = Kriteria::all();
        $data_mapel = Mapel::all();
        $data_prodi = Prodi::orderBy('created_at', 'asc')->get();
        $data_mapel_prodi = DB::table('master_mapel_prodi')
        ->join('mapel', 'mapel.id_mapel', '=', 'master_mapel_prodi.mapel_id')
        ->join('prodi', 'prodi.id_prodi', '=', 'master_mapel_prodi.prodi_id')
        ->select('prodi.*','mapel.*','master_mapel_prodi.*')
        ->get();
        return view('guru.home',compact('data_kriteria','data_prodi','data_mapel','data_mapel_prodi'));
    }

}
        


 

