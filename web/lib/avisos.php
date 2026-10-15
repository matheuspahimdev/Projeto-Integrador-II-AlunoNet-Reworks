<?php
require_once __DIR__ . '/autenticacao.php';
require_once __DIR__ . '/tempo.php';

const NOTICE_CATEGORIES = [
    'secretaria' => ['label' => 'Secretaria', 'icon' => 'bi-building'],
    'coordenacao' => ['label' => 'Coordenação', 'icon' => 'bi-diagram-3'],
    'professores' => ['label' => 'Professores', 'icon' => 'bi-person-workspace'],
    'financeiro' => ['label' => 'Financeiro', 'icon' => 'bi-cash-coin'],
    'eventos' => ['label' => 'Eventos', 'icon' => 'bi-calendar-event'],
];

const NOTICE_PRIORITIES = [
    'urgente' => ['label' => 'Urgente', 'class' => 'text-bg-danger'],
    'importante' => ['label' => 'Importante', 'class' => 'text-bg-warning'],
];

const NOTICE_PREVIEW_LENGTH = 170;

// Avisos com 'audience' aparecem só para as matrículas listadas; os demais são para todos.
const NOTICES = [
    [
        'id' => 1, 'category' => 'professores', 'author' => 'Prof. Nome do Professor 1', 'published_at' => '2026-10-12 08:40',
        'priority' => 'urgente', 'pinned' => true, 'read' => false, 'audience' => ['274769'],
        'title' => 'Alteração de sala da prova de Projeto Integrador II',
        'text' => 'Atenção, turma: a prova de Projeto Integrador II será realizada na Sala 712 (Bloco 2) e não mais no local divulgado anteriormente. O horário permanece o mesmo. Chegue com 15 minutos de antecedência e leve um documento com foto.',
    ],
    [
        'id' => 2, 'category' => 'secretaria', 'author' => 'Secretaria Acadêmica', 'published_at' => '2026-10-12 08:05',
        'priority' => 'importante', 'pinned' => false, 'read' => false,
        'title' => 'Avaliação Institucional (CPA) disponível até 30/10',
        'text' => 'A Comissão Própria de Avaliação abriu o questionário do semestre. A participação é anônima e leva cerca de 5 minutos. Suas respostas ajudam a orientar melhorias na infraestrutura, no atendimento e nas disciplinas.',
        'link' => ['label' => 'Responder avaliação', 'href' => '../avalieNos/avaliacaoInstitucional.php'],
    ],
    [
        'id' => 3, 'category' => 'financeiro', 'author' => 'Setor Financeiro', 'published_at' => '2026-10-09 17:20',
        'priority' => 'importante', 'pinned' => false, 'read' => false,
        'title' => 'Boleto de outubro disponível',
        'text' => 'O boleto da parcela de outubro já pode ser consultado no portal. Você pode copiar a linha digitável, pagar com PIX ou baixar a 2ª via em PDF. Em caso de dúvidas sobre valores, procure o setor financeiro.',
        'link' => ['label' => 'Ver boleto', 'href' => '../financeiro/boletoOnline.php'],
    ],
    [
        'id' => 4, 'category' => 'secretaria', 'author' => 'Secretaria Acadêmica', 'published_at' => '2026-10-08 10:00',
        'priority' => 'normal', 'pinned' => false, 'read' => false,
        'title' => 'Sem aulas em 02/11 (Finados)',
        'text' => 'Em razão do feriado de Finados, não haverá aulas na segunda-feira, 02/11. As atividades retornam normalmente na terça-feira, 03/11.',
    ],
    [
        'id' => 5, 'category' => 'eventos', 'author' => 'Núcleo de Eventos', 'published_at' => '2026-10-06 14:15',
        'priority' => 'normal', 'pinned' => false, 'read' => true,
        'title' => 'Semana de Tecnologia 2026: inscrições abertas',
        'text' => 'Palestras, minicursos e maratona de programação fazem parte da programação deste ano. As vagas dos minicursos são limitadas e preenchidas por ordem de inscrição. Participantes podem solicitar certificado de atividade complementar.',
    ],
    [
        'id' => 6, 'category' => 'professores', 'author' => 'Prof. Nome do Professor 3', 'published_at' => '2026-10-05 09:10',
        'priority' => 'normal', 'pinned' => false, 'read' => true, 'audience' => ['274769', '281450'],
        'title' => 'Novos materiais de Banco de Dados no Repositório',
        'text' => 'Publiquei os slides das aulas 1 e 2, as listas de exercícios com gabarito e o script do banco usado em sala. Revisem antes da próxima aula para tirarmos dúvidas.',
        'link' => ['label' => 'Abrir repositório', 'href' => '../materiais/repositorioAluno.php'],
    ],
    [
        'id' => 7, 'category' => 'coordenacao', 'author' => 'Coordenação do Curso', 'published_at' => '2026-09-29 16:30',
        'priority' => 'normal', 'pinned' => false, 'read' => true,
        'title' => 'Resultado da seleção de monitoria',
        'text' => 'Está disponível o resultado da seleção de monitores do semestre. Os aprovados devem procurar a coordenação para assinar o termo de compromisso. Agradecemos a todos que participaram do processo.',
        'attachments' => [['name' => 'Resultado_Monitoria.pdf', 'size' => '180 KB']],
    ],
    [
        'id' => 8, 'category' => 'secretaria', 'author' => 'Secretaria Acadêmica', 'published_at' => '2026-09-24 11:00',
        'priority' => 'normal', 'pinned' => false, 'read' => true,
        'title' => 'Manutenção programada do portal do aluno',
        'text' => 'O portal ficará indisponível no sábado, 26/09, das 22h às 02h, para atualização dos sistemas. Pedimos que concluam solicitações e downloads antes desse período.',
    ],
    [
        'id' => 9, 'category' => 'coordenacao', 'author' => 'Coordenação do Curso', 'published_at' => '2026-09-18 13:45',
        'priority' => 'importante', 'pinned' => false, 'read' => true,
        'title' => 'Prazo de entrega das atividades complementares',
        'text' => 'Lembramos que os comprovantes de atividades complementares devem ser registrados no portal até o fim do semestre. Alunos em fase de conclusão têm prioridade na análise.',
        'link' => ['label' => 'Registrar atividades', 'href' => '../academico/atividadesComplementares.php'],
    ],
];

function noticesPinnedFirst(): array
{
    $registration = currentStudent()['registration'];
    $notices = array_filter(NOTICES, static fn (array $notice): bool => in_array($registration, $notice['audience'] ?? [$registration], true));
    usort($notices, static fn (array $a, array $b): int => [(int) $b['pinned'], $b['published_at']] <=> [(int) $a['pinned'], $a['published_at']]);
    return $notices;
}

function unreadNoticesCount(array $notices): int
{
    return count(array_filter($notices, static fn (array $notice): bool => !$notice['read']));
}