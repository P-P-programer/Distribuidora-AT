@extends('layouts.app')

@section('content')
  <h2>Inventario</h2>
  <label for="product-search">Buscar producto</label>
  <input id="product-search" type="search" placeholder="SKU o nombre" aria-label="Buscar producto">
  <ul id="results" aria-live="polite"></ul>
@endsection