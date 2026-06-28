<?php

namespace App\Containers\AppSection\Service\Data\Seeders;

use App\Containers\AppSection\Service\Models\Service;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class ServiceSeeder_1 extends ParentSeeder
{
    public function run(): void
    {
        foreach ($this->services() as $serviceData) {
            $prices = $serviceData['prices'];
            unset($serviceData['prices']);

            $service = Service::query()->updateOrCreate(
                [
                    'title' => $serviceData['title'],
                ],
                $serviceData,
            );

            foreach ($prices as $price) {
                $service->prices()->updateOrCreate(
                    [
                        'label' => $price['label'],
                    ],
                    [
                        'price' => $price['price'],
                    ],
                );
            }
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
                'prices' => [
                    [
                        'label' => 'Пн-Чт, 1 день',
                        'price' => '2 500 руб.',
                    ],
                    [
                        'label' => 'Пт-Вс (праздничные дни), 1 день',
                        'price' => '3 500 руб.',
                    ],
                ],
            ],
            [
                'title' => 'Трансфер',
                'content' => '<h1>Трансфер</h1><p>Мы предлагаем удобный и безопасный транспорт для тех, кто хочет насладиться водными приключениями без лишних хлопот. Трансфер позволит легко добраться до точки старта и вернуться обратно.</p>',
                'is_published' => true,
                'prices' => [
                    [
                        'label' => 'Стоимость',
                        'price' => 'Зависит от маршрута, типа транспорта и количества пассажиров',
                    ],
                ],
            ],
            [
                'title' => 'Автостоянка',
                'content' => '<h1>Автостоянка</h1><p>Оставьте автомобиль на время сплава и спокойно наслаждайтесь отдыхом. Автостоянка помогает не переживать за состояние машины во время путешествия.</p>',
                'is_published' => true,
                'prices' => [
                    [
                        'label' => '1 день',
                        'price' => '100 руб.',
                    ],
                ],
            ],
            [
                'title' => 'Прокат SUP-бордов',
                'content' => '<h1>Прокат SUP-бордов</h1><p>Исследуйте живописные воды реки Чусовой на современных надувных SUP-досках. Формат подходит как новичкам, так и опытным райдерам.</p>',
                'is_published' => true,
                'prices' => [
                    [
                        'label' => 'Пн-Чт, 1 день',
                        'price' => '800 руб.',
                    ],
                    [
                        'label' => 'Пт-Вс (праздничные дни), 1 день',
                        'price' => '1 000 руб.',
                    ],
                ],
            ],
        ];
    }
}
