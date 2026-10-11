<?php
require_once __DIR__ . '/../../components/layout.php';

$highestAverage = max(array_map('disciplineAverage', DISCIPLINES));

renderPageStart('Gráficos de Desempenho');
renderAcademicHeader('Gráficos de Desempenho');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-bar-chart"></i></div>
            <div>
              <h2>Média por disciplina</h2>
              <p class="academic-panel__subtitle">Compare o desempenho nas disciplinas com notas lançadas.</p>
            </div>
          </div>
          <div class="academic-panel__body">
            <div class="bar-chart" aria-label="Gráfico de médias por disciplina">
              <?php foreach (DISCIPLINES as $discipline): ?>
                <?php $average = disciplineAverage($discipline); ?>
                <div class="bar-row">
                  <span title="<?= e($discipline['name']) ?>"><?= e($discipline['short_name']) ?></span>
                  <div class="bar" role="progressbar" aria-label="Média em <?= e($discipline['name']) ?>" aria-valuenow="<?= $average ?>" aria-valuemin="0" aria-valuemax="10">
                    <i style="width:<?= $average * 10 ?>%"></i>
                  </div>
                  <strong><?= formatGrade($average) ?></strong>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-speedometer2"></i></div>
            <div><h2>Indicadores</h2><p class="academic-panel__subtitle">Resumo para acompanhar sua evolução.</p></div>
          </div>
          <div class="academic-panel__body">
            <div class="metric-grid">
              <div><span>Média geral</span><strong><?= formatGrade(overallAverage()) ?></strong></div>
              <div><span>Frequência média</span><strong><?= overallAttendance() ?>%</strong></div>
              <div><span>Maior média</span><strong><?= formatGrade($highestAverage) ?></strong></div>
            </div>
            <div class="notice-box mt-3"><i class="bi bi-lightbulb"></i><span>Use os indicadores para identificar disciplinas que merecem mais atenção ao longo do semestre.</span></div>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>