<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateResellerRequest;
use App\Http\Requests\UpdateResellerStatusRequest;
use App\Http\Resources\ResellerResource;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResellerController extends Controller
{
    public function index()
    {
        return view('blog.blog');
    }

    public function show(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $reseller = Reseller::join('users', 'resellers.user_id', 'users.id')
                ->select('resellers.id as id', 'nama', 'email', 'no_hp', 'alamat_detail', 'status')->get();
            return response()->json([
                'status' => true,
                'data' => ResellerResource::collection($reseller)
            ], 201);
        }
        return view('manajemen-reseller.data-reseller');
    }

    public function showPengajuan(Request $request)
    {
        try {
            if ($request->ajax() || $request->wantsJson()) {
                $resellerData = Reseller::join('orders', 'resellers.id', 'orders.user_id')
                    ->select('resellers.id', 'resellers.nama', 'resellers.no_hp', 'resellers.alamat_detail', 'orders.bukti_pembayaran', 'orders.nama_file_original')
                    ->where('resellers.status', false)
                    ->get();
    
                return response()->json([
                    'status' => true,
                    'data' => $resellerData
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    
        return view('manajemen-reseller.pengajuan-reseller');
    }    
    

    public function updateStatus(UpdateResellerStatusRequest $request, Reseller $reseller)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $request->validated();

            $reseller->status = $request->status;
            $reseller->save();
    
            return response()->json([
                'status' => true,
                'data' => new ResellerResource($reseller)
            ], 201);
        }
    
        return response()->json(['status' => false], 401);
    }

    public function showResellerId(Reseller $reseller, Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'true',
                'data' => new ResellerResource($reseller)
            ], 201);
        }

        return response()->json(['status' => false,], 401);
    }

    public function update(UpdateResellerRequest $request, Reseller $reseller)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $request->validated();
    
            $reseller->no_hp = $request->no_hp;
            $reseller->alamat_detail = $request->alamat_detail;
            $reseller->status = $request->status;
    
            $reseller->save();
    
            return response()->json([
                'status' => true,
                'data' => new ResellerResource($reseller)
            ], 201);
        }
    
        return response()->json(['status' => false], 401);
    }

    public function showProfile()
    {
        return view('profile.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $request->validated();
                $reseller = auth()->user()->reseller;
                $fotoProdukPath = $reseller->foto_profil;
                $originalName = $reseller->nama_file_original;
        
                if ($request->hasFile('foto_profil')) {
                    $file = $request->file('foto_profil');
                    $originalName = $file->getClientOriginalName();
    
                    if ($reseller->fotoProduk) {
                        $oldFilePath = str_replace('storage', 'public', $reseller->foto_profil);
                        if (Storage::exists($oldFilePath)) {
                            Storage::delete($oldFilePath);
                        }
                    }
                    $path = $file->store('public/profile_images');
                    $fotoProdukPath = str_replace('public', 'storage', $path);
                }
        
                $reseller->nama = $request->nama;
                $reseller->no_hp = $request->no_hp;
                $reseller->alamat_detail = $request->alamat_detail;
                
                if ($request->hasFile('foto_profil')) {
                    $reseller->foto_profil = $fotoProdukPath;
                    $reseller->nama_file_original = $originalName;
                }
        
                $reseller->save();

                return response()->json(['message' => 'Data Berhasil Diperbaharui', 'status' => true], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Terjadi Kesalahan' . $e->getMessage(), 'status' => false], 500);
            }
        }
    }
}