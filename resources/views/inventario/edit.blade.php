@extends('layouts.app')

@section('title', 'Modificar inventario')

@section('content')
<x-breadcrumb />
<h1>Modificar inventario</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0;padding-left:18px;">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('products.update', $product) }}" style="max-width:560px;display:grid;gap:12px;">
    @csrf
    @method('PATCH')

    <label>
        Nombre
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
    </label>

    <label>
        SKU
        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}">
    </label>

    <label>
        Precio
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}">
    </label>

    <label>
        Stock
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
    </label>

    <label>
        Categoría
        <select name="category_id">
            <option value="">Sin categoría</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id)==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </label>

    <label>
        Imagen (nombre de archivo en /public/img)
        <input type="text" name="image_path" value="{{ old('image_path', $product->image_path) }}" placeholder="michelin17.jpg">
    </label>

    <div style="display:flex;gap:8px;">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('inventario.index') }}" class="btn">Cancelar</a>
    </div>
</form>
@endsection