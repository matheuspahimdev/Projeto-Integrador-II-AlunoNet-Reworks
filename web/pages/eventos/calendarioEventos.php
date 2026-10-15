<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/eventos.php';

$calendarData = jsonForScript(['categories' => EVENT_CATEGORIES, 'events' => calendarEvents()]);
renderPageStart('Eventos');
?>

<?php renderPageHeader('Eventos', 'Calendário acadêmico: provas, apresentações, feriados, palestras e prazos.'); ?>

    <div class="cal-layout">
      <section class="grid-card cal-card" aria-label="Calendário">
        <div class="cal-toolbar">
          <button class="btn btn-outline-secondary btn-sm" type="button" id="calPrev" aria-label="Mês anterior"><i class="bi bi-chevron-left"></i></button>
          <h2 class="cal-title" id="calTitle" aria-live="polite"></h2>
          <button class="btn btn-outline-secondary btn-sm" type="button" id="calToday">Hoje</button>
          <button class="btn btn-outline-secondary btn-sm" type="button" id="calNext" aria-label="Próximo mês"><i class="bi bi-chevron-right"></i></button>
        </div>

        <div class="cal-legend" role="group" aria-label="Legenda e filtro de categorias">
          <?php foreach (EVENT_CATEGORIES as $slug => $category): ?>
            <button class="cal-legend__item cat--<?= e($slug) ?>" type="button" data-category="<?= e($slug) ?>" aria-pressed="true">
              <span class="cal-dot"></span><?= e($category['label']) ?>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="cal-weekdays" aria-hidden="true">
          <span>Dom</span><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span>
        </div>
        <div class="cal-grid" id="calGrid"></div>
      </section>

      <aside class="grid-card cal-side" aria-label="Próximos eventos">
        <h2>Próximos eventos</h2>
        <ul class="cal-upcoming" id="calUpcoming"></ul>
        <p class="text-secondary small mb-0" id="calUpcomingEmpty" hidden>Nenhum evento futuro nas categorias selecionadas.</p>
      </aside>
    </div>


<div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="dayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="dayModalLabel"></h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="dayModalBody"></div>
    </div>
  </div>
</div>

