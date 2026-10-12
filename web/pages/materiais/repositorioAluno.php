<?php
require_once '../../components/layout.php';
renderHead('Repositório do Aluno', 'dark', '../../', false);

$pasta = static fn (int $id, ?int $parent, string $name, string $modified, string $owner): array => [
    'id' => $id, 'parent' => $parent, 'type' => 'folder', 'name' => $name, 'ext' => '',
    'size' => 0, 'modified' => $modified, 'owner' => $owner, 'starred' => false,
];

$arquivo = static fn (int $id, ?int $parent, string $name, int $kb, string $modified, string $owner, bool $starred = false): array => [
    'id' => $id, 'parent' => $parent, 'type' => 'file', 'name' => $name,
    'ext' => strtolower(pathinfo($name, PATHINFO_EXTENSION)), 'size' => $kb * 1024,
    'modified' => $modified, 'owner' => $owner, 'starred' => $starred,
];

$p1 = 'Prof. Nome do Professor 1';
$p2 = 'Prof. Nome do Professor 2';
$p3 = 'Prof. Nome do Professor 3';
$p4 = 'Prof. Nome do Professor 4';
$eu = 'Você';

$itens = [
    // Pastas principais (uma por disciplina) e pasta pessoal
    $pasta(1, null, 'Projeto Integrador II', '2026-10-08', $p1),
    $pasta(2, null, 'Direito Aplicado', '2026-10-05', $p2),
    $pasta(3, null, 'Banco de Dados', '2026-10-09', $p3),
    $pasta(4, null, 'Programação Web', '2026-09-28', $p4),
    $pasta(5, null, 'Documentos Pessoais', '2026-10-02', $eu),

    // Subpastas
    $pasta(6, 1, 'Aulas', '2026-10-08', $p1),
    $pasta(7, 1, 'Entregas', '2026-10-06', $eu),
    $pasta(8, 3, 'Slides', '2026-10-09', $p3),
    $pasta(9, 3, 'Listas de Exercícios', '2026-10-01', $p3),

    // Projeto Integrador II
    $arquivo(10, 1, 'Plano de Ensino.pdf', 320, '2026-08-03', $p1, true),
    $arquivo(11, 1, 'Cronograma do Projeto.xlsx', 86, '2026-09-14', $p1),
    $arquivo(12, 1, 'Modelo de Relatório.docx', 54, '2026-09-20', $p1),
    $arquivo(13, 6, 'Aula 01 - Introdução.pdf', 1228, '2026-08-10', $p1),
    $arquivo(14, 6, 'Aula 02 - Levantamento de Requisitos.pptx', 3482, '2026-09-22', $p1),
    $arquivo(15, 6, 'Gravação Aula 03.mp4', 151552, '2026-10-08', $p1),
    $arquivo(16, 7, 'Entrega 1 - Documento de Visão.pdf', 540, '2026-09-30', $eu),
    $arquivo(17, 7, 'Diagrama de Casos de Uso.png', 210, '2026-10-06', $eu),

    // Direito Aplicado
    $arquivo(18, 2, 'Código de Defesa do Consumidor.pdf', 1843, '2026-08-12', $p2),
    $arquivo(19, 2, 'Resumo Contratos.docx', 72, '2026-10-05', $p2),

    // Banco de Dados
    $arquivo(20, 3, 'Modelo Entidade-Relacionamento.png', 480, '2026-09-18', $p3),
    $arquivo(21, 3, 'Script Banco Escola.sql', 12, '2026-10-09', $p3, true),
    $arquivo(22, 8, 'Aula 01 - Modelagem.pptx', 2970, '2026-08-17', $p3),
    $arquivo(23, 8, 'Aula 02 - SQL Básico.pptx', 3174, '2026-09-07', $p3),
    $arquivo(24, 9, 'Lista 01.pdf', 190, '2026-09-10', $p3),
    $arquivo(25, 9, 'Lista 02.pdf', 205, '2026-10-01', $p3),
    $arquivo(26, 9, 'Gabarito Lista 01.pdf', 160, '2026-09-17', $p3),

    // Programação Web
    $arquivo(27, 4, 'Material Bootstrap.zip', 5734, '2026-09-28', $p4),
    $arquivo(28, 4, 'Referências de JavaScript.pdf', 940, '2026-09-15', $p4),

    // Documentos pessoais
    $arquivo(29, 5, 'Declaração de Matrícula.pdf', 120, '2026-10-02', $eu, true),
    $arquivo(30, 5, 'Histórico Escolar.pdf', 180, '2026-09-12', $eu),
    $arquivo(31, 5, 'Foto 3x4.jpg', 95, '2026-08-01', $eu),
];

