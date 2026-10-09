<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/core/JsonDatabase.php';

abstract class EntityRepository
{
    protected JsonDatabase $database;

    public function __construct(?JsonDatabase $database = null)
    {
        $this->database = $database ?? new JsonDatabase();
    }

    abstract protected function table(): string;

    abstract protected function toEntity(array $record): object;

    abstract protected function toRecord(array $data, string $createdAt, string $updatedAt): array;

    public function all(): array
    {
        return array_map(
            fn (array $record): object => $this->toEntity($record),
            $this->database->all($this->table())
        );
    }

    public function find(int|string $id): ?object
    {
        $record = $this->database->find($this->table(), $id);

        return $record === null ? null : $this->toEntity($record);
    }

    public function create(array $data): object
    {
        $now = date('c');
        $record = $this->database->insert($this->table(), $this->toRecord($data, $now, $now));

        return $this->toEntity($record);
    }

    public function update(int|string $id, array $data): ?object
    {
        $current = $this->database->find($this->table(), $id);

        if ($current === null) {
            return null;
        }

        $record = $this->database->update(
            $this->table(),
            $id,
            $this->toRecord(array_merge($current, $data), (string) $current['created_at'], date('c'))
        );

        return $record === null ? null : $this->toEntity($record);
    }

    public function delete(int|string $id): bool
    {
        return $this->database->delete($this->table(), $id);
    }

    protected function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }

    protected function nullableFloat(mixed $value): ?float
    {
        return $value === null || $value === '' ? null : (float) $value;
    }

    protected function boolean(mixed $value, bool $default = false): bool
    {
        return filter_var($value ?? $default, FILTER_VALIDATE_BOOLEAN);
    }
}
