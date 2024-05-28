<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Models\Reseller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $resellerid = $request->user()->reseller->id;
        $reseller = Reseller::findOrFail($resellerid);
        $products = Product::where('id', $id)->get();
        return view('order.checkout')->with(compact('reseller', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $request->validated();
    
            DB::beginTransaction();
            try {
                if ($request->hasFile('bukti_pembayaran')) {
                    $file = $request->file('bukti_pembayaran');
                    $originalName = $file->getClientOriginalName();
                    $path = $file->store('public/bukti_pembayaran');
                    $fotoProdukPath = str_replace('public', 'storage', $path);
                } else {
                    throw new HttpResponseException(response()->json(['message' => 'Bukti Pembayaran tidak ditemukan.'], 422));
                }
            
                $order = new Order;
                $order->user_id = $request->user_id;
                $order->product_id = $request->product_id;
                $order->ongkos_kirim = $request->ongkos_kirim;
                $order->total_harga = $request->total_harga;
                $order->banyak_item = $request->banyak_item;
                $order->bukti_pembayaran = $fotoProdukPath;
                $order->nama_file_original = $originalName;
                $order->save();
            
                DB::commit();
            
                return response()->json([
                    'status' => true, 
                    'msg' => "Order placed successfully.",
                    'redirect' => route('daftar-order-reseller')
                ], 201);
            } catch (ValidationException $e) {
                DB::rollBack();
            
                return response()->json([
                    'status' => false,
                    'errors' => $e->errors(),
                    'msg' => "Error: " . $e->getMessage(),
                ], 422);
            } catch (\Exception $e) {
                DB::rollBack();
            
                return response()->json([
                    'status' => false,
                    'msg' => "Error: " . $e->getMessage(),
                ], 500);
            }
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function showIndex(Request $request)
    {
        try {
            if ($request->ajax() || $request->wantsJson()) {
                $resellerData = Order::join('resellers', 'orders.user_id', 'resellers.id')
                    ->join('products', 'orders.product_id', 'products.id')
                    ->select('resellers.nama', 'resellers.no_hp', 'resellers.alamat_detail', 'products.namaProduk', 'products.fotoProduk', 'products.hargaProduk', 'orders.no_resi', 'orders.status', 'orders.total_harga', 'orders.banyak_item', 'orders.id')
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
    
        return view('manajemen-produk.data-order');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function showOrderId(Order $order, Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'true',
                'data' => new OrderResource($order)
            ], 201);
        }

        return response()->json(['status' => false,], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validated = $request->validated();

            $order->no_resi = $validated['no_resi'];
            $order->status = $validated['status'];
            $order->save();
    
            return response()->json([
                'status' => true,
                'data' => new OrderResource($order)
            ], 201);
        }
    
        return response()->json(['status' => false], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function indexReseller(Request $request)
    {
        try {
            if ($request->ajax() || $request->wantsJson()) {
                $user = $request->user()->reseller->id;
                $resellerData = Order::join('resellers', 'orders.user_id', 'resellers.id')
                    ->join('products', 'orders.product_id', 'products.id')
                    ->select('products.namaProduk', 'products.fotoProduk', 'products.hargaProduk', 'orders.no_resi', 'orders.status', 'orders.total_harga', 'orders.banyak_item', 'orders.id')
                    ->where('orders.user_id', $user)
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
    
        return view('manajemen-produk.data-order-reseller');
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validated = $request->validated();

            $order->status = $validated['status'];
            $order->save();
    
            return response()->json([
                'status' => true,
                'data' => new OrderResource($order)
            ], 201);
        }
    
        return response()->json(['status' => false], 401);
    }
}
