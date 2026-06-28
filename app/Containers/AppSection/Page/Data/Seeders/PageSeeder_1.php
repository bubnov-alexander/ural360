<?php

namespace App\Containers\AppSection\Page\Data\Seeders;

use App\Containers\AppSection\Page\Enums\PageType;
use App\Containers\AppSection\Page\Models\Page;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class PageSeeder_1 extends ParentSeeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            Page::query()->updateOrCreate(
                [
                    'title' => $page['title'],
                ],
                $page,
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function pages(): array
    {
        return [
            [
                'title' => 'Главная страница',
                'type' => PageType::HOME,
                'content' => 'Сплав по Чусовой. Предоставляем услуги: сплавы для детей и взрослых, корпоративные сплавы, прокат катамаранов, SUP-бордов, транспортные услуги и автостоянка.',
                'is_published' => true,
            ],
            [
                'title' => 'О компании',
                'type' => PageType::CONTENT,
                'content' => 'Ural 360° организует сплавы по реке Чусовая. Более 5 лет команда предоставляет услуги проката катамаранов, трансфера и автостоянки.',
                'is_published' => true,
            ],
            [
                'title' => 'Контактная информация',
                'type' => PageType::CONTACTS,
                'content' => null,
                'is_published' => true,
            ],
            [
                'title' => 'Популярные маршруты',
                'type' => PageType::ROUTES,
                'content' => 'Популярные маршруты сплавов по Чусовой и услуги для путешествия: аренда катамаранов, трансфер, автостоянка и поддержка заявки.',
                'is_published' => true,
            ],
            [
                'title' => 'Политика в отношении обработки персональных данных',
                'type' => PageType::LEGAL,
                'content' => 'Политика обработки персональных данных. Полный текст нужно перенести из WordPress после согласования финального шаблона юридической страницы.',
                'is_published' => true,
            ],
        ];
    }
}
