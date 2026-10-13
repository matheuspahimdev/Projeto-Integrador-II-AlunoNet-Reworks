<?php
require_once '../../components/layout.php';
renderHead('Meus Empréstimos', 'dark', '../../', false);

$fuso = new DateTimeZone('America/Sao_Paulo');
$hoje = new DateTimeImmutable('today', $fuso);
$emDias = static fn (int $dias): string => $hoje->modify(sprintf('%+d days', $dias))->format('Y-m-d');

$emprestimos = [
    [
        'id' => 'EMP-2026-0412', 'bookId' => 2, 'titulo' => 'Clean Code', 'autor' => 'Robert C. Martin', 'categoria' => 'computacao',
        'retirada' => $emDias(-3), 'horario' => '14:00', 'devolucao' => $emDias(4), 'solicitadoEm' => $emDias(-5),
        'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => null,
    ],
    [
        'id' => 'EMP-2026-0398', 'bookId' => 3, 'titulo' => 'Introdução a Sistemas de Banco de Dados', 'autor' => 'C. J. Date', 'categoria' => 'computacao',
        'retirada' => $emDias(-12), 'horario' => '10:00', 'devolucao' => $emDias(-5), 'solicitadoEm' => $emDias(-14),
        'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => null,
    ],
    [
        'id' => 'EMP-2026-0431', 'bookId' => 5, 'titulo' => 'Algoritmos: Teoria e Prática', 'autor' => 'Thomas H. Cormen et al.', 'categoria' => 'computacao',
        'retirada' => $emDias(2), 'horario' => '15:00', 'devolucao' => $emDias(9), 'solicitadoEm' => $emDias(0),
        'status' => 'analise', 'renovacoes' => 0, 'devolvidoEm' => null,
    ],
    [
        'id' => 'EMP-2026-0301', 'bookId' => 13, 'titulo' => 'Dom Casmurro', 'autor' => 'Machado de Assis', 'categoria' => 'literatura',
        'retirada' => $emDias(-30), 'horario' => '09:00', 'devolucao' => $emDias(-23), 'solicitadoEm' => $emDias(-32),
        'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => $emDias(-24),
    ],
    [
        'id' => 'EMP-2026-0245', 'bookId' => 15, 'titulo' => 'Metodologia do Trabalho Científico', 'autor' => 'Antônio Joaquim Severino', 'categoria' => 'metodologia',
        'retirada' => $emDias(-60), 'horario' => '16:00', 'devolucao' => $emDias(-53), 'solicitadoEm' => $emDias(-62),
        'status' => 'retirado', 'renovacoes' => 1, 'devolvidoEm' => $emDias(-55),
    ],
];

