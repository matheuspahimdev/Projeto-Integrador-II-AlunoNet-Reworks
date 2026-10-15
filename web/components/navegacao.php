<?php
require_once __DIR__ . '/../lib/navegacao.php';

function renderSidebar(string $assetRoot): void
{
?>
  <aside id="main-navigation" class="sidebar-nav">
    <nav aria-label="Navegação principal">
      <ul class="sidebar-nav__list">
        <?php foreach (NAVIGATION as $index => $item): ?>
          <?php hasSubmenu($item) ? renderNavigationGroup($item, $index, $assetRoot) : renderNavigationLink($item, $assetRoot); ?>
        <?php endforeach; ?>
        <li class="sidebar-nav__item">
          <a class="<?= navigationLinkClasses(LOGOUT_LINK, false) ?>" href="<?= e(linkUrl(LOGOUT_LINK, $assetRoot)) ?>" data-logout-confirm aria-haspopup="dialog">
            <i class="bi <?= e(LOGOUT_LINK['icon']) ?>" aria-hidden="true"></i><span><?= e(LOGOUT_LINK['label']) ?></span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>
<?php
}

// Confirmação antes de sair, no estilo do AlertDialog do shadcn/ui: só fecha pelos botões.
function renderLogoutDialog(string $assetRoot): void
{
?>
  <div class="modal fade alert-dialog" id="logoutDialog" tabindex="-1" role="alertdialog" aria-modal="true" aria-labelledby="logoutDialogTitle" aria-describedby="logoutDialogDescription" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content alert-dialog__content">
        <div class="alert-dialog__header">
          <span class="alert-dialog__icon" aria-hidden="true"><i class="bi bi-box-arrow-right"></i></span>
          <h2 class="alert-dialog__title" id="logoutDialogTitle">Deseja sair do portal?</h2>
          <p class="alert-dialog__description" id="logoutDialogDescription">Sua sessão será encerrada e você voltará para a tela de login. Informações não enviadas nesta página serão perdidas.</p>
        </div>
        <div class="alert-dialog__footer">
          <button class="btn alert-dialog__cancel" type="button" data-bs-dismiss="modal">Cancelar</button>
          <a class="btn btn-danger alert-dialog__action" href="<?= e(linkUrl(LOGOUT_LINK, $assetRoot)) ?>">Sair</a>
        </div>
      </div>
    </div>
  </div>
<?php
}

function navigationLinkClasses(array $item, bool $canBeActive = true): string
{
  $classes = ['sidebar-nav__link'];
  if ($item['accent'] ?? false) {
    $classes[] = 'sidebar-nav__link--accent';
  }
  if (isset($item['variant'])) {
    $classes[] = 'sidebar-nav__link--' . $item['variant'];
  }
  if ($canBeActive && isActiveSection($item)) {
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

function renderBreadcrumb(array $trail, string $assetRoot): void
{
  $lastIndex = count($trail) - 1;
?>
  <nav class="portal-breadcrumb" aria-label="Você está em">
    <ol class="portal-breadcrumb__list">
      <?php foreach ($trail as $index => $crumb): ?>
        <?php $isMiddle = $index > 0 && $index < $lastIndex; ?>
        <?php if ($index === 1 && $lastIndex > 1): ?>
          <li class="portal-breadcrumb__item portal-breadcrumb__ellipsis" aria-hidden="true"><i class="bi bi-three-dots"></i></li>
          <li class="portal-breadcrumb__separator portal-breadcrumb__ellipsis" role="presentation" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
        <?php endif; ?>
        <li class="portal-breadcrumb__item<?= $isMiddle ? ' portal-breadcrumb__item--middle' : '' ?>">
          <?php if ($index === $lastIndex): ?>
            <span class="portal-breadcrumb__page" aria-current="page"><?php renderBreadcrumbLabel($crumb); ?></span>
          <?php elseif (isset($crumb['href'])): ?>
            <a class="portal-breadcrumb__link" href="<?= e(linkUrl($crumb, $assetRoot)) ?>"><?php renderBreadcrumbLabel($crumb); ?></a>
          <?php else: ?>
            <span class="portal-breadcrumb__text"><?php renderBreadcrumbLabel($crumb); ?></span>
          <?php endif; ?>
        </li>
        <?php if ($index < $lastIndex): ?>
          <li class="portal-breadcrumb__separator<?= $isMiddle ? ' portal-breadcrumb__item--middle' : '' ?>" role="presentation" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ol>
  </nav>
<?php
}

function renderBreadcrumbLabel(array $crumb): void
{
  if (isset($crumb['icon'])) {
    echo '<i class="bi ' . e($crumb['icon']) . '" aria-hidden="true"></i>';
  }
  echo '<span class="portal-breadcrumb__label">' . e($crumb['label']) . '</span>';
}

function renderTopbar(string $assetRoot, string $pageTitle): void
{
?>
  <header class="portal-topbar">
    <div class="portal-topbar__start">
      <button class="portal-topbar__menu btn" type="button" data-sidebar-toggle aria-controls="main-navigation" aria-expanded="false" aria-label="Abrir menu de navegação">
        <i class="bi bi-list" aria-hidden="true"></i>
      </button>
      <a class="portal-topbar__brand" href="<?= e($assetRoot) ?>index.php" aria-label="Página inicial do Alunonet">
        <img class="brand-logo brand-logo--dark-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoBranco.png" alt="UNIFIO" width="99" height="32">
        <img class="brand-logo brand-logo--light-theme" src="<?= e($assetRoot) ?>assets/img/UnifioLogoAzul.png" alt="UNIFIO" width="99" height="32">
      </a>
    </div>
    <?php renderBreadcrumb(breadcrumbTrail($pageTitle), $assetRoot); ?>
    <label class="visually-hidden" for="course-selector">Curso atual</label>
    <select id="course-selector" class="portal-topbar__course">
      <?php foreach (currentStudent()['enrolled_courses'] as $course): ?>
        <option<?= $course === currentStudent()['current_course'] ? ' selected' : '' ?>><?= e($course) ?></option>
      <?php endforeach; ?>
    </select>
    <div class="portal-topbar__profile">
      <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Alternar tema claro/escuro">
        <i class="bi bi-sun-fill icon-sun" aria-hidden="true"></i>
        <i class="bi bi-moon-stars-fill icon-moon" aria-hidden="true"></i>
      </button>
      <span class="portal-topbar__profile-text"><strong><?= e(currentStudent()['name']) ?></strong><small>RA: <?= e(currentStudent()['registration']) ?></small></span>
      <a class="portal-topbar__avatar-link" href="<?= e(linkUrl(PROFILE_LINK, $assetRoot)) ?>" aria-label="Abrir perfil de <?= e(currentStudent()['name']) ?>" <?= isCurrentPage(PROFILE_LINK) ? ' aria-current="page"' : '' ?>>
        <span class="portal-topbar__avatar" aria-hidden="true"><?= e(studentInitials()) ?></span>
      </a>
    </div>
  </header>
<?php
}