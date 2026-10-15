<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/biblioteca.php';

renderPageStart('Consulta ao Acervo');
?>

<?php renderPageHeader('Consulta ao Acervo', 'Pesquise os livros da biblioteca local e agende o empréstimo.', static fn () => renderActionLink('meusEmprestimos.php', 'bi-bookmarks', 'Meus empréstimos')); ?>

    <div class="info-banner" role="note">
      <div class="info-banner__icon"><i class="bi bi-info-circle"></i></div>
      <div>
        <strong>Como funciona</strong>
        <span>Escolha um livro disponível e agende a retirada. A biblioteca atende de segunda a sexta, das 08h às 21h, e o prazo de empréstimo é de <?= LOAN_DAYS ?> dias.</span>
      </div>
    </div>

    <div class="library-toolbar">
      <div class="input-group library-search">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input class="form-control" type="search" id="bookSearch" placeholder="Buscar por título, autor ou editora" aria-label="Buscar livros">
      </div>
      <select class="form-select" id="bookCategory" aria-label="Filtrar por área">
        <option value="">Todas as áreas</option>
        <?php foreach (BOOK_CATEGORIES as $slug => $category): ?>
          <option value="<?= e($slug) ?>"><?= e($category['label']) ?></option>
        <?php endforeach; ?>
      </select>
      <select class="form-select" id="bookSort" aria-label="Ordenar por">
        <option value="title">Ordenar por título</option>
        <option value="author">Ordenar por autor</option>
        <option value="year">Mais recentes</option>
      </select>
      <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" role="switch" id="onlyAvailable">
        <label class="form-check-label" for="onlyAvailable">Somente disponíveis</label>
      </div>
    </div>

    <p class="library-count" id="bookCount" aria-live="polite"></p>

    <div class="book-grid" id="bookGrid">
      <?php foreach (libraryCollectionByTitle() as $book): ?>
        <?php
          $category = BOOK_CATEGORIES[$book['category']];
          $isAvailable = $book['available'] > 0;
          $registryCode = bookRegistryCode($book);
          $details = implode(' • ', array_filter([$book['edition'], $book['publisher'], (string) $book['year']]));
          $searchText = mb_strtolower($book['title'] . ' ' . $book['author'] . ' ' . $book['publisher'] . ' ' . $category['label'] . ' ' . $registryCode);
        ?>
        <article class="book-card"
                 data-id="<?= (int) $book['id'] ?>"
                 data-category="<?= e($book['category']) ?>"
                 data-available="<?= $isAvailable ? 'true' : 'false' ?>"
                 data-title="<?= e($book['title']) ?>"
                 data-author="<?= e($book['author']) ?>"
                 data-year="<?= (int) $book['year'] ?>"
                 data-loan-status="<?= e(activeLoanStatus((int) $book['id']) ?? '') ?>"
                 data-search="<?= e($searchText) ?>">
          <div class="book-cover book-cover--<?= e($book['category']) ?>" aria-hidden="true">
            <i class="bi <?= e($category['icon']) ?>"></i>
            <span><?= e($category['label']) ?></span>
          </div>
          <div class="book-card__body">
            <h2 class="book-card__title"><?= e($book['title']) ?></h2>
            <p class="book-card__author"><?= e($book['author']) ?></p>
            <p class="book-card__meta"><?= e($details) ?></p>
            <div class="book-card__availability">
              <?php if ($isAvailable): ?>
                <span class="badge rounded-pill text-bg-success">Disponível</span>
                <span class="text-secondary"><?= (int) $book['available'] ?> de <?= (int) $book['copies'] ?> exemplares</span>
              <?php else: ?>
                <span class="badge rounded-pill text-bg-secondary">Indisponível</span>
                <?php if ($book['expected_return']): ?>
                  <span class="text-secondary">Devolução prevista: <?= e(formatDate($book['expected_return'])) ?></span>
                <?php endif; ?>
              <?php endif; ?>
              <span class="badge rounded-pill text-bg-warning" data-pending-badge hidden>Pedido em análise</span>
            </div>
            <p class="book-card__where">Estante <?= e($book['shelf']) ?> • <?= e($registryCode) ?></p>
          </div>
          <div class="book-card__foot">
            <button class="btn btn-accent w-100" type="button" data-action="schedule"<?= $isAvailable ? '' : ' disabled' ?>>
              <i class="bi <?= $isAvailable ? 'bi-calendar-plus' : 'bi-x-circle' ?> me-2"></i><?= $isAvailable ? 'Agendar empréstimo' : 'Indisponível no momento' ?>
            </button>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="notice-empty" id="bookEmpty" hidden>
      <i class="bi bi-search"></i>
      <p class="mb-0">Nenhum livro encontrado com esses filtros.</p>
    </div>


