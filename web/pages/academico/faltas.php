<?php
require_once '../../components/layout.php';
renderHead('Faltas', 'dark', '../../', false);

$frequencias = [
    ['name' => 'Laboratório de Programação de Computadores', 'attended' => 34, 'absences' => 2, 'percentage' => 94],
    ['name' => 'Engenharia de Requisitos', 'attended' => 33, 'absences' => 3, 'percentage' => 92],
    ['name' => 'Projeto Integrador II', 'attended' => 35, 'absences' => 1, 'percentage' => 97],
    ['name' => 'Resolução Diferenciada de Problemas', 'attended' => 32, 'absences' => 4, 'percentage' => 89],
    ['name' => 'Empreendedorismo', 'attended' => 31, 'absences' => 3, 'percentage' => 91],
    ['name' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'attended' => 30, 'absences' => 4, 'percentage' => 88],
];

$totalClasses = array_sum(array_map(static fn (array $frequency): int => $frequency['attended'] + $frequency['absences'], $frequencias));
$totalAttended = array_sum(array_column($frequencias, 'attended'));
$totalAbsences = array_sum(array_column($frequencias, 'absences'));
$averageAttendance = (int) round(($totalAttended / $totalClasses) * 100);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Faltas'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic">
      <section class="g-box g-col-3 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-calendar2-x"></i></div>
          <div>
            <h2>Frequência por disciplina</h2>
            <p class="grid-card__subtitle">Consulte presenças, faltas registradas e o percentual de frequência.</p>
          </div>
        </div>
        <div class="grid-card__body">
          <div class="table-responsive">
            <table class="table table-hover align-middle academic-table">
              <thead><tr><th>Disciplina</th><th>Presenças</th><th>Faltas</th><th>Frequência</th><th>Situação</th></tr></thead>
              <tbody>
                <?php foreach ($frequencias as $frequency): ?>
                  <tr>
                    <td><?= htmlspecialchars($frequency['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $frequency['attended'] ?></td>
                    <td><?= $frequency['absences'] ?></td>
                    <td><strong><?= $frequency['percentage'] ?>%</strong></td>
                    <td><span class="badge <?= $frequency['percentage'] >= 75 ? 'text-bg-success' : 'text-bg-warning' ?>"><?= $frequency['percentage'] >= 75 ? 'Regular' : 'Atenção' ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section class="g-box g-col-1 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-check-circle"></i></div>
          <div><h2>Acompanhamento</h2><p class="grid-card__subtitle">Resumo da sua frequência no semestre.</p></div>
        </div>
        <div class="grid-card__body">
          <div class="metric-grid">
            <div><span>Frequência média</span><strong><?= $averageAttendance ?>%</strong></div>
            <div><span>Presenças</span><strong><?= $totalAttended ?></strong></div>
            <div><span>Faltas</span><strong><?= $totalAbsences ?></strong></div>
          </div>
          <div class="notice-box mt-3"><i class="bi bi-shield-check"></i><span>Você está dentro da faixa de frequência apresentada para as disciplinas deste semestre.</span></div>
          <small class="d-block text-secondary mt-3">Os limites de frequência podem variar conforme o regulamento da instituição.</small>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
