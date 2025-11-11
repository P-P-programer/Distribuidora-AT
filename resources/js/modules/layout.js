// Toggle de menú hamburguesa y dropdown de usuario
document.addEventListener('DOMContentLoaded', () => {
  const header = document.getElementById('appHeader');
  const btn = document.getElementById('hamburger');
  const headMenu = document.getElementById('headMenu');

  const userBtn = document.getElementById('userMenuBtn');
  const userMenu = document.getElementById('userMenu');

  const openPanel = (el, controlBtn) => {
    if (!el) return;
    // colocar el panel justo debajo del header
    if (header) el.style.top = `${header.offsetHeight + 8}px`;
    el.classList.add('open');
    el.removeAttribute('hidden');
    el.setAttribute('aria-hidden', 'false');
    if (controlBtn) controlBtn.setAttribute('aria-expanded', 'true');
  };
  const closePanel = (el, controlBtn) => {
    if (!el) return;
    el.classList.remove('open');
    el.setAttribute('aria-hidden', 'true');
    // ocultar tras animación
    setTimeout(() => { if (!el.classList.contains('open')) el.setAttribute('hidden', ''); }, 180);
    if (controlBtn) controlBtn.setAttribute('aria-expanded', 'false');
  };
  const togglePanel = (el, controlBtn) => {
    if (!el) return;
    const isOpen = el.classList.contains('open');
    if (isOpen) closePanel(el, controlBtn); else openPanel(el, controlBtn);
  };

  // hamburguesa (solo móvil)
  if (btn && headMenu) {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      togglePanel(headMenu, btn);
      // cerrar dropdown usuario si está abierto
      if (userMenu && !userMenu.hasAttribute('hidden')) {
        userBtn && userBtn.setAttribute('aria-expanded', 'false');
        userMenu.setAttribute('hidden','');
      }
    });
  }

  // Dropdown usuario
  const toggleDropdown = (el, controlBtn) => {
    if (!el) return;
    const isHidden = el.hasAttribute('hidden');
    if (!isHidden) el.setAttribute('hidden', '');
    else el.removeAttribute('hidden');
    if (controlBtn) controlBtn.setAttribute('aria-expanded', String(isHidden));
  };

  if (userBtn && userMenu) {
    userBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleDropdown(userMenu, userBtn);
      // cerrar panel headMenu si está abierto
      if (headMenu && headMenu.classList.contains('open')) closePanel(headMenu, btn);
    });

    document.addEventListener('click', (e) => {
      if (userMenu && !userMenu.hasAttribute('hidden') &&
          !userMenu.contains(e.target) && e.target !== userBtn) {
        toggleDropdown(userMenu, userBtn);
      }
      if (headMenu && headMenu.classList.contains('open') &&
          !headMenu.contains(e.target) && e.target !== btn) {
        closePanel(headMenu, btn);
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (userMenu && !userMenu.hasAttribute('hidden')) toggleDropdown(userMenu, userBtn);
        if (headMenu && headMenu.classList.contains('open')) closePanel(headMenu, btn);
      }
    });
  }

  // Carrito
  const mobileCart = document.getElementById('mobileCart');
  const cartBtn = document.getElementById('cartBtn');
  const goToCart = () => { window.location.href = '/cart'; };
  if (mobileCart) mobileCart.addEventListener('click', goToCart);
  if (cartBtn) cartBtn.addEventListener('click', goToCart);
});