<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/avisos.php';

$notices = noticesPinnedFirst();
renderPageStart('Avisos');
?>

<?php renderPageHeader('Avisos', 'Comunicados da secretaria, coordenação e professores.', static fn () => renderActionButton('markAllRead', 'bi-check2-all', 'Marcar todos como lidos')); ?>

    <div class="notice-wrap">
      <div class="notice-toolbar">
        <div class="notice-filters" role="group" aria-label="Filtrar avisos">
          <button class="notice-filter active" type="button" data-filter="all">Todos</button>
          <button class="notice-filter" type="button" data-filter="unread">Não lidos <span class="badge text-bg-primary" id="unreadCount"><?= unreadNoticesCount($notices) ?></span></button>
          <?php foreach (NOTICE_CATEGORIES as $slug => $category): ?>
            <button class="notice-filter" type="button" data-filter="<?= e($slug) ?>"><i class="bi <?= e($category['icon']) ?> me-1"></i><?= e($category['label']) ?></button>
          <?php endforeach; ?>
        </div>
        <div class="input-group notice-search">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input class="form-control" type="search" id="noticeSearch" placeholder="Buscar avisos" aria-label="Buscar avisos">
        </div>
      </div>

      <div class="notice-feed" id="noticeFeed" aria-live="polite">
        <?php foreach ($notices as $notice): ?>
          <?php
            $publishedAt = parseDateTime($notice['published_at']);
            $category = NOTICE_CATEGORIES[$notice['category']];
            $priority = NOTICE_PRIORITIES[$notice['priority']] ?? null;
            $attachments = $notice['attachments'] ?? [];
            $link = $notice['link'] ?? null;
            $hasMore = mb_strlen($notice['text']) > NOTICE_PREVIEW_LENGTH || $attachments || $link;
            $searchText = mb_strtolower($notice['title'] . ' ' . $notice['text'] . ' ' . $notice['author'] . ' ' . $category['label']);
            $classes = 'notice-card notice-card--' . $notice['priority'] . ($notice['read'] ? '' : ' is-unread');
          ?>
          <article class="<?= e($classes) ?>"
                   data-id="<?= (int) $notice['id'] ?>"
                   data-category="<?= e($notice['category']) ?>"
                   data-date="<?= e($publishedAt->format('Y-m-d\TH:i')) ?>"
                   data-pinned="<?= $notice['pinned'] ? 'true' : 'false' ?>"
                   data-read="<?= $notice['read'] ? 'true' : 'false' ?>"
                   data-search="<?= e($searchText) ?>">
            <header class="notice-card__head">
              <span class="notice-card__avatar" aria-hidden="true"><i class="bi <?= e($category['icon']) ?>"></i></span>
              <div class="notice-card__meta">
                <strong><?= e($notice['author']) ?></strong>
                <time datetime="<?= e($publishedAt->format('Y-m-d\TH:i')) ?>"><?= e(relativeDateLabel($publishedAt)) ?></time>
              </div>
              <div class="notice-card__tags">
                <span class="notice-dot" title="Não lido"></span>
                <?php if ($priority): ?>
                  <span class="badge rounded-pill <?= e($priority['class']) ?>"><?= e($priority['label']) ?></span>
                <?php endif; ?>
                <span class="badge rounded-pill text-bg-secondary"><?= e($category['label']) ?></span>
              </div>
              <button class="notice-action<?= $notice['pinned'] ? ' is-pinned' : '' ?>" type="button" data-action="pin" aria-pressed="<?= $notice['pinned'] ? 'true' : 'false' ?>" aria-label="<?= $notice['pinned'] ? 'Desafixar aviso' : 'Fixar aviso' ?>">
                <i class="bi <?= $notice['pinned'] ? 'bi-pin-angle-fill' : 'bi-pin-angle' ?>"></i>
              </button>
            </header>

            <h2 class="notice-card__title"><?= e($notice['title']) ?></h2>
            <p class="notice-card__text"><?= e($notice['text']) ?></p>

            <?php if ($attachments || $link): ?>
              <div class="notice-card__more">
                <?php if ($attachments): ?>
                  <div class="notice-attachments">
                    <?php foreach ($attachments as $attachment): ?>
                      <a class="notice-chip" href="#"><i class="bi bi-file-earmark-pdf file-icon--pdf"></i><?= e($attachment['name']) ?> <small><?= e($attachment['size']) ?></small></a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <?php if ($link): ?>
                  <a class="btn btn-sm btn-outline-primary" href="<?= e($link['href']) ?>"><?= e($link['label']) ?><i class="bi bi-arrow-right ms-2"></i></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <footer class="notice-card__foot">
              <?php if ($hasMore): ?>
                <button class="notice-action" type="button" data-action="expand" aria-expanded="false">Ler mais</button>
              <?php endif; ?>
              <button class="notice-action ms-auto" type="button" data-action="read"></button>
            </footer>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="notice-empty" id="noticeEmpty" hidden>
        <i class="bi bi-inbox"></i>
        <p class="mb-0">Nenhum aviso encontrado com esses filtros.</p>
      </div>

      <div class="text-center my-4">
        <button class="btn btn-outline-secondary" type="button" id="noticeMore" hidden>Carregar mais avisos</button>
      </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const PAGE_SIZE = 6;
  const STORAGE_KEY = <?= jsonForScript(studentStorageKey('notices')) ?>;

  const feed = document.getElementById('noticeFeed');
  const cards = [...feed.querySelectorAll('.notice-card')];
  const empty = document.getElementById('noticeEmpty');
  const moreButton = document.getElementById('noticeMore');
  const markAll = document.getElementById('markAllRead');
  const unreadBadge = document.getElementById('unreadCount');
  const search = document.getElementById('noticeSearch');
  const filterButtons = [...document.querySelectorAll('.notice-filter')];

  const state = { filter: 'all', query: '', limit: PAGE_SIZE };
  const touched = new Set();

  const stored = readStoredJson(STORAGE_KEY, {});
  const saved = { read: stored.read || {}, pinned: stored.pinned || {} };
  const persist = () => storeJson(STORAGE_KEY, saved);

  const isRead = (card) => card.dataset.read === 'true';
  const isPinned = (card) => card.dataset.pinned === 'true';

  const paintRead = (card) => {
    const read = isRead(card);
    card.classList.toggle('is-unread', !read);
    card.querySelector('[data-action="read"]').replaceChildren(
      createIcon(read ? 'bi bi-envelope' : 'bi bi-envelope-open'),
      document.createTextNode(read ? 'Marcar como não lido' : 'Marcar como lido'),
    );
  };

  const paintPin = (card) => {
    const pinned = isPinned(card);
    const pin = card.querySelector('[data-action="pin"]');
    pin.classList.toggle('is-pinned', pinned);
    pin.setAttribute('aria-pressed', String(pinned));
    pin.setAttribute('aria-label', pinned ? 'Desafixar aviso' : 'Fixar aviso');
    pin.firstElementChild.className = pinned ? 'bi bi-pin-angle-fill' : 'bi bi-pin-angle';
  };

  const setRead = (card, read) => {
    card.dataset.read = String(read);
    saved.read[card.dataset.id] = read;
    persist();
    paintRead(card);
  };

  const setPinned = (card, pinned) => {
    card.dataset.pinned = String(pinned);
    saved.pinned[card.dataset.id] = pinned;
    persist();
    paintPin(card);
  };

  const matches = (card) => {
    if (state.filter === 'unread' && isRead(card) && !touched.has(card.dataset.id)) return false;
    if (state.filter !== 'all' && state.filter !== 'unread' && card.dataset.category !== state.filter) return false;
    return !state.query || card.dataset.search.includes(state.query);
  };

  const render = () => {
    const sorted = [...cards].sort((a, b) => Number(isPinned(b)) - Number(isPinned(a)) || b.dataset.date.localeCompare(a.dataset.date));
    feed.append(...sorted);

    let total = 0;
    let shown = 0;
    sorted.forEach((card) => {
      const ok = matches(card);
      if (ok) total += 1;
      const visible = ok && shown < state.limit;
      if (visible) shown += 1;
      card.hidden = !visible;
    });

    empty.hidden = total > 0;
    moreButton.hidden = total <= shown;
    moreButton.textContent = `Carregar mais avisos (${total - shown})`;

    const unread = cards.filter((card) => !isRead(card)).length;
    unreadBadge.textContent = String(unread);
    unreadBadge.hidden = unread === 0;
    markAll.disabled = unread === 0;

    filterButtons.forEach((button) => {
      const active = button.dataset.filter === state.filter;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });
  };

  cards.forEach((card) => {
    const id = card.dataset.id;
    if (id in saved.read) card.dataset.read = String(saved.read[id]);
    if (id in saved.pinned) card.dataset.pinned = String(saved.pinned[id]);
    paintRead(card);
    paintPin(card);
  });

  feed.addEventListener('click', (event) => {
    const button = event.target.closest('[data-action]');
    if (!button) return;
    const card = button.closest('.notice-card');
    touched.add(card.dataset.id);

    if (button.dataset.action === 'read') {
      setRead(card, !isRead(card));
    } else if (button.dataset.action === 'pin') {
      setPinned(card, !isPinned(card));
    } else if (button.dataset.action === 'expand') {
      const open = !card.classList.contains('is-expanded');
      card.classList.toggle('is-expanded', open);
      button.setAttribute('aria-expanded', String(open));
      button.textContent = open ? 'Ler menos' : 'Ler mais';
      if (open && !isRead(card)) setRead(card, true);
    }
    render();
  });

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      state.filter = button.dataset.filter;
      state.limit = PAGE_SIZE;
      touched.clear();
      render();
    });
  });

  search.addEventListener('input', () => {
    state.query = search.value.trim().toLowerCase();
    state.limit = PAGE_SIZE;
    touched.clear();
    render();
  });

  moreButton.addEventListener('click', () => {
    state.limit += PAGE_SIZE;
    render();
  });

  markAll.addEventListener('click', () => {
    cards.forEach((card) => setRead(card, true));
    touched.clear();
    render();
    showToast('Todos os avisos foram marcados como lidos.');
  });

  render();
});
</script>
<?php renderPageEnd(); ?>