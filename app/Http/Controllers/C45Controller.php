<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Support\Facades\DB;

class C45Controller extends Controller
{
        // Algoritma Decision Tree C4.5
    public function  ProsesC45($newData)
    {    
        //  Untuk Formating data agar lebih mudah 
        foreach ($newData as $nilai) {
            foreach ($nilai as $alternatif => $nilaiData) {
                if (count($nilaiData) == 3) {
                    $data[] = [
                        'C-01' => $nilaiData[0],
                        'C-02' => $nilaiData[1],
                        'C-03' => $nilaiData[2],
                        'Alternatif Terpilih' => $alternatif
                    ];
                }
                // Jika key 1 tidak ada
                elseif (!isset($nilaiData[1])) {
                    $data[] = [
                        'C-01' => $nilaiData[0],
                        'C-03' => $nilaiData[2],
                        'Alternatif Terpilih' => $alternatif
                    ];
                }
                // Jika key 3 tidak ada
                elseif (!isset($nilaiData[2])) {
                    $data[] = [
                        'C-01' => $nilaiData[0],
                        'C-02' => $nilaiData[1],
                        'Alternatif Terpilih' => $alternatif
                    ];
                }
            }
        }
          
        // ==========Proses Klasifikasi Dan Penjumlahan===========//
           // Hitung total data
            $total_data = count($data);
            $alternatif_counts = [];
            // Inisialisasi variabel untuk menyimpan jumlah data yang memenuhi kriteria
            $count_C1_gt_85 = 0;
            $count_C1_lt_85 = 0;
            $count_C2_gt_85 = 0;
            $count_C2_lt_85 = 0;
            $count_C3_gt_1 = 0;
            $count_C3_lt_1 = 0;

            // Array untuk menyimpan total Alternatif Terpilih
            $total_alternatif_gt_85_C1 = [];
            $total_alternatif_lt_85_C1 = [];
            $total_alternatif_gt_85_C2 = [];
            $total_alternatif_lt_85_C2 = [];
            $total_alternatif_gt_1_C3 = [];
            $total_alternatif_lt_1_C3 = [];

            // Iterasi untuk menghitung dan mengklasifikasi data
            foreach ($data as $item) {
                // Kondisi Menklasifikasi prodi terpilih
                $alternatif = $item["Alternatif Terpilih"];
                // Periksa apakah alternatif sudah ada di dalam array asosiatif
                if (isset($alternatif_counts[$alternatif])) {
                    // Jika alternatif sudah ada, tambahkan jumlah kemunculannya
                    $alternatif_counts[$alternatif]++;
                } else {
                    // Jika alternatif belum ada, buat kunci baru dengan jumlah kemunculan yang sesuai
                    $alternatif_counts[$alternatif] = 1;
                }
                // Cek kondisi untuk C1
                if ($item['C-01'] >= 85) {
                    $count_C1_gt_85 ++;
                    if (!isset($total_alternatif_gt_85_C1[$item['Alternatif Terpilih']])) {
                        $total_alternatif_gt_85_C1[$item['Alternatif Terpilih']] = 1;
                    } else {
                        $total_alternatif_gt_85_C1[$item['Alternatif Terpilih']]++;
                    }
                } else {
                    $count_C1_lt_85 ++;
                    if (!isset(  $total_alternatif_lt_85_C1[$item['Alternatif Terpilih']])) {
                          $total_alternatif_lt_85_C1[$item['Alternatif Terpilih']] = 1;
                    } else {
                          $total_alternatif_lt_85_C1[$item['Alternatif Terpilih']]++;
                    }
                }

                // Cek kondisi untuk C2
                if ($item['C-02'] >= 85) {
                    $count_C2_gt_85 ++;
                    if (!isset(  $total_alternatif_gt_85_C2[$item['Alternatif Terpilih']])) {
                          $total_alternatif_gt_85_C2[$item['Alternatif Terpilih']] = 1;
                    } else {
                          $total_alternatif_gt_85_C2[$item['Alternatif Terpilih']]++;
                    }
                } else {
                    $count_C2_lt_85 ++;
                    if (!isset(  $total_alternatif_lt_85_C2[$item['Alternatif Terpilih']])) {
                          $total_alternatif_lt_85_C2[$item['Alternatif Terpilih']] = 1;
                    } else {
                          $total_alternatif_lt_85_C2[$item['Alternatif Terpilih']]++;
                    }
                }
               
                // Cek kondisi untuk C3
                if (isset( $item['C-03'])) {
                    if ($item['C-03'] >= 1) {
                        $count_C3_gt_1 ++;
                        if (!isset(  $total_alternatif_gt_1_C3[$item['Alternatif Terpilih']])) {
                              $total_alternatif_gt_1_C3[$item['Alternatif Terpilih']] = 1;
                        } else {
                              $total_alternatif_gt_1_C3[$item['Alternatif Terpilih']]++;
                        }
                    } else {
                        $count_C3_lt_1 ++;
                        if (!isset(  $total_alternatif_lt_1_C3[$item['Alternatif Terpilih']])) {
                              $total_alternatif_lt_1_C3[$item['Alternatif Terpilih']] = 1;
                        } else {
                              $total_alternatif_lt_1_C3[$item['Alternatif Terpilih']]++;
                        }
                    }
                }


            }
// ==========   Perhitungan Entropy ====================
        // Inisialisasi variabel untuk menyimpan total entropi
        $total_entropi_counts = 0;
        $total_entropi_gt_85_C1 = 0;
        $total_entropi_lt_85_C1 = 0;
        $total_entropi_gt_85_C2 = 0;
        $total_entropi_lt_85_C2 =0;
        $total_entropi__gt_1_C3 =0 ;
        $total_entropi_lt_1_C3  = 0;

        // Hitung entropi untuk setiap nilai dalam $alternatif_counts
        foreach ($alternatif_counts as &$value) {
           $entropi = (-$value / $total_data) * log($value / $total_data, 2);
            $total_entropi_counts += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_gt_85_C1
        foreach ($total_alternatif_gt_85_C1 as &$value) {
           $entropi = (-intval($value) / $count_C1_gt_85) * log(intval($value) / $count_C1_gt_85, 2);
            $total_entropi_gt_85_C1 += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_lt_85_C1
        foreach ($total_alternatif_lt_85_C1 as &$value) {
           $entropi = (-intval($value) / $count_C1_lt_85) * log(intval($value) / $count_C1_lt_85, 2);
            $total_entropi_lt_85_C1 += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_gt_85_C2
        foreach ($total_alternatif_gt_85_C2 as &$value) {
           $entropi = (-intval($value) / $count_C2_gt_85) * log(intval($value) / $count_C2_gt_85, 2);
            $total_entropi_gt_85_C2 += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_lt_85_C2
        foreach ($total_alternatif_lt_85_C2 as &$value) {
           $entropi = (-intval($value) / $count_C2_lt_85) * log(intval($value) / $count_C2_lt_85, 2);
            $total_entropi_lt_85_C2 += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_ge_1_C3
        foreach ($total_alternatif_gt_1_C3 as &$value) {
           $entropi = (-intval($value) / $count_C3_gt_1) * log(intval($value) / $count_C3_gt_1, 2);
            $total_entropi__gt_1_C3 += $entropi; // Tambahkan nilai entropi ke total entropi
        }

        // Hitung entropi untuk setiap nilai dalam $total_alternatif_lt_1_C3
        foreach ($total_alternatif_lt_1_C3 as &$value) {
           $entropi = (-intval($value) / $count_C3_lt_1) * log(intval($value) / $count_C3_lt_1, 2);
            $total_entropi_lt_1_C3  += $entropi; // Tambahkan nilai entropi ke total entropi
        }
        
// ==================Perhitungan Gain ========================================
       $data_proses_gain =[
        $count_C1_gt_85 ,
        $count_C1_lt_85 ,
        $count_C2_gt_85 ,
        $count_C2_lt_85 ,
        $count_C3_gt_1 ,
        $count_C3_lt_1 ,
       ];
       $data_entropi =[
        $total_entropi_gt_85_C1 ,
        $total_entropi_lt_85_C1 ,
        $total_entropi_gt_85_C2 ,
        $total_entropi_lt_85_C2 ,
        $total_entropi__gt_1_C3 ,
        $total_entropi_lt_1_C3  ,
       ];

       // Inisialisasi array untuk menampung hasil perhitungan
        $prosesgainArray = [];

        // Loop melalui array data dan lakukan perhitungan
        for ($i = 0; $i < count($data_proses_gain); $i++) {
            // Lakukan perhitungan untuk setiap elemen
            $prosesgain = ($data_proses_gain[$i] / $total_data) * $data_entropi[$i];
            // Tambahkan hasil perhitungan ke array hasil
            $prosesgainArray[] = $prosesgain;
        }
        // Inisialisasi array untuk menampung hasil penjumlahan
        $sumProsesGain = [];

        // Loop melalui array data dan lakukan penjumlahan
        for ($i = 0; $i < count($prosesgainArray); $i += 2) {
            // Lakukan penjumlahan untuk setiap dua elemen
            $sum = $prosesgainArray[$i] + $prosesgainArray[$i + 1];
            // Tambahkan hasil penjumlahan ke dalam array
            $sumProsesGain[] = $sum;
        }
        // Ngitung Gain
        // Inisialisasi array untuk menampung hasil perkalian
        $nilai_gain = [];

        // Loop melalui array data dan lakukan pengurangan
        foreach ($sumProsesGain as $value) {
            // Lakukan pengurangan untuk setiap elemen dengan $total_entropi_counts
            $result =  $value - $total_entropi_counts;
            // Tambahkan hasil pengurangan ke dalam array
            $nilai_gain[] = $result;
        }

        // Nama-nama kunci baru
        $keys = ['C-01', 'C-02', 'C-03'];

        // Menggabungkan array asli dengan array kunci baru
        $Array_nilai_gain = array_combine($keys, $nilai_gain);

        // Mencari nilai gain tertinggi
        $maxValue = NULL;
        $maxKey = NULL;

        foreach ($Array_nilai_gain as $key => $value) {
            if ($maxValue === NULL || $value > $maxValue) {
                $maxValue = $value;
                $maxKey = $key;
            }
        }
        if ( $maxKey === "C-01") {
            $nilai =85;
            $array = 0;
        }elseif($maxKey === "C-02" ){
            $nilai =85;
            $array = 1;
        } else{
            $nilai =1;
            $array = 2;
        }
        $maxGain =[$maxKey,$maxValue, $nilai,$array];
        return $maxGain;     
}

    public function RootNode(){
        // Persiapan Data
        $data_validitas = DB::table('prodi_perangkingan')
            ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
            ->select('perangkingan.siswa_id','perangkingan.prodi_terpilih','prodi_perangkingan.nilai_kriteria')
            ->whereColumn('perangkingan.prodi_terpilih', '=', 'prodi_perangkingan.prodi_id')
            ->get();

        $newData = [];
        foreach ($data_validitas as $item) {
            $siswaId = $item->siswa_id;
            $prodiTerpilih = $item->prodi_terpilih;
            $nilaiKriteria = $item->nilai_kriteria;
        
            // Jika kunci belum ada, inisialisasikan dengan array kosong
            if (!isset($newData[$siswaId][$prodiTerpilih])) {
                $newData[$siswaId][$prodiTerpilih] = [];
            }
        
            // Tambahkan nilai kriteria ke dalam array
            $newData[$siswaId][$prodiTerpilih][] = $nilaiKriteria;
        }
        
        // Memanggil ProsesC45 dan menyimpan hasilnya
        $gain_RootNode = $this->ProsesC45($newData);
        
        return $gain_RootNode ;
    }

    public function RightNode()
    {
        $data_validitas = DB::table('prodi_perangkingan')
        ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->select('perangkingan.siswa_id','perangkingan.prodi_terpilih','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria')
        ->whereColumn('perangkingan.prodi_terpilih', '=', 'prodi_perangkingan.prodi_id')
        ->get();
       
        $gain_RootNode = $this->RootNode();

        $Data_format = [];
        foreach ($data_validitas as $item) {
            $siswaId = $item->siswa_id;
            $prodiTerpilih = $item->prodi_terpilih;
            $nilaiKriteria = $item->nilai_kriteria;
        
            // Jika kunci belum ada, inisialisasikan dengan array kosong
            if (!isset($Data_format[$siswaId][$prodiTerpilih])) {
                $Data_format[$siswaId][$prodiTerpilih] = [];
            }
        
            // Tambahkan nilai kriteria ke dalam array
            $Data_format[$siswaId][$prodiTerpilih][] = $nilaiKriteria;
        }

// ================== Mencari Data Yang Lebih Dari RootNode Dan Menentukan Decision Node=================
        $newData = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[$gain_RootNode[3]] >= $gain_RootNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
        
        foreach ( $newData as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya tiga elemen
                if (count($prodiData) >= 3) {
                    // Hapus elemen ketiga dari larik
                    array_splice($prodiData,  $gain_RootNode[3], $gain_RootNode[3]);
                }
            }
        }
        $gain_DecisionNode = $this->ProsesC45($newData);
       
//========== Persiapan Data Untuk menghitung Data Yang lebih Dari $gain_DecisionNode Dan Menentukan Leaft Node =============
        $newData_left_Node_gt = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[ $gain_DecisionNode[3]] >=  $gain_DecisionNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData_left_Node_gt[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
        
        
        foreach ( $newData_left_Node_gt as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya tiga elemen
                if (count($prodiData) >= 3) {
                    // Hapus elemen ketiga dari larik
                    array_splice($prodiData,  $gain_DecisionNode[3]);
                }
            }
        }
        
        // Klasifikasi Data Yang lebih Dari 
        $greaterThanEqual85 = [];
        $lessThan85 = [];
    // Lakukan iterasi pada data dan klasifikasikan
        foreach ($newData_left_Node_gt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilaiArray) {
                foreach ($nilaiArray as $nilai) {
                    if ($nilai >= $gain_DecisionNode[2]) {
                        $greaterThanEqual85[$siswaId][$kodeProdi] = $nilai;
                    } else {
                        $lessThan85[$siswaId][$kodeProdi] = $nilai;
                    }
                }
            }
        }
       
    // ==============Lebih Dari==================
        $countByProdi_gt85 = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $greaterThanEqual85 as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_gt85[$kodeProdi])) {
                    $countByProdi_gt85[$kodeProdi] = 0;
                }
                    $countByProdi_gt85[$kodeProdi]++;
            }
        }
       
