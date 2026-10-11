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
│   └── layout.php               # Cabeçalho e scripts compartilhados
├── assets/
│   ├── css/style.css            # Estilos da aplicação
│   ├── js/components.js         # Menu e componentes JavaScript
│   └── img/                     # Imagens e logotipos
├── lib/
│   └── title.php                # Auxiliar para títulos das páginas
└── pages/                       # Páginas organizadas por módulo
    ├── academico/
    ├── avalieNos/
    ├── financeiro/
    ├── materiais/
    └── suporte/
```

## Fluxo de navegação

O fluxo atual é simples e não possui processamento de login ou persistência:

```text
Navegador
    -> web/index.php
    -> Menu lateral em components.js
    -> Página PHP do módulo
    -> HTML renderizado no navegador
```

Cada página inclui `components/layout.php`, chama `renderHead()` para montar o
cabeçalho e `renderScripts()` para carregar o Bootstrap e os componentes
JavaScript. Os caminhos dos assets são ajustados pelo parâmetro `$assetRoot`.

O arquivo `web/assets/js/components.js` calcula as URLs com base na localização
do próprio script. Dessa forma, os links funcionam tanto no diretório raiz do
servidor quanto quando o projeto é executado dentro de uma subpasta.

## Layout compartilhado

O arquivo `web/components/layout.php` fornece duas funções:

- `renderHead()`: gera a estrutura inicial do documento, define o título,
  carrega Bootstrap, Bootstrap Icons, o CSS principal e aplica o tema salvo no
  `localStorage`.
- `renderScripts()`: carrega o JavaScript do Bootstrap e,
  opcionalmente, `assets/js/components.js`.

O layout não inicia sessões, não valida usuários e não injeta dados de
autenticação no navegador.

## Navegação e componentes

O menu lateral é criado pelo componente `NavBar` em
`web/assets/js/components.js`. Os itens são organizados por módulos, como:

- Acadêmico;
- Financeiro;
- Avalie-nos;
- Materiais;
- Suporte.

Funcionalidades ainda não implementadas são apresentadas visualmente como
indisponíveis. Como não existe autenticação nesta fase, o menu não possui a
opção de logout.

O tema claro/escuro é uma preferência local do navegador, armazenada em
`localStorage` com a chave `alunonet-theme`. Essa preferência não representa uma
sessão de usuário e não é enviada ao servidor.

## Dados e persistência

Os conteúdos exibidos atualmente são estáticos e estão definidos nas próprias
páginas PHP. Não há:

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
