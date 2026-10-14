<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/eventos.php';

$categorias = EVENT_CATEGORIES;
$dadosJson = jsonForScript(['categories' => $categorias, 'events' => calendarEvents()]);
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
          <?php foreach ($categorias as $slug => $categoria): ?>
            <button class="cal-legend__item cat--<?= e($slug) ?>" type="button" data-category="<?= e($slug) ?>" aria-pressed="true">
              <span class="cal-dot"></span><?= e($categoria['label']) ?>
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

<script id="calData" type="application/json"><?= $dadosJson ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const data = JSON.parse(document.getElementById('calData').textContent);
  const categories = data.categories;
  const events = data.events.sort((a, b) => a.data.localeCompare(b.data) || (a.hora || '').localeCompare(b.hora || ''));

  const $ = (id) => document.getElementById(id);
  const grid = $('calGrid');
  const legendButtons = [...document.querySelectorAll('.cal-legend__item')];
  const dayModal = bootstrap.Modal.getOrCreateInstance($('dayModal'));

  const now = new Date();
  const state = { year: now.getFullYear(), month: now.getMonth(), hidden: new Set() };

  const toISO = (date) => date.toLocaleDateString('sv-SE');
  const parse = (iso) => new Date(`${iso}T00:00:00`);
  const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);
  const todayISO = () => toISO(new Date());

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

  const byDate = new Map();
  events.forEach((event) => {
    if (!byDate.has(event.data)) byDate.set(event.data, []);
    byDate.get(event.data).push(event);
  });
  const visibleOn = (iso) => (byDate.get(iso) || []).filter((event) => !state.hidden.has(event.categoria));

  const openDay = (iso) => {
    const list = visibleOn(iso);
    if (!list.length) return;
    $('dayModalLabel').textContent = capitalize(parse(iso).toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }));
    const body = $('dayModalBody');
    body.replaceChildren(...list.map((event) => {
      const item = el('article', `cal-detail cat--${event.categoria}`);
      item.append(el('span', 'cal-badge', categories[event.categoria].label), el('h3', 'mt-2', event.titulo));
      const meta = el('div', 'cal-detail__meta');
      if (event.hora) { const time = el('span'); time.append(icon('bi bi-clock me-1'), document.createTextNode(event.hora)); meta.append(time); }
      if (event.local) { const place = el('span'); place.append(icon('bi bi-geo-alt me-1'), document.createTextNode(event.local)); meta.append(place); }
      if (meta.children.length) item.append(meta);
      if (event.descricao) item.append(el('p', '', event.descricao));
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
      const iso = toISO(date);
      const list = visibleOn(iso);

      const cell = el('button', 'cal-day');
      cell.type = 'button';
      cell.disabled = list.length === 0;
      if (date.getMonth() !== state.month) cell.classList.add('is-outside');
      if (date.getDay() === 0 || date.getDay() === 6) cell.classList.add('is-weekend');
      if (iso === today) cell.classList.add('is-today');
      if (list.some((event) => event.categoria === 'feriado')) cell.classList.add('has-holiday');

      const dayLabel = date.toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'long' });
      cell.setAttribute('aria-label', list.length ? `${dayLabel}, ${list.length} ${list.length === 1 ? 'evento' : 'eventos'}` : dayLabel);
      cell.append(el('span', 'cal-day__num', String(date.getDate())));

      if (list.length) {
        const chips = el('div', 'cal-day__chips');
        const max = list.length > 3 ? 2 : list.length;
        list.slice(0, max).forEach((event) => chips.append(el('span', `cal-chip cat--${event.categoria}`, event.titulo)));
        if (list.length > 3) chips.append(el('span', 'cal-more', `+${list.length - max} mais`));
        cell.append(chips);
        cell.addEventListener('click', () => openDay(iso));
      }
      cells.push(cell);
    }
    grid.replaceChildren(...cells);
  };

  const goTo = (iso) => {
    const date = parse(iso);
    state.year = date.getFullYear();
    state.month = date.getMonth();
    render();
    openDay(iso);
  };

  const renderUpcoming = () => {
    const today = todayISO();
    const list = events.filter((event) => !state.hidden.has(event.categoria) && event.data >= today).slice(0, 6);
    $('calUpcomingEmpty').hidden = list.length > 0;
    $('calUpcoming').replaceChildren(...list.map((event) => {
      const date = parse(event.data);
      const item = el('li');
      const button = el('button', `cal-upcoming__item cat--${event.categoria}`);
      button.type = 'button';

      const block = el('span', 'cal-upcoming__date');
      block.append(el('strong', '', String(date.getDate())), el('span', '', date.toLocaleDateString('pt-BR', { month: 'short' }).replace('.', '')));

      const text = el('span');
      const when = event.data === today ? 'Hoje' : capitalize(date.toLocaleDateString('pt-BR', { weekday: 'long' }));
      text.append(el('span', 'cal-upcoming__title', event.titulo), el('span', 'cal-upcoming__meta', `${when}${event.hora ? ` • ${event.hora}` : ''} • ${categories[event.categoria].label}`));

      button.append(block, text);
      button.addEventListener('click', () => goTo(event.data));
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
    const current = new Date();
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