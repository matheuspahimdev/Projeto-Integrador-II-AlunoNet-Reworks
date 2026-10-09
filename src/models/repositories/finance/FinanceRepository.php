<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/EntityRepository.php';
require_once dirname(__DIR__, 2) . '/entities/finance/finance.php';
require_once dirname(__DIR__, 2) . '/enums/finance/financeStatus.php';
require_once dirname(__DIR__, 2) . '/enums/finance/payment.php';
require_once dirname(__DIR__, 2) . '/enums/finance/paymentMethod.php';

class FinanceRepository extends EntityRepository
{
    protected function table(): string
    {
        return 'finance';
    }

    protected function toRecord(array $data, string $createdAt, string $updatedAt): array
    {
        return [
            'id' => $data['id'] ?? null,
            'user_id' => (int) ($data['user_id'] ?? 0),
            'type_payment' => $this->typePayment($data['type_payment'] ?? TypePayment::PIX)->value,
            'value' => (float) ($data['value'] ?? 0),
            'description' => $data['description'] ?? null,
            'reference_month' => $data['reference_month'] ?? null,
            'due_date' => (string) ($data['due_date'] ?? ''),
            'payment_date' => $data['payment_date'] ?? null,
            'discount_value' => (float) ($data['discount_value'] ?? 0),
            'fine_value' => (float) ($data['fine_value'] ?? 0),
            'interest_value' => (float) ($data['interest_value'] ?? 0),
            'status' => $this->status($data['status'] ?? FinanceStatus::PENDING)->value,
            'payment_method' => $this->paymentMethod($data['payment_method'] ?? null)?->value,
            'transaction_code' => $data['transaction_code'] ?? null,
            'invoice_url' => $data['invoice_url'] ?? null,
            'year' => (int) ($data['year'] ?? 0),
            'name_course' => (string) ($data['name_course'] ?? ''),
            'notes' => $data['notes'] ?? null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    protected function toEntity(array $record): Finance
    {
        return new Finance(
            (int) ($record['id'] ?? 0),
            (int) ($record['user_id'] ?? 0),
            $this->typePayment($record['type_payment'] ?? TypePayment::PIX),
            (float) ($record['value'] ?? 0),
            (string) ($record['due_date'] ?? ''),
            $record['payment_date'] ?? null,
            $this->status($record['status'] ?? FinanceStatus::PENDING),
            (int) ($record['year'] ?? 0),
            (string) ($record['name_course'] ?? ''),
            (string) ($record['created_at'] ?? ''),
            (string) ($record['updated_at'] ?? ''),
            $record['description'] ?? null,
            $record['reference_month'] ?? null,
            (float) ($record['discount_value'] ?? 0),
            (float) ($record['fine_value'] ?? 0),
            (float) ($record['interest_value'] ?? 0),
            $this->paymentMethod($record['payment_method'] ?? null),
            $record['transaction_code'] ?? null,
            $record['invoice_url'] ?? null,
            $record['notes'] ?? null
        );
    }

    private function status(FinanceStatus|string $status): FinanceStatus
    {
        return $status instanceof FinanceStatus ? $status : FinanceStatus::from($status);
    }

    private function typePayment(TypePayment|string $typePayment): TypePayment
    {
        return $typePayment instanceof TypePayment ? $typePayment : TypePayment::from($typePayment);
    }

    private function paymentMethod(PaymentMethod|string|null $paymentMethod): ?PaymentMethod
    {
        if ($paymentMethod === null || $paymentMethod === '') {
            return null;
        }

        return $paymentMethod instanceof PaymentMethod ? $paymentMethod : PaymentMethod::from($paymentMethod);
    }
}
