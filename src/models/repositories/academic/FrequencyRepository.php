<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/frequencies.php';
require_once dirname(__DIR__, 2) . '/enums/academic/frequencyStatus.php';

class FrequencyRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'frequencies';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'discipline_id' => (int) ($data['discipline_id'] ?? 0),
            'class_id' => (int) ($data['class_id'] ?? 0),
            'date' => (string) ($data['date'] ?? ''),
            'status' => $this->status($data['status'] ?? FrequencyStatus::PRESENT)->value,
            'justification' => $data['justification'] ?? null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Frequencies
    {
        return new Frequencies(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (int) ($record['discipline_id'] ?? 0),
            (int) ($record['class_id'] ?? 0),
            (string) ($record['date'] ?? ''),
            $this->status($record['status'] ?? FrequencyStatus::PRESENT),
            $record['justification'] ?? null,
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(FrequencyStatus|string $status): FrequencyStatus
    {
        return $status instanceof FrequencyStatus ? $status : FrequencyStatus::from($status);
    }
}
