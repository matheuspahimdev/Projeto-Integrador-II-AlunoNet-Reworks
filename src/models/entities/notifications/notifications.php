<?php

declare(strict_types=1);

class Notifications
{
    private int $id;
    private int $userId;
    private string $title;
    private string $message;
    private NotificationType $type;
    private ?string $readAt;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, string $title, string $message, NotificationType $type, ?string $readAt, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->readAt = $readAt;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): NotificationType
    {
        return $this->type;
    }

    public function getReadAt(): ?string
    {
        return $this->readAt;
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