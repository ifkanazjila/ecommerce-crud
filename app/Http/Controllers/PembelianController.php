<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\User;
use App\Models\Barang;

class PembelianController extends Controller
{
    public function add(Request $request)
    {
        $start = microtime(true);

        $request->validate([
            'product_id' => 'required|exists:barangs,id', // 'barangs' adalah nama tabel untuk model Barang
        ]);

        $user = auth()->user();
        $productId = $request->input('product_id');

        // Cek apakah produk sudah ada di keranjang
        $basket = Basket::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($basket) {
            // Kalau udah ada, tambahin quantity-nya
            $basket->quantity += 1;
            $basket->save();
        } else {
            // Kalau belum, buat entry baru
            Basket::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $end = microtime(true);
        $completionTime = $end - $start;

        return response()->json([
            'success' => true,
            'completion_time' => $completionTime
        ]);
    }

    public function update(Request $request, $id)
    {
        $start = microtime(true);

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = auth()->user();
        $basket = Basket::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $basket->quantity = $request->quantity;
        $basket->save();

        $end = microtime(true);
        $completionTime = $end - $start;

        return redirect()->route('cart')
            ->with('success', 'Quantity updated')
            ->with('completionTime', $completionTime);
    }

    public function getBasket()
    {
        $user = auth()->user();
        $baskets = Basket::with('product')
            ->where('user_id', $user->id)
            ->get();

        return view('cart', compact('baskets'));
    }

    public function remove($id)
    {
        $start = microtime(true);

        $user = auth()->user();
        $basket = Basket::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $basket->delete();

        $end = microtime(true);
        $completionTime = $end - $start;

        return redirect()->route('cart')
            ->with('success', 'Item removed from cart')
            ->with('completionTime', $completionTime);
    }

    public function getProducts()
    {
        $start = microtime(true);

        $products = Barang::all();

        $end = microtime(true);
        $completionTime = $end - $start;

        return view('dashboard', compact('products', 'completionTime'));
    }
}
