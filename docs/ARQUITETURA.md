# Arquitetura - Portal do Aluno

## Introdução

O AlunoNet foi recriado como um protótipo navegável do portal do aluno da
UNIFIO (Centro Universitário das Faculdades Integradas de Ourinhos). Nesta etapa,
o objetivo principal é representar a interface, a organização das informações e o
fluxo de navegação usando PHP nativo e Bootstrap.

O escopo atual possui um **login simulado**: o aluno entra com matrícula e senha,
a sessão PHP guarda apenas a matrícula e todas as páginas exibem os dados desse
aluno. Não há banco de dados; os dados são simulados em arquivos PHP e as ações
feitas nas páginas ficam no `localStorage` do navegador.

## Arquitetura implementada

O projeto está concentrado na pasta `web` e separa apresentação de dados:

- **Páginas PHP (`pages/`):** exibem as telas do portal. Cuidam apenas da
  apresentação e chamam funções da `lib`.
- **Componentes (`components/`):** estrutura do documento, menu lateral, barra
  superior, cabeçalhos de página, cards e diálogo de logout.
- **Biblioteca (`lib/`):** dados simulados, autenticação e regras de negócio,
  com um arquivo por módulo.
- **JavaScript (`assets/js/components.js`):** comportamento do menu, tema,
  diálogo de logout e utilitários compartilhados pelos scripts das páginas.
- **CSS (`assets/css/style.css`):** tema visual claro/escuro, layout responsivo
  e estilos específicos das páginas.
- **Imagens e ícones (`assets/img`, `assets/icons`):** logotipos, favicon e
  manifest.

As páginas não dependem de controllers, repositories, entidades ou serviços
externos para serem exibidas.

## Estrutura atual

```text
index.php                        # Redireciona para web/index.php (php -S localhost:3000)
web/
├── index.php                    # Página inicial (dashboard do aluno)
├── components/
│   ├── layout.php               # Estrutura da página, e(), jsonForScript(), toast
│   ├── navegacao.php            # Menu lateral, barra superior, breadcrumb e diálogo de logout
│   ├── cabecalho.php            # Cabeçalho de página, botões de ação e impressão
│   └── cartao.php               # Cabeçalho dos cards (grid-card)
├── assets/
│   ├── css/style.css            # Estilos da aplicação
│   ├── js/components.js         # Menu, tema, logout e utilitários das páginas
│   ├── img/                     # Imagens e logotipos
│   └── icons/                   # Favicon (.ico/.svg), ícones de app e manifest
├── lib/
│   ├── autenticacao.php         # Login simulado, sessão e aluno logado
│   ├── dados.php                # Alunos (STUDENTS) e registros acadêmicos por aluno
│   ├── navegacao.php            # Itens do menu, página atual e breadcrumb
│   ├── academico.php            # Regras acadêmicas (médias, frequência, provas)
│   ├── formatacao.php           # Formatação de datas, notas e valores
│   ├── tempo.php                # Data simulada (SIMULATED_TODAY) e datas relativas
│   ├── avaliacao.php            # Questionário da Avaliação Institucional
│   ├── avisos.php               # Avisos, categorias, prioridades e público-alvo
│   ├── biblioteca.php           # Acervo e empréstimos por aluno
│   ├── eventos.php              # Calendário de eventos
│   ├── financeiro.php           # Parcelas, boleto, informe de IR e contrato por aluno
│   ├── materiais.php            # Pastas e arquivos do repositório por aluno
│   ├── perfil.php               # Preferências de notificação e regras de senha
│   ├── protocolo.php            # Requerimentos por aluno
│   └── suporte.php              # Departamentos e chamados por aluno
└── pages/                       # Páginas organizadas por módulo
    ├── academico/
    ├── auth/                    # login.php e logout.php
    ├── avalieNos/
    ├── avisos/
    ├── biblioteca/
    ├── eventos/
    ├── financeiro/
    ├── materiais/
    ├── perfil/
    ├── protocolo/
    └── suporte/
```

## Fluxo de navegação

```text
Navegador
    -> index.php (raiz) -> web/index.php
    -> renderPageStart() chama requireLogin()
        -> sem sessão: redireciona para pages/auth/login.php
        -> com sessão: monta topbar e menu com os dados do aluno
    -> Página PHP do módulo (dados vindos da lib para o aluno logado)
    -> HTML renderizado no navegador
```

Cada página inclui `components/layout.php`, chama `renderPageStart()` para abrir
o documento e `renderPageEnd()` para fechá-lo e carregar os scripts. Os caminhos
dos assets são ajustados pelo parâmetro `$assetRoot`.

