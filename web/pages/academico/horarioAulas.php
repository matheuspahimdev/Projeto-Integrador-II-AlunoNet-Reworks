<?php
require_once __DIR__ . '/../../components/layout.php';

renderPageStart('Horário de Aulas');
renderAcademicHeader('Horário de Aulas');
?>
      <div class="grid-mesh grid-mesh--static">
        <section class="g-box bg-body-secondary border rounded-4 g-col-4 class-schedule-card">
          <div class="class-schedule-card__header">
            <div class="d-flex flex-column gap-1">
              <h2 class="fs-md fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-week me-1"></i>
                Horário de Aulas
              </h2>
              <p class="text-secondary small mb-0 mt-2"><?= e(STUDENT['course']) ?> • Período <?= e(STUDENT['period']) ?></p>
            </div>
            <span class="badge rounded-pill text-bg-primary class-schedule-card__term"><?= e(STUDENT['semester']) ?></span>
          </div>

          <div class="class-schedule">
            <table class="class-schedule__table">
              <thead>
                <tr>
                  <th class="class-schedule__time-header">Horário<br>das aulas</th>
                  <?php foreach (array_keys(WEEKLY_SCHEDULE) as $weekday): ?>
                    <th><?= e($weekday) ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach (CLASS_SLOTS as $slotIndex => $slot): ?>
                  <tr>
                    <th><?= e($slot['start']) ?> - <?= e($slot['end']) ?></th>
                    <?php foreach (WEEKLY_SCHEDULE as $disciplineKeys): ?>
                      <?php $disciplineKey = $disciplineKeys[$slotIndex] ?? null; ?>
                      <?php $discipline = $disciplineKey !== null ? DISCIPLINES[$disciplineKey] : null; ?>
                      <?php if ($discipline === null): ?>
                        <td class="schedule-cell schedule-cell--empty">Sem aula</td>
                      <?php else: ?>
                        <td class="schedule-cell schedule-cell--<?= e($discipline['color']) ?><?= $discipline['online'] ? ' schedule-cell--online' : '' ?>">
                          <strong><?= e($discipline['code']) ?></strong>
                          <span><?= e($discipline['name']) ?></span>
                          <small><i class="bi <?= $discipline['online'] ? 'bi-camera-video' : 'bi-building' ?> me-1"></i><?= e($discipline['room']) ?></small>
                        </td>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="class-schedule__legend">
            <span><i class="bi bi-building me-1"></i>Seg. a Qua.: Bloco 2 • Sala 712</span>
            <span><i class="bi bi-building me-1"></i>Quinta: Bloco 2 • Sala 725</span>
            <span><i class="bi bi-camera-video me-1"></i>Sexta: Online</span>
            <span><i class="bi bi-calendar-x me-1"></i>Sábado: sem aula</span>
          </div>
        </section>
      </div>
<?php renderPageEnd(); ?>