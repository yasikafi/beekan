<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class SellerController extends Controller
{
    // 1. TAMPILKAN DASHBOARD SELLER
    public function index()
    {
        // Ambil info toko dari user yang login
        $user = Auth::user();
        $shopName = $user->shop_name; // Contoh: "Bakmie Nikmat"

        // Ambil orderan HANYA untuk toko ini, urutkan dari yang terbaru
        $orders = Order::where('shop_name', $shopName)->latest()->get();

        // Hitung Statistik (Bonus buat demo biar angkanya gerak)
        $totalPendapatan = $orders->where('status', 'Selesai')->sum('total_price');
        $orderMasuk = $orders->where('status', '!=', 'Selesai')->count();
        $orderSelesai = $orders->where('status', 'Selesai')->count();

        return view('seller', [
            'orders' => $orders,
            'stats' => [
                'pendapatan' => $totalPendapatan,
                'masuk' => $orderMasuk,
                'selesai' => $orderSelesai
            ]
        ]);
    }

    // 2. UPDATE STATUS PESANAN (Terima / Tolak / Selesai)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->status = $request->status; // Status diambil dari input tombol
            $order->save();
        }

        return back(); // Refresh halaman setelah update
    }

    // 1. Tampilkan Form
    public function createMenu()
    {
        return view('seller-add-menu');
    }

    // 2. Simpan Menu ke Database
    public function storeMenu(Request $request)
    {
        // Panggil model Product (pastikan import App\Models\Product di atas)
        \App\Models\Product::create([
            'user_id' => Auth::id(), // Punya siapa?
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image_color' => $request->image_color // Gradient warna pilihan
        ]);

        return redirect('/seller'); // Balik ke dashboard
    }

    public function createFlash()
    {
        // Ambil menu milik seller yang lagi login aja
        $myProducts = \App\Models\Product::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        
        return view('seller-create-flash', ['myMenu' => $myProducts]);
    }

    // 2. SIMPAN FLASH SALE KE DATABASE
    public function storeFlash(Request $request)
    {
        \App\Models\FlashSale::create([
            'product_id' => $request->product_id,
            'discount_price' => $request->price,
            'stock' => $request->stock
        ]);

        return redirect('/seller');
    }
}