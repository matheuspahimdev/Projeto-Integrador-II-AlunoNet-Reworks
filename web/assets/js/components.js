/**
 * Componentes reutilizáveis entre páginas.
 * <nav-bar></nav-bar>            -> navbar em pílula, fixa no topo do shell
 * <theme-toggle></theme-toggle>  -> alterna claro/escuro (usado dentro da nav-bar)
 */

class NavBar extends HTMLElement{
  // cada item pode ter "subs": as sub-abas que aparecem no popup ao clicar.
  // hrefs ainda como placeholder ("#") até essas sub-páginas existirem.
  static ITEMS = [
    { label: 'Acadêmico',  icon: 'bi-mortarboard',
      subs: [{ label: 'Central Acadêmica', href: '../../pages/centralAcademico.html' }, { label: 'Horário de Aulas', href: '#' }, { label: 'Calendário de Provas', href: '#' }, { label: 'Notas e Faltas', href: '#' }, 
        { label: 'Graficos de Desempenho', href: '#' }, { label: 'Consultar Dados Cadastrais', href: '#' }, { label: 'Confirmação de Matrícula', href: '#' }, { label: 'Documentação Integralização Curricular', href: '#' }, 
        { label: 'Atualização de Dados Cadastrais', href: '#' }, { label: 'Atividades Complementares', href: '#' }, { label: 'Plano de Ensino', href: '#' }, { label: 'Carterinha Digital', href: '#' }] },
    { label: 'Financeiro', icon: 'bi-currency-dollar',
      subs: [{ label: 'Central Boletos', href: '#' }, { label: 'Consultar Extrato', href: '#' }, { label: 'Comprovante Imposto de Renda', href: '#' }] },
    { label: 'Protocolos',  icon: 'bi-graph-up-arrow', href: '#' },
    { label: 'Avalie-nos', icon: 'bi-pencil-square',
      subs: [{ label: 'Avaliação Faculdade', href: '#' }] },
    { label: 'Materiais',  icon: 'bi-book-half',
      subs: [{ label: 'Repositório Aluno', href: '#' }] },
    { label: 'Avisos',     icon: 'bi-envelope', href: '#' },
    { label: 'Biblioteca', icon: 'bi-bookshelf', href: '#'},
    { label: 'Eventos',    icon: 'bi-calendar-event', href: '#' },
    { label: 'Moodle',     icon: 'bi-easel2', href: '#'},
    { label: 'Carreiras',  icon: 'bi-rocket-takeoff', href: '#' },
    { label: 'Suporte',    icon: 'bi-headset', accent: true,
      subs: [{ label: 'Chamados', href: '#' }, { label: 'Fila de atendimento (secretaria)', href: '#' }] },
  ];

