<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/suporte.php';

$ticketFormData = jsonForScript([
    'departments' => SUPPORT_DEPARTMENTS,
    'rules' => TICKET_RULES,
    'openStatus' => TICKET_STATUS_OPEN,
    'ticketIds' => array_column(supportTickets(), 'id'),
]);
renderPageStart('Abrir Chamado');
?>

<?php renderPageHeader('Abrir Chamado', 'Escolha o departamento e o tipo de solicitação. Acompanhe o andamento em Meus chamados.', static fn () => renderActionLink('meusChamados.php', 'bi-chat-left-text', 'Meus chamados')); ?>

    <form id="ticketForm" novalidate>
      <section class="ticket-step" id="stepDepartment">
        <h2 class="ticket-step__title"><span class="ticket-step__num">1</span>Escolha o departamento</h2>
        <div class="choice-grid" role="radiogroup" aria-label="Departamento">
          <?php foreach (SUPPORT_DEPARTMENTS as $slug => $department): ?>
            <label class="choice-card">
              <input type="radio" name="department" value="<?= e($slug) ?>">
              <span class="choice-card__icon"><i class="bi <?= e($department['icon']) ?>"></i></span>
              <span>
                <strong><?= e($department['label']) ?></strong>
                <span class="choice-card__desc"><?= e($department['description']) ?></span>
              </span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="ticket-step__error">Escolha um departamento para continuar.</div>
      </section>

      <section class="ticket-step" id="stepType" hidden>
        <h2 class="ticket-step__title"><span class="ticket-step__num">2</span><span id="stepTypeTitle">Qual é a sua solicitação?</span></h2>
        <p class="text-secondary small" id="departmentHint"></p>
        <?php foreach (SUPPORT_REQUEST_TYPES as $slug => $requestTypes): ?>
          <div class="choice-grid choice-grid--compact" data-department-panel="<?= e($slug) ?>" role="radiogroup" aria-label="Tipo de solicitação" hidden>
            <?php foreach ($requestTypes as $requestType): ?>
              <label class="choice-card">
                <input type="radio" name="type" value="<?= e($requestType) ?>">
                <span><strong><?= e($requestType) ?></strong></span>
              </label>
            <?php endforeach; ?>
            <label class="choice-card">
              <input type="radio" name="type" value="__outros">
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
              <textarea class="form-control" id="ticketDescription" rows="5" maxlength="<?= TICKET_RULES['description_max_length'] ?>"></textarea>
              <div class="invalid-feedback" id="ticketDescriptionFeedback"></div>
              <small class="d-block text-end text-secondary mt-1" id="ticketCount">0/<?= TICKET_RULES['description_max_length'] ?></small>
            </div>

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label" for="ticketFile">Anexo (opcional)</label>
                <input class="form-control" type="file" id="ticketFile" accept=".pdf,.jpg,.jpeg,.png">
                <div class="invalid-feedback">O anexo deve ter até <?= TICKET_RULES['attachment_max_mb'] ?> MB.</div>
              </div>
              <div class="col-12 col-md-6">
                <span class="form-label d-block">Como prefere ser contatado?</span>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="contact" id="contactPortal" value="Portal" checked>
                  <label class="form-check-label" for="contactPortal">Pelo portal</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="contact" id="contactEmail" value="E-mail">
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


