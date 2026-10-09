<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/academic/exams.php';
require_once dirname(__DIR__, 2) . '/enums/academic/examStatus.php';

class ExamRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'exams';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'discipline_id' => (int) ($data['discipline_id'] ?? 0),
            'class_id' => (int) ($data['class_id'] ?? 0),
            'name' => (string) ($data['name'] ?? ''),
            'description' => $data['description'] ?? null,
            'score' => $this->nullableFloat($data['score'] ?? null),
            'max_score' => (float) ($data['max_score'] ?? 0),
            'date' => (string) ($data['date'] ?? ''),
            'status' => $this->status($data['status'] ?? ExamStatus::DRAFT)->value,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Exams
    {
        return new Exams(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (int) ($record['discipline_id'] ?? 0),
            (int) ($record['class_id'] ?? 0),
            (string) ($record['name'] ?? ''),
            $record['description'] ?? null,
            $this->nullableFloat($record['score'] ?? null),
            (float) ($record['max_score'] ?? 0),
            (string) ($record['date'] ?? ''),
            $this->status($record['status'] ?? ExamStatus::DRAFT),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function status(ExamStatus|string $status): ExamStatus
    {
        return $status instanceof ExamStatus ? $status : ExamStatus::from($status);
    }
}
