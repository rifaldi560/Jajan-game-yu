<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;




class KeranjangController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('keranjang.index', compact('cart'));
    }

    /**
     * Menambahkan produk ke keranjang belanja
     */
    public function store(Request $request)
    {
        $produk = Produk::findOrFail($request->id);
        $produkId = $request->produk_id;

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['quantity']++;
        } else {
            $cart[$produk->id] = [
                "nama" => $produk->nama,
                "harga" => $produk->harga,
                "gambar" => $produk->gambar,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'totalItems' => count($cart)
        ]);
    }

    /**
     * Mengupdate jumlah produk dalam keranjang
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Menghapus produk dari keranjang
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'totalItems' => count($cart)
        ]);
    }

    /**
     * Mengosongkan seluruh isi keranjang
     */
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'totalItems' => 0
        ]);
    }

    /**
     * Proses checkout (hanya simulasi)
     */

public function checkout()
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('keranjang.index')->with('error', 'Your cart is empty!');
    }

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['harga'] * $item['quantity'];
    }

    $transactions = Transactions::create([
        'user_id' => Auth::id(),
        'items' => json_encode($cart),
        'total_harga' => $total,
        'status' => 'pending',
        'resi' => strtoupper(Str::random(10))
    ]);

    session()->forget('cart');

    return redirect()->route('transactions.index')->with('success', 'Checkout successful! Waiting for approval.');
}

}
