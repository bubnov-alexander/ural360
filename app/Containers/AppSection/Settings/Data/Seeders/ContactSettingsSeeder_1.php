<?php

namespace App\Containers\AppSection\Settings\Data\Seeders;

use App\Containers\AppSection\Settings\Tasks\UpsertContactSettingsTask;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

final class ContactSettingsSeeder_1 extends ParentSeeder
{
    public function run(UpsertContactSettingsTask $task): void
    {
        $task->run([
            'site_name' => 'Сплавы по рекам и аренда транспорта',
            'site_url' => 'https://ural360.ru/',
            'home_url' => 'https://ural360.ru/',
            'phone' => '+7 (900) 047-04-04',
            'email' => 'mail@mailbox.ru',
            'recipient_email' => 'dev@grampus-studio.ru',
            'address' => 'Свердловская область, д. Усть-Утка, ул. Тагильская, д. 37',
            'yandex_map_key' => 'a3719748-7b9d-45b6-86fc-6e72441c9684',
            'yandex_map_script' => '<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A407191a03179b3a0f4ea114510c1de9b5809b5bf739aac3533c8369e1c0b702b&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>',
            'telegram_group_id' => null,
            'max_url' => 'https://max.ru/u/f9LHodD0cOJheshEzUKLkOuxWCrUV5uyv0V_fylraPrMfF8fBjBmsDvTVoo',
            'whatsapp_url' => 'https://wa.me/+79000470404',
            'telegram_url' => 'https://t.me/Ural360',
            'vk_url' => 'https://vk.com/urall360',
        ]);
    }
}
