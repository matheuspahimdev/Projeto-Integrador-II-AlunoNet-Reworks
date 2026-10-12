<?php
require_once '../../components/layout.php';
renderHead('Entrada de Requerimentos', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$curso = 'Engenharia de Software';

$acoesRapidas = [
    ['icon' => 'bi-file-earmark-text', 'title' => 'Declaração de Matrícula', 'description' => 'Emita um comprovante oficial de que você está regularmente matriculado no semestre atual.', 'attachment' => false],
    ['icon' => 'bi-book', 'title' => 'Histórico Escolar', 'description' => 'Solicite a 1ª via gratuita (por semestre) com suas notas e disciplinas concluídas.', 'attachment' => false],
    ['icon' => 'bi-activity', 'title' => 'Atestado Médico', 'description' => 'Envie um atestado para justificar faltas por motivos de saúde.', 'attachment' => true],
    ['icon' => 'bi-briefcase', 'title' => 'Passe Escolar AVOA', 'description' => 'Solicitação para o passe escolar de uso semestral.', 'attachment' => false],
];

$outrosRequerimentos = [
    'Documentos' => [
        'Declaração de Conclusão de Curso',
        'Declaração de Carga Horária',
        'Ementário das Disciplinas',
        '2ª Via da Carteirinha',
    ],
    'Vida acadêmica' => [
        'Aproveitamento de Estudos',
        'Dispensa de Disciplina',
        'Revisão de Nota',
        'Segunda Chamada de Prova',
        'Transferência de Turno',
        'Trancamento de Matrícula',
        'Cancelamento de Matrícula',
    ],
    'Estágio e formatura' => [
        'Declaração de Estágio',
        'Colação de Grau',
    ],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Entrada de Requerimentos</h1>
        <p class="text-secondary mb-0">Solicite documentos, declarações e serviços da secretaria.</p>
      </div>
    </section>

    <div class="info-banner" role="note">
      <div class="info-banner__icon"><i class="bi bi-info-circle"></i></div>
      <div>
        <strong>Informação importante</strong>
        <span>Para visualizar ou imprimir o comprovante do seu requerimento, certifique-se de que possui um leitor de PDF instalado no seu dispositivo.</span>
      </div>
    </div>

    <h2 class="section-title">Ações rápidas (mais solicitadas)</h2>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto" aria-label="Ações rápidas">
      <?php foreach ($acoesRapidas as $acao): ?>
        <article class="g-box g-col-1 grid-card request-card">
          <div class="request-card__icon"><i class="bi <?= $e($acao['icon']) ?>"></i></div>
          <h3><?= $e($acao['title']) ?></h3>
          <p><?= $e($acao['description']) ?></p>
          <button class="btn btn-outline-primary w-100" type="button" data-request="<?= $e($acao['title']) ?>" data-attachment="<?= $acao['attachment'] ? 'true' : 'false' ?>">Solicitar</button>
        </article>
      <?php endforeach; ?>
    </section>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
      <section class="g-box g-col-4 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-file-earmark-plus"></i></div>
          <div>
            <h2>Outros requerimentos</h2>
            <p class="grid-card__subtitle">Escolha o tipo de solicitação que não aparece nas ações rápidas.</p>
          </div>
        </div>
        <div class="grid-card__body">
          <form class="academic-form" id="otherRequestForm" method="post" action="" novalidate>
            <div class="row g-3 mb-3">
              <div class="col-12 col-lg-5">
                <label class="form-label" for="requestCourse">Curso selecionado</label>
                <input class="form-control" id="requestCourse" type="text" value="<?= $e($curso) ?>" disabled>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-8 col-lg-6">
                <label class="form-label" for="requestType">Selecione o tipo do requerimento</label>
                <select class="form-select" id="requestType" name="request_type" required>
                  <option value="" selected disabled>-- Selecione uma opção --</option>
                  <?php foreach ($outrosRequerimentos as $grupo => $itens): ?>
                    <optgroup label="<?= $e($grupo) ?>">
                      <?php foreach ($itens as $item): ?>
                        <option value="<?= $e($item) ?>"><?= $e($item) ?></option>
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

  </main>
</div>

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
          <div><dt>Curso</dt><dd><?= $e($curso) ?></dd></div>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="requestToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="requestToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modalEl = document.getElementById('requestModal');
  const form = document.getElementById('requestForm');
  const typeEl = document.getElementById('requestModalType');
  const attachField = document.getElementById('requestAttachmentField');
  const attachInput = document.getElementById('requestAttachment');
  const toastBody = document.getElementById('requestToastBody');
  const otherForm = document.getElementById('otherRequestForm');
  const otherSelect = document.getElementById('requestType');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('requestToast'), { delay: 5000 });
  let currentRequest = '';

  const openRequest = (name, needsAttachment = false) => {
    currentRequest = name;
    form.reset();
    form.classList.remove('was-validated');
    typeEl.textContent = name;
    attachField.classList.toggle('d-none', !needsAttachment);
    attachInput.required = needsAttachment;
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
    toastBody.textContent = `Solicitação de “${currentRequest}” enviada para a secretaria.`;
    toast.show();
    otherForm.reset();
    otherForm.classList.remove('was-validated');
  });
});
</script>

</body>
</html>
