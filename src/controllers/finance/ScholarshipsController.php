<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/models/repositories/finance/ScholarshipRepository.php';

class ScholarshipsController
{
    private ScholarshipRepository $repository;

    public function __construct(?ScholarshipRepository $repository = null)
    {
        $this->repository = $repository ?? new ScholarshipRepository();
    }

    public function index(): array
    {
        return array_map(
            fn (Scholarships $scholarship): array => $this->toArray($scholarship),
            $this->repository->all()
        );
    }

    public function show(int|string $id): ?array
    {
        $scholarship = $this->repository->find($id);

        return $scholarship === null ? null : $this->toArray($scholarship);
    }

    public function store(array $formData): array
    {
        return $this->toArray($this->repository->create($formData));
    }

    public function update(int|string $id, array $formData): ?array
    {
        $scholarship = $this->repository->update($id, $formData);

        return $scholarship === null ? null : $this->toArray($scholarship);
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

    private function toArray(Scholarships $scholarship): array
    {
        return [
            'id' => $scholarship->getId(),
            'user_id' => $scholarship->getUserId(),
            'name' => $scholarship->getName(),
            'percentage' => $scholarship->getPercentage(),
            'start_date' => $scholarship->getStartDate(),
            'end_date' => $scholarship->getEndDate(),
            'status' => $scholarship->getStatus()->value,
            'document_url' => $scholarship->getDocumentUrl(),
            'created_at' => $scholarship->getCreatedAt(),
            'updated_at' => $scholarship->getUpdatedAt(),
        ];
    }
}