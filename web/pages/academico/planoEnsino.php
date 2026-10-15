<?php
require_once __DIR__ . '/../../components/layout.php';

renderAcademicPageStart('Plano de Ensino');
?>
      <section class="academic-page-grid">
        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-journal-richtext', 'Disciplinas do semestre', 'Consulte os conteúdos e critérios previstos para cada disciplina.'); ?>
          <div class="grid-card__body">
            <div class="academic-list">
              <?php foreach (studentDisciplines() as $discipline): ?>
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

        <section class="grid-card">
          <?php renderCardHead('bi-info-square', 'O que você encontra', 'Informações disponíveis em cada plano.'); ?>
          <div class="grid-card__body">
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