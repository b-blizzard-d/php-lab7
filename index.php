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

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $form = noteDataFromArray(readPutPayload());
    $errors = $validator->validate($form);

    header('Content-Type: application/json; charset=utf-8');

    if ($errors === []) {
        try {
            $note = $repo->add($form);
            http_response_code(200);
            echo json_encode(['success' => true, 'note' => $note], JSON_UNESCAPED_UNICODE);
        } catch (RuntimeException $exception) {
            http_response_code(500);
            echo json_encode(['success' => false, 'errors' => [$exception->getMessage()]], JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(422);
        echo json_encode(['success' => false, 'errors' => $errors], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST, PUT');
    exit('Method not allowed.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = noteDataFromArray($_POST);
    $errors = $validator->validate($form);

    if ($errors === []) {
        try {
            $repo->add($form);
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }
    }

    if ($errors === []) {
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

/**
 * @param array<string, mixed> $source
 * @return array<string, string>
 */
function noteDataFromArray(array $source): array
{
    return [
        'title' => trim((string) ($source['title'] ?? '')),
        'author' => trim((string) ($source['author'] ?? '')),
        'category' => trim((string) ($source['category'] ?? 'study')),
        'text' => trim((string) ($source['text'] ?? '')),
    ];
}

/**
 * @return array<string, mixed>
 */
function readPutPayload(): array
{
    $rawBody = file_get_contents('php://input');
    if ($rawBody === false || trim($rawBody) === '') {
        return [];
    }

    $decoded = json_decode($rawBody, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        return $decoded;
    }

    parse_str($rawBody, $parsed);
    return $parsed;
}
