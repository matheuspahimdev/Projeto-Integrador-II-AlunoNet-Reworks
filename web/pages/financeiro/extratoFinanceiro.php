<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$lancamentos = INSTALLMENTS;
$ultimoPagamento = lastPayment();
$emDia = overdueInstallments() === [];
renderPageStart('Extrato Financeiro');
?>

<?php renderPageHeader('Extrato Financeiro', 'Acompanhe seus lançamentos e histórico de pagamentos'); ?>

    <div class="finance-summary">
      <div class="bg-body-secondary border rounded-4 finance-summary-card">
        <?php if ($emDia): ?>
          <div class="finance-summary-card__icon finance-summary-card__icon--success"><i class="bi bi-check-lg" aria-hidden="true"></i></div>
          <div>
            <p class="finance-summary-card__label">Situação financeira</p>
            <p class="finance-summary-card__value finance-summary-card__value--success">Financeiro em dia</p>
          </div>
        <?php else: ?>
          <div class="finance-summary-card__icon finance-summary-card__icon--danger"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></div>
          <div>
            <p class="finance-summary-card__label">Situação financeira</p>
            <p class="finance-summary-card__value text-danger">Parcelas em atraso</p>
          </div>
        <?php endif; ?>
      </div>

      <div class="bg-body-secondary border rounded-4 finance-summary-card">
        <div class="finance-summary-card__icon"><i class="bi bi-credit-card" aria-hidden="true"></i></div>
        <div>
          <p class="finance-summary-card__label">Último pagamento</p>
          <?php if ($ultimoPagamento !== null): ?>
            <p class="finance-summary-card__value"><?= formatCurrency($ultimoPagamento['value']) ?> <small>em <?= formatDate($ultimoPagamento['paid_at']) ?></small></p>
          <?php else: ?>
            <p class="finance-summary-card__value">Nenhum pagamento</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <section class="bg-body-secondary border rounded-4 finance-table-card" aria-labelledby="finance-ledger-title">
      <div class="finance-table-card__head">
        <h2 id="finance-ledger-title">Lançamentos <small><?= e(STUDENT['term']) ?></small></h2>
        <label class="visually-hidden" for="finance-filter">Filtrar lançamentos</label>
        <select id="finance-filter" class="form-select" data-ledger-filter>
          <option value="all" selected>Todos os lançamentos</option>
          <option value="open">Em aberto</option>
          <option value="paid">Pagos</option>
        </select>
      </div>
      <table class="table finance-ledger">
        <thead>
          <tr>
            <th scope="col">Descrição / Lançamento</th>
            <th scope="col">Vencimento</th>
            <th scope="col">Valor</th>
            <th scope="col">Status</th>
            <th scope="col"><span class="visually-hidden">Ações</span></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lancamentos as $lancamento): ?>
            <?php $pago = isInstallmentPaid($lancamento); ?>
            <tr data-ledger-status="<?= $pago ? 'paid' : 'open' ?>">
              <td class="finance-ledger__desc">
                <strong><?= e($lancamento['description']) ?></strong>
                <small>Boleto <?= e($lancamento['code']) ?> &bull; <?= date('Y', strtotime($lancamento['due_date'])) ?></small>
              </td>
              <td data-label="Vencimento"><?= formatDate($lancamento['due_date']) ?></td>
              <td data-label="Valor" class="fw-bold"><?= formatCurrency($lancamento['value']) ?></td>
              <td data-label="Status">
                <?php if ($pago): ?>
                  <span class="status-pago"><i class="bi bi-check-lg" aria-hidden="true"></i> <?= e(installmentStatus($lancamento)) ?></span>
                  <small class="finance-ledger__paid-at">em <?= formatDate($lancamento['paid_at']) ?></small>
                <?php else: ?>
                  <span class="badge rounded-pill <?= statusBadge(installmentStatus($lancamento)) ?>"><?= e(installmentStatus($lancamento)) ?></span>
                <?php endif; ?>
              </td>
              <td class="finance-ledger__actions">
                <?php if ($pago): ?>
                  <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-receipt me-1" aria-hidden="true"></i>Recibo</button>
                <?php else: ?>
                  <a class="btn btn-sm btn-primary" href="boletoOnline.php"><i class="bi bi-upc-scan me-1" aria-hidden="true"></i>Pagar</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p class="finance-ledger__empty" data-ledger-empty hidden>Nenhum lançamento encontrado para este filtro.</p>
    </section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const filter = document.querySelector('[data-ledger-filter]');
  const rows = document.querySelectorAll('[data-ledger-status]');
  const emptyMessage = document.querySelector('[data-ledger-empty]');

  filter.addEventListener('change', () => {
    let visibleRows = 0;
    rows.forEach((row) => {
      const isVisible = filter.value === 'all' || row.dataset.ledgerStatus === filter.value;
      row.hidden = !isVisible;
      visibleRows += Number(isVisible);
    });
    emptyMessage.hidden = visibleRows > 0;
  });
});
</script>
<?php renderPageEnd(); ?>