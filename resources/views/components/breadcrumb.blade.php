@php
  $route = request()->route();
  $name = $route?->getName();
  $map = [
    'welcome' => ['Inicio'],
    'contact' => ['Inicio' => route('welcome'), 'Contacto'],
    'login' => ['Inicio' => route('welcome'), 'Iniciar sesión'],
    'register' => ['Inicio' => route('welcome'), 'Crear cuenta'],
    'profile.edit' => ['Inicio' => route('welcome'), 'Perfil'],
    'dashboard' => ['Inicio' => route('welcome'), 'Panel'],
  ];
  $trail = $map[$name] ?? ($name ? ['Inicio' => route('welcome'), ucfirst(str_replace('.',' ',$name))] : []);
  $items = [];
  foreach ($trail as $k=>$v) {
    $items[] = is_int($k) ? ['label'=>$v,'url'=>null] : ['label'=>$k,'url'=>$v];
  }
@endphp

@if(!empty($items))
<nav class="breadcrumb" aria-label="Miga de pan">
  <ol>
    @foreach($items as $i=>$it)
      <li>
        @if($it['url'] && $i < count($items)-1)
          <a href="{{ $it['url'] }}">{{ $it['label'] }}</a>
        @else
          <span aria-current="page">{{ $it['label'] }}</span>
        @endif
      </li>
    @endforeach
  </ol>
</nav>
@endif