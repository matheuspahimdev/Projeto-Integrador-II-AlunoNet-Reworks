const THEME_STORAGE_KEY = 'alunonet-theme';

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

document.addEventListener('click', (event) => {
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

  if (event.target.closest('[data-sidebar-backdrop], .sidebar-nav a')) setSidebarOpen(false);
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') setSidebarOpen(false);
});