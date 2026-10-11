<?php
require_once '../../components/layout.php';
renderHead('Horário de Aulas', 'dark', '../../', false);

$hours = [
  'Segunda' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Laboratório de Programação de Computadores', 'code' => 'ESFT2B - M220938', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--blue'],
    ['time' => '20:05 - 20:55', 'subject' => 'Laboratório de Programação de Computadores', 'code' => 'ESFT2B - M220938', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--blue'],
    ['time' => '21:10 - 22:00', 'subject' => 'Laboratório de Programação de Computadores', 'code' => 'ESFT2B - M220938', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--blue'],
    ['time' => '22:00 - 22:50', 'subject' => 'Laboratório de Programação de Computadores', 'code' => 'ESFT2B - M220938', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--blue'],
  ],
  'Terça' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Engenharia de Requisitos', 'code' => 'ESFT2B - M220939', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--green'],
    ['time' => '20:05 - 20:55', 'subject' => 'Engenharia de Requisitos', 'code' => 'ESFT2B - M220939', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--green'],
    ['time' => '21:10 - 22:00', 'subject' => 'Engenharia de Requisitos', 'code' => 'ESFT2B - M220939', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--green'],
    ['time' => '22:00 - 22:50', 'subject' => 'Engenharia de Requisitos', 'code' => 'ESFT2B - M220939', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--green'],
  ],
  'Quarta' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Projeto Integrador II', 'code' => 'ESFT2B - 5841', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--purple'],
    ['time' => '20:05 - 20:55', 'subject' => 'Projeto Integrador II', 'code' => 'ESFT2B - 5841', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--purple'],
    ['time' => '21:10 - 22:00', 'subject' => 'Projeto Integrador II', 'code' => 'ESFT2B - 5841', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--purple'],
    ['time' => '22:00 - 22:50', 'subject' => 'Projeto Integrador II', 'code' => 'ESFT2B - 5841', 'location' => 'Bloco 2 • Sala 712', 'class' => 'schedule-cell--purple'],
  ],
  'Quinta' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Resolução Diferenciada de Problemas', 'code' => 'ESFT2B - 6014', 'location' => 'Bloco 2 • Sala 725', 'class' => 'schedule-cell--orange'],
    ['time' => '20:05 - 20:55', 'subject' => 'Resolução Diferenciada de Problemas', 'code' => 'ESFT2B - 6014', 'location' => 'Bloco 2 • Sala 725', 'class' => 'schedule-cell--orange'],
    ['time' => '21:10 - 22:00', 'subject' => 'Resolução Diferenciada de Problemas', 'code' => 'ESFT2B - 6014', 'location' => 'Bloco 2 • Sala 725', 'class' => 'schedule-cell--orange'],
    ['time' => '22:00 - 22:50', 'subject' => 'Resolução Diferenciada de Problemas', 'code' => 'ESFT2B - 6014', 'location' => 'Bloco 2 • Sala 725', 'class' => 'schedule-cell--orange'],
  ],
  'Sexta' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Empreendedorismo', 'code' => 'ESFT2B - 1097', 'location' => 'Aula Online', 'class' => 'schedule-cell--soft-blue schedule-cell--online'],
    ['time' => '20:05 - 20:55', 'subject' => 'Empreendedorismo', 'code' => 'ESFT2B - 1097', 'location' => 'Aula Online', 'class' => 'schedule-cell--soft-blue schedule-cell--online'],
    ['time' => '21:10 - 22:00', 'subject' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'code' => 'ESFT2B - M220937', 'location' => 'Aula Online', 'class' => 'schedule-cell--soft-blue schedule-cell--online'],
    ['time' => '22:00 - 22:50', 'subject' => 'Direito Aplicado ao Empreendedorismo e Inovação', 'code' => 'ESFT2B - M220937', 'location' => 'Aula Online', 'class' => 'schedule-cell--soft-blue schedule-cell--online'],
  ],
  'Sábado' => [
    ['time' => '19:15 - 20:05', 'subject' => 'Sem aula', 'code' => '', 'location' => '', 'class' => 'schedule-cell--empty'],
    ['time' => '20:05 - 20:55', 'subject' => 'Sem aula', 'code' => '', 'location' => '', 'class' => 'schedule-cell--empty'],
    ['time' => '21:10 - 22:00', 'subject' => 'Sem aula', 'code' => '', 'location' => '', 'class' => 'schedule-cell--empty'],
    ['time' => '22:00 - 22:50', 'subject' => 'Sem aula', 'code' => '', 'location' => '', 'class' => 'schedule-cell--empty'],
  ],
];

?>

<body>
  <div class="app-shell">
    <nav-bar id="main-navigation"></nav-bar>
    <main class="page-content">
      <portal-header></portal-header>

      <?php require_once '../../components/cabecalhoAcademico.php'; renderHeaderAcademic('Horário de Aulas'); ?>

      <div class="grid-mesh grid-mesh--static">
        <section class="g-box bg-body-secondary border rounded-4 g-col-4 class-schedule-card">
          <div class="class-schedule-card__header">
            <div class="d-flex flex-column gap-1">
              <h2 class="fs-md fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-week me-1"></i>
                Horário de Aulas
              </h2>
              <p class="text-secondary small mb-0 mt-2">
                Engenharia de Software • Período Noturno
              </p>
            </div>

            <span class="badge rounded-pill text-bg-primary class-schedule-card__term">2º Semestre</span>
          </div>

          <div class="class-schedule">
            <div class="table-responsive">
              <table class="class-schedule__table">
                <thead>
                  <tr>
                    <th class="class-schedule__time-header">Horário<br>das aulas</th>
                    <th>Segunda</th>
                    <th>Terça</th>
                    <th>Quarta</th>
                    <th>Quinta</th>
                    <th>Sexta</th>
                    <th>Sábado</th>
                  </tr>
                </thead>

                <tbody>
                  <?php for ($i = 0; $i < count($hours['Segunda']); $i++): ?>
                    <tr>
                      <th><?= htmlspecialchars($hours['Segunda'][$i]['time'], ENT_QUOTES, 'UTF-8') ?></th>
                      <?php foreach ($hours as $day => $classes): ?>
                        <td class="schedule-cell <?= $classes[$i]['class'] ?>">
                          <strong><?= htmlspecialchars($classes[$i]['code'], ENT_QUOTES, 'UTF-8') ?></strong>
                          <span><?= htmlspecialchars($classes[$i]['subject'], ENT_QUOTES, 'UTF-8') ?></span>
                          <small><i class="bi bi-building me-1"></i><?= htmlspecialchars($classes[$i]['location'], ENT_QUOTES, 'UTF-8') ?></small>
                        </td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endfor; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="class-schedule__legend">
            <span><i class="bi bi-building me-1"></i>Seg. a Qua.: Bloco 2 • Sala 712</span>
            <span><i class="bi bi-building me-1"></i>Quinta: Bloco 2 • Sala 725</span>
            <span><i class="bi bi-camera-video me-1"></i>Sexta: Online</span>
            <span><i class="bi bi-calendar-x me-1"></i>Sábado: sem aula</span>
          </div>

        </section>
      </div>
    </main>
  </div>
  <?php renderScripts(); ?>
</body>

</html>