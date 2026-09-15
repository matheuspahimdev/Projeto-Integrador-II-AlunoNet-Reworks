<?php

declare(strict_types=1);

class DisciplineClasses
{
    private int $id;
    private int $disciplineId;
    private int $classId;
    private int $teacherId;
    private string $schedule;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $disciplineId, int $classId, int $teacherId, string $schedule, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->disciplineId = $disciplineId;
        $this->classId = $classId;
        $this->teacherId = $teacherId;
        $this->schedule = $schedule;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getSchedule(): string
    {
        return $this->schedule;
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