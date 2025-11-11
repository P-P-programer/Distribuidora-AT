@extends('layouts.app')

@section('title','Analíticas')

@section('content')
<h1>Analíticas</h1>

<div class="analytics-grid">
  <div class="card">
    <h2>Top 5 productos más vendidos</h2>
    <canvas id="chartTopSold" height="140"></canvas>
  </div>
  <div class="card">
    <h2>5 productos con menor stock</h2>
    <canvas id="chartLowStock" height="140"></canvas>
  </div>
</div>

<div class="analytics-lists">
  <div class="card">
    <h2>Compras recientes</h2>
    <ul class="list">
      @forelse($recentPurchases as $r)
        <li>
          <div>
            <strong>{{ $r->user?->name ?? 'Usuario #'.$r->user_id }}</strong>
            compró {{ $r->qty }} × {{ $r->product?->name ?? 'Prod #'.$r->product_id }}
          </div>
          <div class="muted">${{ number_format($r->total_price,2) }} • {{ $r->created_at->diffForHumans() }}</div>
        </li>
      @empty
        <li class="muted">Sin compras</li>
      @endforelse
    </ul>
  </div>

  <div class="card">
    <h2>Modificaciones de stock recientes</h2>
    <ul class="list">
      @forelse($recentStockChanges as $c)
        <li>
          <div>
            <strong>{{ $c->user?->name ?? 'Usuario #'.$c->user_id }}</strong>
            cambió {{ $c->product?->name ?? 'Prod #'.$c->product_id }}
            de {{ $c->old_stock }} a {{ $c->new_stock }}
            (<span style="color:{{ $c->delta>=0 ? '#16a34a':'#dc2626' }}">{{ $c->delta>=0 ? '+' : '' }}{{ $c->delta }}</span>)
          </div>
          <div class="muted">{{ $c->reason === 'purchase' ? 'Compra' : 'Manual' }} • {{ $c->created_at->diffForHumans() }}</div>
        </li>
      @empty
        <li class="muted">Sin cambios</li>
      @endforelse
    </ul>
  </div>
</div>

<script>
  window.analyticsData = {
    topSold: @json($topSold),
    lowStock: @json($lowStock),
  };
</script>
@endsection