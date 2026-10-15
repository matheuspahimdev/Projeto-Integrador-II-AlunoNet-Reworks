<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/protocolo.php';

$requests = studentRequests();
renderPageStart('Consulta de Requerimentos');
?>

<?php renderPageHeader('Consulta de Requerimentos', 'Acompanhe o estado das suas solicitações.'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
      <section class="g-box g-col-4 grid-card">
        <?php renderCardHead('bi-clock-history', 'Meus requerimentos', 'Histórico de solicitações enviadas à secretaria.'); ?>
        <div class="grid-card__body">
          <?php if ($requests === []): ?>
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
                  <?php foreach ($requests as $request): ?>
                    <?php $status = requestStatus($request); ?>
                    <tr>
                      <td><?= e($request['protocol']) ?></td>
                      <td><?= formatDate($request['date']) ?></td>
                      <td class="fw-semibold"><?= e($request['type']) ?></td>
                      <td><span class="badge rounded-pill <?= e($status['class']) ?>"><?= e($status['label']) ?></span></td>
                      <td class="text-end">
                        <?php if ($request['status'] === REQUEST_STATUS_DONE): ?>
                          <a class="btn btn-sm btn-outline-primary" href="#" aria-label="Ver documento do protocolo <?= e($request['protocol']) ?>">Ver documento</a>
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