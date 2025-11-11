document.addEventListener('DOMContentLoaded', () => {
  const buyBtn = document.getElementById('buyConfirmBtn');
  const form = document.getElementById('buyForm');
  const modal = document.getElementById('buyConfirmModal');
  const txt = document.getElementById('buyConfirmText');
  const closeBtn = document.getElementById('buyConfirmClose');
  const cancelBtn = document.getElementById('buyCancelBtn');
  const okBtn = document.getElementById('buyOkBtn');
  const total = form ? form.dataset.total : '0.00';

  if (!buyBtn || !form) return;

  buyBtn.type = 'button';

  function openModal() {
    if (!modal) return;
    txt.innerHTML = '¿Estás seguro de comprar por <strong>$' + parseFloat(total).toFixed(2) + '</strong>?';
    modal.hidden = false;
    modal.style.display = 'flex';
  }
  function closeModal() {
    if (!modal) return;
    modal.hidden = true;
    modal.style.display = 'none';
  }

  buyBtn.addEventListener('click', e => {
    e.preventDefault();
    openModal();
  });
  [closeBtn, cancelBtn].forEach(b => b && b.addEventListener('click', closeModal));
  modal && modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  okBtn && okBtn.addEventListener('click', () => {
    closeModal();
    form.submit();
  });
});