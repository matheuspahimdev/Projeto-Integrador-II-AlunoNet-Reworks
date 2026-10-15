<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/avaliacao.php';

$renderRatingScale = static function (string $name, string $question): void {
    ?>
    <fieldset class="rating-group">
      <legend><?= e($question) ?></legend>
      <div class="rating-scale">
        <?php foreach (RATING_SCALE as $rating => $ratingLabel): ?>
          <label class="rating-option">
            <input class="form-check-input" type="radio" name="<?= e($name) ?>" value="<?= $rating ?>">
            <strong><?= $rating ?></strong>
            <span><?= e($ratingLabel) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
      <div class="invalid-feedback">Selecione uma nota de 1 a 5.</div>
    </fieldset>
    <?php
};
renderPageStart('Avaliação Institucional (CPA)');
?>

<?php renderPageHeader('Avaliação Institucional (CPA)', 'Sua opinião é fundamental para a melhoria contínua da Unifio.', static function (): void { ?>
      <span class="badge rounded-pill text-bg-warning px-3 py-2"><i class="bi bi-clock me-1"></i>Pendente (Prazo: <?= e(formatDayMonth(EVALUATION_DEADLINE)) ?>)</span>
<?php }); ?>

    <div class="info-banner" role="note">
      <div class="info-banner__icon"><i class="bi bi-shield-check"></i></div>
      <div>
        <strong>Avaliação anônima</strong>
        <span>Garantimos o anonimato de todas as respostas. Sinta-se à vontade para ser sincero na sua avaliação.</span>
      </div>
    </div>

    <form id="evaluationForm" method="post" action="" novalidate>
      <section class="grid-mesh grid-mesh--static grid-mesh--academic grid-mesh--auto">
        <section class="g-box g-col-4 grid-card">
          <div class="grid-card__body">
            <?php foreach (EVALUATION_SECTIONS as $section): ?>
              <div class="rating-section">
                <h2 class="rating-section__title"><i class="bi <?= e($section['icon']) ?>"></i><?= e($section['title']) ?></h2>
                <?php $renderRatingScale($section['name'], $section['question']); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="g-box g-col-4 grid-card">
          <?php renderCardHead('bi-mortarboard', 'Avaliação docente'); ?>
          <div class="grid-card__body academic-form">
            <div class="mb-4">
              <label class="form-label" for="disciplineSelect">Selecione a disciplina / professor para avaliar:</label>
              <select class="form-select" id="disciplineSelect" name="discipline">
                <option value="" selected disabled>-- Escolha a disciplina --</option>
                <?php foreach (evaluatedDisciplines() as $discipline): ?>
                  <option value="<?= e($discipline['id']) ?>"><?= e($discipline['label']) ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Selecione a disciplina que deseja avaliar.</div>
            </div>

            <?php $renderRatingScale('teaching', 'Como avalia o domínio do conteúdo e a didática do professor selecionado?'); ?>

            <hr class="my-4">

            <label class="form-label" for="commentField">Críticas, elogios ou sugestões (opcional):</label>
            <textarea class="form-control" id="commentField" name="comment" rows="4" maxlength="1000" placeholder="Deixe aqui o seu comentário..."></textarea>
          </div>
        </section>
      </section>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-accent px-4 py-2" type="submit"><i class="bi bi-send me-2"></i>Enviar avaliação</button>
      </div>
    </form>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('evaluationForm');
  const select = document.getElementById('disciplineSelect');

  form.addEventListener('change', (event) => {
    const group = event.target.closest('.rating-group');
    if (group) group.classList.remove('is-invalid');
    if (event.target === select) select.classList.remove('is-invalid');
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    let firstInvalid = null;
    form.querySelectorAll('.rating-group, #disciplineSelect').forEach((field) => {
      const isGroup = field.classList.contains('rating-group');
      const valid = isGroup ? field.querySelector('input:checked') !== null : field.value !== '';
      field.classList.toggle('is-invalid', !valid);
      if (!valid && !firstInvalid) firstInvalid = isGroup ? field.querySelector('input') : field;
    });

    if (firstInvalid) {
      firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
      firstInvalid.focus({ preventScroll: true });
      return;
    }

    const evaluated = select.selectedOptions[0];
    evaluated.disabled = true;
    evaluated.textContent += ' (avaliada)';
    form.reset();
    showToast('Avaliação enviada com sucesso. Obrigado pela sua participação!');
  });
});
</script>
<?php renderPageEnd(); ?>