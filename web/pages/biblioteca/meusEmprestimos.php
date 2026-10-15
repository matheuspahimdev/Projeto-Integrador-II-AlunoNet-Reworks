<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/biblioteca.php';

$loanData = jsonForScript(['loans' => studentLoans(), 'categories' => BOOK_CATEGORIES]);
renderPageStart('Meus Empréstimos');
?>

<?php renderPageHeader('Meus Empréstimos', 'Acompanhe seus pedidos, prazos de devolução e pendências.', static fn () => renderActionLink('consultaAcervo.php', 'bi-search', 'Consultar acervo', 'btn-accent')); ?>

    <div class="alert alert-danger d-flex align-items-start gap-2" id="overdueAlert" role="alert" hidden>
      <i class="bi bi-exclamation-triangle-fill mt-1" aria-hidden="true"></i>
      <span id="overdueText"></span>
    </div>

    <div class="loan-summary" aria-label="Resumo dos empréstimos">
      <div class="loan-stat"><strong id="statWithYou">0</strong><span>Com você</span></div>
      <div class="loan-stat loan-stat--danger"><strong id="statOverdue">0</strong><span>Devolução vencida</span></div>
      <div class="loan-stat"><strong id="statPending">0</strong><span>Em análise</span></div>
      <div class="loan-stat"><strong id="statReturned">0</strong><span>Devolvidos</span></div>
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

