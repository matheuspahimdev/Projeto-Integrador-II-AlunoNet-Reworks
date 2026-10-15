<?php
require_once __DIR__ . '/autenticacao.php';

const BOOK_CATEGORIES = [
    'computacao' => ['label' => 'Computação', 'icon' => 'bi-laptop'],
    'direito' => ['label' => 'Direito', 'icon' => 'bi-bank'],
    'matematica' => ['label' => 'Matemática', 'icon' => 'bi-calculator'],
    'literatura' => ['label' => 'Literatura', 'icon' => 'bi-book'],
    'metodologia' => ['label' => 'Metodologia', 'icon' => 'bi-journal-text'],
];

const PICKUP_TIMES = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];

const LOAN_DAYS = 7;

const MAX_PICKUP_DAYS_AHEAD = 14;

const LOAN_STATUS_PENDING = 'analise';

const LOAN_STATUS_PICKED_UP = 'retirado';

const LIBRARY_BOOKS = [
    ['id' => 1, 'title' => 'Engenharia de Software', 'author' => 'Ian Sommerville', 'edition' => '10ª edição', 'year' => 2018, 'publisher' => 'Pearson', 'category' => 'computacao', 'copies' => 5, 'available' => 4, 'shelf' => 'C-04', 'expected_return' => null],
    ['id' => 2, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'edition' => '', 'year' => 2009, 'publisher' => 'Alta Books', 'category' => 'computacao', 'copies' => 3, 'available' => 2, 'shelf' => 'C-05', 'expected_return' => null],
    ['id' => 3, 'title' => 'Introdução a Sistemas de Banco de Dados', 'author' => 'C. J. Date', 'edition' => '8ª edição', 'year' => 2004, 'publisher' => 'Elsevier', 'category' => 'computacao', 'copies' => 2, 'available' => 0, 'shelf' => 'C-06', 'expected_return' => '2026-10-16'],
    ['id' => 4, 'title' => 'Sistemas de Banco de Dados', 'author' => 'Ramez Elmasri e Shamkant Navathe', 'edition' => '7ª edição', 'year' => 2018, 'publisher' => 'Pearson', 'category' => 'computacao', 'copies' => 4, 'available' => 3, 'shelf' => 'C-06', 'expected_return' => null],
    ['id' => 5, 'title' => 'Algoritmos: Teoria e Prática', 'author' => 'Thomas H. Cormen et al.', 'edition' => '3ª edição', 'year' => 2012, 'publisher' => 'Elsevier', 'category' => 'computacao', 'copies' => 3, 'available' => 1, 'shelf' => 'C-02', 'expected_return' => null],
    ['id' => 6, 'title' => 'Padrões de Projeto', 'author' => 'Erich Gamma et al.', 'edition' => '', 'year' => 2000, 'publisher' => 'Bookman', 'category' => 'computacao', 'copies' => 1, 'available' => 0, 'shelf' => 'C-05', 'expected_return' => '2026-10-20'],
    ['id' => 7, 'title' => 'UML Essencial', 'author' => 'Martin Fowler', 'edition' => '3ª edição', 'year' => 2005, 'publisher' => 'Bookman', 'category' => 'computacao', 'copies' => 2, 'available' => 2, 'shelf' => 'C-04', 'expected_return' => null],
    ['id' => 8, 'title' => 'JavaScript: O Guia Definitivo', 'author' => 'David Flanagan', 'edition' => '6ª edição', 'year' => 2013, 'publisher' => 'Bookman', 'category' => 'computacao', 'copies' => 2, 'available' => 1, 'shelf' => 'C-07', 'expected_return' => null],
    ['id' => 9, 'title' => 'Redes de Computadores e a Internet', 'author' => 'James F. Kurose e Keith W. Ross', 'edition' => '6ª edição', 'year' => 2013, 'publisher' => 'Pearson', 'category' => 'computacao', 'copies' => 3, 'available' => 2, 'shelf' => 'C-03', 'expected_return' => null],
    ['id' => 10, 'title' => 'Manual de Direito Civil', 'author' => 'Flávio Tartuce', 'edition' => '', 'year' => 2022, 'publisher' => 'Forense', 'category' => 'direito', 'copies' => 3, 'available' => 2, 'shelf' => 'D-01', 'expected_return' => null],
    ['id' => 11, 'title' => 'Curso de Direito Constitucional', 'author' => 'Gilmar Mendes e Paulo Gonet Branco', 'edition' => '17ª edição', 'year' => 2022, 'publisher' => 'Saraiva', 'category' => 'direito', 'copies' => 4, 'available' => 3, 'shelf' => 'D-02', 'expected_return' => null],
    ['id' => 12, 'title' => 'Cálculo, Volume 1', 'author' => 'James Stewart', 'edition' => '7ª edição', 'year' => 2013, 'publisher' => 'Cengage', 'category' => 'matematica', 'copies' => 6, 'available' => 2, 'shelf' => 'M-03', 'expected_return' => null],
    ['id' => 13, 'title' => 'Dom Casmurro', 'author' => 'Machado de Assis', 'edition' => '', 'year' => 2016, 'publisher' => 'Editora Ática', 'category' => 'literatura', 'copies' => 3, 'available' => 3, 'shelf' => 'L-08', 'expected_return' => null],
    ['id' => 14, 'title' => 'O Cortiço', 'author' => 'Aluísio Azevedo', 'edition' => '', 'year' => 2016, 'publisher' => 'Editora Ática', 'category' => 'literatura', 'copies' => 2, 'available' => 0, 'shelf' => 'L-02', 'expected_return' => '2026-10-23'],
    ['id' => 15, 'title' => 'Metodologia do Trabalho Científico', 'author' => 'Antônio Joaquim Severino', 'edition' => '24ª edição', 'year' => 2016, 'publisher' => 'Cortez', 'category' => 'metodologia', 'copies' => 4, 'available' => 4, 'shelf' => 'G-01', 'expected_return' => null],
    ['id' => 16, 'title' => 'Clean Architecture', 'author' => 'Robert C. Martin', 'edition' => '', 'year' => 2017, 'publisher' => 'Alta Books', 'category' => 'computacao', 'copies' => 2, 'available' => 1, 'shelf' => 'C-05', 'expected_return' => null],
];

