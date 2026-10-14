<?php
require_once __DIR__ . '/../lib/navegacao.php';

function renderSidebar(string $assetRoot): void
{
?>
  <aside id="main-navigation" class="sidebar-nav">
    <a class="sidebar-nav__brand" href="<?= e($assetRoot) ?>index.php" aria-label="Página inicial do Alunonet">
      <img class="brand-logo brand-logo--dark-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoBranco.png" alt="UNIFIO" width="99" height="32">
      <img class="brand-logo brand-logo--light-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoAzul.png" alt="UNIFIO" width="99" height="32">
    </a>
    <nav class="sidebar-nav__content" aria-label="Navegação principal">
      <ul class="sidebar-nav__list">
        <?php foreach (NAVIGATION as $index => $item): ?>
          <?php hasSubmenu($item) ? renderNavigationGroup($item, $index, $assetRoot) : renderNavigationLink($item, $assetRoot); ?>
        <?php endforeach; ?>
      </ul>
    </nav>
  </aside>
<?php
}

function navigationLinkClasses(array $item): string
{
  $classes = ['sidebar-nav__link'];
  if ($item['accent'] ?? false) {
    $classes[] = 'sidebar-nav__link--accent';
  }
  if (isActiveSection($item)) {
    $classes[] = 'is-active';
  }

  return implode(' ', $classes);
}

function renderNavigationLink(array $item, string $assetRoot): void
{
?>
  <li class="sidebar-nav__item">
    <a class="<?= navigationLinkClasses($item) ?>" href="<?= e(linkUrl($item, $assetRoot)) ?>" <?= isCurrentPage($item) ? ' aria-current="page"' : '' ?><?= isExternalLink($item) ? ' target="_blank" rel="noopener"' : '' ?>>
      <i class="bi <?= e($item['icon']) ?>" aria-hidden="true"></i><span><?= e($item['label']) ?></span>
    </a>
  </li>
<?php
}

function renderNavigationGroup(array $item, int $index, string $assetRoot): void
{
  $isOpen = isActiveSection($item);
  $submenuId = 'nav-submenu-' . $index;
?>
  <li class="sidebar-nav__item sidebar-nav__item--expandable<?= $isOpen ? ' is-open' : '' ?>">
    <button class="<?= navigationLinkClasses($item) ?>" type="button" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" aria-controls="<?= $submenuId ?>">
      <i class="bi <?= e($item['icon']) ?>" aria-hidden="true"></i>
      <span><?= e($item['label']) ?></span>
      <i class="bi bi-chevron-down sidebar-nav__chevron" aria-hidden="true"></i>
    </button>
    <ul id="<?= $submenuId ?>" class="sidebar-nav__submenu">
      <?php foreach ($item['items'] as $subitem): ?>
        <li><a class="sidebar-nav__sublink<?= isCurrentPage($subitem) ? ' is-active' : '' ?>" href="<?= e(linkUrl($subitem, $assetRoot)) ?>" <?= isCurrentPage($subitem) ? ' aria-current="page"' : '' ?>><?= e($subitem['label']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </li>
<?php
}

function renderTopbar(): void
{
?>
  <header class="portal-topbar">
    <button class="portal-topbar__menu btn" type="button" data-sidebar-toggle aria-controls="main-navigation" aria-expanded="false" aria-label="Abrir menu de navegação">
      <i class="bi bi-list" aria-hidden="true"></i>
    </button>
    <span class="portal-topbar__title">Portal do Aluno</span>
    <div class="portal-topbar__profile">
      <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Alternar tema claro/escuro">
        <i class="bi bi-sun-fill icon-sun" aria-hidden="true"></i>
        <i class="bi bi-moon-stars-fill icon-moon" aria-hidden="true"></i>
      </button>
      <label class="visually-hidden" for="course-selector">Curso atual</label>
      <select id="course-selector" class="portal-topbar__course">
        <?php foreach (ENROLLED_COURSES as $course): ?>
          <option<?= $course === CURRENT_COURSE ? ' selected' : '' ?>><?= e($course) ?></option>
          <?php endforeach; ?>
      </select>
      <span class="portal-topbar__profile-text"><strong><?= e(STUDENT['name']) ?></strong><small>RA: <?= e(STUDENT['registration']) ?></small></span>
      <span class="portal-topbar__avatar" role="img" aria-label="Perfil de <?= e(STUDENT['name']) ?>"><?= e(studentInitials()) ?></span>
    </div>
  </header>
<?php
}