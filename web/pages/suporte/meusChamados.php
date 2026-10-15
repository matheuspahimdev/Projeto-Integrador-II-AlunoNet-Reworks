<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/suporte.php';

$ticketData = jsonForScript([
    'departments' => supportDepartmentBadges(),
    'tickets' => supportTickets(),
    'replyMinLength' => TICKET_RULES['subject_min_length'],
]);
renderPageStart('Meus Chamados');
?>

<?php renderPageHeader('Meus Chamados', 'Acompanhe o andamento das suas solicitações aos departamentos.', static fn () => renderActionLink('chamados.php', 'bi-plus-lg', 'Abrir chamado', 'btn-accent')); ?>

    <div class="alert alert-warning d-flex align-items-start gap-2" id="waitingAlert" role="alert" hidden>
      <i class="bi bi-exclamation-circle-fill mt-1" aria-hidden="true"></i>
      <span id="waitingText"></span>
    </div>

    <div class="loan-summary" aria-label="Resumo dos chamados">
      <div class="loan-stat"><strong id="statInProgress">0</strong><span>Em andamento</span></div>
      <div class="loan-stat"><strong id="statWaiting">0</strong><span>Aguardando sua resposta</span></div>
      <div class="loan-stat"><strong id="statResolved">0</strong><span>Resolvidos</span></div>
      <div class="loan-stat"><strong id="statCanceled">0</strong><span>Cancelados</span></div>
    </div>

    <div class="notice-filters mb-3" role="group" aria-label="Filtrar chamados">
      <button class="notice-filter active" type="button" data-filter="all">Todos</button>
      <button class="notice-filter" type="button" data-filter="aguardando">Aguardando você</button>
      <button class="notice-filter" type="button" data-filter="andamento">Em andamento</button>
      <button class="notice-filter" type="button" data-filter="resolvido">Resolvidos</button>
      <button class="notice-filter" type="button" data-filter="cancelado">Cancelados</button>
    </div>

    <div class="loan-list" id="ticketList" aria-live="polite"></div>

    <div class="notice-empty" id="ticketEmpty" hidden>
      <i class="bi bi-chat-left-text"></i>
      <p class="mb-0" id="ticketEmptyText"></p>
    </div>


<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content academic-form" id="replyForm" novalidate>
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="replyModalLabel">Responder ao departamento</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p class="text-secondary small mb-3" id="replyContext"></p>
        <label class="form-label" for="replyText">Sua resposta</label>
        <textarea class="form-control" id="replyText" rows="4" maxlength="<?= TICKET_RULES['description_max_length'] ?>"></textarea>
        <div class="invalid-feedback">Escreva sua resposta (mínimo de <?= TICKET_RULES['subject_min_length'] ?> caracteres).</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Enviar resposta</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="cancelModalLabel">Cancelar chamado?</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">O chamado <strong id="cancelTitle"></strong> será encerrado sem atendimento. Você poderá reabri-lo depois, se precisar.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Manter chamado</button>
        <button type="button" class="btn btn-danger" id="cancelConfirm">Cancelar chamado</button>
      </div>
    </div>
  </div>
</div>

