document.addEventListener('DOMContentLoaded', () => {
  const cartBtn = document.getElementById('cartBtn');
  const empty = document.querySelector('[data-cart-empty="1"]');
  const success = document.querySelector('[data-purchase-success="1"]');
  if (empty || success) {
    localStorage.setItem('cartCount','0');
    if (cartBtn) {
      const badge = cartBtn.querySelector('.cart-badge');
      if (badge) badge.remove();
    }
  }
});