<?php
require_once __DIR__ . '/autenticacao.php';
require_once __DIR__ . '/formatacao.php';

const INSTITUTION = [
    'name' => 'CENTRO UNIVERSITÁRIO DAS FACULDADES INTEGRADAS DE OURINHOS',
    'legal_name' => 'FUNDAÇÃO EDUCACIONAL MIGUEL MOFARREJ - UNIFIO',
    'foundation' => 'UNIFIO - Fundação Educacional "Miguel Mofarrej"',
    'cnpj' => '53.300.547/0001-31',
];

const FINANCIAL_RECORDS = [
    '274769' => [
        'installments' => [
            [
                'description' => 'Mensalidade - Parcela 04', 'code' => '941962310', 'due_date' => '2026-10-10', 'value' => 741.27, 'paid_at' => null,
                'digitable_line' => '23793.38128 60000.000003 00000.000400 1 99990000074127',
                'pix_code' => '00020126580014br.gov.bcb.pix0136exemplo-alunonet-0000-0000-00005204000053039865406741.275802BR5909ALUNONET6009SAO PAULO62070503***6304ABCD',
            ],
            ['description' => 'Mensalidade - Parcela 03', 'code' => '941954725', 'due_date' => '2026-09-10', 'value' => 741.27, 'paid_at' => '2026-09-10'],
            ['description' => 'Mensalidade - Parcela 02', 'code' => '941941880', 'due_date' => '2026-08-10', 'value' => 741.27, 'paid_at' => '2026-08-10'],
            ['description' => 'Mensalidade - Parcela 01', 'code' => '941936100', 'due_date' => '2026-07-10', 'value' => 667.14, 'paid_at' => '2026-07-03'],
        ],
        'annual_tuition_installment' => [
            2025 => 1482.54,
            2024 => 1398.76,
            2023 => 1321.10,
        ],
        'contractor' => [
            'name' => 'NOME DO RESPONSÁVEL',
            'marital_status' => 'Não informado',
            'birth_date' => '01/01/1950',
            'rg' => '00000000000',
            'cpf' => '00000000000',
            'profession' => '',
            'address' => 'RUA FICTÍCIA, 000',
            'district' => 'BAIRRO EXEMPLO',
            'city' => 'CIDADE',
            'zip_code' => '00000-000',
            'phone' => '(00) 00000-0000',
        ],
        'enrollment_contract' => [
            'city' => 'OURINHOS',
            'signed_on' => '21 de setembro de 2026',
            'academic_term' => 'JULHO A DEZEMBRO DE 2026',
            'semester_fee' => 8895.24,
            'semester_fee_in_words' => 'oito mil oitocentos e noventa e cinco reais e vinte e quatro centavos',
            'installment_count' => 6,
            'installments_label' => '6 (seis)',
            'installment_value' => 1482.54,
            'installment_value_in_words' => 'um mil quatrocentos e oitenta e dois reais, e cinquenta e quatro centavos',
            'remaining_installments' => '5 (cinco)',
            'due_day' => '10 (DEZ)',
            'starts_on' => 'AGOSTO DE 2026',
            'witnesses' => ['Testemunha 1', 'Testemunha 2'],
        ],
    ],
    '281450' => [
        'installments' => [
            [
                'description' => 'Mensalidade - Parcela 04', 'code' => '952310874', 'due_date' => '2026-10-20', 'value' => 980.40, 'paid_at' => null,
                'digitable_line' => '23793.38128 60000.000003 00000.000400 2 99990000098040',
                'pix_code' => '00020126580014br.gov.bcb.pix0136exemplo-alunonet-0000-0000-00015204000053039865406980.405802BR5909ALUNONET6009SAO PAULO62070503***6304BCDE',
            ],
            ['description' => 'Mensalidade - Parcela 03', 'code' => '952298113', 'due_date' => '2026-09-20', 'value' => 980.40, 'paid_at' => '2026-09-18'],
            ['description' => 'Mensalidade - Parcela 02', 'code' => '952285460', 'due_date' => '2026-08-20', 'value' => 980.40, 'paid_at' => '2026-08-19'],
            ['description' => 'Mensalidade - Parcela 01', 'code' => '952271935', 'due_date' => '2026-07-20', 'value' => 882.36, 'paid_at' => '2026-07-15'],
        ],
        'annual_tuition_installment' => [
            2025 => 935.80,
        ],
        'contractor' => [
            'name' => 'NOME DA RESPONSÁVEL',
            'marital_status' => 'Casada',
            'birth_date' => '10/06/1975',
            'rg' => '11111111111',
            'cpf' => '11111111111',
            'profession' => 'Professora',
            'address' => 'AVENIDA EXEMPLO, 250',
            'district' => 'CENTRO',
            'city' => 'OURINHOS',
            'zip_code' => '19901-000',
            'phone' => '(14) 98888-1111',
        ],
        'enrollment_contract' => [
            'city' => 'OURINHOS',
            'signed_on' => '18 de julho de 2026',
            'academic_term' => 'JULHO A DEZEMBRO DE 2026',
            'semester_fee' => 5882.40,
            'semester_fee_in_words' => 'cinco mil oitocentos e oitenta e dois reais e quarenta centavos',
            'installment_count' => 6,
            'installments_label' => '6 (seis)',
            'installment_value' => 980.40,
            'installment_value_in_words' => 'novecentos e oitenta reais e quarenta centavos',
            'remaining_installments' => '5 (cinco)',
            'due_day' => '20 (VINTE)',
            'starts_on' => 'AGOSTO DE 2026',
            'witnesses' => ['Testemunha 1', 'Testemunha 2'],
        ],
    ],
    '268112' => [
        'installments' => [
            [
                'description' => 'Mensalidade - Parcela 04', 'code' => '938874502', 'due_date' => '2026-10-05', 'value' => 1210.00, 'paid_at' => null,
                'digitable_line' => '23793.38128 60000.000003 00000.000400 3 99990000121000',
                'pix_code' => '00020126580014br.gov.bcb.pix0136exemplo-alunonet-0000-0000-000252040000530398654071210.005802BR5909ALUNONET6009SAO PAULO62070503***6304CDEF',
            ],
            [
                'description' => 'Mensalidade - Parcela 03', 'code' => '938861277', 'due_date' => '2026-09-05', 'value' => 1210.00, 'paid_at' => null,
                'digitable_line' => '23793.38128 60000.000003 00000.000300 4 99990000121000',
                'pix_code' => '00020126580014br.gov.bcb.pix0136exemplo-alunonet-0000-0000-000352040000530398654071210.005802BR5909ALUNONET6009SAO PAULO62070503***6304DEF0',
            ],
            ['description' => 'Mensalidade - Parcela 02', 'code' => '938849930', 'due_date' => '2026-08-05', 'value' => 1210.00, 'paid_at' => '2026-08-12'],
            ['description' => 'Mensalidade - Parcela 01', 'code' => '938836614', 'due_date' => '2026-07-05', 'value' => 1089.00, 'paid_at' => '2026-07-05'],
        ],
        'annual_tuition_installment' => [
            2025 => 1152.40,
            2024 => 1098.25,
            2023 => 1045.90,
        ],
        'contractor' => [
            'name' => 'LUCAS FERREIRA LIMA',
            'marital_status' => 'Solteiro',
            'birth_date' => '22/08/2001',
            'rg' => '222222222',
            'cpf' => '22222222222',
            'profession' => 'Assistente administrativo',
            'address' => 'RUA MODELO, 42',
            'district' => 'VILA EXEMPLO',
            'city' => 'OURINHOS',
            'zip_code' => '19902-000',
            'phone' => '(14) 97777-2222',
        ],
        'enrollment_contract' => [
            'city' => 'OURINHOS',
            'signed_on' => '30 de junho de 2026',
            'academic_term' => 'JULHO A DEZEMBRO DE 2026',
            'semester_fee' => 7260.00,
            'semester_fee_in_words' => 'sete mil duzentos e sessenta reais',
            'installment_count' => 6,
            'installments_label' => '6 (seis)',
            'installment_value' => 1210.00,
            'installment_value_in_words' => 'um mil duzentos e dez reais',
            'remaining_installments' => '5 (cinco)',
            'due_day' => '5 (CINCO)',
            'starts_on' => 'AGOSTO DE 2026',
            'witnesses' => ['Testemunha 1', 'Testemunha 2'],
        ],
    ],
];

