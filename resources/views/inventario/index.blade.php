
@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<h1>Inventario de productos</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>SKU</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->sku }}</td>
            <td>${{ $p->price }}</td>
            <td>{{ $p->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-primary">Modificar inventario</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection