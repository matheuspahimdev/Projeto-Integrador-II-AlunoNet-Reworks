<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/classEnrollments.php';
require_once dirname(__DIR__, 2) . '/enums/academic/academicStatus.php';

class ClassEnrollmentRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'class_enrollments';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'class_id' => (int) ($data['class_id'] ?? 0),
            'user_id' => (int) ($data['user_id'] ?? 0),
            'enrolled_at' => (string) ($data['enrolled_at'] ?? ''),
            'status' => $this->status($data['status'] ?? AcademicStatus::PENDING)->value,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): ClassEnrollments
    {
        return new ClassEnrollments(
            (int) ($record['id'] ?? 0),
            (int) ($record['class_id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (string) ($record['enrolled_at'] ?? ''),
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
