<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
            
        $data = DB::table('prodi_perangkingan')
        ->join('prodi', 'prodi.id_prodi', '=', 'prodi_perangkingan.prodi_id')
        ->join('perangkingan', 'perangkingan.id_perangkingan', '=', 'prodi_perangkingan.perangkingan_id')
        ->join('siswa', 'siswa.id_siswa', '=', 'perangkingan.siswa_id')
        ->select('siswa.nis','siswa.nama_siswa','siswa.kelas','prodi.nama_prodi','prodi_perangkingan.kriteria_id','prodi_perangkingan.nilai_kriteria','perangkingan.status_validitas')
        ->whereColumn('prodi.id_prodi', 'perangkingan.prodi_terpilih')
        ->get();
        // Inisialisasi struktur data yang diinginkan
            // Transformasi data ke dalam bentuk koleksi (collection)
        $formattedData = collect($data)->map(function ($item) {
            return [
                'nis' => $item->nis,
                'nama_siswa' => $item->nama_siswa,
                'kelas' => $item->kelas,
                'nama_prodi' => $item->nama_prodi,
                'kriteria_id' => $item->kriteria_id,
                'nilai_kriteria' => $item->nilai_kriteria,
                'status_validitas' => $item->status_validitas,
            ];
        });

        return $formattedData;
    }

    
    public function headings(): array
    {
        return ['NIS','Nama Siswa','Kelas','Prodi Terpilih','Kriteria','Nilai Kriteria','status_Validitas'];
    }
}
