<?php

declare(strict_types=1);

class Frequencies
{
    private int $id;
    private int $userId;
    private int $disciplineId;
    private int $classId;
    private string $date;
    private FrequencyStatus $status;
    private ?string $justification;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, int $disciplineId, int $classId, string $date, FrequencyStatus $status, ?string $justification, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->disciplineId = $disciplineId;
        $this->classId = $classId;
        $this->date = $date;
        $this->status = $status;
        $this->justification = $justification;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getStatus(): FrequencyStatus
    {
        return $this->status;
    }
}