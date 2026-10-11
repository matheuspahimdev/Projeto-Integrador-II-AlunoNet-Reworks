<?php
require_once __DIR__ . '/../../components/layout.php';

$academicData = [
    ['label' => 'Nome completo', 'value' => STUDENT['name']],
    ['label' => 'RA', 'value' => STUDENT['registration']],
    ['label' => 'Curso', 'value' => STUDENT['course']],
    ['label' => 'Período', 'value' => STUDENT['period']],
    ['label' => 'Semestre atual', 'value' => STUDENT['semester'] . ' • ' . STUDENT['term']],
    ['label' => 'Situação acadêmica', 'value' => STUDENT['status'], 'badge' => true],
    ['label' => 'E-mail institucional', 'value' => STUDENT['email']],
    ['label' => 'Telefone', 'value' => STUDENT['phone']],
];

$contacts = [
    ['label' => 'E-mail alternativo', 'value' => STUDENT['alternative_email']],
    ['label' => 'Cidade', 'value' => STUDENT['city']],
    ['label' => 'Última atualização', 'value' => formatDate('2026-08-08')],
];

renderPageStart('Consultar Dados Cadastrais');
renderAcademicHeader('Consultar Dados Cadastrais');
?>
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

        <section class="academic-panel">
          <div class="academic-panel__head">
            <div class="academic-panel__icon"><i class="bi bi-person-lines-fill"></i></div>
            <div><h2>Contato e atualização</h2><p class="academic-panel__subtitle">Dados usados para comunicação acadêmica.</p></div>
          </div>
          <div class="academic-panel__body">
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