// ══════════════════════════════════════════════
// sidebar.js — Renders sidebar and sets active page
// ══════════════════════════════════════════════

function renderSidebar(activePage) {
  const user = getUser();
  if (!user) return;

  const pages = [
    { id: 'dashboard',  href: 'dashboard.html',  label: 'Dashboard',   icon: svgIcons.dashboard },
    { id: 'new-order',  href: 'new-order.html',  label: 'New Order',   icon: svgIcons.restaurant },
    { id: 'orders',     href: 'orders.html',     label: 'Orders',      icon: svgIcons.orders },
    { id: 'billing',    href: 'billing.html',    label: 'Billing',     icon: svgIcons.bill },
    { id: 'menu',       href: 'menu.html',       label: 'Menu Items',  icon: svgIcons.menu },
    { id: 'categories', href: 'categories.html', label: 'Categories',  icon: svgIcons.category },
    ...(user.role === 'admin' ? [
      { id: 'reports', href: 'reports.html', label: 'Reports', icon: svgIcons.report },
      { id: 'users',   href: 'users.html',   label: 'Users',   icon: svgIcons.users },
    ] : []),
  ];

  const navHTML = pages.map(p => `
    <a href="${p.href}" class="nav-item ${activePage === p.id ? 'active' : ''}">
      ${p.icon} ${p.label}
    </a>
  `).join('');

  const sidebar = document.getElementById('sidebar');
  if (sidebar) {
    sidebar.innerHTML = `
      <div class="sidebar-logo">
        <h1>Street 160</h1>
        <p>Family Restaurant</p>
      </div>
      <nav style="flex:1;overflow-y:auto;">${navHTML}</nav>
      <div class="sidebar-footer">
        <div class="user-chip">
          <div class="name">${user.name}</div>
          <div class="role">${user.role}</div>
        </div>
        <button class="logout-btn" onclick="doLogout()">
          ${svgIcons.logout} Logout
        </button>
      </div>
    `;
  }
}

async function doLogout() {
  try { await api.logout(); } catch(e) {}
  localStorage.clear();
  window.location.href = 'login.html';
}

// ── ALERT HELPERS ──
function showAlert(id, msg, type = 'success') {
  const el = document.getElementById(id);
  if (!el) return;
  el.className = `alert alert-${type} show`;
  el.innerHTML = msg; // allow simple HTML
  setTimeout(() => el.classList.remove('show'), 3500);
}

// ── CUSTOM CONFIRM ──
window.customConfirm = function(message) {
  return new Promise((resolve) => {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay show';
    overlay.style.zIndex = '9999';
    overlay.style.backdropFilter = 'blur(4px)';

    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.style.maxWidth = '360px';
    modal.style.textAlign = 'center';
    modal.style.padding = '32px 24px';
    
    const icon = document.createElement('div');
    icon.innerHTML = '<svg width="40" height="40" style="color:var(--warning);margin-bottom:16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
    
    const msg = document.createElement('div');
    msg.style.fontSize = '15px';
    msg.style.marginBottom = '24px';
    msg.style.color = 'var(--text)';
    msg.textContent = message;

    const btnGroup = document.createElement('div');
    btnGroup.style.display = 'flex';
    btnGroup.style.gap = '12px';
    btnGroup.style.justifyContent = 'center';

    const btnCancel = document.createElement('button');
    btnCancel.className = 'btn btn-ghost';
    btnCancel.textContent = 'Cancel';
    btnCancel.onclick = () => { document.body.removeChild(overlay); resolve(false); };

    const btnOk = document.createElement('button');
    btnOk.className = 'btn btn-danger';
    btnOk.textContent = 'Confirm';
    btnOk.onclick = () => { document.body.removeChild(overlay); resolve(true); };

    btnGroup.appendChild(btnCancel);
    btnGroup.appendChild(btnOk);
    
    modal.appendChild(icon);
    modal.appendChild(msg);
    modal.appendChild(btnGroup);
    overlay.appendChild(modal);
    document.body.appendChild(overlay);
  });
};

// ── LOADING HELPERS ──
function setLoading(id, show) {
  const el = document.getElementById(id);
  if (el) el.style.display = show ? 'block' : 'none';
}

// ── BADGE HELPER ──
function statusBadge(status) {
  const map = {
    pending:   'info',
    preparing: 'warning',
    ready:     'gold',
    completed: 'success',
    cancelled: 'danger',
    active:    'success',
    inactive:  'muted',
    paid:      'success',
    unpaid:    'warning',
    available:   'success',
    unavailable: 'danger',
    admin: 'gold',
    staff: 'info',
  };
  return `<span class="badge badge-${map[status] || 'muted'}">${status}</span>`;
}

// ── SVG ICONS ──
const svgIcons = {
  dashboard:  `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>`,
  restaurant: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>`,
  orders:     `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 011-1"/></svg>`,
  bill:       `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>`,
  menu:       `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>`,
  category:   `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>`,
  report:     `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18,20 18,10 12,20 12,4 6,20 6,14"/></svg>`,
  users:      `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>`,
  logout:     `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>`,
  plus:       `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>`,
  print:      `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 6,2 18,2 18,9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>`,
};
