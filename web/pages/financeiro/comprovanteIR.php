<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$beneficiary = incomeTaxBeneficiary();
$year = incomeTaxYearOrLatest($_GET['ano'] ?? null);
$payments = incomeTaxPayments($year);
$total = totalPaid($payments);
renderPageStart('Comprovante para Imposto de Renda');
?>

<?php renderPageHeader('Comprovante para Imposto de Renda', 'Demonstrativo anual de pagamentos (DIRPF)', static function () use ($year): void { ?>
        <form method="get" action="" id="yearForm">
          <label class="visually-hidden" for="yearSelect">Ano-calendário</label>
          <select class="form-select" id="yearSelect" name="ano">
            <?php foreach (incomeTaxYears() as $option): ?>
              <option value="<?= $option ?>"<?= $option === $year ? ' selected' : '' ?>>Ano-Calendário: <?= $option ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <?php renderPrintButton('bi-download', 'Baixar informe (PDF)', 'Informe_IR_' . $year); ?>
<?php }, 'no-print'); ?>

    <div class="irpf-report">
      <div class="print-only">
        <h1>Comprovante para Imposto de Renda</h1>
        <p>Demonstrativo anual de pagamentos (DIRPF) — Ano-calendário <?= $year ?></p>
      </div>

      <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
        <section class="g-box g-col-4 grid-card">
          <?php renderCardHead('bi-building', 'Dados da instituição (fonte pagadora)'); ?>
          <div class="grid-card__body">
            <dl class="data-grid">
              <div><dt>Razão social</dt><dd><?= e(INSTITUTION['legal_name']) ?></dd></div>
              <div><dt>CNPJ</dt><dd><?= e(INSTITUTION['cnpj']) ?></dd></div>
            </dl>
          </div>
        </section>

        <section class="g-box g-col-4 grid-card">
          <?php renderCardHead('bi-receipt', 'Resumo anual - ' . $year); ?>
          <div class="grid-card__body">
            <div class="irpf-summary">
              <div>
                <small>Total de pagamentos efetuados no ano-calendário:</small>
                <span class="irpf-total">R$ <?= formatAmount($total) ?></span>
              </div>
              <div class="irpf-beneficiary">
                <small>Aluno beneficiário:</small>
                <strong><?= e($beneficiary['name']) ?></strong>
                <small>CPF: <?= e($beneficiary['cpf']) ?></small>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover align-middle academic-table">
                <thead>
                  <tr>
                    <th scope="col">Mês de referência</th>
                    <th scope="col">Data do pagamento</th>
                    <th scope="col" class="text-end">Valor pago (R$)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($payments as $payment): ?>
                    <tr>
                      <td><?= e($payment['month']) ?></td>
                      <td><?= e($payment['paid_on']) ?></td>
                      <td class="text-end fw-bold"><?= formatAmount($payment['amount']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="row" colspan="2" class="text-end">Total declarado:</th>
                    <th class="text-end"><?= formatAmount($total) ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </section>
    </div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('yearSelect').addEventListener('change', (event) => event.target.form.submit());
});
</script>
<?php renderPageEnd(); ?>
