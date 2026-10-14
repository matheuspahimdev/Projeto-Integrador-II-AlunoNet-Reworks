<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/suporte.php';

$departamentos = SUPPORT_DEPARTMENTS;
$tipos = SUPPORT_REQUEST_TYPES;
$dadosJson = jsonForScript($departamentos);
renderPageStart('Abrir Chamado');
?>

<?php renderPageHeader('Abrir Chamado', 'Escolha o departamento e o tipo de solicitação. Acompanhe o andamento em Meus chamados.', static fn () => renderActionLink('meusChamados.php', 'bi-chat-left-text', 'Meus chamados')); ?>

    <form id="ticketForm" novalidate>
      <section class="ticket-step" id="stepDept">
        <h2 class="ticket-step__title"><span class="ticket-step__num">1</span>Escolha o departamento</h2>
        <div class="choice-grid" role="radiogroup" aria-label="Departamento">
          <?php foreach ($departamentos as $slug => $dep): ?>
            <label class="choice-card">
              <input type="radio" name="departamento" value="<?= e($slug) ?>">
              <span class="choice-card__icon"><i class="bi <?= e($dep['icon']) ?>"></i></span>
              <span>
                <strong><?= e($dep['label']) ?></strong>
                <span class="choice-card__desc"><?= e($dep['desc']) ?></span>
              </span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="ticket-step__error">Escolha um departamento para continuar.</div>
      </section>

      <section class="ticket-step" id="stepType" hidden>
        <h2 class="ticket-step__title"><span class="ticket-step__num">2</span><span id="stepTypeTitle">Qual é a sua solicitação?</span></h2>
        <p class="text-secondary small" id="deptHint"></p>
        <?php foreach ($tipos as $slug => $lista): ?>
          <div class="choice-grid choice-grid--compact" data-dept-panel="<?= e($slug) ?>" role="radiogroup" aria-label="Tipo de solicitação" hidden>
            <?php foreach ($lista as $tipo): ?>
              <label class="choice-card">
                <input type="radio" name="tipo" value="<?= e($tipo) ?>">
                <span><strong><?= e($tipo) ?></strong></span>
              </label>
            <?php endforeach; ?>
            <label class="choice-card">
              <input type="radio" name="tipo" value="__outros">
              <span class="choice-card__icon"><i class="bi bi-pencil-square"></i></span>
              <span>
                <strong>Outros</strong>
                <span class="choice-card__desc">Nenhuma opção serve? Descreva com suas palavras.</span>
              </span>
            </label>
          </div>
        <?php endforeach; ?>
        <div class="ticket-step__error">Escolha o tipo de solicitação.</div>
      </section>

      <section class="ticket-step" id="stepDetails" hidden>
        <h2 class="ticket-step__title"><span class="ticket-step__num">3</span>Detalhe seu chamado</h2>
        <div class="grid-card">
          <div class="grid-card__body academic-form">
            <div class="mb-3">
              <label class="form-label" for="ticketSubject">Assunto</label>
              <input class="form-control" type="text" id="ticketSubject" maxlength="100" autocomplete="off">
              <div class="invalid-feedback" id="ticketSubjectFeedback"></div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="ticketDescription" id="ticketDescriptionLabel">Descrição</label>
              <textarea class="form-control" id="ticketDescription" rows="5" maxlength="1500"></textarea>
              <div class="invalid-feedback" id="ticketDescriptionFeedback"></div>
              <small class="d-block text-end text-secondary mt-1" id="ticketCount">0/1500</small>
            </div>

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label" for="ticketFile">Anexo (opcional)</label>
                <input class="form-control" type="file" id="ticketFile" accept=".pdf,.jpg,.jpeg,.png">
                <div class="invalid-feedback">O anexo deve ter até 5 MB.</div>
              </div>
              <div class="col-12 col-md-6">
                <span class="form-label d-block">Como prefere ser contatado?</span>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="contato" id="contactPortal" value="Portal" checked>
                  <label class="form-check-label" for="contactPortal">Pelo portal</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="contato" id="contactEmail" value="E-mail">
                  <label class="form-check-label" for="contactEmail">Por e-mail</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-3">
          <small class="text-secondary" id="ticketSla"></small>
          <button class="btn btn-accent px-4 py-2" type="submit"><i class="bi bi-send me-2"></i>Abrir chamado</button>
        </div>
      </section>
    </form>


