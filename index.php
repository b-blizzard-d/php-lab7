<?php

declare(strict_types=1);

require_once __DIR__ . '/src/SecretNoteRepository.php';
require_once __DIR__ . '/src/SecretNoteValidator.php';
require_once __DIR__ . '/src/helpers.php';

$repo = new SecretNoteRepository(__DIR__ . '/data/notes.json');
$validator = new SecretNoteValidator();
$errors = [];
$saved = false;
$form = [
    'title' => '',
    'author' => '',
    'category' => 'study',
    'text' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = [
        'title' => trim((string) ($_POST['title'] ?? '')),
        'author' => trim((string) ($_POST['author'] ?? '')),
        'category' => trim((string) ($_POST['category'] ?? 'study')),
        'text' => trim((string) ($_POST['text'] ?? '')),
    ];

    $errors = $validator->validate($form);

    if ($errors === []) {
        $repo->add($form);
        $saved = true;
        $form = ['title' => '', 'author' => '', 'category' => 'study', 'text' => ''];
    }
}

$view = (string) ($_GET['view'] ?? 'php');
$sort = (string) ($_GET['sort'] ?? 'created_at');
$notes = $repo->all($sort);
$categories = ['study' => 'Учеба', 'life' => 'Жизнь', 'work' => 'Работа'];

$data = compact('errors', 'saved', 'form', 'notes', 'categories', 'view', 'sort');

if ($view === 'twig' && file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';

    $loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/templates/twig');
    $twig = new Twig\Environment($loader, ['autoescape' => 'html']);
    $twig->addFunction(new Twig\TwigFunction('category_label', 'categoryLabel'));

    echo $twig->render('index.twig', $data);
    exit;
}

extract($data, EXTR_SKIP);
require __DIR__ . '/templates/php/layout.php';

