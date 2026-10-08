<?php

if (!function_exists('renderHead')) {
    function renderHead(string $pageTitle, string $theme = 'dark', string $assetRoot = '../../', bool $loginFont = false, bool $requiresAuthentication = true): void
    {
        require_once dirname(__DIR__) . '/lib/auth.php';
        $authenticatedUser = $requiresAuthentication ? requireAuthenticatedUser() : null;
        $safeTitle = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
        $safeTheme = htmlspecialchars($theme, ENT_QUOTES, 'UTF-8');
        $safeAssetRoot = htmlspecialchars($assetRoot, ENT_QUOTES, 'UTF-8');
        ?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="<?= $safeTheme ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunonet - <?= $safeTitle ?></title>
  <?php if ($loginFont): ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <?php endif; ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $safeAssetRoot ?>assets/css/style.css">
<?php if ($requiresAuthentication): ?>
    <script>
        (() => {
            const savedTheme = localStorage.getItem('alunonet-theme');
            if (savedTheme === 'light' || savedTheme === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
            }
            document.documentElement.setAttribute('data-app-loading', 'true');
        })();
    </script>
<?php endif; ?>
<?php if ($authenticatedUser !== null): ?>
    <script>window.ALUNONET_USER = <?= json_encode($authenticatedUser, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<?php endif; ?>
</head>
        <?php
    }
}

if (!function_exists('renderScripts')) {
    function renderScripts(string $assetRoot = '../../', bool $includeComponents = true): void
    {
        $safeAssetRoot = htmlspecialchars($assetRoot, ENT_QUOTES, 'UTF-8');
        ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($includeComponents): ?>
<script src="<?= $safeAssetRoot ?>assets/js/components.js" defer></script>
<?php endif; ?>
        <?php
    }
}