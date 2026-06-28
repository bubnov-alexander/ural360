# Основные пакеты

## Backend

| Пакет | Роль в проекте |
| --- | --- |
| `apiato/core` | Каркас приложения: Containers, Ship, Actions, Tasks, DTO, Requests, Transformers |
| `laravel/framework` | Базовая платформа приложения, HTTP-слой, Eloquent, очереди, конфигурация |
| `laravel/passport` | OAuth2 и API-аутентификация для будущих клиентов и интеграций |
| `spatie/laravel-permission` | Роли и права доступа, включая администраторов |
| `wikimedia/composer-merge-plugin` | Подключение `composer.json` из Apiato Ship и Containers |

## Админка и медиа

| Пакет | Роль в проекте |
| --- | --- |
| `filament/filament` | Административная панель проекта |
| `filament/spatie-laravel-media-library-plugin` | Поля и компоненты Filament для работы с Spatie Media Library |
| `spatie/laravel-medialibrary` | Привязка изображений, документов и галерей к моделям |

## Разработка и качество

| Пакет | Роль в проекте |
| --- | --- |
| `laravel/telescope` | Локальная диагностика запросов, jobs, exceptions, моделей и событий |
| `phpunit/phpunit` | Основной тестовый фреймворк |
| `brianium/paratest` | Параллельный запуск тестов |
| `larastan/larastan` | Статический анализ Laravel-кода через PHPStan |
| `phpstan/phpstan` | Статический анализ PHP |
| `vimeo/psalm` | Дополнительный статический анализ типов |
| `friendsofphp/php-cs-fixer` | Форматирование и единый стиль кода |
| `roave/security-advisories` | Блокировка установки зависимостей с известными уязвимостями |

## Почему выбран Apiato

Apiato подходит для проекта, потому что миграция с WordPress и Telegram-бота требует не просто набора контроллеров, а понятных границ между бизнес-сущностями. Containers помогают разделить услуги, заявки, пользователей, медиа и интеграции, не превращая backend в монолит без структуры.

## Почему выбран Filament

Filament позволяет быстро получить рабочую админку без отдельной frontend-команды. Для Ural360 это особенно полезно: администраторам нужны формы для услуг, маршрутов, заявок, галерей и медиа, а не кастомная CMS с нуля.

