<?php
require_once '../../components/layout.php';
renderHead('Carteirinha Digital', 'dark', '../../', false);
?>
<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>
    <section class="hero-header-pages">
      <div>
        <h1 class="display-6">Carteirinha Digital</h1>
        <p class="text-secondary mb-0">Central Acadêmica • Engenharia de Software • 2026/2</p>
      </div>
      <a class="btn btn-outline-primary" href="centralAcademico.php"><i class="bi bi-arrow-left me-1"></i>Central Acadêmica</a>
    </section>
    <div class="academic-page-grid "><section class="academic-panel academic-panel--wide">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-person-badge"></i></div><div><h2>Carteirinha do aluno</h2></div></div>
      <div class="academic-panel__body"><div class="digital-card"><div class="digital-card__brand">UNIFIO</div><div class="digital-card__avatar">VO</div><div class="digital-card__name">Victor H. Oliveira</div><div class="digital-card__course">Engenharia de Software</div><div class="digital-card__ra">RA 274769</div><div class="digital-card__footer"><span>2026/2</span><span>Aluno Regular</span></div></div></div>
    </section><section class="academic-panel ">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-qr-code"></i></div><div><h2>Validação</h2></div></div>
      <div class="academic-panel__body"><p class="text-secondary">Apresente o QR Code da carteirinha para validação quando o recurso estiver integrado ao sistema.</p><div class="qr-placeholder"><i class="bi bi-qr-code"></i><span>QR CODE</span></div><button class="btn btn-primary w-100 mt-3"><i class="bi bi-download me-1"></i>Salvar carteirinha</button></div>
    </section></div>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>