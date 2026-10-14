<?php
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

const NOTICES = [
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

function noticesPinnedFirst(): array
{
    $notices = NOTICES;
    usort($notices, static fn (array $a, array $b): int => [(int) $b['fixado'], $b['data']] <=> [(int) $a['fixado'], $a['data']]);
    return $notices;
}

function unreadNoticesCount(array $notices): int
{
    return count(array_filter($notices, static fn (array $notice): bool => !$notice['lido']));
}