<script id="calData" type="application/json"><?= $calendarData ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const data = readPageData('calData');
  const categories = data.categories;
  const events = data.events.sort((a, b) => a.date.localeCompare(b.date) || (a.time || '').localeCompare(b.time || ''));

  const $ = (id) => document.getElementById(id);
  const grid = $('calGrid');
  const legendButtons = [...document.querySelectorAll('.cal-legend__item')];
  const dayModal = bootstrap.Modal.getOrCreateInstance($('dayModal'));

  const now = portalToday();
  const state = { year: now.getFullYear(), month: now.getMonth(), hidden: new Set() };

  const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);
  const todayISO = () => toIsoDate(portalToday());

  const byDate = new Map();
  events.forEach((event) => {
    if (!byDate.has(event.date)) byDate.set(event.date, []);
    byDate.get(event.date).push(event);
  });
  const visibleOn = (iso) => (byDate.get(iso) || []).filter((event) => !state.hidden.has(event.category));

  const openDay = (iso) => {
    const list = visibleOn(iso);
    if (!list.length) return;
    $('dayModalLabel').textContent = capitalize(parseIsoDate(iso).toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }));
    const body = $('dayModalBody');
    body.replaceChildren(...list.map((event) => {
      const item = createNode('article', `cal-detail cat--${event.category}`);
      item.append(createNode('span', 'cal-badge', categories[event.category].label), createNode('h3', 'mt-2', event.title));
      const meta = createNode('div', 'cal-detail__meta');
      if (event.time) { const time = createNode('span'); time.append(createIcon('bi bi-clock me-1'), document.createTextNode(event.time)); meta.append(time); }
      if (event.place) { const place = createNode('span'); place.append(createIcon('bi bi-geo-alt me-1'), document.createTextNode(event.place)); meta.append(place); }
      if (meta.children.length) item.append(meta);
      if (event.description) item.append(createNode('p', '', event.description));
      return item;
    }));
    dayModal.show();
  };

  const renderCalendar = () => {
    $('calTitle').textContent = capitalize(new Date(state.year, state.month, 1).toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' }));

    const today = todayISO();
    const first = new Date(state.year, state.month, 1);
    const start = new Date(state.year, state.month, 1 - first.getDay());
    const cells = [];

    for (let i = 0; i < 42; i += 1) {
      const date = new Date(start.getFullYear(), start.getMonth(), start.getDate() + i);
      const iso = toIsoDate(date);
      const list = visibleOn(iso);

      const cell = createNode('button', 'cal-day');
      cell.type = 'button';
      cell.disabled = list.length === 0;
      if (date.getMonth() !== state.month) cell.classList.add('is-outside');
      if (date.getDay() === 0 || date.getDay() === 6) cell.classList.add('is-weekend');
      if (iso === today) cell.classList.add('is-today');
      if (list.some((event) => event.category === 'feriado')) cell.classList.add('has-holiday');

      const dayLabel = date.toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'long' });
      cell.setAttribute('aria-label', list.length ? `${dayLabel}, ${list.length} ${list.length === 1 ? 'evento' : 'eventos'}` : dayLabel);
      cell.append(createNode('span', 'cal-day__num', String(date.getDate())));

      if (list.length) {
        const chips = createNode('div', 'cal-day__chips');
        const max = list.length > 3 ? 2 : list.length;
        list.slice(0, max).forEach((event) => chips.append(createNode('span', `cal-chip cat--${event.category}`, event.title)));
        if (list.length > 3) chips.append(createNode('span', 'cal-more', `+${list.length - max} mais`));
        cell.append(chips);
        cell.addEventListener('click', () => openDay(iso));
      }
      cells.push(cell);
    }
    grid.replaceChildren(...cells);
  };

  const goTo = (iso) => {
    const date = parseIsoDate(iso);
    state.year = date.getFullYear();
    state.month = date.getMonth();
    render();
    openDay(iso);
  };

  const renderUpcoming = () => {
    const today = todayISO();
    const list = events.filter((event) => !state.hidden.has(event.category) && event.date >= today).slice(0, 6);
    $('calUpcomingEmpty').hidden = list.length > 0;
    $('calUpcoming').replaceChildren(...list.map((event) => {
      const date = parseIsoDate(event.date);
      const item = createNode('li');
      const button = createNode('button', `cal-upcoming__item cat--${event.category}`);
      button.type = 'button';

      const block = createNode('span', 'cal-upcoming__date');
      block.append(createNode('strong', '', String(date.getDate())), createNode('span', '', date.toLocaleDateString('pt-BR', { month: 'short' }).replace('.', '')));

      const text = createNode('span');
      const when = event.date === today ? 'Hoje' : capitalize(date.toLocaleDateString('pt-BR', { weekday: 'long' }));
      text.append(createNode('span', 'cal-upcoming__title', event.title), createNode('span', 'cal-upcoming__meta', `${when}${event.time ? ` • ${event.time}` : ''} • ${categories[event.category].label}`));

      button.append(block, text);
      button.addEventListener('click', () => goTo(event.date));
      item.append(button);
      return item;
    }));
  };

  const render = () => {
    renderCalendar();
    renderUpcoming();
  };

  const shiftMonth = (delta) => {
    const date = new Date(state.year, state.month + delta, 1);
    state.year = date.getFullYear();
    state.month = date.getMonth();
    render();
  };

  $('calPrev').addEventListener('click', () => shiftMonth(-1));
  $('calNext').addEventListener('click', () => shiftMonth(1));
  $('calToday').addEventListener('click', () => {
    const current = portalToday();
    state.year = current.getFullYear();
    state.month = current.getMonth();
    render();
  });

  legendButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const category = button.dataset.category;
      if (state.hidden.has(category)) state.hidden.delete(category);
      else state.hidden.add(category);
      const active = !state.hidden.has(category);
      button.classList.toggle('is-off', !active);
      button.setAttribute('aria-pressed', String(active));
      render();
    });
  });

  render();
});
</script>
<?php renderPageEnd(); ?>