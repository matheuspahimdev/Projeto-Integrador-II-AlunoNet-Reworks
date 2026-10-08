<?php
require_once '../../components/layout.php';
renderHead('DIC — Documentação Integralização Curricular', 'dark', '../../', false);
?>
<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>
    <section class="hero-header-pages">
      <div>
        <h1 class="display-6">DIC — Documentação Integralização Curricular</h1>
        <p class="text-secondary mb-0">Central Acadêmica • Engenharia de Software • 2026/2</p>
      </div>
      <a class="btn btn-outline-primary" href="centralAcademico.php"><i class="bi bi-arrow-left me-1"></i>Central Acadêmica</a>
    </section>
    <div class="academic-page-grid "><section class="academic-panel academic-panel--wide">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-diagram-3"></i></div><div><h2>Integralização curricular</h2></div></div>
      <div class="academic-panel__body"><div class="progress-summary"><div class="d-flex justify-content-between mb-2"><strong>Progresso do curso</strong><span>62%</span></div><div class="progress" role="progressbar" aria-label="Integralização curricular" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width:62%">62%</div></div></div><div class="metric-grid mt-4"><div><span>Carga concluída</span><strong>1.920h</strong></div><div><span>Carga total</span><strong>3.080h</strong></div><div><span>Semestres concluídos</span><strong>1</strong></div></div></div>
    </section><section class="academic-panel ">
      <div class="academic-panel__head"><div class="academic-panel__icon"><i class="bi bi-list-check"></i></div><div><h2>Componentes curriculares</h2></div></div>
      <div class="academic-panel__body"><ul class="clean-list"><li><span>Disciplinas obrigatórias</span><strong>1.680h / 2.520h</strong></li><li><span>Atividades complementares</span><strong>80h / 160h</strong></li><li><span>Projeto Integrador</span><strong>120h / 200h</strong></li><li><span>Optativas</span><strong>40h / 200h</strong></li></ul></div>
    </section></div>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>