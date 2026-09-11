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
  boletos: route('pages/financeiro/centralBoleto.html'),
  chamados: route('pages/suporte/chamado.html'),
  repositorio: route('pages/materiais/repositorioAluno.html'),
  avaliacao: route('pages/avalieNos/avaliacaoFaculdade.html'),
});

class NavBar extends HTMLElement {
  static ITEMS = [
    {
      label: 'Acadêmico', icon: 'bi-mortarboard',
      subs: [
        { label: 'Central Acadêmica', href: ROUTES.centralAcademica },
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
    this.classList.add('navbar-top', 'bg-body-tertiary', 'border',
      'd-flex', 'align-items-center', 'flex-shrink-0');

    const items = NavBar.ITEMS.map((item, index) => this.renderItem(item, index)).join('');

    this.innerHTML = `
      <a class="navbar-top__slot navbar-top__slot--logo rounded-pill"
          href="${ROUTES.home}" aria-label="Página inicial">
        <img class="brand-logo brand-logo--dark-theme"
          src="${route('assets/img/UnifioLogoBranco.png')}"
          alt="Alunonet">

        <img class="brand-logo brand-logo--light-theme"
          src="${route('assets/img/UnifioLogoAzul.png')}"
          alt="Alunonet">
      </a>
      <ul class="navbar-top__nav nav flex-row flex-nowrap">${items}</ul>
      <div class="navbar-top__actions">
        <theme-toggle></theme-toggle>
        <div class="navbar-top__slot navbar-top__slot--profile rounded-circle" title="perfil / avatar">
          <span class="navbar-top__slot-label">perfil</span>
        </div>
      </div>
    `;

    this.initializeDropdowns();
  }

  renderItem(item, index) {
    const hasSubs = Array.isArray(item.subs) && item.subs.length > 0;
    // A navegação mantém a mesma aparência em todas as páginas; nenhuma rota
    // recebe classe "is-active", pois ela faz o item parecer desaparecer no tema atual.
    const classes = `navbar-top__link${item.accent ? ' navbar-top__link--accent' : ''}`;

    if (hasSubs) {
      const menuId = `nav-drop-${index}`;
      const subItems = item.subs.map((sub) => `
        <li><a class="dropdown-item" href="${sub.href}">${sub.label}</a></li>
      `).join('');

      // O botão abre o menu; somente os links dentro dele fazem navegação.
      // Isto elimina o uso de href="#" e a necessidade de clicar duas vezes.
      return `
        <li class="nav-item dropdown">
          <button id="${menuId}" class="${classes} dropdown-toggle border-0 bg-transparent"
            type="button" data-bs-toggle="dropdown" aria-expanded="false" title="${item.label}">
            <i class="bi ${item.icon}"></i>
            <span class="navbar-top__link-label">${item.label}</span>
            <i class="bi bi-chevron-right navbar-top__chevron"></i>
          </button>
          <ul class="dropdown-menu" aria-labelledby="${menuId}">${subItems}</ul>
        </li>
      `;
    }

    if (item.unavailable || !item.href) {
      return `
        <li class="nav-item">
          <span class="${classes} opacity-50" aria-disabled="true" title="${item.label} — em breve">
            <i class="bi ${item.icon}"></i><span class="navbar-top__link-label">${item.label}</span>
          </span>
        </li>
      `;
    }

    return `
      <li class="nav-item">
        <a href="${item.href}" class="${classes}" title="${item.label}">
          <i class="bi ${item.icon}"></i><span class="navbar-top__link-label">${item.label}</span>
        </a>
      </li>
    `;
  }

  initializeDropdowns() {
    if (typeof bootstrap === 'undefined') {
      console.error('nav-bar: Bootstrap não foi carregado.');
      return;
    }

    let activeInstance = null;
    let closeTimer = null;

    this.querySelectorAll('.nav-item.dropdown').forEach((item) => {
      const toggle = item.querySelector('.dropdown-toggle');
      const menu = item.querySelector('.dropdown-menu');
      const instance = bootstrap.Dropdown.getOrCreateInstance(toggle, {
        popperConfig: { strategy: 'fixed' },
      });

      toggle.addEventListener('show.bs.dropdown', () => {
        menu.classList.remove('is-positioned');
        requestAnimationFrame(() => requestAnimationFrame(() => menu.classList.add('is-positioned')));
      });
      toggle.addEventListener('hide.bs.dropdown', () => menu.classList.remove('is-positioned'));

      item.addEventListener('mouseenter', () => {
        clearTimeout(closeTimer);
        if (activeInstance && activeInstance !== instance) activeInstance.hide();
        instance.show();
        activeInstance = instance;
      });

      item.addEventListener('mouseleave', () => {
        closeTimer = setTimeout(() => {
          instance.hide();
          if (activeInstance === instance) activeInstance = null;
        }, 220);
      });
    });
  }
}

customElements.define('nav-bar', NavBar);

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
