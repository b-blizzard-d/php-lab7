<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function categoryLabel(string $category): string
{
    return [
        'study' => 'Учеба',
        'life' => 'Жизнь',
        'work' => 'Работа',
    ][$category] ?? $category;
}

