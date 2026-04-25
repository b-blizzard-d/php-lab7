<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Лабораторная работа 7</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        label { display: block; margin-top: 10px; }
        input, select, textarea, button { width: 100%; max-width: 640px; padding: 8px; box-sizing: border-box; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; vertical-align: top; }
        .msg { padding: 8px; border: 1px solid #999; max-width: 640px; }
    </style>
</head>
<body>
    <h1>Лабораторная работа 7. Шаблонизация</h1>
    <p><strong>Выполнила:</strong> Metelska Daniela, группа I2402</p>
    <p>Режим:
        <a href="?view=php">PHP-шаблоны</a>
        <a href="?view=twig">Twig</a>
    </p>

    <?php require __DIR__ . '/form.php'; ?>
    <?php require __DIR__ . '/list.php'; ?>
</body>
</html>

