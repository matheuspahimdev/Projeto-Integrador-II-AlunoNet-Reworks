<?php
require_once '../../components/layout.php';
renderHead('Atividades Complementares', 'dark', '../../', false);
?>
<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>
    <section class="hero-header-pages">
      <div>
        <h1 class="display-6">Atividades Complementares</h1>
        <p class="text-secondary mb-0">Central Acadêmica • Engenharia de Software • 2026/2</p>
      </div>
      <a class="btn btn-outline-primary" href="centralAcademico.php"><i class="bi bi-arrow-left me-1"></i>Central Acadêmica</a>
    </section>
    <div class="academic-page-grid "><section class="academic-panel ">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-trophy"></i></div><div><h2>Carga horária</h2></div></div>
      <div class="academic-panel__body"><div class="metric-grid"><div><span>Horas cumpridas</span><strong>80h</strong></div><div><span>Horas exigidas</span><strong>160h</strong></div><div><span>Restantes</span><strong>80h</strong></div></div><div class="progress mt-4" role="progressbar" aria-label="Atividades complementares" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width:50%">50%</div></div></div>
    </section><section class="academic-panel academic-panel--wide">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-journal-check"></i></div><div><h2>Atividades registradas</h2></div></div>
      <div class="academic-panel__body"><div class="academic-list"><div class="academic-list__item"><div><strong>Curso de extensão</strong><small>20 horas • Deferido</small></div><span class="badge text-bg-success">20h</span></div><div class="academic-list__item"><div><strong>Evento acadêmico</strong><small>10 horas • Deferido</small></div><span class="badge text-bg-success">10h</span></div><div class="academic-list__item"><div><strong>Projeto voluntário</strong><small>30 horas • Deferido</small></div><span class="badge text-bg-success">30h</span></div><div class="academic-list__item"><div><strong>Workshop de tecnologia</strong><small>20 horas • Deferido</small></div><span class="badge text-bg-success">20h</span></div></div></div>
    </section><section class="academic-panel ">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-cloud-arrow-up"></i></div><div><h2>Enviar comprovante</h2></div></div>
      <div class="academic-panel__body"><p class="text-secondary">Cadastre uma nova atividade e envie o comprovante para análise da coordenação.</p><button class="btn btn-primary w-100"><i class="bi bi-upload me-1"></i>Nova atividade</button></div>
    </section></div>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>