<?php
require_once __DIR__ . '/../../components/layout.php';

$academicData = [
    ['label' => 'Nome completo', 'value' => currentStudent()['name']],
    ['label' => 'RA', 'value' => currentStudent()['registration']],
    ['label' => 'Curso', 'value' => currentStudent()['course']],
    ['label' => 'Período', 'value' => currentStudent()['period']],
    ['label' => 'Semestre atual', 'value' => currentStudent()['semester'] . ' • ' . currentStudent()['term']],
    ['label' => 'Situação acadêmica', 'value' => currentStudent()['status'], 'badge' => true],
    ['label' => 'E-mail institucional', 'value' => currentStudent()['email']],
    ['label' => 'Telefone', 'value' => currentStudent()['phone']],
];

$contacts = [
    ['label' => 'E-mail alternativo', 'value' => currentStudent()['alternative_email']],
    ['label' => 'Cidade', 'value' => currentStudent()['city']],
    ['label' => 'Última atualização', 'value' => formatDate('2026-08-08')],
];

renderAcademicPageStart('Consultar Dados Cadastrais');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-person-vcard', 'Dados do aluno', 'Informações acadêmicas registradas no portal.'); ?>
          <div class="grid-card__body">
            <dl class="data-grid">
              <?php foreach ($academicData as $item): ?>
                <div>
                  <dt><?= e($item['label']) ?></dt>
                  <dd>
                    <?php if (isset($item['badge'])): ?>
                      <span class="badge <?= statusBadge($item['value']) ?>"><?= e($item['value']) ?></span>
                    <?php else: ?>
                      <?= e($item['value']) ?>
                    <?php endif; ?>
                  </dd>
                </div>
              <?php endforeach; ?>
            </dl>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-person-lines-fill', 'Contato e atualização', 'Dados usados para comunicação acadêmica.'); ?>
          <div class="grid-card__body">
            <dl class="data-grid data-grid--single">
              <?php foreach ($contacts as $item): ?>
                <div><dt><?= e($item['label']) ?></dt><dd><?= e($item['value']) ?></dd></div>
              <?php endforeach; ?>
            </dl>
            <a href="atualizacaoDadosCadastrais.php" class="btn btn-primary w-100 mt-3"><i class="bi bi-pencil-square me-1"></i>Atualizar dados</a>
            <p class="text-secondary small mt-3 mb-0">Mantenha seus contatos atualizados para receber avisos da instituição.</p>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>