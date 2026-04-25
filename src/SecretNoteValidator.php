<?php

declare(strict_types=1);

require_once __DIR__ . '/ValidatorInterface.php';

final class SecretNoteValidator implements ValidatorInterface
{
    private const CATEGORIES = ['study', 'life', 'work'];

    public function validate(array $data): array
    {
        $errors = [];

        if (mb_strlen($data['title'] ?? '') < 3) {
            $errors[] = 'Заголовок должен быть не короче 3 символов.';
        }

        if (mb_strlen($data['author'] ?? '') < 2) {
            $errors[] = 'Автор должен быть указан.';
        }

        if (!in_array($data['category'] ?? '', self::CATEGORIES, true)) {
            $errors[] = 'Категория выбрана неверно.';
        }

        if (mb_strlen($data['text'] ?? '') < 10) {
            $errors[] = 'Текст должен быть не короче 10 символов.';
        }

        return $errors;
    }
}

