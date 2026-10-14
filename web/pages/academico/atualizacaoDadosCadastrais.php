<?php
require_once __DIR__ . '/../../components/layout.php';

$fields = [
    ['label' => 'Nome completo', 'name' => 'full_name', 'value' => STUDENT['name'], 'type' => 'text', 'column' => 'col-md-6'],
    ['label' => 'E-mail institucional', 'name' => 'email', 'value' => STUDENT['email'], 'type' => 'email', 'column' => 'col-md-6'],
    ['label' => 'Telefone', 'name' => 'phone', 'value' => STUDENT['phone'], 'type' => 'tel', 'column' => 'col-md-6'],
    ['label' => 'CEP', 'name' => 'zip_code', 'value' => STUDENT['zip_code'], 'type' => 'text', 'column' => 'col-md-6'],
    ['label' => 'Endereço', 'name' => 'address', 'value' => STUDENT['address'], 'type' => 'text', 'column' => 'col-md-8'],
    ['label' => 'Número', 'name' => 'number', 'value' => STUDENT['address_number'], 'type' => 'text', 'column' => 'col-md-4'],
];

renderPageStart('Atualização de Dados Cadastrais');
renderAcademicHeader('Atualização de Dados Cadastrais');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-pencil-square', 'Atualizar informações', 'Revise os dados antes de enviar uma solicitação de alteração.'); ?>
          <div class="grid-card__body">
            <form class="academic-form" method="post" action="">
              <div class="row g-3">
                <?php foreach ($fields as $field): ?>
                  <div class="<?= e($field['column']) ?>">
                    <label class="form-label" for="<?= e($field['name']) ?>"><?= e($field['label']) ?></label>
                    <input class="form-control" id="<?= e($field['name']) ?>" name="<?= e($field['name']) ?>" type="<?= e($field['type']) ?>" value="<?= e($field['value']) ?>">
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="notice-box mt-4"><i class="bi bi-info-circle"></i><span>Em uma versão integrada, as alterações serão enviadas para análise e validação da secretaria.</span></div>
              <button type="button" class="btn btn-primary mt-3"><i class="bi bi-check2 me-1"></i>Enviar atualização</button>
            </form>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-exclamation-circle', 'Atenção', 'Antes de salvar suas alterações.'); ?>
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
<?php renderPageEnd(); ?>