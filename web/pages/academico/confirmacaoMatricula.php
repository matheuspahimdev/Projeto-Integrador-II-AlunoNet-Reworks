<?php
require_once '../../components/layout.php';
renderHead('Confirmação de Matrícula', 'dark', '../../', false);

$matricula = [
    ['label' => 'RA', 'value' => '274769'],
    ['label' => 'Curso', 'value' => 'Engenharia de Software'],
    ['label' => 'Modalidade', 'value' => 'Presencial'],
    ['label' => 'Período', 'value' => 'Noturno'],
    ['label' => 'Disciplinas matriculadas', 'value' => '6'],
    ['label' => 'Data da confirmação', 'value' => '10/08/2026'],
];

$etapas = [
    ['label' => 'Solicitação de matrícula', 'date' => '08/08/2026', 'status' => 'Concluída', 'icon' => 'bi-check-circle-fill'],
    ['label' => 'Análise acadêmica', 'date' => '09/08/2026', 'status' => 'Concluída', 'icon' => 'bi-check-circle-fill'],
    ['label' => 'Confirmação do semestre', 'date' => '10/08/2026', 'status' => 'Concluída', 'icon' => 'bi-check-circle-fill'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Confirmação de Matrícula'); ?>

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
            <div><strong>Matrícula confirmada</strong><span>2026/2 • Engenharia de Software • 2º semestre</span></div>
          </div>
          <hr>
          <dl class="data-grid">
            <?php foreach ($matricula as $item): ?>
              <div><dt><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></dt><dd><?= htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8') ?></dd></div>
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
            <?php foreach ($etapas as $etapa): ?>
              <li>
                <span><strong><?= htmlspecialchars($etapa['label'], ENT_QUOTES, 'UTF-8') ?></strong><small><?= htmlspecialchars($etapa['date'], ENT_QUOTES, 'UTF-8') ?></small></span>
                <i class="bi <?= $etapa['icon'] ?> text-success" title="<?= htmlspecialchars($etapa['status'], ENT_QUOTES, 'UTF-8') ?>"></i>
              </li>
            <?php endforeach; ?>
          </ul>
          <button class="btn btn-outline-primary w-100 mt-3" type="button"><i class="bi bi-file-earmark-pdf me-1"></i>Visualizar comprovante</button>
          <p class="text-secondary small mt-3 mb-0">O documento será gerado em PDF quando a secretaria estiver integrada ao portal.</p>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
