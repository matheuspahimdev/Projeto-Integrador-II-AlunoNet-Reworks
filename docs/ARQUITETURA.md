# Arquitetura - Portal do Aluno

## Introdução

O portal do aluno da UNIFIO (Centro Universitário das Faculdades Integradas de Ourinhos) será desenvolvido com uma arquitetura MVC organizada em camadas. Essa escolha separa a apresentação, o processamento das requisições, as regras de acesso aos dados e a representação das informações do sistema.

A arquitetura foi definida para permitir a reconstrução gradual do portal, mantendo o projeto simples, compreensível e adequado ao escopo acadêmico. Cada parte do sistema possui uma responsabilidade específica, facilitando a manutenção, os testes e a evolução das funcionalidades.

## Arquitetura escolhida

O projeto utiliza as seguintes camadas:

- **Frontend:** concentra as páginas, componentes visuais, formulários e arquivos públicos acessados pelo navegador.
- **Rotas e configuração:** centralizam os caminhos do projeto e registram os controllers disponíveis.
- **Controllers:** recebem as requisições do frontend, acionam os repositories e retornam respostas para o navegador.
- **Repositories:** executam as operações básicas de leitura, criação, atualização e exclusão dos dados.
- **Entities:** representam os objetos do domínio, como usuários, cursos, disciplinas e matrículas.
- **Enums:** padronizam valores fixos do sistema, como perfis, status e tipos de registros.
- **Persistência:** utiliza o arquivo `database.json` como simulador de banco de dados durante o desenvolvimento.

Essa divisão estabelece um fluxo claro:

```text
Navegador
    -> Frontend e formulário
    -> Rota
    -> Controller
    -> Repository
    -> JsonDatabase
    -> database.json
```

## Frontend

O frontend está localizado na pasta `web`. Ele contém as páginas, componentes, recursos visuais e as ações utilizados pelos formulários.

Os formulários enviam os dados para os arquivos de processamento dentro de `web/lib`. Esses arquivos não concentram regras de negócio. Sua responsabilidade é carregar a configuração das rotas e encaminhar a requisição para o controller correspondente.

Essa organização mantém a interface independente da implementação interna do backend. Portanto, uma página pode enviar dados sem precisar conhecer como eles são armazenados.

## Backend

O backend está localizado na pasta `src` e segue a separação de responsabilidades abaixo.

### Controllers

Os controllers são responsáveis por interpretar as requisições do navegador e selecionar a operação adequada. O `UsersController`, por exemplo, oferece operações para listar, consultar, cadastrar, atualizar e excluir usuários.

### Repositories

Os repositories fazem a comunicação com a camada de persistência. O `UserRepository` converte os dados recebidos do formulário em registros compatíveis com o `database.json` e converte os registros encontrados em entidades `Users`.

### Entities

As entidades representam os dados principais do portal. Elas são criadas por construtores e disponibilizam getters para leitura dos seus valores. A alteração dos dados é realizada pelo repository, que grava um novo estado no arquivo de persistência.

### Enums

Os enums definem valores permitidos para campos que possuem opções limitadas. Essa abordagem evita a utilização de textos diferentes para representar o mesmo estado e mantém os dados padronizados.

### Persistência simulada

O arquivo `src/data/database.json` representa temporariamente o banco de dados do sistema. A classe `JsonDatabase`, localizada em `src/core`, concentra as operações de leitura e escrita do arquivo.

Essa solução atende ao objetivo atual de simular o funcionamento completo do portal por meio de formulários, sem exigir a configuração de um banco de dados externo. Em uma etapa futura, a camada `JsonDatabase` poderá ser substituída por uma conexão com banco de dados real sem alterar a responsabilidade dos controllers e das páginas.

## Critérios da decisão

A arquitetura foi escolhida pelos seguintes motivos:

1. **Organização:** cada camada possui uma função definida.
2. **Simplicidade:** o projeto utiliza PHP nativo e não depende de um framework neste momento.
3. **Evolução:** novas entidades, controllers e repositories podem ser adicionados seguindo o mesmo padrão.
4. **Manutenção:** alterações na persistência não precisam modificar as páginas do frontend.
5. **Adequação ao projeto:** a estrutura atende à proposta de reconstruir as funcionalidades do portal do aluno de forma gradual.

## Conclusão

A arquitetura MVC em camadas está definida como padrão estrutural do projeto. O frontend recebe os dados do usuário, as rotas encaminham as requisições, os controllers coordenam as operações, os repositories acessam a persistência e as entidades representam os dados do domínio.

Com essa definição, o portal possui uma base organizada para implementar os módulos acadêmico, financeiro, de empréstimos, notificações, requisitos e usuários. A utilização do `database.json` atende à fase atual de desenvolvimento e mantém aberta a substituição futura por um banco de dados definitivo.