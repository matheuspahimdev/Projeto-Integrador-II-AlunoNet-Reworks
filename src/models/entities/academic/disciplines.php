<?php

declare(strict_types=1);

class Disciplines
{
    private int $id;
    private int $courseId;
    private string $code;
    private string $name;
    private ?string $description;
    private int $semester;
    private int $workloadHours;
    private ?int $prerequisiteId;
    private bool $isActive;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $courseId, string $code, string $name, ?string $description, int $semester, int $workloadHours, ?int $prerequisiteId, bool $isActive, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->courseId = $courseId;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->semester = $semester;
        $this->workloadHours = $workloadHours;
        $this->prerequisiteId = $prerequisiteId;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSemester(): int
    {
        return $this->semester;
    }

    public function getWorkloadHours(): int
    {
        return $this->workloadHours;
    }

    public function getPrerequisiteId(): ?int
    {
        return $this->prerequisiteId;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
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