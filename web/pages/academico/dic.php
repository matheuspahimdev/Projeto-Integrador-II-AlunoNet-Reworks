<?php
require_once __DIR__ . '/../../components/layout.php';

$curriculumComponents = [
    ['name' => 'Disciplinas obrigatórias', 'completed' => 1680, 'total' => 2520],
    ['name' => 'Atividades complementares', 'completed' => approvedComplementaryHours(), 'total' => REQUIRED_COMPLEMENTARY_HOURS],
    ['name' => 'Projeto Integrador', 'completed' => 120, 'total' => 200],
    ['name' => 'Disciplinas optativas', 'completed' => 40, 'total' => 200],
];

$completedHours = array_sum(array_column($curriculumComponents, 'completed'));
$totalHours = array_sum(array_column($curriculumComponents, 'total'));
$progress = percentage($completedHours, $totalHours);

renderPageStart('DIC — Documentação de Integralização Curricular');
renderAcademicHeader('DIC — Documentação de Integralização Curricular');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-diagram-3"></i></div>
            <div>
              <h2>Integralização curricular</h2>
              <p class="academic-panel__subtitle">Acompanhe o avanço das atividades necessárias para concluir o curso.</p>
            </div>
          </div>
          <div class="academic-panel__body">
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

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-list-check"></i></div>
            <div><h2>Componentes curriculares</h2><p class="academic-panel__subtitle">Carga concluída em cada grupo.</p></div>
          </div>
          <div class="academic-panel__body">
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