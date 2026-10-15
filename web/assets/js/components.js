const THEME_STORAGE_KEY = 'alunonet-theme';

const portalToday = () => {
  const iso = document.documentElement.dataset.today;
  const date = iso ? new Date(`${iso}T00:00:00`) : new Date();
  date.setHours(0, 0, 0, 0);
  return date;
};

const portalNowISO = () => {
  const time = new Date();
  const pad = (value) => String(value).padStart(2, '0');
  return `${toIsoDate(portalToday())}T${pad(time.getHours())}:${pad(time.getMinutes())}`;
};

const toIsoDate = (date) => date.toLocaleDateString('sv-SE');

const parseIsoDate = (iso) => new Date(`${iso}T00:00:00`);

const addDays = (date, days) => {
  const copy = new Date(date);
  copy.setDate(copy.getDate() + days);
  return copy;
};

const formatDateBR = (date) => date.toLocaleDateString('pt-BR');

const pluralize = (count, singular, plural) => `${count} ${count === 1 ? singular : plural}`;

const createNode = (tag, className = '', text = '') => {
  const node = document.createElement(tag);
  if (className) node.className = className;
  if (text) node.textContent = text;
  return node;
};

const createIcon = (className) => {
  const node = createNode('i', className);
  node.setAttribute('aria-hidden', 'true');
  return node;
};

const createButton = (className, text = '') => {
  const node = createNode('button', className, text);
  node.type = 'button';
  return node;
};

const readPageData = (id) => JSON.parse(document.getElementById(id).textContent);

const readStoredJson = (key, fallback) => {
  try {
    return JSON.parse(localStorage.getItem(key)) ?? fallback;
  } catch {
    return fallback;
  }
};

const readStoredList = (key) => {
  const value = readStoredJson(key, []);
  return Array.isArray(value) ? value : [];
};

const storeJson = (key, value) => {
  try {
    localStorage.setItem(key, JSON.stringify(value));
    return true;
  } catch {
    return false;
  }
};

const removeStored = (key) => {
  try {
    localStorage.removeItem(key);
  } catch {
    return;
  }
};

const showToast = (message, { ok = true, link = null } = {}) => {
  const toastElement = document.getElementById('pageToast');
  const body = document.getElementById('pageToastBody');
  toastElement.classList.toggle('text-bg-success', ok);
  toastElement.classList.toggle('text-bg-danger', !ok);
  body.replaceChildren(document.createTextNode(message));
  if (link) {
    const anchor = createNode('a', 'text-white fw-bold ms-1', link.label);
    anchor.href = link.href;
    body.append(anchor);
  }
  bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 5000 }).show();
};

const copyToClipboard = async (text) => {
  try {
    await navigator.clipboard.writeText(text);
    return true;
  } catch {
    const area = createNode('textarea');
    area.value = text;
    area.style.position = 'fixed';
    area.style.opacity = '0';
    document.body.append(area);
    area.select();
    let copied = false;
    try {
      copied = document.execCommand('copy');
    } catch {
      copied = false;
    }
    area.remove();
    return copied;
  }
};

const copyFromButton = async (button) => {
  const copied = await copyToClipboard(button.dataset.copy);
  showToast(copied ? button.dataset.copyMessage : 'Não foi possível copiar. Selecione o código e copie manualmente.', { ok: copied });
};

const printWithTitle = (title) => {
  const originalTitle = document.title;
  window.addEventListener('afterprint', () => { document.title = originalTitle; }, { once: true });
  document.title = title;
  window.print();
};

const togglePasswordVisibility = (button) => {
  const input = document.getElementById(button.dataset.togglePassword);
  const show = input.type === 'password';
  input.type = show ? 'text' : 'password';
  button.setAttribute('aria-pressed', String(show));
  button.setAttribute('aria-label', show ? 'Ocultar senha' : 'Mostrar senha');
  button.querySelector('i').className = `bi ${show ? 'bi-eye-slash' : 'bi-eye'}`;
};

const saveTheme = (theme) => {
  try {
    localStorage.setItem(THEME_STORAGE_KEY, theme);
  } catch {
    return;
  }
};

const toggleTheme = () => {
  const root = document.documentElement;
  const nextTheme = root.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
  root.setAttribute('data-bs-theme', nextTheme);
  saveTheme(nextTheme);
};

const setSidebarOpen = (isOpen) => {
  document.body.classList.toggle('sidebar-is-open', isOpen);
  document.querySelector('[data-sidebar-toggle]')?.setAttribute('aria-expanded', String(isOpen));
};

const toggleSubmenu = (button) => {
  const item = button.closest('.sidebar-nav__item');
  const willOpen = !item.classList.contains('is-open');
  item.classList.toggle('is-open', willOpen);
  button.setAttribute('aria-expanded', String(willOpen));
};

document.querySelectorAll('.sidebar-nav__submenu').forEach((menu) => {
  menu.style.setProperty('--submenu-height', `${menu.scrollHeight}px`);
});

const openLogoutDialog = () => {
  const dialog = document.getElementById('logoutDialog');
  if (!dialog || !window.bootstrap) return false;

  setSidebarOpen(false);
  bootstrap.Modal.getOrCreateInstance(dialog).show();
  return true;
};

document.getElementById('logoutDialog')?.addEventListener('shown.bs.modal', (event) => {
  event.target.querySelector('.alert-dialog__cancel').focus();
});

document.addEventListener('click', (event) => {
  if (event.target.closest('[data-logout-confirm]') && openLogoutDialog()) {
    event.preventDefault();
    return;
  }

  const submenuButton = event.target.closest('.sidebar-nav__item--expandable > button');
  if (submenuButton) {
    toggleSubmenu(submenuButton);
    return;
  }

  if (event.target.closest('[data-sidebar-toggle]')) {
    setSidebarOpen(!document.body.classList.contains('sidebar-is-open'));
    return;
  }

  if (event.target.closest('[data-theme-toggle]')) {
    toggleTheme();
    return;
  }

  const copyButton = event.target.closest('[data-copy]');
  if (copyButton) {
    copyFromButton(copyButton);
    return;
  }

  const printButton = event.target.closest('[data-print-title]');
  if (printButton) {
    printWithTitle(printButton.dataset.printTitle);
    return;
  }

  const passwordToggle = event.target.closest('[data-toggle-password]');
  if (passwordToggle) {
    togglePasswordVisibility(passwordToggle);
    return;
  }

  if (event.target.closest('[data-sidebar-backdrop], .sidebar-nav a')) setSidebarOpen(false);
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') setSidebarOpen(false);
});