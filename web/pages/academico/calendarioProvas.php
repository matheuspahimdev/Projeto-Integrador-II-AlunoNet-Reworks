<?php
require_once '../../components/layout.php';
renderHead('Calendário de Provas', 'dark', '../../', false);

$avaliacoes = [
    [
        'date' => '14/10/2026',
        'day' => 'Quarta-feira',
        'short_date' => '14 OUT',
        'time' => '19:15 às 20:55',
        'subject' => 'Projeto Integrador II',
        'type' => '1ª avaliação',
        'location' => 'Sala 712 • Bloco 2',
        'mode' => 'Presencial',
        'status' => 'Próxima',
        'status_class' => 'text-bg-primary',
        'icon' => 'bi-pencil-square',
    ],
    [
        'date' => '20/10/2026',
        'day' => 'Terça-feira',
        'short_date' => '20 OUT',
        'time' => '21:10 às 22:50',
        'subject' => 'Engenharia de Requisitos',
        'type' => 'Avaliação parcial',
        'location' => 'Sala 712 • Bloco 2',
        'mode' => 'Presencial',
        'status' => 'Agendada',
        'status_class' => 'text-bg-secondary',
        'icon' => 'bi-journal-check',
    ],
    [
        'date' => '27/10/2026',
        'day' => 'Terça-feira',
        'short_date' => '27 OUT',
        'time' => '19:15 às 20:55',
        'subject' => 'Resolução Diferenciada de Problemas',
        'type' => 'Avaliação',
        'location' => 'Sala 725 • Bloco 2',
        'mode' => 'Presencial',
        'status' => 'Agendada',
        'status_class' => 'text-bg-secondary',
        'icon' => 'bi-calculator',
    ],
    [
        'date' => '03/11/2026',
        'day' => 'Terça-feira',
        'short_date' => '03 NOV',
        'time' => '19:15 às 20:55',
        'subject' => 'Empreendedorismo',
        'type' => 'Atividade avaliativa',
        'location' => 'Ambiente virtual',
        'mode' => 'Online',
        'status' => 'Agendada',
        'status_class' => 'text-bg-secondary',
        'icon' => 'bi-camera-video',
    ],
];

$totalAvaliacoes = count($avaliacoes);
$presenciais = count(array_filter($avaliacoes, static fn (array $avaliacao): bool => $avaliacao['mode'] === 'Presencial'));
$online = $totalAvaliacoes - $presenciais;
$proximaAvaliacao = $avaliacoes[0];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Calendário de Provas'); ?>

    <section class="academic-calendar-summary" aria-label="Resumo do calendário">
      <div class="academic-calendar-summary__next">
        <div class="academic-calendar-summary__icon"><i class="bi <?= $proximaAvaliacao['icon'] ?>"></i></div>
        <div>
          <span>Próxima avaliação</span>
          <strong><?= htmlspecialchars($proximaAvaliacao['subject'], ENT_QUOTES, 'UTF-8') ?></strong>
          <small><?= htmlspecialchars($proximaAvaliacao['date'], ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars($proximaAvaliacao['time'], ENT_QUOTES, 'UTF-8') ?></small>
        </div>
      </div>
      <div class="academic-calendar-summary__metrics">
        <div><span>Avaliações previstas</span><strong><?= $totalAvaliacoes ?></strong></div>
        <div><span>Presenciais</span><strong><?= $presenciais ?></strong></div>
        <div><span>Online</span><strong><?= $online ?></strong></div>
      </div>
    </section>

    <div class="academic-page-grid academic-calendar-grid">
      <section class="academic-panel academic-panel--wide">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-calendar2-check"></i></div>
          <div>
            <h2>Próximas avaliações</h2>
            <p class="academic-panel__subtitle">Acompanhe datas, horários e locais das avaliações do semestre.</p>
          </div>
        </div>
        <div class="academic-panel__body">
          <div class="academic-calendar-list">
            <?php foreach ($avaliacoes as $avaliacao): ?>
              <article class="academic-calendar-item">
                <div class="academic-calendar-item__date">
                  <strong><?= htmlspecialchars($avaliacao['short_date'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <small><?= htmlspecialchars($avaliacao['day'], ENT_QUOTES, 'UTF-8') ?></small>
                </div>
                <div class="academic-calendar-item__content">
                  <div class="academic-calendar-item__title">
                    <div>
                      <strong><?= htmlspecialchars($avaliacao['subject'], ENT_QUOTES, 'UTF-8') ?></strong>
                      <small><?= htmlspecialchars($avaliacao['type'], ENT_QUOTES, 'UTF-8') ?></small>
                    </div>
                    <span class="badge <?= htmlspecialchars($avaliacao['status_class'], ENT_QUOTES, 'UTF-8') ?>">
                      <?= htmlspecialchars($avaliacao['status'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  </div>
                  <div class="academic-calendar-item__details">
                    <span><i class="bi bi-clock"></i><?= htmlspecialchars($avaliacao['time'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span><i class="bi bi-geo-alt"></i><?= htmlspecialchars($avaliacao['location'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span><i class="bi <?= $avaliacao['mode'] === 'Online' ? 'bi-camera-video' : 'bi-building' ?>"></i><?= htmlspecialchars($avaliacao['mode'], ENT_QUOTES, 'UTF-8') ?></span>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="academic-panel">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-info-circle"></i></div>
          <div>
            <h2>Orientações</h2>
            <p class="academic-panel__subtitle">O que conferir antes da avaliação.</p>
          </div>
        </div>
        <div class="academic-panel__body">
          <div class="notice-box mb-3">
            <i class="bi bi-bell"></i>
            <span>Confira o ambiente da disciplina para acompanhar alterações de data, sala ou modalidade.</span>
          </div>
          <ul class="clean-list academic-calendar-checklist">
            <li><span>Chegar com antecedência</span><i class="bi bi-check2-circle"></i></li>
            <li><span>Levar documento acadêmico</span><i class="bi bi-check2-circle"></i></li>
            <li><span>Verificar materiais permitidos</span><i class="bi bi-check2-circle"></i></li>
            <li><span>Salvar o calendário atualizado</span><i class="bi bi-check2-circle"></i></li>
          </ul>
        </div>
      </section>
    </div>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
