<?php

declare(strict_types=1);

class Finance
{
    private int $id;
    private int $userId;
    private TypePayment $typePayment;
    private float $value;
    private string $dueDate;
    private ?string $paymentDate;
    private FinanceStatus $status;
    private int $year;
    private string $nameCourse;
    private ?string $description;
    private ?string $referenceMonth;
    private float $discountValue;
    private float $fineValue;
    private float $interestValue;
    private ?PaymentMethod $paymentMethod;
    private ?string $transactionCode;
    private ?string $invoiceUrl;
    private ?string $notes;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, int $userId, TypePayment $typePayment, float $value, string $dueDate, ?string $paymentDate, FinanceStatus $status, int $year, string $nameCourse, string $createdAt, string $updatedAt, ?string $description = null, ?string $referenceMonth = null, float $discountValue = 0.0, float $fineValue = 0.0, float $interestValue = 0.0, ?PaymentMethod $paymentMethod = null, ?string $transactionCode = null, ?string $invoiceUrl = null, ?string $notes = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->typePayment = $typePayment;
        $this->value = $value;
        $this->dueDate = $dueDate;
        $this->paymentDate = $paymentDate;
        $this->status = $status;
        $this->year = $year;
        $this->nameCourse = $nameCourse;
        $this->description = $description;
        $this->referenceMonth = $referenceMonth;
        $this->discountValue = $discountValue;
        $this->fineValue = $fineValue;
        $this->interestValue = $interestValue;
        $this->paymentMethod = $paymentMethod;
        $this->transactionCode = $transactionCode;
        $this->invoiceUrl = $invoiceUrl;
        $this->notes = $notes;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTypePayment(): TypePayment
    {
        return $this->typePayment;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getPaymentDate(): ?string
    {
        return $this->paymentDate;
    }

    public function getStatus(): FinanceStatus
    {
        return $this->status;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getNameCourse(): string
    {
        return $this->nameCourse;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getReferenceMonth(): ?string
    {
        return $this->referenceMonth;
    }

    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }

    public function getFineValue(): float
    {
        return $this->fineValue;
    }

    public function getInterestValue(): float
    {
        return $this->interestValue;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getTransactionCode(): ?string
    {
        return $this->transactionCode;
    }

    public function getInvoiceUrl(): ?string
    {
        return $this->invoiceUrl;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }
}