$dadosJson = json_encode($emprestimos, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Meus Empréstimos</h1>
        <p class="text-secondary mb-0">Acompanhe seus pedidos, prazos de devolução e pendências.</p>
      </div>
      <a class="btn btn-accent" href="consultaAcervo.php"><i class="bi bi-search me-2"></i>Consultar acervo</a>
    </section>

    <div class="alert alert-danger d-flex align-items-start gap-2" id="overdueAlert" role="alert" hidden>
      <i class="bi bi-exclamation-triangle-fill mt-1" aria-hidden="true"></i>
      <span id="overdueText"></span>
    </div>

    <div class="loan-summary" aria-label="Resumo dos empréstimos">
      <div class="loan-stat"><strong id="statComVoce">0</strong><span>Com você</span></div>
      <div class="loan-stat loan-stat--danger"><strong id="statVencido">0</strong><span>Devolução vencida</span></div>
      <div class="loan-stat"><strong id="statAnalise">0</strong><span>Em análise</span></div>
      <div class="loan-stat"><strong id="statDevolvido">0</strong><span>Devolvidos</span></div>
    </div>

    <div class="notice-filters mb-3" role="group" aria-label="Filtrar empréstimos">
      <button class="notice-filter active" type="button" data-filter="all">Todos</button>
      <button class="notice-filter" type="button" data-filter="com-voce">Com você</button>
      <button class="notice-filter" type="button" data-filter="vencido">Vencidos</button>
      <button class="notice-filter" type="button" data-filter="analise">Em análise</button>
      <button class="notice-filter" type="button" data-filter="devolvido">Devolvidos</button>
    </div>

    <div class="loan-list" id="loanList" aria-live="polite"></div>

    <div class="notice-empty" id="loanEmpty" hidden>
      <i class="bi bi-bookmarks"></i>
      <p class="mb-0" id="loanEmptyText"></p>
    </div>

  </main>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="cancelModalLabel">Cancelar pedido?</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">O pedido de <strong id="cancelTitle"></strong> será cancelado e o livro voltará a ficar disponível para outros alunos.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Manter pedido</button>
        <button type="button" class="btn btn-danger" id="cancelConfirm">Cancelar pedido</button>
      </div>
    </div>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="loanToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="loanToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script id="loanData" type="application/json"><?= $dadosJson ?></script>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'alunonet.emprestimos';
  const RENEW_DAYS = 7;
  const ICONS = { computacao: 'bi-laptop', direito: 'bi-bank', matematica: 'bi-calculator', literatura: 'bi-book', metodologia: 'bi-journal-text' };
  const STATES = {
    vencido: { label: 'Devolução vencida', badge: 'text-bg-danger', order: 0 },
    'com-voce': { label: 'Com você', badge: 'text-bg-success', order: 1 },
    analise: { label: 'Em análise', badge: 'text-bg-warning', order: 2 },
    devolvido: { label: 'Devolvido', badge: 'text-bg-secondary', order: 3 },
  };

  const $ = (id) => document.getElementById(id);
  const list = $('loanList');
  const filterButtons = [...document.querySelectorAll('.notice-filter')];
  const toastEl = $('loanToast');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 4000 });
  const cancelModal = bootstrap.Modal.getOrCreateInstance($('cancelModal'));

  const parse = (iso) => new Date(`${iso}T00:00:00`);
  const toISO = (date) => date.toLocaleDateString('sv-SE');
  const fmt = (iso) => parse(iso).toLocaleDateString('pt-BR');
  const addDays = (iso, days) => { const date = parse(iso); date.setDate(date.getDate() + days); return toISO(date); };
  const today = () => { const date = new Date(); date.setHours(0, 0, 0, 0); return date; };
  const daysBetween = (from, to) => Math.round((to - from) / 86400000);
  const plural = (n, one, many) => `${n} ${n === 1 ? one : many}`;

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

  const loadRequests = () => {
    try {
      const value = JSON.parse(localStorage.getItem(STORAGE_KEY));
      return Array.isArray(value) ? value : [];
    } catch (error) { return []; }
  };
  const saveRequests = (requests) => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(requests)); } catch (error) { /* ignora */ }
  };

  let loans = [
    ...JSON.parse($('loanData').textContent).map((loan) => ({ ...loan, stored: false })),
    ...loadRequests().map((request) => ({ ...request, stored: true })),
  ];
  let filter = 'all';
  let pendingCancel = null;

  const stateOf = (loan) => {
    if (loan.devolvidoEm) return 'devolvido';
    if (loan.status === 'analise') return 'analise';
    return parse(loan.devolucao) < today() ? 'vencido' : 'com-voce';
  };

  const showToast = (message) => {
    $('loanToastBody').textContent = message;
    toast.show();
  };

  const sortKey = {
    vencido: (a, b) => a.devolucao.localeCompare(b.devolucao),
    'com-voce': (a, b) => a.devolucao.localeCompare(b.devolucao),
    analise: (a, b) => a.retirada.localeCompare(b.retirada),
    devolvido: (a, b) => b.devolvidoEm.localeCompare(a.devolvidoEm),
  };

  const field = (label, value) => {
    const span = el('span');
    span.append(el('b', '', `${label}: `), document.createTextNode(value));
    return span;
  };

  const noteFor = (loan, state) => {
    if (state === 'vencido') {
      const late = daysBetween(parse(loan.devolucao), today());
      return [`Atrasado há ${plural(late, 'dia', 'dias')}. Devolva à biblioteca o quanto antes para evitar multa.`, 'loan-card__note loan-card__note--danger'];
    }
    if (state === 'com-voce') {
      const left = daysBetween(today(), parse(loan.devolucao));
      const text = left === 0 ? 'A devolução é hoje.' : left === 1 ? 'Falta 1 dia para a devolução.' : `Faltam ${left} dias para a devolução.`;
      return [text, left <= 2 ? 'loan-card__note loan-card__note--danger' : 'loan-card__note'];
    }
    if (state === 'analise') return ['Pedido em análise pela biblioteca. Você será avisado quando for confirmado.', 'loan-card__note'];
    return [`Devolvido em ${fmt(loan.devolvidoEm)}.`, 'loan-card__note'];
  };

  const renewLoan = (loan) => {
    loan.devolucao = addDays(loan.devolucao, RENEW_DAYS);
    loan.renovacoes += 1;
    render();
    showToast(`Empréstimo renovado. Nova devolução: ${fmt(loan.devolucao)} (simulação).`);
  };

  const askCancel = (loan) => {
    pendingCancel = loan;
    $('cancelTitle').textContent = loan.titulo;
    cancelModal.show();
  };

  const renderCard = (loan) => {
    const state = stateOf(loan);
    const card = el('article', `loan-card loan-card--${state}`);

    const cover = el('div', `book-cover book-cover--mini book-cover--${loan.categoria}`);
    cover.setAttribute('aria-hidden', 'true');
    cover.append(icon(`bi ${ICONS[loan.categoria] || 'bi-book'}`));

    const info = el('div', 'loan-card__info');
    const head = el('div', 'd-flex flex-wrap align-items-center gap-2');
    head.append(el('h2', 'loan-card__title', loan.titulo), el('span', `badge rounded-pill ${STATES[state].badge}`, STATES[state].label));

    const dates = el('div', 'loan-card__dates');
    dates.append(field(state === 'analise' ? 'Retirada agendada' : 'Retirada', `${fmt(loan.retirada)}${state === 'analise' ? ` às ${loan.horario}` : ''}`));
    dates.append(field('Devolução prevista', fmt(loan.devolucao)));
    if (loan.renovacoes) dates.append(field('Renovações', String(loan.renovacoes)));

    const [noteText, noteClass] = noteFor(loan, state);
    info.append(head, el('p', 'loan-card__author', loan.autor), dates, el('p', noteClass, noteText));

    const side = el('div', 'loan-card__side');
    if (state === 'com-voce') {
      const renewed = loan.renovacoes >= 1;
      const renew = el('button', 'btn btn-sm btn-outline-primary', renewed ? 'Já renovado' : `Renovar por ${RENEW_DAYS} dias`);
      renew.type = 'button';
      renew.disabled = renewed;
      renew.addEventListener('click', () => renewLoan(loan));
      side.append(renew);
    } else if (state === 'vencido') {
      side.append(el('span', 'text-secondary small', 'Renovação indisponível'));
    } else if (state === 'analise') {
      const cancel = el('button', 'btn btn-sm btn-outline-danger', 'Cancelar pedido');
      cancel.type = 'button';
      cancel.addEventListener('click', () => askCancel(loan));
      side.append(cancel);
    } else {
      const again = el('a', 'btn btn-sm btn-outline-secondary', 'Pedir novamente');
      again.href = 'consultaAcervo.php';
      side.append(again);
    }

    card.append(cover, info, side);
    return card;
  };

  const render = () => {
    const counts = { vencido: 0, 'com-voce': 0, analise: 0, devolvido: 0 };
    loans.forEach((loan) => { counts[stateOf(loan)] += 1; });
    $('statComVoce').textContent = counts['com-voce'];
    $('statVencido').textContent = counts.vencido;
    $('statAnalise').textContent = counts.analise;
    $('statDevolvido').textContent = counts.devolvido;

    $('overdueAlert').hidden = counts.vencido === 0;
    $('overdueText').textContent = `Você possui ${plural(counts.vencido, 'livro com devolução vencida', 'livros com devolução vencida')}. Devolva à biblioteca o quanto antes para evitar multa.`;

    filterButtons.forEach((button) => {
      const active = button.dataset.filter === filter;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });

    const visible = loans
      .filter((loan) => filter === 'all' || stateOf(loan) === filter)
      .sort((a, b) => {
        const sa = stateOf(a);
        const sb = stateOf(b);
        return STATES[sa].order - STATES[sb].order || (sa === sb ? sortKey[sa](a, b) : 0);
      });

    list.replaceChildren(...visible.map(renderCard));
    $('loanEmpty').hidden = visible.length > 0;
    $('loanEmptyText').textContent = filter === 'all' ? 'Você ainda não tem empréstimos. Consulte o acervo e agende o seu primeiro.' : 'Nenhum empréstimo nesta situação.';
  };

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => { filter = button.dataset.filter; render(); });
  });

  $('cancelConfirm').addEventListener('click', () => {
    if (!pendingCancel) return;
    const target = pendingCancel;
    loans = loans.filter((loan) => loan !== target);
    if (target.stored) saveRequests(loadRequests().filter((request) => request.id !== target.id));
    pendingCancel = null;
    cancelModal.hide();
    render();
    showToast(`Pedido de “${target.titulo}” cancelado.`);
  });

  render();
});
</script>

</body>
</html>
