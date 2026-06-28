# Ural360

Backend проекта Ural360 на Laravel 12, Apiato 13 и Filament.

Проект создается как новая платформа для переноса текущей инфраструктуры Ural360: legacy WordPress-сайта, Telegram-бота `yst-travel`, услуг, маршрутов, заявок, медиа и административных процессов.

## Что это за проект

Ural360 связан с туристическими услугами по Уралу:

- сплавы и маршруты по Чусовой;
- прокат катамаранов;
- прокат SUP-досок;
- трансфер;
- автостоянка;
- прием и сопровождение заявок через сайт и Telegram-бота.

Текущая цель backend-проекта - постепенно заменить WordPress-часть на управляемую Laravel/Apiato-архитектуру, не ломая уже работающий Python Telegram-бот.

## Документация

Подробная документация по инфраструктуре проекта находится в [docs/ural360](docs/ural360/README.md).

Основные разделы:

- [архитектура](docs/ural360/architecture.md);
- [основные пакеты](docs/ural360/packages.md);
- [план миграции](docs/ural360/migration-plan.md);
- [границы данных и доступ Telegram-бота](docs/ural360/data-boundaries.md);
- [Telegram-бот `yst-travel`](docs/ural360/telegram-bot.md);
- [WordPress legacy](docs/ural360/wordpress-legacy.md).

## Текущий стек

| Технология | Назначение |
| --- | --- |
| Laravel 12 | Основа backend-приложения |
| Apiato 13 | Архитектура через Containers, Actions, Tasks, Requests и Transformers |
| Filament | Административная панель |
| Spatie Media Library | Хранение и привязка изображений и файлов |
| Filament Spatie Media Library Plugin | Интеграция медиа-полей в Filament |
| Laravel Passport | API-аутентификация |
| Spatie Permission | Роли и права доступа |
| Telescope | Локальная диагностика приложения |

## Что уже настроено

- установлен Filament;
- добавлен `AdminPanelProvider`;
- доступ в Filament ограничен super admin пользователем;
- добавлены переменные для первого администратора в `.env.example`;
- seeder администратора берет данные из конфигурации;
- установлен Spatie Media Library и Filament-плагин для него;
- опубликованы `config/media-library.php` и миграция таблицы `media`;
- миграции намеренно не запускались.

## Локальный запуск

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Дальше нужно настроить подключение к базе в `.env`.

Миграции запускать только осознанно, когда база подготовлена:

```bash
php artisan migrate
```

Создание стартового администратора:

```bash
php artisan db:seed
```

Локальный сервер:

```bash
php artisan serve
```

Админка Filament:

```text
/admin
```

## Переменные администратора

В `.env.example` есть настройки стартового пользователя админки:

```env
ADMIN_NAME="Super Admin"
ADMIN_EMAIL=admin@admin.com
ADMIN_PASSWORD=admin
```

В реальном окружении пароль надо заменить до запуска seeders.

## Архитектурный подход

Backend должен стать владельцем бизнес-логики и схемы базы данных. Telegram-бот остается отдельным Python-сервисом, но на первом этапе может работать с общей БД через отдельного пользователя с ограниченными правами.

Целевое состояние:

- Apiato владеет миграциями, моделями, правилами и API;
- Filament управляет услугами, маршрутами, заявками и медиа;
- Telegram-бот сначала получает ограниченный DB-доступ;
- после стабилизации бот переходит на Apiato API;
- WordPress постепенно выводится из эксплуатации.

## Правила безопасности

- Не коммитить `.env`.
- Не коммитить токены Telegram, SSH-ключи, дампы баз и приватные конфиги.
- Не коммитить `vendor`, `node_modules`, локальные SQLite-базы, cache и логи.
- Не давать Telegram-боту полный доступ к базе.
- Миграции и изменение схемы выполнять только со стороны Laravel/Apiato.

## GitHub

Основной репозиторий проекта:

```text
https://github.com/bubnov-alexander/ural360
```

Обычный рабочий цикл:

```bash
git add .
git commit -m "..."
git push
```

