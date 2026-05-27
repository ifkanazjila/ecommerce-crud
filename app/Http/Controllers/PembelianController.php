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
        // Cek login
        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);

        }

        $start = microtime(true);

        // Validasi request
        $request->validate([
            'product_id' => 'required|exists:barangs,id',
        ]);

        $user = auth()->user();

        $productId = $request->input('product_id');

        // Cek apakah produk sudah ada di keranjang
        $basket = Basket::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($basket) {

            // Kalau sudah ada → tambah quantity
            $basket->quantity += 1;

            $basket->save();

        } else {

            // Kalau belum ada → insert baru
            Basket::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);

        }

        $end = microtime(true);

        $completionTime = $end - $start;

        // Return JSON untuk fetch/AJAX
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'completion_time' => $completionTime
        ]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $user = auth()->user();

    $basket = Basket::where('user_id', $user->id)
        ->where('id', $id)
        ->firstOrFail();

    $basket->quantity = $request->quantity;

    $basket->save();

    $subtotal =
        $basket->product->price * $basket->quantity;

    $total = Basket::with('product')
        ->where('user_id', $user->id)
        ->get()
        ->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

    return response()->json([
        'success' => true,
        'subtotal' => $subtotal,
        'total' => $total
    ]);
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
            ->with('success', 'Produk berhasil dihapus dari keranjang!')
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

    public function checkout()
    {
        $user = auth()->user();

        $baskets = Basket::with('product')
            ->where('user_id', $user->id)
            ->get();

        return view('checkout', compact('baskets'));
    }

    
}