Os links do menu são relativos e montados com o mesmo `$assetRoot`. Dessa
forma, funcionam tanto no diretório raiz do servidor quanto quando o projeto é
executado dentro de uma subpasta. Os redirecionamentos (`redirectTo()`) usam
`pathToWebRoot()`, que calcula o caminho relativo da página atual até `web/`.

## Autenticação simulada

A autenticação fica em `web/lib/autenticacao.php`:

- `login($matricula, $senha)`: valida os campos (`validateLogin()`), procura o
  aluno em `STUDENTS` e, se a senha conferir, grava a matrícula em
  `$_SESSION['registration']`. Retorna um array de erros (vazio em caso de
  sucesso).
- `logout()`: destrói a sessão.
- `loggedStudent()`: aluno da sessão ou `null`.
- `requireLogin()`: redireciona para `pages/auth/login.php` se não houver aluno
  logado. É chamado por `renderPageStart()`, então toda página que usa o layout
  já é protegida.
- `currentStudent()`: dados do aluno logado, usados pelas páginas e pela `lib`.
- `studentStorageKey($nome)`: gera a chave de `localStorage` do aluno
  (`alunonet.<nome>.<matrícula>`), para que alunos diferentes no mesmo navegador
  não vejam os dados uns dos outros.

A tela `pages/auth/login.php` não usa `renderPageStart()` (apenas
`renderDocumentHead()`), valida os campos também no navegador com as mensagens
de `LOGIN_MESSAGES` e pode lembrar a matrícula no `localStorage`. Um aluno já
logado que acesse o login é enviado direto para a página inicial.

O logout é feito pelo item "Sair" do menu, que abre um diálogo de confirmação
(`renderLogoutDialog()`) antes de ir para `pages/auth/logout.php`.

As senhas ficam em texto puro em `STUDENTS`. O login existe apenas para
demonstrar o fluxo e não deve ser tratado como mecanismo de segurança.

## Layout compartilhado

O arquivo `web/components/layout.php` fornece:

- `renderPageStart($titulo, $assetRoot)`: exige login, gera o `<head>`, o link
  "Pular para o conteúdo", a barra superior e o menu lateral.
- `renderAcademicPageStart($titulo)`: atalho para páginas acadêmicas, que já
  inclui o cabeçalho com o link para a Central Acadêmica.
- `renderDocumentHead($titulo, $assetRoot)`: apenas o `<head>` (Bootstrap,
  Bootstrap Icons, CSS principal, favicon, manifest e tema salvo no
  `localStorage`). O `<html>` recebe `data-today` com a data simulada.
- `renderPageEnd($assetRoot)`: fecha a estrutura, inclui o diálogo de logout e o
  toast da página e carrega o JavaScript do Bootstrap e `components.js`.
- `e()`: escapa valores antes de exibi-los no HTML.
- `jsonForScript()`: serializa dados para os scripts das páginas com segurança.

A barra superior (`renderTopbar()`) mostra a logo, o breadcrumb
(`breadcrumbTrail()`), o seletor de curso, o botão de tema e o nome, a matrícula
e as iniciais do aluno, com link para "Meu Perfil".

Componentes reutilizáveis:

- `renderPageHeader($titulo, $subtitulo, $acoes, $classeExtra)`: título da
  página. `$acoes` é uma função opcional que imprime os botões à direita.
- `renderActionLink()` e `renderActionButton()`: botões de ação com ícone,
  usados dentro de `$acoes`.
- `renderPrintButton()`: abre a impressão do navegador com um nome de arquivo
  sugerido para "Salvar como PDF".
- `renderAcademicHeader($titulo)`: cabeçalho padrão das páginas acadêmicas.
- `renderCardHead($icone, $titulo, $subtitulo)`: cabeçalho dos cards
  `.grid-card`. O corpo do card usa `.grid-card__body`.

Exemplo de página nova:

```php
<?php
require_once __DIR__ . '/../../components/layout.php';

renderPageStart('Minha Página');
renderPageHeader('Minha Página', 'Descrição curta', static fn () => renderActionLink('outra.php', 'bi-arrow-right', 'Ir para outra'));
?>
    <section class="grid-card">
      <?php renderCardHead('bi-star', 'Olá, ' . studentFirstName(), 'Subtítulo opcional'); ?>
      <div class="grid-card__body">Conteúdo</div>
    </section>
<?php renderPageEnd(); ?>
```

## Navegação e componentes

