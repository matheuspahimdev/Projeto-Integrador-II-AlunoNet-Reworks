<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/loans/loans.php';
require_once dirname(__DIR__, 2) . '/enums/loans/loanStatus.php';

class LoanRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'loans';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'item_name' => (string) ($data['item_name'] ?? ''),
            'item_code' => (string) ($data['item_code'] ?? ''),
            'description' => $data['description'] ?? null,
            'loan_date' => (string) ($data['loan_date'] ?? ''),
            'expected_return_date' => (string) ($data['expected_return_date'] ?? ''),
            'returned_at' => $data['returned_at'] ?? null,
            'status' => $this->status($data['status'] ?? LoanStatus::AVAILABLE)->value,
            'fine_value' => (float) ($data['fine_value'] ?? 0),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Loans
    {
        return new Loans(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (string) ($record['item_name'] ?? ''),
            (string) ($record['item_code'] ?? ''),
            $record['description'] ?? null,
            (string) ($record['loan_date'] ?? ''),
            (string) ($record['expected_return_date'] ?? ''),
            $record['returned_at'] ?? null,
            $this->status($record['status'] ?? LoanStatus::AVAILABLE),
            (float) ($record['fine_value'] ?? 0),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(LoanStatus|string $status): LoanStatus
    {
        return $status instanceof LoanStatus ? $status : LoanStatus::from($status);
    }
}