const STUDENT_LOANS = [
    '274769' => [
        ['id' => 'EMP-2026-0412', 'book_id' => 2, 'pickup_date' => '2026-10-11', 'pickup_time' => '14:00', 'due_date' => '2026-10-18', 'requested_at' => '2026-10-09', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => null],
        ['id' => 'EMP-2026-0398', 'book_id' => 3, 'pickup_date' => '2026-10-02', 'pickup_time' => '10:00', 'due_date' => '2026-10-09', 'requested_at' => '2026-09-30', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => null],
        ['id' => 'EMP-2026-0431', 'book_id' => 5, 'pickup_date' => '2026-10-16', 'pickup_time' => '15:00', 'due_date' => '2026-10-23', 'requested_at' => '2026-10-14', 'status' => LOAN_STATUS_PENDING, 'renewals' => 0, 'returned_at' => null],
        ['id' => 'EMP-2026-0301', 'book_id' => 13, 'pickup_date' => '2026-09-14', 'pickup_time' => '09:00', 'due_date' => '2026-09-21', 'requested_at' => '2026-09-12', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => '2026-09-20'],
        ['id' => 'EMP-2026-0245', 'book_id' => 15, 'pickup_date' => '2026-08-15', 'pickup_time' => '16:00', 'due_date' => '2026-08-22', 'requested_at' => '2026-08-13', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 1, 'returned_at' => '2026-08-20'],
    ],
    '281450' => [
        ['id' => 'EMP-2026-0420', 'book_id' => 4, 'pickup_date' => '2026-10-12', 'pickup_time' => '09:00', 'due_date' => '2026-10-19', 'requested_at' => '2026-10-10', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => null],
        ['id' => 'EMP-2026-0415', 'book_id' => 9, 'pickup_date' => '2026-10-08', 'pickup_time' => '10:00', 'due_date' => '2026-10-15', 'requested_at' => '2026-10-06', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 1, 'returned_at' => null],
        ['id' => 'EMP-2026-0287', 'book_id' => 8, 'pickup_date' => '2026-09-04', 'pickup_time' => '08:00', 'due_date' => '2026-09-11', 'requested_at' => '2026-09-02', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => '2026-09-10'],
    ],
    '268112' => [
        ['id' => 'EMP-2026-0402', 'book_id' => 15, 'pickup_date' => '2026-10-04', 'pickup_time' => '19:00', 'due_date' => '2026-10-11', 'requested_at' => '2026-10-03', 'status' => LOAN_STATUS_PICKED_UP, 'renewals' => 0, 'returned_at' => null],
        ['id' => 'EMP-2026-0433', 'book_id' => 11, 'pickup_date' => '2026-10-15', 'pickup_time' => '18:00', 'due_date' => '2026-10-22', 'requested_at' => '2026-10-14', 'status' => LOAN_STATUS_PENDING, 'renewals' => 0, 'returned_at' => null],
    ],
];

function bookRegistryCode(array $book): string
{
    return sprintf('BIB-%06d', 1000 + $book['id'] * 7);
}

function libraryBook(int $bookId): array
{
    return array_values(array_filter(LIBRARY_BOOKS, static fn (array $book): bool => $book['id'] === $bookId))[0];
}

function libraryCollectionByTitle(): array
{
    $books = LIBRARY_BOOKS;
    usort($books, static fn (array $a, array $b): int => strcoll($a['title'], $b['title']));
    return $books;
}

// Empréstimos do aluno logado com título, autor e área do livro.
function studentLoans(): array
{
    return array_map(static function (array $loan): array {
        $book = libraryBook($loan['book_id']);
        return $loan + ['title' => $book['title'], 'author' => $book['author'], 'category' => $book['category']];
    }, STUDENT_LOANS[currentStudent()['registration']] ?? []);
}

function activeLoanStatus(int $bookId): ?string
{
    foreach (studentLoans() as $loan) {
        if ($loan['book_id'] === $bookId && $loan['returned_at'] === null) {
            return $loan['status'];
        }
    }

    return null;
}
