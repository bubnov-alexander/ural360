<?php

namespace App\Containers\AppSection\Settings\Settings;

use Spatie\LaravelSettings\Settings;

final class ContactSettings extends Settings
{
    public string $site_name = 'Сплавы по рекам и аренда транспорта';

    public string $site_url = 'https://ural360.ru/';

    public string $home_url = 'https://ural360.ru/';

    public string $phone = '+7 (900) 047-04-04';

    public string $email = 'mail@mailbox.ru';

    public string $recipient_email = 'dev@grampus-studio.ru';

    public string $address = 'Свердловская область, д. Усть-Утка, ул. Тагильская, д. 37';

    public ?string $yandex_map_key = 'a3719748-7b9d-45b6-86fc-6e72441c9684';

    public ?string $yandex_map_script = '<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A407191a03179b3a0f4ea114510c1de9b5809b5bf739aac3533c8369e1c0b702b&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>';

    public ?string $telegram_group_id = null;

    public static function group(): string
    {
        return 'contact';
    }
}
