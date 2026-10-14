<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/protocolo.php';

$requerimentos = STUDENT_REQUESTS;
renderPageStart('Consulta de Requerimentos');
?>

<?php renderPageHeader('Consulta de Requerimentos', 'Acompanhe o estado das suas solicitações.'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
      <section class="g-box g-col-4 grid-card">
        <?php renderCardHead('bi-clock-history', 'Meus requerimentos', 'Histórico de solicitações enviadas à secretaria.'); ?>
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
                    <?php $status = requestStatus($req) ?? ['label' => $req['status'], 'class' => 'text-bg-secondary']; ?>
                    <tr>
                      <td><?= e($req['protocolo']) ?></td>
                      <td><?= e($req['data']) ?></td>
                      <td class="fw-semibold"><?= e($req['tipo']) ?></td>
                      <td><span class="badge rounded-pill <?= e($status['class']) ?>"><?= e($status['label']) ?></span></td>
                      <td class="text-end">
                        <?php if ($req['status'] === 'concluido'): ?>
                          <a class="btn btn-sm btn-outline-primary" href="#" aria-label="Ver documento do protocolo <?= e($req['protocolo']) ?>">Ver documento</a>
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
<?php renderPageEnd(); ?>