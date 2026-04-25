<?php

declare(strict_types=1);

final class SecretNoteRepository
{
    public function __construct(private string $file)
    {
        $directory = dirname($this->file);

        if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
            throw new RuntimeException('Storage directory could not be created.');
        }

        if (!file_exists($this->file) && file_put_contents($this->file, "[]\n", LOCK_EX) === false) {
            throw new RuntimeException('Storage file could not be created.');
        }
    }

    public function add(array $data): array
    {
        $items = $this->all();
        $note = [
            'title' => $data['title'],
            'author' => $data['author'],
            'category' => $data['category'],
            'text' => $data['text'],
            'created_at' => date('Y-m-d H:i'),
        ];
        $items[] = $note;

        $json = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false || file_put_contents($this->file, $json . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException('Storage file could not be written.');
        }

        return $note;
    }

    public function all(string $sort = 'created_at'): array
    {
        $json = file_get_contents($this->file);
        $items = json_decode($json === false ? '[]' : $json, true);
        $items = is_array($items) ? $items : [];
        $allowed = ['created_at', 'author', 'category'];
        $sort = in_array($sort, $allowed, true) ? $sort : 'created_at';

        usort($items, fn ($a, $b) => strcmp((string) ($a[$sort] ?? ''), (string) ($b[$sort] ?? '')));

        return $items;
    }
}
