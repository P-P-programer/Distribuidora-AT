<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PurchaseLog;
use App\Models\StockChange;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []); // formato: [id => ['qty'=>n]]
        $productIds = array_keys($cart);
        $products = $productIds ? Product::whereIn('id', $productIds)->get() : collect();

        $total = 0;
        foreach ($products as $p) {
            $qty = (int)($cart[$p->id]['qty'] ?? 1);
            $total += ((float)$p->price) * $qty;
        }

        return view('cart.index', compact('products', 'cart', 'total'));
    }

    public function add(Request $request)
    {
        $productId = (int)$request->input('product_id');
        $quantity  = (int)$request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;

        $cart = session('cart', []); // [id => ['qty'=>n]]

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $quantity;
        } else {
            $cart[$productId] = ['qty' => $quantity];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cart_count' => array_sum(array_map(fn($v) => $v['qty'], $cart))
        ]);
    }

    public function buy(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        foreach ($products as $product) {
            $qty = (int)($cart[$product->id]['qty'] ?? 1);
            if ($qty < 1) continue;

            if ($product->stock < $qty) {
                return redirect()->route('cart.index')
                    ->with('error', "Stock insuficiente de {$product->name}");
            }

            $old = (int)$product->stock;
            PurchaseLog::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $product->price,
                'total_price' => ((float)$product->price) * $qty,
            ]);

            $product->decrement('stock', $qty);
            $new = $old - $qty;

            StockChange::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'old_stock' => $old,
                'new_stock' => $new,
                'delta' => $new - $old,
                'reason' => 'purchase',
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Compra realizada con éxito');
    }
}