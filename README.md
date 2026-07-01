# Ural360

Backend проекта Ural360 на Laravel 12, Apiato 13 и Filament.

Проект создается как новая платформа для переноса текущей инфраструктуры Ural360: legacy WordPress-сайта, Telegram-бота `yst-travel`, услуг, маршрутов, заявок, медиа, SEO-данных и административных процессов.

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

## Связанные репозитории

| Репозиторий | Назначение |
| --- | --- |
| <https://github.com/bubnov-alexander/ural360> | Основной Laravel/Apiato backend проекта |
| <https://github.com/bubnov-alexander/yst-travel> | Оригинальный Python Telegram-бот `yst-travel`, о котором идет речь в документации |

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

- установлен и настроен Filament;
- добавлен `AdminPanelProvider`;
- доступ в Filament ограничен super admin пользователем;
- стандартный информационный виджет Filament убран с инфопанели;
- добавлены переменные для первого администратора в `.env.example`;
- seeder администратора берет данные из конфигурации;
- установлен Spatie Media Library и Filament-плагин для него;
- опубликованы `config/media-library.php` и миграция таблицы `media`;
- добавлен Filament-раздел для управления медиафайлами: удаление изображений и ручное редактирование `alt`;
- добавлена автогенерация `alt` для изображений;
- `alt` из Spatie Media выводится во фронтенд-шаблонах;
- добавлен прием заявок с сайта через `/callback/`;
- заявки отправляются на email из настроек контактов;
- заявки доступны в Filament только для просмотра, но статус можно менять;
- добавлены статусы заявок: `Новая`, `В обработке`, `Обработана`;
- добавлен отдельный MySQL connection `yst_travel` для данных Telegram-бота;
- добавлены таблицы, модели и read-only Filament-разделы для данных Telegram-бота;
- раздел Telegram-бота в Filament называется `Телеграм бот` и находится в нижней части меню.

## Локальный запуск

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Дальше нужно настроить подключение к базе в `.env`.

Миграции основной базы:

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

## Заявки с сайта

Форма заявки отправляет `POST`-запрос на:

```text
/callback/
```

Поля заявки:

| Поле | Обязательное | Назначение |
| --- | --- | --- |
| `name` | нет | Имя клиента |
| `phone` | да | Телефон клиента |
| `comment` | нет | Комментарий |
| `page_url` | нет | Страница, с которой отправлена заявка |

После создания заявки письмо отправляется на email, указанный в настройках контактов Filament.

В админке заявки находятся в разделе `Заявки -> Заявки с сайта`. Создавать, редактировать и удалять заявки вручную нельзя. Можно просматривать заявку и менять статус.

Статусы хранятся числом:

| Значение | Статус |
| --- | --- |
| `1` | Новая |
| `2` | В обработке |
| `3` | Обработана |

## Медиа и alt

Изображения управляются через раздел Filament `Медиа`. Там можно:

- просматривать загруженные изображения;
- удалять ненужные файлы;
- вручную менять `alt`;
- запускать генерацию `alt` командой.

Команда генерации `alt`:

```bash
php artisan media:generate-alts
```

Принудительно перезаписать уже заполненные `alt`:

```bash
php artisan media:generate-alts --force
```

Базовая логика генерации учитывает сущность, к которой прикреплено изображение, и имя файла. Для изображений с ручным `alt` команда без `--force` значение не перезаписывает.

## Telegram-бот YST Travel

Данные Telegram-бота вынесены в отдельное подключение Laravel:

```text
yst_travel
```

Оно указывает на отдельную MySQL-базу, которую в дальнейшем сможет использовать Python-бот.

Переменные окружения:

```env
YST_TRAVEL_DB_HOST=127.0.0.1
YST_TRAVEL_DB_PORT=3306
YST_TRAVEL_DB_DATABASE=yst_travel_db
YST_TRAVEL_DB_USERNAME=dev_bs_user
YST_TRAVEL_DB_PASSWORD=dev_bs_password
```

Миграции таблиц Telegram-бота:

```bash
php artisan migrate --database=yst_travel --path=app/Containers/AppSection/YstTravel/Data/Migrations --force
```

Экспорт данных из старой SQLite-базы бота в JSON:

```bash
python3 scripts/export-yst-travel.py /mnt/c/Users/kinok/OneDrive/Desktop/10451.grampus-server.ru/yst-travel/app/storage/database.db storage/app/yst-travel.json
```

Импорт JSON в MySQL:

```bash
php artisan yst-travel:import-json storage/app/yst-travel.json
```

Импорт с удалением строк, которых уже нет в SQLite-экспорте:

```bash
php artisan yst-travel:import-json storage/app/yst-travel.json --prune
```

В Filament данные Telegram-бота находятся в группе `Телеграм бот`. Разделы сделаны read-only, чтобы админка не ломала данные, с которыми будет работать Python-бот.

## Переменные администратора

В `.env.example` есть настройки стартового пользователя админки:

```env
ADMIN_NAME="Super Admin"
ADMIN_EMAIL=admin@admin.com
ADMIN_PASSWORD=admin
```

В реальном окружении пароль надо заменить до запуска seeders.

## Архитектурный подход

Backend должен стать владельцем бизнес-логики и схемы основной базы данных. Telegram-бот остается отдельным Python-сервисом, а его данные временно хранятся в отдельной MySQL-базе `yst_travel_db`, доступной из Laravel через connection `yst_travel`.

Целевое состояние:

- Apiato владеет миграциями, моделями, правилами и API;
- Filament управляет услугами, маршрутами, заявками, настройками, SEO и медиа;
- Telegram-бот сначала получает ограниченный DB-доступ к своей отдельной базе;
- после стабилизации бот переходит на Apiato API;
- WordPress постепенно выводится из эксплуатации.

## Правила безопасности

- Не коммитить `.env`.
- Не коммитить токены Telegram, SSH-ключи, дампы баз и приватные конфиги.
- Не коммитить `vendor`, `node_modules`, локальные SQLite-базы, cache и логи.
- Не давать Telegram-боту полный доступ к основной базе проекта.
- Миграции и изменение схемы выполнять только со стороны Laravel/Apiato.
- Для данных Telegram-бота сохранять совместимость с Python-ботом: не переименовывать таблицы и колонки без отдельного этапа миграции бота.

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
