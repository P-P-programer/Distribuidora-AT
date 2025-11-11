@php
  $flash = [];
  foreach (['success','status','info','warning','error'] as $key) {
      if (session($key)) {
          $type = $key === 'status' ? 'success' : $key;
          $flash[] = ['type' => $type, 'message' => session($key)];
      }
  }
@endphp

{{-- Alertas inline de errores de validación --}}
@if ($errors->any())
  <div class="alert alert-error" role="alert" style="margin: .75rem 0 1rem;">
    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 22q-2.075 0-3.9-.788t-3.2-2.137t-2.137-3.2T2 12t.788-3.875t2.137-3.2t3.2-2.15T12 2t3.875.775t3.2 2.15t2.15 3.2T22 12t-.775 3.975t-2.15 3.2t-3.2 2.137T12 22Zm-1-5h2v-2h-2v2Zm0-4h2V7h-2v6Z"/></svg>
    <div>
      <p><strong>Corrige los siguientes campos:</strong></p>
      <ul style="margin:.35rem 0 0; padding-left: 1rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

{{-- Datos para toasts (sesión) --}}
@if (!empty($flash))
  <script id="flash-data" type="application/json">{!! json_encode($flash, JSON_UNESCAPED_UNICODE) !!}</script>
@endif