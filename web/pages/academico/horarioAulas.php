<?php
require_once __DIR__ . '/../../components/layout.php';

renderAcademicPageStart('Horário de Aulas');
?>
      <div class="grid-mesh grid-mesh--static">
        <section class="g-box bg-body-secondary border rounded-4 g-col-4 class-schedule-card">
          <div class="class-schedule-card__header">
            <div class="d-flex flex-column gap-1">
              <h2 class="fs-md fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-week me-1"></i>
                Horário de Aulas
              </h2>
              <p class="text-secondary small mb-0 mt-2"><?= e(currentStudent()['course']) ?> • Período <?= e(currentStudent()['period']) ?></p>
            </div>
            <span class="badge rounded-pill text-bg-primary class-schedule-card__term"><?= e(currentStudent()['semester']) ?></span>
          </div>

          <div class="class-schedule">
            <table class="class-schedule__table">
              <thead>
                <tr>
                  <th class="class-schedule__time-header">Horário<br>das aulas</th>
                  <?php foreach (array_keys(weeklySchedule()) as $weekday): ?>
                    <th><?= e($weekday) ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach (classSlots() as $slotIndex => $slot): ?>
                  <tr>
                    <th><?= e($slot['start']) ?> - <?= e($slot['end']) ?></th>
                    <?php foreach (weeklySchedule() as $disciplineKeys): ?>
                      <?php $disciplineKey = $disciplineKeys[$slotIndex] ?? null; ?>
                      <?php $discipline = $disciplineKey !== null ? studentDisciplines()[$disciplineKey] : null; ?>
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
            <?php foreach (scheduleLegend() as $legendItem): ?>
              <span><i class="bi <?= e($legendItem['icon']) ?> me-1"></i><?= e($legendItem['text']) ?></span>
            <?php endforeach; ?>
          </div>
        </section>
      </div>
<?php renderPageEnd(); ?>