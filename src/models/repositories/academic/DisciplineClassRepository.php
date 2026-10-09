<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/disciplineClasses.php';

class DisciplineClassRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'discipline_classes';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'discipline_id' => (int) ($data['discipline_id'] ?? 0),
            'class_id' => (int) ($data['class_id'] ?? 0),
            'teacher_id' => (int) ($data['teacher_id'] ?? 0),
            'schedule' => (string) ($data['schedule'] ?? ''),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): DisciplineClasses
    {
        return new DisciplineClasses(
            (int) ($record['id'] ?? 0),
            (int) ($record['discipline_id'] ?? 0),
            (int) ($record['class_id'] ?? 0),
            (int) ($record['teacher_id'] ?? 0),
            (string) ($record['schedule'] ?? ''),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }
}
