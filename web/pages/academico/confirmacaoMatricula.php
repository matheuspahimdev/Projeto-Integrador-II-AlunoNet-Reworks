<?php
require_once __DIR__ . '/../../components/layout.php';

const ENROLLMENT_CONFIRMATION_DATE = '2026-08-10';

$enrollment = [
    ['label' => 'RA', 'value' => STUDENT['registration']],
    ['label' => 'Curso', 'value' => STUDENT['course']],
    ['label' => 'Modalidade', 'value' => STUDENT['modality']],
    ['label' => 'Período', 'value' => STUDENT['period']],
    ['label' => 'Disciplinas matriculadas', 'value' => count(DISCIPLINES)],
    ['label' => 'Data da confirmação', 'value' => formatDate(ENROLLMENT_CONFIRMATION_DATE)],
];

$steps = [
    ['label' => 'Solicitação de matrícula', 'date' => '2026-08-08'],
    ['label' => 'Análise acadêmica', 'date' => '2026-08-09'],
    ['label' => 'Confirmação do semestre', 'date' => ENROLLMENT_CONFIRMATION_DATE],
];

renderPageStart('Confirmação de Matrícula');
renderAcademicHeader('Confirmação de Matrícula');
?>
      <section class="academic-page-grid">
        <section class="academic-panel academic-panel--wide">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-patch-check"></i></div>
            <div>
              <h2>Situação da matrícula</h2>
              <p class="academic-panel__subtitle">Confira o vínculo acadêmico e as disciplinas do período.</p>
            </div>
          </div>
          <div class="academic-panel__body">
            <div class="status-card">
              <i class="bi bi-patch-check-fill"></i>
              <div><strong>Matrícula confirmada</strong><span><?= e(STUDENT['term']) ?> • <?= e(STUDENT['course']) ?> • <?= e(STUDENT['semester']) ?></span></div>
            </div>
            <hr>
            <dl class="data-grid">
              <?php foreach ($enrollment as $item): ?>
                <div><dt><?= e($item['label']) ?></dt><dd><?= e($item['value']) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        </section>

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-list-check"></i></div>
            <div><h2>Etapas concluídas</h2><p class="academic-panel__subtitle">Histórico da confirmação no portal.</p></div>
          </div>
          <div class="academic-panel__body">
            <ul class="clean-list">
              <?php foreach ($steps as $step): ?>
                <li>
                  <span><strong><?= e($step['label']) ?></strong><small><?= formatDate($step['date']) ?></small></span>
                  <i class="bi bi-check-circle-fill text-success" title="Concluída"></i>
                </li>
              <?php endforeach; ?>
            </ul>
            <button class="btn btn-outline-primary w-100 mt-3" type="button"><i class="bi bi-file-earmark-pdf me-1"></i>Visualizar comprovante</button>
            <p class="text-secondary small mt-3 mb-0">O documento será gerado em PDF quando a secretaria estiver integrada ao portal.</p>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>