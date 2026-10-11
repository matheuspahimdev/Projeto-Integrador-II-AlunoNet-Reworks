const COMPONENTS_URL = document.currentScript?.src || window.location.href;
const APP_ROOT_URL = new URL('../../index.php', COMPONENTS_URL);
const THEME_STORAGE_KEY = 'alunonet-theme';

const route = (path) => new URL(path, APP_ROOT_URL).href;

const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (character) => ({
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#039;',
}[character]));

const saveTheme = (theme) => {
  try {
    localStorage.setItem(THEME_STORAGE_KEY, theme);
  } catch {
    return;
  }
};

const closeMenu = () => {
  document.body.classList.remove('sidebar-is-open');
  document.querySelector('[data-sidebar-toggle]')?.setAttribute('aria-expanded', 'false');
};

const ROUTES = Object.freeze({
  home: APP_ROOT_URL.href,
  centralAcademica: route('pages/academico/centralAcademico.php'),
  horarioAulas: route('pages/academico/horarioAulas.php'),
  calendarioProvas: route('pages/academico/calendarioProvas.php'),
  notas: route('pages/academico/notas.php'),
  faltas: route('pages/academico/faltas.php'),
  desempenho: route('pages/academico/desempenho.php'),
  dadosCadastrais: route('pages/academico/dadosCadastrais.php'),
  confirmacaoMatricula: route('pages/academico/confirmacaoMatricula.php'),
  dic: route('pages/academico/dic.php'),
  atualizacaoDados: route('pages/academico/atualizacaoDadosCadastrais.php'),
  atividadesComplementares: route('pages/academico/atividadesComplementares.php'),
  planoEnsino: route('pages/academico/planoEnsino.php'),
  carteirinhaDigital: route('pages/academico/carteirinhaDigital.php'),
  boletos: route('pages/financeiro/centralBoleto.php'),
  chamados: route('pages/suporte/chamado.php'),
  repositorio: route('pages/materiais/repositorioAluno.php'),
  avaliacao: route('pages/avalieNos/avaliacaoFaculdade.php'),
});

class NavBar extends HTMLElement {
  static ITEMS = [
    { label: 'Início', icon: 'bi-house-door-fill', href: ROUTES.home },
    {
      label: 'Acadêmico', icon: 'bi-mortarboard',
      subs: [
        { label: 'Central Acadêmica', href: ROUTES.centralAcademica },
        { label: 'Horário de Aulas', href: ROUTES.horarioAulas },
        { label: 'Calendário de Provas', href: ROUTES.calendarioProvas },
        { label: 'Notas', href: ROUTES.notas },
        { label: 'Faltas', href: ROUTES.faltas },
        { label: 'Gráficos de Desempenho', href: ROUTES.desempenho },
        { label: 'Dados Cadastrais', href: ROUTES.dadosCadastrais },
        { label: 'Confirmação de Matrícula', href: ROUTES.confirmacaoMatricula },
        { label: 'DIC', href: ROUTES.dic },
        { label: 'Atualização de Dados Cadastrais', href: ROUTES.atualizacaoDados },
        { label: 'Atividades Complementares', href: ROUTES.atividadesComplementares },
        { label: 'Plano de Ensino', href: ROUTES.planoEnsino },
        { label: 'Carteirinha Digital', href: ROUTES.carteirinhaDigital },
      ],
    },
    {
      label: 'Financeiro', icon: 'bi-currency-dollar',
      subs: [
        { label: 'Central de Boletos', href: ROUTES.boletos },
      ],
    },
    { label: 'Protocolos', icon: 'bi-graph-up-arrow', unavailable: true },
    {
      label: 'Avalie-nos', icon: 'bi-pencil-square',
      subs: [
        { label: 'Avaliação da Faculdade', href: ROUTES.avaliacao },
      ],
    },
    {
      label: 'Materiais', icon: 'bi-book-half',
      subs: [
        { label: 'Repositório do Aluno', href: ROUTES.repositorio },
      ],
    },
    { label: 'Avisos', icon: 'bi-envelope', unavailable: true },
    { label: 'Biblioteca', icon: 'bi-bookshelf', unavailable: true },
    { label: 'Eventos', icon: 'bi-calendar-event', unavailable: true },
    { label: 'Moodle', icon: 'bi-easel2', unavailable: true },
    { label: 'Carreiras', icon: 'bi-rocket-takeoff', unavailable: true },
    {
      label: 'Suporte', icon: 'bi-headset', accent: true,
      subs: [
        { label: 'Chamados', href: ROUTES.chamados },
      ],
    },
  ];

  connectedCallback() {
    if (this.dataset.ready) return;
    this.dataset.ready = 'true';
    this.classList.add('sidebar-nav');

    const items = NavBar.ITEMS.map((item, index) => this.renderItem(item, index)).join('');

    this.innerHTML = `
      <a class="sidebar-nav__brand" href="${ROUTES.home}" aria-label="Página inicial do Alunonet">
        <img class="brand-logo brand-logo--dark-theme" src="${route('assets/img/UnifioLogoBranco.png')}" alt="Alunonet">
        <img class="brand-logo brand-logo--light-theme" src="${route('assets/img/UnifioLogoAzul.png')}" alt="Alunonet">
      </a>
      <nav class="sidebar-nav__content" aria-label="Navegação principal">
        <ul class="sidebar-nav__list">${items}</ul>
      </nav>
    `;

    this.querySelectorAll('.sidebar-nav__item--expandable > button').forEach((button) => {
      button.addEventListener('click', () => {
        const item = button.closest('.sidebar-nav__item');
        const willOpen = !item.classList.contains('is-open');
        item.classList.toggle('is-open', willOpen);
        button.setAttribute('aria-expanded', String(willOpen));
      });
    });

    this.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
  }

