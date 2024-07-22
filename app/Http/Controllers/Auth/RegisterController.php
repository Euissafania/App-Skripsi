<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showGuruRegisterForm()
    {
        return view('auth.register');
    }

    public function showSiswaRegisterForm()
    {
        return view('auth.registerSiswa');
    }

    protected function validatorGuru(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nip' => ['required'],
            'nama_sekolah' => ['required'],
            'alamat_sekolah' => ['required'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
    }

    protected function validatorSiswa(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nis' => ['required'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
    }

    protected function createGuru(array $data)
    {
        return DB::transaction(function () use ($data) {
            $fileName = '';
            if (!empty($data['foto']) && $data['foto']->isValid()) {
                $nama = Str::random(5);
                $extensi = $data['foto']->extension();
                $fileName = $nama . '.' . $extensi;
                $data['foto']->move(public_path('assets/img/profile'), $fileName);
            }

            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'guru',
                'foto' => $fileName,
            ]);

            DB::table('guru')->insert([
                'id_guru' => 'gr-' . rand(3, 5) . uniqid(),
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama_sekolah' => $data['nama_sekolah'],
                'alamat_sekolah' => $data['alamat_sekolah'],
            ]);

            return $user;
        });
    }

    protected function createSiswa(array $data)
    {
        return DB::transaction(function () use ($data) {
            $fileName = '';
            if (!empty($data['foto']) && $data['foto']->isValid()) {
                $nama = Str::random(5);
                $extensi = $data['foto']->extension();
                $fileName = $nama . '.' . $extensi;
                $data['foto']->move(public_path('assets/img/profile'), $fileName);
            }

            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'siswa',
                'foto' => $fileName,
            ]);

            DB::table('siswa')->insert([
                'id_siswa' => $user->id,
                'nama_siswa' => $user->nama,
                'nis' => $data['nis'],
                'kelas' => $data['kelas'],
            ]);

            return $user;
        });
    }

    public function registerGuru(Request $request)
    {
        $this->validatorGuru($request->all())->validate();
        $user = $this->createGuru($request->all());
        return redirect($this->redirectPath());
    }

    public function registerSiswa(Request $request)
    {
        $this->validatorSiswa($request->all())->validate();
        $user = $this->createSiswa($request->all());
        return redirect($this->redirectPath());
    }
}
