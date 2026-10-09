<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/finance/scholarships.php';
require_once dirname(__DIR__, 2) . '/enums/academic/academicStatus.php';

class ScholarshipRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'scholarships';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'name' => (string) ($data['name'] ?? ''),
            'percentage' => (float) ($data['percentage'] ?? 0),
            'start_date' => (string) ($data['start_date'] ?? ''),
            'end_date' => $data['end_date'] ?? null,
            'status' => $this->status($data['status'] ?? AcademicStatus::PENDING)->value,
            'document_url' => $data['document_url'] ?? null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Scholarships
    {
        return new Scholarships(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (string) ($record['name'] ?? ''),
            (float) ($record['percentage'] ?? 0),
            (string) ($record['start_date'] ?? ''),
            $record['end_date'] ?? null,
            $this->status($record['status'] ?? AcademicStatus::PENDING),
            $record['document_url'] ?? null,
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(AcademicStatus|string $status): AcademicStatus
    {
        return $status instanceof AcademicStatus ? $status : AcademicStatus::from($status);
    }
}
