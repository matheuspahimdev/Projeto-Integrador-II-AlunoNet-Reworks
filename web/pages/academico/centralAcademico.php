<?php
require_once '../../components/layout.php';
renderHead('Central Acadêmica', 'dark', '../../', false);

$links = [
  ['url' => 'horarioAulas.php', 'class' => 'bi bi-calendar-week', 'title' => 'Horário de Aulas', 'description' => 'Consulte sua grade semanal, salas e aulas online.'],
  ['url' => 'calendarioProvas.php', 'class' => 'bi bi-calendar2-check', 'title' => 'Calendário de Provas', 'description' => 'Veja datas e próximas avaliações.'],
  ['url' => 'notas.php', 'class' => 'bi bi-award', 'title' => 'Notas', 'description' => 'Acompanhe notas, médias e situação nas disciplinas.'],
  ['url' => 'faltas.php', 'class' => 'bi bi-calendar2-x', 'title' => 'Faltas', 'description' => 'Consulte sua frequência por disciplina.'],
  ['url' => 'desempenho.php', 'class' => 'bi bi-bar-chart-line', 'title' => 'Gráficos de Desempenho', 'description' => 'Visualize médias e indicadores acadêmicos.'],
  ['url' => 'dadosCadastrais.php', 'class' => 'bi bi-person-vcard', 'title' => 'Consultar Dados Cadastrais', 'description' => 'Veja os dados registrados no portal.'],
  ['url' => 'confirmacaoMatricula.php', 'class' => 'bi bi-patch-check', 'title' => 'Confirmação de Matrícula', 'description' => 'Consulte a situação e os dados da matrícula.'],
  ['url' => 'dic.php', 'class' => 'bi bi-diagram-3', 'title' => 'DIC', 'description' => 'Documentação e integralização curricular.'],
  ['url' => 'atualizacaoDadosCadastrais.php', 'class' => 'bi bi-pencil-square', 'title' => 'Atualização de Dados Cadastrais', 'description' => 'Atualize telefone, e-mail e endereço.'],
  ['url' => 'atividadesComplementares.php', 'class' => 'bi bi-trophy', 'title' => 'Atividades Complementares', 'description' => 'Acompanhe horas e atividades registradas.'],
  ['url' => 'planoEnsino.php', 'class' => 'bi bi-journal-richtext', 'title' => 'Plano de Ensino', 'description' => 'Consulte ementas, objetivos e critérios de avaliação.'],
  ['url' => 'carteirinhaDigital.php', 'class' => 'bi bi-person-badge', 'title' => 'Carteirinha Digital', 'description' => 'Acesse sua identificação acadêmica digital.'],
];

?>

<body>
  <div class="app-shell">
    <nav-bar id="main-navigation"></nav-bar>
    <main class="page-content">
      <portal-header></portal-header>
      <section class="hero-header-pages">
        <div>
          <h1 class="display-6">Central Acadêmica</h1>
          <p class="text-secondary mb-0">Acesse os principais recursos acadêmicos do seu curso.</p>
        </div>
      </section>

      <section class="academic-hero-card">
        <div class="academic-hero-card__icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
          <h2>Engenharia de Software</h2>
          <p>2º semestre • 2026/2 • Período Noturno</p>
        </div>
        <div class="academic-hero-card__status"><span class="status-dot"></span> Matrícula ativa</div>
      </section>

      <div class="academic-links-grid">
        <?php foreach ($links as $link): ?>
          <a class="academic-link-card" href="<?= $link['url'] ?>"><i class="<?= $link['class'] ?>"></i>
            <div><strong><?= htmlspecialchars($link['title'], ENT_QUOTES, 'UTF-8') ?></strong><span><?= htmlspecialchars($link['description'], ENT_QUOTES, 'UTF-8') ?></span></div><i class="bi bi-chevron-right arrow"></i>
          </a>
        <?php endforeach; ?>
      </div>
    </main>
  </div>
  <?php renderScripts(); ?>
</body>

</html>