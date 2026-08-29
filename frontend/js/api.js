// ══════════════════════════════════════════════
// api.js — Laravel API Helper
// Base URL: change this to your Laravel server
// ══════════════════════════════════════════════

const API_BASE = 'http://localhost:8000/api';

// Get stored auth token
function getToken() {
  return localStorage.getItem('auth_token');
}

// Get stored user info
function getUser() {
  const u = localStorage.getItem('auth_user');
  return u ? JSON.parse(u) : null;
}

// Check if logged in, redirect to login if not
function requireAuth() {
  if (!getToken()) {
    window.location.href = 'login.html';
    return false;
  }
  return true;
}

// Check if admin, redirect if not
function requireAdmin() {
  const user = getUser();
  if (!user || user.role !== 'admin') {
    window.location.href = 'dashboard.html';
    return false;
  }
  return true;
}

// Core API fetch wrapper
async function apiFetch(endpoint, options = {}) {
  const token = getToken();
  const config = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
      ...options.headers,
    },
    ...options,
  };
  if (config.body && typeof config.body === 'object') {
    config.body = JSON.stringify(config.body);
  }
  try {
    const res = await fetch(`${API_BASE}${endpoint}`, config);
    if (res.status === 401) {
      localStorage.clear();
      window.location.href = 'login.html';
      return null;
    }
    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'API error');
    return data;
  } catch (err) {
    throw err;
  }
}

// ── CONVENIENCE METHODS ──
const api = {
  get:    (url)         => apiFetch(url, { method: 'GET' }),
  post:   (url, body)   => apiFetch(url, { method: 'POST', body }),
  put:    (url, body)   => apiFetch(url, { method: 'PUT', body }),
  delete: (url)         => apiFetch(url, { method: 'DELETE' }),

  // Auth
  login:     (username, password) => apiFetch('/login',  { method: 'POST', body: { username, password } }),
  verifyOtp: (username, otp)      => apiFetch('/verify-otp', { method: 'POST', body: { username, otp } }),
  logout:    ()                   => apiFetch('/logout', { method: 'POST' }),

  // Categories
  getCategories:    ()       => api.get('/categories'),
  createCategory:   (data)   => api.post('/categories', data),
  updateCategory:   (id, d)  => api.put(`/categories/${id}`, d),
  deleteCategory:   (id)     => api.delete(`/categories/${id}`),

  // Menu Items
  getMenuItems:  ()       => api.get('/menu-items'),
  createItem:    (data)   => api.post('/menu-items', data),
  updateItem:    (id, d)  => api.put(`/menu-items/${id}`, d),
  deleteItem:    (id)     => api.delete(`/menu-items/${id}`),

  // Tables
  getTables:     ()       => api.get('/tables'),

  // Orders
  getOrders:    ()          => api.get('/orders'),
  createOrder:  (data)      => api.post('/orders', data),
  updateStatus: (id, status)=> api.put(`/orders/${id}/status`, { status }),
  cancelOrder:  (id)        => api.put(`/orders/${id}/status`, { status: 'cancelled' }),

  // Bills
  getBills:     ()          => api.get('/bills'),
  createBill:   (data)      => api.post('/bills', data),
  markPaid:     (id)        => api.put(`/bills/${id}/pay`, {}),

  // Reports (admin)
  getSummary:   ()          => api.get('/reports/summary'),
  getTopItems:  ()          => api.get('/reports/top-items'),

  // Users (admin)
  getUsers:     ()          => api.get('/users'),
  createUser:   (data)      => api.post('/users', data),
  deleteUser:   (id)        => api.delete(`/users/${id}`),
};
