<?php

declare(strict_types=1);

class Requirements
{
    private int $id;
    private int $userId;
    private string $type;
    private string $subject;
    private string $description;
    private RequirementStatus $status;
    private string $protocolNumber;
    private string $requestedAt;
    private ?string $answeredAt;
    private ?string $answer;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, string $type, string $subject, string $description, RequirementStatus $status, string $protocolNumber, string $requestedAt, ?string $answeredAt, ?string $answer, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->type = $type;
        $this->subject = $subject;
        $this->description = $description;
        $this->status = $status;
        $this->protocolNumber = $protocolNumber;
        $this->requestedAt = $requestedAt;
        $this->answeredAt = $answeredAt;
        $this->answer = $answer;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): RequirementStatus
    {
        return $this->status;
    }

    public function getProtocolNumber(): string
    {
        return $this->protocolNumber;
    }

    public function getRequestedAt(): string
    {
        return $this->requestedAt;
    }
    
    public function getAnsweredAt(): ?string
    {
        return $this->answeredAt;
    }
    
    public function getAnswer(): ?string
    {
        return $this->answer;
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