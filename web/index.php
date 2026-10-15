<?php
require_once __DIR__ . '/components/layout.php';
require_once __DIR__ . '/lib/financeiro.php';
require_once __DIR__ . '/lib/avisos.php';
require_once __DIR__ . '/lib/eventos.php';

$nextExam = upcomingExams()[0] ?? null;

/* ---------- Destaques do portal: dados ---------- */
$nextBoleto = nextInstallmentDue() ?? overdueInstallments()[0] ?? null;
$boletoVencido = $nextBoleto !== null && isInstallmentOverdue($nextBoleto);
$boletoDias = $nextBoleto
    ? (int) (new DateTimeImmutable($nextBoleto['due_date']))->diff(parseDateTime(SIMULATED_TODAY))->format('%r%a')
    : 0;

$destaqueNotices = array_slice(noticesPinnedFirst(), 0, 4);

$nextEvent = null;
foreach (calendarEvents() as $event) {
    if ($event['data'] < SIMULATED_TODAY) continue;
    if ($nextEvent === null || [$event['data'], $event['hora'] ?? ''] < [$nextEvent['data'], $nextEvent['hora'] ?? '']) {
        $nextEvent = $event;
    }
}

$todayWeekday = WEEKDAYS[(int) date('N', strtotime(SIMULATED_TODAY))];
$weekSummary = [];
foreach (WEEKLY_SCHEDULE as $weekday => $disciplineKeys) {
    $chips = [];
    foreach (array_unique($disciplineKeys) as $disciplineKey) {
        if ($disciplineKey === null) continue;
        $discipline = DISCIPLINES[$disciplineKey];
        $chips[] = ['code' => $discipline['code'], 'name' => $discipline['name'], 'room' => $discipline['room'], 'color' => $discipline['color'], 'online' => $discipline['online']];
    }
    $weekSummary[] = [
        'short' => mb_substr($weekday, 0, 3),
        'isToday' => $weekday === $todayWeekday,
        'classes' => $chips,
    ];
}

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

          <!-- Aulas: mini mostrador da semana -->
          <article class="g-box g-col-4 dashboard-card dashboard-card--schedule">
            <div class="box-content">
              <span class="dashboard-card__icon"><i class="bi bi-calendar-week"></i></span>
              <span class="dashboard-card__eyebrow">Minha semana • <?= e(STUDENT['semester']) ?></span>
              <div class="box-content__body">
                <h3>Aulas da semana</h3>
                <div class="mini-week" role="list">
                  <?php foreach ($weekSummary as $day): ?>
                    <div class="mini-week__day<?= $day['isToday'] ? ' is-today' : '' ?>" role="listitem">
                      <span class="mini-week__day-name"><?= e($day['short']) ?></span>
                      <?php foreach ($day['classes'] as $class): ?>
                        <span class="mini-week__chip schedule-cell schedule-cell--<?= e($class['color']) ?><?= $class['online'] ? ' schedule-cell--online' : '' ?>">
                          <strong><?= e($class['code']) ?></strong>
                          <span class="mini-week__chip-name"><?= e($class['name']) ?></span>
                          <small><i class="bi <?= $class['online'] ? 'bi-camera-video' : 'bi-geo-alt' ?>"></i> <?= e($class['room']) ?></small>
                        </span>
                      <?php endforeach; ?>
                      <?php if ($day['classes'] === []): ?>
                        <span class="mini-week__off">Sem aula</span>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
                <a class="btn btn-primary dashboard-card__action" href="pages/academico/horarioAulas.php">Horário completo<i class="bi bi-arrow-up-right"></i></a>
              </div>
            </div>
          </article>

          <!-- Próximo boleto -->
          <?php if ($nextBoleto !== null): ?>
          <article class="g-box g-col-1 dashboard-card<?= $boletoVencido ? ' dashboard-card--danger-accent' : ' dashboard-card--finance' ?>">
            <div class="box-content">
              <span class="dashboard-card__icon"><i class="bi bi-upc-scan"></i></span>
              <span class="dashboard-card__eyebrow">Financeiro • <?= $boletoVencido ? 'Em atraso' : 'Próximo vencimento' ?></span>
              <div class="box-content__body">
                <h3><?= e($nextBoleto['description']) ?></h3>
                <span class="dashboard-card__highlight"><?= formatCurrency($nextBoleto['value']) ?></span>
                <ul class="dashboard-card__facts">
                  <li><i class="bi <?= $boletoVencido ? 'bi-exclamation-circle-fill text-danger' : 'bi-calendar-check' ?>"></i>Vence <?= $boletoVencido ? 'u em' : 'em' ?> <?= formatDate($nextBoleto['due_date']) ?></li>
                  <li><i class="bi bi-hourglass-split"></i><?= $boletoDias === 0 ? 'Hoje' : ($boletoVencido ? "Atrasado há {$boletoDias} dia" . ($boletoDias > 1 ? 's' : '') : "Faltam {$boletoDias} dia" . ($boletoDias > 1 ? 's' : '')) ?></li>
                </ul>
                <a class="btn <?= $boletoVencido ? 'btn-danger' : 'btn-accent' ?> dashboard-card__action" href="pages/financeiro/boletoOnline.php">Ver boleto<i class="bi bi-arrow-up-right"></i></a>
              </div>
            </div>
          </article>
          <?php endif; ?>

          <!-- Próxima prova -->
          <article class="g-box g-col-1 dashboard-card dashboard-card--exam">
            <div class="box-content">
              <span class="dashboard-card__icon"><i class="bi bi-journal-check"></i></span>
              <span class="dashboard-card__eyebrow">Avaliações</span>
              <div class="box-content__body">
                <?php if ($nextExam !== null): ?>
                  <h3><?= e(DISCIPLINES[$nextExam['discipline']]['name']) ?></h3>
                  <span class="badge rounded-pill text-bg-primary mb-2"><?= e($nextExam['type']) ?></span>
                  <ul class="dashboard-card__facts">
                    <li><i class="bi bi-calendar3"></i><?= $nextExam['date'] === SIMULATED_TODAY ? 'Hoje' : formatDate($nextExam['date']) ?></li>
                    <li><i class="bi bi-clock"></i><?= e($nextExam['time']) ?></li>
                  </ul>
                  <a class="btn btn-outline-primary dashboard-card__action" href="pages/academico/calendarioProvas.php">Calendário de provas<i class="bi bi-arrow-up-right"></i></a>
                <?php else: ?>
                  <h3>Sem provas agendadas</h3>
                  <p>Aproveite para revisar as matérias.</p>
                  <a class="btn btn-outline-primary dashboard-card__action" href="pages/academico/calendarioProvas.php">Calendário de provas<i class="bi bi-arrow-up-right"></i></a>
                <?php endif; ?>
              </div>
            </div>
          </article>

          <!-- Carrossel de avisos -->
          <article class="g-box g-col-2 dashboard-card dashboard-card--news">
            <div class="box-content">
              <span class="dashboard-card__icon"><i class="bi bi-megaphone"></i></span>
              <span class="dashboard-card__eyebrow">Avisos • <?= $destaqueNotices !== [] ? count($destaqueNotices) . ' destaques' : 'nada novo' ?></span>
              <div class="box-content__body">
                <h3>Fique por dentro</h3>
                <?php if ($destaqueNotices !== []): ?>
                <div id="noticesCarousel" class="carousel slide summary-carousel" data-bs-ride="carousel" data-bs-interval="5000" aria-roledescription="carrossel" aria-label="Últimos avisos">
                  <div class="carousel-indicators">
                    <?php foreach ($destaqueNotices as $index => $aviso): ?>
                      <button type="button" data-bs-target="#noticesCarousel" data-bs-slide-to="<?= $index ?>"<?= $index === 0 ? ' class="active" aria-current="true"' : '' ?> aria-label="Aviso <?= $index + 1 ?>"></button>
                    <?php endforeach; ?>
                  </div>
                  <div class="carousel-inner">
                    <?php foreach ($destaqueNotices as $index => $aviso): ?>
                      <div class="carousel-item<?= $index === 0 ? ' active' : '' ?>"<?= $index === 0 ? '' : ' data-bs-interval="5000"' ?>>
                        <?php $prioridade = NOTICE_PRIORITIES[$aviso['prioridade']] ?? null; ?>
                        <?php if ($prioridade !== null): ?>
                          <span class="badge rounded-pill <?= e($prioridade['class']) ?> me-1"><?= e($prioridade['label']) ?></span>
                        <?php endif; ?>
                        <span class="badge rounded-pill text-bg-secondary"><?= e(NOTICE_CATEGORIES[$aviso['categoria']]['label']) ?></span>
                        <h4><?= e($aviso['titulo']) ?></h4>
                        <p><?= e(mb_strimwidth($aviso['texto'], 0, 110, '…')) ?></p>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#noticesCarousel" data-bs-slide="prev" aria-label="Aviso anterior">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#noticesCarousel" data-bs-slide="next" aria-label="Próximo aviso">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                  </button>
                </div>
                <?php else: ?>
                  <p>Nenhum aviso publicado até o momento.</p>
                <?php endif; ?>
                <a class="btn btn-outline-primary dashboard-card__action" href="pages/avisos/feedAvisos.php">Ver todos os avisos<i class="bi bi-arrow-up-right"></i></a>
              </div>
            </div>
          </article>

          <!-- Próximo evento -->
          <article class="g-box g-col-4 dashboard-card dashboard-card--event">
            <div class="box-content">
              <span class="dashboard-card__icon"><i class="bi bi-stars"></i></span>
              <span class="dashboard-card__eyebrow">Eventos</span>
              <div class="box-content__body">
                <?php if ($nextEvent !== null): ?>
                  <span class="badge rounded-pill text-bg-primary mb-2"><?= e(EVENT_CATEGORIES[$nextEvent['categoria']]['label']) ?></span>
                  <h3><?= e($nextEvent['titulo']) ?></h3>
                  <div class="dashboard-card__date">
                    <div class="dashboard-card__date-badge"><?= e(formatShortDate($nextEvent['data'])) ?></div>
                    <ul class="dashboard-card__facts">
                      <?php if ($nextEvent['data'] === SIMULATED_TODAY): ?><li><i class="bi bi-lightning-charge"></i>É hoje</li><?php endif; ?>
                      <?php if ($nextEvent['hora']): ?><li><i class="bi bi-clock"></i><?= e($nextEvent['hora']) ?></li><?php endif; ?>
                      <?php if ($nextEvent['local']): ?><li><i class="bi bi-geo-alt"></i><?= e($nextEvent['local']) ?></li><?php endif; ?>
                    </ul>
                  </div>
                <?php else: ?>
                  <h3>Sem eventos próximos</h3>
                  <p>Consulte o calendário para ver o semestre completo.</p>
                <?php endif; ?>
                <a class="btn btn-outline-primary dashboard-card__action" href="pages/eventos/calendarioEventos.php">Calendário de eventos<i class="bi bi-arrow-up-right"></i></a>
              </div>
            </div>
          </article>

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