<script id="ticketFormData" type="application/json"><?= $ticketFormData ?></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = <?= jsonForScript(studentStorageKey('tickets')) ?>;
  const OTHERS = '__outros';
  const data = readPageData('ticketFormData');
  const { departments, rules } = data;

  const $ = (id) => document.getElementById(id);
  const form = $('ticketForm');
  const departmentStep = $('stepDepartment');
  const typeStep = $('stepType');
  const detailsStep = $('stepDetails');
  const subject = $('ticketSubject');
  const description = $('ticketDescription');
  const file = $('ticketFile');
  const departmentRadios = [...form.querySelectorAll('input[name="department"]')];
  const typeRadios = [...form.querySelectorAll('input[name="type"]')];
  const panels = [...form.querySelectorAll('[data-department-panel]')];

  const checked = (radios) => radios.find((radio) => radio.checked);
  const isOthersSelected = () => checked(typeRadios)?.value === OTHERS;
  const descriptionMinLength = () => (isOthersSelected() ? rules.other_description_min_length : rules.description_min_length);
  const updateCharacterCount = () => { $('ticketCount').textContent = `${description.value.length}/${rules.description_max_length}`; };

  const setDescriptionError = (message) => {
    $('ticketDescriptionFeedback').textContent = message;
    description.classList.toggle('is-invalid', Boolean(message));
  };

  const resetForm = () => {
    form.reset();
    [typeStep, detailsStep].forEach((step) => { step.hidden = true; });
    [departmentStep, typeStep].forEach((step) => step.classList.remove('is-invalid'));
    form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
    setDescriptionError('');
    updateCharacterCount();
  };

  const showTypeStep = (departmentSlug) => {
    const department = departments[departmentSlug];
    departmentStep.classList.remove('is-invalid');
    typeRadios.forEach((type) => { type.checked = false; });
    panels.forEach((panel) => { panel.hidden = panel.dataset.departmentPanel !== departmentSlug; });
    $('stepTypeTitle').textContent = `Qual é a sua solicitação para ${department.label}?`;
    $('departmentHint').textContent = `Prazo médio de resposta: ${department.response_time}.`;
    typeStep.hidden = false;
    typeStep.classList.remove('is-invalid');
    detailsStep.hidden = true;
  };

  const showDetailsStep = (type) => {
    const department = departments[checked(departmentRadios).value];
    const others = type === OTHERS;
    typeStep.classList.remove('is-invalid');
    subject.value = others ? '' : type;
    subject.placeholder = others ? 'Resuma sua solicitação em poucas palavras' : '';
    description.placeholder = others ? 'Explique o que você precisa com o máximo de detalhes.' : 'Conte o que aconteceu e o que você espera como solução.';
    $('ticketDescriptionLabel').textContent = others ? 'Descreva sua solicitação' : 'Descrição';
    $('ticketSla').textContent = `Departamento: ${department.label} • Prazo médio de resposta: ${department.response_time}.`;
    subject.classList.remove('is-invalid');
    setDescriptionError('');
    detailsStep.hidden = false;
    (others ? subject : description).focus({ preventScroll: true });
    detailsStep.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  };

  const areStepsValid = () => {
    const department = checked(departmentRadios);
    const type = checked(typeRadios);
    departmentStep.classList.toggle('is-invalid', !department);
    typeStep.classList.toggle('is-invalid', Boolean(department) && !type);
    if (!department) departmentStep.scrollIntoView({ behavior: 'smooth', block: 'center' });
    else if (!type) typeStep.scrollIntoView({ behavior: 'smooth', block: 'center' });
    return Boolean(department && type);
  };

  const areDetailsValid = () => {
    const subjectText = subject.value.trim();
    const attachment = file.files[0];
    const subjectError = subjectText.length < rules.subject_min_length;
    const descriptionError = description.value.trim().length < descriptionMinLength();
    const fileError = Boolean(attachment) && attachment.size > rules.attachment_max_mb * 1024 * 1024;

    $('ticketSubjectFeedback').textContent = subjectText ? `O assunto precisa ter pelo menos ${rules.subject_min_length} caracteres.` : 'Informe o assunto do chamado.';
    subject.classList.toggle('is-invalid', subjectError);
    setDescriptionError(descriptionError ? `Descreva com pelo menos ${descriptionMinLength()} caracteres.` : '');
    file.classList.toggle('is-invalid', fileError);

    const firstInvalid = [[subjectError, subject], [descriptionError, description], [fileError, file]].find(([hasError]) => hasError);
    firstInvalid?.[1].focus();
    return !firstInvalid;
  };

  const nextTicketId = (storedTickets) => {
    const usedIds = [...data.ticketIds, ...storedTickets.map((ticket) => ticket.id)];
    const next = Math.max(0, ...usedIds.map((id) => Number(String(id).split('-')[2]) || 0)) + 1;
    return `CH-${portalToday().getFullYear()}-${String(next).padStart(4, '0')}`;
  };

  const ticketFromForm = (storedTickets) => {
    const now = portalNowISO();
    const type = checked(typeRadios).value;
    return {
      id: nextTicketId(storedTickets),
      department: checked(departmentRadios).value,
      type: type === OTHERS ? 'Outros' : type,
      subject: subject.value.trim(),
      description: description.value.trim(),
      attachment: file.files[0]?.name ?? null,
      contact: form.querySelector('input[name="contact"]:checked').value,
      status: data.openStatus,
      opened_at: now,
      updated_at: now,
      history: [{ at: now, author: 'Você', text: 'Chamado aberto.' }],
    };
  };

  departmentRadios.forEach((radio) => radio.addEventListener('change', () => showTypeStep(radio.value)));
  typeRadios.forEach((radio) => radio.addEventListener('change', () => showDetailsStep(radio.value)));

  description.addEventListener('input', () => {
    updateCharacterCount();
    if (description.classList.contains('is-invalid') && description.value.trim().length >= descriptionMinLength()) setDescriptionError('');
  });
  subject.addEventListener('input', () => { if (subject.value.trim().length >= rules.subject_min_length) subject.classList.remove('is-invalid'); });
  file.addEventListener('change', () => file.classList.remove('is-invalid'));

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (!areStepsValid() || !areDetailsValid()) return;

    const storedTickets = readStoredList(STORAGE_KEY);
    const ticket = ticketFromForm(storedTickets);
    if (!storeJson(STORAGE_KEY, [...storedTickets, ticket])) {
      showToast('Não foi possível registrar o chamado neste navegador.', { ok: false });
      return;
    }

    resetForm();
    window.scrollTo({ top: 0, behavior: 'smooth' });
    showToast(`Chamado ${ticket.id} aberto para ${departments[ticket.department].label}.`, { link: { href: 'meusChamados.php', label: 'Acompanhar chamado' } });
  });
});
</script>
<?php renderPageEnd(); ?>
