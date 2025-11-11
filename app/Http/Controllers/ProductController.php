<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('inventory.index');
    }

    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        $products = Product::query()
            ->when($q, fn($qq) => $qq->where('name', 'like', "%{$q}%")
                                     ->orWhere('sku', 'like', "%{$q}%"))
            ->select('id','name','sku','price','image_path')
            ->limit(20)
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image_path' => 'nullable|string'
        ]);

        $product = Product::create($request->all());

        return back()->with('success', __('messages.saved'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('warning', __('messages.deleted'));
    }
}