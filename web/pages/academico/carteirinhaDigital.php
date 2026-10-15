<?php
require_once __DIR__ . '/../../components/layout.php';

$validations = [
    ['label' => 'Identificação acadêmica', 'value' => 'Ativa'],
    ['label' => 'Vínculo acadêmico', 'value' => 'Regular'],
    ['label' => 'Validade', 'value' => 'Semestre ' . currentStudent()['term']],
];

renderAcademicPageStart('Carteirinha Digital');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-person-badge', 'Identificação do aluno', 'Apresente esta identificação em ambientes e serviços da instituição.'); ?>
          <div class="grid-card__body">
            <div class="digital-card">
              <div class="digital-card__brand">UNIFIO</div>
              <div class="digital-card__avatar"><?= e(studentInitials()) ?></div>
              <div class="digital-card__name"><?= e(currentStudent()['name']) ?></div>
              <div class="digital-card__course"><?= e(currentStudent()['course']) ?> • <?= e(currentStudent()['period']) ?></div>
              <div class="digital-card__ra">RA <?= e(currentStudent()['registration']) ?></div>
              <div class="digital-card__footer"><span><?= e(currentStudent()['term']) ?></span><span>Aluno regular</span></div>
            </div>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-qr-code', 'Validação', 'Confira a situação da carteirinha.'); ?>
          <div class="grid-card__body">
            <ul class="clean-list">
              <?php foreach ($validations as $validation): ?>
                <li><span><?= e($validation['label']) ?></span><strong><?= e($validation['value']) ?></strong></li>
              <?php endforeach; ?>
            </ul>
            <div class="qr-placeholder mt-3"><i class="bi bi-qr-code"></i><span>QR CODE</span></div>
            <button class="btn btn-primary w-100 mt-3" type="button"><i class="bi bi-download me-1"></i>Salvar carteirinha</button>
            <p class="text-secondary small mt-3 mb-0">O QR Code poderá ser validado pela instituição quando o recurso estiver integrado.</p>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>