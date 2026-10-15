<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/perfil.php';

$renderPasswordField = static function (string $id, string $label, string $autocomplete): void {
?>
  <div class="mb-3">
    <label class="form-label" for="<?= e($id) ?>"><?= e($label) ?></label>
    <div class="input-group has-validation">
      <input class="form-control" type="password" id="<?= e($id) ?>" autocomplete="<?= e($autocomplete) ?>">
      <button class="btn btn-outline-secondary" type="button" data-toggle-password="<?= e($id) ?>" aria-label="Mostrar senha" aria-pressed="false"><i class="bi bi-eye"></i></button>
      <div class="invalid-feedback" id="<?= e($id) ?>Feedback"></div>
    </div>
  </div>
<?php
};

renderPageStart('Meu Perfil');
?>

<?php renderPageHeader('Meu Perfil', 'Consulte seus dados, altere sua senha e personalize sua foto.'); ?>

    <div class="profile-layout">
      <aside class="grid-card profile-card" aria-label="Resumo do perfil">
        <div class="profile-avatar" id="profileAvatar" data-initials="<?= e(studentInitials()) ?>" aria-hidden="true"></div>
        <h2 class="profile-name"><?= e(currentStudent()['name']) ?></h2>
        <p class="profile-meta">Matrícula <?= e(currentStudent()['registration']) ?></p>
        <span class="badge rounded-pill text-bg-success"><?= e(currentStudent()['status']) ?></span>

        <div class="profile-actions">
          <button class="btn btn-primary" type="button" id="changePhoto"><i class="bi bi-camera me-2"></i>Alterar foto</button>
          <button class="btn btn-outline-secondary" type="button" id="removePhoto" hidden><i class="bi bi-trash me-2"></i>Remover foto</button>
        </div>

        <dl class="profile-facts">
          <div><dt>Curso</dt><dd><?= e(currentStudent()['course']) ?></dd></div>
          <div><dt>Período letivo</dt><dd><?= e(currentStudent()['term']) ?></dd></div>
          <div><dt>Turno</dt><dd><?= e(currentStudent()['period']) ?></dd></div>
        </dl>
      </aside>

      <div>
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tabInfoButton" data-bs-toggle="tab" data-bs-target="#tabInfo" type="button" role="tab" aria-controls="tabInfo" aria-selected="true"><i class="bi bi-person me-2"></i>Informações</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tabSecurityButton" data-bs-toggle="tab" data-bs-target="#tabSecurity" type="button" role="tab" aria-controls="tabSecurity" aria-selected="false"><i class="bi bi-shield-lock me-2"></i>Segurança</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tabPrefsButton" data-bs-toggle="tab" data-bs-target="#tabPrefs" type="button" role="tab" aria-controls="tabPrefs" aria-selected="false"><i class="bi bi-bell me-2"></i>Preferências</button>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="tabInfo" role="tabpanel" aria-labelledby="tabInfoButton" tabindex="0">
            <div class="profile-stack">
              <section class="grid-card">
                <div class="grid-card__head">
                  <div class="grid-card__icon"><i class="bi bi-mortarboard"></i></div>
                  <div><h2>Dados acadêmicos</h2></div>
                </div>
                <div class="grid-card__body">
                  <dl class="data-grid">
                    <div><dt>Matrícula</dt><dd><?= e(currentStudent()['registration']) ?></dd></div>
                    <div><dt>Curso</dt><dd><?= e(currentStudent()['course']) ?></dd></div>
                    <div><dt>Período letivo</dt><dd><?= e(currentStudent()['term']) ?></dd></div>
                    <div><dt>Turno</dt><dd><?= e(currentStudent()['period']) ?></dd></div>
                    <div><dt>Ingresso</dt><dd><?= e(currentStudent()['admission']) ?></dd></div>
                    <div><dt>Situação</dt><dd><?= e(currentStudent()['status']) ?></dd></div>
                  </dl>
                </div>
              </section>

              <section class="grid-card">
                <div class="grid-card__head">
                  <div class="grid-card__icon"><i class="bi bi-person-vcard"></i></div>
                  <div><h2>Dados pessoais</h2></div>
                  <button class="btn btn-sm btn-outline-secondary ms-auto" type="button" id="toggleSensitive" aria-pressed="false"><i class="bi bi-eye me-1"></i>Mostrar documentos</button>
                </div>
                <div class="grid-card__body">
                  <dl class="data-grid">
                    <div><dt>Nome completo</dt><dd><?= e(currentStudent()['name']) ?></dd></div>
                    <div><dt>Data de nascimento</dt><dd><?= e(currentStudent()['birth_date']) ?></dd></div>
                    <div><dt>CPF</dt><dd data-sensitive data-value="<?= e(currentStudent()['cpf']) ?>" data-mask="•••.•••.•••-••">•••.•••.•••-••</dd></div>
                    <div><dt>RG</dt><dd data-sensitive data-value="<?= e(currentStudent()['rg']) ?>" data-mask="•••••••••">•••••••••</dd></div>
                  </dl>
                </div>
              </section>

              <section class="grid-card">
                <div class="grid-card__head">
                  <div class="grid-card__icon"><i class="bi bi-geo-alt"></i></div>
                  <div><h2>Contato e endereço</h2></div>
                  <a class="btn btn-sm btn-outline-primary ms-auto" href="../academico/atualizacaoDadosCadastrais.php"><i class="bi bi-pencil me-1"></i>Atualizar dados</a>
                </div>
                <div class="grid-card__body">
                  <dl class="data-grid">
                    <div><dt>E-mail institucional</dt><dd><?= e(currentStudent()['email']) ?></dd></div>
                    <div><dt>E-mail pessoal</dt><dd><?= e(currentStudent()['alternative_email']) ?></dd></div>
                    <div><dt>Telefone</dt><dd><?= e(currentStudent()['phone']) ?></dd></div>
                    <div><dt>CEP</dt><dd><?= e(currentStudent()['zip_code']) ?></dd></div>
                    <div><dt>Endereço</dt><dd><?= e(currentStudent()['address'] . ', ' . currentStudent()['address_number'] . ' — ' . currentStudent()['city']) ?></dd></div>
                  </dl>
                </div>
              </section>
            </div>
          </div>

          <div class="tab-pane fade" id="tabSecurity" role="tabpanel" aria-labelledby="tabSecurityButton" tabindex="0">
            <div class="profile-stack">
              <section class="grid-card">
                <div class="grid-card__head">
                  <div class="grid-card__icon"><i class="bi bi-key"></i></div>
                  <div>
                    <h2>Alterar senha</h2>
                    <p class="grid-card__subtitle">Última alteração em <span id="passwordChanged"><?= e(formatDate(LAST_PASSWORD_CHANGE)) ?></span>.</p>
                  </div>
                </div>
                <div class="grid-card__body academic-form">
                  <form id="passwordForm" novalidate>
                    <div class="row">
                      <div class="col-12 col-lg-7">
                        <?php $renderPasswordField('currentPassword', 'Senha atual', 'current-password'); ?>
                        <?php $renderPasswordField('newPassword', 'Nova senha', 'new-password'); ?>

                        <div class="password-meter mb-3" aria-live="polite">
                          <div class="d-flex justify-content-between small mb-1">
                            <span class="text-secondary">Força da senha</span>
                            <strong id="strengthLabel">—</strong>
                          </div>
                          <div class="progress" role="progressbar" aria-label="Força da senha" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar" id="strengthBar" style="width: 0%"></div>
                          </div>
                          <ul class="password-rules">
                            <?php foreach (PASSWORD_RULES as $rule => $description): ?>
                              <li data-rule="<?= e($rule) ?>"><i class="bi bi-circle me-2" aria-hidden="true"></i><?= e($description) ?></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>

                        <?php $renderPasswordField('confirmPassword', 'Confirmar nova senha', 'new-password'); ?>

                        <button class="btn btn-accent px-4" type="submit"><i class="bi bi-check2-circle me-2"></i>Salvar nova senha</button>
                      </div>
                      <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                        <div class="notice-box"><i class="bi bi-shield-check"></i><span>Use uma senha que você não utiliza em outros sites e nunca a compartilhe. A equipe da instituição não pede sua senha por e-mail ou telefone.</span></div>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>
          </div>

          <div class="tab-pane fade" id="tabPrefs" role="tabpanel" aria-labelledby="tabPrefsButton" tabindex="0">
            <div class="profile-stack">
              <section class="grid-card">
                <div class="grid-card__head">
                  <div class="grid-card__icon"><i class="bi bi-bell"></i></div>
                  <div>
                    <h2>Notificações</h2>
                    <p class="grid-card__subtitle">Escolha o que você quer receber. As alterações são salvas na hora.</p>
                  </div>
                </div>
                <div class="grid-card__body">
                  <?php foreach (NOTIFICATION_PREFERENCES as $pref): ?>
                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" role="switch" id="pref-<?= e($pref['key']) ?>" data-pref="<?= e($pref['key']) ?>"<?= $pref['checked'] ? ' checked' : '' ?>>
                      <label class="form-check-label" for="pref-<?= e($pref['key']) ?>"><?= e($pref['label']) ?></label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="photoModalLabel">Foto de perfil</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center academic-form">
        <div class="profile-avatar profile-avatar--lg" id="photoPreview" aria-hidden="true"></div>
        <label class="form-label" for="photoInput">Escolha uma imagem</label>
        <input class="form-control" type="file" id="photoInput" accept="image/jpeg,image/png,image/webp">
        <div class="invalid-feedback" id="photoError"></div>
        <p class="text-secondary small mt-2 mb-0">JPG, PNG ou WebP, até 5 MB. A imagem será recortada em formato quadrado.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="savePhoto" disabled>Salvar foto</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const PHOTO_KEY = <?= jsonForScript(studentStorageKey('profile.photo')) ?>;
  const PREFERENCES_KEY = <?= jsonForScript(studentStorageKey('profile.preferences')) ?>;
  const PASSWORD_DATE_KEY = <?= jsonForScript(studentStorageKey('profile.passwordChangedAt')) ?>;
  const MAX_PHOTO_SIZE = 5 * 1024 * 1024;
  const PHOTO_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

  const $ = (id) => document.getElementById(id);
  const photoModal = bootstrap.Modal.getOrCreateInstance($('photoModal'));


  /* ---------- Foto de perfil ---------- */
  const initials = $('profileAvatar').dataset.initials;
  let photo = readStoredJson(PHOTO_KEY, null);
  let pendingPhoto = null;

  const paintAvatar = (target, source) => {
    target.replaceChildren();
    if (source) {
      const image = document.createElement('img');
      image.src = source;
      image.alt = '';
      target.append(image);
    } else {
      target.textContent = initials;
    }
  };

  const refreshAvatars = () => {
    paintAvatar($('profileAvatar'), photo);
    paintAvatar($('photoPreview'), pendingPhoto || photo);
    $('removePhoto').hidden = !photo;
  };

  const toSquareDataURL = (file) => new Promise((resolve, reject) => {
    const url = URL.createObjectURL(file);
    const image = new Image();
    image.onload = () => {
      const size = 256;
      const canvas = document.createElement('canvas');
      canvas.width = size;
      canvas.height = size;
      const context = canvas.getContext('2d');
      const side = Math.min(image.width, image.height);
      context.fillStyle = '#fff';
      context.fillRect(0, 0, size, size);
      context.drawImage(image, (image.width - side) / 2, (image.height - side) / 2, side, side, 0, 0, size, size);
      URL.revokeObjectURL(url);
      resolve(canvas.toDataURL('image/jpeg', 0.85));
    };
    image.onerror = () => { URL.revokeObjectURL(url); reject(new Error('imagem inválida')); };
    image.src = url;
  });

  const setPhotoError = (message) => {
    $('photoError').textContent = message;
    $('photoInput').classList.toggle('is-invalid', Boolean(message));
  };

  $('changePhoto').addEventListener('click', () => {
    pendingPhoto = null;
    $('photoInput').value = '';
    setPhotoError('');
    $('savePhoto').disabled = true;
    refreshAvatars();
    photoModal.show();
  });

  $('photoInput').addEventListener('change', async (event) => {
    const file = event.target.files[0];
    pendingPhoto = null;
    $('savePhoto').disabled = true;
    setPhotoError('');
    if (!file) { refreshAvatars(); return; }
    if (!PHOTO_TYPES.includes(file.type)) { setPhotoError('Formato não suportado. Use JPG, PNG ou WebP.'); refreshAvatars(); return; }
    if (file.size > MAX_PHOTO_SIZE) { setPhotoError('A imagem deve ter até 5 MB.'); refreshAvatars(); return; }
    try {
      pendingPhoto = await toSquareDataURL(file);
      $('savePhoto').disabled = false;
    } catch (error) {
      setPhotoError('Não foi possível ler a imagem. Tente outro arquivo.');
    }
    refreshAvatars();
  });

  $('savePhoto').addEventListener('click', () => {
    if (!pendingPhoto) return;
    if (!storeJson(PHOTO_KEY, pendingPhoto)) { showToast('Não foi possível salvar a foto neste navegador.', { ok: false }); return; }
    photo = pendingPhoto;
    pendingPhoto = null;
    refreshAvatars();
    photoModal.hide();
    showToast('Foto de perfil atualizada.');
  });

  $('removePhoto').addEventListener('click', () => {
    removeStored(PHOTO_KEY);
    photo = null;
    refreshAvatars();
    showToast('Foto removida.');
  });

  refreshAvatars();

  /* ---------- Documentos (mostrar/ocultar) ---------- */
  let revealed = false;
  $('toggleSensitive').addEventListener('click', (event) => {
    revealed = !revealed;
    document.querySelectorAll('[data-sensitive]').forEach((node) => {
      node.textContent = revealed ? node.dataset.value : node.dataset.mask;
    });
    const button = event.currentTarget;
    button.setAttribute('aria-pressed', String(revealed));
    button.replaceChildren();
    button.append(createIcon(`bi ${revealed ? 'bi-eye-slash' : 'bi-eye'} me-1`), document.createTextNode(revealed ? 'Ocultar documentos' : 'Mostrar documentos'));
  });

  /* ---------- Alterar senha ---------- */
  const RULES = {
    length: (value) => value.length >= 8,
    lower: (value) => /[a-z]/.test(value),
    upper: (value) => /[A-Z]/.test(value),
    number: (value) => /\d/.test(value),
    special: (value) => /[^A-Za-z0-9]/.test(value),
  };
  const LEVELS = [
    { max: 0, label: '—', className: 'bg-secondary' },
    { max: 2, label: 'Fraca', className: 'bg-danger' },
    { max: 3, label: 'Média', className: 'bg-warning' },
    { max: 4, label: 'Boa', className: 'bg-info' },
    { max: 5, label: 'Forte', className: 'bg-success' },
  ];

  const form = $('passwordForm');
  const current = $('currentPassword');
  const next = $('newPassword');
  const confirm = $('confirmPassword');

  const updateMeter = () => {
    let score = 0;
    document.querySelectorAll('[data-rule]').forEach((item) => {
      const ok = RULES[item.dataset.rule](next.value);
      if (ok) score += 1;
      item.classList.toggle('is-ok', ok);
      item.firstElementChild.className = `bi ${ok ? 'bi-check-circle-fill' : 'bi-circle'} me-2`;
    });
    const level = LEVELS.find((entry) => score <= entry.max);
    const bar = $('strengthBar');
    bar.style.width = `${(score / 5) * 100}%`;
    bar.className = `progress-bar ${level.className}`;
    bar.parentElement.setAttribute('aria-valuenow', String(Math.round((score / 5) * 100)));
    $('strengthLabel').textContent = next.value ? level.label : '—';
    return score;
  };

  const setFieldError = (input, message) => {
    $(`${input.id}Feedback`).textContent = message;
    input.classList.toggle('is-invalid', Boolean(message));
  };

  next.addEventListener('input', () => {
    updateMeter();
    if (next.classList.contains('is-invalid')) setFieldError(next, '');
  });
  current.addEventListener('input', () => setFieldError(current, ''));
  confirm.addEventListener('input', () => setFieldError(confirm, ''));

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const currentError = current.value ? '' : 'Informe sua senha atual.';
    let nextError = '';
    if (Object.values(RULES).some((rule) => !rule(next.value))) nextError = 'A nova senha não atende a todos os requisitos.';
    else if (next.value === current.value) nextError = 'A nova senha deve ser diferente da atual.';
    const confirmError = confirm.value === next.value && confirm.value ? '' : 'As senhas não coincidem.';

    setFieldError(current, currentError);
    setFieldError(next, nextError);
    setFieldError(confirm, confirmError);
    const firstInvalid = [current, next, confirm].find((input) => input.classList.contains('is-invalid'));
    if (firstInvalid) { firstInvalid.focus(); return; }

    const today = portalToday();
    storeJson(PASSWORD_DATE_KEY, toIsoDate(today));
    $('passwordChanged').textContent = formatDateBR(today);
    form.reset();
    updateMeter();
    showToast('Senha alterada com sucesso (simulação).');
  });

  const savedPasswordDate = readStoredJson(PASSWORD_DATE_KEY, null);
  if (savedPasswordDate) $('passwordChanged').textContent = formatDateBR(parseIsoDate(savedPasswordDate));
  updateMeter();

  /* ---------- Preferências ---------- */
  const preferences = readStoredJson(PREFERENCES_KEY, {});

  document.querySelectorAll('[data-pref]').forEach((input) => {
    if (input.dataset.pref in preferences) input.checked = Boolean(preferences[input.dataset.pref]);
    input.addEventListener('change', () => {
      preferences[input.dataset.pref] = input.checked;
      if (storeJson(PREFERENCES_KEY, preferences)) showToast('Preferência salva.');
      else showToast('Não foi possível salvar a preferência neste navegador.', { ok: false });
    });
  });
});
</script>
<?php renderPageEnd(); ?>