<script id="loanData" type="application/json"><?= $loanData ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = <?= jsonForScript(studentStorageKey('loans')) ?>;
  const RENEW_DAYS = <?= LOAN_DAYS ?>;
  const STATUS_PENDING = <?= jsonForScript(LOAN_STATUS_PENDING) ?>;
  const STATES = {
    vencido: { label: 'Devolução vencida', badge: 'text-bg-danger', order: 0 },
    'com-voce': { label: 'Com você', badge: 'text-bg-success', order: 1 },
    analise: { label: 'Em análise', badge: 'text-bg-warning', order: 2 },
    devolvido: { label: 'Devolvido', badge: 'text-bg-secondary', order: 3 },
  };

  const $ = (id) => document.getElementById(id);
  const data = readPageData('loanData');
  const list = $('loanList');
  const filterButtons = [...document.querySelectorAll('.notice-filter')];
  const cancelModal = bootstrap.Modal.getOrCreateInstance($('cancelModal'));

  const formatIso = (iso) => formatDateBR(parseIsoDate(iso));
  const daysBetween = (from, to) => Math.round((to - from) / 86400000);

  let loans = [
    ...data.loans.map((loan) => ({ ...loan, stored: false })),
    ...readStoredList(STORAGE_KEY).map((request) => ({ ...request, stored: true })),
  ];
  let filter = 'all';
  let pendingCancel = null;

  const stateOf = (loan) => {
    if (loan.returned_at) return 'devolvido';
    if (loan.status === STATUS_PENDING) return 'analise';
    return parseIsoDate(loan.due_date) < portalToday() ? 'vencido' : 'com-voce';
  };

  const sortWithinState = {
    vencido: (a, b) => a.due_date.localeCompare(b.due_date),
    'com-voce': (a, b) => a.due_date.localeCompare(b.due_date),
    analise: (a, b) => a.pickup_date.localeCompare(b.pickup_date),
    devolvido: (a, b) => b.returned_at.localeCompare(a.returned_at),
  };

  const field = (label, value) => {
    const span = createNode('span');
    span.append(createNode('b', '', `${label}: `), document.createTextNode(value));
    return span;
  };

  const noteFor = (loan, state) => {
    if (state === 'vencido') {
      const late = daysBetween(parseIsoDate(loan.due_date), portalToday());
      return [`Atrasado há ${pluralize(late, 'dia', 'dias')}. Devolva à biblioteca o quanto antes para evitar multa.`, 'loan-card__note loan-card__note--danger'];
    }
    if (state === 'com-voce') {
      const left = daysBetween(portalToday(), parseIsoDate(loan.due_date));
      const text = left === 0 ? 'A devolução é hoje.' : left === 1 ? 'Falta 1 dia para a devolução.' : `Faltam ${left} dias para a devolução.`;
      return [text, left <= 2 ? 'loan-card__note loan-card__note--danger' : 'loan-card__note'];
    }
    if (state === 'analise') return ['Pedido em análise pela biblioteca. Você será avisado quando for confirmado.', 'loan-card__note'];
    return [`Devolvido em ${formatIso(loan.returned_at)}.`, 'loan-card__note'];
  };

  const renewLoan = (loan) => {
    loan.due_date = toIsoDate(addDays(parseIsoDate(loan.due_date), RENEW_DAYS));
    loan.renewals += 1;
    render();
    showToast(`Empréstimo renovado. Nova devolução: ${formatIso(loan.due_date)} (simulação).`);
  };

  const askCancel = (loan) => {
    pendingCancel = loan;
    $('cancelTitle').textContent = loan.title;
    cancelModal.show();
  };

  const loanCardActions = (loan, state) => {
    const side = createNode('div', 'loan-card__side');
    if (state === 'com-voce') {
      const renewed = loan.renewals >= 1;
      const renew = createButton('btn btn-sm btn-outline-primary', renewed ? 'Já renovado' : `Renovar por ${RENEW_DAYS} dias`);
      renew.disabled = renewed;
      renew.addEventListener('click', () => renewLoan(loan));
      side.append(renew);
    } else if (state === 'vencido') {
      side.append(createNode('span', 'text-secondary small', 'Renovação indisponível'));
    } else if (state === 'analise') {
      const cancel = createButton('btn btn-sm btn-outline-danger', 'Cancelar pedido');
      cancel.addEventListener('click', () => askCancel(loan));
      side.append(cancel);
    } else {
      const again = createNode('a', 'btn btn-sm btn-outline-secondary', 'Pedir novamente');
      again.href = 'consultaAcervo.php';
      side.append(again);
    }
    return side;
  };

  const renderCard = (loan) => {
    const state = stateOf(loan);
    const card = createNode('article', `loan-card loan-card--${state}`);

    const cover = createNode('div', `book-cover book-cover--mini book-cover--${loan.category}`);
    cover.setAttribute('aria-hidden', 'true');
    cover.append(createIcon(`bi ${data.categories[loan.category]?.icon || 'bi-book'}`));

    const info = createNode('div', 'loan-card__info');
    const head = createNode('div', 'd-flex flex-wrap align-items-center gap-2');
    head.append(createNode('h2', 'loan-card__title', loan.title), createNode('span', `badge rounded-pill ${STATES[state].badge}`, STATES[state].label));

    const dates = createNode('div', 'loan-card__dates');
    dates.append(field(state === 'analise' ? 'Retirada agendada' : 'Retirada', `${formatIso(loan.pickup_date)}${state === 'analise' ? ` às ${loan.pickup_time}` : ''}`));
    dates.append(field('Devolução prevista', formatIso(loan.due_date)));
    if (loan.renewals) dates.append(field('Renovações', String(loan.renewals)));

    const [noteText, noteClass] = noteFor(loan, state);
    info.append(head, createNode('p', 'loan-card__author', loan.author), dates, createNode('p', noteClass, noteText));

    card.append(cover, info, loanCardActions(loan, state));
    return card;
  };

  const renderSummary = () => {
    const counts = { vencido: 0, 'com-voce': 0, analise: 0, devolvido: 0 };
    loans.forEach((loan) => { counts[stateOf(loan)] += 1; });
    $('statWithYou').textContent = counts['com-voce'];
    $('statOverdue').textContent = counts.vencido;
    $('statPending').textContent = counts.analise;
    $('statReturned').textContent = counts.devolvido;

    $('overdueAlert').hidden = counts.vencido === 0;
    $('overdueText').textContent = `Você possui ${pluralize(counts.vencido, 'livro com devolução vencida', 'livros com devolução vencida')}. Devolva à biblioteca o quanto antes para evitar multa.`;
  };

  const render = () => {
    renderSummary();

    filterButtons.forEach((button) => {
      const active = button.dataset.filter === filter;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });

    const visible = loans
      .filter((loan) => filter === 'all' || stateOf(loan) === filter)
      .sort((a, b) => {
        const stateA = stateOf(a);
        const stateB = stateOf(b);
        return STATES[stateA].order - STATES[stateB].order || (stateA === stateB ? sortWithinState[stateA](a, b) : 0);
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
    if (target.stored) storeJson(STORAGE_KEY, readStoredList(STORAGE_KEY).filter((request) => request.id !== target.id));
    pendingCancel = null;
    cancelModal.hide();
    render();
    showToast(`Pedido de “${target.title}” cancelado.`);
  });

  render();
});
</script>
<?php renderPageEnd(); ?>
