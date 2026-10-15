<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$overdueInvoices = overdueInstallments();
$unpaidInvoices = unpaidInstallments();
renderPageStart('Boleto Online & Pagamentos');
?>

<?php renderPageHeader('Boleto Online & Pagamentos', 'Acesse suas faturas abertas ou gere a 2ª via.'); ?>

    <?php if ($overdueInvoices === []): ?>
      <div class="info-banner info-banner--success" role="status">
        <div class="info-banner__icon"><i class="bi bi-check-lg"></i></div>
        <div>
          <strong>Tudo certo por aqui, <?= e(studentFirstName()) ?>!</strong>
          <span>Você não possui boletos em atraso neste momento.</span>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-danger mx-1 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>Você possui <?= count($overdueInvoices) ?> boleto(s) em atraso. Regularize o quanto antes.
      </div>
    <?php endif; ?>

    <h2 class="section-title">Boletos em aberto</h2>

    <?php foreach ($unpaidInvoices as $invoice): ?>
      <?php $isOverdue = isInstallmentOverdue($invoice); ?>
      <article class="invoice-card">
        <div class="invoice-card__top">
          <div>
            <?php if ($isOverdue): ?>
              <span class="badge rounded-pill text-bg-danger"><i class="bi bi-exclamation-circle me-1"></i>Vencido</span>
            <?php else: ?>
              <span class="badge rounded-pill text-bg-warning"><i class="bi bi-clock me-1"></i>A vencer</span>
            <?php endif; ?>
            <h3 class="invoice-card__title"><?= e($invoice['description']) ?></h3>
            <p class="invoice-card__meta">Boleto/Lançamento: <?= e($invoice['code']) ?> • Ano/Semestre: <?= e(currentStudent()['term']) ?></p>
          </div>
          <div class="invoice-card__amount">
            <small>Valor a pagar</small>
            <span class="invoice-card__value"><?= formatCurrency($invoice['value']) ?></span>
            <span class="invoice-card__due text-danger"><?= $isOverdue ? 'Venceu' : 'Vence' ?> em <?= formatDate($invoice['due_date']) ?></span>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12 col-md-4">
            <button class="btn btn-accent w-100" type="button" data-copy="<?= e($invoice['digitable_line']) ?>" data-copy-message="Linha digitável copiada.">
              <i class="bi bi-copy me-2"></i>Copiar linha digitável
            </button>
          </div>
          <div class="col-12 col-md-4">
            <button class="btn btn-outline-primary w-100" type="button" data-pix-code="<?= e($invoice['pix_code']) ?>" data-pix-value="<?= e(formatCurrency($invoice['value'])) ?>">
              <i class="bi bi-qr-code me-2"></i>Pagar com PIX
            </button>
          </div>
          <div class="col-12 col-md-4">
            <button class="btn btn-outline-secondary w-100" type="button" data-pdf-unavailable>
              <i class="bi bi-download me-2"></i>Baixar PDF (2ª via)
            </button>
          </div>
        </div>
      </article>
    <?php endforeach; ?>

    <?php if ($unpaidInvoices === []): ?>
      <div class="notice-box mx-1"><i class="bi bi-info-circle"></i><span>Não há boletos em aberto no momento.</span></div>
    <?php endif; ?>


<?php if ($unpaidInvoices !== []): ?>
<div class="modal fade" id="pixModal" tabindex="-1" aria-labelledby="pixModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="pixModalLabel">Pagar com PIX</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="pix-qr" aria-hidden="true"><i class="bi bi-qr-code"></i></div>
        <p class="text-center text-secondary small">Escaneie o QR Code no app do seu banco ou use o código copia e cola. Valor: <strong id="pixValue"></strong></p>
        <label class="form-label" for="pixCode">PIX copia e cola</label>
        <div class="input-group">
          <input class="form-control" id="pixCode" type="text" readonly>
          <button class="btn btn-accent" type="button" id="pixCopy" data-copy="" data-copy-message="Código PIX copiado.">Copiar</button>
        </div>
        <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>QR Code e código ilustrativos. Serão gerados pelo backend na versão integrada.</span></div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const pixModal = document.getElementById('pixModal');

  document.querySelectorAll('[data-pix-code]').forEach((button) => {
    button.addEventListener('click', () => {
      document.getElementById('pixValue').textContent = button.dataset.pixValue;
      document.getElementById('pixCode').value = button.dataset.pixCode;
      document.getElementById('pixCopy').dataset.copy = button.dataset.pixCode;
      bootstrap.Modal.getOrCreateInstance(pixModal).show();
    });
  });

  document.querySelectorAll('[data-pdf-unavailable]').forEach((button) => {
    button.addEventListener('click', () => showToast('A 2ª via em PDF será gerada pelo backend na versão integrada. Por enquanto, use a linha digitável ou o PIX.'));
  });
});
</script>
<?php renderPageEnd(); ?>
