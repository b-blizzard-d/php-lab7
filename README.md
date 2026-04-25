# Лабораторная работа 7. Шаблонизация

**Выполнила:** Metelska Daniela, группа I2402

## Цель

Разделить логику приложения и HTML-представление.

## Что сделано

- логика формы находится в `index.php`;
- классы вынесены в папку `src`;
- PHP-шаблоны находятся в `templates/php`;
- Twig-шаблоны находятся в `templates/twig`;
- записи сохраняются в `data/notes.json`;
- есть режимы `view=php` и `view=twig`.

## Запуск

PHP-шаблоны:

```text
http://localhost/projects/usm/Metelska%20Daniela/lab7/index.php?view=php
```

Twig:

```text
http://localhost/projects/usm/Metelska%20Daniela/lab7/index.php?view=twig
```

Без XAMPP:

```bash
cd "Metelska Daniela/lab7"
php -S localhost:8000
```

Потом открыть:

```text
http://localhost:8000/index.php?view=php
http://localhost:8000/index.php?view=twig
```

Если папки `vendor` нет, зависимости восстанавливаются командой:

```bash
composer install
```

## Ответы на вопросы

1. PHP-шаблоны не требуют зависимостей. Twig имеет более чистый синтаксис и автоэкранирование.
2. Разделение логики и HTML делает проект понятнее.
3. Наследование Twig позволяет создать общий `layout.twig` и переиспользовать его.

## Вывод

В работе одна и та же форма показана через два варианта шаблонов.

