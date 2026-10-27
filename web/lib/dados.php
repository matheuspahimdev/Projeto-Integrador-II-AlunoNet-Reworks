<?php

/*
 * DADOS CENTRALIZADOS DO ALUNONET
 *
 * Este arquivo reúne os dados simulados utilizados pelo sistema:
 * - constantes e regras acadêmicas;
 * - cadastro dos alunos e informações de acesso;
 * - histórico acadêmico, disciplinas, notas e frequência;
 * - horários, avaliações e atividades complementares;
 * - classes visuais associadas aos status.
 *
 * ATENÇÃO:
 * Ao adicionar ou alterar um aluno, confira os arquivos dependentes
 * indicados no final deste arquivo. As matrículas devem permanecer
 * consistentes entre os cadastros, e as chaves das disciplinas devem
 * corresponder às referências utilizadas nas demais funcionalidades.
 */

require_once __DIR__ . '/tempo.php';

// nota mínima para aprovação em uma disciplina
const PASSING_GRADE = 6.0;

// percentual mínimo de frequência
const MINIMUM_ATTENDANCE = 75;

// total de horas em atividades complementares exigidas pelo curso
const REQUIRED_COMPLEMENTARY_HOURS = 160;

// quantidade de notas lançadas por disciplina em cada semestre
const GRADES_PER_SEMESTER = 2;

//rótulos de status usados em atividades complementares
const ACTIVITY_APPROVED = 'Deferido';

const ACTIVITY_UNDER_REVIEW = 'Em análise';

/*
 * Cadastro dos alunos de demonstração.
 *
 * A chave de cada registro é a matrícula utilizada no login.
 * O campo 'registration' deve corresponder à chave do cadastro.
 *
 * Os dados são fictícios e as senhas estão em texto puro porque
 * o projeto utiliza autenticação simulada, sem segurança real.
 */

const STUDENTS = [
    '274769' => [
        'name' => 'Victor H. Oliveira',
        'sex' => 'M',
        'registration' => '274769',
        'password' => 'victor123',
        'cpf' => '000.000.000-00',
        'rg' => '000000000',
        'birth_date' => '01/01/2000',
        'admission' => '2024/1',
        'course' => 'Engenharia de Software',
        'semester' => '2º semestre',
        'term' => '2026/2',
        'period' => 'Noturno',
        'modality' => 'Presencial',
        'status' => 'Matriculado',
        'email' => 'victor.oliveira@aluno.edu.br',
        'alternative_email' => 'victor.oliveira@email.com',
        'phone' => '(14) 99999-0000',
        'zip_code' => '19900-000',
        'address' => 'Rua Exemplo',
        'address_number' => '100',
        'city' => 'Ourinhos - SP',
        'enrolled_courses' => [
            '2026/2 · Eng. de Software',
            '2026/2 · Análise e Desenvolvimento de Sistemas',
            '2026/2 · Administração',
        ],
        'current_course' => '2026/2 · Eng. de Software',
    ],
    '281450' => [
        'name' => 'Ana Beatriz Souza',
        'sex' => 'F',
        'registration' => '281450',
        'password' => 'ana123',
        'cpf' => '111.111.111-11',
        'rg' => '111111111',
        'birth_date' => '15/03/2003',
        'admission' => '2025/1',
        'course' => 'Análise e Desenvolvimento de Sistemas',
        'semester' => '4º semestre',
        'term' => '2026/2',
        'period' => 'Matutino',
        'modality' => 'Presencial',
        'status' => 'Matriculado',
        'email' => 'ana.souza@aluno.edu.br',
        'alternative_email' => 'ana.souza@email.com',
        'phone' => '(14) 98888-1111',
        'zip_code' => '19901-000',
        'address' => 'Avenida Exemplo',
        'address_number' => '250',
        'city' => 'Ourinhos - SP',
        'enrolled_courses' => [
            '2026/2 · Análise e Desenvolvimento de Sistemas',
        ],
        'current_course' => '2026/2 · Análise e Desenvolvimento de Sistemas',
    ],
    '268112' => [
        'name' => 'Lucas Ferreira Lima',
        'sex' => 'M',
        'registration' => '268112',
        'password' => 'lucas123',
        'cpf' => '222.222.222-22',
        'rg' => '222222222',
        'birth_date' => '22/08/2001',
        'admission' => '2023/2',
        'course' => 'Administração',
        'semester' => '6º semestre',
        'term' => '2026/2',
        'period' => 'Noturno',
        'modality' => 'Presencial',
        'status' => 'Matriculado',
        'email' => 'lucas.lima@aluno.edu.br',
        'alternative_email' => 'lucas.lima@email.com',
        'phone' => '(14) 97777-2222',
        'zip_code' => '19902-000',
        'address' => 'Rua Modelo',
        'address_number' => '42',
        'city' => 'Ourinhos - SP',
        'enrolled_courses' => [
            '2026/2 · Administração',
        ],
        'current_course' => '2026/2 · Administração',
    ],
];

