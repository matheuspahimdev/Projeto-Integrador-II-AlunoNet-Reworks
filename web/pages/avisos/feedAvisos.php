<?php
require_once '../../components/layout.php';
renderHead('Avisos', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$fuso = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTimeImmutable('now', $fuso);

$categorias = [
    'secretaria' => ['label' => 'Secretaria', 'icon' => 'bi-building'],
    'coordenacao' => ['label' => 'Coordenação', 'icon' => 'bi-diagram-3'],
    'professores' => ['label' => 'Professores', 'icon' => 'bi-person-workspace'],
    'financeiro' => ['label' => 'Financeiro', 'icon' => 'bi-cash-coin'],
    'eventos' => ['label' => 'Eventos', 'icon' => 'bi-calendar-event'],
];

$prioridades = [
    'urgente' => ['label' => 'Urgente', 'class' => 'text-bg-danger'],
    'importante' => ['label' => 'Importante', 'class' => 'text-bg-warning'],
];

$avisos = [
    [
        'id' => 1, 'categoria' => 'professores', 'autor' => 'Prof. Nome do Professor 1', 'data' => '2026-10-12 08:40',
        'prioridade' => 'urgente', 'fixado' => true, 'lido' => false,
        'titulo' => 'Alteração de sala da prova de Projeto Integrador II',
        'texto' => 'Atenção, turma: a prova de Projeto Integrador II será realizada na Sala 712 (Bloco 2) e não mais no local divulgado anteriormente. O horário permanece o mesmo. Chegue com 15 minutos de antecedência e leve um documento com foto.',
    ],
    [
        'id' => 2, 'categoria' => 'secretaria', 'autor' => 'Secretaria Acadêmica', 'data' => '2026-10-12 08:05',
        'prioridade' => 'importante', 'fixado' => false, 'lido' => false,
        'titulo' => 'Avaliação Institucional (CPA) disponível até 30/10',
        'texto' => 'A Comissão Própria de Avaliação abriu o questionário do semestre. A participação é anônima e leva cerca de 5 minutos. Suas respostas ajudam a orientar melhorias na infraestrutura, no atendimento e nas disciplinas.',
        'link' => ['label' => 'Responder avaliação', 'href' => '../avalieNos/avaliacaoInstitucional.php'],
    ],
    [
        'id' => 3, 'categoria' => 'financeiro', 'autor' => 'Setor Financeiro', 'data' => '2026-10-09 17:20',
        'prioridade' => 'importante', 'fixado' => false, 'lido' => false,
        'titulo' => 'Boleto de outubro disponível',
        'texto' => 'O boleto da parcela de outubro já pode ser consultado no portal. Você pode copiar a linha digitável, pagar com PIX ou baixar a 2ª via em PDF. Em caso de dúvidas sobre valores, procure o setor financeiro.',
        'link' => ['label' => 'Ver boleto', 'href' => '../financeiro/boletoOnline.php'],
    ],
    [
        'id' => 4, 'categoria' => 'secretaria', 'autor' => 'Secretaria Acadêmica', 'data' => '2026-10-08 10:00',
        'prioridade' => 'normal', 'fixado' => false, 'lido' => false,
        'titulo' => 'Sem aulas em 02/11 (Finados)',
        'texto' => 'Em razão do feriado de Finados, não haverá aulas na segunda-feira, 02/11. As atividades retornam normalmente na terça-feira, 03/11.',
    ],
    [
        'id' => 5, 'categoria' => 'eventos', 'autor' => 'Núcleo de Eventos', 'data' => '2026-10-06 14:15',
        'prioridade' => 'normal', 'fixado' => false, 'lido' => true,
        'titulo' => 'Semana de Tecnologia 2026: inscrições abertas',
        'texto' => 'Palestras, minicursos e maratona de programação fazem parte da programação deste ano. As vagas dos minicursos são limitadas e preenchidas por ordem de inscrição. Participantes podem solicitar certificado de atividade complementar.',
    ],
    [
        'id' => 6, 'categoria' => 'professores', 'autor' => 'Prof. Nome do Professor 3', 'data' => '2026-10-05 09:10',
        'prioridade' => 'normal', 'fixado' => false, 'lido' => true,
        'titulo' => 'Novos materiais de Banco de Dados no Repositório',
        'texto' => 'Publiquei os slides das aulas 1 e 2, as listas de exercícios com gabarito e o script do banco usado em sala. Revisem antes da próxima aula para tirarmos dúvidas.',
        'link' => ['label' => 'Abrir repositório', 'href' => '../materiais/repositorioAluno.php'],
    ],
    [
        'id' => 7, 'categoria' => 'coordenacao', 'autor' => 'Coordenação do Curso', 'data' => '2026-09-29 16:30',
        'prioridade' => 'normal', 'fixado' => false, 'lido' => true,
        'titulo' => 'Resultado da seleção de monitoria',
        'texto' => 'Está disponível o resultado da seleção de monitores do semestre. Os aprovados devem procurar a coordenação para assinar o termo de compromisso. Agradecemos a todos que participaram do processo.',
        'anexos' => [['nome' => 'Resultado_Monitoria.pdf', 'tamanho' => '180 KB']],
    ],
    [
        'id' => 8, 'categoria' => 'secretaria', 'autor' => 'Secretaria Acadêmica', 'data' => '2026-09-24 11:00',
        'prioridade' => 'normal', 'fixado' => false, 'lido' => true,
        'titulo' => 'Manutenção programada do portal do aluno',
        'texto' => 'O portal ficará indisponível no sábado, 26/09, das 22h às 02h, para atualização dos sistemas. Pedimos que concluam solicitações e downloads antes desse período.',
    ],
    [
        'id' => 9, 'categoria' => 'coordenacao', 'autor' => 'Coordenação do Curso', 'data' => '2026-09-18 13:45',
        'prioridade' => 'importante', 'fixado' => false, 'lido' => true,
        'titulo' => 'Prazo de entrega das atividades complementares',
        'texto' => 'Lembramos que os comprovantes de atividades complementares devem ser registrados no portal até o fim do semestre. Alunos em fase de conclusão têm prioridade na análise.',
        'link' => ['label' => 'Registrar atividades', 'href' => '../academico/atividadesComplementares.php'],
    ],
];

usort($avisos, static fn (array $a, array $b): int => [(int) $b['fixado'], $b['data']] <=> [(int) $a['fixado'], $a['data']]);

$rotuloData = static function (DateTimeImmutable $data) use ($agora): string {
    $dias = -((int) $agora->setTime(0, 0)->diff($data->setTime(0, 0))->format('%r%a'));
    $hora = $data->format('H:i');

    return match (true) {
        $dias === 0 => "Hoje às {$hora}",
        $dias === 1 => "Ontem às {$hora}",
        $dias > 1 && $dias < 7 => "Há {$dias} dias",
        default => $data->format('d/m/Y'),
    };
};

$naoLidos = count(array_filter($avisos, static fn (array $aviso): bool => !$aviso['lido']));
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h1 class="display-6">Avisos</h1>
        <p class="text-secondary mb-0">Comunicados da secretaria, coordenação e professores.</p>
      </div>
      <button class="btn btn-outline-primary" type="button" id="markAllRead"><i class="bi bi-check2-all me-2"></i>Marcar todos como lidos</button>
    </section>

    <div class="notice-wrap">
      <div class="notice-toolbar">
        <div class="notice-filters" role="group" aria-label="Filtrar avisos">
          <button class="notice-filter active" type="button" data-filter="all">Todos</button>
          <button class="notice-filter" type="button" data-filter="unread">Não lidos <span class="badge text-bg-primary" id="unreadCount"><?= $naoLidos ?></span></button>
          <?php foreach ($categorias as $slug => $categoria): ?>
            <button class="notice-filter" type="button" data-filter="<?= $e($slug) ?>"><i class="bi <?= $e($categoria['icon']) ?> me-1"></i><?= $e($categoria['label']) ?></button>
          <?php endforeach; ?>
        </div>
        <div class="input-group notice-search">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input class="form-control" type="search" id="noticeSearch" placeholder="Buscar avisos" aria-label="Buscar avisos">
        </div>
      </div>

      <div class="notice-feed" id="noticeFeed" aria-live="polite">
        <?php foreach ($avisos as $aviso): ?>
          <?php
            $data = new DateTimeImmutable($aviso['data'], $fuso);
            $categoria = $categorias[$aviso['categoria']];
            $prioridade = $prioridades[$aviso['prioridade']] ?? null;
            $anexos = $aviso['anexos'] ?? [];
            $link = $aviso['link'] ?? null;
            $temMais = mb_strlen($aviso['texto']) > 170 || $anexos || $link;
            $busca = mb_strtolower($aviso['titulo'] . ' ' . $aviso['texto'] . ' ' . $aviso['autor'] . ' ' . $categoria['label']);
            $classes = 'notice-card notice-card--' . $aviso['prioridade'] . ($aviso['lido'] ? '' : ' is-unread');
          ?>
          <article class="<?= $e($classes) ?>"
                   data-id="<?= (int) $aviso['id'] ?>"
                   data-category="<?= $e($aviso['categoria']) ?>"
                   data-date="<?= $e($data->format('Y-m-d\TH:i')) ?>"
                   data-pinned="<?= $aviso['fixado'] ? 'true' : 'false' ?>"
                   data-read="<?= $aviso['lido'] ? 'true' : 'false' ?>"
                   data-search="<?= $e($busca) ?>">
            <header class="notice-card__head">
              <span class="notice-card__avatar" aria-hidden="true"><i class="bi <?= $e($categoria['icon']) ?>"></i></span>
              <div class="notice-card__meta">
                <strong><?= $e($aviso['autor']) ?></strong>
                <time datetime="<?= $e($data->format('Y-m-d\TH:i')) ?>"><?= $e($rotuloData($data)) ?></time>
              </div>
              <div class="notice-card__tags">
                <span class="notice-dot" title="Não lido"></span>
                <?php if ($prioridade): ?>
                  <span class="badge rounded-pill <?= $e($prioridade['class']) ?>"><?= $e($prioridade['label']) ?></span>
                <?php endif; ?>
                <span class="badge rounded-pill text-bg-secondary"><?= $e($categoria['label']) ?></span>
              </div>
              <button class="notice-action<?= $aviso['fixado'] ? ' is-pinned' : '' ?>" type="button" data-action="pin" aria-pressed="<?= $aviso['fixado'] ? 'true' : 'false' ?>" aria-label="<?= $aviso['fixado'] ? 'Desafixar aviso' : 'Fixar aviso' ?>">
                <i class="bi <?= $aviso['fixado'] ? 'bi-pin-angle-fill' : 'bi-pin-angle' ?>"></i>
              </button>
            </header>

            <h2 class="notice-card__title"><?= $e($aviso['titulo']) ?></h2>
            <p class="notice-card__text"><?= $e($aviso['texto']) ?></p>

            <?php if ($anexos || $link): ?>
              <div class="notice-card__more">
                <?php if ($anexos): ?>
                  <div class="notice-attachments">
                    <?php foreach ($anexos as $anexo): ?>
                      <a class="notice-chip" href="#"><i class="bi bi-file-earmark-pdf file-icon--pdf"></i><?= $e($anexo['nome']) ?> <small><?= $e($anexo['tamanho']) ?></small></a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <?php if ($link): ?>
                  <a class="btn btn-sm btn-outline-primary" href="<?= $e($link['href']) ?>"><?= $e($link['label']) ?><i class="bi bi-arrow-right ms-2"></i></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <footer class="notice-card__foot">
              <?php if ($temMais): ?>
                <button class="notice-action" type="button" data-action="expand" aria-expanded="false">Ler mais</button>
              <?php endif; ?>
              <button class="notice-action ms-auto" type="button" data-action="read"></button>
            </footer>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="notice-empty" id="noticeEmpty" hidden>
        <i class="bi bi-inbox"></i>
        <p class="mb-0">Nenhum aviso encontrado com esses filtros.</p>
      </div>

      <div class="text-center my-4">
        <button class="btn btn-outline-secondary" type="button" id="noticeMore" hidden>Carregar mais avisos</button>
      </div>
    </div>

  </main>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="noticeToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="noticeToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const PAGE_SIZE = 6;
  const STORAGE_KEY = 'alunonet.avisos';

  const feed = document.getElementById('noticeFeed');
  const cards = [...feed.querySelectorAll('.notice-card')];
  const empty = document.getElementById('noticeEmpty');
  const moreButton = document.getElementById('noticeMore');
  const markAll = document.getElementById('markAllRead');
  const unreadBadge = document.getElementById('unreadCount');
  const search = document.getElementById('noticeSearch');
  const filterButtons = [...document.querySelectorAll('.notice-filter')];
  const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('noticeToast'), { delay: 3500 });

  const state = { filter: 'all', query: '', limit: PAGE_SIZE };
  const touched = new Set();

  let saved = { read: {}, pinned: {} };
  try {
    const raw = JSON.parse(localStorage.getItem(STORAGE_KEY));
    if (raw && typeof raw === 'object') saved = { read: raw.read || {}, pinned: raw.pinned || {} };
  } catch (error) { /* sem armazenamento disponível: segue com o estado do servidor */ }
  const persist = () => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(saved)); } catch (error) { /* ignora */ }
  };

  const icon = (className) => {
    const node = document.createElement('i');
    node.className = className;
    node.setAttribute('aria-hidden', 'true');
    return node;
  };

  const isRead = (card) => card.dataset.read === 'true';
  const isPinned = (card) => card.dataset.pinned === 'true';

  const paintRead = (card) => {
    const read = isRead(card);
    card.classList.toggle('is-unread', !read);
    card.querySelector('[data-action="read"]').replaceChildren(
      icon(read ? 'bi bi-envelope' : 'bi bi-envelope-open'),
      document.createTextNode(read ? 'Marcar como não lido' : 'Marcar como lido'),
    );
  };

  const paintPin = (card) => {
    const pinned = isPinned(card);
    const pin = card.querySelector('[data-action="pin"]');
    pin.classList.toggle('is-pinned', pinned);
    pin.setAttribute('aria-pressed', String(pinned));
    pin.setAttribute('aria-label', pinned ? 'Desafixar aviso' : 'Fixar aviso');
    pin.firstElementChild.className = pinned ? 'bi bi-pin-angle-fill' : 'bi bi-pin-angle';
  };

  const setRead = (card, read) => {
    card.dataset.read = String(read);
    saved.read[card.dataset.id] = read;
    persist();
    paintRead(card);
  };

  const setPinned = (card, pinned) => {
    card.dataset.pinned = String(pinned);
    saved.pinned[card.dataset.id] = pinned;
    persist();
    paintPin(card);
  };

  const matches = (card) => {
    if (state.filter === 'unread' && isRead(card) && !touched.has(card.dataset.id)) return false;
    if (state.filter !== 'all' && state.filter !== 'unread' && card.dataset.category !== state.filter) return false;
    return !state.query || card.dataset.search.includes(state.query);
  };

  const render = () => {
    const sorted = [...cards].sort((a, b) => Number(isPinned(b)) - Number(isPinned(a)) || b.dataset.date.localeCompare(a.dataset.date));
    feed.append(...sorted);

    let total = 0;
    let shown = 0;
    sorted.forEach((card) => {
      const ok = matches(card);
      if (ok) total += 1;
      const visible = ok && shown < state.limit;
      if (visible) shown += 1;
      card.hidden = !visible;
    });

    empty.hidden = total > 0;
    moreButton.hidden = total <= shown;
    moreButton.textContent = `Carregar mais avisos (${total - shown})`;

    const unread = cards.filter((card) => !isRead(card)).length;
    unreadBadge.textContent = String(unread);
    unreadBadge.hidden = unread === 0;
    markAll.disabled = unread === 0;

    filterButtons.forEach((button) => {
      const active = button.dataset.filter === state.filter;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });
  };

  cards.forEach((card) => {
    const id = card.dataset.id;
    if (id in saved.read) card.dataset.read = String(saved.read[id]);
    if (id in saved.pinned) card.dataset.pinned = String(saved.pinned[id]);
    paintRead(card);
    paintPin(card);
  });

  feed.addEventListener('click', (event) => {
    const button = event.target.closest('[data-action]');
    if (!button) return;
    const card = button.closest('.notice-card');
    touched.add(card.dataset.id);

    if (button.dataset.action === 'read') {
      setRead(card, !isRead(card));
    } else if (button.dataset.action === 'pin') {
      setPinned(card, !isPinned(card));
    } else if (button.dataset.action === 'expand') {
      const open = !card.classList.contains('is-expanded');
      card.classList.toggle('is-expanded', open);
      button.setAttribute('aria-expanded', String(open));
      button.textContent = open ? 'Ler menos' : 'Ler mais';
      if (open && !isRead(card)) setRead(card, true);
    }
    render();
  });

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      state.filter = button.dataset.filter;
      state.limit = PAGE_SIZE;
      touched.clear();
      render();
    });
  });

  search.addEventListener('input', () => {
    state.query = search.value.trim().toLowerCase();
    state.limit = PAGE_SIZE;
    touched.clear();
    render();
  });

  moreButton.addEventListener('click', () => {
    state.limit += PAGE_SIZE;
    render();
  });

  markAll.addEventListener('click', () => {
    cards.forEach((card) => setRead(card, true));
    touched.clear();
    render();
    document.getElementById('noticeToastBody').textContent = 'Todos os avisos foram marcados como lidos.';
    toast.show();
  });

  render();
});
</script>

</body>
</html>
