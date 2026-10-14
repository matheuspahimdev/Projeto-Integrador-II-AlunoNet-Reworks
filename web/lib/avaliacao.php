<?php

const EVALUATION_DEADLINE = '30/10';

const RATING_SCALE = [
    1 => 'Muito ruim',
    2 => 'Ruim',
    3 => 'Regular',
    4 => 'Bom',
    5 => 'Excelente',
];

const EVALUATION_SECTIONS = [
    ['name' => 'infraestrutura', 'icon' => 'bi-house', 'title' => '1. Infraestrutura e Serviços', 'question' => 'Como avalia as condições das salas de aula, laboratórios e biblioteca?'],
    ['name' => 'atendimento', 'icon' => 'bi-plus-circle', 'title' => '2. Atendimento Institucional', 'question' => 'Como avalia a agilidade e eficiência do atendimento da Secretaria?'],
];

const EVALUATED_DISCIPLINES = [
    ['id' => 'projeto-integrador-ii', 'label' => 'Projeto Integrador II — Prof. Nome do Professor 1'],
    ['id' => 'direito-aplicado', 'label' => 'Direito Aplicado — Prof. Nome do Professor 2'],
    ['id' => 'banco-de-dados', 'label' => 'Banco de Dados — Prof. Nome do Professor 3'],
    ['id' => 'programacao-web', 'label' => 'Programação Web — Prof. Nome do Professor 4'],
];