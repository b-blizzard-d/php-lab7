<h2>Сохраненные записи</h2>
<p>
    Сортировка:
    <a href="?view=<?= e($view) ?>&sort=created_at">дата</a>
    <a href="?view=<?= e($view) ?>&sort=author">автор</a>
    <a href="?view=<?= e($view) ?>&sort=category">категория</a>
</p>

<table>
    <tr><th>Дата</th><th>Заголовок</th><th>Автор</th><th>Категория</th><th>Текст</th></tr>
    <?php foreach ($notes as $note): ?>
        <tr>
            <td><?= e((string) $note['created_at']) ?></td>
            <td><?= e((string) $note['title']) ?></td>
            <td><?= e((string) $note['author']) ?></td>
            <td><?= e(categoryLabel((string) $note['category'])) ?></td>
            <td><?= nl2br(e((string) $note['text'])) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

