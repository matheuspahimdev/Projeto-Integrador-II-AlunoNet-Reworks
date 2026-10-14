<?php
require_once __DIR__ . '/dados.php';
require_once __DIR__ . '/formatacao.php';

const INSTITUTION = [
    'name' => 'CENTRO UNIVERSITÁRIO DAS FACULDADES INTEGRADAS DE OURINHOS',
    'legal_name' => 'FUNDAÇÃO EDUCACIONAL MIGUEL MOFARREJ - UNIFIO',
    'foundation' => 'UNIFIO - Fundação Educacional "Miguel Mofarrej"',
    'cnpj' => '53.300.547/0001-31',
];

const INSTALLMENTS = [
    [
        'description' => 'Mensalidade - Parcela 04', 'code' => '941962310', 'due_date' => '2026-10-10', 'value' => 741.27, 'paid_at' => null,
        'digitable_line' => '23793.38128 60000.000003 00000.000400 1 99990000074127',
        'pix_code' => '00020126580014br.gov.bcb.pix0136exemplo-alunonet-0000-0000-00005204000053039865406741.275802BR5909ALUNONET6009SAO PAULO62070503***6304ABCD',
    ],
    ['description' => 'Mensalidade - Parcela 03', 'code' => '941954725', 'due_date' => '2026-09-10', 'value' => 741.27, 'paid_at' => '2026-09-10'],
    ['description' => 'Mensalidade - Parcela 02', 'code' => '941941880', 'due_date' => '2026-08-10', 'value' => 741.27, 'paid_at' => '2026-08-10'],
    ['description' => 'Mensalidade - Parcela 01', 'code' => '941936100', 'due_date' => '2026-07-10', 'value' => 667.14, 'paid_at' => '2026-07-03'],
];

const ANNUAL_TUITION_INSTALLMENT = [
    2025 => 1482.54,
    2024 => 1398.76,
    2023 => 1321.10,
];

const CONTRACTOR = [
    'nome' => 'NOME DO RESPONSÁVEL',
    'estadoCivil' => 'Não informado',
    'nascimento' => '01/01/1950',
    'rg' => '00000000000',
    'cpf' => '00000000000',
    'profissao' => '',
    'endereco' => 'RUA FICTÍCIA, 000',
    'bairro' => 'BAIRRO EXEMPLO',
    'cidade' => 'CIDADE',
    'cep' => '00000-000',
    'fone' => '(00) 00000-0000',
];

const ENROLLMENT_CONTRACT = [
    'cidade' => 'OURINHOS',
    'data' => '21 de setembro de 2026',
    'semestreLetivo' => 'JULHO A DEZEMBRO DE 2026',
    'semestralidade' => 8895.24,
    'semestralidadeExtenso' => 'oito mil oitocentos e noventa e cinco reais e vinte e quatro centavos',
    'parcelas' => '6 (seis)',
    'parcela' => 1482.54,
    'parcelaExtenso' => 'um mil quatrocentos e oitenta e dois reais, e cinquenta e quatro centavos',
    'restantes' => '5 (cinco)',
    'diaVencimento' => '10 (DEZ)',
    'inicio' => 'AGOSTO DE 2026',
    'testemunhas' => ['Testemunha 1', 'Testemunha 2'],
];

function isInstallmentPaid(array $installment): bool
{
    return $installment['paid_at'] !== null;
}

function isInstallmentOverdue(array $installment): bool
{
    return !isInstallmentPaid($installment) && $installment['due_date'] < SIMULATED_TODAY;
}

function installmentStatus(array $installment): string
{
    return isInstallmentPaid($installment) ? 'Pago' : 'Em aberto';
}

function paidInstallments(): array
{
    return array_values(array_filter(INSTALLMENTS, 'isInstallmentPaid'));
}

function overdueInstallments(): array
{
    return array_values(array_filter(INSTALLMENTS, 'isInstallmentOverdue'));
}

function lastPayment(): ?array
{
    return paidInstallments()[0] ?? null;
}

function nextInstallmentDue(): ?array
{
    $pending = array_filter(INSTALLMENTS, static fn (array $installment): bool => !isInstallmentPaid($installment) && !isInstallmentOverdue($installment));
    usort($pending, static fn (array $a, array $b): int => $a['due_date'] <=> $b['due_date']);
    return $pending[0] ?? null;
}

function incomeTaxYears(): array
{
    return array_keys(ANNUAL_TUITION_INSTALLMENT);
}

function incomeTaxYearOrLatest(?string $requestedYear): int
{
    $year = (int) $requestedYear;
    return array_key_exists($year, ANNUAL_TUITION_INSTALLMENT) ? $year : incomeTaxYears()[0];
}

function incomeTaxPayments(int $year): array
{
    return array_map(
        static fn (int $month, string $monthName): array => [
            'mes' => $monthName . ' / ' . $year,
            'data' => sprintf('10/%02d/%d', $month, $year),
            'valor' => ANNUAL_TUITION_INSTALLMENT[$year],
        ],
        array_keys(MONTH_NAMES),
        MONTH_NAMES,
    );
}

function totalPaid(array $payments): float
{
    return round(array_sum(array_column($payments, 'valor')), 2);
}

function incomeTaxBeneficiary(): array
{
    return ['nome' => mb_strtoupper(STUDENT['name']), 'cpf' => STUDENT['cpf']];
}

function contractStudent(): array
{
    [$city, $state] = array_map('trim', explode('-', STUDENT['city']));

    return [
        'nome' => mb_strtoupper(STUDENT['name']),
        'matricula' => STUDENT['registration'],
        'curso' => STUDENT['course'],
        'periodo' => STUDENT['term'],
        'sexo' => 'M',
        'estadoCivil' => 'Não informado',
        'rg' => '000000000',
        'orgaoEmissor' => '/',
        'dataExpedicao' => '',
        'local' => mb_strtoupper(STUDENT['address']),
        'numero' => STUDENT['address_number'],
        'complemento' => '',
        'cep' => STUDENT['zip_code'],
        'bairro' => 'BAIRRO EXEMPLO',
        'municipio' => mb_strtoupper($city),
        'uf' => $state,
        'telResidencial' => STUDENT['phone'],
        'telCelular' => STUDENT['phone'],
        'email' => mb_strtoupper(STUDENT['email']),
        'naturalidade' => mb_strtoupper($city),
        'ufNaturalidade' => $state,
        'nacionalidade' => 'BRASILEIRA',
        'nascimento' => '01/01/2000',
        'pai' => 'NOME DO PAI FICTÍCIO',
        'mae' => 'NOME DA MÃE FICTÍCIA',
    ];
}

function contractDocumentName(array $student): string
{
    return 'Contrato_' . $student['matricula'] . '_' . str_replace('/', '-', $student['periodo']);
}