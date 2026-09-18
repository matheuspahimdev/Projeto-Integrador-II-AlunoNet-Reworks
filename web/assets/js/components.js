/**
 * Componentes compartilhados do Alunonet.
 *
 * As URLs são calculadas a partir deste próprio arquivo. Assim elas funcionam
 * tanto ao abrir o protótipo localmente quanto quando ele estiver em uma
 * subpasta do servidor, inclusive nas páginas dentro de /pages.
 */

const COMPONENTS_URL = document.currentScript?.src || window.location.href;
const APP_ROOT_URL = new URL('../../', COMPONENTS_URL);
const route = (path) => new URL(path, APP_ROOT_URL).href;

const ROUTES = Object.freeze({
  home: APP_ROOT_URL.href,
  centralAcademica: route('pages/academico/centralAcademico.html'),
  boletos: route('pages/financeiro/centralBoletos.html'),
  chamados: route('pages/suporte/chamado.html'),
  repositorio: route('pages/materiais/repositorioAluno.html'),
  avaliacao: route('pages/avalieNos/avaliacaoFaculdade.html'),
});

class NavBar extends HTMLElement {
  static ITEMS = [
    { label: 'Início', icon: 'bi-house-door-fill', href: ROUTES.home },
    {
      label: 'Acadêmico', icon: 'bi-mortarboard',
      subs: [
        { label: 'Central Acadêmica', href: ROUTES.centralAcademica },
        { label: 'Horas de Aula', href: ROUTES.centralAcademica },
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
    if (!document.querySelector('[data-sidebar-backdrop]')) {
      document.body.insertAdjacentHTML('afterbegin', '<div class="sidebar-backdrop" data-sidebar-backdrop></div>');
    }

    const items = NavBar.ITEMS.map((item, index) => this.renderItem(item, index)).join('');

    this.innerHTML = `
      <a class="sidebar-nav__brand" href="${ROUTES.home}" aria-label="Página inicial do Alunonet">
        <img class="brand-logo brand-logo--dark-theme"
          src="${route('assets/img/UnifioLogoBranco.png')}"
          alt="Alunonet">

        <img class="brand-logo brand-logo--light-theme"
          src="${route('assets/img/UnifioLogoAzul.png')}"
          alt="Alunonet">
      </a>
      <nav class="sidebar-nav__content" aria-label="Navegação principal">
        <ul class="sidebar-nav__list">${items}</ul>
      </nav>
      <div class="sidebar-nav__footer">
        <button class="sidebar-nav__exit" type="button" aria-disabled="true" title="O encerramento de sessão será conectado quando houver autenticação">
          <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
          <span>Sair</span>
        </button>
      </div>
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

  renderItem(item, index) {
    const hasSubs = Array.isArray(item.subs) && item.subs.length > 0;
    const isHome = window.location.pathname.endsWith('/') || window.location.pathname.endsWith('/index.html');
    const isActive = (item.label === 'Início' && isHome)
      || item.subs?.some((sub) => new URL(sub.href).pathname === window.location.pathname);
    const classes = `sidebar-nav__link${item.accent ? ' sidebar-nav__link--accent' : ''}${isActive ? ' is-active' : ''}`;

    if (hasSubs) {
      const menuId = `nav-submenu-${index}`;
      const subItems = item.subs.map((sub) => `
        <li><a class="sidebar-nav__sublink" href="${sub.href}">${sub.label}</a></li>
      `).join('');
      return `
        <li class="sidebar-nav__item sidebar-nav__item--expandable${isActive ? ' is-open' : ''}">
          <button class="${classes}" type="button" aria-expanded="${isActive ? 'true' : 'false'}" aria-controls="${menuId}">
            <i class="bi ${item.icon}"></i>
            <span>${item.label}</span>
            <i class="bi bi-chevron-down sidebar-nav__chevron" aria-hidden="true"></i>
          </button>
          <div id="${menuId}" class="sidebar-nav__submenu">
            <ul class="sidebar-nav__submenu-list">${subItems}</ul>
          </div>
        </li>
      `;
    }

    if (item.unavailable || !item.href) {
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

// O controle fica delegado ao documento: funciona mesmo quando a navbar e o
// botão do topo são criados em momentos diferentes durante o carregamento.
const closeMenu = () => {
  document.body.classList.remove('sidebar-is-open');
  document.querySelector('[data-sidebar-toggle]')?.setAttribute('aria-expanded', 'false');
};

customElements.define('nav-bar', NavBar);

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

class PortalHeader extends HTMLElement {
  // Inclua novos cursos aqui. Quando houver integração com dados reais,
  // esta lista poderá ser preenchida pela API mantendo o mesmo formato.
  static COURSES = [
    { label: '2026/2 · Eng. de Software', selected: true },
    { label: '2026/2 · Análise e Desenvolvimento de Sistemas' },
    { label: '2026/2 · Administração' },
  ];

  connectedCallback() {
    if (this.dataset.ready) return;
    this.dataset.ready = 'true';
    this.classList.add('portal-topbar');
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
        <span class="portal-topbar__profile-text"><strong>Victor H. Oliveira</strong><small>RA: 274769</small></span>
        <span class="portal-topbar__avatar" aria-label="Perfil de Victor H. Oliveira">VO</span>
      </div>
    `;
  }
}

customElements.define('portal-header', PortalHeader);

class ThemeToggle extends HTMLElement {
  connectedCallback() {
    this.classList.add('icon-btn', 'theme-toggle');
    this.setAttribute('role', 'button');
    this.setAttribute('tabindex', '0');
    this.setAttribute('aria-label', 'Alternar tema claro/escuro');

    const savedTheme = localStorage.getItem('alunonet-theme');
    if (savedTheme === 'light' || savedTheme === 'dark') {
      document.documentElement.setAttribute('data-bs-theme', savedTheme);
    }

    this.innerHTML = '<i class="bi bi-sun-fill icon-sun"></i><i class="bi bi-moon-stars-fill icon-moon"></i>';

    const toggle = () => {
      const html = document.documentElement;
      const theme = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-bs-theme', theme);
      localStorage.setItem('alunonet-theme', theme);
    };

    this.addEventListener('click', toggle);
    this.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggle();
      }
    });
  }
}

customElements.define('theme-toggle', ThemeToggle);