   // ==================Kurang Dari ==================
        $countByProdi_lt85 = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $lessThan85  as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_lt85[$kodeProdi])) {
                    $countByProdi_lt85[$kodeProdi] = 0;
                }
                $countByProdi_lt85[$kodeProdi]++;
            }
        }

//================== $gain_DecisionNode  Kurang Dari ======================
        $newData_left_Node_lt = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[ $gain_DecisionNode[3]] < $gain_DecisionNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData_left_Node_lt[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
        foreach ( $newData_left_Node_lt as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya tiga elemen
                if (count($prodiData) >= 3) {
                    // Hapus elemen ketiga dari larik
                    array_splice($prodiData,  $gain_DecisionNode[3]);
                }
            }
        }
        $greaterThanEqual85_lt = [];
        $lessThan85_lt = [];
        // Lakukan iterasi pada data dan klasifikasikan
        foreach ($newData_left_Node_lt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilaiArray) {
                foreach ($nilaiArray as $nilai) {
                    if ($nilai >= 85) {
                        $greaterThanEqual85_lt[$siswaId][$kodeProdi] = $nilai;
                    } else {
                        $lessThan85_lt[$siswaId][$kodeProdi] = $nilai;
                    }
                }
            }
        }
        // ==============Lebih Dari==================
        $countByProdi_gt85_lt = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $greaterThanEqual85_lt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_gt85_lt[$kodeProdi])) {
                    $countByProdi_gt85_lt[$kodeProdi] = 0;
                }
                    $countByProdi_gt85_lt[$kodeProdi]++;
            }
        }
       
        // ==================Kurang Dari ==================
        $countByProdi_lt85_lt = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $lessThan85_lt  as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_lt85_lt[$kodeProdi])) {
                    $countByProdi_lt85_lt[$kodeProdi] = 0;
                }
                $countByProdi_lt85_lt[$kodeProdi]++;
            }
        }
      
        if($gain_RootNode[0] === "C-01" && $gain_DecisionNode[0] === "C-02")
        {
            $kriteria_leftNode = "C-03";
            $nilai =1;
        } elseif($gain_RootNode[0] === "C-01" && $gain_DecisionNode[0] === "C-03")
        {
            $kriteria_leftNode = "C-02";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-02" && $gain_DecisionNode[0] === "C-01")
        {
            $kriteria_leftNode = "C-03";
            $nilai =1;
        } elseif($gain_RootNode[0] === "C-02" && $gain_DecisionNode[0] === "C-03")
        {
            $kriteria_leftNode = "C-01";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-03" && $gain_DecisionNode[0] === "C-01")
        {
            $kriteria_leftNode = "C-02";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-03" && $gain_DecisionNode[0] === "C-02")
        {
            $kriteria_leftNode = "C-01";
            $nilai =85;
        }

        $data_RightNode =[ $gain_RootNode[0], $gain_RootNode[2],$gain_DecisionNode[0],$gain_DecisionNode[2],$kriteria_leftNode, $nilai, $countByProdi_gt85, $countByProdi_lt85,$kriteria_leftNode, $nilai, $countByProdi_gt85_lt, $countByProdi_lt85_lt];
        
        return  $data_RightNode;
        

    }  

    public function LeftNode()
    {
        $data_validitas = DB::table('prodi_perangkingan')
        ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->select('perangkingan.siswa_id','perangkingan.prodi_terpilih','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria')
        ->whereColumn('perangkingan.prodi_terpilih', '=', 'prodi_perangkingan.prodi_id')
        ->get();
       
        $gain_RootNode = $this->RootNode();
         
        // Data Lebih Dari >=$gain_RootNode 
        $Data_format = [];
        foreach ($data_validitas as $item) {
            $siswaId = $item->siswa_id;
            $prodiTerpilih = $item->prodi_terpilih;
            $nilaiKriteria = $item->nilai_kriteria;
        
            // Jika kunci belum ada, inisialisasikan dengan array kosong
            if (!isset($Data_format[$siswaId][$prodiTerpilih])) {
                $Data_format[$siswaId][$prodiTerpilih] = [];
            }
        
            // Tambahkan nilai kriteria ke dalam array
            $Data_format[$siswaId][$prodiTerpilih][] = $nilaiKriteria;
        }

// ================== Mencari Data Yang Lebih Dari RootNode Dan Menentukan Decision Node=================
        $newData = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[$gain_RootNode[3]] < $gain_RootNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
        foreach ( $newData as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya tiga elemen
                if (count($prodiData) >= 3) {
                    // Hapus elemen ketiga dari larik
                    array_splice($prodiData,  $gain_RootNode[3], $gain_RootNode[3]);
                }
            }
        }
        $gain_DecisionNode = $this->ProsesC45($newData);
       
        
//========== Persiapan Data Untuk menghitung Data Yang lebih Dari $gain_DecisionNode Dan Menentukan Leaft Node =============
        $newData_left_Node_gt = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[ $gain_DecisionNode[3]] >=  $gain_DecisionNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData_left_Node_gt[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
       
        foreach ($newData_left_Node_gt as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya dua elemen
                if (count($prodiData) >= 2) {
                    // Hapus elemen pertama
                    array_shift($prodiData);
                    // Hapus elemen terakhir
                    array_pop($prodiData);
                }
            }
        }
     
        // Klasifikasi Dara Yang lebih Dari 
        $greaterThanEqual85 = [];
        $lessThan85 = [];
    // Lakukan iterasi pada data dan klasifikasikan
        foreach ($newData_left_Node_gt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilaiArray) {
                foreach ($nilaiArray as $nilai) {
                    if ($nilai >= $gain_DecisionNode[2]) {
                        $greaterThanEqual85[$siswaId][$kodeProdi] = $nilai;
                    } else {
                        $lessThan85[$siswaId][$kodeProdi] = $nilai;
                    }
                }
            }
        }
       
    // ==============Lebih Dari==================
        $countByProdi_gt85 = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $greaterThanEqual85 as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_gt85[$kodeProdi])) {
                    $countByProdi_gt85[$kodeProdi] = 0;
                }
                    $countByProdi_gt85[$kodeProdi]++;
            }
        }
       
   // ==================Kurang Dari ==================
        $countByProdi_lt85 = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $lessThan85  as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_lt85[$kodeProdi])) {
                    $countByProdi_lt85[$kodeProdi] = 0;
                }
                $countByProdi_lt85[$kodeProdi]++;
            }
        }
       
