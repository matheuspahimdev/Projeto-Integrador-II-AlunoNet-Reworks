<?php

declare(strict_types=1);

class Classes
{
    private int $id;
    private int $courseId;
    private string $name;
    private int $academicYear;
    private int $semester;
    private string $shift;
    private ?string $room;
    private int $capacity;
    private AcademicStatus $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $courseId, string $name, int $academicYear, int $semester, string $shift, ?string $room, int $capacity, AcademicStatus $status, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->courseId = $courseId;
        $this->name = $name;
        $this->academicYear = $academicYear;
        $this->semester = $semester;
        $this->shift = $shift;
        $this->room = $room;
        $this->capacity = $capacity;
        $this->status = $status;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getAcademicYear(): int
    {
        return $this->academicYear;
    }

    public function getSemester(): int
    {
        return $this->semester;
    }

    public function getShift(): string
    {
        return $this->shift;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
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