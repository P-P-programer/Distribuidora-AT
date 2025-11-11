const icons = {
  success: '<svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="m10 17l-5-5l1.4-1.4l3.6 3.575L17.6 6.6L19 8z"/></svg>',
  error:   '<svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 22q-2.075 0-3.9-.788t-3.2-2.137t-2.137-3.2T2 12t.788-3.875t2.137-3.2t3.2-2.15T12 2t3.875.775t3.2 2.15t2.15 3.2T22 12t-.775 3.975t-2.15 3.2t-3.2 2.137T12 22Zm-1-5h2v-2h-2v2Zm0-4h2V7h-2v6Z"/></svg>',
  info:    '<svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 17h2v-6h-2v6Zm1-8q.425 0 .713-.288T13 8q0-.425-.288-.712T12 7q-.425 0-.712.288T11 8q0 .425.288.713T12 9Zm0 13q-2.075 0-3.9-.788t-3.2-2.137t-2.137-3.2T2 12t.788-3.875t2.137-3.2t3.2-2.15T12 2t3.875.775t3.2 2.15t2.15 3.2T22 12t-.775 3.975t-2.15 3.2t-3.2 2.137T12 22Z"/></svg>',
  warning: '<svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M1 21h22L12 2L1 21Zm12-3h-2v-2h2v2Zm0-4h-2v-4h2v4Z"/></svg>',
};

function ensureRoot() {
  let root = document.getElementById('toast-root');
  if (!root) {
    root = document.createElement('div');
    root.id = 'toast-root';
    root.setAttribute('aria-live', 'polite');
    root.setAttribute('aria-atomic', 'true');
    document.body.appendChild(root);
  }
  return root;
}

export function showToast(message, type = 'info', opts = {}) {
  const root = ensureRoot();
  const toast = document.createElement('div');
  toast.className = `toast ${type} toast-enter`;
  toast.setAttribute('role', 'status');

  const title = opts.title || ({
    success: 'Éxito',
    error: 'Error',
    info: 'Información',
    warning: 'Aviso'
  })[type] || 'Aviso';

  toast.innerHTML = `
    ${icons[type] || icons.info}
    <div>
      <p class="title">${title}</p>
      <p class="msg">${message}</p>
    </div>
    <button class="close" aria-label="Cerrar">&times;</button>
  `;

  root.appendChild(toast);
  // enter animation
  requestAnimationFrame(() => toast.classList.add('toast-enter-active'));
  const close = () => {
    toast.classList.remove('toast-enter', 'toast-enter-active');
    toast.classList.add('toast-exit');
    requestAnimationFrame(() => toast.classList.add('toast-exit-active'));
    setTimeout(() => toast.remove(), 200);
  };
  toast.querySelector('.close')?.addEventListener('click', close);

  const ttl = typeof opts.ttl === 'number' ? opts.ttl : 3800;
  if (ttl > 0) setTimeout(close, ttl);
}

// Exponer helper global
window.flash = (msg, type = 'info', opts = {}) => showToast(msg, type, opts);

// Auto-cargar mensajes desde el script JSON del partial
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('flash-data');
  if (!el) return;
  try {
    const data = JSON.parse(el.textContent || '[]');
    if (Array.isArray(data)) {
      data.forEach(it => showToast(it.message, it.type, it.opts || {}));
    }
  } catch {}
});