  isActive(item) {
    const { pathname } = window.location;
    const isHome = pathname.endsWith('/') || pathname.endsWith('/index.php');
    return (item.href === ROUTES.home && isHome)
      || Boolean(item.subs?.some((sub) => new URL(sub.href).pathname === pathname));
  }

  renderItem(item, index) {
    const isActive = this.isActive(item);
    const classes = `sidebar-nav__link${item.accent ? ' sidebar-nav__link--accent' : ''}${isActive ? ' is-active' : ''}`;

    if (item.subs?.length) {
      const menuId = `nav-submenu-${index}`;
      const subItems = item.subs.map((sub) => `
        <li><a class="sidebar-nav__sublink" href="${sub.href}">${sub.label}</a></li>
      `).join('');
      return `
        <li class="sidebar-nav__item sidebar-nav__item--expandable${isActive ? ' is-open' : ''}">
          <button class="${classes}" type="button" aria-expanded="${isActive}" aria-controls="${menuId}">
            <i class="bi ${item.icon}"></i>
            <span>${item.label}</span>
            <i class="bi bi-chevron-down sidebar-nav__chevron" aria-hidden="true"></i>
          </button>
          <ul id="${menuId}" class="sidebar-nav__submenu">${subItems}</ul>
        </li>
      `;
    }

    if (item.unavailable) {
      return `
        <li class="sidebar-nav__item">
          <span class="${classes} opacity-50" aria-disabled="true" title="${item.label} — em breve">
            <i class="bi ${item.icon}"></i><span>${item.label}</span>
          </span>
        </li>
      `;
    }

    return `
      <li class="sidebar-nav__item">
        <a href="${item.href}" class="${classes}" title="${item.label}">
          <i class="bi ${item.icon}"></i><span>${item.label}</span>
        </a>
      </li>
    `;
  }
}

class PortalHeader extends HTMLElement {
  static COURSES = [
    { label: '2026/2 · Eng. de Software', selected: true },
    { label: '2026/2 · Análise e Desenvolvimento de Sistemas' },
    { label: '2026/2 · Administração' },
  ];

  connectedCallback() {
    if (this.dataset.ready) return;
    this.dataset.ready = 'true';
    this.classList.add('portal-topbar');

    const name = escapeHtml(this.dataset.name || 'Aluno');
    const registration = escapeHtml(this.dataset.registration || '');
    const initials = escapeHtml(this.dataset.initials || '');
    const courses = PortalHeader.COURSES.map((course) => `
      <option${course.selected ? ' selected' : ''}>${course.label}</option>
    `).join('');

    this.innerHTML = `
      <button class="portal-topbar__menu btn" type="button" data-sidebar-toggle
        aria-controls="main-navigation" aria-expanded="false" aria-label="Abrir menu de navegação">
        <i class="bi bi-list" aria-hidden="true"></i>
      </button>
      <span class="portal-topbar__title">Portal do Aluno</span>
      <div class="portal-topbar__profile">
        <theme-toggle></theme-toggle>
        <label class="portal-topbar__course-label" for="course-selector">Curso atual</label>
        <select id="course-selector" class="portal-topbar__course" aria-label="Selecionar curso atual">
          ${courses}
        </select>
        <span class="portal-topbar__profile-text"><strong>${name}</strong><small>RA: ${registration}</small></span>
        <span class="portal-topbar__avatar" aria-label="Perfil de ${name}">${initials}</span>
      </div>
    `;
  }
}

class ThemeToggle extends HTMLElement {
  connectedCallback() {
    if (this.dataset.ready) return;
    this.dataset.ready = 'true';
    this.classList.add('icon-btn', 'theme-toggle');
    this.setAttribute('role', 'button');
    this.setAttribute('tabindex', '0');
    this.setAttribute('aria-label', 'Alternar tema claro/escuro');
    this.innerHTML = '<i class="bi bi-sun-fill icon-sun"></i><i class="bi bi-moon-stars-fill icon-moon"></i>';

    this.addEventListener('click', () => this.toggleTheme());
    this.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        this.toggleTheme();
      }
    });
  }

  toggleTheme() {
    const root = document.documentElement;
    const nextTheme = root.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
    root.setAttribute('data-bs-theme', nextTheme);
    saveTheme(nextTheme);
  }
}

document.addEventListener('click', (event) => {
  const trigger = event.target.closest('[data-sidebar-toggle]');
  if (trigger) {
    const isOpen = document.body.classList.toggle('sidebar-is-open');
    trigger.setAttribute('aria-expanded', String(isOpen));
    return;
  }

  if (event.target.closest('[data-sidebar-backdrop]')) closeMenu();
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') closeMenu();
});

customElements.define('nav-bar', NavBar);
customElements.define('portal-header', PortalHeader);
customElements.define('theme-toggle', ThemeToggle);

requestAnimationFrame(() => document.documentElement.removeAttribute('data-app-loading'));