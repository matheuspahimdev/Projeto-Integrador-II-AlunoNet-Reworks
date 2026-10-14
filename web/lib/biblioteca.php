<?php
require_once __DIR__ . '/tempo.php';

const BOOK_CATEGORIES = [
    'computacao' => ['label' => 'Computação', 'icon' => 'bi-laptop'],
    'direito' => ['label' => 'Direito', 'icon' => 'bi-bank'],
    'matematica' => ['label' => 'Matemática', 'icon' => 'bi-calculator'],
    'literatura' => ['label' => 'Literatura', 'icon' => 'bi-book'],
    'metodologia' => ['label' => 'Metodologia', 'icon' => 'bi-journal-text'],
];

const PICKUP_TIMES = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];

function libraryBook(int $id, string $title, string $author, string $edition, int $year, string $publisher, string $category, int $copies, int $available, string $shelf, ?string $expectedReturn = null): array
{
    return [
        'id' => $id, 'titulo' => $title, 'autor' => $author, 'edicao' => $edition, 'ano' => $year, 'editora' => $publisher,
        'categoria' => $category, 'total' => $copies, 'disponiveis' => $available, 'estante' => $shelf,
        'previsao' => $expectedReturn, 'tombo' => sprintf('BIB-%06d', 1000 + $id * 7),
    ];
}

function libraryCollection(): array
{
    return [
        libraryBook(1, 'Engenharia de Software', 'Ian Sommerville', '10ª edição', 2018, 'Pearson', 'computacao', 5, 4, 'C-04'),
        libraryBook(2, 'Clean Code', 'Robert C. Martin', '', 2009, 'Alta Books', 'computacao', 3, 2, 'C-05'),
        libraryBook(3, 'Introdução a Sistemas de Banco de Dados', 'C. J. Date', '8ª edição', 2004, 'Elsevier', 'computacao', 2, 0, 'C-06', dateFromToday(2)),
        libraryBook(4, 'Sistemas de Banco de Dados', 'Ramez Elmasri e Shamkant Navathe', '7ª edição', 2018, 'Pearson', 'computacao', 4, 3, 'C-06'),
        libraryBook(5, 'Algoritmos: Teoria e Prática', 'Thomas H. Cormen et al.', '3ª edição', 2012, 'Elsevier', 'computacao', 3, 1, 'C-02'),
        libraryBook(6, 'Padrões de Projeto', 'Erich Gamma et al.', '', 2000, 'Bookman', 'computacao', 1, 0, 'C-05', dateFromToday(6)),
        libraryBook(7, 'UML Essencial', 'Martin Fowler', '3ª edição', 2005, 'Bookman', 'computacao', 2, 2, 'C-04'),
        libraryBook(8, 'JavaScript: O Guia Definitivo', 'David Flanagan', '6ª edição', 2013, 'Bookman', 'computacao', 2, 1, 'C-07'),
        libraryBook(9, 'Redes de Computadores e a Internet', 'James F. Kurose e Keith W. Ross', '6ª edição', 2013, 'Pearson', 'computacao', 3, 2, 'C-03'),
        libraryBook(10, 'Manual de Direito Civil', 'Flávio Tartuce', '', 2022, 'Forense', 'direito', 3, 2, 'D-01'),
        libraryBook(11, 'Curso de Direito Constitucional', 'Gilmar Mendes e Paulo Gonet Branco', '17ª edição', 2022, 'Saraiva', 'direito', 4, 3, 'D-02'),
        libraryBook(12, 'Cálculo, Volume 1', 'James Stewart', '7ª edição', 2013, 'Cengage', 'matematica', 6, 2, 'M-03'),
        libraryBook(13, 'Dom Casmurro', 'Machado de Assis', '', 2016, 'Editora Ática', 'literatura', 3, 3, 'L-08'),
        libraryBook(14, 'O Cortiço', 'Aluísio Azevedo', '', 2016, 'Editora Ática', 'literatura', 2, 0, 'L-02', dateFromToday(9)),
        libraryBook(15, 'Metodologia do Trabalho Científico', 'Antônio Joaquim Severino', '24ª edição', 2016, 'Cortez', 'metodologia', 4, 4, 'G-01'),
    ];
}

function libraryCollectionByTitle(): array
{
    $books = libraryCollection();
    usort($books, static fn (array $a, array $b): int => strcoll($a['titulo'], $b['titulo']));
    return $books;
}

function studentLoans(): array
{
    return [
        [
            'id' => 'EMP-2026-0412', 'bookId' => 2, 'titulo' => 'Clean Code', 'autor' => 'Robert C. Martin', 'categoria' => 'computacao',
            'retirada' => dateFromToday(-3), 'horario' => '14:00', 'devolucao' => dateFromToday(4), 'solicitadoEm' => dateFromToday(-5),
            'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => null,
        ],
        [
            'id' => 'EMP-2026-0398', 'bookId' => 3, 'titulo' => 'Introdução a Sistemas de Banco de Dados', 'autor' => 'C. J. Date', 'categoria' => 'computacao',
            'retirada' => dateFromToday(-12), 'horario' => '10:00', 'devolucao' => dateFromToday(-5), 'solicitadoEm' => dateFromToday(-14),
            'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => null,
        ],
        [
            'id' => 'EMP-2026-0431', 'bookId' => 5, 'titulo' => 'Algoritmos: Teoria e Prática', 'autor' => 'Thomas H. Cormen et al.', 'categoria' => 'computacao',
            'retirada' => dateFromToday(2), 'horario' => '15:00', 'devolucao' => dateFromToday(9), 'solicitadoEm' => dateFromToday(0),
            'status' => 'analise', 'renovacoes' => 0, 'devolvidoEm' => null,
        ],
        [
            'id' => 'EMP-2026-0301', 'bookId' => 13, 'titulo' => 'Dom Casmurro', 'autor' => 'Machado de Assis', 'categoria' => 'literatura',
            'retirada' => dateFromToday(-30), 'horario' => '09:00', 'devolucao' => dateFromToday(-23), 'solicitadoEm' => dateFromToday(-32),
            'status' => 'retirado', 'renovacoes' => 0, 'devolvidoEm' => dateFromToday(-24),
        ],
        [
            'id' => 'EMP-2026-0245', 'bookId' => 15, 'titulo' => 'Metodologia do Trabalho Científico', 'autor' => 'Antônio Joaquim Severino', 'categoria' => 'metodologia',
            'retirada' => dateFromToday(-60), 'horario' => '16:00', 'devolucao' => dateFromToday(-53), 'solicitadoEm' => dateFromToday(-62),
            'status' => 'retirado', 'renovacoes' => 1, 'devolvidoEm' => dateFromToday(-55),
        ],
    ];
}