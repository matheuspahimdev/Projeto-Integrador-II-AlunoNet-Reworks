<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/requirements/requirements.php';
require_once dirname(__DIR__, 2) . '/enums/requirements/requirementStatus.php';

class RequirementRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'requirements';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'type' => (string) ($data['type'] ?? ''),
            'subject' => (string) ($data['subject'] ?? ''),
            'description' => (string) ($data['description'] ?? ''),
            'status' => $this->status($data['status'] ?? RequirementStatus::OPEN)->value,
            'protocol_number' => (string) ($data['protocol_number'] ?? ''),
            'requested_at' => (string) ($data['requested_at'] ?? ''),
            'answered_at' => $data['answered_at'] ?? null,
            'answer' => $data['answer'] ?? null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Requirements
    {
        return new Requirements(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (string) ($record['type'] ?? ''),
            (string) ($record['subject'] ?? ''),
            (string) ($record['description'] ?? ''),
            $this->status($record['status'] ?? RequirementStatus::OPEN),
            (string) ($record['protocol_number'] ?? ''),
            (string) ($record['requested_at'] ?? ''),
            $record['answered_at'] ?? null,
            $record['answer'] ?? null,
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(RequirementStatus|string $status): RequirementStatus
    {
        return $status instanceof RequirementStatus ? $status : RequirementStatus::from($status);
    }
}