/*
 * Histórico acadêmico organizado por matrícula.
 *
 * Cada aluno possui suas disciplinas, notas, frequência, horários,
 * avaliações, atividades complementares e progresso curricular.
 *
 * As chaves internas das disciplinas, como 'labProgramacao',
 * 'bancoDados' e 'projetoIntegrador', funcionam como identificadores.
 * Elas são utilizadas pelo cronograma, pelas avaliações e por outros
 * módulos, especialmente web/lib/materiais.php e web/lib/eventos.php.
 *
 * Ao renomear uma chave, atualize todas as referências dependentes
 * para evitar erros ou informações ausentes nas páginas.
 */

const ACADEMIC_RECORDS = [
    '274769' => [
        'disciplines' => [
            'labProgramacao' => [
                'name' => 'Laboratório de Programação de Computadores',
                'short_name' => 'Lab. Programação',
                'code' => 'ESFT2B - M220938',
                'room' => 'Bloco 2 • Sala 712',
                'online' => false,
                'color' => 'blue',
                'teacher' => 'Prof. Marcelo Santos',
                'workload' => 80,
                'method' => 'Aulas práticas',
                'grades' => [8.5, 9.0],
                'attended' => 34,
                'absences' => 2,
            ],
            'engRequisitos' => [
                'name' => 'Engenharia de Requisitos',
                'short_name' => 'Eng. Requisitos',
                'code' => 'ESFT2B - M220939',
                'room' => 'Bloco 2 • Sala 712',
                'online' => false,
                'color' => 'green',
                'teacher' => 'Profa. Renata Lima',
                'workload' => 80,
                'method' => 'Aulas presenciais',
                'grades' => [7.5, 8.0],
                'attended' => 33,
                'absences' => 3,
            ],
            'projetoIntegrador' => [
                'name' => 'Projeto Integrador II',
                'short_name' => 'Projeto Integrador',
                'code' => 'ESFT2B - 5841',
                'room' => 'Bloco 2 • Sala 712',
                'online' => false,
                'color' => 'purple',
                'teacher' => 'Prof. André Oliveira',
                'workload' => 80,
                'method' => 'Projeto em grupo',
                'grades' => [9.0],
                'attended' => 35,
                'absences' => 1,
            ],
            'resolucaoProblemas' => [
                'name' => 'Resolução Diferenciada de Problemas',
                'short_name' => 'RDP',
                'code' => 'ESFT2B - 6014',
                'room' => 'Bloco 2 • Sala 725',
                'online' => false,
                'color' => 'orange',
                'teacher' => 'Profa. Camila Rocha',
                'workload' => 80,
                'method' => 'Estudos de caso',
                'grades' => [8.0, 7.5],
                'attended' => 32,
                'absences' => 4,
            ],
            'empreendedorismo' => [
                'name' => 'Empreendedorismo',
                'short_name' => 'Empreendedorismo',
                'code' => 'ESFT2B - 1097',
                'room' => 'Aula online',
                'online' => true,
                'color' => 'soft-blue',
                'teacher' => 'Prof. Eduardo Martins',
                'workload' => 40,
                'method' => 'Aulas online',
                'grades' => [8.5],
                'attended' => 31,
                'absences' => 3,
            ],
            'direitoInovacao' => [
                'name' => 'Direito Aplicado ao Empreendedorismo e Inovação',
                'short_name' => 'Direito e Inovação',
                'code' => 'ESFT2B - M220937',
                'room' => 'Aula online',
                'online' => true,
                'color' => 'soft-blue',
                'teacher' => 'Profa. Juliana Alves',
                'workload' => 40,
                'method' => 'Aulas online',
                'grades' => [9.0],
                'attended' => 30,
                'absences' => 4,
            ],
        ],
        'class_slots' => [
            ['start' => '19:15', 'end' => '20:05'],
            ['start' => '20:05', 'end' => '20:55'],
            ['start' => '21:10', 'end' => '22:00'],
            ['start' => '22:00', 'end' => '22:50'],
        ],
        'weekly_schedule' => [
            'Segunda' => ['labProgramacao', 'labProgramacao', 'labProgramacao', 'labProgramacao'],
            'Terça' => ['engRequisitos', 'engRequisitos', 'engRequisitos', 'engRequisitos'],
            'Quarta' => ['projetoIntegrador', 'projetoIntegrador', 'projetoIntegrador', 'projetoIntegrador'],
            'Quinta' => ['resolucaoProblemas', 'resolucaoProblemas', 'resolucaoProblemas', 'resolucaoProblemas'],
            'Sexta' => ['empreendedorismo', 'empreendedorismo', 'direitoInovacao', 'direitoInovacao'],
            'Sábado' => [null, null, null, null],
        ],
        'exams' => [
            ['date' => '2026-10-14', 'discipline' => 'projetoIntegrador', 'type' => '1ª avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-pencil-square'],
            ['date' => '2026-10-20', 'discipline' => 'engRequisitos', 'type' => 'Avaliação parcial', 'time' => '21:10 às 22:50', 'icon' => 'bi-journal-check'],
            ['date' => '2026-10-29', 'discipline' => 'resolucaoProblemas', 'type' => 'Avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-calculator'],
            ['date' => '2026-11-06', 'discipline' => 'empreendedorismo', 'type' => 'Atividade avaliativa', 'time' => '19:15 às 20:55', 'icon' => 'bi-camera-video'],
        ],
        'complementary_activities' => [
            ['name' => 'Curso de extensão', 'category' => 'Formação complementar', 'hours' => 20, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Evento acadêmico', 'category' => 'Participação em evento', 'hours' => 10, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Projeto voluntário', 'category' => 'Responsabilidade social', 'hours' => 30, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Workshop de tecnologia', 'category' => 'Aperfeiçoamento profissional', 'hours' => 20, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Palestra sobre inovação', 'category' => 'Aguardando análise', 'hours' => 10, 'status' => ACTIVITY_UNDER_REVIEW],
        ],
        'curriculum' => [
            ['name' => 'Disciplinas obrigatórias', 'completed' => 1680, 'total' => 2520],
            ['name' => 'Projeto Integrador', 'completed' => 120, 'total' => 200],
            ['name' => 'Disciplinas optativas', 'completed' => 40, 'total' => 200],
        ],
    ],
    '281450' => [
        'disciplines' => [
            'programacaoWeb' => [
                'name' => 'Programação para Web',
                'short_name' => 'Programação Web',
                'code' => 'ADS4A - M310412',
                'room' => 'Bloco 3 • Lab. 4',
                'online' => false,
                'color' => 'blue',
                'teacher' => 'Prof. Ricardo Nunes',
                'workload' => 80,
                'method' => 'Aulas práticas',
                'grades' => [9.0, 8.5],
                'attended' => 36,
                'absences' => 0,
            ],
            'bancoDados' => [
                'name' => 'Banco de Dados II',
                'short_name' => 'Banco de Dados',
                'code' => 'ADS4A - M310415',
                'room' => 'Bloco 3 • Lab. 2',
                'online' => false,
                'color' => 'green',
                'teacher' => 'Profa. Fernanda Costa',
                'workload' => 80,
                'method' => 'Aulas práticas',
                'grades' => [6.5, 7.0],
                'attended' => 33,
                'absences' => 3,
            ],
            'engSoftware' => [
                'name' => 'Engenharia de Software',
                'short_name' => 'Eng. Software',
                'code' => 'ADS4A - M310418',
                'room' => 'Bloco 3 • Sala 304',
                'online' => false,
                'color' => 'purple',
                'teacher' => 'Prof. Gustavo Ribeiro',
                'workload' => 80,
                'method' => 'Aulas presenciais',
                'grades' => [5.0, 5.5],
                'attended' => 34,
                'absences' => 2,
            ],
            'redes' => [
                'name' => 'Redes de Computadores',
                'short_name' => 'Redes',
                'code' => 'ADS4A - M310421',
                'room' => 'Bloco 3 • Lab. 1',
                'online' => false,
                'color' => 'orange',
                'teacher' => 'Prof. Paulo Mendes',
                'workload' => 80,
                'method' => 'Aulas práticas',
                'grades' => [7.0],
                'attended' => 26,
                'absences' => 10,
            ],
            'projetoIntegrador' => [
                'name' => 'Projeto Integrador IV',
                'short_name' => 'Projeto Integrador',
                'code' => 'ADS4A - 5844',
                'room' => 'Bloco 3 • Sala 304',
                'online' => false,
                'color' => 'purple',
                'teacher' => 'Prof. André Oliveira',
                'workload' => 80,
                'method' => 'Projeto em grupo',
                'grades' => [8.0],
                'attended' => 35,
                'absences' => 1,
            ],
            'eticaTi' => [
                'name' => 'Ética e Legislação em Tecnologia da Informação',
                'short_name' => 'Ética em TI',
                'code' => 'ADS4A - 1102',
                'room' => 'Aula online',
                'online' => true,
                'color' => 'soft-blue',
                'teacher' => 'Profa. Juliana Alves',
                'workload' => 40,
                'method' => 'Aulas online',
                'grades' => [9.5],
                'attended' => 18,
                'absences' => 0,
            ],
        ],
        'class_slots' => [
            ['start' => '07:30', 'end' => '08:20'],
            ['start' => '08:20', 'end' => '09:10'],
            ['start' => '09:25', 'end' => '10:15'],
            ['start' => '10:15', 'end' => '11:05'],
        ],
        'weekly_schedule' => [
            'Segunda' => ['programacaoWeb', 'programacaoWeb', 'programacaoWeb', 'programacaoWeb'],
            'Terça' => ['bancoDados', 'bancoDados', 'bancoDados', 'bancoDados'],
            'Quarta' => ['engSoftware', 'engSoftware', 'projetoIntegrador', 'projetoIntegrador'],
            'Quinta' => ['redes', 'redes', 'redes', 'redes'],
            'Sexta' => ['projetoIntegrador', 'projetoIntegrador', 'eticaTi', 'eticaTi'],
            'Sábado' => [null, null, null, null],
        ],
        'exams' => [
            ['date' => '2026-10-16', 'discipline' => 'bancoDados', 'type' => 'Avaliação parcial', 'time' => '07:30 às 09:10', 'icon' => 'bi-database'],
            ['date' => '2026-10-21', 'discipline' => 'engSoftware', 'type' => '2ª avaliação', 'time' => '07:30 às 09:10', 'icon' => 'bi-journal-check'],
            ['date' => '2026-10-29', 'discipline' => 'redes', 'type' => 'Avaliação prática', 'time' => '07:30 às 11:05', 'icon' => 'bi-hdd-network'],
            ['date' => '2026-11-06', 'discipline' => 'eticaTi', 'type' => 'Atividade avaliativa', 'time' => '09:25 às 11:05', 'icon' => 'bi-camera-video'],
        ],
        'complementary_activities' => [
            ['name' => 'Hackathon universitário', 'category' => 'Participação em evento', 'hours' => 20, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Curso online de Git', 'category' => 'Formação complementar', 'hours' => 15, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Monitoria de Algoritmos', 'category' => 'Atividade de ensino', 'hours' => 40, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Semana de Tecnologia', 'category' => 'Aguardando análise', 'hours' => 12, 'status' => ACTIVITY_UNDER_REVIEW],
        ],
        'curriculum' => [
            ['name' => 'Disciplinas obrigatórias', 'completed' => 1360, 'total' => 2000],
            ['name' => 'Projeto Integrador', 'completed' => 150, 'total' => 200],
            ['name' => 'Disciplinas optativas', 'completed' => 80, 'total' => 120],
        ],
    ],
    '268112' => [
        'disciplines' => [
            'gestaoFinanceira' => [
                'name' => 'Administração Financeira e Orçamentária',
                'short_name' => 'Adm. Financeira',
                'code' => 'ADM6B - M410203',
                'room' => 'Bloco 1 • Sala 108',
                'online' => false,
                'color' => 'blue',
                'teacher' => 'Prof. Sérgio Tavares',
                'workload' => 80,
                'method' => 'Estudos de caso',
                'grades' => [7.0, 6.5],
                'attended' => 32,
                'absences' => 4,
            ],
            'marketing' => [
                'name' => 'Marketing Estratégico',
                'short_name' => 'Marketing',
                'code' => 'ADM6B - M410207',
                'room' => 'Bloco 1 • Sala 108',
                'online' => false,
                'color' => 'orange',
                'teacher' => 'Profa. Patrícia Moura',
                'workload' => 80,
                'method' => 'Aulas presenciais',
                'grades' => [8.5, 9.0],
                'attended' => 35,
                'absences' => 1,
            ],
            'gestaoPessoas' => [
                'name' => 'Gestão de Pessoas',
                'short_name' => 'Gestão de Pessoas',
                'code' => 'ADM6B - M410210',
                'room' => 'Bloco 1 • Sala 112',
                'online' => false,
                'color' => 'green',
                'teacher' => 'Profa. Cláudia Ramos',
                'workload' => 80,
                'method' => 'Seminários',
                'grades' => [6.0],
                'attended' => 28,
                'absences' => 8,
            ],
            'logistica' => [
                'name' => 'Logística Empresarial',
                'short_name' => 'Logística',
                'code' => 'ADM6B - M410214',
                'room' => 'Bloco 1 • Sala 112',
                'online' => false,
                'color' => 'purple',
                'teacher' => 'Prof. Henrique Duarte',
                'workload' => 80,
                'method' => 'Aulas presenciais',
                'grades' => [7.5, 8.0],
                'attended' => 34,
                'absences' => 2,
            ],
            'empreendedorismo' => [
                'name' => 'Empreendedorismo',
                'short_name' => 'Empreendedorismo',
                'code' => 'ADM6B - 1097',
                'room' => 'Aula online',
                'online' => true,
                'color' => 'soft-blue',
                'teacher' => 'Prof. Eduardo Martins',
                'workload' => 40,
                'method' => 'Aulas online',
                'grades' => [8.0],
                'attended' => 17,
                'absences' => 1,
            ],
        ],
        'class_slots' => [
            ['start' => '19:15', 'end' => '20:05'],
            ['start' => '20:05', 'end' => '20:55'],
            ['start' => '21:10', 'end' => '22:00'],
            ['start' => '22:00', 'end' => '22:50'],
        ],
        'weekly_schedule' => [
            'Segunda' => ['gestaoFinanceira', 'gestaoFinanceira', 'gestaoFinanceira', 'gestaoFinanceira'],
            'Terça' => ['marketing', 'marketing', 'marketing', 'marketing'],
            'Quarta' => ['gestaoPessoas', 'gestaoPessoas', 'gestaoPessoas', 'gestaoPessoas'],
            'Quinta' => ['logistica', 'logistica', 'logistica', 'logistica'],
            'Sexta' => ['empreendedorismo', 'empreendedorismo', null, null],
            'Sábado' => [null, null, null, null],
        ],
        'exams' => [
            ['date' => '2026-10-19', 'discipline' => 'gestaoFinanceira', 'type' => '2ª avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-calculator'],
            ['date' => '2026-10-27', 'discipline' => 'marketing', 'type' => 'Apresentação de case', 'time' => '21:10 às 22:50', 'icon' => 'bi-easel'],
            ['date' => '2026-11-04', 'discipline' => 'gestaoPessoas', 'type' => '2ª avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-pencil-square'],
            ['date' => '2026-11-12', 'discipline' => 'logistica', 'type' => 'Avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-truck'],
        ],
        'complementary_activities' => [
            ['name' => 'Congresso de Administração', 'category' => 'Participação em evento', 'hours' => 30, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Estágio não obrigatório', 'category' => 'Aperfeiçoamento profissional', 'hours' => 60, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Curso de Excel avançado', 'category' => 'Formação complementar', 'hours' => 25, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Ação social na comunidade', 'category' => 'Responsabilidade social', 'hours' => 20, 'status' => ACTIVITY_APPROVED],
            ['name' => 'Palestra de liderança', 'category' => 'Aguardando análise', 'hours' => 8, 'status' => ACTIVITY_UNDER_REVIEW],
        ],
        'curriculum' => [
            ['name' => 'Disciplinas obrigatórias', 'completed' => 2240, 'total' => 2800],
            ['name' => 'Estágio supervisionado', 'completed' => 120, 'total' => 300],
            ['name' => 'Disciplinas optativas', 'completed' => 120, 'total' => 160],
        ],
    ],
];

/*
 * Classes visuais dos status.
 *
 * Relaciona cada texto de status à classe do Bootstrap utilizada
 * para exibir sua etiqueta colorida.
 *
 * Se um novo status precisar utilizar uma cor específica, verifique
 * se ele deve ser incluído neste mapa. Status sem correspondência
 * recebem a classe padrão definida em statusBadgeClass(), em
 * web/lib/academico.php.
 */

const STATUS_BADGES = [
    'Aprovado' => 'text-bg-success',
    'Reprovado' => 'text-bg-danger',
    'Em andamento' => 'text-bg-primary',
    'Deferido' => 'text-bg-success',
    'Em análise' => 'text-bg-warning',
    'Próxima' => 'text-bg-primary',
    'Agendada' => 'text-bg-secondary',
    'Regular' => 'text-bg-success',
    'Atenção' => 'text-bg-warning',
    'Matriculado' => 'text-bg-success',
    'Publicado' => 'text-bg-success',
    'Pago' => 'text-bg-success',
    'Em aberto' => 'text-bg-warning',
];

/*
 * ============================================================
 * ARQUIVOS DEPENDENTES DE DADOS.PHP
 * ============================================================
 *
 * Ao adicionar alunos, alterar matrículas ou modificar disciplinas,
 * confira os arquivos abaixo para manter os dados consistentes.
 *
 * 1. web/lib/financeiro.php — linhas 12–150
 *    Array: FINANCIAL_RECORDS
 *    Mantém registros financeiros, parcelas, contratos e dados
 *    dos responsáveis associados às matrículas.
 *    ATENÇÃO: revisar especialmente a linha 30.
 *
 * 2. web/lib/biblioteca.php — linhas 41–80
 *    Array: STUDENT_LOANS
 *    Mantém empréstimos e solicitações de livros vinculados
 *    às matrículas dos alunos.
 *
 * 3. web/lib/suporte.php — linhas 59–167
 *    Array: SUPPORT_TICKETS
 *    Mantém os chamados de suporte associados a cada aluno.
 *
 * 4. web/lib/materiais.php — linhas 8–84
 *    Array: REPOSITORY_RECORDS
 *    Mantém as pastas e os arquivos do repositório de cada aluno.
 *    As referências do campo 'discipline' devem corresponder
 *    às chaves das disciplinas em ACADEMIC_RECORDS.
 *    ATENÇÃO: conferir também as linhas 13–14, que contêm
 *    nomes de professores que precisam ser revisados.
 *
 * 5. web/lib/protocolo.php — linhas 12–62
 *    Array: STUDENT_REQUESTS
 *    Mantém os requerimentos acadêmicos vinculados às matrículas.
 *
 * 6. web/lib/avisos.php — linhas 21–84
 *    Array: NOTICES
 *    O campo 'audience' define quais alunos podem visualizar
 *    cada aviso. Conferir os autores e o público-alvo.
 *    ATENÇÃO: revisar especialmente as linhas 23 e 55,
 *    que contêm nomes genéricos de professores.
 *
 * 7. web/lib/eventos.php — linhas 15 e 87
 *    Constante: INTEGRATOR_PROJECT_KEY
 *    Deve corresponder à chave 'projetoIntegrador' utilizada
 *    em ACADEMIC_RECORDS para localizar os eventos da disciplina.
 *
 * ============================================================
 * ARQUIVOS QUE CONSOMEM OS DADOS
 * ============================================================
 *
 * 8. web/lib/autenticacao.php — linhas 77–120
 *    Consulta STUDENTS para validar o login simulado.
 *    Conferir caso a estrutura do cadastro ou as matrículas mudem.
 *
 * 9. web/lib/academico.php — linhas 8–11 e 172
 *    Consulta ACADEMIC_RECORDS e utiliza as constantes acadêmicas
 *    e STATUS_BADGES para calcular e apresentar os dados.
 *    Conferir caso a estrutura do histórico ou os status mudem.
 *
 * ============================================================
 * REFERÊNCIAS INTERNAS DESTE ARQUIVO
 * ============================================================
 *
 * web/lib/dados.php — linhas 29–120:
 * Cadastro dos alunos e suas matrículas (STUDENTS).
 *
 * web/lib/dados.php — linhas 122–468:
 * Histórico acadêmico, disciplinas, notas, frequência e demais
 * informações acadêmicas (ACADEMIC_RECORDS).
 *
 * web/lib/dados.php — linhas 476–490:
 * Classes visuais associadas aos status (STATUS_BADGES).
 *
 * IMPORTANTE:
 * Os números das linhas podem mudar conforme o código for editado.
 * Sempre confirme a posição atual antes de fazer alterações.
 */
