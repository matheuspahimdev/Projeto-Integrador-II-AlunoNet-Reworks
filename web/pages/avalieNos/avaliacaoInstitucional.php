<?php
require_once '../../components/layout.php';
renderHead('Avaliação Institucional (CPA)', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$prazo = '30/10';

$escala = [
    1 => 'Muito ruim',
    2 => 'Ruim',
    3 => 'Regular',
    4 => 'Bom',
    5 => 'Excelente',
];

$secoes = [
    ['name' => 'infraestrutura', 'icon' => 'bi-house', 'title' => '1. Infraestrutura e Serviços', 'question' => 'Como avalia as condições das salas de aula, laboratórios e biblioteca?'],
    ['name' => 'atendimento', 'icon' => 'bi-plus-circle', 'title' => '2. Atendimento Institucional', 'question' => 'Como avalia a agilidade e eficiência do atendimento da Secretaria?'],
];

$disciplinas = [
    ['id' => 'projeto-integrador-ii', 'label' => 'Projeto Integrador II — Prof. Nome do Professor 1'],
    ['id' => 'direito-aplicado', 'label' => 'Direito Aplicado — Prof. Nome do Professor 2'],
    ['id' => 'banco-de-dados', 'label' => 'Banco de Dados — Prof. Nome do Professor 3'],
    ['id' => 'programacao-web', 'label' => 'Programação Web — Prof. Nome do Professor 4'],
];

$renderEscala = static function (string $name, string $question, array $escala) use ($e): void {
    ?>
    <fieldset class="rating-group">
      <legend><?= $e($question) ?></legend>
      <div class="rating-scale">
        <?php foreach ($escala as $valor => $rotulo): ?>
          <label class="rating-option">
            <input class="form-check-input" type="radio" name="<?= $e($name) ?>" value="<?= $valor ?>">
            <strong><?= $valor ?></strong>
            <span><?= $e($rotulo) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
      <div class="invalid-feedback">Selecione uma nota de 1 a 5.</div>
    </fieldset>
    <?php
};
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Avaliação Institucional (CPA)</h1>
        <p class="text-secondary mb-0">Sua opinião é fundamental para a melhoria contínua da Unifio.</p>
      </div>
      <span class="badge rounded-pill text-bg-warning px-3 py-2"><i class="bi bi-clock me-1"></i>Pendente (Prazo: <?= $e($prazo) ?>)</span>
    </section>

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
            <?php foreach ($secoes as $secao): ?>
              <div class="rating-section">
                <h2 class="rating-section__title"><i class="bi <?= $e($secao['icon']) ?>"></i><?= $e($secao['title']) ?></h2>
                <?php $renderEscala($secao['name'], $secao['question'], $escala); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="g-box g-col-4 grid-card">
          <div class="grid-card__head">
            <div class="grid-card__icon"><i class="bi bi-mortarboard"></i></div>
            <div>
              <h2>Avaliação docente</h2>
            </div>
          </div>
          <div class="grid-card__body academic-form">
            <div class="mb-4">
              <label class="form-label" for="disciplineSelect">Selecione a disciplina / professor para avaliar:</label>
              <select class="form-select" id="disciplineSelect" name="disciplina">
                <option value="" selected disabled>-- Escolha a disciplina --</option>
                <?php foreach ($disciplinas as $disciplina): ?>
                  <option value="<?= $e($disciplina['id']) ?>"><?= $e($disciplina['label']) ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Selecione a disciplina que deseja avaliar.</div>
            </div>

            <?php $renderEscala('docente', 'Como avalia o domínio do conteúdo e a didática do professor selecionado?', $escala); ?>

            <hr class="my-4">

            <label class="form-label" for="commentField">Críticas, elogios ou sugestões (opcional):</label>
            <textarea class="form-control" id="commentField" name="comentario" rows="4" maxlength="1000" placeholder="Deixe aqui o seu comentário..."></textarea>
          </div>
        </section>
      </section>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-accent px-4 py-2" type="submit"><i class="bi bi-send me-2"></i>Enviar avaliação</button>
      </div>
    </form>

  </main>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="evaluationToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">Avaliação enviada com sucesso. Obrigado pela sua participação!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('evaluationForm');
  const select = document.getElementById('disciplineSelect');
  const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('evaluationToast'), { delay: 5000 });

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
    toast.show();
  });
});
</script>

</body>
</html>
