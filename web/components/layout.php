<?php
require_once __DIR__ . '/../lib/academico.php';
require_once __DIR__ . '/cabecalho.php';

function e(string|int|float $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function renderPageStart(string $pageTitle, string $assetRoot = '../../'): void
{
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunonet - <?= e($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= e($assetRoot) ?>assets/css/style.css">
  <script>
    (() => {
      const LOADING_TIMEOUT_MS = 3000;
      const root = document.documentElement;
      const readSavedTheme = () => {
        try {
          return localStorage.getItem('alunonet-theme');
        } catch {
          return null;
        }
      };

      const savedTheme = readSavedTheme();
      if (savedTheme === 'light' || savedTheme === 'dark') {
        root.setAttribute('data-bs-theme', savedTheme);
      }
      root.setAttribute('data-app-loading', 'true');
      setTimeout(() => root.removeAttribute('data-app-loading'), LOADING_TIMEOUT_MS);
    })();
  </script>
</head>
<body>
  <div class="app-shell">
    <nav-bar id="main-navigation"></nav-bar>
    <div class="sidebar-backdrop" data-sidebar-backdrop></div>
    <main class="page-content">
      <portal-header
        data-name="<?= e(STUDENT['name']) ?>"
        data-registration="<?= e(STUDENT['registration']) ?>"
        data-initials="<?= e(studentInitials()) ?>"></portal-header>
<?php
}

function renderPageEnd(string $assetRoot = '../../'): void
{
?>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= e($assetRoot) ?>assets/js/components.js" defer></script>
</body>
</html>
<?php
}