<?php
require_once '../../components/layout.php';
renderHead('Consulta de Requerimentos', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$statusMap = [
    'concluido' => ['label' => 'Concluído', 'class' => 'text-bg-success'],
    'analise' => ['label' => 'Em análise', 'class' => 'text-bg-warning'],
    'indeferido' => ['label' => 'Indeferido', 'class' => 'text-bg-danger'],
];

$requerimentos = [
    ['protocolo' => '#REQ-2026-9012', 'data' => '12/08/2026', 'tipo' => 'Declaração de Matrícula', 'status' => 'concluido'],
    ['protocolo' => '#REQ-2026-8834', 'data' => '05/08/2026', 'tipo' => 'Passe Escolar AVOA', 'status' => 'analise'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Consulta de Requerimentos</h1>
        <p class="text-secondary mb-0">Acompanhe o estado das suas solicitações.</p>
      </div>
    </section>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
      <section class="g-box g-col-4 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-clock-history"></i></div>
          <div>
            <h2>Meus requerimentos</h2>
            <p class="grid-card__subtitle">Histórico de solicitações enviadas à secretaria.</p>
          </div>
        </div>
        <div class="grid-card__body">
          <?php if (empty($requerimentos)): ?>
            <div class="notice-box"><i class="bi bi-info-circle"></i><span>Você ainda não possui requerimentos registrados.</span></div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle academic-table">
                <thead>
                  <tr>
                    <th scope="col">Protocolo</th>
                    <th scope="col">Data</th>
                    <th scope="col">Tipo de requerimento</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($requerimentos as $req): ?>
                    <?php $status = $statusMap[$req['status']] ?? ['label' => $req['status'], 'class' => 'text-bg-secondary']; ?>
                    <tr>
                      <td><?= $e($req['protocolo']) ?></td>
                      <td><?= $e($req['data']) ?></td>
                      <td class="fw-semibold"><?= $e($req['tipo']) ?></td>
                      <td><span class="badge rounded-pill <?= $e($status['class']) ?>"><?= $e($status['label']) ?></span></td>
                      <td class="text-end">
                        <?php if ($req['status'] === 'concluido'): ?>
                          <a class="btn btn-sm btn-outline-primary" href="#" aria-label="Ver documento do protocolo <?= $e($req['protocolo']) ?>">Ver documento</a>
                        <?php else: ?>
                          <button class="btn btn-sm btn-outline-secondary" type="button" disabled>Aguardar</button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </section>
    </section>

  </main>
</div>

<?php renderScripts(); ?>

</body>
</html>
