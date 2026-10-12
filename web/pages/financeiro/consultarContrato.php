<?php
require_once '../../components/layout.php';
renderHead('Consulta de Contrato', 'dark', '../../', false);

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$campo = static fn (string $label, string $valor): string => '<span><b>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</b> ' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '</span>';
$moeda = static fn (float $valor): string => number_format($valor, 2, ',', '.');

$instituicao = 'CENTRO UNIVERSITÁRIO DAS FACULDADES INTEGRADAS DE OURINHOS';

$aluno = [
    'nome' => 'NOME DO ALUNO',
    'matricula' => '000000',
    'curso' => 'Engenharia de Software',
    'periodo' => '2026/2',
    'sexo' => 'M',
    'estadoCivil' => 'Não informado',
    'rg' => '000000000',
    'orgaoEmissor' => '/',
    'dataExpedicao' => '',
    'local' => 'RUA FICTÍCIA, 000',
    'numero' => '000',
    'complemento' => '',
    'cep' => '00000-000',
    'bairro' => 'BAIRRO EXEMPLO',
    'municipio' => 'CIDADE',
    'uf' => 'UF',
    'telResidencial' => '(00) 00000-0000',
    'telCelular' => '(00) 00000-0000',
    'email' => 'ALUNO@GMAIL.COM',
    'naturalidade' => 'CIDADE',
    'ufNaturalidade' => 'UF',
    'nacionalidade' => 'BRASILEIRA',
    'nascimento' => '01/01/2000',
    'pai' => 'NOME DO PAI FICTÍCIO',
    'mae' => 'NOME DA MÃE FICTÍCIA',
];

