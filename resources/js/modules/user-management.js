document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('confirmModal');
  const txt = document.getElementById('confirmText');
  const closeBtn = document.getElementById('confirmClose');
  const cancelBtn = document.getElementById('confirmCancel');
  const okBtn = document.getElementById('confirmOk');
  const focusableSelector = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
  let pendingSubmit = null;
  let lastFocused = null;

  function trapFocus(container, e) {
    const nodes = container.querySelectorAll(focusableSelector);
    if (!nodes.length) return;
    const first = nodes[0];
    const last = nodes[nodes.length - 1];
    if (e.key === 'Tab') {
      if (e.shiftKey && document.activeElement === first) {
        last.focus();
        e.preventDefault();
      } else if (!e.shiftKey && document.activeElement === last) {
        first.focus();
        e.preventDefault();
      }
    } else if (e.key === 'Escape') {
      closeModal();
    }
  }

  function openModal(message, onOk) {
    lastFocused = document.activeElement;
    txt.innerHTML = message;
    modal.hidden = false;
    modal.style.display = 'flex';
    pendingSubmit = onOk;
    setTimeout(() => okBtn && okBtn.focus(), 0);
    modal.addEventListener('keydown', (e) => trapFocus(modal, e));
  }

  function closeModal() {
    modal.hidden = true;
    modal.style.display = 'none';
    pendingSubmit = null;
    if (lastFocused && typeof lastFocused.focus === 'function') {
      lastFocused.focus();
    }
  }

  [closeBtn, cancelBtn].forEach(b => b && b.addEventListener('click', closeModal));
  modal && modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

  okBtn && okBtn.addEventListener('click', () => { if (pendingSubmit) pendingSubmit(); closeModal(); });

  // Crear usuario
  const createBtn = document.getElementById('createConfirm');
  const createForm = document.getElementById('createUserForm');
  if (createBtn && createForm) {
    createBtn.addEventListener('click', () => {
      const name = (createForm.querySelector('#cu_name')?.value || 'este usuario').trim();
      const role = (createForm.querySelector('#cu_role')?.value || 'usuario');
      openModal(`¿Crear a <strong>${name}</strong> con rol <strong>${role}</strong>?`, () => createForm.submit());
    });
  }

  // Guardar por fila
  document.querySelectorAll('.btn-save').forEach(btn => {
    btn.addEventListener('click', () => {
      const form = btn.closest('form.inline-edit');
      const name = form.querySelector('input[name="name"]').value;
      openModal(`¿Guardar cambios de <strong>${name}</strong>?`, () => form.submit());
    });
  });

  // Inactivar/activar
  document.querySelectorAll('.btn-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const form = btn.closest('form');
      const action = btn.dataset.action;
      const name = btn.dataset.name;
      openModal(`¿Seguro que deseas <strong>${action}</strong> a <strong>${name}</strong>?`, () => form.submit());
    });
  });
});