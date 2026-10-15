<?php
require_once __DIR__ . '/../../components/layout.php';

$complementaryActivitiesComponent = ['name' => 'Atividades complementares', 'completed' => approvedComplementaryHours(), 'total' => REQUIRED_COMPLEMENTARY_HOURS];
$mandatoryDisciplines = curriculumComponents()[0];
$otherComponents = array_slice(curriculumComponents(), 1);
$curriculumComponents = [$mandatoryDisciplines, $complementaryActivitiesComponent, ...$otherComponents];

$completedHours = array_sum(array_column($curriculumComponents, 'completed'));
$totalHours = array_sum(array_column($curriculumComponents, 'total'));
$progress = percentage($completedHours, $totalHours);

renderAcademicPageStart('DIC — Documentação de Integralização Curricular');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-diagram-3', 'Integralização curricular', 'Acompanhe o avanço das atividades necessárias para concluir o curso.'); ?>
          <div class="grid-card__body">
            <div class="progress-summary">
              <div class="d-flex justify-content-between mb-2"><strong>Progresso do curso</strong><span><?= $progress ?>%</span></div>
              <div class="progress" role="progressbar" aria-label="Integralização curricular" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width:<?= $progress ?>%"><?= $progress ?>%</div>
              </div>
            </div>
            <div class="metric-grid mt-4">
              <div><span>Carga concluída</span><strong><?= formatHours($completedHours) ?></strong></div>
              <div><span>Carga total</span><strong><?= formatHours($totalHours) ?></strong></div>
              <div><span>Carga restante</span><strong><?= formatHours($totalHours - $completedHours) ?></strong></div>
            </div>
            <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>O percentual considera disciplinas, atividades complementares, projeto integrador e optativas.</span></div>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-list-check', 'Componentes curriculares', 'Carga concluída em cada grupo.'); ?>
          <div class="grid-card__body">
            <ul class="clean-list">
              <?php foreach ($curriculumComponents as $component): ?>
                <li>
                  <span><strong><?= e($component['name']) ?></strong><small><?= formatHours($component['completed']) ?> de <?= formatHours($component['total']) ?></small></span>
                  <strong><?= percentage($component['completed'], $component['total']) ?>%</strong>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>