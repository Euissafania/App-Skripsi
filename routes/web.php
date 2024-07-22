<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C45Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PenentuanProdiController;
use App\Http\Controllers\ProsesAlgoritmaController;
use App\Http\Controllers\Auth\RegisterSiswaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin
Route::controller(MapelController::class)->group(function() {
    Route::get('/mapel', 'index')->name('mapel')->middleware(['auth', 'role:admin']);
    Route::post('/add_mapel', 'store')->name('add_mapel')->middleware(['auth', 'role:admin']);
    Route::put('/update_data/{id}','update');
    Route::delete('/mapel_delete/{id}', 'destroy')->name('mapel_delete');
  });
Route::controller(KriteriaController::class)->group(function() {
  Route::get('/data_kriteria', 'index')->middleware(['auth', 'role:admin']);
  Route::post('/add_kriteria', 'store')->name('add_kriteria')->middleware(['auth', 'role:admin']);
  Route::put('/update_data/{id}','update');
  Route::delete('/delete/{id}', 'destroy')->name('delete');
});
Route::controller(ProdiController::class)->group(function() {
    Route::get('/data_prodi', 'index')->middleware('auth')->middleware(['auth', 'role:admin']);
    Route::post('/add_prodi', 'store')->name('add_prodi')->middleware(['auth', 'role:admin']);
    Route::put('/update_data/{id}','update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
  });



// Guru
Route::controller(PenentuanProdiController::class)->group(function() {
    Route::get('/perangkingan', 'index')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/add_prangkingan', 'create')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/get-mapel/{prodi_id}', 'getMapel')->middleware(['auth', 'role:guru|siswa']); 
    Route::post('/add_data', 'store')->name('add_data')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/export-data', 'export')->name('export-data')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/show-data/{id}', 'show')->name('show-data')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/delete/{id}', 'destroy')->name('delete')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/pilih_role', 'pilihrole');
    // Route::put('/update_data/{id}','update');
  });

  Route::controller(ProsesAlgoritmaController::class)->group(function() {
    Route::get('/proses-1/{id}','perangkingan')->name('proses')->middleware(['auth', 'role:guru|siswa']);
    Route::get('/home', 'home')->name('home')->middleware(['auth', 'role:siswa|guru']); 
    // Route::post('/add_data', 'store')->name('add_data');
    // Route::get('/show_data/{id}', 'show')->name('show_data.show');
    // Route::put('/update_data/{id}','update');
    // Route::delete('/delete/{id}', 'delete')->name('delete');
  });

Route::controller(C45Controller::class)->group(function() {
     Route::get('/RuleC45', 'ViewRule')->middleware(['auth', 'role:siswa|guru']); 
     Route::get('/cekValidita/{id}','CekValiditas')->name('proses-2')->middleware(['auth', 'role:guru|siswa']);
});
Route::controller(RegisterController::class)->group(function() {
      Route::get('/Regis-Guru', 'showGuruRegisterForm');
      Route::post('/create-guru', 'registerGuru')->name('create-guru');
      Route::get('/Regis-Siswa', 'showSiswaRegisterForm');
      Route::post('/create-siswa', 'registerSiswa')->name('create-siswa');
    
});



Auth::routes();
Route::get('/access-denied', function () { return view('auth.access_denied');})->middleware('auth');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);



