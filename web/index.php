<?php
require_once __DIR__ . '/components/layout.php';

$todayClass = firstClassOn(SIMULATED_TODAY);
$nextExam = upcomingExams()[0];

$dashboardCards = [
    [
        'class' => 'dashboard-card--notice',
        'columns' => 2,
        'icon' => 'bi-exclamation-triangle-fill',
        'eyebrow' => 'Atenção',
        'title' => 'Alteração de Grade',
        'description' => 'O prazo para realizar ajustes na sua grade curricular termina em 16 de outubro.',
        'action' => 'Ajustar minha grade',
        'url' => 'pages/academico/centralAcademico.php',
        'button_class' => 'btn-warning',
    ],
    [
        'class' => 'dashboard-card--today',
        'columns' => 1,
        'icon' => 'bi-calendar2-week',
        'eyebrow' => 'Hoje • ' . weekdayName(SIMULATED_TODAY),
        'title' => $todayClass['discipline']['name'] ?? 'Sem aulas hoje',
        'description' => $todayClass === null
            ? 'Aproveite para revisar os conteúdos da semana.'
            : $todayClass['discipline']['room'] . ' • ' . $todayClass['start'] . ' às ' . $todayClass['end'],
        'action' => 'Ver horário completo',
        'url' => 'pages/academico/horarioAulas.php',
        'button_class' => 'btn-primary',
    ],
    [
        'class' => 'dashboard-card--career',
        'columns' => 1,
        'icon' => 'bi-briefcase-fill',
        'eyebrow' => 'Oportunidades',
        'title' => 'Unifio Carreiras',
        'description' => 'Cadastre seu currículo e acompanhe novas oportunidades profissionais.',
        'action' => 'Disponível em breve',
        'url' => null,
        'button_class' => 'btn-outline-primary',
    ],
];

$quickAccess = [
    ['icon' => 'bi-upc-scan', 'label' => 'Boleto mensalidade', 'url' => 'pages/financeiro/boletoOnline.php'],
    ['icon' => 'bi-file-earmark-text', 'label' => 'Comprovante de matrícula', 'url' => 'pages/academico/confirmacaoMatricula.php'],
    ['icon' => 'bi-trophy', 'label' => 'Atividades complementares', 'url' => 'pages/academico/atividadesComplementares.php'],
    ['icon' => 'bi-person-vcard', 'label' => 'Carteirinha digital', 'url' => 'pages/academico/carteirinhaDigital.php'],
];

renderPageStart('Página Inicial', '');
?>
      <section class="dashboard-hero">
        <div class="dashboard-hero__content">
          <span class="dashboard-hero__eyebrow"><i class="bi bi-grid-1x2-fill"></i> Visão geral</span>
          <h1>Olá, <?= e(studentFirstName()) ?>! <span aria-hidden="true">👋</span></h1>
          <p>Tenha uma visão rápida da sua rotina acadêmica e acesse o que precisa hoje.</p>
        </div>
        <div class="dashboard-hero__status">
          <span class="status-dot"></span>
          <div><strong>Matrícula ativa</strong><small><?= e(STUDENT['course']) ?> · <?= e(STUDENT['term']) ?></small></div>
        </div>
      </section>

      <section class="dashboard-overview" aria-label="Resumo acadêmico">
        <div><i class="bi bi-calendar3"></i><span>Próxima avaliação<strong><?= e(mb_strtolower(formatShortDate($nextExam['date']))) ?></strong></span></div>
        <div><i class="bi bi-award"></i><span>Média geral<strong><?= e(formatGrade(overallAverage())) ?></strong></span></div>
        <div><i class="bi bi-check2-circle"></i><span>Frequência média<strong><?= overallAttendance() ?>%</strong></span></div>
        <a href="pages/academico/calendarioProvas.php"><span>Ver calendário<strong>acadêmico</strong></span><i class="bi bi-arrow-up-right"></i></a>
      </section>

      <section class="dashboard-section" aria-labelledby="dashboard-highlights-title">
        <div class="dashboard-section__heading">
          <div><span class="dashboard-section__eyebrow">Acompanhe sua rotina</span><h2 id="dashboard-highlights-title">Destaques do portal</h2></div>
          <a href="pages/academico/centralAcademico.php">Central acadêmica <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="grid-mesh grid-mesh--static dashboard-grid">
          <?php foreach ($dashboardCards as $card): ?>
            <article class="g-box g-col-<?= $card['columns'] ?> dashboard-card <?= e($card['class']) ?>">
              <div class="box-content">
                <span class="dashboard-card__icon"><i class="bi <?= e($card['icon']) ?>"></i></span>
                <span class="dashboard-card__eyebrow"><?= e($card['eyebrow']) ?></span>
                <div class="box-content__body">
                  <h3><?= e($card['title']) ?></h3>
                  <p><?= e($card['description']) ?></p>
                  <?php if ($card['url'] === null): ?>
                    <span class="btn <?= e($card['button_class']) ?> dashboard-card__action disabled" aria-disabled="true"><?= e($card['action']) ?></span>
                  <?php else: ?>
                    <a class="btn <?= e($card['button_class']) ?> dashboard-card__action" href="<?= e($card['url']) ?>"><?= e($card['action']) ?><i class="bi bi-arrow-up-right"></i></a>
                  <?php endif; ?>
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
            <a class="g-box g-col-1 quick-access__item" href="<?= e($access['url']) ?>">
              <i class="bi <?= e($access['icon']) ?>"></i>
              <span><?= e($access['label']) ?></span>
              <i class="bi bi-arrow-up-right quick-access__arrow"></i>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
<?php renderPageEnd(''); ?>