$dadosJson = json_encode($itens, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Repositório do Aluno</h1>
        <p class="text-secondary mb-0">Materiais de aula, entregas e documentos organizados por disciplina.</p>
      </div>
    </section>

    <div class="repo-layout">
      <aside class="grid-card repo-side" aria-label="Menu do repositório">
        <div class="dropdown">
          <button class="btn btn-accent w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-plus-lg me-2"></i>Novo
          </button>
          <ul class="dropdown-menu w-100">
            <li><button class="dropdown-item" type="button" id="newFolderBtn"><i class="bi bi-folder-plus me-2"></i>Nova pasta</button></li>
            <li><button class="dropdown-item" type="button" id="uploadBtn"><i class="bi bi-upload me-2"></i>Upload de arquivos</button></li>
          </ul>
        </div>

        <nav class="repo-nav" aria-label="Seções">
          <button class="repo-nav__item active" type="button" data-view="mine"><i class="bi bi-hdd"></i>Meu repositório</button>
          <button class="repo-nav__item" type="button" data-view="recent"><i class="bi bi-clock-history"></i>Recentes</button>
          <button class="repo-nav__item" type="button" data-view="starred"><i class="bi bi-star"></i>Favoritos</button>
        </nav>

        <div class="repo-storage">
          <div class="progress" role="progressbar" aria-label="Armazenamento usado" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar" id="storageBar" style="width: 1%"></div>
          </div>
          <small id="storageText"></small>
        </div>
      </aside>

      <section class="grid-card repo-main" id="repoMain" aria-label="Arquivos e pastas">
        <div class="repo-toolbar">
          <div class="input-group repo-search">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input class="form-control" type="search" id="repoSearch" placeholder="Pesquisar no repositório" aria-label="Pesquisar no repositório">
          </div>
          <select class="form-select repo-sort" id="repoSort" aria-label="Ordenar por">
            <option value="name">Nome</option>
            <option value="modified">Modificado</option>
            <option value="size">Tamanho</option>
          </select>
          <div class="btn-group" role="group" aria-label="Modo de exibição">
            <input class="btn-check" type="radio" name="viewMode" id="viewGrid" value="grid" checked>
            <label class="btn btn-outline-secondary" for="viewGrid"><i class="bi bi-grid"></i><span class="visually-hidden">Grade</span></label>
            <input class="btn-check" type="radio" name="viewMode" id="viewList" value="list">
            <label class="btn btn-outline-secondary" for="viewList"><i class="bi bi-list-ul"></i><span class="visually-hidden">Lista</span></label>
          </div>
        </div>

        <nav aria-label="Caminho da pasta"><ol class="breadcrumb repo-crumbs" id="repoCrumbs"></ol></nav>

        <div id="repoContent" aria-live="polite"></div>
      </section>
    </div>

  </main>
</div>

<input type="file" id="uploadInput" multiple hidden>

<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewName" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold text-break" id="previewName"></h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="repo-preview" id="previewIcon" aria-hidden="true"></div>
        <dl class="data-grid mb-3">
          <div><dt>Tipo</dt><dd id="previewType"></dd></div>
          <div><dt>Tamanho</dt><dd id="previewSize"></dd></div>
          <div><dt>Modificado em</dt><dd id="previewDate"></dd></div>
          <div><dt>Proprietário</dt><dd id="previewOwner"></dd></div>
          <div><dt>Local</dt><dd id="previewPath"></dd></div>
        </dl>
        <div class="notice-box"><i class="bi bi-info-circle"></i><span>A visualização do conteúdo do arquivo estará disponível com o backend integrado.</span></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="previewStar"></button>
        <button type="button" class="btn btn-primary" id="previewDownload"><i class="bi bi-download me-1"></i>Baixar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <form class="modal-content academic-form" id="folderForm" novalidate>
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="folderModalLabel">Nova pasta</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <label class="form-label" for="folderName">Nome da pasta</label>
        <input class="form-control" type="text" id="folderName" maxlength="80" autocomplete="off">
        <div class="invalid-feedback" id="folderNameFeedback"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Criar</button>
      </div>
    </form>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="repoToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="repoToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script id="repoData" type="application/json"><?= $dadosJson ?></script>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const items = JSON.parse(document.getElementById('repoData').textContent);
  const LIMIT = 5 * 1024 ** 3;
  const state = { view: 'mine', folderId: null, query: '', sort: 'name', mode: 'grid' };
  let nextId = Math.max(...items.map((item) => item.id)) + 1;
  let previewId = null;

  const $ = (id) => document.getElementById(id);
  const content = $('repoContent');
  const crumbs = $('repoCrumbs');
  const main = $('repoMain');
  const searchInput = $('repoSearch');
  const uploadInput = $('uploadInput');
  const folderInput = $('folderName');
  const toastEl = $('repoToast');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3500 });
  const previewModal = bootstrap.Modal.getOrCreateInstance($('previewModal'));
  const folderModal = bootstrap.Modal.getOrCreateInstance($('folderModal'));

  const el = (tag, className = '', text = '') => {
    const node = document.createElement(tag);
    if (className) node.className = className;
    if (text) node.textContent = text;
    return node;
  };
  const icon = (className) => {
    const node = el('i', className);
    node.setAttribute('aria-hidden', 'true');
    return node;
  };
  const button = (className, label = '') => {
    const node = el('button', className);
    node.type = 'button';
    if (label) node.setAttribute('aria-label', label);
    return node;
  };

  const TYPES = {};
  [
    ['pdf', ['pdf'], 'bi-file-earmark-pdf', 'PDF'],
    ['doc', ['doc', 'docx'], 'bi-file-earmark-word', 'Documento Word'],
    ['ppt', ['ppt', 'pptx'], 'bi-file-earmark-slides', 'Apresentação'],
    ['xls', ['xls', 'xlsx', 'csv'], 'bi-file-earmark-excel', 'Planilha'],
    ['zip', ['zip', 'rar', '7z'], 'bi-file-earmark-zip', 'Arquivo compactado'],
    ['img', ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg'], 'bi-file-earmark-image', 'Imagem'],
    ['video', ['mp4', 'mov', 'webm', 'mkv'], 'bi-file-earmark-play', 'Vídeo'],
    ['code', ['sql', 'js', 'php', 'html', 'css', 'json', 'java', 'ts'], 'bi-file-earmark-code', 'Código-fonte'],
    ['other', ['txt', 'md'], 'bi-file-earmark-text', 'Texto'],
  ].forEach(([kind, extensions, iconClass, label]) => {
    extensions.forEach((ext) => { TYPES[ext] = [iconClass, kind, label]; });
  });

  const typeOf = (item) => (item.type === 'folder'
    ? ['bi-folder-fill', 'folder', 'Pasta']
    : (TYPES[item.ext] || ['bi-file-earmark', 'other', item.ext ? item.ext.toUpperCase() : 'Arquivo']));
  const fileIcon = (item, extra = '') => {
    const [iconClass, kind] = typeOf(item);
    return icon(`bi ${iconClass} file-icon--${kind} ${extra}`.trim());
  };

  const fmtSize = (bytes) => {
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 ** 2) return `${Math.round(bytes / 1024)} KB`;
    if (bytes < 1024 ** 3) return `${(bytes / 1024 ** 2).toFixed(1).replace('.', ',')} MB`;
    return `${(bytes / 1024 ** 3).toFixed(2).replace('.', ',')} GB`;
  };
  const fmtDate = (iso) => new Date(`${iso}T00:00:00`).toLocaleDateString('pt-BR');
  const today = () => new Date().toLocaleDateString('sv-SE');

  const byId = (id) => items.find((item) => item.id === id);
  const pathOf = (id) => {
    const path = [];
    let current = byId(id);
    while (current) {
      path.unshift(current);
      current = current.parent === null ? null : byId(current.parent);
    }
    return path;
  };
  const locationOf = (item) => (item.parent === null ? 'Meu repositório' : pathOf(item.parent).map((folder) => folder.name).join(' / '));

  const compare = {
    name: (a, b) => a.name.localeCompare(b.name, 'pt-BR', { numeric: true }),
    modified: (a, b) => b.modified.localeCompare(a.modified) || compare.name(a, b),
    size: (a, b) => b.size - a.size || compare.name(a, b),
  };

  const visibleItems = () => {
    const query = state.query.trim().toLowerCase();
    let list;
    if (query) list = items.filter((item) => item.name.toLowerCase().includes(query));
    else if (state.view === 'recent') list = items.filter((item) => item.type === 'file').sort(compare.modified).slice(0, 12);
    else if (state.view === 'starred') list = items.filter((item) => item.starred);
    else list = items.filter((item) => item.parent === state.folderId);
    const order = state.view === 'recent' && !query ? compare.modified : compare[state.sort];
    return [...list].sort(order);
  };

  const showToast = (message, ok = true) => {
    toastEl.classList.toggle('text-bg-success', ok);
    toastEl.classList.toggle('text-bg-danger', !ok);
    $('repoToastBody').textContent = message;
    toast.show();
  };

  const download = (item) => {
    if (item.blob) {
      const url = URL.createObjectURL(item.blob);
      const link = el('a');
      link.href = url;
      link.download = item.name;
      link.click();
      URL.revokeObjectURL(url);
      showToast(`Download de “${item.name}” iniciado.`);
    } else {
      showToast(`Download de “${item.name}” simulado. Disponível com o backend integrado.`);
    }
  };

  const openFolder = (id) => {
    state.view = 'mine';
    state.folderId = id;
    state.query = '';
    searchInput.value = '';
    render();
  };
  const setView = (view) => {
    state.view = view;
    state.query = '';
    searchInput.value = '';
    render();
  };

  const syncPreview = (item) => {
    $('previewIcon').replaceChildren(fileIcon(item));
    $('previewName').textContent = item.name;
    $('previewType').textContent = typeOf(item)[2];
    $('previewSize').textContent = fmtSize(item.size);
    $('previewDate').textContent = fmtDate(item.modified);
    $('previewOwner').textContent = item.owner;
    $('previewPath').textContent = locationOf(item);
    $('previewStar').replaceChildren(icon(item.starred ? 'bi bi-star-fill' : 'bi bi-star'), document.createTextNode(item.starred ? ' Remover dos favoritos' : ' Favoritar'));
  };
  const openPreview = (item) => {
    previewId = item.id;
    syncPreview(item);
    previewModal.show();
  };

  const toggleStar = (item) => {
    item.starred = !item.starred;
    render();
    if (previewId === item.id) syncPreview(item);
  };

  const actions = (item) => {
    const wrap = el('div', 'd-flex align-items-center justify-content-end');
    const star = button(`repo-icon-btn${item.starred ? ' is-starred' : ''}`, item.starred ? `Remover ${item.name} dos favoritos` : `Adicionar ${item.name} aos favoritos`);
    star.append(icon(item.starred ? 'bi bi-star-fill' : 'bi bi-star'));
    star.addEventListener('click', () => toggleStar(item));
    const down = button('repo-icon-btn', `Baixar ${item.name}`);
    down.append(icon('bi bi-download'));
    down.addEventListener('click', () => download(item));
    wrap.append(star, down);
    return wrap;
  };

  const renderGrid = (list) => {
    const fragment = document.createDocumentFragment();
    const folders = list.filter((item) => item.type === 'folder');
    const files = list.filter((item) => item.type === 'file');

    if (folders.length) {
      fragment.append(el('h3', 'repo-section-title', 'Pastas'));
      const grid = el('div', 'repo-folders');
      folders.forEach((folder) => {
        const card = el('div', 'repo-folder');
        const open = button('repo-folder__open');
        open.append(fileIcon(folder, 'fs-4'), el('span', '', folder.name));
        open.title = folder.name;
        open.addEventListener('click', () => openFolder(folder.id));
        card.append(open);
        grid.append(card);
      });
      fragment.append(grid);
    }

    if (files.length) {
      fragment.append(el('h3', 'repo-section-title', 'Arquivos'));
      const grid = el('div', 'repo-files');
      files.forEach((file) => {
        const card = el('article', 'repo-file');
        const thumb = button('repo-file__thumb', `Visualizar ${file.name}`);
        thumb.append(fileIcon(file));
        thumb.addEventListener('click', () => openPreview(file));
        const info = el('div', 'repo-file__info');
        const name = el('span', 'repo-file__name', file.name);
        name.title = file.name;
        info.append(name, el('span', 'repo-file__meta', `${fmtSize(file.size)} • ${fmtDate(file.modified)}`));
        const foot = el('div', 'repo-file__foot');
        foot.append(fileIcon(file, 'fs-5'), info, actions(file));
        card.append(thumb, foot);
        grid.append(card);
      });
      fragment.append(grid);
    }
    return fragment;
  };

  const renderList = (list, showPath) => {
    const wrap = el('div', 'table-responsive');
    const table = el('table', 'table table-hover align-middle academic-table repo-table');
    const head = el('tr');
    ['Nome', 'Proprietário', 'Modificado', 'Tamanho', ''].forEach((title) => {
      const th = el('th');
      th.scope = 'col';
      if (title) th.textContent = title;
      else th.append(el('span', 'visually-hidden', 'Ações'));
      head.append(th);
    });
    const thead = el('thead');
    thead.append(head);

    const body = el('tbody');
    list.forEach((item) => {
      const row = el('tr');
      const nameCell = el('td');
      const open = button('repo-name-btn');
      open.append(fileIcon(item, 'fs-5'), el('span', '', item.name));
      open.addEventListener('click', () => (item.type === 'folder' ? openFolder(item.id) : openPreview(item)));
      nameCell.append(open);
      if (showPath) nameCell.append(el('span', 'repo-path', locationOf(item)));
      row.append(nameCell, el('td', '', item.owner), el('td', '', fmtDate(item.modified)), el('td', '', item.type === 'folder' ? '—' : fmtSize(item.size)));
      const actionCell = el('td', 'text-end');
      if (item.type === 'file') actionCell.append(actions(item));
      row.append(actionCell);
      body.append(row);
    });

    table.append(thead, body);
    wrap.append(table);
    return wrap;
  };

  const emptyState = (query) => {
    let iconClass = 'bi-folder2-open';
    let message = 'Esta pasta está vazia. Arraste arquivos até aqui ou use Novo > Upload de arquivos.';
    if (query) { iconClass = 'bi-search'; message = `Nenhum resultado para “${query}”.`; }
    else if (state.view === 'starred') { iconClass = 'bi-star'; message = 'Nenhum favorito ainda. Marque a estrela de um arquivo para encontrá-lo aqui.'; }
    else if (state.view === 'recent') { iconClass = 'bi-clock-history'; message = 'Nenhum arquivo recente.'; }
    const box = el('div', 'repo-empty');
    box.append(icon(`bi ${iconClass}`), el('p', 'mb-0', message));
    return box;
  };

  const crumb = (label, handler) => {
    const li = el('li', `breadcrumb-item${handler ? '' : ' active'}`);
    if (handler) {
      const link = button('repo-crumb');
      link.textContent = label;
      link.addEventListener('click', handler);
      li.append(link);
    } else {
      li.textContent = label;
      li.setAttribute('aria-current', 'page');
    }
    crumbs.append(li);
  };

  const render = () => {
    const query = state.query.trim();

    document.querySelectorAll('[data-view]').forEach((navButton) => {
      const active = navButton.dataset.view === state.view && !query;
      navButton.classList.toggle('active', active);
      if (active) navButton.setAttribute('aria-current', 'page');
      else navButton.removeAttribute('aria-current');
    });

    crumbs.replaceChildren();
    if (query) crumb(`Resultados para “${query}”`);
    else if (state.view === 'recent') crumb('Recentes');
    else if (state.view === 'starred') crumb('Favoritos');
    else {
      const path = state.folderId === null ? [] : pathOf(state.folderId);
      crumb('Meu repositório', path.length ? () => openFolder(null) : null);
      path.forEach((folder, index) => crumb(folder.name, index < path.length - 1 ? () => openFolder(folder.id) : null));
    }

    const list = visibleItems();
    content.replaceChildren();
    if (!list.length) content.append(emptyState(query));
    else content.append(state.mode === 'grid' ? renderGrid(list) : renderList(list, Boolean(query) || state.view !== 'mine'));

    const used = items.reduce((total, item) => total + (item.type === 'file' ? item.size : 0), 0);
    const percent = Math.max(1, Math.min(100, (used / LIMIT) * 100));
    $('storageText').textContent = `${fmtSize(used)} de 5 GB usados`;
    $('storageBar').style.width = `${percent}%`;
    $('storageBar').parentElement.setAttribute('aria-valuenow', String(Math.round(percent)));
  };

  const addFiles = (fileList) => {
    const files = [...fileList];
    if (!files.length) return;
    state.view = 'mine';
    state.query = '';
    searchInput.value = '';
    files.forEach((file) => {
      const dot = file.name.lastIndexOf('.');
      items.push({
        id: nextId++, parent: state.folderId, type: 'file', name: file.name,
        ext: dot > -1 ? file.name.slice(dot + 1).toLowerCase() : '', size: file.size,
        modified: today(), owner: 'Você', starred: false, blob: file,
      });
    });
    render();
    showToast(`${files.length} arquivo(s) adicionado(s) à pasta atual (simulação, sem envio ao servidor).`);
  };

  document.querySelectorAll('[data-view]').forEach((navButton) => {
    navButton.addEventListener('click', () => (navButton.dataset.view === 'mine' ? openFolder(null) : setView(navButton.dataset.view)));
  });
  searchInput.addEventListener('input', () => { state.query = searchInput.value; render(); });
  $('repoSort').addEventListener('change', (event) => { state.sort = event.target.value; render(); });
  document.querySelectorAll('input[name="viewMode"]').forEach((radio) => {
    radio.addEventListener('change', () => { state.mode = radio.value; render(); });
  });

  $('previewDownload').addEventListener('click', () => { const item = byId(previewId); if (item) download(item); });
  $('previewStar').addEventListener('click', () => { const item = byId(previewId); if (item) toggleStar(item); });

  $('uploadBtn').addEventListener('click', () => uploadInput.click());
  uploadInput.addEventListener('change', () => { addFiles(uploadInput.files); uploadInput.value = ''; });

  $('newFolderBtn').addEventListener('click', () => {
    folderInput.value = '';
    folderInput.classList.remove('is-invalid');
    folderModal.show();
  });
  $('folderModal').addEventListener('shown.bs.modal', () => folderInput.focus());
  $('folderForm').addEventListener('submit', (event) => {
    event.preventDefault();
    const name = folderInput.value.trim();
    const parent = state.folderId;
    let error = '';
    if (!name) error = 'Informe um nome para a pasta.';
    else if (items.some((item) => item.parent === parent && item.type === 'folder' && item.name.toLowerCase() === name.toLowerCase())) error = 'Já existe uma pasta com esse nome aqui.';
    folderInput.classList.toggle('is-invalid', Boolean(error));
    $('folderNameFeedback').textContent = error;
    if (error) return;
    items.push({ id: nextId++, parent, type: 'folder', name, ext: '', size: 0, modified: today(), owner: 'Você', starred: false });
    folderModal.hide();
    state.view = 'mine';
    state.query = '';
    searchInput.value = '';
    render();
    showToast(`Pasta “${name}” criada.`);
  });

  ['dragenter', 'dragover'].forEach((type) => {
    main.addEventListener(type, (event) => {
      if (!event.dataTransfer || ![...event.dataTransfer.types].includes('Files')) return;
      event.preventDefault();
      main.classList.add('is-dragging');
    });
  });
  main.addEventListener('dragleave', (event) => {
    if (!main.contains(event.relatedTarget)) main.classList.remove('is-dragging');
  });
  main.addEventListener('drop', (event) => {
    if (!event.dataTransfer || !event.dataTransfer.files.length) return;
    event.preventDefault();
    main.classList.remove('is-dragging');
    addFiles(event.dataTransfer.files);
  });

  render();
});
</script>

</body>
</html>
