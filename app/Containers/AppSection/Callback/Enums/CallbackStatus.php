<?php

namespace App\Containers\AppSection\Callback\Enums;

enum CallbackStatus: int
{
    case NEW = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;

    /**
     * @return array<int, string>
     */
    public static function options(): array
    {
        return [
            self::NEW->value => 'Новая',
            self::IN_PROGRESS->value => 'В обработке',
            self::COMPLETED->value => 'Обработана',
        ];
    }

    public function label(): string
    {
        return self::options()[$this->value];
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
        };
    }
}
