@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="catalogo-flex" style="padding-top:1rem; padding-bottom:1rem; display:flex; gap:1.5rem; align-items:flex-start; flex-wrap:wrap;">
    <aside class="sidebar-filtros">
        <div class="search-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input id="searchInput" type="search" placeholder="Buscar productos..." />
        </div>
        
        <div class="card filtros-card">
            <h3 class="filtros-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
                </svg>
                Categorías
            </h3>
            <ul id="categoriesList" class="categories-list">
                <li><button data-id="" class="category-btn active">Todas las categorías</button></li>
                @foreach($categories as $cat)
                    <li><button data-id="{{ $cat->id }}" class="category-btn">{{ $cat->name }}</button></li>
                @endforeach
            </ul>
        </div>
    </aside>
    
    <main style="flex:1; min-width:300px;">
        <h1 style="margin-bottom:1rem;">Catálogo de Productos</h1>
        <div id="productosGrid" class="productos-grid"></div>
        <div id="noResults" style="display:none; text-align:center; color:#888; margin-top:2rem;">
            No se encontraron productos.
        </div>
        <div id="loader" style="text-align:center; padding:1rem; display:none;">Cargando...</div>
    </main>
</div>

<!-- Modal de detalle -->
<div id="productModal" class="modal-overlay" hidden role="dialog" aria-modal="true" aria-labelledby="modalName">
  <div class="modal-dialog">
    <button id="modalClose" class="modal-close" aria-label="Cerrar">×</button>
    <div class="modal-body">
      <div class="modal-media">
        <img id="modalImage" src="" alt="" class="modal-image">
      </div>
      <div class="modal-info">
        <h3 id="modalName"></h3>
        <p id="modalCategory" class="muted"></p>
        <p id="modalPrice" class="price"></p>
        <p id="modalStock"></p>
        <p id="modalDescription"></p>

        <div class="quantity-selector">
          <label for="quantityInput">Cantidad:</label>
          <div class="qty-controls">
            <button id="qtyMinus" type="button" class="qty-btn">−</button>
            <input id="quantityInput" type="number" min="1" value="1" max="999" />
            <button id="qtyPlus" type="button" class="qty-btn">+</button>
          </div>
        </div>

        <div class="modal-actions">
          @auth
            <button id="modalAddCart" class="confirm">Agregar al carrito</button>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-contrast">Inicia sesión para comprar</a>
          @endauth
        </div>
      </div>
    </div>
  </div>
</div>
<div style="height:140px;"></div>
@endsection