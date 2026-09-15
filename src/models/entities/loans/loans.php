<?php

declare(strict_types=1);

class Loans
{
    private int $id;
    private int $userId;
    private string $itemName;
    private string $itemCode;
    private ?string $description;
    private string $loanDate;
    private string $expectedReturnDate;
    private ?string $returnedAt;
    private LoanStatus $status;
    private float $fineValue;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, string $itemName, string $itemCode, ?string $description, string $loanDate, string $expectedReturnDate, ?string $returnedAt, LoanStatus $status, float $fineValue, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->itemName = $itemName;
        $this->itemCode = $itemCode;
        $this->description = $description;
        $this->loanDate = $loanDate;
        $this->expectedReturnDate = $expectedReturnDate;
        $this->returnedAt = $returnedAt;
        $this->status = $status;
        $this->fineValue = $fineValue;
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

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getItemCode(): string
    {
        return $this->itemCode;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLoanDate(): string
    {
        return $this->loanDate;
    }

    public function getExpectedReturnDate(): string
    {
        return $this->expectedReturnDate;
    }

    public function getReturnedAt(): ?string
    {
        return $this->returnedAt;
    }

    public function getStatus(): LoanStatus
    {
        return $this->status;
    }

    public function getFineValue(): float
    {
        return $this->fineValue;
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