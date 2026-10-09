<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/enrollments.php';
require_once dirname(__DIR__, 2) . '/enums/academic/academicStatus.php';

class EnrollmentRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'enrollments';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'course_id' => (int) ($data['course_id'] ?? 0),
            'class_id' => (int) ($data['class_id'] ?? 0),
            'entry_date' => (string) ($data['entry_date'] ?? ''),
            'completion_date' => $data['completion_date'] ?? null,
            'status' => $this->status($data['status'] ?? AcademicStatus::PENDING)->value,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Enrollments
    {
        return new Enrollments(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (int) ($record['course_id'] ?? 0),
            (int) ($record['class_id'] ?? 0),
            (string) ($record['entry_date'] ?? ''),
            $record['completion_date'] ?? null,
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
