<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/autenticacao.php';

$assetRoot = '../../';
$registration = '';
$errors = [];

if (loggedStudent() !== null) {
  redirectTo('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $registration = normalizeRegistration(postedText('registration'));
  $errors = login($registration, postedText('password'));

  if (!$errors) {
    redirectTo('index.php');
  }
}

$alertMessage = $errors['credentials'] ?? LOGIN_MESSAGES['invalid_fields'];
$fieldClass = static fn (string $field): string => isset($errors[$field]) ? ' is-invalid' : '';

renderDocumentHead('Entrar', $assetRoot);
?>
  <body class="login-page">
    <a class="visually-hidden-focusable skip-link" href="#registration">Pular para o formulário de acesso</a>

    <header class="login-topbar">
      <a class="login-topbar__brand" href="<?= e(INSTITUTIONAL_SITE_URL) ?>" target="_blank" rel="noopener" aria-label="Site da UNIFIO (abre em nova aba)">
        <img class="brand-logo brand-logo--dark-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoBranco.png" alt="UNIFIO" width="99" height="32">
        <img class="brand-logo brand-logo--light-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoAzul.png" alt="UNIFIO" width="99" height="32">
      </a>
      <span class="login-topbar__tag"><i class="bi bi-mortarboard" aria-hidden="true"></i> Portal do Aluno</span>
      <nav class="login-topbar__actions" aria-label="Links institucionais">
        <a class="login-topbar__link" href="<?= e(INSTITUTIONAL_SITE_URL) ?>" target="_blank" rel="noopener">Site institucional <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
        <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Alternar tema claro/escuro">
          <i class="bi bi-sun-fill icon-sun" aria-hidden="true"></i>
          <i class="bi bi-moon-stars-fill icon-moon" aria-hidden="true"></i>
        </button>
      </nav>
    </header>

    <main class="login-shell">
      <section class="login-hero" aria-labelledby="loginHeroTitle">
        <h1 id="loginHeroTitle">Sua vida acadêmica <span>em um só lugar.</span></h1>
        <p class="login-hero__lead">Notas, frequência, horários, boletos e requerimentos da UNIFIO reunidos no Alunonet.</p>

        <div class="login-moodle">
          <span class="login-moodle__icon" aria-hidden="true"><i class="bi bi-easel2"></i></span>
          <div class="login-moodle__text">
            <p class="login-moodle__eyebrow">Ambiente virtual · AVA</p>
            <h2>Acessar o Moodle</h2>
            <p>Salas de aula online, atividades e materiais didáticos.</p>
          </div>
          <a class="btn login-moodle__button" href="<?= e(MOODLE_URL) ?>" target="_blank" rel="noopener">Ir para o AVA <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
        </div>

        <ul class="login-hero__list">
          <?php foreach (LOGIN_HIGHLIGHTS as $highlight): ?>
            <li><i class="bi <?= e($highlight['icon']) ?>" aria-hidden="true"></i><?= e($highlight['text']) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>

      <section class="login-card" aria-labelledby="loginTitle">
        <h2 id="loginTitle" class="login-card__title">Entrar no portal</h2>
        <p class="login-card__subtitle">Informe sua matrícula e senha para continuar.</p>

        <div class="alert alert-danger login-card__alert" id="loginAlert" role="alert"<?= $errors ? '' : ' hidden' ?>>
          <i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i>
          <span id="loginAlertMessage"><?= e($alertMessage) ?></span>
        </div>

        <form class="login-form" method="post" novalidate data-login-form>
          <div class="mb-3">
            <label class="form-label" for="registration">Matrícula</label>
            <div class="login-field">
              <i class="bi bi-person-badge" aria-hidden="true"></i>
              <input class="form-control<?= $fieldClass('registration') ?>" type="text" id="registration" name="registration" value="<?= e($registration) ?>" inputmode="numeric" autocomplete="username" maxlength="10" pattern="<?= e(REGISTRATION_PATTERN) ?>" placeholder="Ex.: 274769" required autofocus aria-describedby="registrationFeedback">
              <div class="invalid-feedback" id="registrationFeedback"><?= e($errors['registration'] ?? '') ?></div>
            </div>
          </div>

          <div class="mb-2">
            <div class="login-form__label-row">
              <label class="form-label" for="password">Senha</label>
              <a href="#" class="login-form__link">Esqueci minha senha</a>
            </div>
            <div class="login-field">
              <i class="bi bi-lock" aria-hidden="true"></i>
              <input class="form-control<?= $fieldClass('password') ?>" type="password" id="password" name="password" autocomplete="current-password" placeholder="Digite sua senha" required aria-describedby="passwordFeedback">
              <button class="login-field__toggle" type="button" data-toggle-password="password" aria-label="Mostrar senha" aria-pressed="false"><i class="bi bi-eye" aria-hidden="true"></i></button>
              <div class="invalid-feedback" id="passwordFeedback"><?= e($errors['password'] ?? '') ?></div>
            </div>
            <p class="login-form__caps" id="capsLockWarning" hidden><i class="bi bi-capslock-fill" aria-hidden="true"></i> Caps Lock está ativado.</p>
          </div>

          <div class="login-form__options">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" name="remember">
              <label class="form-check-label" for="remember">Lembrar matrícula</label>
            </div>
            <a href="#" class="login-form__link login-form__link--muted">Primeiro acesso?</a>
          </div>

          <button class="btn btn-primary login-form__submit" type="submit">
            <span>Acessar Portal do Aluno</span><i class="bi bi-arrow-right" aria-hidden="true"></i>
          </button>
        </form>

        <div class="login-card__help">
          <a class="btn login-card__help-button" href="#"><i class="bi bi-headset" aria-hidden="true"></i> Suporte ao aluno</a>
          <a class="btn login-card__help-button" href="#"><i class="bi bi-question-circle" aria-hidden="true"></i> Como acessar?</a>
        </div>
      </section>
    </main>

    <footer class="login-footer">
      <span><strong>UNIFIO</strong> · Centro Universitário de Ourinhos</span>
      <nav aria-label="Informações legais">
        <a href="#">Termos de uso</a>
        <a href="#">Privacidade (LGPD)</a>
      </nav>
    </footer>

    <script src="<?= e($assetRoot) ?>assets/js/components.js" defer></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const REMEMBER_KEY = 'alunonet-login-registration';
        const MESSAGES = <?= jsonForScript(LOGIN_MESSAGES) ?>;
        const REGISTRATION_REGEX = new RegExp(<?= jsonForScript('^' . REGISTRATION_PATTERN . '$') ?>);
        const form = document.querySelector('[data-login-form]');
        const registration = document.getElementById('registration');
        const password = document.getElementById('password');
        const remember = document.getElementById('remember');
        const alertBox = document.getElementById('loginAlert');

        const savedRegistration = readStoredJson(REMEMBER_KEY, null);
        if (savedRegistration && !registration.value) {
          registration.value = savedRegistration;
          remember.checked = true;
          password.focus();
        }

        registration.addEventListener('input', () => {
          registration.value = registration.value.replace(/\D/g, '');
        });

        const setFieldError = (input, message) => {
          input.classList.toggle('is-invalid', Boolean(message));
          document.getElementById(`${input.id}Feedback`).textContent = message;
        };

        [registration, password].forEach((input) => input.addEventListener('input', () => {
          setFieldError(input, '');
          if (!registration.classList.contains('is-invalid') && !password.classList.contains('is-invalid')) alertBox.hidden = true;
        }));

        password.addEventListener('keyup', (event) => {
          document.getElementById('capsLockWarning').hidden = !event.getModifierState?.('CapsLock');
        });

        form.addEventListener('submit', (event) => {
          const registrationError = !registration.value ? MESSAGES.registration_required
            : REGISTRATION_REGEX.test(registration.value) ? '' : MESSAGES.registration_invalid;
          const passwordError = password.value ? '' : MESSAGES.password_required;

          setFieldError(registration, registrationError);
          setFieldError(password, passwordError);

          const firstInvalid = [registration, password].find((input) => input.classList.contains('is-invalid'));
          document.getElementById('loginAlertMessage').textContent = MESSAGES.invalid_fields;
          alertBox.hidden = !firstInvalid;
          if (firstInvalid) {
            event.preventDefault();
            firstInvalid.focus();
            return;
          }

          if (remember.checked) storeJson(REMEMBER_KEY, registration.value);
          else removeStored(REMEMBER_KEY);
          const submit = form.querySelector('[type="submit"]');
          submit.classList.add('is-loading');
          submit.querySelector('span').textContent = 'Acessando…';
          submit.querySelector('i').className = 'bi bi-arrow-repeat';
        });
      });
    </script>
  </body>

  </html>