<?php
require_once __DIR__ . '/../../components/layout.php';

$installments = [
    ['description' => 'Mensalidade - Parcela 04', 'code' => '941962310', 'due_date' => '2026-10-10', 'value' => 741.27, 'paid_at' => null],
    ['description' => 'Mensalidade - Parcela 03', 'code' => '941954725', 'due_date' => '2026-09-10', 'value' => 741.27, 'paid_at' => '2026-09-10'],
    ['description' => 'Mensalidade - Parcela 02', 'code' => '941941880', 'due_date' => '2026-08-10', 'value' => 741.27, 'paid_at' => '2026-08-10'],
    ['description' => 'Mensalidade - Parcela 01', 'code' => '941936100', 'due_date' => '2026-07-10', 'value' => 667.14, 'paid_at' => '2026-07-03'],
];

$paidInstallments = array_values(array_filter($installments, static fn (array $installment): bool => $installment['paid_at'] !== null));
$openInstallments = array_values(array_filter($installments, static fn (array $installment): bool => $installment['paid_at'] === null));
$lastPayment = $paidInstallments[0];
$nextInstallment = $openInstallments[0] ?? null;

renderPageStart('Central de Boletos');
renderPageHeader('Central de Boletos', 'Acompanhe seus lançamentos e histórico de pagamentos.');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-receipt"></i></div>
            <div>
              <h2>Extrato financeiro</h2>
              <p class="academic-panel__subtitle">Lançamentos do semestre <?= e(STUDENT['term']) ?>.</p>
            </div>
          </div>
          <div class="academic-panel__body">
            <div class="table-responsive">
              <table class="table table-hover align-middle academic-table">
                <thead><tr><th>Lançamento</th><th>Vencimento</th><th>Valor</th><th>Situação</th><th>Ações</th></tr></thead>
                <tbody>
                  <?php foreach ($installments as $installment): ?>
                    <?php $status = $installment['paid_at'] === null ? 'Em aberto' : 'Pago'; ?>
                    <tr>
                      <td>
                        <strong class="d-block"><?= e($installment['description']) ?></strong>
                        <small class="text-secondary">Boleto <?= e($installment['code']) ?></small>
                      </td>
                      <td><?= formatDate($installment['due_date']) ?></td>
                      <td><strong><?= formatCurrency($installment['value']) ?></strong></td>
                      <td>
                        <span class="badge <?= statusBadge($status) ?>"><?= e($status) ?></span>
                        <?php if ($installment['paid_at'] !== null): ?>
                          <small class="d-block text-secondary mt-1">em <?= formatDate($installment['paid_at']) ?></small>
                        <?php endif; ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm <?= $installment['paid_at'] === null ? 'btn-primary' : 'btn-outline-secondary' ?>">
                          <?= $installment['paid_at'] === null ? 'Gerar boleto' : 'Recibo' ?>
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-wallet2"></i></div>
            <div><h2>Resumo</h2><p class="academic-panel__subtitle">Situação financeira do semestre.</p></div>
          </div>
          <div class="academic-panel__body">
            <div class="status-card">
              <i class="bi bi-check-circle-fill"></i>
              <div><strong>Financeiro em dia</strong><span>Nenhuma parcela vencida.</span></div>
            </div>
            <dl class="data-grid data-grid--single mt-3">
              <div><dt>Último pagamento</dt><dd><?= formatCurrency($lastPayment['value']) ?> em <?= formatDate($lastPayment['paid_at']) ?></dd></div>
              <?php if ($nextInstallment !== null): ?>
                <div><dt>Próximo vencimento</dt><dd><?= formatCurrency($nextInstallment['value']) ?> em <?= formatDate($nextInstallment['due_date']) ?></dd></div>
              <?php endif; ?>
            </dl>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>