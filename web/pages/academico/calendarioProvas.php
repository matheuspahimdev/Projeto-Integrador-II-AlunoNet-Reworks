<?php
require_once __DIR__ . '/../../components/layout.php';

$exams = upcomingExams();
$nextExam = $exams[0] ?? null;
$onlineExams = count(array_filter($exams, static fn (array $exam): bool => studentDisciplines()[$exam['discipline']]['online']));
$inPersonExams = count($exams) - $onlineExams;

renderAcademicPageStart('Calendário de Provas');
?>
      <section class="academic-calendar-summary" aria-label="Resumo do calendário">
        <div class="academic-calendar-summary__next">
          <div class="academic-calendar-summary__icon"><i class="bi <?= e($nextExam['icon'] ?? 'bi-calendar-check') ?>"></i></div>
          <div>
            <span>Próxima avaliação</span>
            <?php if ($nextExam === null): ?>
              <strong>Nenhuma avaliação agendada</strong>
            <?php else: ?>
              <strong><?= e(studentDisciplines()[$nextExam['discipline']]['name']) ?></strong>
              <small><?= formatDate($nextExam['date']) ?> • <?= e($nextExam['time']) ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="academic-calendar-summary__metrics">
          <div><span>Avaliações previstas</span><strong><?= count($exams) ?></strong></div>
          <div><span>Presenciais</span><strong><?= $inPersonExams ?></strong></div>
          <div><span>Online</span><strong><?= $onlineExams ?></strong></div>
        </div>
      </section>

      <div class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-calendar2-check', 'Próximas avaliações', 'Acompanhe datas, horários e locais das avaliações do semestre.'); ?>
          <div class="grid-card__body">
            <?php if ($exams === []): ?>
              <div class="notice-box"><i class="bi bi-info-circle"></i><span>Não há avaliações futuras no calendário.</span></div>
            <?php endif; ?>
            <div class="academic-calendar-list">
              <?php foreach ($exams as $exam): ?>
                <?php $discipline = studentDisciplines()[$exam['discipline']]; ?>
                <?php $status = examStatus($exam); ?>
                <article class="academic-calendar-item">
                  <div class="academic-calendar-item__date">
                    <strong><?= formatShortDate($exam['date']) ?></strong>
                    <small><?= e(weekdayName($exam['date'])) ?></small>
                  </div>
                  <div class="academic-calendar-item__content">
                    <div class="academic-calendar-item__title">
                      <div>
                        <strong><?= e($discipline['name']) ?></strong>
                        <small><?= e($exam['type']) ?></small>
                      </div>
                      <span class="badge <?= statusBadge($status) ?>"><?= e($status) ?></span>
                    </div>
                    <div class="academic-calendar-item__details">
                      <span><i class="bi bi-clock"></i><?= e($exam['time']) ?></span>
                      <span><i class="bi bi-geo-alt"></i><?= e($discipline['room']) ?></span>
                      <span><i class="bi <?= $discipline['online'] ? 'bi-camera-video' : 'bi-building' ?>"></i><?= $discipline['online'] ? 'Online' : 'Presencial' ?></span>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-info-circle', 'Orientações', 'O que conferir antes da avaliação.'); ?>
          <div class="grid-card__body">
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
<?php renderPageEnd(); ?>