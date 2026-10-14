<?php
require_once __DIR__ . '/../../components/layout.php';

$statuses = array_map('disciplineStatus', DISCIPLINES);
$approvedCount = count(array_keys($statuses, 'Aprovado', true));
$inProgressCount = count(array_keys($statuses, 'Em andamento', true));

renderPageStart('Notas');
renderAcademicHeader('Notas');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-award', 'Boletim do semestre', 'Acompanhe as avaliações lançadas e a situação em cada disciplina.'); ?>
          <div class="grid-card__body">
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

        <section class="grid-card">
          <?php renderCardHead('bi-graph-up', 'Resumo acadêmico', 'Visão geral das notas lançadas.'); ?>
          <div class="grid-card__body">
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