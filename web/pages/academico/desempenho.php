<?php
require_once '../../components/layout.php';
renderHead('Gráficos de Desempenho', 'dark', '../../', false);

$desempenho = [
    ['short_name' => 'Lab. Programação', 'name' => 'Laboratório de Programação de Computadores', 'average' => 8.8, 'attendance' => 94],
    ['short_name' => 'Eng. Requisitos', 'name' => 'Engenharia de Requisitos', 'average' => 7.8, 'attendance' => 92],
    ['short_name' => 'Projeto Integrador', 'name' => 'Projeto Integrador II', 'average' => 9.0, 'attendance' => 97],
    ['short_name' => 'RDP', 'name' => 'Resolução Diferenciada de Problemas', 'average' => 7.8, 'attendance' => 89],
    ['short_name' => 'Empreendedorismo', 'name' => 'Empreendedorismo', 'average' => 8.5, 'attendance' => 91],
    ['short_name' => 'Direito e Inovação', 'name' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'average' => 9.0, 'attendance' => 88],
];

$average = array_sum(array_column($desempenho, 'average')) / count($desempenho);
$attendance = array_sum(array_column($desempenho, 'attendance')) / count($desempenho);
$best = max(array_column($desempenho, 'average'));
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Gráficos de Desempenho'); ?>

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
            <?php foreach ($desempenho as $item): ?>
              <div class="bar-row">
                <span title="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($item['short_name'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="bar" role="progressbar" aria-label="Média em <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>" aria-valuenow="<?= $item['average'] ?>" aria-valuemin="0" aria-valuemax="10">
                  <i style="width:<?= $item['average'] * 10 ?>%"></i>
                </div>
                <strong><?= number_format($item['average'], 1, ',', '.') ?></strong>
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
            <div><span>Média geral</span><strong><?= number_format($average, 1, ',', '.') ?></strong></div>
            <div><span>Frequência média</span><strong><?= round($attendance) ?>%</strong></div>
            <div><span>Maior média</span><strong><?= number_format($best, 1, ',', '.') ?></strong></div>
          </div>
          <div class="notice-box mt-3"><i class="bi bi-lightbulb"></i><span>Use os indicadores para identificar disciplinas que merecem mais atenção ao longo do semestre.</span></div>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
