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
    'Central Acadêmica • ' . STUDENT['course'] . ' • ' . STUDENT['term'],
    static fn() => renderActionLink('centralAcademico.php', 'bi-arrow-left', 'Central Acadêmica'),
  );
}

function renderActionLink(string $href, string $icon, string $label, string $variant = 'btn-outline-primary'): void
{
?>
  <a class="btn <?= e($variant) ?>" href="<?= e($href) ?>"><i class="bi <?= e($icon) ?> me-2" aria-hidden="true"></i><?= e($label) ?></a>
<?php
}

function renderActionButton(string $id, string $icon, string $label, string $variant = 'btn-outline-primary', string $hint = ''): void
{
?>
  <button class="btn <?= e($variant) ?>" type="button" id="<?= e($id) ?>" <?= $hint === '' ? '' : ' title="' . e($hint) . '"' ?>><i class="bi <?= e($icon) ?> me-2" aria-hidden="true"></i><?= e($label) ?></button>
<?php
}

function renderUnderConstruction(string $icon, string $description): void
{
?>
  <section class="grid-card under-construction">
    <div class="under-construction__icon"><i class="bi <?= e($icon) ?>" aria-hidden="true"></i></div>
    <h2>Em construção</h2>
    <p><?= e($description) ?></p>
    <a class="btn btn-primary" href="../../index.php"><i class="bi bi-house-door me-1" aria-hidden="true"></i>Voltar ao início</a>
  </section>
<?php
}