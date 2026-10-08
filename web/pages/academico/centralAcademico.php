<?php
require_once '../../components/layout.php';
renderHead('Central Acadêmica', 'dark', '../../', false);
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
      <div><h2>Engenharia de Software</h2><p>2º semestre • 2026/2 • Período Noturno</p></div>
      <div class="academic-hero-card__status"><span class="status-dot"></span> Matrícula ativa</div>
    </section>

    <div class="academic-links-grid">
      <a class="academic-link-card" href="horarioAulas.php"><i class="bi bi-calendar-week"></i><div><strong>Horário de Aulas</strong><span>Consulte sua grade semanal, salas e aulas online.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="calendarioProvas.php"><i class="bi bi-calendar2-check"></i><div><strong>Calendário de Provas</strong><span>Veja datas e próximas avaliações.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="notas.php"><i class="bi bi-award"></i><div><strong>Notas</strong><span>Acompanhe notas, médias e situação nas disciplinas.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="faltas.php"><i class="bi bi-calendar2-x"></i><div><strong>Faltas</strong><span>Consulte sua frequência por disciplina.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="desempenho.php"><i class="bi bi-bar-chart-line"></i><div><strong>Gráficos de Desempenho</strong><span>Visualize médias e indicadores acadêmicos.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="dadosCadastrais.php"><i class="bi bi-person-vcard"></i><div><strong>Consultar Dados Cadastrais</strong><span>Veja os dados registrados no portal.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="confirmacaoMatricula.php"><i class="bi bi-patch-check"></i><div><strong>Confirmação de Matrícula</strong><span>Consulte a situação e os dados da matrícula.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="dic.php"><i class="bi bi-diagram-3"></i><div><strong>DIC</strong><span>Documentação e integralização curricular.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="atualizacaoDadosCadastrais.php"><i class="bi bi-pencil-square"></i><div><strong>Atualização de Dados Cadastrais</strong><span>Atualize telefone, e-mail e endereço.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="atividadesComplementares.php"><i class="bi bi-trophy"></i><div><strong>Atividades Complementares</strong><span>Acompanhe horas e atividades registradas.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="planoEnsino.php"><i class="bi bi-journal-richtext"></i><div><strong>Plano de Ensino</strong><span>Consulte ementas, objetivos e critérios de avaliação.</span></div><i class="bi bi-chevron-right arrow"></i></a>
      <a class="academic-link-card" href="carteirinhaDigital.php"><i class="bi bi-person-badge"></i><div><strong>Carteirinha Digital</strong><span>Acesse sua identificação acadêmica digital.</span></div><i class="bi bi-chevron-right arrow"></i></a>
    </div>
  </main>
</div>
<?php renderScripts(); ?>
</body>
</html>