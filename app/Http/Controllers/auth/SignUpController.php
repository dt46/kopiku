<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignUpRequest;
use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use function Laravel\Prompts\error;

class SignUpController extends Controller
{
    public function index()
    {
        return view('auth.sign-up');
    }

    public function signUp(SignUpRequest $request)
    {
        $req = $request->validated();
    
        DB::beginTransaction();
        try {
            $role = Role::where('name', 'reseller')->first();
            if (!$role) {
                throw new \Exception('Role reseller tidak ditemukan.');
            }
            $user = new User();
            $user->role_id = $role->id; 
            $user->name = explode('@', $req['email'])[0];
            $user->email = $req['email'];
            $user->password = Hash::make($req['password']); 
            $user->save();
    
            $reseller = new Reseller;
            $reseller->user_id = $user->id;
            $reseller->nama = $req['nama'];
            $reseller->no_hp = $req['no_hp'];
            $reseller->provinsi = $req['provinsi'];
            $reseller->kota = $req['kota'];
            $reseller->kecamatan = $req['kecamatan'];
            $reseller->alamat_detail = $req['alamat_detail'];
            
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/profil_images');
                $reseller->foto_profil = str_replace('public', 'storage', $path);
                $reseller->nama_file_original = $originalName;
            }

            $reseller->save();
            
            DB::commit();
    
            return redirect()->route('signin')->with("res-status", [
                'msg' => "Pendaftaran berhasil. Silakan login akun Anda",
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            error('Terjadi kesalahan: ' . $e->getMessage());
    
            return redirect()->route('signup')
                ->with("res-status", [
                    'msg' => "Terjadi kesalahan: " . $e->getMessage(),
                    'status' => 'danger'
                ]);
        }
    }
}
