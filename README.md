# Projeto-Integrador-II-AlunoNet-Reworks
Projeto educacional focado em refazer o site do aluno da universidade UNIFIO

## Problema

O site AlunoNet apresenta uma interface desatualizada, com aparência visual antiga e elementos que não seguem os padrões atuais de design e usabilidade. A organização das informações também não é muito intuitiva, dificultando o acesso dos usuários a determinadas funcionalidades.

Além disso, existem botões e componentes pequenos, páginas com pouco ou nenhum conteúdo e grandes espaços vazios, resultando em um aproveitamento pouco eficiente da tela.

Outro problema identificado é a falta de responsividade, principalmente em dispositivos móveis, onde algumas páginas podem apresentar problemas de layout e exigir zoom ou movimentação horizontal da tela.

Também foram identificadas dificuldades na integração com portais institucionais, como o Moodle e o Workalove, o que pode prejudicar a continuidade da navegação e a experiência do usuário.

## Solução geral

O projeto propõe uma reformulação da interface do AlunoNet, tornando a plataforma mais moderna, limpa, intuitiva e fácil de utilizar. A proposta busca melhorar a experiência de alunos e professores, facilitando o acesso às informações e funcionalidades e tornando a navegação mais prática, organizada e eficiente.

## Soluções específicas

- Reorganização da interface: menus, informações e funcionalidades serão reorganizados para facilitar o acesso aos principais recursos.

- Design responsivo: a plataforma será adaptada para diferentes dispositivos, como computadores, tablets e celulares.

- Melhoria dos componentes: botões e outros elementos da interface serão redimensionados e melhor organizados, facilitando a interação do usuário.

- Melhor aproveitamento do espaço: os espaços das páginas serão utilizados de maneira mais eficiente, reduzindo áreas vazias e melhorando a distribuição das informações.

- Integração com sistemas institucionais: a integração com plataformas como Moodle e Workalove será aprimorada.

- Abertura de portais externos: Moodle e Workalove serão abertos em novas abas, mantendo cada sistema independente e evitando possíveis problemas na estrutura do AlunoNet.

Dessa forma, a proposta busca proporcionar uma plataforma mais acessível, organizada e eficiente para alunos e professores.

## Tecnologias utilizadas
- Github
- Visual Studio Code
- Figma
- Miro
- PHP 8.1+ (sem frameworks)
- Bootstrap 5.3 e Bootstrap Icons (via CDN)
- JavaScript puro

## Como executar

Na raiz do projeto, inicie o servidor embutido do PHP:

```bash
php -S localhost:3000
```

Depois acesse `http://localhost:3000`. O `index.php` da raiz redireciona para
`web/index.php`, que por sua vez leva à tela de login enquanto não houver uma
sessão ativa.

## Modo atual de navegação

Nesta etapa do projeto, o portal funciona como um protótipo navegável com
**login simulado**. Todas as páginas exigem um aluno logado; sem sessão, o
usuário é redirecionado para `web/pages/auth/login.php`.

Alunos de demonstração disponíveis:

| Aluno               | Matrícula | Senha       | Curso                                 |
| ------------------- | --------- | ----------- | ------------------------------------- |
| Victor H. Oliveira  | `274769`  | `victor123` | Engenharia de Software                |
| Ana Beatriz Souza   | `281450`  | `ana123`    | Análise e Desenvolvimento de Sistemas |
| Lucas Ferreira Lima | `268112`  | `lucas123`  | Administração                         |

Cada aluno possui seus próprios dados: disciplinas, notas, faltas, horários,
provas, parcelas financeiras, requerimentos, chamados, empréstimos, materiais e
avisos. A sessão PHP guarda apenas a matrícula; o restante é lido dos dados
simulados em `web/lib`.

Observações importantes:

- As senhas ficam em texto puro no código. O login serve apenas para
  demonstração e **não oferece segurança real**.
- Não há banco de dados. Ações feitas nas páginas (abrir chamados, reservar
  livros, marcar avisos como lidos, foto de perfil etc.) ficam salvas no
  `localStorage` do navegador, separadas por aluno.
- A data de "hoje" do protótipo é fixa em **14/10/2026** (`SIMULATED_TODAY`),
  para que provas, boletos, avisos e empréstimos sempre apareçam de forma
  coerente.
- O botão "Sair" do menu pede confirmação e encerra a sessão.

Mais detalhes sobre a organização do código estão em
[`docs/ARQUITETURA.md`](docs/ARQUITETURA.md).