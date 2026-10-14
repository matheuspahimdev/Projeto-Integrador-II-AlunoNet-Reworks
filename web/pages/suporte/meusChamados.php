<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/suporte.php';

$dadosJson = jsonForScript(['departments' => supportDepartmentBadges(), 'tickets' => supportTickets()]);
renderPageStart('Meus Chamados');
?>

<?php renderPageHeader('Meus Chamados', 'Acompanhe o andamento das suas solicitações aos departamentos.', static fn () => renderActionLink('chamados.php', 'bi-plus-lg', 'Abrir chamado', 'btn-accent')); ?>

    <div class="alert alert-warning d-flex align-items-start gap-2" id="waitingAlert" role="alert" hidden>
      <i class="bi bi-exclamation-circle-fill mt-1" aria-hidden="true"></i>
      <span id="waitingText"></span>
    </div>

    <div class="loan-summary" aria-label="Resumo dos chamados">
      <div class="loan-stat"><strong id="statAndamento">0</strong><span>Em andamento</span></div>
      <div class="loan-stat"><strong id="statAguardando">0</strong><span>Aguardando sua resposta</span></div>
      <div class="loan-stat"><strong id="statResolvido">0</strong><span>Resolvidos</span></div>
      <div class="loan-stat"><strong id="statCancelado">0</strong><span>Cancelados</span></div>
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
        <textarea class="form-control" id="replyText" rows="4" maxlength="1500"></textarea>
        <div class="invalid-feedback">Escreva sua resposta (mínimo de 5 caracteres).</div>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="ticketToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="ticketToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script id="ticketData" type="application/json"><?= $dadosJson ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'alunonet.chamados';
  const data = JSON.parse(document.getElementById('ticketData').textContent);
  const DEPTS = data.departments;
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
  const toastEl = $('ticketToast');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 4000 });
  const replyModal = bootstrap.Modal.getOrCreateInstance($('replyModal'));
  const cancelModal = bootstrap.Modal.getOrCreateInstance($('cancelModal'));
  const replyText = $('replyText');

  const toISO = (date) => date.toLocaleDateString('sv-SE');
  const nowISO = () => {
    const date = new Date();
    return `${toISO(date)}T${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
  };
  const fmt = (iso) => new Date(iso).toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' });
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
  const button = (className, label) => {
    const node = el('button', className, label);
    node.type = 'button';
    return node;
  };

  const loadTickets = () => {
    try {
      const value = JSON.parse(localStorage.getItem(STORAGE_KEY));
      return Array.isArray(value) ? value : [];
    } catch (error) { return []; }
  };
  const saveTickets = (tickets) => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(tickets)); } catch (error) { /* ignora */ }
  };

  let tickets = [
    ...data.tickets.map((ticket) => ({ ...ticket, stored: false })),
    ...loadTickets().map((ticket) => ({ ...ticket, stored: true })),
  ];
  let filter = 'all';
  const expanded = new Set();
  let target = null;

  const syncStored = () => {
    saveTickets(tickets.filter((ticket) => ticket.stored).map(({ stored, ...rest }) => rest));
  };

  const showToast = (message) => {
    $('ticketToastBody').textContent = message;
    toast.show();
  };

  const update = (ticket, text, status) => {
    const now = nowISO();
    ticket.historico.push({ em: now, autor: 'Você', texto: text });
    ticket.status = status;
    ticket.atualizadoEm = now;
    if (ticket.stored) syncStored();
  };

  const noteFor = (ticket) => {
    const dept = DEPTS[ticket.departamento]?.label || 'departamento';
    if (ticket.status === 'aguardando') return [`O ${dept} aguarda sua resposta para continuar o atendimento.`, 'loan-card__note loan-card__note--danger'];
    if (ticket.status === 'andamento') return [`Em atendimento pelo ${dept}.`, 'loan-card__note'];
    if (ticket.status === 'aberto') return ['Chamado registrado. Aguardando o início do atendimento.', 'loan-card__note'];
    if (ticket.status === 'resolvido') return [`Resolvido em ${fmt(ticket.atualizadoEm)}.`, 'loan-card__note'];
    return [`Cancelado em ${fmt(ticket.atualizadoEm)}.`, 'loan-card__note'];
  };

  const timeline = (ticket) => {
    const ol = el('ol', 'ticket-timeline');
    ticket.historico.forEach((entry) => {
      const li = el('li');
      const time = el('time', '', fmt(entry.em));
      time.dateTime = entry.em;
      const who = el('strong', '', `${entry.autor}: `);
      li.append(time, who, document.createTextNode(entry.texto));
      ol.append(li);
    });
    return ol;
  };

  const openReply = (ticket) => {
    target = ticket;
    $('replyContext').textContent = `${ticket.id} — ${ticket.assunto}`;
    replyText.value = '';
    replyText.classList.remove('is-invalid');
    replyModal.show();
  };

  const renderCard = (ticket) => {
    const status = STATUS[ticket.status];
    const dept = DEPTS[ticket.departamento] || { label: ticket.departamento, icon: 'bi-chat-dots' };
    const card = el('article', `loan-card loan-card--${ticket.status}`);

    const iconBox = el('div', 'ticket-icon');
    iconBox.setAttribute('aria-hidden', 'true');
    iconBox.append(icon(`bi ${dept.icon}`));

    const info = el('div', 'loan-card__info');
    const head = el('div', 'd-flex flex-wrap align-items-center gap-2');
    head.append(el('h2', 'loan-card__title', ticket.assunto), el('span', `badge rounded-pill ${status.badge}`, status.label));

    const dates = el('div', 'loan-card__dates');
    [['Aberto em', fmt(ticket.abertoEm)], ['Última atualização', fmt(ticket.atualizadoEm)]].forEach(([label, value]) => {
      const span = el('span');
      span.append(el('b', '', `${label}: `), document.createTextNode(value));
      dates.append(span);
    });
    if (ticket.anexo) {
      const attachment = el('span');
      attachment.append(icon('bi bi-paperclip me-1'), document.createTextNode(ticket.anexo));
      dates.append(attachment);
    }

    const preview = ticket.descricao.length > 180 ? `${ticket.descricao.slice(0, 180)}…` : ticket.descricao;
    const [noteText, noteClass] = noteFor(ticket);
    info.append(
      head,
      el('p', 'loan-card__author', `${ticket.id} • ${dept.label} • ${ticket.tipo}`),
      dates,
      el('p', 'small mt-2 mb-0', preview),
      el('p', noteClass, noteText),
    );

    const side = el('div', 'loan-card__side');
    const open = expanded.has(ticket.id);
    const toggle = button('btn btn-sm btn-outline-secondary', open ? 'Ocultar andamento' : 'Ver andamento');
    toggle.setAttribute('aria-expanded', String(open));
    toggle.addEventListener('click', () => {
      if (expanded.has(ticket.id)) expanded.delete(ticket.id); else expanded.add(ticket.id);
      render();
    });

    if (ticket.status === 'aguardando') {
      const reply = button('btn btn-sm btn-primary', 'Responder');
      reply.addEventListener('click', () => openReply(ticket));
      side.append(reply);
    } else if (ticket.status === 'aberto') {
      const cancel = button('btn btn-sm btn-outline-danger', 'Cancelar chamado');
      cancel.addEventListener('click', () => {
        target = ticket;
        $('cancelTitle').textContent = ticket.id;
        cancelModal.show();
      });
      side.append(cancel);
    } else if (ticket.status === 'resolvido') {
      const reopen = button('btn btn-sm btn-outline-secondary', 'Reabrir');
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
    $('statAndamento').textContent = count(FILTERS.andamento);
    $('statAguardando').textContent = count(FILTERS.aguardando);
    $('statResolvido').textContent = count(FILTERS.resolvido);
    $('statCancelado').textContent = count(FILTERS.cancelado);

    const waiting = count(FILTERS.aguardando);
    $('waitingAlert').hidden = waiting === 0;
    $('waitingText').textContent = `Você tem ${plural(waiting, 'chamado aguardando', 'chamados aguardando')} sua resposta. Responda para que o atendimento continue.`;

    filterButtons.forEach((filterButton) => {
      const active = filterButton.dataset.filter === filter;
      filterButton.classList.toggle('active', active);
      filterButton.setAttribute('aria-pressed', String(active));
    });

    const visible = tickets
      .filter(FILTERS[filter])
      .sort((a, b) => STATUS[a.status].order - STATUS[b.status].order || b.atualizadoEm.localeCompare(a.atualizadoEm));

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
    const invalid = text.length < 5;
    replyText.classList.toggle('is-invalid', invalid);
    if (invalid || !target) return;
    update(target, text, 'andamento');
    replyModal.hide();
    render();
    showToast(`Resposta enviada ao ${DEPTS[target.departamento]?.label || 'departamento'} (simulação).`);
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