<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/enums/users/role.php';
require_once dirname(__DIR__, 2) . '/entities/users/users.php';

class UserRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'users';
    }

    public function findByRegistration(string $registrationNumber): ?Users
    {
        foreach ($this->all() as $user) {
            if ($user->getRegistrationNumber() === $registrationNumber) {
                return $user;
            }
        }

        return null;
    }

    public function authenticate(string $registrationNumber, string $password): ?Users
    {
        $user = $this->findByRegistration($registrationNumber);

        if ($user === null || !$user->isActive() || !password_verify($password, $user->getPassword())) {
            return null;
        }

        return $user;
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
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
            'is_active' => $this->boolean($data['is_active'] ?? true, true),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Users
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
        $password = (string) ($data['password'] ?? '');

        if ($password === '') {
            return '';
        }

        return password_get_info($password)['algoName'] !== 'unknown'
            ? $password
            : password_hash($password, PASSWORD_DEFAULT);
    }
}