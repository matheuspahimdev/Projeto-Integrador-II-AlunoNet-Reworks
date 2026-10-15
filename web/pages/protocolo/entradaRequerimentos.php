<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/protocolo.php';

$course = currentStudent()['course'];
renderPageStart('Entrada de Requerimentos');
?>

<?php renderPageHeader('Entrada de Requerimentos', 'Solicite documentos, declarações e serviços da secretaria.'); ?>

    <div class="info-banner" role="note">
      <div class="info-banner__icon"><i class="bi bi-info-circle"></i></div>
      <div>
        <strong>Informação importante</strong>
        <span>Para visualizar ou imprimir o comprovante do seu requerimento, certifique-se de que possui um leitor de PDF instalado no seu dispositivo.</span>
      </div>
    </div>

    <h2 class="section-title">Ações rápidas (mais solicitadas)</h2>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto" aria-label="Ações rápidas">
      <?php foreach (QUICK_REQUESTS as $quickRequest): ?>
        <article class="g-box g-col-1 grid-card request-card">
          <div class="request-card__icon"><i class="bi <?= e($quickRequest['icon']) ?>"></i></div>
          <h3><?= e($quickRequest['title']) ?></h3>
          <p><?= e($quickRequest['description']) ?></p>
          <button class="btn btn-outline-primary w-100" type="button" data-request="<?= e($quickRequest['title']) ?>" data-attachment="<?= $quickRequest['attachment'] ? 'true' : 'false' ?>">Solicitar</button>
        </article>
      <?php endforeach; ?>
    </section>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
      <section class="g-box g-col-4 grid-card">
        <?php renderCardHead('bi-file-earmark-plus', 'Outros requerimentos', 'Escolha o tipo de solicitação que não aparece nas ações rápidas.'); ?>
        <div class="grid-card__body">
          <form class="academic-form" id="otherRequestForm" method="post" action="" novalidate>
            <div class="row g-3 mb-3">
              <div class="col-12 col-lg-5">
                <label class="form-label" for="requestCourse">Curso selecionado</label>
                <input class="form-control" id="requestCourse" type="text" value="<?= e($course) ?>" disabled>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-8 col-lg-6">
                <label class="form-label" for="requestType">Selecione o tipo do requerimento</label>
                <select class="form-select" id="requestType" name="request_type" required>
                  <option value="" selected disabled>-- Selecione uma opção --</option>
                  <?php foreach (OTHER_REQUESTS as $group => $requestTypes): ?>
                    <optgroup label="<?= e($group) ?>">
                      <?php foreach ($requestTypes as $requestType): ?>
                        <option value="<?= e($requestType) ?>"><?= e($requestType) ?></option>
                      <?php endforeach; ?>
                    </optgroup>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Selecione o tipo do requerimento para continuar.</div>
              </div>
              <div class="col-12 col-md-auto">
                <div class="form-label mb-0 d-none d-md-block" aria-hidden="true">&nbsp;</div>
                <button class="btn btn-accent w-100" type="submit">Prosseguir solicitação</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </section>


<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content academic-form" id="requestForm" novalidate>
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="requestModalLabel">Confirmar solicitação</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <dl class="data-grid data-grid--single mb-3">
          <div><dt>Requerimento</dt><dd id="requestModalType"></dd></div>
          <div><dt>Curso</dt><dd><?= e($course) ?></dd></div>
        </dl>
        <div class="mb-3 d-none" id="requestAttachmentField">
          <label class="form-label" for="requestAttachment">Anexar atestado (PDF, JPG ou PNG)</label>
          <input class="form-control" type="file" id="requestAttachment" accept=".pdf,.jpg,.jpeg,.png">
          <div class="invalid-feedback">Anexe o atestado para continuar.</div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="requestNotes">Observações (opcional)</label>
          <textarea class="form-control" id="requestNotes" rows="3" maxlength="500"></textarea>
        </div>
        <div class="notice-box"><i class="bi bi-info-circle"></i><span>Nesta versão de protótipo, o envio é simulado. Com o backend integrado, a solicitação seguirá para análise da secretaria.</span></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Enviar solicitação</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('requestForm');
  const requestTypeLabel = document.getElementById('requestModalType');
  const attachmentField = document.getElementById('requestAttachmentField');
  const attachmentInput = document.getElementById('requestAttachment');
  const otherForm = document.getElementById('otherRequestForm');
  const otherSelect = document.getElementById('requestType');
  const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('requestModal'));
  let currentRequest = '';

  const openRequest = (name, needsAttachment = false) => {
    currentRequest = name;
    form.reset();
    form.classList.remove('was-validated');
    requestTypeLabel.textContent = name;
    attachmentField.classList.toggle('d-none', !needsAttachment);
    attachmentInput.required = needsAttachment;
    modal.show();
  };

  document.querySelectorAll('[data-request]').forEach((button) => {
    button.addEventListener('click', () => openRequest(button.dataset.request, button.dataset.attachment === 'true'));
  });

  otherForm.addEventListener('submit', (event) => {
    event.preventDefault();
    otherForm.classList.add('was-validated');
    if (!otherForm.checkValidity()) return;
    openRequest(otherSelect.value);
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    form.classList.add('was-validated');
    if (!form.checkValidity()) return;
    modal.hide();
    showToast(`Solicitação de “${currentRequest}” enviada para a secretaria.`);
    otherForm.reset();
    otherForm.classList.remove('was-validated');
  });
});
</script>
<?php renderPageEnd(); ?>