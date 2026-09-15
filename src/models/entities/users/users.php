<?php

declare(strict_types=1);

class Users
{
    private int $id;
    private ?int $courseId;
    private string $name;
    private string $email;
    private string $password;
    private Role $role;
    private bool $isActive;
    private string $createdAt;
    private string $updatedAt;
    private ?int $classId = null;
    private ?string $registrationNumber = null;
    private ?string $socialName = null;
    private ?string $document = null;
    private ?string $birthDate = null;
    private ?string $phone = null;
    private ?string $address = null;

    public function __construct(
        int $id,
        ?int $courseId,
        string $name,
        string $email,
        string $password,
        Role $role,
        bool $isActive,
        string $createdAt,
        string $updatedAt,
        ?int $classId = null,
        ?string $registrationNumber = null,
        ?string $socialName = null,
        ?string $document = null,
        ?string $birthDate = null,
        ?string $phone = null,
        ?string $address = null
    ) {
        $this->id = $id;
        $this->courseId = $courseId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->classId = $classId;
        $this->registrationNumber = $registrationNumber;
        $this->socialName = $socialName;
        $this->document = $document;
        $this->birthDate = $birthDate;
        $this->phone = $phone;
        $this->address = $address;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function getClassId(): ?int
    {
        return $this->classId;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSocialName(): ?string
    {
        return $this->socialName;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function isActive(): bool
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