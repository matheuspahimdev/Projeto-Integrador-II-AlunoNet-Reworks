<?php
require_once __DIR__ . '/../lib/autenticacao.php';
require_once __DIR__ . '/../lib/academico.php';
require_once __DIR__ . '/navegacao.php';
require_once __DIR__ . '/cabecalho.php';
require_once __DIR__ . '/cartao.php';

function e(string|int|float $value): string
{
  return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// JSON seguro para colocar dentro de <script>, inclusive como valor literal no JS.
function jsonForScript(mixed $data): string
{
  return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function renderPageStart(string $pageTitle, string $assetRoot = '../../'): void
{
  requireLogin();
  renderDocumentHead($pageTitle, $assetRoot);
?>
  <body>
    <a class="visually-hidden-focusable skip-link" href="#conteudo">Pular para o conteúdo</a>
    <div class="app-shell">
      <?php renderTopbar($assetRoot, $pageTitle); ?>
      <?php renderSidebar($assetRoot); ?>
      <div class="sidebar-backdrop" data-sidebar-backdrop></div>
      <main id="conteudo" class="page-content" tabindex="-1">
<?php
}

function renderAcademicPageStart(string $pageTitle): void
{
  renderPageStart($pageTitle);
  renderAcademicHeader($pageTitle);
}

function renderDocumentHead(string $pageTitle, string $assetRoot): void
{
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark" data-today="<?= e(SIMULATED_TODAY) ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunonet - <?= e($pageTitle) ?></title>
  <meta name="description" content="Portal do Aluno UNIFIO: notas, faltas, financeiro, requerimentos e serviços acadêmicos.">
  <meta name="theme-color" content="#1B468E">
  <script>
    (() => {
      try {
        const savedTheme = localStorage.getItem('alunonet-theme');
        if (savedTheme === 'light' || savedTheme === 'dark') {
          document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
      } catch {
        return;
      }
    })();
  </script>
  <link rel="icon" href="<?= e($assetRoot) ?>assets/icons/favicon.ico" sizes="any">
  <link rel="icon" href="<?= e($assetRoot) ?>assets/icons/favicon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= e($assetRoot) ?>assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="<?= e($assetRoot) ?>assets/icons/site.webmanifest">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= e($assetRoot) ?>assets/css/style.css">
</head>

<?php
}

// Toast único da página, usado pelo showToast() de components.js.
function renderPageToast(): void
{
?>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="pageToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="pageToastBody"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
      </div>
    </div>
  </div>
<?php
}

function renderPageEnd(string $assetRoot = '../../'): void
{
?>
      </main>
    </div>
    <?php renderLogoutDialog($assetRoot); ?>
    <?php renderPageToast(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= e($assetRoot) ?>assets/js/components.js" defer></script>
  </body>

</html>
<?php
}
