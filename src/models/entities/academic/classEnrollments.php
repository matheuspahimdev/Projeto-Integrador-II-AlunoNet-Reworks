<?php

declare(strict_types=1);

class ClassEnrollments
{
    private int $id;
    private int $classId;
    private int $userId;
    private string $enrolledAt;
    private AcademicStatus $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $classId, int $userId, string $enrolledAt, AcademicStatus $status, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->classId = $classId;
        $this->userId = $userId;
        $this->enrolledAt = $enrolledAt;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEnrolledAt(): string
    {
        return $this->enrolledAt;
    }

    public function getStatus(): AcademicStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}