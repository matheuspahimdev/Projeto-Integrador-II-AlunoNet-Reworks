<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/notifications/notifications.php';
require_once dirname(__DIR__, 2) . '/enums/notifications/notificationType.php';

class NotificationRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'notifications';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'title' => (string) ($data['title'] ?? ''),
            'message' => (string) ($data['message'] ?? ''),
            'type' => $this->type($data['type'] ?? NotificationType::SYSTEM)->value,
            'read_at' => $data['read_at'] ?? null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Notifications
    {
        return new Notifications(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            (string) ($record['title'] ?? ''),
            (string) ($record['message'] ?? ''),
            $this->type($record['type'] ?? NotificationType::SYSTEM),
            $record['read_at'] ?? null,
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? '')
        );
    }

    private function type(NotificationType|string $type): NotificationType
    {
        return $type instanceof NotificationType ? $type : NotificationType::from($type);
    }
}
