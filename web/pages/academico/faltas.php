<?php
require_once __DIR__ . '/../../components/layout.php';

$totalAttended = array_sum(array_column(DISCIPLINES, 'attended'));
$totalAbsences = array_sum(array_column(DISCIPLINES, 'absences'));
$hasAttendanceWarning = in_array('Atenção', array_map('attendanceStatus', DISCIPLINES), true);

renderPageStart('Faltas');
renderAcademicHeader('Faltas');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-calendar2-x', 'Frequência por disciplina', 'Consulte presenças, faltas registradas e o percentual de frequência.'); ?>
          <div class="grid-card__body">
            <div class="table-responsive">
              <table class="table table-hover align-middle academic-table">
                <thead><tr><th>Disciplina</th><th>Presenças</th><th>Faltas</th><th>Frequência</th><th>Situação</th></tr></thead>
                <tbody>
                  <?php foreach (DISCIPLINES as $discipline): ?>
                    <?php $status = attendanceStatus($discipline); ?>
                    <tr>
                      <td><?= e($discipline['name']) ?></td>
                      <td><?= $discipline['attended'] ?></td>
                      <td><?= $discipline['absences'] ?></td>
                      <td><strong><?= disciplineAttendance($discipline) ?>%</strong></td>
                      <td><span class="badge <?= statusBadge($status) ?>"><?= e($status) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-check-circle', 'Acompanhamento', 'Resumo da sua frequência no semestre.'); ?>
          <div class="grid-card__body">
            <div class="metric-grid">
              <div><span>Frequência média</span><strong><?= overallAttendance() ?>%</strong></div>
              <div><span>Presenças</span><strong><?= $totalAttended ?></strong></div>
              <div><span>Faltas</span><strong><?= $totalAbsences ?></strong></div>
            </div>
            <?php if ($hasAttendanceWarning): ?>
              <div class="notice-box mt-3"><i class="bi bi-exclamation-triangle"></i><span>Há disciplinas abaixo de <?= MINIMUM_ATTENDANCE ?>% de frequência. Fique atento para não ser reprovado por faltas.</span></div>
            <?php else: ?>
              <div class="notice-box mt-3"><i class="bi bi-shield-check"></i><span>Você está acima de <?= MINIMUM_ATTENDANCE ?>% de frequência em todas as disciplinas deste semestre.</span></div>
            <?php endif; ?>
            <small class="d-block text-secondary mt-3">Os limites de frequência podem variar conforme o regulamento da instituição.</small>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>