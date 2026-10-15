<?php
require_once __DIR__ . '/../../components/layout.php';
require_once __DIR__ . '/../../lib/financeiro.php';

$field = static fn (string $label, string $value): string => '<span><b>' . e($label) . '</b> ' . e($value) . '</span>';

$student = contractStudent();
$contractor = contractor();
$contract = enrollmentContract();
renderPageStart('Consulta de Contrato');
?>

<?php renderPageHeader('Consulta de Contrato', 'Requerimento de matrícula e prestação de serviços educacionais', static fn () => renderPrintButton('bi-printer', 'Imprimir / Baixar PDF', contractDocumentName($student)), 'no-print'); ?>

    <article class="contract-paper" aria-label="Requerimento de matrícula e contrato de prestação de serviços educacionais">
      <h2>Requerimento de Matrícula e Contrato de Prestação de Serviços Educacionais</h2>

      <p>Exma. Sra. Reitora do: <b><?= e(INSTITUTION['name']) ?></b></p>
      <p>N.º Matrícula: <b><?= e($student['registration']) ?></b></p>
      <p>Matrícula no Curso: <b><?= e($student['course']) ?></b> &nbsp;&nbsp;&nbsp; Ano: <b><?= e($student['term']) ?></b></p>

      <h3 class="contract-section">Dados gerais:</h3>

      <div class="contract-cols">
        <div class="contract-line"><?= $field('Nome:', $student['name']) ?></div>
        <div class="contract-line"><?= $field('Sexo:', $student['sex']) ?><?= $field('Est. Civil:', $student['marital_status']) ?></div>
      </div>
      <div class="contract-line">
        <?= $field('R.G.:', $student['rg']) ?><?= $field('Órgão Emissor:', $student['issuing_agency']) ?><?= $field('Data Expedição:', $student['issue_date']) ?>
      </div>

      <p class="mt-4"><b>Endereço:</b></p>
      <div class="contract-line">
        <?= $field('Local:', $student['street']) ?><?= $field('N.º:', $student['number']) ?><?= $field('Compl:', $student['complement']) ?><?= $field('CEP:', $student['zip_code']) ?>
      </div>
      <div class="contract-cols">
        <div class="contract-line"><?= $field('Bairro:', $student['district']) ?></div>
        <div class="contract-line"><?= $field('Município:', $student['city']) ?><?= $field('UF:', $student['state']) ?></div>
        <div class="contract-line"><?= $field('Tel. Res.:', $student['home_phone']) ?></div>
        <div class="contract-line"><?= $field('Tel. Celular:', $student['mobile_phone']) ?></div>
      </div>
      <div class="contract-line"><?= $field('E-mail:', $student['email']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $field('Naturalidade:', $student['birthplace']) ?><?= $field('UF:', $student['birthplace_state']) ?></div>
        <div class="contract-line"><?= $field('Nacionalidade:', $student['nationality']) ?><?= $field('Data Nasc.:', $student['birth_date']) ?></div>
      </div>

      <p class="mt-3"><b>Filiação:</b></p>
      <div class="contract-cols">
        <div class="contract-line"><?= $field('Pai:', $student['father']) ?></div>
        <div class="contract-line"><?= $field('Mãe:', $student['mother']) ?></div>
      </div>

      <div class="contract-clauses mt-4">
        <p><b><?= e(INSTITUTION['name']) ?></b></p>
        <p>O(A) CONTRATANTE ACIMA IDENTIFICADO(A), JUNTANDO OS DOCUMENTOS EXIGIDOS, REQUER MATRÍCULA PARA O SEMESTRE LETIVO DE <?= e($contract['academic_term']) ?>, NO CURSO E TURMA ESPECIFICADOS, OBRIGANDO-SE A RESPEITAR E CUMPRIR O REGIMENTO ESCOLAR, AS NORMAS DE CONDUTA, LEGISLAÇÃO APLICÁVEL À ÁREA DE ENSINO E AS EMANADAS DE OUTRAS FONTES LEGAIS QUE REGULEM SUPLETIVAMENTE A MATÉRIA. O CONTRATO DE SERVIÇOS EDUCACIONAIS, CONDICIONADO AO DEFERIMENTO DA MATRÍCULA, FICA DESDE LOGO CELEBRADO, E PASSARÁ A SER REGIDO PELAS CLÁUSULAS PRINCIPAIS A SEGUIR:</p>
        <p><b>CLÁUSULA 1ª.</b> A FUNDAÇÃO SE OBRIGA A MINISTRAR O ENSINO POR MEIO DE AULAS E DEMAIS ATIVIDADES ESCOLARES, DEVENDO O PLANO DE ESTUDOS, OS PROGRAMAS, O CURRÍCULO E O CALENDÁRIO ESCOLAR ESTAREM EM CONFORMIDADE COM O DISPOSTO NA LEGISLAÇÃO EM VIGOR E DE ACORDO COM O PLANO ESCOLAR PARA A SÉRIE E CURSO OBJETO DO REQUERIMENTO DE MATRÍCULA ACIMA.</p>
        <p><b>CLÁUSULA 2ª.</b> O(A) REQUERENTE/CONTRATANTE PAGARÁ A SEMESTRALIDADE DE R$ <?= formatAmount($contract['semester_fee']) ?> (<?= e($contract['semester_fee_in_words']) ?>), EM <?= e($contract['installments_label']) ?> PARCELAS MENSAIS E IGUAIS DE R$ <?= formatAmount($contract['installment_value']) ?> (<?= e($contract['installment_value_in_words']) ?>), A PRIMEIRA NESTE ATO, E AS <?= e($contract['remaining_installments']) ?> RESTANTES TODO DIA <?= e($contract['due_day']) ?> DE CADA MÊS, A PARTIR DE <?= e($contract['starts_on']) ?>, NA REDE BANCÁRIA AUTORIZADA.</p>
        <p><b>CLÁUSULA 3ª.</b> A FALTA DE PAGAMENTO DE QUALQUER PARCELA NO RESPECTIVO VENCIMENTO SUJEITARÁ O(A) REQUERENTE/CONTRATANTE AO PAGAMENTO DE MULTA DE 2% (DOIS POR CENTO) SOBRE O VALOR TOTAL DO DÉBITO ATUALIZADO PELO INPC/IBGE, MAIS JUROS DE MORA DE 1% (UM POR CENTO) AO MÊS CALCULADOS PRO RATA DIE SOBRE O DÉBITO ATUALIZADO, DESDE A DATA DO INADIMPLEMENTO ATÉ A DA EFETIVAÇÃO DO PAGAMENTO.</p>
        <p><b>CLÁUSULA 4ª.</b> A FUNDAÇÃO EMITIRÁ DUPLICATAS DE PRESTAÇÃO DE SERVIÇOS EM RELAÇÃO AOS CRÉDITOS DECORRENTES DESTE CONTRATO, SENDO CERTO QUE, EM CASO DE NÃO PAGAMENTO NO RESPECTIVO VENCIMENTO, O TÍTULO DE CRÉDITO SERÁ ENCAMINHADO AO PROTESTO CAMBIAL E POSTERIOR COBRANÇA JUDICIAL.</p>
        <p><b>CLÁUSULA 5ª.</b> O USUÁRIO E SENHA FORNECIDOS PARA ACESSO AO PORTAL ELETRÔNICO SÃO DE USO PESSOAL E INTRANSFERÍVEL. O(A) REQUERENTE/CONTRATANTE SE OBRIGA A ALTERAR A SENHA APÓS O PRIMEIRO ACESSO, DE MOLDE QUE A PARTIR DA ALTERAÇÃO A SENHA SERÁ DE CONHECIMENTO EXCLUSIVO DO(A) MESMO(A), ASSUMINDO TOTAL RESPONSABILIDADE PELO SIGILO E UTILIZAÇÃO.</p>
        <p><b>CLÁUSULA 6ª.</b> AO ASSINAR O PRESENTE CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS, O(A) REQUERENTE/CONTRATANTE ADERE ÀS CLÁUSULAS GERAIS ESTABELECIDAS PELAS PORTARIAS DA PRESIDÊNCIA N.º 02/2003, REGISTRADA PERANTE O CARTÓRIO DE REGISTRO DE TÍTULOS E DOCUMENTOS DE OURINHOS SOB O N.º 28.845, DO LIVRO B, EM 15/12/2003, E SUBSEQUENTES ALTERAÇÕES.</p>
      </div>

      <p class="contract-date"><?= e($contract['city']) ?>, <?= e($contract['signed_on']) ?>.</p>

      <p><b>TESTEMUNHAS:</b></p>
      <div class="contract-signatures">
        <?php foreach ($contract['witnesses'] as $witness): ?>
          <div class="contract-signature">
            <?= e($witness) ?><br>RG.: 00.000.000-0<br>CPF: 000.000.000-00
          </div>
        <?php endforeach; ?>
      </div>
      <div class="contract-signatures">
        <div class="contract-signature"><?= e(INSTITUTION['foundation']) ?></div>
        <div class="contract-signature">Aluno(a) ou Responsável<br><b><?= e($contractor['name']) ?></b></div>
      </div>

      <hr class="contract-divider">

      <h3 class="contract-section">Dados do(a) contratante:</h3>
      <div class="contract-line"><?= $field('Nome:', $contractor['name']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $field('Est. Civil:', $contractor['marital_status']) ?></div>
        <div class="contract-line"><?= $field('Data Nasc.:', $contractor['birth_date']) ?></div>
        <div class="contract-line"><?= $field('RG.:', $contractor['rg']) ?></div>
        <div class="contract-line"><?= $field('CPF:', $contractor['cpf']) ?></div>
      </div>
      <div class="contract-line"><?= $field('Profissão:', $contractor['profession']) ?></div>
      <div class="contract-line"><?= $field('Endereço:', $contractor['address']) ?></div>
      <div class="contract-cols">
        <div class="contract-line"><?= $field('Bairro:', $contractor['district']) ?></div>
        <div class="contract-line"><?= $field('Cidade:', $contractor['city']) ?></div>
        <div class="contract-line"><?= $field('CEP:', $contractor['zip_code']) ?></div>
        <div class="contract-line"><?= $field('Fone:', $contractor['phone']) ?></div>
      </div>

      <p class="mt-4"><b>Deferido:</b></p>
      <p><b><?= e($contract['city']) ?>, <?= e($contract['signed_on']) ?>.</b></p>
      <div class="contract-signatures">
        <div class="contract-signature">Secretária Geral Interina</div>
        <div class="contract-signature">Reitora</div>
      </div>
    </article>


<?php renderPageEnd(); ?>
