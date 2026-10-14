<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$instituicao = INSTITUTION;
$beneficiario = incomeTaxBeneficiary();
$anos = incomeTaxYears();
$ano = incomeTaxYearOrLatest($_GET['ano'] ?? null);
$pagamentos = incomeTaxPayments($ano);
$total = totalPaid($pagamentos);
$tituloImpressao = 'Informe_IR_' . $ano;
renderPageStart('Comprovante para Imposto de Renda');
?>

<?php renderPageHeader('Comprovante para Imposto de Renda', 'Demonstrativo anual de pagamentos (DIRPF)', static function () use ($anos, $ano): void { ?>
        <form method="get" action="" id="yearForm">
          <label class="visually-hidden" for="yearSelect">Ano-calendário</label>
          <select class="form-select" id="yearSelect" name="ano">
            <?php foreach ($anos as $opcao): ?>
              <option value="<?= $opcao ?>"<?= $opcao === $ano ? ' selected' : '' ?>>Ano-Calendário: <?= $opcao ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <?php renderActionButton('downloadReport', 'bi-download', 'Baixar informe (PDF)', 'btn-primary', 'Na janela de impressão, escolha “Salvar como PDF”'); ?>
<?php }, 'no-print'); ?>

    <div class="irpf-report">
      <div class="print-only">
        <h1>Comprovante para Imposto de Renda</h1>
        <p>Demonstrativo anual de pagamentos (DIRPF) — Ano-calendário <?= $ano ?></p>
      </div>

      <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
        <section class="g-box g-col-4 grid-card">
          <?php renderCardHead('bi-building', 'Dados da instituição (fonte pagadora)'); ?>
          <div class="grid-card__body">
            <dl class="data-grid">
              <div><dt>Razão social</dt><dd><?= e($instituicao['legal_name']) ?></dd></div>
              <div><dt>CNPJ</dt><dd><?= e($instituicao['cnpj']) ?></dd></div>
            </dl>
          </div>
        </section>

        <section class="g-box g-col-4 grid-card">
          <?php renderCardHead('bi-receipt', 'Resumo anual - ' . $ano); ?>
          <div class="grid-card__body">
            <div class="irpf-summary">
              <div>
                <small>Total de pagamentos efetuados no ano-calendário:</small>
                <span class="irpf-total">R$ <?= formatAmount($total) ?></span>
              </div>
              <div class="irpf-beneficiary">
                <small>Aluno beneficiário:</small>
                <strong><?= e($beneficiario['nome']) ?></strong>
                <small>CPF: <?= e($beneficiario['cpf']) ?></small>
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
                  <?php foreach ($pagamentos as $pagamento): ?>
                    <tr>
                      <td><?= e($pagamento['mes']) ?></td>
                      <td><?= e($pagamento['data']) ?></td>
                      <td class="text-end fw-bold"><?= formatAmount($pagamento['valor']) ?></td>
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
  const originalTitle = document.title;
  const printTitle = <?= json_encode($tituloImpressao, JSON_UNESCAPED_UNICODE) ?>;

  window.addEventListener('beforeprint', () => { document.title = printTitle; });
  window.addEventListener('afterprint', () => { document.title = originalTitle; });

  document.getElementById('downloadReport').addEventListener('click', () => window.print());
  document.getElementById('yearSelect').addEventListener('change', (event) => event.target.form.submit());
});
</script>
<?php renderPageEnd(); ?>