<script id="ticketData" type="application/json"><?= $ticketData ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = <?= jsonForScript(studentStorageKey('tickets')) ?>;
  const data = readPageData('ticketData');
  const DEPARTMENTS = data.departments;
  const STATUS = {
    aguardando: { label: 'Aguardando sua resposta', badge: 'text-bg-warning', order: 0 },
    andamento: { label: 'Em atendimento', badge: 'text-bg-primary', order: 1 },
    aberto: { label: 'Aberto', badge: 'text-bg-info', order: 2 },
    resolvido: { label: 'Resolvido', badge: 'text-bg-success', order: 3 },
    cancelado: { label: 'Cancelado', badge: 'text-bg-secondary', order: 4 },
  };
  const FILTERS = {
    all: () => true,
    aguardando: (ticket) => ticket.status === 'aguardando',
    andamento: (ticket) => ['aberto', 'andamento'].includes(ticket.status),
    resolvido: (ticket) => ticket.status === 'resolvido',
    cancelado: (ticket) => ticket.status === 'cancelado',
  };

  const $ = (id) => document.getElementById(id);
  const list = $('ticketList');
  const filterButtons = [...document.querySelectorAll('.notice-filter')];
  const replyModal = bootstrap.Modal.getOrCreateInstance($('replyModal'));
  const cancelModal = bootstrap.Modal.getOrCreateInstance($('cancelModal'));
  const replyText = $('replyText');

  const PREVIEW_LENGTH = 180;
  const formatDateTime = (iso) => new Date(iso).toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' });
  const departmentLabel = (ticket) => DEPARTMENTS[ticket.department]?.label || 'departamento';

  let tickets = [
    ...data.tickets.map((ticket) => ({ ...ticket, stored: false })),
    ...readStoredList(STORAGE_KEY).map((ticket) => ({ ...ticket, stored: true })),
  ];
  let filter = 'all';
  const expanded = new Set();
  let target = null;

  const syncStored = () => {
    storeJson(STORAGE_KEY, tickets.filter((ticket) => ticket.stored).map(({ stored, ...rest }) => rest));
  };

  const update = (ticket, text, status) => {
    const now = portalNowISO();
    ticket.history.push({ at: now, author: 'Você', text });
    ticket.status = status;
    ticket.updated_at = now;
    if (ticket.stored) syncStored();
  };

  const noteFor = (ticket) => {
    const department = departmentLabel(ticket);
    if (ticket.status === 'aguardando') return [`O setor ${department} aguarda sua resposta para continuar o atendimento.`, 'loan-card__note loan-card__note--danger'];
    if (ticket.status === 'andamento') return [`Em atendimento pelo setor ${department}.`, 'loan-card__note'];
    if (ticket.status === 'aberto') return ['Chamado registrado. Aguardando o início do atendimento.', 'loan-card__note'];
    if (ticket.status === 'resolvido') return [`Resolvido em ${formatDateTime(ticket.updated_at)}.`, 'loan-card__note'];
    return [`Cancelado em ${formatDateTime(ticket.updated_at)}.`, 'loan-card__note'];
  };

  const timeline = (ticket) => {
    const ol = createNode('ol', 'ticket-timeline');
    ticket.history.forEach((entry) => {
      const li = createNode('li');
      const time = createNode('time', '', formatDateTime(entry.at));
      time.dateTime = entry.at;
      const who = createNode('strong', '', `${entry.author}: `);
      li.append(time, who, document.createTextNode(entry.text));
      ol.append(li);
    });
    return ol;
  };

  const openReply = (ticket) => {
    target = ticket;
    $('replyContext').textContent = `${ticket.id} — ${ticket.subject}`;
    replyText.value = '';
    replyText.classList.remove('is-invalid');
    replyModal.show();
  };

  const renderCard = (ticket) => {
    const status = STATUS[ticket.status];
    const department = DEPARTMENTS[ticket.department] || { label: ticket.department, icon: 'bi-chat-dots' };
    const card = createNode('article', `loan-card loan-card--${ticket.status}`);

    const iconBox = createNode('div', 'ticket-icon');
    iconBox.setAttribute('aria-hidden', 'true');
    iconBox.append(createIcon(`bi ${department.icon}`));

    const info = createNode('div', 'loan-card__info');
    const head = createNode('div', 'd-flex flex-wrap align-items-center gap-2');
    head.append(createNode('h2', 'loan-card__title', ticket.subject), createNode('span', `badge rounded-pill ${status.badge}`, status.label));

    const dates = createNode('div', 'loan-card__dates');
    [['Aberto em', formatDateTime(ticket.opened_at)], ['Última atualização', formatDateTime(ticket.updated_at)]].forEach(([label, value]) => {
      const span = createNode('span');
      span.append(createNode('b', '', `${label}: `), document.createTextNode(value));
      dates.append(span);
    });
    if (ticket.attachment) {
      const attachment = createNode('span');
      attachment.append(createIcon('bi bi-paperclip me-1'), document.createTextNode(ticket.attachment));
      dates.append(attachment);
    }

    const preview = ticket.description.length > PREVIEW_LENGTH ? `${ticket.description.slice(0, PREVIEW_LENGTH)}…` : ticket.description;
    const [noteText, noteClass] = noteFor(ticket);
    info.append(
      head,
      createNode('p', 'loan-card__author', `${ticket.id} • ${department.label} • ${ticket.type}`),
      dates,
      createNode('p', 'small mt-2 mb-0', preview),
      createNode('p', noteClass, noteText),
    );

    const side = createNode('div', 'loan-card__side');
    const open = expanded.has(ticket.id);
    const toggle = createButton('btn btn-sm btn-outline-secondary', open ? 'Ocultar andamento' : 'Ver andamento');
    toggle.setAttribute('aria-expanded', String(open));
    toggle.addEventListener('click', () => {
      if (expanded.has(ticket.id)) expanded.delete(ticket.id); else expanded.add(ticket.id);
      render();
    });

    if (ticket.status === 'aguardando') {
      const reply = createButton('btn btn-sm btn-primary', 'Responder');
      reply.addEventListener('click', () => openReply(ticket));
      side.append(reply);
    } else if (ticket.status === 'aberto') {
      const cancel = createButton('btn btn-sm btn-outline-danger', 'Cancelar chamado');
      cancel.addEventListener('click', () => {
        target = ticket;
        $('cancelTitle').textContent = ticket.id;
        cancelModal.show();
      });
      side.append(cancel);
    } else if (ticket.status === 'resolvido') {
      const reopen = createButton('btn btn-sm btn-outline-secondary', 'Reabrir');
      reopen.addEventListener('click', () => {
        update(ticket, 'Chamado reaberto pelo solicitante.', 'aberto');
        render();
        showToast(`Chamado ${ticket.id} reaberto.`);
      });
      side.append(reopen);
    }
    side.append(toggle);

    card.append(iconBox, info, side);
    if (open) card.append(timeline(ticket));
    return card;
  };

  const render = () => {
    const count = (predicate) => tickets.filter(predicate).length;
    $('statInProgress').textContent = count(FILTERS.andamento);
    $('statWaiting').textContent = count(FILTERS.aguardando);
    $('statResolved').textContent = count(FILTERS.resolvido);
    $('statCanceled').textContent = count(FILTERS.cancelado);

    const waiting = count(FILTERS.aguardando);
    $('waitingAlert').hidden = waiting === 0;
    $('waitingText').textContent = `Você tem ${pluralize(waiting, 'chamado aguardando', 'chamados aguardando')} sua resposta. Responda para que o atendimento continue.`;

    filterButtons.forEach((filterButton) => {
      const active = filterButton.dataset.filter === filter;
      filterButton.classList.toggle('active', active);
      filterButton.setAttribute('aria-pressed', String(active));
    });

    const visible = tickets
      .filter(FILTERS[filter])
      .sort((a, b) => STATUS[a.status].order - STATUS[b.status].order || b.updated_at.localeCompare(a.updated_at));

    list.replaceChildren(...visible.map(renderCard));
    $('ticketEmpty').hidden = visible.length > 0;
    $('ticketEmptyText').textContent = filter === 'all' ? 'Você ainda não abriu nenhum chamado.' : 'Nenhum chamado nesta situação.';
  };

  filterButtons.forEach((filterButton) => {
    filterButton.addEventListener('click', () => { filter = filterButton.dataset.filter; render(); });
  });

  $('replyForm').addEventListener('submit', (event) => {
    event.preventDefault();
    const text = replyText.value.trim();
    const invalid = text.length < data.replyMinLength;
    replyText.classList.toggle('is-invalid', invalid);
    if (invalid || !target) return;
    update(target, text, 'andamento');
    replyModal.hide();
    render();
    showToast(`Resposta enviada ao setor ${departmentLabel(target)} (simulação).`);
  });

  $('cancelConfirm').addEventListener('click', () => {
    if (!target) return;
    update(target, 'Chamado cancelado pelo solicitante.', 'cancelado');
    cancelModal.hide();
    render();
    showToast(`Chamado ${target.id} cancelado.`);
  });

  render();
});
</script>
<?php renderPageEnd(); ?>