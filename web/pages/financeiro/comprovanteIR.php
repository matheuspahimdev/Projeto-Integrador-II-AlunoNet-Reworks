<?php
require_once '../../components/layout.php';
renderHead('Comprovante para Imposto de Renda', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$moeda = static fn (float $valor): string => number_format($valor, 2, ',', '.');

$instituicao = [
    'razaoSocial' => 'FUNDAÇÃO EDUCACIONAL MIGUEL MOFARREJ - UNIFIO',
    'cnpj' => '53.300.547/0001-31',
];

$beneficiario = [
    'nome' => 'NOME DO ALUNO',
    'cpf' => '000.000.000-00',
];

$mensalidadePorAno = [
    2025 => 1482.54,
    2024 => 1398.76,
    2023 => 1321.10,
];

$meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

$anos = array_keys($mensalidadePorAno);
$ano = (int) ($_GET['ano'] ?? $anos[0]);
if (!isset($mensalidadePorAno[$ano])) {
    $ano = $anos[0];
}

$pagamentos = [];
foreach ($meses as $indice => $mes) {
    $pagamentos[] = [
        'mes' => $mes . ' / ' . $ano,
        'data' => sprintf('10/%02d/%d', $indice + 1, $ano),
        'valor' => $mensalidadePorAno[$ano],
    ];
}

$total = round(array_sum(array_column($pagamentos, 'valor')), 2);
$tituloImpressao = 'Informe_IR_' . $ano;
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3 no-print">
      <div>
        <h1 class="display-6">Comprovante para Imposto de Renda</h1>
        <p class="text-secondary mb-0">Demonstrativo anual de pagamentos (DIRPF)</p>
      </div>
      <div class="d-flex flex-wrap align-items-center gap-2">
        <form method="get" action="" id="yearForm">
          <label class="visually-hidden" for="yearSelect">Ano-calendário</label>
          <select class="form-select" id="yearSelect" name="ano">
            <?php foreach ($anos as $opcao): ?>
              <option value="<?= $opcao ?>"<?= $opcao === $ano ? ' selected' : '' ?>>Ano-Calendário: <?= $opcao ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <button class="btn btn-primary" type="button" id="downloadReport" title="Na janela de impressão, escolha “Salvar como PDF”">
          <i class="bi bi-download me-2"></i>Baixar informe (PDF)
        </button>
      </div>
    </section>

    <div class="irpf-report">
      <div class="print-only">
        <h1>Comprovante para Imposto de Renda</h1>
        <p>Demonstrativo anual de pagamentos (DIRPF) — Ano-calendário <?= $ano ?></p>
      </div>

      <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
        <section class="g-box g-col-4 grid-card">
          <div class="grid-card__head">
            <div class="grid-card__icon"><i class="bi bi-building"></i></div>
            <div>
              <h2>Dados da instituição (fonte pagadora)</h2>
            </div>
          </div>
          <div class="grid-card__body">
            <dl class="data-grid">
              <div><dt>Razão social</dt><dd><?= $e($instituicao['razaoSocial']) ?></dd></div>
              <div><dt>CNPJ</dt><dd><?= $e($instituicao['cnpj']) ?></dd></div>
            </dl>
          </div>
        </section>

        <section class="g-box g-col-4 grid-card">
          <div class="grid-card__head">
            <div class="grid-card__icon"><i class="bi bi-receipt"></i></div>
            <div>
              <h2>Resumo anual - <?= $ano ?></h2>
            </div>
          </div>
          <div class="grid-card__body">
            <div class="irpf-summary">
              <div>
                <small>Total de pagamentos efetuados no ano-calendário:</small>
                <span class="irpf-total">R$ <?= $moeda($total) ?></span>
              </div>
              <div class="irpf-beneficiary">
                <small>Aluno beneficiário:</small>
                <strong><?= $e($beneficiario['nome']) ?></strong>
                <small>CPF: <?= $e($beneficiario['cpf']) ?></small>
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
                      <td><?= $e($pagamento['mes']) ?></td>
                      <td><?= $e($pagamento['data']) ?></td>
                      <td class="text-end fw-bold"><?= $moeda($pagamento['valor']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="row" colspan="2" class="text-end">Total declarado:</th>
                    <th class="text-end"><?= $moeda($total) ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </section>
    </div>

  </main>
</div>

<?php renderScripts(); ?>

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

</body>
</html>