  connectedCallback(){
    this.classList.add('navbar-top', 'bg-body-tertiary', 'border',
      'd-flex', 'align-items-center', 'flex-shrink-0');

    const items = NavBar.ITEMS.map((item, i) => {
      const menuId = `nav-drop-${i}`;
      const hasSubs = Array.isArray(item.subs) && item.subs.length > 0;

      // sem "subs" -> link direto, sem seta e sem popup
      if (!hasSubs){
        return `
          <li class="nav-item">
            <a href="${item.href || '#'}" class="navbar-top__link${item.active ? ' is-active' : ''}${item.accent ? ' navbar-top__link--accent' : ''}" title="${item.label}">
              <i class="bi ${item.icon}"></i>
              <span class="navbar-top__link-label">${item.label}</span>
            </a>
          </li>
        `;
      }

      // com "subs" -> dropdown com seta e popup
      const subs = item.subs.map(sub => `
        <li><a class="dropdown-item" href="${sub.href}">${sub.label}</a></li>
      `).join('');

      return `
        <li class="nav-item dropdown">
          <a href="#" id="${menuId}" class="navbar-top__link dropdown-toggle${item.active ? ' is-active' : ''}${item.accent ? ' navbar-top__link--accent' : ''}"
             role="button" data-bs-toggle="dropdown" aria-expanded="false" title="${item.label}">
            <i class="bi ${item.icon}"></i>
            <span class="navbar-top__link-label">${item.label}</span>
            <i class="bi bi-chevron-right navbar-top__chevron"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="${menuId}">
            ${subs}
          </ul>
        </li>
      `;
    }).join('');

    this.innerHTML = `
      <div class="navbar-top__slot navbar-top__slot--logo rounded-pill" title="logo">
        <span class="navbar-top__slot-label">logo</span>
      </div>

      <ul class="navbar-top__nav nav flex-row flex-nowrap">
        ${items}
      </ul>

      <div class="navbar-top__actions">

        <theme-toggle></theme-toggle>
        <div class="navbar-top__slot navbar-top__slot--profile rounded-circle" title="perfil / avatar">
          <span class="navbar-top__slot-label">perfil</span>
        </div>
      </div>
    `;

    // inicializa cada dropdown na mão, com strategy:'fixed' — assim o popup
    // escapa do overflow (scroll horizontal) da lista de navegação e não fica cortado/invisível.
    if (typeof bootstrap !== 'undefined'){
      // estado compartilhado entre todos os itens: só um popup ativo por vez.
      // ao trocar de item direto (hover em B antes do timer de A terminar),
      // o anterior fecha na hora — o delay só vale pra quando sai pra fora de tudo.
      let activeInstance = null;
      let closeTimer = null;

      this.querySelectorAll('.nav-item.dropdown').forEach(li => {
        const toggleEl = li.querySelector('.dropdown-toggle');
        const menuEl = li.querySelector('.dropdown-menu');
        const instance = bootstrap.Dropdown.getOrCreateInstance(toggleEl, { popperConfig: { strategy: 'fixed' } });

        // só revela o popup depois de 2 frames de renderização — garante que o
        // Popper já terminou de posicionar antes de qualquer coisa ficar visível,
        // eliminando o "pisca no canto superior esquerdo antes de pular pro lugar".
        toggleEl.addEventListener('show.bs.dropdown', () => {
          menuEl.classList.remove('is-positioned');
          requestAnimationFrame(() => {
            requestAnimationFrame(() => {
              menuEl.classList.add('is-positioned');
            });
          });
        });
        toggleEl.addEventListener('hide.bs.dropdown', () => {
          menuEl.classList.remove('is-positioned');
        });

        // abre/fecha por hover (mouse), sem abandonar o clique (touch/teclado).
        li.addEventListener('mouseenter', () => {
          clearTimeout(closeTimer);

          // trocando de item: fecha o popup anterior na hora, sem esperar o
          // delay — é isso que evitava os dois ficarem visíveis ao mesmo tempo.
          if (activeInstance && activeInstance !== instance){
            activeInstance.hide();
          }

          instance.show();
          activeInstance = instance;
        });

        li.addEventListener('mouseleave', () => {
          // o delay só entra em ação aqui: saindo pra fora de tudo (não pra
          // outro item), dá tempo do mouse atravessar o vão até o popup.
          closeTimer = setTimeout(() => {
            instance.hide();
            if (activeInstance === instance) activeInstance = null;
          }, 220);
        });
      });
    } else {
      console.error('nav-bar: bootstrap.bundle.min.js não carregou — verifique a conexão com o CDN ou bloqueadores de anúncio/rede.');
    }
  }
}
customElements.define('nav-bar', NavBar);

class ThemeToggle extends HTMLElement{
  connectedCallback(){
    this.classList.add('icon-btn', 'theme-toggle');
    this.setAttribute('role', 'button');
    this.setAttribute('tabindex', '0');
    this.setAttribute('aria-label', 'Alternar tema claro/escuro');

    this.innerHTML = `
      <i class="bi bi-sun-fill icon-sun"></i>
      <i class="bi bi-moon-stars-fill icon-moon"></i>
    `;

    const toggle = () => {
      const html = document.documentElement;
      html.setAttribute('data-bs-theme', html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
    };

    this.addEventListener('click', toggle);
    this.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        toggle();
      }
    });
  }
}
customElements.define('theme-toggle', ThemeToggle);
