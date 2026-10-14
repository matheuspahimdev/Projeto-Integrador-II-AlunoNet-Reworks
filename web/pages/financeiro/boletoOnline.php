<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$boletosEmAtraso = overdueInstallments();
$proximoVencimento = nextInstallmentDue();
renderPageStart('Boleto Online & Pagamentos');
?>

<?php renderPageHeader('Boleto Online & Pagamentos', 'Acesse suas faturas abertas ou gere a 2ª via.'); ?>

    <?php if ($boletosEmAtraso === []): ?>
      <div class="info-banner info-banner--success" role="status">
        <div class="info-banner__icon"><i class="bi bi-check-lg"></i></div>
        <div>
          <strong>Tudo certo por aqui, <?= e(studentFirstName()) ?>!</strong>
          <span>Você não possui boletos em atraso neste momento.</span>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-danger mx-1 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>Você possui <?= count($boletosEmAtraso) ?> boleto(s) em atraso. Regularize o quanto antes.
      </div>
    <?php endif; ?>

    <h2 class="section-title">Próximo vencimento</h2>

    <?php if ($proximoVencimento): ?>
      <article class="invoice-card">
        <div class="invoice-card__top">
          <div>
            <span class="badge rounded-pill text-bg-warning"><i class="bi bi-clock me-1"></i>A vencer</span>
            <h3 class="invoice-card__title"><?= e($proximoVencimento['description']) ?></h3>
            <p class="invoice-card__meta">Boleto/Lançamento: <?= e($proximoVencimento['code']) ?> • Ano/Semestre: <?= e(STUDENT['term']) ?></p>
          </div>
          <div class="invoice-card__amount">
            <small>Valor a pagar</small>
            <span class="invoice-card__value"><?= formatCurrency($proximoVencimento['value']) ?></span>
            <span class="invoice-card__due text-danger">Vence em <?= formatDate($proximoVencimento['due_date']) ?></span>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12 col-md-4">
            <button class="btn btn-accent w-100" type="button" data-copy="<?= e($proximoVencimento['digitable_line']) ?>" data-copy-message="Linha digitável copiada.">
              <i class="bi bi-copy me-2"></i>Copiar linha digitável
            </button>
          </div>
          <div class="col-12 col-md-4">
            <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#pixModal">
              <i class="bi bi-qr-code me-2"></i>Pagar com PIX
            </button>
          </div>
          <div class="col-12 col-md-4">
            <a class="btn btn-outline-secondary w-100" href="#" download>
              <i class="bi bi-download me-2"></i>Baixar PDF (2ª via)
            </a>
          </div>
        </div>
      </article>
    <?php else: ?>
      <div class="notice-box mx-1"><i class="bi bi-info-circle"></i><span>Não há boletos a vencer no momento.</span></div>
    <?php endif; ?>


<?php if ($proximoVencimento): ?>
<div class="modal fade" id="pixModal" tabindex="-1" aria-labelledby="pixModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-6 fw-bold" id="pixModalLabel">Pagar com PIX</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="pix-qr" aria-hidden="true"><i class="bi bi-qr-code"></i></div>
        <p class="text-center text-secondary small">Escaneie o QR Code no app do seu banco ou use o código copia e cola. Valor: <strong><?= formatCurrency($proximoVencimento['value']) ?></strong></p>
        <label class="form-label" for="pixCode">PIX copia e cola</label>
        <div class="input-group">
          <input class="form-control" id="pixCode" type="text" readonly value="<?= e($proximoVencimento['pix_code']) ?>">
          <button class="btn btn-accent" type="button" data-copy="<?= e($proximoVencimento['pix_code']) ?>" data-copy-message="Código PIX copiado.">Copiar</button>
        </div>
        <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>QR Code e código ilustrativos. Serão gerados pelo backend na versão integrada.</span></div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="copyToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="copyToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const toastEl = document.getElementById('copyToast');
  const toastBody = document.getElementById('copyToastBody');
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3500 });

  const copyText = async (text) => {
    try {
      await navigator.clipboard.writeText(text);
      return true;
    } catch (error) {
      const area = document.createElement('textarea');
      area.value = text;
      area.style.position = 'fixed';
      area.style.opacity = '0';
      document.body.appendChild(area);
      area.select();
      let copied = false;
      try { copied = document.execCommand('copy'); } catch (err) { copied = false; }
      area.remove();
      return copied;
    }
  };

  document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
      const copied = await copyText(button.dataset.copy);
      toastEl.classList.toggle('text-bg-success', copied);
      toastEl.classList.toggle('text-bg-danger', !copied);
      toastBody.textContent = copied ? button.dataset.copyMessage : 'Não foi possível copiar. Selecione o código e copie manualmente.';
      toast.show();
    });
  });
});
</script>
<?php renderPageEnd(); ?>