// Dados financeiros do aluno logado, vindos de FINANCIAL_RECORDS.
function financialRecord(): array
{
    return FINANCIAL_RECORDS[currentStudent()['registration']];
}

function studentInstallments(): array
{
    return financialRecord()['installments'];
}

function annualTuitionInstallment(): array
{
    return financialRecord()['annual_tuition_installment'];
}

function contractor(): array
{
    return financialRecord()['contractor'];
}

function enrollmentContract(): array
{
    return financialRecord()['enrollment_contract'];
}

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
    return array_values(array_filter(studentInstallments(), 'isInstallmentPaid'));
}

function overdueInstallments(): array
{
    return array_values(array_filter(studentInstallments(), 'isInstallmentOverdue'));
}

function lastPayment(): ?array
{
    return paidInstallments()[0] ?? null;
}

// Parcelas ainda não pagas (vencidas e a vencer), da mais antiga para a mais nova.
function unpaidInstallments(): array
{
    $unpaid = array_filter(studentInstallments(), static fn (array $installment): bool => !isInstallmentPaid($installment));
    usort($unpaid, static fn (array $a, array $b): int => $a['due_date'] <=> $b['due_date']);
    return $unpaid;
}

function nextInstallmentDue(): ?array
{
    $pending = array_filter(unpaidInstallments(), static fn (array $installment): bool => !isInstallmentOverdue($installment));
    return array_values($pending)[0] ?? null;
}

