<?php

const SIMULATED_TODAY = '2026-10-07';

const PASSING_GRADE = 6.0;

const MINIMUM_ATTENDANCE = 75;

const REQUIRED_COMPLEMENTARY_HOURS = 160;

const STUDENT = [
    'name' => 'Victor H. Oliveira',
    'registration' => '274769',
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
];

const DISCIPLINES = [
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
];

const CLASS_SLOTS = [
    ['start' => '19:15', 'end' => '20:05'],
    ['start' => '20:05', 'end' => '20:55'],
    ['start' => '21:10', 'end' => '22:00'],
    ['start' => '22:00', 'end' => '22:50'],
];

const WEEKLY_SCHEDULE = [
    'Segunda' => ['labProgramacao', 'labProgramacao', 'labProgramacao', 'labProgramacao'],
    'Terça' => ['engRequisitos', 'engRequisitos', 'engRequisitos', 'engRequisitos'],
    'Quarta' => ['projetoIntegrador', 'projetoIntegrador', 'projetoIntegrador', 'projetoIntegrador'],
    'Quinta' => ['resolucaoProblemas', 'resolucaoProblemas', 'resolucaoProblemas', 'resolucaoProblemas'],
    'Sexta' => ['empreendedorismo', 'empreendedorismo', 'direitoInovacao', 'direitoInovacao'],
    'Sábado' => [null, null, null, null],
];

const EXAMS = [
    ['date' => '2026-10-14', 'discipline' => 'projetoIntegrador', 'type' => '1ª avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-pencil-square'],
    ['date' => '2026-10-20', 'discipline' => 'engRequisitos', 'type' => 'Avaliação parcial', 'time' => '21:10 às 22:50', 'icon' => 'bi-journal-check'],
    ['date' => '2026-10-29', 'discipline' => 'resolucaoProblemas', 'type' => 'Avaliação', 'time' => '19:15 às 20:55', 'icon' => 'bi-calculator'],
    ['date' => '2026-11-06', 'discipline' => 'empreendedorismo', 'type' => 'Atividade avaliativa', 'time' => '19:15 às 20:55', 'icon' => 'bi-camera-video'],
];

const COMPLEMENTARY_ACTIVITIES = [
    ['name' => 'Curso de extensão', 'category' => 'Formação complementar', 'hours' => 20, 'status' => 'Deferido'],
    ['name' => 'Evento acadêmico', 'category' => 'Participação em evento', 'hours' => 10, 'status' => 'Deferido'],
    ['name' => 'Projeto voluntário', 'category' => 'Responsabilidade social', 'hours' => 30, 'status' => 'Deferido'],
    ['name' => 'Workshop de tecnologia', 'category' => 'Aperfeiçoamento profissional', 'hours' => 20, 'status' => 'Deferido'],
    ['name' => 'Palestra sobre inovação', 'category' => 'Aguardando análise', 'hours' => 10, 'status' => 'Em análise'],
];

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