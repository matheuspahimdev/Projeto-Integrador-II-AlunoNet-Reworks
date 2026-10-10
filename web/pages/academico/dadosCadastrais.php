<?php
require_once '../../components/layout.php';
renderHead('Consultar Dados Cadastrais', 'dark', '../../', false);

$dadosAcademicos = [
    ['label' => 'Nome completo', 'value' => 'Victor H. Oliveira'],
    ['label' => 'RA', 'value' => '274769'],
    ['label' => 'Curso', 'value' => 'Engenharia de Software'],
    ['label' => 'Período', 'value' => 'Noturno'],
    ['label' => 'Semestre atual', 'value' => '2º semestre • 2026/2'],
    ['label' => 'Situação acadêmica', 'value' => 'Matriculado', 'badge' => 'text-bg-success'],
    ['label' => 'E-mail institucional', 'value' => 'victor.oliveira@aluno.edu.br'],
    ['label' => 'Telefone', 'value' => '(14) 99999-0000'],
];

$contatos = [
    ['label' => 'E-mail alternativo', 'value' => 'victor.oliveira@email.com'],
    ['label' => 'Cidade', 'value' => 'Ourinhos - SP'],
    ['label' => 'Última atualização', 'value' => '08/08/2026'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Consultar Dados Cadastrais'); ?>

    <section class="academic-page-grid">
      <section class="academic-panel academic-panel--wide">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-person-vcard"></i></div>
          <div>
            <h2>Dados do aluno</h2>
            <p class="academic-panel__subtitle">Informações acadêmicas registradas no portal.</p>
          </div>
        </div>
        <div class="academic-panel__body">
          <dl class="data-grid">
            <?php foreach ($dadosAcademicos as $item): ?>
              <div>
                <dt><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></dt>
                <dd>
                  <?php if (isset($item['badge'])): ?>
                    <span class="badge <?= $item['badge'] ?>"><?= htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8') ?></span>
                  <?php else: ?>
                    <?= htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8') ?>
                  <?php endif; ?>
                </dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </div>
      </section>

      <section class="academic-panel">
        <div class="academic-panel__head">
          <div class="academic-panel__icon"><i class="bi bi-person-lines-fill"></i></div>
          <div><h2>Contato e atualização</h2><p class="academic-panel__subtitle">Dados usados para comunicação acadêmica.</p></div>
        </div>
        <div class="academic-panel__body">
          <dl class="data-grid data-grid--single">
            <?php foreach ($contatos as $item): ?>
              <div><dt><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></dt><dd><?= htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <?php endforeach; ?>
          </dl>
          <a href="atualizacaoDadosCadastrais.php" class="btn btn-primary w-100 mt-3"><i class="bi bi-pencil-square me-1"></i>Atualizar dados</a>
          <p class="text-secondary small mt-3 mb-0">Mantenha seus contatos atualizados para receber avisos da instituição.</p>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
