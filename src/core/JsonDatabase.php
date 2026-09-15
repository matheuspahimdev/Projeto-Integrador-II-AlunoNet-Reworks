<?php

declare(strict_types=1);

class JsonDatabase
{
    private string $filePath;

    public function __construct(?string $filePath = null)
    {
        $this->filePath = $filePath ?? dirname(__DIR__) . '/data/database.json';
    }

    public function all(string $table): array
    {
        $database = $this->read();

        return $database['tables'][$table]['data'] ?? [];
    }

    public function find(string $table, int|string $id): ?array
    {
        foreach ($this->all($table) as $record) {
            if ((string) ($record['id'] ?? '') === (string) $id) {
                return $record;
            }
        }

        return null;
    }

    public function insert(string $table, array $record): array
    {
        $database = $this->read();
        $records = $database['tables'][$table]['data'] ?? [];

        if (!isset($record['id'])) {
            $ids = array_map(
                static fn (array $item): int => (int) ($item['id'] ?? 0),
                $records
            );
            $record['id'] = empty($ids) ? 1 : max($ids) + 1;
        }

        $database['tables'][$table]['data'][] = $record;
        $this->write($database);

        return $record;
    }

    public function update(string $table, int|string $id, array $record): ?array
    {
        $database = $this->read();

        foreach ($database['tables'][$table]['data'] as $index => $current) {
            if ((string) ($current['id'] ?? '') !== (string) $id) {
                continue;
            }

            $record['id'] = $current['id'];
            $database['tables'][$table]['data'][$index] = $record;
            $this->write($database);

            return $record;
        }

        return null;
    }

    public function delete(string $table, int|string $id): bool
    {
        $database = $this->read();

        foreach ($database['tables'][$table]['data'] as $index => $record) {
            if ((string) ($record['id'] ?? '') !== (string) $id) {
                continue;
            }

            unset($database['tables'][$table]['data'][$index]);
            $database['tables'][$table]['data'] = array_values($database['tables'][$table]['data']);
            $this->write($database);

            return true;
        }

        return false;
    }

    private function read(): array
    {
        if (!is_file($this->filePath)) {
            throw new RuntimeException("Arquivo do banco de dados não encontrado: {$this->filePath}");
        }

        $content = file_get_contents($this->filePath);
        $database = json_decode($content ?: '', true);

        if (!is_array($database) || !isset($database[0]['tables']) || !is_array($database[0]['tables'])) {
            throw new RuntimeException('Formato inválido do arquivo database.json.');
        }

        return $database[0];
    }

    private function write(array $database): void
    {
        $json = json_encode([$database], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        if (file_put_contents($this->filePath, $json . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException("Não foi possível escrever no arquivo do banco de dados: {$this->filePath}");
        }
    }
}