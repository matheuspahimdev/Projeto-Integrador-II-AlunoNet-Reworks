<?php
include_once 'components/layout.php';
renderHead('Página Inicial', 'dark', '');

$dashboardCards = [
    [
        'class' => 'dashboard-card--notice',
        'icon' => 'bi-exclamation-triangle-fill',
        'eyebrow' => 'Atenção',
        'title' => 'Alteração de Grade',
        'description' => 'O prazo para realizar ajustes na sua grade curricular termina em 19 de setembro.',
        'action' => 'Ajustar minha grade',
        'url' => 'pages/academico/centralAcademico.php',
        'button_class' => 'btn-warning',
    ],
    [
        'class' => 'dashboard-card--today',
        'icon' => 'bi-calendar2-week',
        'eyebrow' => 'Hoje • Quarta-feira',
        'title' => 'Projeto Integrador II',
        'description' => 'Sala 112 · Prédio 1<br><strong>19:15 às 22:50</strong>',
        'action' => 'Ver horário completo',
        'url' => 'pages/academico/horarioAulas.php',
        'button_class' => 'btn-primary',
    ],
    [
        'class' => 'dashboard-card--career',
        'icon' => 'bi-briefcase-fill',
        'eyebrow' => 'Oportunidades',
        'title' => 'Unifio Carreiras',
        'description' => 'Cadastre seu currículo e acompanhe novas oportunidades profissionais.',
        'action' => 'Acessar portal',
        'url' => '#',
        'button_class' => 'btn-outline-primary',
    ],
];

$quickAccess = [
    ['icon' => 'bi-upc-scan', 'label' => 'Boleto mensalidade', 'url' => 'pages/financeiro/centralBoleto.php'],
    ['icon' => 'bi-file-earmark-text', 'label' => 'Comprovante de matrícula', 'url' => 'pages/academico/confirmacaoMatricula.php'],
    ['icon' => 'bi-trophy', 'label' => 'Atividades complementares', 'url' => 'pages/academico/atividadesComplementares.php'],
    ['icon' => 'bi-person-vcard', 'label' => 'Carteirinha digital', 'url' => 'pages/academico/carteirinhaDigital.php'],
];
?>

<body>
  <div class="app-shell">
    <nav-bar id="main-navigation"></nav-bar>
    <div class="sidebar-backdrop" data-sidebar-backdrop></div>

    <main class="page-content">
      <portal-header></portal-header>

      <section class="dashboard-hero">
        <div class="dashboard-hero__content">
          <span class="dashboard-hero__eyebrow"><i class="bi bi-grid-1x2-fill"></i> Visão geral</span>
          <h1>Olá, Victor! <span aria-hidden="true">👋</span></h1>
          <p>Tenha uma visão rápida da sua rotina acadêmica e acesse o que precisa hoje.</p>
        </div>
        <div class="dashboard-hero__status">
          <span class="status-dot"></span>
          <div><strong>Matrícula ativa</strong><small>Engenharia de Software · 2026/2</small></div>
        </div>
      </section>

      <section class="dashboard-overview" aria-label="Resumo acadêmico">
        <div><i class="bi bi-calendar3"></i><span>Próxima avaliação<strong>14 out</strong></span></div>
        <div><i class="bi bi-award"></i><span>Média geral<strong>8,5</strong></span></div>
        <div><i class="bi bi-check2-circle"></i><span>Frequência média<strong>92%</strong></span></div>
        <a href="pages/academico/calendarioProvas.php"><span>Ver calendário<strong>acadêmico</strong></span><i class="bi bi-arrow-up-right"></i></a>
      </section>

      <section class="dashboard-section" aria-labelledby="dashboard-highlights-title">
        <div class="dashboard-section__heading">
          <div><span class="dashboard-section__eyebrow">Acompanhe sua rotina</span><h2 id="dashboard-highlights-title">Destaques do portal</h2></div>
          <a href="pages/academico/centralAcademico.php">Central acadêmica <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="grid-mesh grid-mesh--static dashboard-grid">
          <?php foreach ($dashboardCards as $card): ?>
            <article class="g-box g-col-<?= $card['class'] === 'dashboard-card--notice' ? '2' : '1' ?> dashboard-card <?= $card['class'] ?>">
              <div class="box-content">
                <span class="dashboard-card__icon"><i class="bi <?= htmlspecialchars($card['icon'], ENT_QUOTES, 'UTF-8') ?>"></i></span>
                <span class="dashboard-card__eyebrow"><?= htmlspecialchars($card['eyebrow'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="box-content__body">
                  <h3><?= htmlspecialchars($card['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                  <p><?= htmlspecialchars($card['description'], ENT_QUOTES, 'UTF-8') ?></p>
                  <a class="btn <?= htmlspecialchars($card['button_class'], ENT_QUOTES, 'UTF-8') ?> dashboard-card__action" href="<?= htmlspecialchars($card['url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($card['action'], ENT_QUOTES, 'UTF-8') ?><i class="bi bi-arrow-up-right"></i></a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="quick-access" aria-labelledby="quick-access-title">
        <div class="dashboard-section__heading">
          <div><span class="dashboard-section__eyebrow">Atalhos</span><h2 id="quick-access-title">Acesso rápido</h2></div>
        </div>
        <div class="grid-mesh grid-mesh--static quick-access__grid">
          <?php foreach ($quickAccess as $access): ?>
            <a class="g-box g-col-1 quick-access__item" href="<?= htmlspecialchars($access['url'], ENT_QUOTES, 'UTF-8') ?>">
              <i class="bi <?= htmlspecialchars($access['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
              <span><?= htmlspecialchars($access['label'], ENT_QUOTES, 'UTF-8') ?></span>
              <i class="bi bi-arrow-up-right quick-access__arrow"></i>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>

  <?php renderScripts(''); ?>
</body>
</html>