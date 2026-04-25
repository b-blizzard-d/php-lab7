<?php if ($saved): ?><p class="msg">Запись сохранена.</p><?php endif; ?>
<?php if ($errors): ?>
    <div class="msg">
        <?php foreach ($errors as $error): ?>
            <div><?= e($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post">
    <label>Заголовок</label>
    <input name="title" required minlength="3" value="<?= e($form['title']) ?>">

    <label>Автор</label>
    <input name="author" required minlength="2" value="<?= e($form['author']) ?>">

    <label>Категория</label>
    <select name="category">
        <?php foreach ($categories as $value => $label): ?>
            <option value="<?= e($value) ?>" <?= $form['category'] === $value ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Текст</label>
    <textarea name="text" required minlength="10"><?= e($form['text']) ?></textarea>

    <button type="submit">Сохранить</button>
</form>

