<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{

    public function index()
    {
        $data_kriteria = Kriteria::all();
        return view('admin.kriteria.index', compact('data_kriteria'));
    }

    public function store(Request $request)
    {
         // Mendapatkan ID terakhir dari database
        $lastId = Kriteria::max('id_kriteria');
        // Mengambil angka dari ID terakhir
        $lastIdNumber = (int) substr($lastId, 2);

        // Membuat ID baru dengan format C-XX
        $newId = 'C-' . str_pad($lastIdNumber + 1, 2, '0', STR_PAD_LEFT);
        Kriteria::create([
            'id_kriteria'=> $newId,
            'nama_kriteria'=>$request->nama_kriteria,
            'bobot'=>$request->bobot,
        ]);
        return redirect('/data_kriteria')->with('success','Data Kriteria Berhasil Disimpan');
    }

    public function update(Request $request, string $id)
    {
        DB::table('kriteria_bobot')
        ->where('id_kriteria', $id)
        ->update([
            'nama_kriteria' => $request->input('nama_kriteria'),
            'bobot' => $request->input('bobot') 
            ]);
        return redirect('/data_kriteria')->with('success','Data Kriteria Berhasil Diupdate');
    }
    public function destroy(string $id)
    {
        DB::table('kriteria_bobot')
        ->where('id_kriteria', $id)
        ->delete();
    
        return redirect('/data_kriteria')->with('success', 'Mapel berhasil dihapus.');
    }
}
