<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data_mapel = Mapel::all();
        $data_prodi = Prodi::orderBy('created_at', 'asc')->get();
        $data_mapel_prodi = DB::table('master_mapel_prodi')
        ->join('mapel', 'mapel.id_mapel', '=', 'master_mapel_prodi.mapel_id')
        ->join('prodi', 'prodi.id_prodi', '=', 'master_mapel_prodi.prodi_id')
        ->select('prodi.*','mapel.*','master_mapel_prodi.*')
        ->orderBy('prodi.created_at', 'asc')
        ->get();
       return view('admin.prodi.index', compact('data_prodi','data_mapel','data_mapel_prodi'));
    }

    public function store(Request $request)
    {
        $prodi = Prodi::create([
            'id_prodi'=> 'prd-' .rand(2, 3) . uniqid(),
            'nama_prodi'=>$request->nama_prodi,
        ]);

        $id_mapels = $request->mapel_id;
        foreach($id_mapels as $id_mapel) {
            DB::table('master_mapel_prodi')->insert([
                'prodi_id' => $prodi->id_prodi,
                'mapel_id' => $id_mapel
            ]);
        }
        return redirect('/data_prodi')->with('success', 'Data Prodi Berhasil Disimpan');
    }

    public function update(Request $request, string $id)
    {
        // Update prodi
            Prodi::where('id_prodi', $id)
            ->update(['nama_prodi' => $request->nama_prodi]);

            // Delete existing mapel_prodi records for this prodi
            DB::table('master_mapel_prodi')
            ->where('prodi_id', $id)
            ->delete();

            // Insert new mapel_prodi records
            $id_mapels = $request->mapel_id;
            foreach ($id_mapels as $id_mapel) {
            DB::table('master_mapel_prodi')->insert([
                'prodi_id' => $id,
                'mapel_id' => $id_mapel
            ]);
            }

            return redirect('/data_prodi')->with('success', 'Data Prodi Berhasil Disimpan');
    }

    
    public function destroy(string $id)
    {
        DB::table('master_mapel_prodi')
        ->where('prodi_id', $id)
        ->delete();
        DB::table('prodi')
        ->where('id_prodi', $id)
        ->delete();
    
        return redirect('/data_prodi')->with('success', 'Mapel berhasil dihapus.');
    }
}
