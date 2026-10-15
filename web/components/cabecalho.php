<?php

function renderPageHeader(string $title, string $subtitle, ?callable $renderActions = null, string $extraClass = ''): void
{
?>
  <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3<?= $extraClass === '' ? '' : ' ' . e($extraClass) ?>">
    <div>
      <h1 class="display-6"><?= e($title) ?></h1>
      <p class="text-secondary mb-0"><?= e($subtitle) ?></p>
    </div>
    <?php if ($renderActions !== null): ?>
      <div class="d-flex flex-wrap align-items-center gap-2">
        <?php $renderActions(); ?>
      </div>
    <?php endif; ?>
  </section>
<?php
}

function renderAcademicHeader(string $title): void
{
  renderPageHeader(
    $title,
    'Central Acadêmica • ' . currentStudent()['course'] . ' • ' . currentStudent()['term'],
    static fn() => renderActionLink('centralAcademico.php', 'bi-arrow-left', 'Central Acadêmica'),
  );
}

function renderActionLink(string $href, string $icon, string $label, string $variant = 'btn-outline-primary'): void
{
?>
  <a class="btn <?= e($variant) ?>" href="<?= e($href) ?>"><i class="bi <?= e($icon) ?> me-2" aria-hidden="true"></i><?= e($label) ?></a>
<?php
}

function renderActionButton(string $id, string $icon, string $label): void
{
?>
  <button class="btn btn-outline-primary" type="button" id="<?= e($id) ?>"><i class="bi <?= e($icon) ?> me-2" aria-hidden="true"></i><?= e($label) ?></button>
<?php
}

// Abre a impressão do navegador com o nome de arquivo sugerido para "Salvar como PDF".
function renderPrintButton(string $icon, string $label, string $documentName): void
{
?>
  <button class="btn btn-primary" type="button" data-print-title="<?= e($documentName) ?>" title="Na janela de impressão, escolha “Salvar como PDF”"><i class="bi <?= e($icon) ?> me-2" aria-hidden="true"></i><?= e($label) ?></button>
<?php
}
