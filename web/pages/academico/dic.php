<?php
require_once '../../components/layout.php';
renderHead('DIC — Documentação Integralização Curricular', 'dark', '../../', false);

$componentes = [
    ['name' => 'Disciplinas obrigatórias', 'completed' => 1680, 'total' => 2520, 'percentage' => 67],
    ['name' => 'Atividades complementares', 'completed' => 80, 'total' => 160, 'percentage' => 50],
    ['name' => 'Projeto Integrador', 'completed' => 120, 'total' => 200, 'percentage' => 60],
    ['name' => 'Disciplinas optativas', 'completed' => 40, 'total' => 200, 'percentage' => 20],
];

$completedHours = array_sum(array_column($componentes, 'completed'));
$totalHours = array_sum(array_column($componentes, 'total'));
$progress = (int) round(($completedHours / $totalHours) * 100);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('DIC — Documentação Integralização Curricular'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic">
      <section class="g-box g-col-3 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-diagram-3"></i></div>
          <div>
            <h2>Integralização curricular</h2>
            <p class="grid-card__subtitle">Acompanhe o avanço das atividades necessárias para concluir o curso.</p>
          </div>
        </div>
        <div class="grid-card__body">
          <div class="progress-summary">
            <div class="d-flex justify-content-between mb-2"><strong>Progresso do curso</strong><span><?= $progress ?>%</span></div>
            <div class="progress" role="progressbar" aria-label="Integralização curricular" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width:<?= $progress ?>%"><?= $progress ?>%</div>
            </div>
          </div>
          <div class="metric-grid mt-4">
            <div><span>Carga concluída</span><strong><?= number_format($completedHours, 0, ',', '.') ?>h</strong></div>
            <div><span>Carga total</span><strong><?= number_format($totalHours, 0, ',', '.') ?>h</strong></div>
            <div><span>Carga restante</span><strong><?= number_format($totalHours - $completedHours, 0, ',', '.') ?>h</strong></div>
          </div>
          <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>O percentual considera disciplinas, atividades complementares, projeto integrador e optativas.</span></div>
        </div>
      </section>

      <section class="g-box g-col-1 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-list-check"></i></div>
          <div><h2>Componentes curriculares</h2><p class="grid-card__subtitle">Carga concluída em cada grupo.</p></div>
        </div>
        <div class="grid-card__body">
          <ul class="clean-list">
            <?php foreach ($componentes as $component): ?>
              <li>
                <span><strong><?= htmlspecialchars($component['name'], ENT_QUOTES, 'UTF-8') ?></strong><small><?= $component['completed'] ?>h de <?= $component['total'] ?>h</small></span>
                <strong><?= $component['percentage'] ?>%</strong>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
