<?php
require_once '../../components/layout.php';
renderHead('Notas', 'dark', '../../', false);

$disciplinas = [
    ['name' => 'Laboratório de Programação de Computadores', 'first' => 8.5, 'second' => 9.0, 'average' => 8.8, 'status' => 'Aprovado', 'status_class' => 'text-bg-success'],
    ['name' => 'Engenharia de Requisitos', 'first' => 7.5, 'second' => 8.0, 'average' => 7.8, 'status' => 'Aprovado', 'status_class' => 'text-bg-success'],
    ['name' => 'Projeto Integrador II', 'first' => 9.0, 'second' => null, 'average' => 9.0, 'status' => 'Em andamento', 'status_class' => 'text-bg-primary'],
    ['name' => 'Resolução Diferenciada de Problemas', 'first' => 8.0, 'second' => 7.5, 'average' => 7.8, 'status' => 'Aprovado', 'status_class' => 'text-bg-success'],
    ['name' => 'Empreendedorismo', 'first' => 8.5, 'second' => null, 'average' => 8.5, 'status' => 'Em andamento', 'status_class' => 'text-bg-primary'],
    ['name' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'first' => 9.0, 'second' => null, 'average' => 9.0, 'status' => 'Em andamento', 'status_class' => 'text-bg-primary'],
];

$average = array_sum(array_column($disciplinas, 'average')) / count($disciplinas);
$approved = count(array_filter($disciplinas, static fn (array $discipline): bool => $discipline['status'] === 'Aprovado'));
$inProgress = count($disciplinas) - $approved;
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Notas'); ?>

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
                <?php foreach ($disciplinas as $discipline): ?>
                  <tr>
                    <td><?= htmlspecialchars($discipline['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= number_format($discipline['first'], 1, ',', '.') ?></td>
                    <td><?= $discipline['second'] === null ? '—' : number_format($discipline['second'], 1, ',', '.') ?></td>
                    <td><strong><?= number_format($discipline['average'], 1, ',', '.') ?></strong></td>
                    <td><span class="badge <?= $discipline['status_class'] ?>"><?= $discipline['status'] ?></span></td>
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
            <div><span>Média geral</span><strong><?= number_format($average, 1, ',', '.') ?></strong></div>
            <div><span>Aprovadas</span><strong><?= $approved ?></strong></div>
            <div><span>Em andamento</span><strong><?= $inProgress ?></strong></div>
          </div>
          <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>Notas sem a segunda avaliação permanecem em acompanhamento até o fechamento do semestre.</span></div>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>