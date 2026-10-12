<?php
require_once '../../components/layout.php';
renderHead('Atividades Complementares', 'dark', '../../', false);

$atividades = [
    ['name' => 'Curso de extensão', 'category' => 'Formação complementar', 'hours' => 20, 'status' => 'Deferido', 'status_class' => 'text-bg-success'],
    ['name' => 'Evento acadêmico', 'category' => 'Participação em evento', 'hours' => 10, 'status' => 'Deferido', 'status_class' => 'text-bg-success'],
    ['name' => 'Projeto voluntário', 'category' => 'Responsabilidade social', 'hours' => 30, 'status' => 'Deferido', 'status_class' => 'text-bg-success'],
    ['name' => 'Workshop de tecnologia', 'category' => 'Aperfeiçoamento profissional', 'hours' => 20, 'status' => 'Deferido', 'status_class' => 'text-bg-success'],
    ['name' => 'Palestra sobre inovação', 'category' => 'Aguardando análise', 'hours' => 10, 'status' => 'Em análise', 'status_class' => 'text-bg-warning'],
];

$requiredHours = 160;
$completedHours = array_sum(array_map(static fn (array $activity): int => $activity['status'] === 'Deferido' ? $activity['hours'] : 0, $atividades));
$pendingHours = array_sum(array_map(static fn (array $activity): int => $activity['status'] === 'Em análise' ? $activity['hours'] : 0, $atividades));
$remainingHours = max(0, $requiredHours - $completedHours);
$progress = (int) round(($completedHours / $requiredHours) * 100);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Atividades Complementares'); ?>

    <section class="grid-mesh grid-mesh--static grid-mesh--academic">
      <section class="g-box g-col-1 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-trophy"></i></div>
          <div><h2>Carga horária</h2><p class="grid-card__subtitle">Acompanhe o cumprimento das horas exigidas.</p></div>
        </div>
        <div class="grid-card__body">
          <div class="metric-grid">
            <div><span>Horas cumpridas</span><strong><?= $completedHours ?>h</strong></div>
            <div><span>Horas exigidas</span><strong><?= $requiredHours ?>h</strong></div>
            <div><span>Restantes</span><strong><?= $remainingHours ?>h</strong></div>
          </div>
          <div class="progress mt-4" role="progressbar" aria-label="Atividades complementares" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width:<?= $progress ?>%"><?= $progress ?>%</div></div>
          <small class="d-block text-secondary mt-2"><?= $pendingHours ?>h aguardando análise.</small>
        </div>
      </section>

      <section class="g-box g-col-3 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-journal-check"></i></div>
          <div><h2>Atividades registradas</h2><p class="grid-card__subtitle">Acompanhe o resultado da análise de cada comprovante.</p></div>
        </div>
        <div class="grid-card__body">
          <div class="academic-list">
            <?php foreach ($atividades as $atividade): ?>
              <article class="academic-list__item">
                <div>
                  <strong><?= htmlspecialchars($atividade['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <small><?= htmlspecialchars($atividade['category'], ENT_QUOTES, 'UTF-8') ?> • <?= $atividade['hours'] ?> horas</small>
                </div>
                <span class="badge <?= $atividade['status_class'] ?>"><?= htmlspecialchars($atividade['status'], ENT_QUOTES, 'UTF-8') ?></span>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="g-box g-col-1 grid-card">
        <div class="grid-card__head">
          <div class="grid-card__icon"><i class="bi bi-cloud-arrow-up"></i></div>
          <div><h2>Enviar comprovante</h2><p class="grid-card__subtitle">Registre uma nova atividade acadêmica.</p></div>
        </div>
        <div class="grid-card__body">
          <p class="text-secondary">Cadastre a atividade, informe a carga horária e envie o comprovante para análise da coordenação.</p>
          <button class="btn btn-primary w-100" type="button"><i class="bi bi-upload me-1"></i>Nova atividade</button>
          <div class="notice-box mt-3"><i class="bi bi-info-circle"></i><span>Os comprovantes devem estar legíveis e conter a data e a carga horária da atividade.</span></div>
        </div>
      </section>
    </section>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>