//================== $gain_DecisionNode  Kurang Dari ======================
        $newData_left_Node_lt = [];
        // Loop melalui newData dan aplikasikan kondisi
        foreach ($Data_format as $siswaId => $nilai) {
            foreach ($nilai as $prodiTerpilih => $nilaiData) {
                // Cek kondisi array[2] >= 1
                if ($nilaiData[$gain_DecisionNode[3]] < $gain_DecisionNode[2]) {
                    // Tambahkan data yang memenuhi kondisi ke array $data_validitas
                    $newData_left_Node_lt[$siswaId][$prodiTerpilih] = $nilaiData;
                }
            }
        }
        
        foreach ($newData_left_Node_lt as &$siswaData) {
            foreach ($siswaData as &$prodiData) {
                // Periksa apakah larik memiliki setidaknya dua elemen
                if (count($prodiData) >= 2) {
                    // Hapus elemen pertama
                    array_shift($prodiData);
                    // Hapus elemen terakhir
                    array_pop($prodiData);
                }
            }
        }
        $greaterThanEqual85_lt = [];
        $lessThan85_lt = [];
        // Lakukan iterasi pada data dan klasifikasikan
        foreach ($newData_left_Node_lt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilaiArray) {
                foreach ($nilaiArray as $nilai) {
                    if ($nilai >= 85) {
                        $greaterThanEqual85_lt[$siswaId][$kodeProdi] = $nilai;
                    } else {
                        $lessThan85_lt[$siswaId][$kodeProdi] = $nilai;
                    }
                }
            }
        }
        // ==============Lebih Dari==================
        $countByProdi_gt85_lt = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $greaterThanEqual85_lt as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_gt85_lt[$kodeProdi])) {
                    $countByProdi_gt85_lt[$kodeProdi] = 0;
                }
                    $countByProdi_gt85_lt[$kodeProdi]++;
            }
        }
      
        // ==================Kurang Dari ==================
        $countByProdi_lt85_lt = [];
        // Lakukan iterasi pada data dan hitung jumlahnya berdasarkan kode prodi
        foreach ( $lessThan85_lt  as $siswaId => $prodiData) {
            foreach ($prodiData as $kodeProdi => $nilai) {
                if (!isset($countByProdi_lt85_lt[$kodeProdi])) {
                    $countByProdi_lt85_lt[$kodeProdi] = 0;
                }
                $countByProdi_lt85_lt[$kodeProdi]++;
            }
        }


        if($gain_RootNode[0] === "C-01" && $gain_DecisionNode[0] === "C-02")
        {
            $kriteria_leftNode = "C-03";
            $nilai =1;
        } elseif($gain_RootNode[0] === "C-01" && $gain_DecisionNode[0] === "C-03")
        {
            $kriteria_leftNode = "C-02";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-02" && $gain_DecisionNode[0] === "C-01")
        {
            $kriteria_leftNode = "C-03";
            $nilai =1;
        } elseif($gain_RootNode[0] === "C-02" && $gain_DecisionNode[0] === "C-03")
        {
            $kriteria_leftNode = "C-01";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-03" && $gain_DecisionNode[0] === "C-01")
        {
            $kriteria_leftNode = "C-02";
            $nilai =85;
        }elseif($gain_RootNode[0] === "C-03" && $gain_DecisionNode[0] === "C-02")
        {
            $kriteria_leftNode = "C-01";
            $nilai =85;
        }

        $data_LeftNode =[ $gain_RootNode[0], $gain_RootNode[2],$gain_DecisionNode[0],$gain_DecisionNode[2],$kriteria_leftNode, $nilai, $countByProdi_gt85, $countByProdi_lt85,$kriteria_leftNode, $nilai, $countByProdi_gt85_lt, $countByProdi_lt85_lt];
        return $data_LeftNode;
    }

    public function CekValiditas(string $id)
    {
        $data = DB::table('prodi_perangkingan')
        ->join('prodi', 'id_prodi', '=', 'prodi_perangkingan.prodi_id')
        ->join('perangkingan', 'id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->join('siswa', 'id_siswa', '=', 'perangkingan.siswa_id')
        ->select('perangkingan.siswa_id','perangkingan.prodi_terpilih','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria')
        ->where('siswa.id_siswa', $id)
        ->get();
        $Data_format = [];
        foreach ($data as $item) {
            $siswaId = $item->siswa_id;
            $prodiTerpilih = $item->prodi_terpilih;
            $nilaiKriteria = $item->nilai_kriteria;
        
            // Jika kunci belum ada, inisialisasikan dengan array kosong
            if (!isset($Data_format[$siswaId][$prodiTerpilih])) {
                $Data_format[$siswaId][$prodiTerpilih] = [];
            }
        
            // Tambahkan nilai kriteria ke dalam array
            $Data_format[$siswaId][$prodiTerpilih][] = $nilaiKriteria;
        }
        foreach ($Data_format as $nilai) {
            foreach ($nilai as $alternatif => $nilaiData) {
              
                    $datas[] = [
                        'C-01' => $nilaiData[0],
                        'C-02' => $nilaiData[1],
                        'C-03' => $nilaiData[2],
                        'Alternatif Terpilih' => $alternatif
                    ];
            }
        }
        $RihtNode = $this->RightNode() ;
        $LeftNode = $this->LeftNode() ;
       
        // $status = [];

        foreach ($datas as $item) {
            // RightNode
            if (intval($item["C-03"]) >= $RihtNode[1] && intval($item["C-02"]) >= $RihtNode[3] && intval($item["C-01"]) >= $RihtNode[5] && array_key_exists($item['Alternatif Terpilih'],$RihtNode[6])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) >= $RihtNode[1] && intval($item["C-02"]) >= $RihtNode[3] && intval($item["C-01"]) < $RihtNode[5] && array_key_exists($item['Alternatif Terpilih'],$RihtNode[7])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) >= $RihtNode[1] && intval($item["C-02"]) < $RihtNode[3] && intval($item["C-01"]) >= $RihtNode[5] && array_key_exists($item['Alternatif Terpilih'],$RihtNode[10])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) >= $RihtNode[1] && intval($item["C-02"]) < $RihtNode[3] && intval($item["C-01"]) < $RihtNode[5] && array_key_exists($item['Alternatif Terpilih'],$RihtNode[11])) {
                $status = 'Valid';
            }
            // Left Node
            elseif (intval($item["C-03"]) < $LeftNode[1] && intval($item["C-01"]) >= $LeftNode[3] && intval($item["C-02"]) >= $LeftNode[5] && array_key_exists($item['Alternatif Terpilih'],$LeftNode[6])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) < $LeftNode[1] && intval($item["C-01"]) >= $LeftNode[3] && intval($item["C-02"]) < $LeftNode[5] && array_key_exists($item['Alternatif Terpilih'],$LeftNode[7])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) < $LeftNode[1] && intval($item["C-01"]) < $LeftNode[3] && intval($item["C-02"]) >= $LeftNode[5] && array_key_exists($item['Alternatif Terpilih'],$LeftNode[10])) {
                $status = 'Valid';
            }elseif (intval($item["C-03"]) < $LeftNode[1] && intval($item["C-01"]) < $LeftNode[3] && intval($item["C-02"]) < $LeftNode[5] && array_key_exists($item['Alternatif Terpilih'],$LeftNode[11])) {
                $status = 'Valid';
            }
            else{
                $status = 'Tidak Valid';

            }
        }
        DB::table('perangkingan')
        ->where('siswa_id', $id)
        ->update(['status_validitas' => $status]);
            
       return redirect('/perangkingan')
        ->with('success', 'Prodi terpilih berhasil diupdate');
    }

    public function ViewRule()
    {

        $RootNode = $this->RootNode() ;
        $RihtNode = $this->RightNode() ;
        $LeftNode = $this->LeftNode() ;
        $data_prodi = Prodi::all();
       
        return view('guru.ruleC45', compact('RihtNode','LeftNode','data_prodi'));
        
        
    }


} 

