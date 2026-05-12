<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'stock' => 'required|integer',
        ]);

        // 1. Buat SKU unik (Contoh: INV-20231024-001)
        $sku = 'INV-' . date('Ymd') . '-' . rand(100, 999);

        // 2. Generate QR Code berdasarkan SKU (Ganti PNG ke SVG)
        $qrCodeImage = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($sku);

        // 3. Simpan ke Database (Simpan mentah saja sebagai string)
        $product = Product::create([
            'sku' => $sku,
            'name' => $request->name,
            'stock' => $request->stock,
            'qr_code' => $qrCodeImage, // Langsung simpan string SVG-nya
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan!',
            'data' => $product
        ]);
    }

    public function scan(Request $request)
    {
        $product = Product::where('sku', $request->sku)->first();

        if (!$product) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        if ($product->stock > 0) {
            $product->decrement('stock'); // Mengurangi stok sebanyak 1
            return response()->json(['message' => 'Stok berhasil dikurangi', 'product' => $product]);
        }

        return response()->json(['message' => 'Stok habis'], 400);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Barang berhasil dihapus']);
    }

    public function index()
    {
        // Ambil semua data produk untuk ditampilkan di tabel Next.js
        return response()->json(Product::all());
    }
}