O menu lateral e a barra superior são gerados no servidor por
`web/components/navegacao.php`, a partir da lista `NAVIGATION` em
`web/lib/navegacao.php`. Como chegam prontos no HTML, a logo e o menu aparecem
já na primeira pintura, sem piscar ao trocar de página. Para adicionar uma
página ao menu, basta incluir um item em `NAVIGATION`. O item ativo, o
`aria-current` e o breadcrumb são definidos automaticamente. Os itens são
organizados por módulos:

- Início;
- Acadêmico;
- Financeiro;
- Protocolos;
- Avalie-nos;
- Materiais;
- Avisos;
- Biblioteca;
- Eventos;
- Moodle e Carreiras (links externos, abertos em nova aba);
- Suporte;
- Sair.

O `web/assets/js/components.js` cuida do comportamento: abrir e fechar
submenus, abrir o menu no celular (fecha com Esc ou tocando fora), alternar o
tema, abrir o diálogo de logout, copiar códigos (`data-copy`), imprimir
(`data-print-title`) e mostrar/ocultar senhas (`data-toggle-password`). Também
expõe utilitários usados pelos scripts das páginas, como `portalToday()`,
`readStoredJson()`, `storeJson()` e `showToast()`.

O tema claro/escuro é uma preferência local do navegador, armazenada em
`localStorage` com a chave `alunonet-theme`, e vale para todos os alunos.

## Dados e persistência

Os conteúdos exibidos são simulados. As páginas cuidam apenas da apresentação:
os dados e as regras de negócio ficam em `web/lib`, com um arquivo por módulo.

- `dados.php` define os alunos de demonstração (`STUDENTS`) e, em
  `ACADEMIC_RECORDS`, as disciplinas, horários, provas, atividades
  complementares e grade de cada um. `academico.php` calcula médias,
  frequências, situações e a próxima avaliação.
- Os módulos guardam seus registros indexados pela matrícula
  (`FINANCIAL_RECORDS`, `STUDENT_REQUESTS`, `SUPPORT_TICKETS`, `STUDENT_LOANS`,
  `REPOSITORY_RECORDS`). As funções de acesso, como `financialRecord()` ou
  `studentLoans()`, usam `currentStudent()` para devolver só os dados do aluno
  logado. Os avisos usam o campo `audience` para definir quem os recebe.
- `formatacao.php` e `tempo.php` são compartilhados entre os módulos.

Todos os módulos usam a constante `SIMULATED_TODAY` (em `tempo.php`) como data
de referência. O mesmo valor vai para o atributo `data-today` do `<html>`, e o
JavaScript o lê com `portalToday()`. Assim, PHP e navegador concordam sobre o
"hoje" do protótipo.

As ações feitas nas páginas (chamados abertos, reservas de livros, avisos lidos,
foto e preferências do perfil) são salvas no `localStorage` com as chaves de
`studentStorageKey()`, ou seja, separadas por aluno e restritas ao navegador.

Para integrar um banco de dados ou uma API, basta trocar o corpo das funções da
`lib` mantendo o formato dos dados retornados; as páginas não precisam mudar.
Ainda não há:

- banco de dados;
- controllers ou repositories;
- cadastro de usuários ou senhas protegidas por hash;
- envio real de formulários para o servidor (exceto o login).

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

- autenticação real, com senhas em hash e proteção contra CSRF;
- controllers para cada módulo;
- entidades e repositories;
- persistência em banco de dados no lugar das constantes e do `localStorage`;
- validação e processamento dos formulários no servidor.

Esses recursos não fazem parte da implementação atual e só devem ser
introduzidos quando forem definidos como requisito do projeto.

## Critérios da decisão atual

O protótipo com login simulado e sem banco de dados foi adotado porque:

1. mantém o foco na interface e na usabilidade;
2. permite demonstrar o portal com alunos diferentes, cada um com seus dados;
3. dispensa configurar infraestrutura (basta `php -S`);
4. facilita a validação visual das páginas e dos componentes;
5. mantém aberta a integração futura com uma API ou banco de dados, já que as
   páginas só dependem das funções da `lib`.

## Conclusão

A arquitetura atual é uma aplicação PHP de apresentação, com componentes
compartilhados, Bootstrap e JavaScript para a navegação. O acesso passa por um
login simulado baseado em sessão, e todas as páginas exibem os dados do aluno
logado a partir da `lib`.

A separação em camadas MVC permanece como possibilidade de evolução, mas não
deve ser considerada parte do funcionamento atual enquanto não houver
persistência real.
