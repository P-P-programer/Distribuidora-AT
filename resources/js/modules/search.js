// Búsqueda AJAX de productos con retroalimentación
export async function searchProducts(q) {
  const res = await fetch(`/api/products/search?q=${encodeURIComponent(q)}`, {
    headers: { 'Accept': 'application/json' }
  });
  if (!res.ok) throw new Error('Error buscando productos');
  return await res.json();
}

// Ejemplo de uso (ata a un input con id=product-search y una lista con id=results)
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('product-search');
  const list = document.getElementById('results');
  if (!input || !list) return;

  let t;
  input.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(async () => {
      const q = input.value.trim();
      if (!q) { list.innerHTML = ''; return; }
      try {
        const items = await searchProducts(q);
        list.innerHTML = items.map(p =>
          `<li><img src="/storage/${p.image_path ?? ''}" alt="" width="24" height="24"> ${p.sku} - ${p.name} ($${p.price})</li>`
        ).join('');
      } catch (e) {
        list.innerHTML = '<li>Error al buscar</li>';
      }
    }, 300);
  });
});