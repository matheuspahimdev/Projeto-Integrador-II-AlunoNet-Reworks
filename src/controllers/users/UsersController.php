<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/models/repositories/user/UserRepository.php';

class UsersController
{
    private UserRepository $repository;

    public function __construct(?UserRepository $repository = null)
    {
        $this->repository = $repository ?? new UserRepository();
    }

    public function index(): array
    {
        return array_map(
            fn (Users $user): array => $this->toArray($user),
            $this->repository->all()
        );
    }

    public function show(int|string $id): ?array
    {
        $user = $this->repository->find($id);

        return $user === null ? null : $this->toArray($user);
    }

    public function store(array $formData): array
    {
        return $this->toArray($this->repository->create($formData));
    }

    public function update(int|string $id, array $formData): ?array
    {
        $user = $this->repository->update($id, $formData);

        return $user === null ? null : $this->toArray($user);
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
                'POST' => $this->store($_POST),
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

    private function toArray(Users $user): array
    {
        return [
            'id' => $user->getId(),
            'course_id' => $user->getCourseId(),
            'class_id' => $user->getClassId(),
            'registration_number' => $user->getRegistrationNumber(),
            'name' => $user->getName(),
            'social_name' => $user->getSocialName(),
            'document' => $user->getDocument(),
            'birth_date' => $user->getBirthDate(),
            'phone' => $user->getPhone(),
            'address' => $user->getAddress(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()->value,
            'is_active' => $user->isActive(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ];
    }
}