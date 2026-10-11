<?php
require_once __DIR__ . '/../../components/layout.php';

$statuses = array_map('disciplineStatus', DISCIPLINES);
$approvedCount = count(array_keys($statuses, 'Aprovado', true));
$inProgressCount = count(array_keys($statuses, 'Em andamento', true));

renderPageStart('Notas');
renderAcademicHeader('Notas');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-award"></i></div>
            <div>
              <h2>Boletim do semestre</h2>
              <p class="academic-panel__subtitle">Acompanhe as avaliações lançadas e a situação em cada disciplina.</p>
            </div>
          </div>
          <div class="academic-panel__body">
            <div class="table-responsive">
              <table class="table table-hover align-middle academic-table">
                <thead><tr><th>Disciplina</th><th>Nota 1</th><th>Nota 2</th><th>Média</th><th>Situação</th></tr></thead>
                <tbody>
                  <?php foreach (DISCIPLINES as $key => $discipline): ?>
                    <tr>
                      <td><?= e($discipline['name']) ?></td>
                      <td><?= formatGrade($discipline['grades'][0]) ?></td>
                      <td><?= isset($discipline['grades'][1]) ? formatGrade($discipline['grades'][1]) : '—' ?></td>
                      <td><strong><?= formatGrade(disciplineAverage($discipline)) ?></strong></td>
                      <td><span class="badge <?= statusBadge($statuses[$key]) ?>"><?= e($statuses[$key]) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-graph-up"></i></div>
            <div><h2>Resumo acadêmico</h2><p class="academic-panel__subtitle">Visão geral das notas lançadas.</p></div>
          </div>
          <div class="academic-panel__body">
            <div class="metric-grid">
              <div><span>Média geral</span><strong><?= formatGrade(overallAverage()) ?></strong></div>
              <div><span>Aprovadas</span><strong><?= $approvedCount ?></strong></div>
              <div><span>Em andamento</span><strong><?= $inProgressCount ?></strong></div>
            </div>
            <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>Notas sem a segunda avaliação permanecem em acompanhamento até o fechamento do semestre.</span></div>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>