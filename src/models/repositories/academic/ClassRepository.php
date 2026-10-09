<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/classes.php';
require_once dirname(__DIR__, 2) . '/enums/academic/academicStatus.php';

class ClassRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'classes';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'course_id' => (int) ($data['course_id'] ?? 0),
            'name' => (string) ($data['name'] ?? ''),
            'academic_year' => (int) ($data['academic_year'] ?? 0),
            'semester' => (int) ($data['semester'] ?? 0),
            'shift' => (string) ($data['shift'] ?? ''),
            'room' => $data['room'] ?? null,
            'capacity' => (int) ($data['capacity'] ?? 0),
            'status' => $this->status($data['status'] ?? AcademicStatus::PENDING)->value,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Classes
    {
        return new Classes(
            (int) ($record['id'] ?? 0),
            (int) ($record['course_id'] ?? 0),
            (string) ($record['name'] ?? ''),
            (int) ($record['academic_year'] ?? 0),
            (int) ($record['semester'] ?? 0),
            (string) ($record['shift'] ?? ''),
            $record['room'] ?? null,
            (int) ($record['capacity'] ?? 0),
            $this->status($record['status'] ?? AcademicStatus::PENDING),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(AcademicStatus|string $status): AcademicStatus
    {
        return $status instanceof AcademicStatus ? $status : AcademicStatus::from($status);
    }
}
