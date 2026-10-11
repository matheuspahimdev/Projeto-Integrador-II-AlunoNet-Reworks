<?php

function renderPageHeader(string $title, string $subtitle): void
{
?>
      <section class="hero-header-pages">
        <h1 class="display-6"><?= e($title) ?></h1>
        <p class="text-secondary mb-0"><?= e($subtitle) ?></p>
      </section>
<?php
}

function renderAcademicHeader(string $title): void
{
?>
      <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="display-6"><?= e($title) ?></h1>
          <p class="text-secondary mb-0">Central Acadêmica • <?= e(STUDENT['course']) ?> • <?= e(STUDENT['term']) ?></p>
        </div>
        <a class="btn btn-outline-primary" href="centralAcademico.php"><i class="bi bi-arrow-left me-1"></i>Central Acadêmica</a>
      </section>
<?php
}

function renderUnderConstruction(string $icon, string $description): void
{
?>
      <section class="academic-panel under-construction">
        <div class="under-construction__icon"><i class="bi <?= e($icon) ?>"></i></div>
        <h2>Em construção</h2>
        <p><?= e($description) ?></p>
        <a class="btn btn-primary" href="../../index.php"><i class="bi bi-house-door me-1"></i>Voltar ao início</a>
      </section>
<?php
}