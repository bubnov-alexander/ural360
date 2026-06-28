<?php

namespace App\Containers\AppSection\Service\Data\Seeders;

use App\Containers\AppSection\Service\Models\Service;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class ServiceSeeder_1 extends ParentSeeder
{
    public function run(): void
    {
        foreach ($this->services() as $service) {
            Service::query()->updateOrCreate(
                [
                    'title' => $service['title'],
                ],
                $service,
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function services(): array
    {
        return [
            [
                'title' => 'Прокат катамаранов',
                'content' => '<h1>Прокат катамаранов</h1><p>Погрузитесь в мир сплавов с нашим прокатом катамаранов в живописных деревнях Сулём, Усть-Утка, Харёнки и посёлке Ёква. Мы предлагаем возможность насладиться природой без хлопот с подготовкой оборудования.</p>',
                'is_published' => true,
            ],
            [
                'title' => 'Трансфер',
                'content' => '<h1>Трансфер</h1><p>Мы предлагаем удобный и безопасный транспорт для тех, кто хочет насладиться водными приключениями без лишних хлопот. Трансфер позволит легко добраться до точки старта и вернуться обратно.</p>',
                'is_published' => true,
            ],
            [
                'title' => 'Автостоянка',
                'content' => '<h1>Автостоянка</h1><p>Оставьте автомобиль на время сплава и спокойно наслаждайтесь отдыхом. Автостоянка помогает не переживать за состояние машины во время путешествия.</p>',
                'is_published' => true,
            ],
            [
                'title' => 'Прокат SUP-бордов',
                'content' => '<h1>Прокат SUP-бордов</h1><p>Исследуйте живописные воды реки Чусовой на современных надувных SUP-досках. Формат подходит как новичкам, так и опытным райдерам.</p>',
                'is_published' => true,
            ],
        ];
    }
}
