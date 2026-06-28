<?php

namespace App\Containers\AppSection\Page\Enums;

enum PageType: string
{
    case HOME = 'home';
    case CONTENT = 'content';
    case CONTACTS = 'contacts';
    case ROUTES = 'routes';
    case LEGAL = 'legal';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::HOME->value => 'Главная',
            self::CONTENT->value => 'Контентная',
            self::CONTACTS->value => 'Контакты',
            self::ROUTES->value => 'Маршруты',
            self::LEGAL->value => 'Юридическая',
        ];
    }

    public function label(): string
    {
        return self::options()[$this->value];
    }
}
