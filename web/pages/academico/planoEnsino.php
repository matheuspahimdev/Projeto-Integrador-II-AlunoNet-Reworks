<?php
require_once __DIR__ . '/../../components/layout.php';

renderPageStart('Plano de Ensino');
renderAcademicHeader('Plano de Ensino');
?>
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
              <?php foreach (DISCIPLINES as $discipline): ?>
                <article class="academic-list__item">
                  <div>
                    <strong><?= e($discipline['name']) ?></strong>
                    <small><?= formatHours($discipline['workload']) ?> • <?= e($discipline['teacher']) ?> • <?= e($discipline['method']) ?></small>
                  </div>
                  <span class="badge <?= statusBadge('Publicado') ?>">Publicado</span>
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
<?php renderPageEnd(); ?>