<?php

declare(strict_types=1);

class Scholarships
{
    private int $id;
    private int $userId;
    private string $name;
    private float $percentage;
    private string $startDate;
    private ?string $endDate;
    private AcademicStatus $status;
    private ?string $documentUrl;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, string $name, float $percentage, string $startDate, ?string $endDate, AcademicStatus $status, ?string $documentUrl, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->percentage = $percentage;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->documentUrl = $documentUrl;
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
    public function getName(): string
    {
        return $this->name;
    }
    public function getPercentage(): float
    {
        return $this->percentage;
    }
    public function getStartDate(): string
    {
        return $this->startDate;
    }
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
    public function getStatus(): AcademicStatus
    {
        return $this->status;
    }
    public function getDocumentUrl(): ?string
    {
        return $this->documentUrl;
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