$contratante = [
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

$contrato = [
    'cidade' => 'CIDADE',
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
    'fundacao' => 'UNIFIO - Fundação Educacional "Miguel Mofarrej"',
];

$tituloImpressao = 'Contrato_' . $aluno['matricula'] . '_' . str_replace('/', '-', $aluno['periodo']);
?>

<body>
<div class="app-shell">
  <nav-bar id="main-navigation"></nav-bar>
  <main class="page-content">
    <portal-header></portal-header>

    <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3 no-print">
      <div>
        <h1 class="display-6">Consulta de Contrato</h1>
        <p class="text-secondary mb-0">Requerimento de matrícula e prestação de serviços educacionais</p>
      </div>
      <button class="btn btn-primary" type="button" id="printContract" title="Na janela de impressão, escolha “Salvar como PDF”">
        <i class="bi bi-printer me-2"></i>Imprimir / Baixar PDF
      </button>
    </section>

    <article class="contract-paper" aria-label="Requerimento de matrícula e contrato de prestação de serviços educacionais">
      <h2>Requerimento de Matrícula e Contrato de Prestação de Serviços Educacionais</h2>

      <p>Exma. Sra. Reitora do: <b><?= $e($instituicao) ?></b></p>
      <p>N.º Matrícula: <b><?= $e($aluno['matricula']) ?></b></p>
      <p>Matrícula no Curso: <b><?= $e($aluno['curso']) ?></b> &nbsp;&nbsp;&nbsp; Ano: <b><?= $e($aluno['periodo']) ?></b></p>

      <h3 class="contract-section">Dados gerais:</h3>

      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Nome:', $aluno['nome']) ?></div>
        <div class="contract-line"><?= $campo('Sexo:', $aluno['sexo']) ?><?= $campo('Est. Civil:', $aluno['estadoCivil']) ?></div>
      </div>
      <div class="contract-line">
        <?= $campo('R.G.:', $aluno['rg']) ?><?= $campo('Órgão Emissor:', $aluno['orgaoEmissor']) ?><?= $campo('Data Expedição:', $aluno['dataExpedicao']) ?>
      </div>

      <p class="mt-4"><b>Endereço:</b></p>
      <div class="contract-line">
        <?= $campo('Local:', $aluno['local']) ?><?= $campo('N.º:', $aluno['numero']) ?><?= $campo('Compl:', $aluno['complemento']) ?><?= $campo('CEP:', $aluno['cep']) ?>
      </div>
      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Bairro:', $aluno['bairro']) ?></div>
        <div class="contract-line"><?= $campo('Município:', $aluno['municipio']) ?><?= $campo('UF:', $aluno['uf']) ?></div>
        <div class="contract-line"><?= $campo('Tel. Res.:', $aluno['telResidencial']) ?></div>
        <div class="contract-line"><?= $campo('Tel. Celular:', $aluno['telCelular']) ?></div>
      </div>
      <div class="contract-line"><?= $campo('E-mail:', $aluno['email']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Naturalidade:', $aluno['naturalidade']) ?><?= $campo('UF:', $aluno['ufNaturalidade']) ?></div>
        <div class="contract-line"><?= $campo('Nacionalidade:', $aluno['nacionalidade']) ?><?= $campo('Data Nasc.:', $aluno['nascimento']) ?></div>
      </div>

      <p class="mt-3"><b>Filiação:</b></p>
      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Pai:', $aluno['pai']) ?></div>
        <div class="contract-line"><?= $campo('Mãe:', $aluno['mae']) ?></div>
      </div>

      <div class="contract-clauses mt-4">
        <p><b><?= $e($instituicao) ?></b></p>
        <p>O(A) CONTRATANTE ACIMA IDENTIFICADO(A), JUNTANDO OS DOCUMENTOS EXIGIDOS, REQUER MATRÍCULA PARA O SEMESTRE LETIVO DE <?= $e($contrato['semestreLetivo']) ?>, NO CURSO E TURMA ESPECIFICADOS, OBRIGANDO-SE A RESPEITAR E CUMPRIR O REGIMENTO ESCOLAR, AS NORMAS DE CONDUTA, LEGISLAÇÃO APLICÁVEL À ÁREA DE ENSINO E AS EMANADAS DE OUTRAS FONTES LEGAIS QUE REGULEM SUPLETIVAMENTE A MATÉRIA. O CONTRATO DE SERVIÇOS EDUCACIONAIS, CONDICIONADO AO DEFERIMENTO DA MATRÍCULA, FICA DESDE LOGO CELEBRADO, E PASSARÁ A SER REGIDO PELAS CLÁUSULAS PRINCIPAIS A SEGUIR:</p>
        <p><b>CLÁUSULA 1ª.</b> A FUNDAÇÃO SE OBRIGA A MINISTRAR O ENSINO POR MEIO DE AULAS E DEMAIS ATIVIDADES ESCOLARES, DEVENDO O PLANO DE ESTUDOS, OS PROGRAMAS, O CURRÍCULO E O CALENDÁRIO ESCOLAR ESTAREM EM CONFORMIDADE COM O DISPOSTO NA LEGISLAÇÃO EM VIGOR E DE ACORDO COM O PLANO ESCOLAR PARA A SÉRIE E CURSO OBJETO DO REQUERIMENTO DE MATRÍCULA ACIMA.</p>
        <p><b>CLÁUSULA 2ª.</b> O(A) REQUERENTE/CONTRATANTE PAGARÁ A SEMESTRALIDADE DE R$ <?= $moeda($contrato['semestralidade']) ?> (<?= $e($contrato['semestralidadeExtenso']) ?>), EM <?= $e($contrato['parcelas']) ?> PARCELAS MENSAIS E IGUAIS DE R$ <?= $moeda($contrato['parcela']) ?> (<?= $e($contrato['parcelaExtenso']) ?>), A PRIMEIRA NESTE ATO, E AS <?= $e($contrato['restantes']) ?> RESTANTES TODO DIA <?= $e($contrato['diaVencimento']) ?> DE CADA MÊS, A PARTIR DE <?= $e($contrato['inicio']) ?>, NA REDE BANCÁRIA AUTORIZADA.</p>
        <p><b>CLÁUSULA 3ª.</b> A FALTA DE PAGAMENTO DE QUALQUER PARCELA NO RESPECTIVO VENCIMENTO SUJEITARÁ O(A) REQUERENTE/CONTRATANTE AO PAGAMENTO DE MULTA DE 2% (DOIS POR CENTO) SOBRE O VALOR TOTAL DO DÉBITO ATUALIZADO PELO INPC/IBGE, MAIS JUROS DE MORA DE 1% (UM POR CENTO) AO MÊS CALCULADOS PRO RATA DIE SOBRE O DÉBITO ATUALIZADO, DESDE A DATA DO INADIMPLEMENTO ATÉ A DA EFETIVAÇÃO DO PAGAMENTO.</p>
        <p><b>CLÁUSULA 4ª.</b> A FUNDAÇÃO EMITIRÁ DUPLICATAS DE PRESTAÇÃO DE SERVIÇOS EM RELAÇÃO AOS CRÉDITOS DECORRENTES DESTE CONTRATO, SENDO CERTO QUE, EM CASO DE NÃO PAGAMENTO NO RESPECTIVO VENCIMENTO, O TÍTULO DE CRÉDITO SERÁ ENCAMINHADO AO PROTESTO CAMBIAL E POSTERIOR COBRANÇA JUDICIAL.</p>
        <p><b>CLÁUSULA 5ª.</b> O USUÁRIO E SENHA FORNECIDOS PARA ACESSO AO PORTAL ELETRÔNICO SÃO DE USO PESSOAL E INTRANSFERÍVEL. O(A) REQUERENTE/CONTRATANTE SE OBRIGA A ALTERAR A SENHA APÓS O PRIMEIRO ACESSO, DE MOLDE QUE A PARTIR DA ALTERAÇÃO A SENHA SERÁ DE CONHECIMENTO EXCLUSIVO DO(A) MESMO(A), ASSUMINDO TOTAL RESPONSABILIDADE PELO SIGILO E UTILIZAÇÃO.</p>
        <p><b>CLÁUSULA 6ª.</b> AO ASSINAR O PRESENTE CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS, O(A) REQUERENTE/CONTRATANTE ADERE ÀS CLÁUSULAS GERAIS ESTABELECIDAS PELAS PORTARIAS DA PRESIDÊNCIA N.º 02/2003, REGISTRADA PERANTE O CARTÓRIO DE REGISTRO DE TÍTULOS E DOCUMENTOS DE OURINHOS SOB O N.º 28.845, DO LIVRO B, EM 15/12/2003, E SUBSEQUENTES ALTERAÇÕES.</p>
      </div>

      <p class="contract-date"><?= $e($contrato['cidade']) ?>, <?= $e($contrato['data']) ?>.</p>

      <p><b>TESTEMUNHAS:</b></p>
      <div class="contract-signatures">
        <?php foreach ($contrato['testemunhas'] as $testemunha): ?>
          <div class="contract-signature">
            <?= $e($testemunha) ?><br>RG.: 00.000.000-0<br>CPF: 000.000.000-00
          </div>
        <?php endforeach; ?>
      </div>
      <div class="contract-signatures">
        <div class="contract-signature"><?= $e($contrato['fundacao']) ?></div>
        <div class="contract-signature">Aluno(a) ou Responsável<br><b><?= $e($contratante['nome']) ?></b></div>
      </div>

      <hr class="contract-divider">

      <h3 class="contract-section">Dados do(a) contratante:</h3>
      <div class="contract-line"><?= $campo('Nome:', $contratante['nome']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Est. Civil:', $contratante['estadoCivil']) ?></div>
        <div class="contract-line"><?= $campo('Data Nasc.:', $contratante['nascimento']) ?></div>
        <div class="contract-line"><?= $campo('RG.:', $contratante['rg']) ?></div>
        <div class="contract-line"><?= $campo('CPF:', $contratante['cpf']) ?></div>
      </div>
      <div class="contract-line"><?= $campo('Profissão:', $contratante['profissao']) ?></div>
      <div class="contract-line"><?= $campo('Endereço:', $contratante['endereco']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $campo('Bairro:', $contratante['bairro']) ?></div>
        <div class="contract-line"><?= $campo('Cidade:', $contratante['cidade']) ?></div>
        <div class="contract-line"><?= $campo('CEP:', $contratante['cep']) ?></div>
        <div class="contract-line"><?= $campo('Fone:', $contratante['fone']) ?></div>
      </div>

      <p class="mt-4"><b>Deferido:</b></p>
      <p><b><?= $e($contrato['cidade']) ?>, <?= $e($contrato['data']) ?>.</b></p>
      <div class="contract-signatures">
        <div class="contract-signature">Secretária Geral Interina</div>
        <div class="contract-signature">Reitora</div>
      </div>
    </article>

  </main>
</div>

<?php renderScripts(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const originalTitle = document.title;
  const printTitle = <?= json_encode($tituloImpressao, JSON_UNESCAPED_UNICODE) ?>;

  window.addEventListener('beforeprint', () => { document.title = printTitle; });
  window.addEventListener('afterprint', () => { document.title = originalTitle; });

  document.getElementById('printContract').addEventListener('click', () => window.print());
});
</script>

</body>
</html>