function installmentDeadlineLabel(array $installment): string
{
    $days = daysUntil($installment['due_date']);

    return match (true) {
        $days === 0 => 'Vence hoje',
        $days < 0 => 'Atrasado há ' . pluralize(-$days, 'dia', 'dias'),
        $days === 1 => 'Falta 1 dia',
        default => 'Faltam ' . pluralize($days, 'dia', 'dias'),
    };
}

function firstInstallmentDueDate(): DateTimeImmutable
{
    return parseDateTime(min(array_column(studentInstallments(), 'due_date')));
}

function tuitionDueDay(): int
{
    return (int) firstInstallmentDueDate()->format('d');
}

// Um vencimento por mês, a partir da 1ª parcela, até completar as parcelas do contrato.
function tuitionDueDates(): array
{
    $firstDueDate = firstInstallmentDueDate();
    $installmentCount = enrollmentContract()['installment_count'];

    return array_map(
        static fn (int $month): string => $firstDueDate->modify("+{$month} months")->format('Y-m-d'),
        range(0, $installmentCount - 1),
    );
}

function incomeTaxYears(): array
{
    return array_keys(annualTuitionInstallment());
}

function incomeTaxYearOrLatest(?string $requestedYear): int
{
    $year = (int) $requestedYear;
    return array_key_exists($year, annualTuitionInstallment()) ? $year : incomeTaxYears()[0];
}

function incomeTaxPayments(int $year): array
{
    $dueDay = tuitionDueDay();

    return array_map(
        static fn (int $month, string $monthName): array => [
            'month' => $monthName . ' / ' . $year,
            'paid_on' => sprintf('%02d/%02d/%d', $dueDay, $month, $year),
            'amount' => annualTuitionInstallment()[$year],
        ],
        array_keys(MONTH_NAMES),
        MONTH_NAMES,
    );
}

function totalPaid(array $payments): float
{
    return round(array_sum(array_column($payments, 'amount')), 2);
}

function incomeTaxBeneficiary(): array
{
    return ['name' => mb_strtoupper(currentStudent()['name']), 'cpf' => currentStudent()['cpf']];
}

function contractStudent(): array
{
    $student = currentStudent();
    [$city, $state] = array_map('trim', explode('-', $student['city']));

    return [
        'name' => mb_strtoupper($student['name']),
        'registration' => $student['registration'],
        'course' => $student['course'],
        'term' => $student['term'],
        'sex' => $student['sex'],
        'marital_status' => 'Não informado',
        'rg' => $student['rg'],
        'issuing_agency' => '/',
        'issue_date' => '',
        'street' => mb_strtoupper($student['address']),
        'number' => $student['address_number'],
        'complement' => '',
        'zip_code' => $student['zip_code'],
        'district' => 'BAIRRO EXEMPLO',
        'city' => mb_strtoupper($city),
        'state' => $state,
        'home_phone' => $student['phone'],
        'mobile_phone' => $student['phone'],
        'email' => mb_strtoupper($student['email']),
        'birthplace' => mb_strtoupper($city),
        'birthplace_state' => $state,
        'nationality' => 'BRASILEIRA',
        'birth_date' => $student['birth_date'],
        'father' => 'NOME DO PAI FICTÍCIO',
        'mother' => 'NOME DA MÃE FICTÍCIA',
    ];
}

function contractDocumentName(array $student): string
{
    return 'Contrato_' . $student['registration'] . '_' . str_replace('/', '-', $student['term']);
}