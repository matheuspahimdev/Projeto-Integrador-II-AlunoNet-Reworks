# Arquitetura - Portal do Aluno

## Introdução

O AlunoNet está sendo recriado como um protótipo navegável do portal do aluno da
UNIFIO (Centro Universitário das Faculdades Integradas de Ourinhos). Nesta etapa,
o objetivo principal é representar a interface, a organização das informações e o
fluxo de navegação usando PHP nativo e Bootstrap.

O escopo atual não possui banco de dados, autenticação ou controle de sessão. O
acesso é direto e manual: o usuário abre a página inicial e navega pelas opções
disponíveis no menu lateral.

## Arquitetura implementada

Atualmente, o projeto está concentrado na pasta `web` e possui uma estrutura
orientada à apresentação:

- **Páginas PHP:** exibem as telas do portal e seus dados estáticos.
- **Componentes compartilhados:** concentram o cabeçalho HTML, os estilos
  externos e os scripts comuns às páginas.
- **JavaScript:** cria o menu lateral e os componentes reutilizáveis do portal,
  além de calcular as rotas relativas para permitir o uso em subpastas.
- **CSS:** define o tema visual, o layout responsivo e os estilos específicos
  das páginas.
- **Imagens:** armazenam as marcas e demais recursos visuais utilizados pela
  interface.

As páginas não dependem de controllers, repositories, entidades ou serviços
externos para serem exibidas.

## Estrutura atual

```text
web/
├── index.php                    # Página inicial do portal
├── components/
│   ├── layout.php               # Estrutura da página, e() e scripts
│   ├── navegacao.php            # Menu lateral e barra superior
│   ├── cabecalho.php            # Cabeçalho de página, botões de ação e "Em construção"
│   └── cartao.php               # Cabeçalho dos cards (grid-card)
├── assets/
│   ├── css/style.css            # Estilos da aplicação
│   ├── js/components.js         # Comportamento do menu, submenus e tema
│   ├── img/                     # Imagens e logotipos
│   └── icons/                   # Favicon (.ico/.svg), ícones de app e manifest
├── lib/
│   ├── dados.php                # Dados simulados do aluno e do semestre
│   ├── navegacao.php            # Itens do menu e detecção da página atual
│   ├── academico.php            # Regras acadêmicas (médias, frequência, provas)
│   ├── formatacao.php           # Formatação de datas, notas e valores
│   ├── tempo.php                # Relógio da simulação e datas relativas
│   ├── avaliacao.php            # Questionário da Avaliação Institucional
│   ├── avisos.php               # Avisos, categorias e prioridades
│   ├── biblioteca.php           # Acervo e empréstimos
│   ├── eventos.php              # Calendário de eventos
│   ├── financeiro.php           # Parcelas, boleto, informe de IR e contrato
│   ├── materiais.php            # Pastas e arquivos do repositório
│   ├── protocolo.php            # Requerimentos
│   └── suporte.php              # Departamentos e chamados
└── pages/                       # Páginas organizadas por módulo
    ├── academico/
    ├── avalieNos/
    ├── avisos/
    ├── biblioteca/
    ├── eventos/
    ├── financeiro/
    ├── materiais/
    ├── protocolo/
    └── suporte/
```

## Fluxo de navegação

O fluxo atual é simples e não possui processamento de login ou persistência:

```text
Navegador
    -> web/index.php
    -> Menu lateral renderizado em PHP (components/navegacao.php)
    -> Página PHP do módulo
    -> HTML renderizado no navegador
```

Cada página inclui `components/layout.php`, chama `renderPageStart()` para abrir
o documento e `renderPageEnd()` para fechá-lo e carregar os scripts. Os caminhos
dos assets são ajustados pelo parâmetro `$assetRoot`.

Os links do menu são relativos e montados com o mesmo `$assetRoot`. Dessa
forma, funcionam tanto no diretório raiz do servidor quanto quando o projeto é
executado dentro de uma subpasta.

## Layout compartilhado

O arquivo `web/components/layout.php` fornece:

- `renderPageStart()`: gera o `<head>` (Bootstrap, Bootstrap Icons, CSS
  principal, favicon e tema salvo no `localStorage`), o link "Pular para o
  conteúdo", o menu lateral e a barra superior com os dados do aluno.
- `renderPageEnd()`: fecha a estrutura da página e carrega o JavaScript do
  Bootstrap e `assets/js/components.js`.
- `e()`: escapa valores antes de exibi-los no HTML.
- `jsonForScript()`: serializa dados para os scripts das páginas com segurança.

Componentes reutilizáveis:

- `renderPageHeader($titulo, $subtitulo, $acoes, $classeExtra)`: título da
  página. `$acoes` é uma função opcional que imprime os botões à direita.
- `renderActionLink()` e `renderActionButton()`: botões de ação com ícone,
  usados dentro de `$acoes`.
- `renderAcademicHeader($titulo)`: cabeçalho padrão das páginas acadêmicas, com
  o atalho para a Central Acadêmica.
