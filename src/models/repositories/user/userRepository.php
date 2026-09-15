<?php

declare(strict_types=1);

require_once dirname(__DIR__, 3) . '/core/JsonDatabase.php';
require_once dirname(__DIR__, 3) . '/models/enums/users/role.php';
require_once dirname(__DIR__, 3) . '/models/entities/users/users.php';

class UserRepository
{
    private JsonDatabase $database;

    public function __construct(?JsonDatabase $database = null)
    {
        $this->database = $database ?? new JsonDatabase();
    }

    public function all(): array
    {
        return array_map(
            fn (array $record): Users => $this->toEntity($record),
            $this->database->all('users')
        );
    }

    public function find(int|string $id): ?Users
    {
        $record = $this->database->find('users', $id);

        return $record === null ? null : $this->toEntity($record);
    }

    public function create(array $formData): Users
    {
        $now = date('c');
        $record = $this->toRecord($formData, $now, $now);
        $record = $this->database->insert('users', $record);

        return $this->toEntity($record);
    }

    public function update(int|string $id, array $formData): ?Users
    {
        $current = $this->database->find('users', $id);

        if ($current === null) {
            return null;
        }

        $record = $this->toRecord(array_merge($current, $formData), $current['created_at'], date('c'));
        $record = $this->database->update('users', $id, $record);

        return $record === null ? null : $this->toEntity($record);
    }

    public function delete(int|string $id): bool
    {
        return $this->database->delete('users', $id);
    }

    private function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'course_id' => $this->nullableInt($data['course_id'] ?? null),
            'class_id' => $this->nullableInt($data['class_id'] ?? null),
            'registration_number' => $data['registration_number'] ?? null,
            'name' => (string) ($data['name'] ?? ''),
            'social_name' => $data['social_name'] ?? null,
            'document' => $data['document'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'email' => (string) ($data['email'] ?? ''),
            'password' => $this->password($data),
            'role' => $this->role($data['role'] ?? Role::STUDENT)->value,
            'is_active' => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    private function toEntity(array $record): Users
    {
        return new Users(
            $record['id'] ?? null,
            $this->nullableInt($record['course_id'] ?? null),
            (string) ($record['name'] ?? ''),
            (string) ($record['email'] ?? ''),
            (string) ($record['password'] ?? ''),
            $this->role($record['role'] ?? Role::STUDENT),
            (bool) ($record['is_active'] ?? true),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? ''),
            $this->nullableInt($record['class_id'] ?? null),
            $record['registration_number'] ?? null,
            $record['social_name'] ?? null,
            $record['document'] ?? null,
            $record['birth_date'] ?? null,
            $record['phone'] ?? null,
            $record['address'] ?? null
        );
    }

    private function role(Role|string $role): Role
    {
        return $role instanceof Role ? $role : Role::from($role);
    }

    private function password(array $data): string
    {
        return (string) ($data['password'] ?? '');
    }

    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}