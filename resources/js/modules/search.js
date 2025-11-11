// Búsqueda AJAX de productos con retroalimentación
export async function searchProducts(q) {
  const res = await fetch(`/api/products/search?q=${encodeURIComponent(q)}`, {
    headers: { 'Accept': 'application/json' }
  });
  if (!res.ok) throw new Error('Error buscando productos');
  return await res.json();
}

// Actualizar badge del carrito
function updateCartBadge() {
  const cartBtn = document.getElementById('cartBtn');
  if (!cartBtn) return;
  
  let badge = cartBtn.querySelector('.cart-badge');
  const count = parseInt(localStorage.getItem('cartCount') || '0');
  
  if (count > 0) {
    if (!badge) {
      badge = document.createElement('span');
      badge.className = 'cart-badge';
      cartBtn.style.position = 'relative';
      cartBtn.appendChild(badge);
    }
    badge.textContent = count;
  } else if (badge) {
    badge.remove();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('searchInput');
  const grid = document.getElementById('productosGrid');
  const categoriesList = document.getElementById('categoriesList');
  const noResults = document.getElementById('noResults');
  const loader = document.getElementById('loader');
  let selectedCategory = '';
  let products = [];

  // Inicializar badge del carrito
  updateCartBadge();

  // Función para buscar productos por texto y categoría
  async function fetchProducts(q = '', category = '') {
    if (loader) loader.style.display = 'block';
    if (noResults) noResults.style.display = 'none';
    if (grid) grid.innerHTML = '';
    try {
      const res = await fetch(`/api/products/search?q=${encodeURIComponent(q)}&category=${encodeURIComponent(category)}`, {
        headers: { 'Accept': 'application/json' }
      });
      if (!res.ok) throw new Error('Error buscando productos');
      products = await res.json();
      renderProducts(products);
    } catch (e) {
      if (grid) grid.innerHTML = '<li>Error al buscar productos</li>';
    } finally {
      if (loader) loader.style.display = 'none';
    }
  }

  // Renderiza los productos en el grid
  function renderProducts(items) {
    if (!items.length) {
      if (noResults) noResults.style.display = 'block';
      if (grid) grid.innerHTML = '';
      return;
    }
    if (noResults) noResults.style.display = 'none';
    if (grid) {
      grid.innerHTML = items.map(p =>
        `<li class="card" data-product='${JSON.stringify(p)}'>
          <div class="img-wrap">
            <img src="/img/${p.image_path ?? ''}" alt="${p.name}">
          </div>
          <div>
            <h4>${p.name}</h4>
            <p class="muted">${p.sku ?? ''}</p>
            <p class="muted">${p.category?.name ?? ''}</p>
            <p class="price">$${p.price}</p>
            <button class="btn-ver" style="margin-top:8px;background:#1e293b;color:#fff;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-weight:600;">Ver detalles</button>
          </div>
        </li>`
      ).join('');
    }
  }

  // Búsqueda por texto
  if (input) {
    let t;
    input.addEventListener('input', () => {
      clearTimeout(t);
      t = setTimeout(() => {
        fetchProducts(input.value.trim(), selectedCategory);
      }, 300);
    });
  }

  // Filtro por categoría
  if (categoriesList) {
    categoriesList.addEventListener('click', e => {
      const btn = e.target.closest('.category-btn');
      if (!btn) return;
      categoriesList.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      selectedCategory = btn.dataset.id;
      fetchProducts(input.value.trim(), selectedCategory);
    });
  }

  // Modal de producto y agregar al carrito
  const modal = document.getElementById('productModal');
  const modalClose = document.getElementById('modalClose');
  const modalAddCart = document.getElementById('modalAddCart');
  const quantityInput = document.getElementById('quantityInput');
  const qtyPlus = document.getElementById('qtyPlus');
  const qtyMinus = document.getElementById('qtyMinus');
  let selectedProduct = null;

  // Controles de cantidad
  if (qtyPlus) {
    qtyPlus.addEventListener('click', () => {
      const current = parseInt(quantityInput.value) || 1;
      const max = parseInt(quantityInput.max) || 999;
      if (current < max) quantityInput.value = current + 1;
    });
  }

  if (qtyMinus) {
    qtyMinus.addEventListener('click', () => {
      const current = parseInt(quantityInput.value) || 1;
      if (current > 1) quantityInput.value = current - 1;
    });
  }

  // Solo abre el modal al dar click en "Ver"
  if (grid) {
    grid.addEventListener('click', e => {
      const btn = e.target.closest('.btn-ver');
      if (!btn) return;
      const li = btn.closest('li[data-product]');
      if (!li) return;
      selectedProduct = JSON.parse(li.dataset.product);
      document.getElementById('modalImage').src = "/img/" + (selectedProduct.image_path ?? '');
      document.getElementById('modalName').textContent = selectedProduct.name;
      document.getElementById('modalCategory').textContent = selectedProduct.category?.name ?? '';
      document.getElementById('modalPrice').textContent = '$' + selectedProduct.price;
      document.getElementById('modalStock').textContent = 'Stock disponible: ' + selectedProduct.stock + ' unidades';
      document.getElementById('modalDescription').textContent = selectedProduct.description ?? 'Sin descripción';
      if (quantityInput) {
        quantityInput.value = 1;
        quantityInput.max = selectedProduct.stock;
      }
      if (modal) modal.style.display = 'flex';
    });
  }

  if (modalClose) {
    modalClose.addEventListener('click', () => {
      if (modal) modal.style.display = 'none';
    });
  }

  // Confirmación elegante con modal personalizado antes de agregar al carrito
  if (modalAddCart) {
    modalAddCart.addEventListener('click', async () => {
      if (!selectedProduct) return;
      
      const quantity = parseInt(quantityInput?.value || 1);
      
      // Crear modal de confirmación elegante CON OVERLAY
      const confirmModal = document.createElement('div');
      confirmModal.className = 'modal-overlay';
      confirmModal.style.cssText = 'display: flex !important;';
      confirmModal.innerHTML = `
        <div class="modal-dialog" style="max-width:380px;text-align:center;">
          <h3 style="margin-top:0;color:#0f172a;font-size:1.25rem;">¿Agregar al carrito?</h3>
          <p style="color:#64748b;margin:1rem 0 1.5rem;">¿Agregar <strong>${quantity} unidad(es)</strong> de <strong>${selectedProduct.name}</strong> a tu carrito?</p>
          <div style="display:flex;gap:12px;justify-content:center;">
            <button id="confirmYes" class="confirm" style="background:#16a34a;color:#fff;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-weight:600;">Sí, agregar</button>
            <button id="confirmNo" style="background:#e2e8f0;color:#475569;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-weight:600;">Cancelar</button>
          </div>
        </div>
      `;
      document.body.appendChild(confirmModal);

      const confirmYes = confirmModal.querySelector('#confirmYes');
      const confirmNo = confirmModal.querySelector('#confirmNo');

      confirmModal.addEventListener('click', (e) => {
        if (e.target === confirmModal) document.body.removeChild(confirmModal);
      });

      confirmNo.addEventListener('click', () => {
        document.body.removeChild(confirmModal);
      });

      confirmYes.addEventListener('click', async () => {
        document.body.removeChild(confirmModal);
        try {
          const res = await fetch('/cart/add', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: selectedProduct.id, quantity })
          });
          if (!res.ok) throw new Error('No se pudo agregar al carrito');
          
          // Actualizar contador del carrito
          const currentCount = parseInt(localStorage.getItem('cartCount') || '0');
          localStorage.setItem('cartCount', currentCount + quantity);
          updateCartBadge();
          
          // Mensaje de éxito elegante CON OVERLAY
          const successModal = document.createElement('div');
          successModal.className = 'modal-overlay';
          successModal.style.cssText = 'display: flex !important;';
          successModal.innerHTML = `
            <div class="modal-dialog" style="max-width:350px;text-align:center;">
              <div style="width:64px;height:64px;margin:0 auto 1rem;background:#16a34a;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="32" height="32" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
              </div>
              <h3 style="margin:0 0 .5rem;color:#0f172a;">¡Producto agregado!</h3>
              <p style="color:#64748b;margin:0 0 1.5rem;">Se agregaron ${quantity} unidad(es) a tu carrito.</p>
              <button id="successOk" class="confirm" style="background:#1e293b;color:#fff;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-weight:600;">Entendido</button>
            </div>
          `;
          document.body.appendChild(successModal);
          
          successModal.addEventListener('click', (e) => {
            if (e.target === successModal) document.body.removeChild(successModal);
          });
          
          successModal.querySelector('#successOk').addEventListener('click', () => {
            document.body.removeChild(successModal);
          });
          
          if (modal) modal.style.display = 'none';
        } catch (e) {
          alert('Error: ' + e.message);
        }
      });
    });
  }

  // Carga inicial
  if (grid) fetchProducts();
});