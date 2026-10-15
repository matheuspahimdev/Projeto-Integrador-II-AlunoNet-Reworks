<?php
require_once __DIR__ . '/../../components/layout.php';

$links = [
    ['url' => 'horarioAulas.php', 'icon' => 'bi-calendar-week', 'title' => 'Horário de Aulas', 'description' => 'Consulte sua grade semanal, salas e aulas online.'],
    ['url' => 'calendarioProvas.php', 'icon' => 'bi-calendar2-check', 'title' => 'Calendário de Provas', 'description' => 'Veja datas e próximas avaliações.'],
    ['url' => 'notas.php', 'icon' => 'bi-award', 'title' => 'Notas', 'description' => 'Acompanhe notas, médias e situação nas disciplinas.'],
    ['url' => 'faltas.php', 'icon' => 'bi-calendar2-x', 'title' => 'Faltas', 'description' => 'Consulte sua frequência por disciplina.'],
    ['url' => 'desempenho.php', 'icon' => 'bi-bar-chart-line', 'title' => 'Gráficos de Desempenho', 'description' => 'Visualize médias e indicadores acadêmicos.'],
    ['url' => 'dadosCadastrais.php', 'icon' => 'bi-person-vcard', 'title' => 'Consultar Dados Cadastrais', 'description' => 'Veja os dados registrados no portal.'],
    ['url' => 'confirmacaoMatricula.php', 'icon' => 'bi-patch-check', 'title' => 'Confirmação de Matrícula', 'description' => 'Consulte a situação e os dados da matrícula.'],
    ['url' => 'dic.php', 'icon' => 'bi-diagram-3', 'title' => 'DIC', 'description' => 'Documentação e integralização curricular.'],
    ['url' => 'atualizacaoDadosCadastrais.php', 'icon' => 'bi-pencil-square', 'title' => 'Atualização de Dados Cadastrais', 'description' => 'Atualize telefone, e-mail e endereço.'],
    ['url' => 'atividadesComplementares.php', 'icon' => 'bi-trophy', 'title' => 'Atividades Complementares', 'description' => 'Acompanhe horas e atividades registradas.'],
    ['url' => 'planoEnsino.php', 'icon' => 'bi-journal-richtext', 'title' => 'Plano de Ensino', 'description' => 'Consulte ementas, objetivos e critérios de avaliação.'],
    ['url' => 'carteirinhaDigital.php', 'icon' => 'bi-person-badge', 'title' => 'Carteirinha Digital', 'description' => 'Acesse sua identificação acadêmica digital.'],
];

renderPageStart('Central Acadêmica');
renderPageHeader('Central Acadêmica', 'Acesse os principais recursos acadêmicos do seu curso.');
?>
      <section class="academic-hero-card">
        <div class="academic-hero-card__icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
          <h2><?= e(currentStudent()['course']) ?></h2>
          <p><?= e(currentStudent()['semester']) ?> • <?= e(currentStudent()['term']) ?> • Período <?= e(currentStudent()['period']) ?></p>
        </div>
        <div class="academic-hero-card__status"><span class="status-dot"></span> Matrícula ativa</div>
      </section>

      <div class="academic-links-grid">
        <?php foreach ($links as $link): ?>
          <a class="academic-link-card" href="<?= e($link['url']) ?>">
            <i class="bi <?= e($link['icon']) ?>"></i>
            <div><strong><?= e($link['title']) ?></strong><span><?= e($link['description']) ?></span></div>
            <i class="bi bi-chevron-right arrow"></i>
          </a>
        <?php endforeach; ?>
      </div>
<?php renderPageEnd(); ?>