<?php
require_once '../../components/layout.php';
renderHead('Extrato Financeiro', 'dark', '../../', false);
?>
<body>

<div class="app-shell">

  <nav-bar id="main-navigation"></nav-bar>

  <main class="page-content">

    <portal-header></portal-header>

    <section class="hero-header-pages">
      <h1 class="display-6">Extrato Financeiro</h1>
      <p class="text-secondary mb-0">Acompanhe seus lançamentos e histórico de pagamentos</p>
    </section>

    <div class="grid-mesh grid-mesh--static">
      <div class="g-box bg-body-secondary border rounded-4 g-col-2 finance-summary-card">
        <div class="finance-summary-card__icon finance-summary-card__icon--success"><i class="bi bi-check-lg"></i></div>
        <div>
          <p class="finance-summary-card__label">Situação Acadêmica</p>
          <p class="finance-summary-card__value finance-summary-card__value--success">Financeiro em Dia</p>
        </div>
      </div>

      <div class="g-box bg-body-secondary border rounded-4 g-col-2 finance-summary-card">
        <div class="finance-summary-card__icon"><i class="bi bi-credit-card"></i></div>
        <div>
          <p class="finance-summary-card__label">Último Pagamento</p>
          <p class="finance-summary-card__value">R$ 741,27 <small>(10/09/2026)</small></p>
        </div>
      </div>
    </div>

    <div class="finance-filter-card bg-body-secondary border rounded-4">
      <div class="finance-filter-bar">
        <select class="form-select" aria-label="Filtrar período">
          <option selected>Todos os Lançamentos (2026/2)</option>
        </select>
        <button type="button" class="btn btn-outline-primary fw-semibold">Filtrar Histórico</button>
      </div>
    </div>

    <div class="grid-mesh grid-mesh--static">
      <div class="g-box bg-body-secondary border rounded-4 g-col-4 finance-table-card">
        <table class="table finance-ledger">
          <thead>
            <tr>
              <th scope="col">Descrição / Lançamento</th>
              <th scope="col">Vencimento</th>
              <th scope="col">Valor</th>
              <th scope="col">Status</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="finance-ledger__desc">
                <strong>Mensalidade - Parcela</strong>
                <small>Boleto/Lançamento: 941954725 &bull; Ano: 2026</small>
              </td>
              <td>10/09/2026</td>
              <td class="fw-bold">R$ 741,27</td>
              <td>
                <span class="status-pago"><i class="bi bi-check-lg"></i> Pago</span>
                <div><small class="text-secondary">em 10/09/2026</small></div>
              </td>
              <td><button type="button" class="btn btn-sm btn-outline-secondary">Recibo</button></td>
            </tr>
            <tr>
              <td class="finance-ledger__desc">
                <strong>Mensalidade - Parcela</strong>
                <small>Boleto/Lançamento: 941941880 &bull; Ano: 2026</small>
              </td>
              <td>10/08/2026</td>
              <td class="fw-bold">R$ 741,27</td>
              <td>
                <span class="status-pago"><i class="bi bi-check-lg"></i> Pago</span>
                <div><small class="text-secondary">em 10/08/2026</small></div>
              </td>
              <td><button type="button" class="btn btn-sm btn-outline-secondary">Recibo</button></td>
            </tr>
            <tr>
              <td class="finance-ledger__desc">
                <strong>Mensalidade - Parcela 01</strong>
                <small>Boleto/Lançamento: 941936100 &bull; Ano: 2026</small>
              </td>
              <td>10/07/2026</td>
              <td class="fw-bold">R$ 667,14</td>
              <td>
                <span class="status-pago"><i class="bi bi-check-lg"></i> Pago</span>
                <div><small class="text-secondary">em 03/07/2026</small></div>
              </td>
              <td><button type="button" class="btn btn-sm btn-outline-secondary">Recibo</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</div>

<?php renderScripts(); ?>

</body>
</html>