<?php

const WEB_ROOT = __DIR__ . '/..';

const MOODLE_URL = 'https://conhecer.unifio.edu.br/login/index.php';

const NAVIGATION = [
    ['label' => 'Início', 'icon' => 'bi-house-door-fill', 'href' => 'index.php'],
    [
        'label' => 'Acadêmico', 'icon' => 'bi-mortarboard',
        'items' => [
            ['label' => 'Central Acadêmica', 'href' => 'pages/academico/centralAcademico.php'],
            ['label' => 'Horário de Aulas', 'href' => 'pages/academico/horarioAulas.php'],
            ['label' => 'Calendário de Provas', 'href' => 'pages/academico/calendarioProvas.php'],
            ['label' => 'Notas', 'href' => 'pages/academico/notas.php'],
            ['label' => 'Faltas', 'href' => 'pages/academico/faltas.php'],
            ['label' => 'Gráficos de Desempenho', 'href' => 'pages/academico/desempenho.php'],
            ['label' => 'Dados Cadastrais', 'href' => 'pages/academico/dadosCadastrais.php'],
            ['label' => 'Confirmação de Matrícula', 'href' => 'pages/academico/confirmacaoMatricula.php'],
            ['label' => 'DIC', 'href' => 'pages/academico/dic.php'],
            ['label' => 'Atualização de Dados Cadastrais', 'href' => 'pages/academico/atualizacaoDadosCadastrais.php'],
            ['label' => 'Atividades Complementares', 'href' => 'pages/academico/atividadesComplementares.php'],
            ['label' => 'Plano de Ensino', 'href' => 'pages/academico/planoEnsino.php'],
            ['label' => 'Carteirinha Digital', 'href' => 'pages/academico/carteirinhaDigital.php'],
        ],
    ],
    [
        'label' => 'Financeiro', 'icon' => 'bi-currency-dollar',
        'items' => [
            ['label' => 'Extrato Financeiro', 'href' => 'pages/financeiro/extratoFinanceiro.php'],
            ['label' => 'Boleto Online', 'href' => 'pages/financeiro/boletoOnline.php'],
            ['label' => 'Consultar Contrato', 'href' => 'pages/financeiro/consultarContrato.php'],
            ['label' => 'Comprovante de IR', 'href' => 'pages/financeiro/comprovanteIR.php'],
        ],
    ],
    [
        'label' => 'Protocolos', 'icon' => 'bi-file-earmark-text',
        'items' => [
            ['label' => 'Entrada de Requerimentos', 'href' => 'pages/protocolo/entradaRequerimentos.php'],
            ['label' => 'Consulta de Requerimentos', 'href' => 'pages/protocolo/consultaRequerimentos.php'],
        ],
    ],
    [
        'label' => 'Avalie-nos', 'icon' => 'bi-pencil-square',
        'items' => [
            ['label' => 'Avaliação Institucional', 'href' => 'pages/avalieNos/avaliacaoInstitucional.php'],
        ],
    ],
    [
        'label' => 'Materiais', 'icon' => 'bi-book-half',
        'items' => [
            ['label' => 'Repositório do Aluno', 'href' => 'pages/materiais/repositorioAluno.php'],
        ],
    ],
    [
        'label' => 'Avisos', 'icon' => 'bi-envelope',
        'items' => [
            ['label' => 'Feed de Avisos', 'href' => 'pages/avisos/feedAvisos.php'],
        ],
    ],
    [
        'label' => 'Biblioteca', 'icon' => 'bi-bookshelf',
        'items' => [
            ['label' => 'Consulta ao Acervo', 'href' => 'pages/biblioteca/consultaAcervo.php'],
            ['label' => 'Meus Empréstimos', 'href' => 'pages/biblioteca/meusEmprestimos.php'],
        ],
    ],
    [
        'label' => 'Eventos', 'icon' => 'bi-calendar-event',
        'items' => [
            ['label' => 'Calendário de Eventos', 'href' => 'pages/eventos/calendarioEventos.php'],
        ],
    ],
    ['label' => 'Moodle', 'icon' => 'bi-easel2', 'href' => MOODLE_URL, 'external' => true],
    ['label' => 'Carreiras', 'icon' => 'bi-rocket-takeoff', 'href' => 'https://workability.worka.love/#/login/unifio/matriculados', 'external' => true],
    [
        'label' => 'Suporte', 'icon' => 'bi-headset', 'accent' => true,
        'items' => [
            ['label' => 'Chamados', 'href' => 'pages/suporte/chamados.php'],
            ['label' => 'Meus Chamados', 'href' => 'pages/suporte/meusChamados.php'],
        ],
    ],
];

const HOME_LINK = ['label' => 'Início', 'icon' => 'bi-house-door', 'href' => 'index.php'];

const PROFILE_LINK = ['label' => 'Meu Perfil', 'href' => 'pages/perfil/perfil.php'];

const LOGOUT_LINK = ['label' => 'Sair', 'icon' => 'bi-box-arrow-right', 'href' => 'pages/auth/logout.php', 'variant' => 'danger'];

function isExternalLink(array $link): bool
{
    return $link['external'] ?? false;
}

function hasSubmenu(array $item): bool
{
    return isset($item['items']);
}

function currentPagePath(): string
{
    return realpath(get_included_files()[0]);
}

function isCurrentPage(array $link): bool
{
    return !isExternalLink($link) && realpath(WEB_ROOT . '/' . $link['href']) === currentPagePath();
}

function isActiveSection(array $item): bool
{
    if (!hasSubmenu($item)) {
        return isCurrentPage($item);
    }

    foreach ($item['items'] as $subitem) {
        if (isCurrentPage($subitem)) {
            return true;
        }
    }

    return false;
}

// Trilha da página atual: Início › seção do menu › página. Seções não têm link, só agrupam.
function breadcrumbTrail(string $pageTitle): array
{
    if (isCurrentPage(HOME_LINK)) {
        return [HOME_LINK];
    }

    foreach ([...NAVIGATION, PROFILE_LINK] as $item) {
        if (!hasSubmenu($item)) {
            if (isCurrentPage($item)) {
                return [HOME_LINK, $item];
            }
            continue;
        }

        foreach ($item['items'] as $subitem) {
            if (isCurrentPage($subitem)) {
                return [HOME_LINK, ['label' => $item['label']], $subitem];
            }
        }
    }

    return [HOME_LINK, ['label' => $pageTitle]];
}

function linkUrl(array $link, string $assetRoot): string
{
    return isExternalLink($link) ? $link['href'] : $assetRoot . $link['href'];
}