<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content academic-form" id="loanForm" novalidate>
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="loanModalLabel">Agendar empréstimo</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex gap-3 mb-3">
          <div id="loanCover" class="book-cover book-cover--mini" aria-hidden="true"></div>
          <div>
            <strong class="d-block" id="loanBookTitle"></strong>
            <span class="text-secondary small" id="loanBookAuthor"></span>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12 col-sm-6">
            <label class="form-label" for="loanDate">Data de retirada</label>
            <input class="form-control" type="date" id="loanDate">
            <div class="invalid-feedback" id="loanDateFeedback"></div>
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label" for="loanTime">Horário</label>
            <select class="form-select" id="loanTime">
              <option value="" selected disabled>Escolha</option>
              <?php foreach (PICKUP_TIMES as $pickupTime): ?>
                <option value="<?= e($pickupTime) ?>"><?= e($pickupTime) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Escolha um horário.</div>
          </div>
        </div>

        <dl class="data-grid mt-3 mb-3">
          <div><dt>Devolução prevista</dt><dd id="loanReturn">—</dd></div>
        </dl>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="loanTerms">
          <label class="form-check-label small" for="loanTerms">Estou ciente de que o prazo é de <?= LOAN_DAYS ?> dias a partir da retirada e de que o atraso na devolução gera multa conforme o regulamento da biblioteca.</label>
          <div class="invalid-feedback">Confirme que está ciente das regras.</div>
        </div>

        <div class="notice-box"><i class="bi bi-info-circle"></i><span>O pedido fica em análise até a confirmação da biblioteca. Acompanhe em Meus empréstimos.</span></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-calendar-check me-1"></i>Confirmar agendamento</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = <?= jsonForScript(studentStorageKey('loans')) ?>;
  const LOAN_DAYS = <?= LOAN_DAYS ?>;
  const MAX_DAYS_AHEAD = <?= MAX_PICKUP_DAYS_AHEAD ?>;
  const STATUS_PENDING = <?= jsonForScript(LOAN_STATUS_PENDING) ?>;
  const LOAN_LABELS = {
    [STATUS_PENDING]: { icon: 'bi-hourglass-split', text: 'Pedido em análise' },
    [<?= jsonForScript(LOAN_STATUS_PICKED_UP) ?>]: { icon: 'bi-bookmark-check', text: 'Já está com você' },
  };

  const $ = (id) => document.getElementById(id);
  const grid = $('bookGrid');
  const cards = [...grid.querySelectorAll('.book-card')];
  const form = $('loanForm');
  const dateInput = $('loanDate');
  const timeSelect = $('loanTime');
  const termsInput = $('loanTerms');
  const modal = bootstrap.Modal.getOrCreateInstance($('loanModal'));

  const state = { query: '', category: '', onlyAvailable: false, sort: 'title' };
  let currentCard = null;

  const normalize = (text) => text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

  const hasPendingRequest = (bookId) => readStoredList(STORAGE_KEY)
    .some((request) => request.book_id === bookId && request.status === STATUS_PENDING && !request.returned_at);

  const loanStatusOf = (card) => card.dataset.loanStatus || (hasPendingRequest(Number(card.dataset.id)) ? STATUS_PENDING : '');

  const paintCard = (card) => {
    const loan = LOAN_LABELS[loanStatusOf(card)];
    const isAvailable = card.dataset.available === 'true';
    const badge = card.querySelector('[data-pending-badge]');
    badge.hidden = !loan;
    if (loan) badge.textContent = loan.text;

    const button = card.querySelector('[data-action="schedule"]');
    button.disabled = Boolean(loan) || !isAvailable;
    button.replaceChildren(
      createIcon(`bi ${loan ? loan.icon : isAvailable ? 'bi-calendar-plus' : 'bi-x-circle'} me-2`),
      document.createTextNode(loan ? loan.text : isAvailable ? 'Agendar empréstimo' : 'Indisponível no momento'),
    );
  };

  const sorters = {
    title: (a, b) => a.dataset.title.localeCompare(b.dataset.title, 'pt-BR'),
    author: (a, b) => a.dataset.author.localeCompare(b.dataset.author, 'pt-BR'),
    year: (a, b) => Number(b.dataset.year) - Number(a.dataset.year) || sorters.title(a, b),
  };

  const matchesFilters = (card) => (!state.category || card.dataset.category === state.category)
    && (!state.onlyAvailable || card.dataset.available === 'true')
    && (!state.query || card.dataset.search.includes(state.query));

  const render = () => {
    const sorted = [...cards].sort(sorters[state.sort]);
    grid.append(...sorted);
    let shown = 0;
    sorted.forEach((card) => {
      const visible = matchesFilters(card);
      card.hidden = !visible;
      if (visible) shown += 1;
    });
    $('bookCount').textContent = pluralize(shown, 'livro encontrado', 'livros encontrados');
    $('bookEmpty').hidden = shown > 0;
  };

  const openLoanModal = (card) => {
    currentCard = card;
    $('loanBookTitle').textContent = card.dataset.title;
    $('loanBookAuthor').textContent = card.dataset.author;
    const cover = $('loanCover');
    cover.className = `book-cover book-cover--mini book-cover--${card.dataset.category}`;
    cover.replaceChildren(card.querySelector('.book-cover i').cloneNode(true));

    form.reset();
    form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
    dateInput.min = toIsoDate(addDays(portalToday(), 1));
    dateInput.max = toIsoDate(addDays(portalToday(), MAX_DAYS_AHEAD));
    $('loanReturn').textContent = '—';
    modal.show();
  };

  const pickupDateError = () => {
    if (!dateInput.value) return 'Escolha a data de retirada.';
    const chosen = parseIsoDate(dateInput.value);
    const min = parseIsoDate(dateInput.min);
    const max = parseIsoDate(dateInput.max);
    if (chosen < min || chosen > max) return `Escolha uma data entre ${formatDateBR(min)} e ${formatDateBR(max)}.`;
    if ([0, 6].includes(chosen.getDay())) return 'A biblioteca atende de segunda a sexta. Escolha um dia útil.';
    return '';
  };

  const isLoanFormValid = () => {
    const dateError = pickupDateError();
    $('loanDateFeedback').textContent = dateError;
    dateInput.classList.toggle('is-invalid', Boolean(dateError));
    timeSelect.classList.toggle('is-invalid', !timeSelect.value);
    termsInput.classList.toggle('is-invalid', !termsInput.checked);
    return !dateError && Boolean(timeSelect.value) && termsInput.checked;
  };

  const loanRequestFromForm = () => ({
    id: `EMP-${Date.now().toString(36).toUpperCase()}`,
    book_id: Number(currentCard.dataset.id),
    title: currentCard.dataset.title,
    author: currentCard.dataset.author,
    category: currentCard.dataset.category,
    pickup_date: dateInput.value,
    pickup_time: timeSelect.value,
    due_date: toIsoDate(addDays(parseIsoDate(dateInput.value), LOAN_DAYS)),
    requested_at: toIsoDate(portalToday()),
    status: STATUS_PENDING,
    renewals: 0,
    returned_at: null,
  });

  cards.forEach((card) => {
    card.dataset.search = normalize(card.dataset.search);
    paintCard(card);
  });

  $('bookSearch').addEventListener('input', (event) => { state.query = normalize(event.target.value.trim()); render(); });
  $('bookCategory').addEventListener('change', (event) => { state.category = event.target.value; render(); });
  $('bookSort').addEventListener('change', (event) => { state.sort = event.target.value; render(); });
  $('onlyAvailable').addEventListener('change', (event) => { state.onlyAvailable = event.target.checked; render(); });

  grid.addEventListener('click', (event) => {
    const button = event.target.closest('[data-action="schedule"]');
    if (button && !button.disabled) openLoanModal(button.closest('.book-card'));
  });

  dateInput.addEventListener('change', () => {
    $('loanReturn').textContent = dateInput.value ? formatDateBR(addDays(parseIsoDate(dateInput.value), LOAN_DAYS)) : '—';
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (!isLoanFormValid()) return;

    const request = loanRequestFromForm();
    if (!storeJson(STORAGE_KEY, [...readStoredList(STORAGE_KEY), request])) {
      showToast('Não foi possível registrar o pedido neste navegador.', { ok: false });
      return;
    }

    modal.hide();
    paintCard(currentCard);
    showToast(`Pedido de “${request.title}” enviado para análise.`, { link: { href: 'meusEmprestimos.php', label: 'Ver meus empréstimos' } });
  });

  render();
});
</script>
<?php renderPageEnd(); ?>
