<?php

function renderCardHead(string $icon, string $title, ?string $subtitle = null): void
{
?>
  <div class="grid-card__head">
    <div class="grid-card__icon"><i class="bi <?= e($icon) ?>" aria-hidden="true"></i></div>
    <div>
      <h2><?= e($title) ?></h2>
      <?php if ($subtitle !== null): ?>
        <p class="grid-card__subtitle"><?= e($subtitle) ?></p>
      <?php endif; ?>
    </div>
  </div>
<?php
}