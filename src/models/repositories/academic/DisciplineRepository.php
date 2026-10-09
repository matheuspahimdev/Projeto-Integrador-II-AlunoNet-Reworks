<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/disciplines.php';

class DisciplineRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'disciplines';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'course_id' => (int) ($data['course_id'] ?? 0),
            'code' => (string) ($data['code'] ?? ''),
            'name' => (string) ($data['name'] ?? ''),
            'description' => $data['description'] ?? null,
            'semester' => (int) ($data['semester'] ?? 0),
            'workload_hours' => (int) ($data['workload_hours'] ?? 0),
            'prerequisite_id' => $this->nullableInt($data['prerequisite_id'] ?? null),
            'is_active' => $this->boolean($data['is_active'] ?? true, true),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Disciplines
    {
        return new Disciplines(
            (int) ($record['id'] ?? 0),
            (int) ($record['course_id'] ?? 0),
            (string) ($record['code'] ?? ''),
            (string) ($record['name'] ?? ''),
            $record['description'] ?? null,
            (int) ($record['semester'] ?? 0),
            (int) ($record['workload_hours'] ?? 0),
            $this->nullableInt($record['prerequisite_id'] ?? null),
            $this->boolean($record['is_active'] ?? true, true),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }
}
