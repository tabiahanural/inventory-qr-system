<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua data produk untuk ditampilkan di tabel Next.js
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'stock' => 'required|integer',
        ]);

        // 1. Buat SKU unik
        $sku = 'INV-' . date('Ymd') . '-' . rand(100, 999);

        // 2. Generate QR Code berdasarkan SKU (Format SVG)
        $qrCodeImage = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($sku);

        // 3. Simpan ke Database
        $product = Product::create([
            'sku' => $sku,
            'name' => $request->name,
            'stock' => $request->stock,
            'qr_code' => $qrCodeImage, 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan!',
            'data' => $product
        ]);
    }

    public function scan(Request $request)
    {
        // Cari produk berdasarkan SKU
        $product = Product::where('sku', $request->sku)->first();

        if (!$product) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        // --- LOGIKA TERBARU: CEK TYPE DARI NEXT.JS ---
        $type = $request->input('type', 'out'); // Default ke 'out' jika tidak dikirim

        if ($type === 'in') {
            // Jika mode MASUK, tambah stok
            $product->increment('stock');
            $msg = 'Stok berhasil ditambah';
        } else {
            // Jika mode KELUAR, kurangi stok (cek jika stok masih ada)
            if ($product->stock > 0) {
                $product->decrement('stock');
                $msg = 'Stok berhasil dikurangi';
            } else {
                return response()->json(['message' => 'Gagal: Stok sudah habis!'], 400);
            }
        }

        // Kembalikan response json yang menyertakan data produk terbaru
        return response()->json([
            'message' => $msg,
            'id' => $product->id,
            'sku' => $product->sku,
            'name' => $product->name,
            'stock' => $product->stock
        ], 200);
    }

    // --- FITUR BARU: UNTUK EDIT DATA BARANG (PENSIL AMBER) ---
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'message' => 'Data barang berhasil diperbarui',
            'product' => $product
        ]);
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
}