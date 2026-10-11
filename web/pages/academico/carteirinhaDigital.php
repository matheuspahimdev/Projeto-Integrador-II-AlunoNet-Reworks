<?php
require_once '../../components/layout.php';
renderHead('Carteirinha Digital', 'dark', '../../', false);

$aluno = [
    'name' => 'Victor H. Oliveira',
    'initials' => 'VO',
    'course' => 'Engenharia de Software',
    'registration' => '274769',
    'period' => 'Noturno',
    'semester' => '2026/2',
    'status' => 'Aluno regular',
];

$validations = [
    ['label' => 'Identificação acadêmica', 'value' => 'Ativa'],
    ['label' => 'Vínculo acadêmico', 'value' => 'Regular'],
    ['label' => 'Validade', 'value' => 'Semestre 2026/2'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Carteirinha Digital'); ?>

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
            <div class="digital-card__avatar"><?= htmlspecialchars($aluno['initials'], ENT_QUOTES, 'UTF-8') ?></div>
            <div class="digital-card__name"><?= htmlspecialchars($aluno['name'], ENT_QUOTES, 'UTF-8') ?></div>
            <div class="digital-card__course"><?= htmlspecialchars($aluno['course'], ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars($aluno['period'], ENT_QUOTES, 'UTF-8') ?></div>
            <div class="digital-card__ra">RA <?= htmlspecialchars($aluno['registration'], ENT_QUOTES, 'UTF-8') ?></div>
            <div class="digital-card__footer"><span><?= htmlspecialchars($aluno['semester'], ENT_QUOTES, 'UTF-8') ?></span><span><?= htmlspecialchars($aluno['status'], ENT_QUOTES, 'UTF-8') ?></span></div>
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
              <li><span><?= htmlspecialchars($validation['label'], ENT_QUOTES, 'UTF-8') ?></span><strong><?= htmlspecialchars($validation['value'], ENT_QUOTES, 'UTF-8') ?></strong></li>
            <?php endforeach; ?>
          </ul>
          <div class="qr-placeholder mt-3"><i class="bi bi-qr-code"></i><span>QR CODE</span></div>
          <button class="btn btn-primary w-100 mt-3" type="button"><i class="bi bi-download me-1"></i>Salvar carteirinha</button>
          <p class="text-secondary small mt-3 mb-0">O QR Code poderá ser validado pela instituição quando o recurso estiver integrado.</p>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