- `renderCardHead($icone, $titulo, $subtitulo)`: cabeçalho dos cards
  `.grid-card`. O corpo do card usa `.grid-card__body`.
- `renderUnderConstruction()`: estado "Em construção".

Exemplo de página nova:

```php
<?php
require_once __DIR__ . '/../../components/layout.php';

renderPageStart('Minha Página');
renderPageHeader('Minha Página', 'Descrição curta', static fn () => renderActionLink('outra.php', 'bi-arrow-right', 'Ir para outra'));
?>
    <section class="grid-card">
      <?php renderCardHead('bi-star', 'Título do card', 'Subtítulo opcional'); ?>
      <div class="grid-card__body">Conteúdo</div>
    </section>
<?php renderPageEnd(); ?>
```

O layout não inicia sessões, não valida usuários e não injeta dados de
autenticação no navegador.

## Navegação e componentes

O menu lateral e a barra superior são gerados no servidor por
`web/components/navegacao.php`, a partir da lista `NAVIGATION` em
`web/lib/navegacao.php`. Como chegam prontos no HTML, a logo e o menu aparecem
já na primeira pintura, sem piscar ao trocar de página. Para adicionar uma
página ao menu, basta incluir um item em `NAVIGATION`. O item ativo e o
`aria-current` são marcados automaticamente. Os itens são organizados por
módulos, como:

- Acadêmico;
- Financeiro;
- Protocolos;
- Avalie-nos;
- Materiais;
- Avisos;
- Biblioteca;
- Eventos;
- Suporte.

O `web/assets/js/components.js` cuida apenas do comportamento: abrir e fechar
submenus, abrir o menu no celular (fecha com Esc ou tocando fora) e alternar o
tema. Como não existe autenticação nesta fase, o menu não possui a opção de
logout.

O tema claro/escuro é uma preferência local do navegador, armazenada em
`localStorage` com a chave `alunonet-theme`. Essa preferência não representa uma
sessão de usuário e não é enviada ao servidor.

## Dados e persistência

Os conteúdos exibidos são simulados. As páginas cuidam apenas da apresentação:
os dados e as regras de negócio ficam em `web/lib`, com um arquivo por módulo.

- `dados.php` concentra os dados do aluno e do semestre, e `academico.php`
  calcula médias, frequências, situações e a próxima avaliação.
- Cada módulo (`avisos.php`, `biblioteca.php`, `financeiro.php` etc.) expõe seus
  dados por constantes ou funções e implementa suas próprias regras, como
  parcelas em atraso, próximo vencimento ou o informe de IR por ano.
- `formatacao.php` e `tempo.php` são compartilhados entre os módulos.

O módulo acadêmico e o financeiro usam a constante `SIMULATED_TODAY` como data
de referência. Avisos, biblioteca e suporte geram datas relativas ao dia atual
(`dateFromToday()`), porque os scripts dessas páginas comparam as datas com o
relógio do navegador.

Para integrar um banco de dados ou uma API, basta trocar o corpo das funções da
`lib` mantendo o formato dos dados retornados; as páginas não precisam mudar.
Não há:

- banco de dados;
- arquivo `database.json` em uso;
- controllers ou repositories ativos;
- cadastro ou consulta de usuários;
- login, logout ou sessões PHP.

Formulários e botões existentes representam a experiência planejada do portal,
mas ainda não estão conectados a uma camada de persistência.

## Arquitetura planejada

Quando o escopo exigir dados dinâmicos, a aplicação poderá evoluir para uma
arquitetura em camadas sem alterar a organização visual das páginas. Uma
possível evolução é:

```text
Navegador
    -> Página ou formulário
    -> Rota
    -> Controller
    -> Repository
    -> Persistência
```

Nessa etapa futura poderão ser adicionados:

- autenticação e controle de sessão;
- controllers para cada módulo;
- entidades e repositories;
- persistência em banco de dados;
- validação e processamento dos formulários.

Esses recursos não fazem parte da implementação atual e só devem ser
introduzidos quando forem definidos como requisito do projeto.

## Critérios da decisão atual

O protótipo sem autenticação e sem banco de dados foi adotado porque:

1. mantém o foco na interface e na usabilidade;
2. permite navegar pelas funcionalidades sem configurar infraestrutura;
3. reduz a complexidade durante a fase de demonstração;
4. facilita a validação visual das páginas e dos componentes;
5. mantém aberta a integração futura com uma API ou banco de dados.

## Conclusão

A arquitetura atual é uma aplicação PHP de apresentação, com páginas estáticas,
componentes compartilhados, Bootstrap e JavaScript para a navegação. O portal
pode ser acessado diretamente por `web/index.php`, sem login e sem sessões.

A separação em camadas MVC permanece como possibilidade de evolução, mas não
deve ser considerada parte do funcionamento atual enquanto não houver
persistência ou regras de negócio implementadas.
