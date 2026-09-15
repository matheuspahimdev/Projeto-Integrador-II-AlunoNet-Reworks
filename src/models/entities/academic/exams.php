<?php

declare(strict_types=1);

class Exams
{
	private int $id;
	private int $userId;
	private int $disciplineId;
	private int $classId;
	private string $name;
	private ?string $description;
	private ?float $score;
	private float $maxScore;
	private string $date;
	private ExamStatus $status;
	private string $createdAt;
	private string $updatedAt;

	public function __construct(int $id, int $userId, int $disciplineId, int $classId, string $name, ?string $description, ?float $score, float $maxScore, string $date, ExamStatus $status, string $createdAt, string $updatedAt)
	{
		$this->id = $id;
		$this->userId = $userId;
		$this->disciplineId = $disciplineId;
		$this->classId = $classId;
		$this->name = $name;
		$this->description = $description;
		$this->score = $score;
		$this->maxScore = $maxScore;
		$this->date = $date;
		$this->status = $status;
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

	public function getDisciplineId(): int
	{
		return $this->disciplineId;
	}

	public function getClassId(): int
	{
		return $this->classId;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function getScore(): ?float
	{
		return $this->score;
	}

	public function getMaxScore(): float
	{
		return $this->maxScore;
	}

	public function getDate(): string
	{
		return $this->date;
	}

	public function getStatus(): ExamStatus
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