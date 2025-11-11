<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockChange;

class ProductController
{
    // Catálogo para usuarios
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.index', compact('categories'));
    }

    // Inventario (solo admin/superadmin) – valida rol aquí
    public function inventario()
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['admin', 'superadmin'], true)) {
            abort(403, 'No tienes permiso para acceder.');
        }

        $products = Product::orderBy('id')->get();
        return view('inventario.index', compact('products'));
    }

    // Búsqueda AJAX
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));
        $category = $request->input('category');
        $query = Product::with('category');

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('sku', 'like', "%{$q}%");
            });
        }
        if ($category) {
            $query->where('category_id', $category);
        }
        return response()->json($query->get());
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['admin','superadmin'], true)) {
            abort(403, 'No tienes permiso para acceder.');
        }
        $categories = Category::orderBy('name')->get();
        return view('inventario.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['admin','superadmin'], true)) {
            abort(403, 'No tienes permiso para acceder.');
        }

        $data = $request->validate([
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'name'  => ['sometimes','string','max:255'],
            'sku'   => ['sometimes','string','max:100'],
            'category_id' => ['nullable','exists:categories,id'],
            'image_path'  => ['sometimes','nullable','string','max:255'],
        ]);

        $old = (int)$product->stock;
        $product->update($data);
        $new = (int)$product->stock;

        if ($new !== $old) {
            StockChange::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'old_stock' => $old,
                'new_stock' => $new,
                'delta' => $new - $old,
                'reason' => 'manual',
            ]);
        }

        return redirect()->route('inventario.index')->with('success', 'Inventario actualizado');
    }
}