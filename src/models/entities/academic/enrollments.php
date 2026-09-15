<?php

declare(strict_types=1);

class Enrollments
{
    private int $id;
    private int $userId;
    private int $courseId;
    private int $classId;
    private string $entryDate;
    private ?string $completionDate;
    private AcademicStatus $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, int $courseId, int $classId, string $entryDate, ?string $completionDate, AcademicStatus $status, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->courseId = $courseId;
        $this->classId = $classId;
        $this->entryDate = $entryDate;
        $this->completionDate = $completionDate;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function getEntryDate(): string
    {
        return $this->entryDate;
    }

    public function getCompletionDate(): ?string
    {
        return $this->completionDate;
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