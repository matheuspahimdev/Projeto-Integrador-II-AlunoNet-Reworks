<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/biblioteca.php';

$categorias = BOOK_CATEGORIES;
$horarios = PICKUP_TIMES;
$livros = libraryCollectionByTitle();
renderPageStart('Consulta ao Acervo');
?>

<?php renderPageHeader('Consulta ao Acervo', 'Pesquise os livros da biblioteca local e agende o empréstimo.', static fn () => renderActionLink('meusEmprestimos.php', 'bi-bookmarks', 'Meus empréstimos')); ?>

    <div class="info-banner" role="note">
      <div class="info-banner__icon"><i class="bi bi-info-circle"></i></div>
      <div>
        <strong>Como funciona</strong>
        <span>Escolha um livro disponível e agende a retirada. A biblioteca atende de segunda a sexta, das 08h às 21h, e o prazo de empréstimo é de 7 dias.</span>
      </div>
    </div>

    <div class="library-toolbar">
      <div class="input-group library-search">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input class="form-control" type="search" id="bookSearch" placeholder="Buscar por título, autor ou editora" aria-label="Buscar livros">
      </div>
      <select class="form-select" id="bookCategory" aria-label="Filtrar por área">
        <option value="">Todas as áreas</option>
        <?php foreach ($categorias as $slug => $categoria): ?>
          <option value="<?= e($slug) ?>"><?= e($categoria['label']) ?></option>
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
      <?php foreach ($livros as $item): ?>
        <?php
          $categoria = $categorias[$item['categoria']];
          $disponivel = $item['disponiveis'] > 0;
          $meta = implode(' • ', array_filter([$item['edicao'], $item['editora'], (string) $item['ano']]));
          $busca = mb_strtolower($item['titulo'] . ' ' . $item['autor'] . ' ' . $item['editora'] . ' ' . $categoria['label'] . ' ' . $item['tombo']);
        ?>
        <article class="book-card"
                 data-id="<?= (int) $item['id'] ?>"
                 data-category="<?= e($item['categoria']) ?>"
                 data-available="<?= $disponivel ? 'true' : 'false' ?>"
                 data-titulo="<?= e($item['titulo']) ?>"
                 data-autor="<?= e($item['autor']) ?>"
                 data-ano="<?= (int) $item['ano'] ?>"
                 data-search="<?= e($busca) ?>">
          <div class="book-cover book-cover--<?= e($item['categoria']) ?>" aria-hidden="true">
            <i class="bi <?= e($categoria['icon']) ?>"></i>
            <span><?= e($categoria['label']) ?></span>
          </div>
          <div class="book-card__body">
            <h2 class="book-card__title"><?= e($item['titulo']) ?></h2>
            <p class="book-card__author"><?= e($item['autor']) ?></p>
            <p class="book-card__meta"><?= e($meta) ?></p>
            <div class="book-card__availability">
              <?php if ($disponivel): ?>
                <span class="badge rounded-pill text-bg-success">Disponível</span>
                <span class="text-secondary"><?= (int) $item['disponiveis'] ?> de <?= (int) $item['total'] ?> exemplares</span>
              <?php else: ?>
                <span class="badge rounded-pill text-bg-secondary">Indisponível</span>
                <?php if ($item['previsao']): ?>
                  <span class="text-secondary">Devolução prevista: <?= e((new DateTimeImmutable($item['previsao']))->format('d/m/Y')) ?></span>
                <?php endif; ?>
              <?php endif; ?>
              <span class="badge rounded-pill text-bg-warning" data-pending-badge hidden>Pedido em análise</span>
            </div>
            <p class="book-card__where">Estante <?= e($item['estante']) ?> • <?= e($item['tombo']) ?></p>
          </div>
          <div class="book-card__foot">
            <button class="btn btn-accent w-100" type="button" data-action="schedule"<?= $disponivel ? '' : ' disabled' ?>>
              <i class="bi <?= $disponivel ? 'bi-calendar-plus' : 'bi-x-circle' ?> me-2"></i><?= $disponivel ? 'Agendar empréstimo' : 'Indisponível no momento' ?>
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
              <?php foreach ($horarios as $horario): ?>
                <option value="<?= e($horario) ?>"><?= e($horario) ?></option>
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
          <label class="form-check-label small" for="loanTerms">Estou ciente de que o prazo é de 7 dias a partir da retirada e de que o atraso na devolução gera multa conforme o regulamento da biblioteca.</label>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="libraryToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="libraryToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'alunonet.emprestimos';
  const LOAN_DAYS = 7;
  const MAX_DAYS_AHEAD = 14;

  const $ = (id) => document.getElementById(id);
  const grid = $('bookGrid');
  const cards = [...grid.querySelectorAll('.book-card')];
  const empty = $('bookEmpty');
  const count = $('bookCount');
  const form = $('loanForm');
  const dateInput = $('loanDate');
  const timeSelect = $('loanTime');
  const termsInput = $('loanTerms');
  const toastEl = $('libraryToast');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 5000 });
  const modal = bootstrap.Modal.getOrCreateInstance($('loanModal'));

  const state = { query: '', category: '', onlyAvailable: false, sort: 'title' };
  let currentCard = null;

  const normalize = (text) => text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
  const toISO = (date) => date.toLocaleDateString('sv-SE');
  const fromISO = (iso) => new Date(`${iso}T00:00:00`);
  const addDays = (date, days) => { const copy = new Date(date); copy.setDate(copy.getDate() + days); return copy; };
  const fmt = (date) => date.toLocaleDateString('pt-BR');
  const icon = (className) => {
    const node = document.createElement('i');
    node.className = className;
    node.setAttribute('aria-hidden', 'true');
    return node;
  };

  const loadRequests = () => {
    try {
      const value = JSON.parse(localStorage.getItem(STORAGE_KEY));
      return Array.isArray(value) ? value : [];
    } catch (error) { return []; }
  };
  const saveRequests = (list) => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(list)); return true; } catch (error) { return false; }
  };
  const hasPending = (bookId) => loadRequests().some((r) => r.bookId === bookId && r.status === 'analise' && !r.devolvidoEm);

  const showToast = (message, ok = true, linkHref = '') => {
    toastEl.classList.toggle('text-bg-success', ok);
    toastEl.classList.toggle('text-bg-danger', !ok);
    const body = $('libraryToastBody');
    body.replaceChildren(document.createTextNode(message));
    if (linkHref) {
      const link = document.createElement('a');
      link.href = linkHref;
      link.className = 'text-white fw-bold ms-1';
      link.textContent = 'Ver meus empréstimos';
      body.append(link);
    }
    toast.show();
  };

  const paintCard = (card) => {
    const pending = hasPending(Number(card.dataset.id));
    const available = card.dataset.available === 'true';
    card.querySelector('[data-pending-badge]').hidden = !pending;
    const button = card.querySelector('[data-action="schedule"]');
    button.disabled = pending || !available;
    button.replaceChildren(
      icon(`bi ${pending ? 'bi-hourglass-split' : available ? 'bi-calendar-plus' : 'bi-x-circle'} me-2`),
      document.createTextNode(pending ? 'Pedido em análise' : available ? 'Agendar empréstimo' : 'Indisponível no momento'),
    );
  };

  const sorters = {
    title: (a, b) => a.dataset.titulo.localeCompare(b.dataset.titulo, 'pt-BR'),
    author: (a, b) => a.dataset.autor.localeCompare(b.dataset.autor, 'pt-BR'),
    year: (a, b) => Number(b.dataset.ano) - Number(a.dataset.ano) || sorters.title(a, b),
  };

  const render = () => {
    const sorted = [...cards].sort(sorters[state.sort]);
    grid.append(...sorted);
    let shown = 0;
    sorted.forEach((card) => {
      const ok = (!state.category || card.dataset.category === state.category)
        && (!state.onlyAvailable || card.dataset.available === 'true')
        && (!state.query || card.dataset.search.includes(state.query));
      card.hidden = !ok;
      if (ok) shown += 1;
    });
    count.textContent = `${shown} ${shown === 1 ? 'livro encontrado' : 'livros encontrados'}`;
    empty.hidden = shown > 0;
  };

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
    if (!button || button.disabled) return;
    currentCard = button.closest('.book-card');

    $('loanBookTitle').textContent = currentCard.dataset.titulo;
    $('loanBookAuthor').textContent = currentCard.dataset.autor;
    const cover = $('loanCover');
    cover.className = `book-cover book-cover--mini book-cover--${currentCard.dataset.category}`;
    cover.replaceChildren(currentCard.querySelector('.book-cover i').cloneNode(true));

    form.reset();
    form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
    dateInput.min = toISO(addDays(new Date(), 1));
    dateInput.max = toISO(addDays(new Date(), MAX_DAYS_AHEAD));
    $('loanReturn').textContent = '—';
    modal.show();
  });

  dateInput.addEventListener('change', () => {
    $('loanReturn').textContent = dateInput.value ? fmt(addDays(fromISO(dateInput.value), LOAN_DAYS)) : '—';
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    let dateError = '';
    if (!dateInput.value) {
      dateError = 'Escolha a data de retirada.';
    } else {
      const chosen = fromISO(dateInput.value);
      const min = fromISO(dateInput.min);
      const max = fromISO(dateInput.max);
      if (chosen < min || chosen > max) dateError = `Escolha uma data entre ${fmt(min)} e ${fmt(max)}.`;
      else if ([0, 6].includes(chosen.getDay())) dateError = 'A biblioteca atende de segunda a sexta. Escolha um dia útil.';
    }
    $('loanDateFeedback').textContent = dateError;
    dateInput.classList.toggle('is-invalid', Boolean(dateError));

    const timeError = !timeSelect.value;
    timeSelect.classList.toggle('is-invalid', timeError);
    const termsError = !termsInput.checked;
    termsInput.classList.toggle('is-invalid', termsError);
    if (dateError || timeError || termsError) return;

    const request = {
      id: `EMP-${Date.now().toString(36).toUpperCase()}`,
      bookId: Number(currentCard.dataset.id),
      titulo: currentCard.dataset.titulo,
      autor: currentCard.dataset.autor,
      categoria: currentCard.dataset.category,
      retirada: dateInput.value,
      horario: timeSelect.value,
      devolucao: toISO(addDays(fromISO(dateInput.value), LOAN_DAYS)),
      solicitadoEm: toISO(new Date()),
      status: 'analise',
      renovacoes: 0,
      devolvidoEm: null,
    };

    const requests = loadRequests();
    requests.push(request);
    if (!saveRequests(requests)) {
      showToast('Não foi possível registrar o pedido neste navegador.', false);
      return;
    }

    modal.hide();
    paintCard(currentCard);
    showToast(`Pedido de “${request.titulo}” enviado para análise.`, true, 'meusEmprestimos.php');
  });

  render();
});
</script>
<?php renderPageEnd(); ?>