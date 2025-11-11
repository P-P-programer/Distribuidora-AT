@extends('layouts.app')

@section('content')
<section class="hero" aria-label="Bienvenida">
  <img src="{{ asset('images/hero.jpg') }}" alt="Repuestos y herramientas" class="hero-img">
  <div class="hero-text">
    <h2>Bienvenido a {{ config('app.name') }}</h2>
    <p>Inventario y venta simulada de repuestos para autos y motos.</p>
  </div>
</section>

<section class="destacados" aria-labelledby="productos-title">
  <h3 id="productos-title" class="section-title">Productos</h3>
  <ul class="grid">
    @forelse($products as $p)
      <li class="card">
        <div class="img-wrap">
          @if($p->image_path)
            <img src="{{ asset('img/'.$p->image_path) }}" alt="{{ $p->name }}">
          @else
            <img src="{{ asset('img/placeholder.png') }}" alt="{{ $p->name }}">
          @endif
        </div>
        <h4>{{ $p->name }}</h4>
        <p>SKU: {{ $p->sku }}</p>
        <p class="price">${{ number_format($p->price,2) }}</p>
      </li>
    @empty
      <li>No hay productos aún.</li>
    @endforelse
  </ul>
</section>

<section class="sobre" aria-labelledby="qs-title">
  <h2 id="qs-title" class="section-title">Quiénes somos</h2>
  <div class="sobre-content">
    <div class="info-card" role="article" aria-label="Experiencia">
      <div class="info-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="M7.5 21q-.65 0-1.075-.425T6 19.5q0-.65.425-1.075T7.5 18q.65 0 1.075.425T9 19.5q0 .65-.425 1.075T7.5 21Zm9 0q-.65 0-1.075-.425T15 19.5q0-.65.425-1.075T16.5 18q.65 0 1.075.425T18 19.5q0 .65-.425 1.075T16.5 21ZM5.95 13.5l2.05-6h10.15q.375 0 .613.275T19 8q0 .05-.175.55L17.3 13.5q-.2.55-.662.9t-1.063.35H7.975ZM6.8 12h8.7l1.5-4.5H8.85l-2.05 4.5Z"/>
        </svg>
      </div>
      <h3>Experiencia</h3>
      <p>Plataforma demostrativa centrada en inventario y procesos simulados de venta de repuestos para optimizar flujos y accesibilidad.</p>
    </div>
    <div class="info-card" role="article" aria-label="Accesibilidad">
      <div class="info-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="M12 13.5q.625 0 1.062-.438T13.5 12q0-.625-.438-1.062T12 10.5q-.625 0-1.062.438T10.5 12q0 .625.438 1.062T12 13.5Zm0 3q-1.85 0-3.438-1.05T5.25 12q.825-2.4 2.413-3.95Q9.25 6.5 12 6.5t4.338 1.55Q17.925 9.6 18.75 12q-.825 2.4-2.413 3.95Q14.75 16.5 12 16.5Zm0-1q1.6 0 2.975-.837T17.1 12q-.575-1.65-1.95-2.575Q13.775 8.5 12 8.5t-3.15.925Q7.475 10.35 6.9 12q.575 1.65 1.95 2.575Q10.225 15.5 12 15.5Z"/>
        </svg>
      </div>
      <h3>Accesibilidad</h3>
      <p>Diseño con enfoque WCAG: navegación clara, contraste adecuado y soporte completo para teclado.</p>
    </div>
    <div class="info-card" role="article" aria-label="Modularidad">
      <div class="info-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="m12 22l-7-9l7-9l7 9l-7 9Zm0-2.85l4.6-6.15L12 6.85L7.4 13l4.6 6.15Z"/>
        </svg>
      </div>
      <h3>Modularidad</h3>
      <p>Estructura escalable: componentes, roles y permisos lista para extender analíticas y catálogo.</p>
    </div>
  </div>
</section>

<section class="mv-blocks" aria-labelledby="mv-title">
  <h2 id="mv-title" class="section-title">Misión y Visión</h2>
  <div class="mv-grid">
    <div class="info-card" role="article" aria-label="Misión">
      <div class="info-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="M12 22q-4.425 0-7.425-3T1.575 11Q2.55 6.6 5.75 3.8T12 1q4.425 0 7.425 3t3 7.975q-.975 4.4-4.175 7.225T12 22Zm0-2q3.55 0 6.125-2.45T20.85 11Q20 7.55 17.425 5.275T12 3q-3.55 0-6.125 2.275T3.15 11q.85 3.45 3.425 5.8T12 20Zm0-3.5q2.35 0 4-1.65T17.65 11q0-2.35-1.65-4T12 5.35q-2.35 0-4 1.65T6.35 11q0 2.35 1.65 4T12 16.5Zm0-2q-1.7 0-2.9-1.2T7.9 11q0-1.7 1.2-2.9T12 6.9q1.7 0 2.9 1.2t1.2 2.9q0 1.7-1.2 2.8t-2.9 1.7Z"/>
        </svg>
      </div>
      <h3>Misión</h3>
      <p>Facilitar administración eficiente de repuestos con interfaces claras y procesos de entrenamiento.</p>
    </div>
    <div class="info-card" role="article" aria-label="Visión">
      <div class="info-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="M9 21q-.425 0-.712-.288T8 20q0-.425.288-.712T9 19h6q.425 0 .713.288T16 20q0 .425-.287.713T15 21H9Zm3-4q-2.5 0-4.25-1.75T6 11q0-2.5 1.75-4.25T12 5q2.5 0 4.25 1.75T18 11q0 2.5-1.75 4.25T12 17Zm0-2q1.675 0 2.838-1.163T16 11q0-1.675-1.162-2.837T12 7q-1.675 0-2.837 1.163T8 11q0 1.675 1.163 2.837T12 15Z"/>
        </svg>
      </div>
      <h3>Visión</h3>
      <p>Ser referencia formativa aplicando buenas prácticas modernas y accesibles de inventario.</p>
    </div>
  </div>
</section>
@endsection
