<?php
require_once __DIR__ . '/../../components/layout.php';

$exams = upcomingExams();
$nextExam = $exams[0];
$nextExamDiscipline = DISCIPLINES[$nextExam['discipline']];
$onlineExams = count(array_filter($exams, static fn (array $exam): bool => DISCIPLINES[$exam['discipline']]['online']));
$inPersonExams = count($exams) - $onlineExams;

renderPageStart('Calendário de Provas');
renderAcademicHeader('Calendário de Provas');
?>
      <section class="academic-calendar-summary" aria-label="Resumo do calendário">
        <div class="academic-calendar-summary__next">
          <div class="academic-calendar-summary__icon"><i class="bi <?= e($nextExam['icon']) ?>"></i></div>
          <div>
            <span>Próxima avaliação</span>
            <strong><?= e($nextExamDiscipline['name']) ?></strong>
            <small><?= formatDate($nextExam['date']) ?> • <?= e($nextExam['time']) ?></small>
          </div>
        </div>
        <div class="academic-calendar-summary__metrics">
          <div><span>Avaliações previstas</span><strong><?= count($exams) ?></strong></div>
          <div><span>Presenciais</span><strong><?= $inPersonExams ?></strong></div>
          <div><span>Online</span><strong><?= $onlineExams ?></strong></div>
        </div>
      </section>

      <div class="academic-page-grid">
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
              <?php foreach ($exams as $exam): ?>
                <?php $discipline = DISCIPLINES[$exam['discipline']]; ?>
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
<?php renderPageEnd(); ?>