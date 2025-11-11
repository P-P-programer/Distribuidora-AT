@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
<h1 class="cart-title">Carrito de compras</h1>

@if(session('success'))
  <div class="alert alert-success" data-purchase-success="1">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($products->isEmpty())
  <p data-cart-empty="1" class="cart-empty">No hay productos en el carrito.</p>
@else
  <div class="cart-summary-panel">
      <div class="cart-meta">
          <span><strong>Productos:</strong> {{ count($products) }}</span>
          <span><strong>Total:</strong> ${{ number_format($total, 2) }}</span>
      </div>
      <button id="buyConfirmBtn" class="btn btn-primary cart-buy-btn" aria-haspopup="dialog">
          Comprar ahora
      </button>
  </div>

  <ul class="cart-items">
    @foreach($products as $p)
      @php
        $qty = (int)($cart[$p->id]['qty'] ?? 1);
        $subtotal = (float)$p->price * $qty;
      @endphp
      <li class="cart-item">
        <div class="cart-item-media">
            <div class="cart-thumb">
              @if($p->image_path)
                <img src="/img/{{ $p->image_path }}" alt="{{ $p->name }}">
              @else
                <span class="no-img">IMG</span>
              @endif
            </div>
        </div>
        <div class="cart-item-info">
            <h3 class="cart-item-name">{{ $p->name }}</h3>
            <p class="cart-item-sku">{{ $p->sku }}</p>
            <p class="cart-item-price">Precio: ${{ number_format($p->price, 2) }}</p>
            <p class="cart-item-qty">Cantidad: <b>{{ $qty }}</b></p>
        </div>
        <div class="cart-item-total">
            <span class="cart-subtitle">Subtotal</span>
            <span class="cart-subvalue">${{ number_format($subtotal, 2) }}</span>
        </div>
      </li>
    @endforeach
  </ul>

  <div class="cart-footer-total">
      <div class="cart-total-label">Total a pagar</div>
      <div class="cart-total-value">${{ number_format($total, 2) }}</div>
  </div>

  <form id="buyForm" method="POST" action="{{ route('cart.buy') }}" data-total="{{ number_format($total, 2, '.', '') }}" hidden>
    @csrf
  </form>
@endif

<!-- Modal de confirmación compra -->
<div id="buyConfirmModal" class="modal-overlay" hidden role="dialog" aria-modal="true" aria-labelledby="buyConfirmTitle">
  <div class="modal-dialog" style="max-width:420px;">
      <button type="button" class="modal-close" id="buyConfirmClose" aria-label="Cerrar">×</button>
      <h3 id="buyConfirmTitle" style="margin-top:0;">Confirmar compra</h3>
      <p id="buyConfirmText" class="muted" style="line-height:1.45;"></p>
      <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:1.75rem;">
          <button type="button" class="btn btn-soft" id="buyCancelBtn" style="background:#e2e8f0;color:#334155;">Cancelar</button>
          <button type="button" class="confirm" id="buyOkBtn">Sí, comprar</button>
      </div>
  </div>
</div>

@endsection
