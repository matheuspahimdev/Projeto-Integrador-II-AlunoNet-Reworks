<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/courses.php';

class CourseRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'courses';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'code' => (string) ($data['code'] ?? ''),
            'name' => (string) ($data['name'] ?? ''),
            'description' => $data['description'] ?? null,
            'degree_level' => (string) ($data['degree_level'] ?? ''),
            'duration_semesters' => (int) ($data['duration_semesters'] ?? 0),
            'workload_hours' => (int) ($data['workload_hours'] ?? 0),
            'is_active' => $this->boolean($data['is_active'] ?? true, true),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Courses
    {
        return new Courses(
            (int) ($record['id'] ?? 0),
            (string) ($record['code'] ?? ''),
            (string) ($record['name'] ?? ''),
            $record['description'] ?? null,
            (string) ($record['degree_level'] ?? ''),
            (int) ($record['duration_semesters'] ?? 0),
            (int) ($record['workload_hours'] ?? 0),
            $this->boolean($record['is_active'] ?? true, true),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }
}
