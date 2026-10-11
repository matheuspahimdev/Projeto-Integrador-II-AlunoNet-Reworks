<?php
require_once '../../components/layout.php';
renderHead('Plano de Ensino', 'dark', '../../', false);

$disciplinas = [
    ['name' => 'Laboratório de Programação de Computadores', 'workload' => '80h', 'teacher' => 'Prof. Marcelo Santos', 'method' => 'Aulas práticas', 'status' => 'Publicado'],
    ['name' => 'Engenharia de Requisitos', 'workload' => '80h', 'teacher' => 'Profa. Renata Lima', 'method' => 'Aulas presenciais', 'status' => 'Publicado'],
    ['name' => 'Projeto Integrador II', 'workload' => '80h', 'teacher' => 'Prof. André Oliveira', 'method' => 'Projeto em grupo', 'status' => 'Publicado'],
    ['name' => 'Resolução Diferenciada de Problemas', 'workload' => '80h', 'teacher' => 'Profa. Camila Rocha', 'method' => 'Estudos de caso', 'status' => 'Publicado'],
    ['name' => 'Empreendedorismo', 'workload' => '40h', 'teacher' => 'Prof. Eduardo Martins', 'method' => 'Aulas online', 'status' => 'Publicado'],
    ['name' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'workload' => '40h', 'teacher' => 'Profa. Juliana Alves', 'method' => 'Aulas online', 'status' => 'Publicado'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Plano de Ensino'); ?>

    <section class="academic-page-grid">
      <section class="academic-panel academic-panel--wide">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-journal-richtext"></i></div>
          <div>
            <h2>Disciplinas do semestre</h2>
            <p class="academic-panel__subtitle">Consulte os conteúdos e critérios previstos para cada disciplina.</p>
          </div>
        </div>
        <div class="academic-panel__body">
          <div class="academic-list">
            <?php foreach ($disciplinas as $disciplina): ?>
              <article class="academic-list__item">
                <div>
                  <strong><?= htmlspecialchars($disciplina['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <small><?= htmlspecialchars($disciplina['workload'], ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars($disciplina['teacher'], ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars($disciplina['method'], ENT_QUOTES, 'UTF-8') ?></small>
                </div>
                <span class="badge text-bg-success"><?= htmlspecialchars($disciplina['status'], ENT_QUOTES, 'UTF-8') ?></span>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="academic-panel">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-info-square"></i></div>
          <div><h2>O que você encontra</h2><p class="academic-panel__subtitle">Informações disponíveis em cada plano.</p></div>
        </div>
        <div class="academic-panel__body">
          <ul class="clean-list">
            <li><span>Ementa e objetivos</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Conteúdo programático</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Metodologia de ensino</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Critérios de avaliação</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Bibliografia</span><i class="bi bi-check2 text-success"></i></li>
          </ul>
          <div class="notice-box mt-3"><i class="bi bi-lightbulb"></i><span>Use o plano para organizar seus estudos e entender como cada disciplina será conduzida.</span></div>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
