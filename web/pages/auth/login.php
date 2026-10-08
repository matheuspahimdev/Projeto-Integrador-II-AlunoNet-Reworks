<?php
require_once '../../lib/auth.php';
require_once '../../components/layout.php';
$authError = consumeAuthError();
renderHead('Acesso', 'light', '../../', true, false);
?>
<body class="login-page">
    <main class="login-shell">
        <section class="login-panel" aria-labelledby="login-title">
            <header class="login-header">
                <a class="login-brand" href="../../index.php" aria-label="Alunonet - página inicial">
                    <img src="../../assets/img/UnifioLogoAzul.png" alt="Unifio">
                </a>
                <span class="login-status"><i class="bi bi-shield-check" aria-hidden="true"></i> Ambiente seguro</span>
            </header>

            <div class="login-content">
                <p class="login-eyebrow">Portal do aluno</p>
                <h1 id="login-title">Bem-vindo de volta.</h1>
                <p class="login-lead">Acesse sua jornada acadêmica em um só lugar.</p>

                <?php if ($authError !== null): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 small" role="alert">
                        <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                        <span><?= htmlspecialchars($authError['message'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                <?php endif; ?>

                <form class="login-form" action="../../lib/users/login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label" for="registration">Matrícula</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text" aria-hidden="true"><i class="bi bi-person-badge"></i></span>
                            <input class="form-control" id="registration" name="registration" type="text" inputmode="numeric" autocomplete="username" placeholder="Digite sua matrícula" value="<?= htmlspecialchars($authError['registration'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <label class="form-label" for="password">Senha</label>
                            <a class="login-link login-link--small" href="#">Esqueci minha senha</a>
                        </div>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text" aria-hidden="true"><i class="bi bi-lock"></i></span>
                            <input class="form-control" id="password" name="password" type="password" autocomplete="current-password" placeholder="Digite sua senha" required>
                            <button class="btn login-password-toggle" type="button" data-password-toggle aria-label="Mostrar senha" aria-pressed="false">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-check login-remember">
                        <input class="form-check-input" id="remember" type="checkbox" name="remember">
                        <label class="form-check-label" for="remember">Lembrar de mim neste dispositivo</label>
                    </div>

                    <button class="btn btn-primary btn-lg w-100 login-submit" type="submit">
                        Entrar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <div class="login-help">
                    <i class="bi bi-headset" aria-hidden="true"></i>
                    <span>Precisa de ajuda? <a class="login-link" href="#">Fale com o suporte</a></span>
                </div>
            </div>

            <footer class="login-footer">© 2026 Unifio · Alunonet</footer>
        </section>

        <aside class="login-showcase" aria-label="Recursos do Alunonet">
            <div class="login-showcase__pattern" aria-hidden="true"></div>
            <img class="login-showcase__logo" src="../../assets/img/UnifioLogoBranco.png" alt="Unifio">
            <div class="login-showcase__content">
                <span class="login-showcase__badge"><i class="bi bi-stars" aria-hidden="true"></i> Sua vida acadêmica, simplificada</span>
                <h2>Mais clareza para você chegar mais longe.</h2>
                <p>Notas, horários, documentos e tudo o que importa para sua jornada acadêmica, sempre por perto.</p>
                <div class="login-showcase__metrics" aria-label="Benefícios do portal">
                    <span><strong><i class="bi bi-lightning-charge-fill" aria-hidden="true"></i></strong> Acesso rápido</span>
                    <span><strong><i class="bi bi-phone" aria-hidden="true"></i></strong> De qualquer lugar</span>
                </div>
            </div>
            <div class="login-showcase__orb login-showcase__orb--one" aria-hidden="true"></div>
            <div class="login-showcase__orb login-showcase__orb--two" aria-hidden="true"></div>
        </aside>
    </main>

    <script>
        const passwordToggle = document.querySelector('[data-password-toggle]');
        const passwordInput = document.querySelector('#password');

        passwordToggle?.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            passwordToggle.setAttribute('aria-label', isPassword ? 'Ocultar senha' : 'Mostrar senha');
            passwordToggle.setAttribute('aria-pressed', String(isPassword));
            passwordToggle.querySelector('i').className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
</body>
</html>