<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="ticketToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="ticketToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script id="deptData" type="application/json"><?= $dadosJson ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'alunonet.chamados';
  const MAX_FILE_SIZE = 5 * 1024 * 1024;
  const OTHERS = '__outros';
  const departments = JSON.parse(document.getElementById('deptData').textContent);

  const $ = (id) => document.getElementById(id);
  const form = $('ticketForm');
  const stepDept = $('stepDept');
  const stepType = $('stepType');
  const stepDetails = $('stepDetails');
  const subject = $('ticketSubject');
  const description = $('ticketDescription');
  const file = $('ticketFile');
  const toastEl = $('ticketToast');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 6000 });
  const deptRadios = [...form.querySelectorAll('input[name="departamento"]')];
  const typeRadios = [...form.querySelectorAll('input[name="tipo"]')];
  const panels = [...form.querySelectorAll('[data-dept-panel]')];

  const checked = (radios) => radios.find((radio) => radio.checked);
  const toISO = (date) => date.toLocaleDateString('sv-SE');
  const nowISO = () => {
    const date = new Date();
    return `${toISO(date)}T${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
  };

  const loadTickets = () => {
    try {
      const value = JSON.parse(localStorage.getItem(STORAGE_KEY));
      return Array.isArray(value) ? value : [];
    } catch (error) { return []; }
  };
  const saveTickets = (list) => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(list)); return true; } catch (error) { return false; }
  };

  const showToast = (message, ok = true, linkHref = '') => {
    toastEl.classList.toggle('text-bg-success', ok);
    toastEl.classList.toggle('text-bg-danger', !ok);
    const body = $('ticketToastBody');
    body.replaceChildren(document.createTextNode(message));
    if (linkHref) {
      const link = document.createElement('a');
      link.href = linkHref;
      link.className = 'text-white fw-bold ms-1';
      link.textContent = 'Acompanhar chamado';
      body.append(link);
    }
    toast.show();
  };

  const minLength = () => (checked(typeRadios)?.value === OTHERS ? 20 : 10);

  const setDescriptionError = (message) => {
    $('ticketDescriptionFeedback').textContent = message;
    description.classList.toggle('is-invalid', Boolean(message));
  };

  const resetAll = () => {
    form.reset();
    [stepType, stepDetails].forEach((step) => { step.hidden = true; });
    [stepDept, stepType].forEach((step) => step.classList.remove('is-invalid'));
    form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
    setDescriptionError('');
    $('ticketCount').textContent = '0/1500';
  };

  deptRadios.forEach((radio) => {
    radio.addEventListener('change', () => {
      const dept = departments[radio.value];
      stepDept.classList.remove('is-invalid');
      typeRadios.forEach((type) => { type.checked = false; });
      panels.forEach((panel) => { panel.hidden = panel.dataset.deptPanel !== radio.value; });
      $('stepTypeTitle').textContent = `Qual é a sua solicitação para ${dept.label}?`;
      $('deptHint').textContent = `Prazo médio de resposta: ${dept.prazo}.`;
      stepType.hidden = false;
      stepType.classList.remove('is-invalid');
      stepDetails.hidden = true;
    });
  });

  typeRadios.forEach((radio) => {
    radio.addEventListener('change', () => {
      const dept = departments[checked(deptRadios).value];
      const others = radio.value === OTHERS;
      stepType.classList.remove('is-invalid');
      subject.value = others ? '' : radio.value;
      subject.placeholder = others ? 'Resuma sua solicitação em poucas palavras' : '';
      description.placeholder = others ? 'Explique o que você precisa com o máximo de detalhes.' : 'Conte o que aconteceu e o que você espera como solução.';
      $('ticketDescriptionLabel').textContent = others ? 'Descreva sua solicitação' : 'Descrição';
      $('ticketSla').textContent = `Departamento: ${dept.label} • Prazo médio de resposta: ${dept.prazo}.`;
      subject.classList.remove('is-invalid');
      setDescriptionError('');
      stepDetails.hidden = false;
      (others ? subject : description).focus({ preventScroll: true });
      stepDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  });

  description.addEventListener('input', () => {
    $('ticketCount').textContent = `${description.value.length}/1500`;
    if (description.classList.contains('is-invalid') && description.value.trim().length >= minLength()) setDescriptionError('');
  });
  subject.addEventListener('input', () => { if (subject.value.trim().length >= 5) subject.classList.remove('is-invalid'); });
  file.addEventListener('change', () => file.classList.remove('is-invalid'));

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const dept = checked(deptRadios);
    const type = checked(typeRadios);
    stepDept.classList.toggle('is-invalid', !dept);
    stepType.classList.toggle('is-invalid', Boolean(dept) && !type);
    if (!dept) { stepDept.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
    if (!type) { stepType.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }

    const subjectText = subject.value.trim();
    const descriptionText = description.value.trim();
    const subjectError = subjectText.length < 5;
    const descriptionError = descriptionText.length < minLength();
    const attachment = file.files[0] || null;
    const fileError = Boolean(attachment) && attachment.size > MAX_FILE_SIZE;

    $('ticketSubjectFeedback').textContent = subjectText ? 'O assunto precisa ter pelo menos 5 caracteres.' : 'Informe o assunto do chamado.';
    subject.classList.toggle('is-invalid', subjectError);
    setDescriptionError(descriptionError ? `Descreva com pelo menos ${minLength()} caracteres.` : '');
    file.classList.toggle('is-invalid', fileError);
    if (subjectError) { subject.focus(); return; }
    if (descriptionError) { description.focus(); return; }
    if (fileError) { file.focus(); return; }

    const tickets = loadTickets();
    const next = Math.max(190, ...tickets.map((ticket) => (Number(String(ticket.id).split('-')[2]) || 0) + 1));
    const now = nowISO();
    const ticket = {
      id: `CH-${new Date().getFullYear()}-${String(next).padStart(4, '0')}`,
      departamento: dept.value,
      tipo: type.value === OTHERS ? 'Outros' : type.value,
      assunto: subjectText,
      descricao: descriptionText,
      anexo: attachment ? attachment.name : null,
      contato: form.querySelector('input[name="contato"]:checked').value,
      status: 'aberto',
      abertoEm: now,
      atualizadoEm: now,
      historico: [{ em: now, autor: 'Você', texto: 'Chamado aberto.' }],
    };

    tickets.push(ticket);
    if (!saveTickets(tickets)) {
      showToast('Não foi possível registrar o chamado neste navegador.', false);
      return;
    }

    resetAll();
    window.scrollTo({ top: 0, behavior: 'smooth' });
    showToast(`Chamado ${ticket.id} aberto para ${departments[ticket.departamento].label}.`, true, 'meusChamados.php');
  });
});
</script>
<?php renderPageEnd(); ?>