<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order; // <-- PENTING: Biar kenal model Order
use Illuminate\Support\Facades\Auth; // <-- PENTING: Biar tau siapa yang login

class BuyerController extends Controller
{
    // 1. FUNGSI MENAMPILKAN MENU (CODE LAMA KAMU)
    public function index()
    {
        // Ambil semua produk beserta data penjualnya (shop_name)
        $products = Product::with('seller')->get();

        // Susun ulang datanya biar formatnya { "Nama Toko": [Menu1, Menu2] }
        $vendors = [];

        foreach ($products as $item) {
            $shopName = $item->seller->shop_name;

            // Kalau toko belum ada di list, bikin array kosong dulu
            if (!isset($vendors[$shopName])) {
                $vendors[$shopName] = [];
            }

            // Masukin menu ke tokonya
            $vendors[$shopName][] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'desc' => $item->description,
                'imgColor' => $item->image_color
            ];
        }

        // Kirim data yang udah rapi ke View 'buyer'
        return view('buyer', ['menuData' => $vendors]);
    }

    // 2. FUNGSI BARU: TERIMA ORDER DARI JAVASCRIPT
    public function storeOrder(Request $request)
    {
        // Validasi simpel (opsional, tapi bagus biar aman)
        // Kita langsung simpan aja sesuai request dari JS
        
        Order::create([
            'user_id' => Auth::id(),        // Ambil ID user yang sedang login
            'shop_name' => $request->vendor, // Nama Toko dari JS
            'menu_name' => $request->item,   // Nama Menu dari JS
            'price' => $request->price,      // Harga Satuan
            'qty' => $request->qty,          // Jumlah
            'total_price' => $request->total,// Total Harga
            'status' => 'Menunggu Konfirmasi' // Status default
        ]);

        return response()->json([
            'message' => 'Order berhasil masuk database!',
            'status' => 'success'
        ]);
    }

    public function flashSale()
    {
        // Ambil data Flash Sale + Info Produk + Info Seller-nya
        $items = \App\Models\FlashSale::with('product.seller')->get();
        return view('flash-sale', ['flashItems' => $items]);
    }
}