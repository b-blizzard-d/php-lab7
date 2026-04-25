<?php

declare(strict_types=1);

final class SecretNoteRepository
{
    public function __construct(private string $file)
    {
        if (!is_dir(dirname($this->file))) {
            mkdir(dirname($this->file), 0777, true);
        }

        if (!file_exists($this->file)) {
            file_put_contents($this->file, '[]');
        }
    }

    public function add(array $data): void
    {
        $items = $this->all();
        $items[] = [
            'title' => $data['title'],
            'author' => $data['author'],
            'category' => $data['category'],
            'text' => $data['text'],
            'created_at' => date('Y-m-d H:i'),
        ];

        file_put_contents($this->file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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

