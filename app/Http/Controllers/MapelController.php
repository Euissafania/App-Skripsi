<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
   
    public function index()
    {
        $data_mapel = Mapel::orderBy('id_mapel', 'desc')->get();//eloquent
        return view('admin.mapel.index', compact('data_mapel'));
    }

    public function store(Request $request)
    {
           Mapel::create([
            'id_mapel'=>'mpl-' . rand(3, 5) . uniqid(),
            'nama_mapel'=>$request->nama_mapel,
           ]);
        return redirect('/mapel')->with('success','Data Mata Pelajaran Berhasil Disimpan');
    }


    public function update(Request $request, string $id)
    {
        DB::table('mapel')
        ->where('id_mapel', $id)
        ->update(['nama_mapel' => $request->input('nama_mapel')]);
        return redirect()->route('mapel');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('mapel')
        ->where('id_mapel', $id)
        ->delete();
    
        return redirect()->route('mapel')->with('success', 'Mapel berhasil dihapus.');
    }
}
