<?php
require_once '../../components/layout.php';
renderHead('Atualização de Dados Cadastrais', 'dark', '../../', false);

$campos = [
    ['label' => 'Nome completo', 'name' => 'full_name', 'value' => 'Victor H. Oliveira', 'type' => 'text', 'column' => 'col-md-6'],
    ['label' => 'E-mail institucional', 'name' => 'email', 'value' => 'victor.oliveira@aluno.edu.br', 'type' => 'email', 'column' => 'col-md-6'],
    ['label' => 'Telefone', 'name' => 'phone', 'value' => '(14) 99999-0000', 'type' => 'tel', 'column' => 'col-md-6'],
    ['label' => 'CEP', 'name' => 'zip_code', 'value' => '19900-000', 'type' => 'text', 'column' => 'col-md-6'],
    ['label' => 'Endereço', 'name' => 'address', 'value' => 'Rua Exemplo', 'type' => 'text', 'column' => 'col-md-8'],
    ['label' => 'Número', 'name' => 'number', 'value' => '100', 'type' => 'text', 'column' => 'col-md-4'],
];
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>
    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Atualização de Dados Cadastrais'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic">
      <section class="g-box g-col-3 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-pencil-square"></i></div>
          <div>
            <h2>Atualizar informações</h2>
            <p class="grid-card__subtitle">Revise os dados antes de enviar uma solicitação de alteração.</p>
          </div>
        </div>
        <div class="grid-card__body">
          <form class="academic-form" method="post" action="">
            <div class="row g-3">
              <?php foreach ($campos as $campo): ?>
                <div class="<?= htmlspecialchars($campo['column'], ENT_QUOTES, 'UTF-8') ?>">
                  <label class="form-label" for="<?= htmlspecialchars($campo['name'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($campo['label'], ENT_QUOTES, 'UTF-8') ?></label>
                  <input class="form-control" id="<?= htmlspecialchars($campo['name'], ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($campo['name'], ENT_QUOTES, 'UTF-8') ?>" type="<?= htmlspecialchars($campo['type'], ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($campo['value'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              <?php endforeach; ?>
            </div>
            <div class="notice-box mt-4"><i class="bi bi-info-circle"></i><span>Em uma versão integrada, as alterações serão enviadas para análise e validação da secretaria.</span></div>
            <button type="button" class="btn btn-primary mt-3"><i class="bi bi-check2 me-1"></i>Enviar atualização</button>
          </form>
        </div>
      </section>

      <section class="g-box g-col-1 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-exclamation-circle"></i></div>
          <div><h2>Atenção</h2><p class="grid-card__subtitle">Antes de salvar suas alterações.</p></div>
        </div>
        <div class="grid-card__body">
          <ul class="clean-list">
            <li><span>Confira o e-mail informado</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Mantenha o telefone atualizado</span><i class="bi bi-check2 text-success"></i></li>
            <li><span>Use seu endereço atual</span><i class="bi bi-check2 text-success"></i></li>
          </ul>
          <p class="text-secondary small mt-3 mb-0">Dados corretos ajudam a instituição a enviar comunicados acadêmicos importantes.</p>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
