<?php
require_once __DIR__ . '/../../components/layout.php';

$completedHours = approvedComplementaryHours();
$pendingHours = complementaryHoursWithStatus('Em análise');
$remainingHours = max(0, REQUIRED_COMPLEMENTARY_HOURS - $completedHours);
$progress = percentage($completedHours, REQUIRED_COMPLEMENTARY_HOURS);

renderPageStart('Atividades Complementares');
renderAcademicHeader('Atividades Complementares');
?>
      <section class="academic-page-grid">
        <section class="grid-card">
          <?php renderCardHead('bi-trophy', 'Carga horária', 'Acompanhe o cumprimento das horas exigidas.'); ?>
          <div class="grid-card__body">
            <div class="metric-grid">
              <div><span>Horas cumpridas</span><strong><?= formatHours($completedHours) ?></strong></div>
              <div><span>Horas exigidas</span><strong><?= formatHours(REQUIRED_COMPLEMENTARY_HOURS) ?></strong></div>
              <div><span>Restantes</span><strong><?= formatHours($remainingHours) ?></strong></div>
            </div>
            <div class="progress mt-4" role="progressbar" aria-label="Atividades complementares" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width:<?= $progress ?>%"><?= $progress ?>%</div></div>
            <small class="d-block text-secondary mt-2"><?= formatHours($pendingHours) ?> aguardando análise.</small>
          </div>
        </section>

        <section class="grid-card grid-card--wide">
          <?php renderCardHead('bi-journal-check', 'Atividades registradas', 'Acompanhe o resultado da análise de cada comprovante.'); ?>
          <div class="grid-card__body">
            <div class="academic-list">
              <?php foreach (COMPLEMENTARY_ACTIVITIES as $activity): ?>
                <article class="academic-list__item">
                  <div>
                    <strong><?= e($activity['name']) ?></strong>
                    <small><?= e($activity['category']) ?> • <?= $activity['hours'] ?> horas</small>
                  </div>
                  <span class="badge <?= statusBadge($activity['status']) ?>"><?= e($activity['status']) ?></span>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <section class="grid-card">
          <?php renderCardHead('bi-cloud-arrow-up', 'Enviar comprovante', 'Registre uma nova atividade acadêmica.'); ?>
          <div class="grid-card__body">
            <p class="text-secondary">Cadastre a atividade, informe a carga horária e envie o comprovante para análise da coordenação.</p>
            <button class="btn btn-primary w-100" type="button"><i class="bi bi-upload me-1"></i>Nova atividade</button>
            <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>Os comprovantes devem estar legíveis e conter a data e a carga horária da atividade.</span></div>
          </div>
        </section>
      </section>
<?php renderPageEnd(); ?>