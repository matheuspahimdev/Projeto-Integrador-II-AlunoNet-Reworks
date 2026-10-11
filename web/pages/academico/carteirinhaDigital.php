<?php
require_once __DIR__ . '/../../components/layout.php';

$validations = [
    ['label' => 'Identificação acadêmica', 'value' => 'Ativa'],
    ['label' => 'Vínculo acadêmico', 'value' => 'Regular'],
    ['label' => 'Validade', 'value' => 'Semestre ' . STUDENT['term']],
];

renderPageStart('Carteirinha Digital');
renderAcademicHeader('Carteirinha Digital');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-person-badge"></i></div>
            <div>
              <h2>Identificação do aluno</h2>
              <p class="academic-panel__subtitle">Apresente esta identificação em ambientes e serviços da instituição.</p>
            </div>
          </div>
          <div class="academic-panel__body">
            <div class="digital-card">
              <div class="digital-card__brand">UNIFIO</div>
              <div class="digital-card__avatar"><?= e(studentInitials()) ?></div>
              <div class="digital-card__name"><?= e(STUDENT['name']) ?></div>
              <div class="digital-card__course"><?= e(STUDENT['course']) ?> • <?= e(STUDENT['period']) ?></div>
              <div class="digital-card__ra">RA <?= e(STUDENT['registration']) ?></div>
              <div class="digital-card__footer"><span><?= e(STUDENT['term']) ?></span><span>Aluno regular</span></div>
            </div>
          </div>
        </section>

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-qr-code"></i></div>
            <div><h2>Validação</h2><p class="academic-panel__subtitle">Confira a situação da carteirinha.</p></div>
          </div>
          <div class="academic-panel__body">
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