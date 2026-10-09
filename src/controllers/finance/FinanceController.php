<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/models/repositories/finance/FinanceRepository.php';

class FinanceController
{
    private FinanceRepository $repository;

    public function __construct(?FinanceRepository $repository = null)
    {
        $this->repository = $repository ?? new FinanceRepository();
    }

    public function index(): array
    {
        return array_map(
            fn (Finance $finance): array => $this->toArray($finance),
            $this->repository->all()
        );
    }

    public function show(int|string $id): ?array
    {
        $finance = $this->repository->find($id);

        return $finance === null ? null : $this->toArray($finance);
    }

    public function store(array $formData): array
    {
        return $this->toArray($this->repository->create($formData));
    }

    public function update(int|string $id, array $formData): ?array
    {
        $finance = $this->repository->update($id, $formData);

        return $finance === null ? null : $this->toArray($finance);
    }

    public function destroy(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function handle(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $id = $_GET['id'] ?? null;

        try {
            $response = match ($method) {
                'GET' => $id === null ? $this->index() : $this->show($id),
                'POST' => $this->store($this->requestData()),
                'PUT', 'PATCH' => $this->update($id, $this->requestData()),
                'DELETE' => $this->destroy($id),
                default => throw new RuntimeException('Método HTTP não suportado.'),
            };

            if ($response === null || $response === false) {
                http_response_code(404);
            }

            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (Throwable $exception) {
            http_response_code(400);
            echo json_encode(['erro' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function requestData(): array
    {
        $content = file_get_contents('php://input');
        $data = json_decode($content ?: '', true);

        return is_array($data) ? $data : $_POST;
    }

    private function toArray(Finance $finance): array
    {
        return [
            'id' => $finance->getId(),
            'user_id' => $finance->getUserId(),
            'type_payment' => $finance->getTypePayment()->value,
            'value' => $finance->getValue(),
            'description' => $finance->getDescription(),
            'reference_month' => $finance->getReferenceMonth(),
            'due_date' => $finance->getDueDate(),
            'payment_date' => $finance->getPaymentDate(),
            'discount_value' => $finance->getDiscountValue(),
            'fine_value' => $finance->getFineValue(),
            'interest_value' => $finance->getInterestValue(),
            'status' => $finance->getStatus()->value,
            'payment_method' => $finance->getPaymentMethod()?->value,
            'transaction_code' => $finance->getTransactionCode(),
            'invoice_url' => $finance->getInvoiceUrl(),
            'year' => $finance->getYear(),
            'name_course' => $finance->getNameCourse(),
            'notes' => $finance->getNotes(),
            'created_at' => $finance->getCreatedAt(),
            'updated_at' => $finance->getUpdatedAt(),
        ];
    }
}
