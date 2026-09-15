<?php

declare(strict_types=1);

class Courses
{
    private int $id;
    private string $code;
    private string $name;
    private ?string $description;
    private string $degreeLevel;
    private int $durationSemesters;
    private int $workloadHours;
    private bool $isActive;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, string $code, string $name, ?string $description, string $degreeLevel, int $durationSemesters, int $workloadHours, bool $isActive, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->degreeLevel = $degreeLevel;
        $this->durationSemesters = $durationSemesters;
        $this->workloadHours = $workloadHours;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getDegreeLevel(): string
    {
        return $this->degreeLevel;
    }

    public function getDurationSemesters(): int
    {
        return $this->durationSemesters;
    }

    public function getWorkloadHours(): int
    {
        return $this->workloadHours;
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